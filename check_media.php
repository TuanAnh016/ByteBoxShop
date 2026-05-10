<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$p = App\Models\Product::first();
echo $p->name . PHP_EOL;
echo 'Media count: ' . $p->getMedia('images')->count() . PHP_EOL;
echo 'First media URL: ' . $p->getFirstMediaUrl('images') . PHP_EOL;

$media = $p->getFirstMedia('images');
if ($media) {
    echo 'File exists: ' . (file_exists($media->getPath()) ? 'YES' : 'NO') . PHP_EOL;
    echo 'File path: ' . $media->getPath() . PHP_EOL;
    echo 'Disk: ' . $media->disk . PHP_EOL;
}
