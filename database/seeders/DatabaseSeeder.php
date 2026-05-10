<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Atelier',
            'email' => 'admin@bytebox.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        // Categories
        $categories = [
            [
                'name' => 'Âm thanh Đỉnh cao', 
                'slug' => Str::slug('Âm thanh Đỉnh cao'), 
                'description' => 'Trải nghiệm âm thanh vượt trội.',
                'image' => 'https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Bảo vệ Nghệ thuật', 
                'slug' => Str::slug('Bảo vệ Nghệ thuật'), 
                'description' => 'Ốp lưng và túi chống sốc cao cấp.',
                'image' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Năng lượng Tối thượng', 
                'slug' => Str::slug('Năng lượng Tối thượng'), 
                'description' => 'Sạc và cáp truyền dữ liệu siêu tốc.',
                'image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Kiệt tác Hiển thị', 
                'slug' => Str::slug('Kiệt tác Hiển thị'), 
                'description' => 'Màn hình và phụ kiện hình ảnh.',
                'image' => 'https://images.unsplash.com/photo-1517059224940-d4af9eec41b7?q=80&w=800&auto=format&fit=crop'
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $products = [
            // Category 1: Âm thanh Đỉnh cao (Audio)
            [
                'name' => 'Aura Master Headphone - Limited Obsidian',
                'slug' => Str::slug('Aura Master Headphone Limited Obsidian'),
                'description' => 'Tai nghe over-ear với công nghệ chống ồn chủ động kép. Lớp hoàn thiện Obsidian mờ sang trọng.',
                'price' => 499.00,
                'sale_price' => 449.00,
                'category_id' => 1,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Echo Forge Wireless Earbuds',
                'slug' => Str::slug('Echo Forge Wireless Earbuds'),
                'description' => 'Tai nghe TWS vỏ nhôm xước nguyên khối, âm thanh Hi-Res Audio chứng nhận.',
                'price' => 249.00,
                'sale_price' => null,
                'category_id' => 1,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Sonic Prism Soundbar',
                'slug' => Str::slug('Sonic Prism Soundbar'),
                'description' => 'Loa thanh 7.1.4 Dolby Atmos với lưới tản nhiệt mạ vàng hồng 18K.',
                'price' => 899.00,
                'sale_price' => 799.00,
                'category_id' => 1,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Resonance Over-Ear Studio',
                'slug' => Str::slug('Resonance Over-Ear Studio'),
                'description' => 'Tai nghe kiểm âm với màng loa Graphene, đệm tai bọc da Cừu thủ công.',
                'price' => 599.00,
                'sale_price' => null,
                'category_id' => 1,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Obsidian Velvet IEMs',
                'slug' => Str::slug('Obsidian Velvet IEMs'),
                'description' => 'Tai nghe In-Ear Monitor đúc custom từ đá Obsidian đen tuyền.',
                'price' => 349.00,
                'sale_price' => 299.00,
                'category_id' => 1,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1598331668826-20cefac91461?q=80&w=800&auto=format&fit=crop'
            ],
            
            // Category 2: Bảo vệ Nghệ thuật (Cases/Sleeves)
            [
                'name' => 'Aegis Vanguard Laptop Sleeve 16"',
                'slug' => Str::slug('Aegis Vanguard Laptop Sleeve 16'),
                'description' => 'Túi chống sốc da thật dập nổi kết hợp sợi carbon. Thiết kế phi tuyến tính độc bản.',
                'price' => 89.00,
                'sale_price' => null,
                'category_id' => 2,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Onyx Carbon iPhone 15 Pro Case',
                'slug' => Str::slug('Onyx Carbon iPhone 15 Pro Case'),
                'description' => 'Ốp lưng từ sợi Carbon thật kết hợp viền hợp kim Titantium mạ vàng đen.',
                'price' => 59.00,
                'sale_price' => 49.00,
                'category_id' => 2,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Leather Artisan iPad Pro Folio',
                'slug' => Str::slug('Leather Artisan iPad Pro Folio'),
                'description' => 'Bao da iPad khâu thủ công từ Ý, nhuộm màu đen sẫm Dark Atelier.',
                'price' => 129.00,
                'sale_price' => null,
                'category_id' => 2,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Obsidian Shield MacBook Shell',
                'slug' => Str::slug('Obsidian Shield MacBook Shell'),
                'description' => 'Ốp nhựa nhám mờ xuyên thấu siêu mỏng bảo vệ toàn diện cho MacBook.',
                'price' => 79.00,
                'sale_price' => null,
                'category_id' => 2,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Velvet Touch Tech Pouch',
                'slug' => Str::slug('Velvet Touch Tech Pouch'),
                'description' => 'Túi đựng phụ kiện công nghệ lót nhung bọc vải Kordura kháng nước.',
                'price' => 45.00,
                'sale_price' => 39.00,
                'category_id' => 2,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?q=80&w=800&auto=format&fit=crop'
            ],

            // Category 3: Năng lượng Tối thượng (Chargers/Cables)
            [
                'name' => 'Nexus Quantum Hub 12-in-1',
                'slug' => Str::slug('Nexus Quantum Hub 12 in 1'),
                'description' => 'Hub mở rộng với thân nhôm nguyên khối. Hỗ trợ xuất 2 màn hình 8K.',
                'price' => 129.00,
                'sale_price' => null,
                'category_id' => 3,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1593640498182-31c70c8268f5?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Chronos Wireless Charging Artifact',
                'slug' => Str::slug('Chronos Wireless Charging Artifact'),
                'description' => 'Đế sạc không dây 3 trong 1. Viền mạ vàng 18K và mặt kính Sapphire cường lực.',
                'price' => 199.00,
                'sale_price' => 179.00,
                'category_id' => 3,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1615526675159-e248c3021d3f?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'OmniCore 140W GaN Charger',
                'slug' => Str::slug('OmniCore 140W GaN Charger'),
                'description' => 'Củ sạc siêu nhanh công nghệ GaN thế hệ mới, kích thước siêu nhỏ.',
                'price' => 89.00,
                'sale_price' => null,
                'category_id' => 3,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1632213702157-1954848383a8?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Carbon Braided Thunderbolt 4 Cable',
                'slug' => Str::slug('Carbon Braided Thunderbolt 4 Cable'),
                'description' => 'Cáp bọc dù pha sợi carbon, băng thông 40Gbps siêu cấp.',
                'price' => 49.00,
                'sale_price' => null,
                'category_id' => 3,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1624823183569-8395562d98dc?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'SolarFlare PowerBank 20000mAh',
                'slug' => Str::slug('SolarFlare PowerBank 20000mAh'),
                'description' => 'Pin dự phòng viền nhôm, tích hợp màn hình OLED hiển thị công suất.',
                'price' => 149.00,
                'sale_price' => 129.00,
                'category_id' => 3,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1609091839311-d5365f9ff1c5?q=80&w=800&auto=format&fit=crop'
            ],

            // Category 4: Kiệt tác Hiển thị (Monitors/Displays)
            [
                'name' => 'RetinaX 32" 6K Pro Display',
                'slug' => Str::slug('RetinaX 32 6K Pro Display'),
                'description' => 'Màn hình chuyên đồ họa với độ phủ màu 100% DCI-P3, chân đế xoay 360.',
                'price' => 1999.00,
                'sale_price' => null,
                'category_id' => 4,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Horizon Curved Ultrawide 49"',
                'slug' => Str::slug('Horizon Curved Ultrawide 49'),
                'description' => 'Màn hình cong vô cực 1000R, tấm nền QD-OLED cho sắc đen sâu thẳm.',
                'price' => 1499.00,
                'sale_price' => 1299.00,
                'category_id' => 4,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1616053351239-67d710d8e82d?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Prism Portable OLED 15.6"',
                'slug' => Str::slug('Prism Portable OLED 15 6'),
                'description' => 'Màn hình phụ di động siêu mỏng 4mm, kết nối chỉ cần 1 cáp Type-C.',
                'price' => 399.00,
                'sale_price' => null,
                'category_id' => 4,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1588666309990-d68f08e3d4a6?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Obsidian Frameless Monitor 27"',
                'slug' => Str::slug('Obsidian Frameless Monitor 27'),
                'description' => 'Màn hình viền siêu mỏng 4 cạnh, thiết kế nguyên khối phong cách Minimalist.',
                'price' => 499.00,
                'sale_price' => 449.00,
                'category_id' => 4,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'name' => 'Visionary Studio Display 8K',
                'slug' => Str::slug('Visionary Studio Display 8K'),
                'description' => 'Cực phẩm màn hình 8K đầu tiên trang bị MiniLED 4096 vùng sáng độc lập.',
                'price' => 3499.00,
                'sale_price' => 3199.00,
                'category_id' => 4,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?q=80&w=800&auto=format&fit=crop'
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }
    }
}
