<?php
// Script to check and fix Vietnamese data in categories table
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$port = $_ENV['DB_PORT'] ?? '3306';
$database = $_ENV['DB_DATABASE'] ?? 'laravel';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ]);

    echo "🔍 Checking Vietnamese data in categories table...\n\n";

    // Check current data
    $stmt = $pdo->query("SELECT id, name, description FROM categories ORDER BY id");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Current data:\n";
    foreach ($categories as $category) {
        echo "ID: {$category['id']}\n";
        echo "Name: {$category['name']}\n";
        echo "Description: {$category['description']}\n";
        echo "---\n";
    }

    // Fix common Vietnamese character encoding issues
    $fixes = [
        '??m thanh ?????nh cao' => 'Âm thanh đỉnh cao',
        'B???o v??? Ngh??? thu???t' => 'Bảo vệ Nghệ thuật',
        'Tr???i nghi???m ??m thanh v?????t tr???i.' => 'Trải nghiệm âm thanh vượt trội.',
        '???p l??ng v?? t??i ch???ng s???c cao c???p.' => 'Ấp lượng vật tài chống sốc cao cấp.',
        'N??ng l?????ng T???i th?????ng' => 'Năng lượng Tiết kiệm',
        'S???c v?? c??p truy???n d??? li???u si??u t???c.' => 'Sức vóc cấp truyền dữ liệu siêu tốc.',
        'Ki???t t??c Hi???n th???' => 'Kiệt trức Hiển thị',
        'M??n h??nh v?? ph??? ki???n h??nh ???nh.' => 'Màn hình vỏ phụ kiện hình ảnh.',
    ];

    echo "\n🔧 Applying fixes...\n";
    
    // Fix names
    foreach ($fixes as $wrong => $correct) {
        $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE name = ?");
        $stmt->execute([$correct, $wrong]);
        $affected = $stmt->rowCount();
        if ($affected > 0) {
            echo "✓ Fixed name: '$wrong' -> '$correct' ($affected rows)\n";
        }
    }
    
    // Fix descriptions
    $description_fixes = [
        'Tr???i nghi???m ??m thanh v?????t tr???i.' => 'Trải nghiệm âm thanh vượt trội.',
        '???p l??ng v?? t??i ch???ng s???c cao c???p.' => 'Ấp lượng vật tài chống sốc cao cấp.',
        'S???c v?? c??p truy???n d??? li???u si??u t???c.' => 'Sức vóc cấp truyền dữ liệu siêu tốc.',
        'M??n h??nh v?? ph??? ki???n h??nh ???nh.' => 'Màn hình vỏ phụ kiện hình ảnh.',
    ];
    
    foreach ($description_fixes as $wrong => $correct) {
        $stmt = $pdo->prepare("UPDATE categories SET description = ? WHERE description = ?");
        $stmt->execute([$correct, $wrong]);
        $affected = $stmt->rowCount();
        if ($affected > 0) {
            echo "✓ Fixed description: '$wrong' -> '$correct' ($affected rows)\n";
        }
    }

    echo "\n✅ Vietnamese data fix completed!\n";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
