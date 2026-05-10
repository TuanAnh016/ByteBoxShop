<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

#[Signature('app:migrate-images-to-media-library')]
#[Description('Migrate existing product and category images to Spatie Media Library')]
class MigrateImagesToMediaLibrary extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Migrating product images...');
        $products = Product::whereNotNull('image')->where('image', '!=', '')->get();
        foreach ($products as $product) {
            $path = public_path('storage/' . $product->image);
            if (File::exists($path) && $product->getMedia('images')->count() === 0) {
                $product->addMedia($path)->preservingOriginal()->toMediaCollection('images');
                $this->line("Migrated image for Product ID: {$product->id}");
            }
        }

        $this->info('Migrating category images...');
        $categories = Category::whereNotNull('image')->where('image', '!=', '')->get();
        foreach ($categories as $category) {
            $path = public_path('storage/' . $category->image);
            if (File::exists($path) && $category->getMedia('images')->count() === 0) {
                $category->addMedia($path)->preservingOriginal()->toMediaCollection('images');
                $this->line("Migrated image for Category ID: {$category->id}");
            }
        }
        
        $this->info('Image migration complete.');
    }
}
