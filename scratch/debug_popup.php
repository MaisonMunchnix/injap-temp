<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\PopupAnnouncement;

$popup = PopupAnnouncement::latest()->first();
if ($popup) {
    echo "ID: " . $popup->id . "\n";
    echo "Title: " . $popup->title . "\n";
    echo "Image: " . $popup->image . "\n";
    echo "Is Active: " . $popup->is_active . "\n";
    
    if ($popup->image) {
        $fullPath = public_path($popup->image);
        echo "Full Path: " . $fullPath . "\n";
        echo "Exists: " . (file_exists($fullPath) ? "Yes" : "No") . "\n";
    }
} else {
    echo "No popup found.\n";
}
