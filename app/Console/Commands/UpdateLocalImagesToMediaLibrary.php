<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;

#[Signature('app:update-local-images-to-media-library')]
#[Description('Updates product and category images from local productimg folder using Media Library')]
class UpdateLocalImagesToMediaLibrary extends Command
{
    public function handle()
    {
        $mapping = [
            'Aura Master Headphone - Limited Obsidian' => 'Auramaster.jpg',
            'Echo Forge Wireless Earbuds' => 'Echoforge.jpg',
            'Sonic Prism Soundbar' => 'Sonicprism.jpg',
            'Resonance Over-Ear Studio' => 'Resonanceover.jpg',
            'Obsidian Velvet IEMs' => 'Obsidianvelvet.jpg',
            'Aegis Vanguard Laptop Sleeve 16"' => 'Aegisvanguard.jpg',
            'Onyx Carbon iPhone 15 Pro Case' => 'Onyxcarbon15pro.jpg',
            'Leather Artisan iPad Pro Folio' => 'Leatherartisanipad.jpg',
            'Obsidian Shield MacBook Shell' => 'Obsidianshieldmacbook.jpg',
            'Velvet Touch Tech Pouch' => 'Velvettouchtech.jpg',
            'Nexus Quantum Hub 12-in-1' => 'Nexusquantum12in1.jpg',
            'Chronos Wireless Charging Artifact' => 'Choronoswireless.jpg',
            'OmniCore 140W GaN Charger' => 'Omnicore140w.jpg',
            'Carbon Braided Thunderbolt 4 Cable' => 'carbonbraided.jpg',
            'SolarFlare PowerBank 20000mAh' => 'Solarflarepowerbank.jpg',
            'RetinaX 32" 6K Pro Display' => 'RetinaX6kPro.jpg',
            'Horizon Curved Ultrawide 49"' => 'Horizoncurved.jpg',
            'Prism Portable OLED 15.6"' => 'Prismportable.jpg',
            'Obsidian Frameless Monitor 27"' => 'obsidianframeless.jpg',
            'Visionary Studio Display 8K' => 'Visionarystudiodisplay8K.jpg',
        ];

        $this->info('Starting to update product images...');

        foreach ($mapping as $productName => $fileName) {
            $product = Product::where('name', $productName)->first();
            if ($product) {
                $filePath = public_path('productimg/' . $fileName);
                if (file_exists($filePath)) {
                    // Clear existing media first to avoid duplicates
                    $product->clearMediaCollection('images');
                    
                    // Add new media
                    $product->addMedia($filePath)
                            ->preservingOriginal()
                            ->toMediaCollection('images');
                    $this->info("Updated image for product: {$productName}");
                } else {
                    $this->error("File not found: {$filePath}");
                }
            } else {
                $this->error("Product not found: {$productName}");
            }
        }

        $this->info('Starting to update category images...');

        $categories = Category::all();
        foreach ($categories as $category) {
            $firstProduct = $category->products()->first();
            
            if ($firstProduct) {
                // Get the file name from mapping for this first product
                if (isset($mapping[$firstProduct->name])) {
                    $fileName = $mapping[$firstProduct->name];
                    $filePath = public_path('productimg/' . $fileName);
                    
                    if (file_exists($filePath)) {
                        $category->clearMediaCollection('images');
                        $category->addMedia($filePath)
                                 ->preservingOriginal()
                                 ->toMediaCollection('images');
                        $this->info("Updated image for category: {$category->name}");
                    }
                }
            }
        }

        $this->info('All images updated successfully!');
    }
}
