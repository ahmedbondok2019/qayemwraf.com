<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\GroupPermission;
use App\Models\Permission;
use App\Models\StaticTranslation;
use Illuminate\Contracts\Console\Kernel;

$parent = 'projects';
$group = 'General';
$crud = ['read', 'create', 'update', 'delete'];

foreach ($crud as $action) {
    $p = Permission::updateOrCreate(
        ['name' => "projects_{$action}"],
        ['parent_permission' => $parent, 'group_permission' => $group, 'status' => 1]
    );
    GroupPermission::firstOrCreate(['permission_id' => $p->id, 'group_id' => 1]);
}

StaticTranslation::updateOrCreate(
    ['key' => 'dashboard.projects'],
    ['translations' => ['ar' => 'المشروعات', 'en' => 'Projects']]
);

echo "Permissions and translation seeded successfully!\n";
