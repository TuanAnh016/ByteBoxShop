#!/usr/bin/env python3
"""
ByteBox Data Analytics Script
Analyzes purchasing patterns by age group and gender from the database.
Outputs results as JSON to stdout.
Supports both MySQL and PostgreSQL.
"""

import sys
import json
import os
from datetime import date

# Import database drivers at top level so they are always in scope
try:
    import psycopg2
    import psycopg2.extras
except ImportError:
    psycopg2 = None

try:
    import mysql.connector
except ImportError:
    mysql = None

# Force UTF-8 for stdout to handle Vietnamese characters on Windows
if sys.stdout.encoding != 'UTF-8':
    import io
    sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

# --- DB Config from environment ---
# Render provides DATABASE_URL as a full connection string.
# Parse it first; fall back to individual DB_* vars for local dev.
DATABASE_URL = os.environ.get('DATABASE_URL', '')
DB_CONNECTION = os.environ.get('DB_CONNECTION', 'pgsql')

if DATABASE_URL:
    from urllib.parse import urlparse
    _u = urlparse(DATABASE_URL)
    DB_HOST = _u.hostname or '127.0.0.1'
    DB_PORT = _u.port or 5432
    DB_NAME = (_u.path or '/bytebox').lstrip('/')
    DB_USER = _u.username or 'root'
    DB_PASS = _u.password or ''
    # Render uses postgresql:// scheme → always pgsql
    DB_CONNECTION = 'pgsql'
else:
    DB_HOST = os.environ.get('DB_HOST', '127.0.0.1')
    DB_PORT = int(os.environ.get('DB_PORT', 5432 if DB_CONNECTION == 'pgsql' else 3306))
    DB_NAME = os.environ.get('DB_DATABASE', 'bytebox')
    DB_USER = os.environ.get('DB_USERNAME', 'root')
    DB_PASS = os.environ.get('DB_PASSWORD', '')

# Try to import the right database driver
conn = None
cursor = None

def connect_db():
    global conn, cursor
    if DB_CONNECTION == 'mysql':
        if mysql is None:
            print(json.dumps({"error": "mysql-connector-python not installed. Run: pip install mysql-connector-python"}))
            sys.exit(1)
        conn = mysql.connector.connect(
            host=DB_HOST, port=DB_PORT,
            database=DB_NAME, user=DB_USER, password=DB_PASS,
            charset='utf8mb4'
        )
        cursor = conn.cursor(dictionary=True)
    else:
        # PostgreSQL — prefer DATABASE_URL string if available (Render)
        if psycopg2 is None:
            print(json.dumps({"error": "psycopg2 not installed. Run: pip install psycopg2-binary"}))
            sys.exit(1)
        if DATABASE_URL:
            conn = psycopg2.connect(DATABASE_URL, sslmode='require')
        else:
            conn = psycopg2.connect(
                host=DB_HOST, port=DB_PORT,
                dbname=DB_NAME, user=DB_USER, password=DB_PASS
            )
        cursor = conn.cursor(cursor_factory=psycopg2.extras.RealDictCursor)


def get_age_group(age):
    if age is None:
        return "Không rõ"
    if age < 18:
        return "Dưới 18"
    elif age <= 24:
        return "18–24"
    elif age <= 34:
        return "25–34"
    elif age <= 44:
        return "35–44"
    elif age <= 54:
        return "45–54"
    else:
        return "55+"


