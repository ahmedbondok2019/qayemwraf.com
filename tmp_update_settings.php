<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$setting = \App\Models\Setting::find(1);
if ($setting) {
    if ($setting->logo && strpos($setting->logo, 'storage/') === false) {
        $setting->logo = 'storage/website/images/logo/' . $setting->logo;
    }
    if ($setting->logo_dark && strpos($setting->logo_dark, 'storage/') === false) {
        $setting->logo_dark = 'storage/website/images/logo/' . $setting->logo_dark;
    }
    if ($setting->fav_icon && strpos($setting->fav_icon, 'storage/') === false) {
        $setting->fav_icon = 'storage/website/images/logo/' . $setting->fav_icon;
    }
    $setting->save();
    echo "Settings updated successfully\n";
} else {
    echo "Settings not found\n";
}
