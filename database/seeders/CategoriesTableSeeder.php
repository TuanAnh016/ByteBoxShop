<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Âm thanh Đỉnh cao',
                'slug' => 'am-thanh-dinh-cao',
                'description' => 'Trải nghiệm âm thanh vượt trội.',
                'image' => 'https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?q=80&w=800&auto=format&fit=crop',
                'created_at' => '2026-05-04 07:00:03',
                'updated_at' => '2026-05-04 07:00:03',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bảo vệ Nghệ thuật',
                'slug' => 'bao-ve-nghe-thuat',
                'description' => 'Ốp lưng và túi chống sốc cao cấp.',
                'image' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?q=80&w=800&auto=format&fit=crop',
                'created_at' => '2026-05-04 07:00:03',
                'updated_at' => '2026-05-04 07:00:03',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Năng lượng Tối thượng',
                'slug' => 'nang-luong-toi-thuong',
                'description' => 'Sạc và cáp truyền dữ liệu siêu tốc.',
                'image' => 'https://images.unsplash.com/photo-1583863788434-e58a36330cf0?q=80&w=800&auto=format&fit=crop',
                'created_at' => '2026-05-04 07:00:03',
                'updated_at' => '2026-05-04 07:00:03',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Kiệt tác Hiển thị',
                'slug' => 'kiet-tac-hien-thi',
                'description' => 'Màn hình và phụ kiện hình ảnh.',
                'image' => 'https://images.unsplash.com/photo-1517059224940-d4af9eec41b7?q=80&w=800&auto=format&fit=crop',
                'created_at' => '2026-05-04 07:00:03',
                'updated_at' => '2026-05-04 07:00:03',
            ),
        ));
        
        
    }
}