def analyze():
    connect_db()

    # -----------------------------------------------
    # 1. Gender distribution of buyers
    # -----------------------------------------------
    cursor.execute("""
        SELECT 
            COALESCE(u.gender, 'unknown') as gender,
            COUNT(DISTINCT o.id) as total_orders,
            COALESCE(SUM(o.total), 0) as total_revenue
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.status != 'cancelled'
        GROUP BY u.gender
    """)
    gender_stats = cursor.fetchall()

    gender_labels_map = {'male': 'Nam', 'female': 'Nữ', 'other': 'Khác', 'unknown': 'Không rõ'}
    gender_data = {
        "labels": [],
        "orders": [],
        "revenue": []
    }
    for row in gender_stats:
        gender_data["labels"].append(gender_labels_map.get(row['gender'], row['gender']))
        gender_data["orders"].append(int(row['total_orders']))
        gender_data["revenue"].append(float(row['total_revenue']))

    # -----------------------------------------------
    # 2. Age group distribution of buyers
    # -----------------------------------------------
    cursor.execute("""
        SELECT 
            u.date_of_birth,
            COUNT(DISTINCT o.id) as total_orders,
            COALESCE(SUM(o.total), 0) as total_revenue
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.status != 'cancelled'
        GROUP BY u.date_of_birth
    """)
    dob_stats = cursor.fetchall()

    age_group_agg = {}
    today = date.today()
    for row in dob_stats:
        if row['date_of_birth']:
            dob = row['date_of_birth']
            if isinstance(dob, str):
                from datetime import datetime
                dob = datetime.strptime(dob, '%Y-%m-%d').date()
            age = today.year - dob.year - ((today.month, today.day) < (dob.month, dob.day))
        else:
            age = None
        group = get_age_group(age)
        if group not in age_group_agg:
            age_group_agg[group] = {"orders": 0, "revenue": 0.0}
        age_group_agg[group]["orders"] += int(row['total_orders'])
        age_group_agg[group]["revenue"] += float(row['total_revenue'])

    age_group_order = ["Dưới 18", "18–24", "25–34", "35–44", "45–54", "55+", "Không rõ"]
    age_data = {
        "labels": [],
        "orders": [],
        "revenue": []
    }
    for group in age_group_order:
        if group in age_group_agg:
            age_data["labels"].append(group)
            age_data["orders"].append(age_group_agg[group]["orders"])
            age_data["revenue"].append(age_group_agg[group]["revenue"])

    # -----------------------------------------------
    # 3. Top categories by gender
    # -----------------------------------------------
    cursor.execute("""
        SELECT 
            COALESCE(u.gender, 'unknown') as gender,
            c.name as category_name,
            COUNT(od.id) as items_sold,
            COALESCE(SUM(od.price * od.quantity), 0) as revenue
        FROM order_details od
        JOIN orders o ON od.order_id = o.id
        JOIN products p ON od.product_id = p.id
        JOIN categories c ON p.category_id = c.id
        JOIN users u ON o.user_id = u.id
        WHERE o.status != 'cancelled'
        GROUP BY u.gender, c.name
        ORDER BY u.gender, revenue DESC
    """)
    category_gender_raw = cursor.fetchall()

    category_by_gender = {}
    for row in category_gender_raw:
        g = gender_labels_map.get(row['gender'], row['gender'])
        if g not in category_by_gender:
            category_by_gender[g] = []
        category_by_gender[g].append({
            "category": row['category_name'],
            "items_sold": int(row['items_sold']),
            "revenue": float(row['revenue'])
        })

    # -----------------------------------------------
    # 4. Top categories by age group
    # -----------------------------------------------
    cursor.execute("""
        SELECT 
            u.date_of_birth,
            c.name as category_name,
            COUNT(od.id) as items_sold,
            COALESCE(SUM(od.price * od.quantity), 0) as revenue
        FROM order_details od
        JOIN orders o ON od.order_id = o.id
        JOIN products p ON od.product_id = p.id
        JOIN categories c ON p.category_id = c.id
        JOIN users u ON o.user_id = u.id
        WHERE o.status != 'cancelled'
        GROUP BY u.date_of_birth, c.name
        ORDER BY revenue DESC
    """)
    category_age_raw = cursor.fetchall()

    category_by_age = {}
    for row in category_age_raw:
        if row['date_of_birth']:
            dob = row['date_of_birth']
            if isinstance(dob, str):
                from datetime import datetime
                dob = datetime.strptime(dob, '%Y-%m-%d').date()
            age = today.year - dob.year - ((today.month, today.day) < (dob.month, dob.day))
        else:
            age = None
        group = get_age_group(age)
        if group not in category_by_age:
            category_by_age[group] = []
        # Find if category already in list
        found = False
        for item in category_by_age[group]:
            if item["category"] == row['category_name']:
                item["items_sold"] += int(row['items_sold'])
                item["revenue"] += float(row['revenue'])
                found = True
                break
        if not found:
            category_by_age[group].append({
                "category": row['category_name'],
                "items_sold": int(row['items_sold']),
                "revenue": float(row['revenue'])
            })

    # -----------------------------------------------
    # 5. Top 10 Products
    # -----------------------------------------------
    cursor.execute("""
        SELECT 
            p.name as product_name,
            COUNT(od.id) as total_sold,
            COALESCE(SUM(od.price * od.quantity), 0) as revenue
        FROM order_details od
        JOIN orders o ON od.order_id = o.id
        JOIN products p ON od.product_id = p.id
        WHERE o.status != 'cancelled'
        GROUP BY p.id, p.name
        ORDER BY total_sold DESC, revenue DESC
        LIMIT 10
    """)
    top_products = cursor.fetchall()

    # -----------------------------------------------
    # 6. Summary stats
    # -----------------------------------------------
    cursor.execute("""
        SELECT 
            COUNT(DISTINCT o.id) as total_orders,
            COALESCE(SUM(o.total), 0) as total_revenue,
            COUNT(DISTINCT o.user_id) as unique_buyers
        FROM orders o
        WHERE o.status != 'cancelled'
    """)
    summary = cursor.fetchone()

    cursor.execute("SELECT COUNT(*) as total FROM users WHERE role = 'customer'")
    user_count = cursor.fetchone()

    cursor.close()
    conn.close()

    result = {
        "generated_at": date.today().isoformat(),
        "summary": {
            "total_orders": int(summary['total_orders']),
            "total_revenue": float(summary['total_revenue']),
            "unique_buyers": int(summary['unique_buyers']),
            "total_users": int(user_count['total'])
        },
        "gender": gender_data,
        "age_groups": age_data,
        "category_by_gender": category_by_gender,
        "category_by_age": category_by_age,
        "top_products": [
            {
                "name": row['product_name'],
                "sold": int(row['total_sold']),
                "revenue": float(row['revenue'])
            } for row in top_products
        ]
    }

    print(json.dumps(result, ensure_ascii=False, indent=2))


if __name__ == '__main__':
    try:
        analyze()
    except Exception as e:
        print(json.dumps({"error": str(e)}))
        sys.exit(1)
