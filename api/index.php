<?php
/**
 * Vercel Serverless Function for Laravel
 */

// Set environment variables for Vercel
$_ENV['APP_ENV'] = 'production';
$_ENV['APP_DEBUG'] = 'false';

// Define the path to the Laravel public directory
$laravelPublicPath = __DIR__ . '/../public';

// Set the working directory to Laravel root
chdir(__DIR__ . '/..');

// Load Laravel's bootstrap
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Use HTTP Kernel instead of Console Kernel for web requests
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Handle the request
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
