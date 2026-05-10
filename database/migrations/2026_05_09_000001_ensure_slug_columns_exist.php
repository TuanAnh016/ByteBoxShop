<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Đảm bảo bảng categories có column slug
        if (!Schema::hasColumn('categories', 'slug')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->string('slug', 256)->nullable()->after('name');
            });
        }

        // Đảm bảo bảng products có column slug
        if (!Schema::hasColumn('products', 'slug')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('slug', 256)->nullable()->after('name');
            });
        }

        // Điền slug cho các category chưa có slug
        $categories = DB::table('categories')->whereNull('slug')->orWhere('slug', '')->get();
        foreach ($categories as $category) {
            $baseSlug = Str::slug($category->name);
            $slug     = $baseSlug;
            $counter  = 1;
            while (DB::table('categories')->where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            DB::table('categories')->where('id', $category->id)->update(['slug' => $slug]);
        }

        // Điền slug cho các product chưa có slug
        $products = DB::table('products')->whereNull('slug')->orWhere('slug', '')->get();
        foreach ($products as $product) {
            $baseSlug = Str::slug($product->name);
            $slug     = $baseSlug;
            $counter  = 1;
            while (DB::table('products')->where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        }

        // Thêm unique index nếu chưa có
        try {
            Schema::table('categories', function (Blueprint $table) {
                $table->unique('slug');
            });
        } catch (\Exception $e) {
            // Index đã tồn tại, bỏ qua
        }

        try {
            Schema::table('products', function (Blueprint $table) {
                $table->unique('slug');
            });
        } catch (\Exception $e) {
            // Index đã tồn tại, bỏ qua
        }
    }

    public function down(): void
    {
        // Không xóa slug vì có thể đã có từ trước
    }
};
