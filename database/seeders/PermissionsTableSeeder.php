<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'asset_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'asset_category_create',
            ],
            [
                'id'    => 19,
                'title' => 'asset_category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'asset_category_show',
            ],
            [
                'id'    => 21,
                'title' => 'asset_category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'asset_category_access',
            ],
            [
                'id'    => 23,
                'title' => 'asset_location_create',
            ],
            [
                'id'    => 24,
                'title' => 'asset_location_edit',
            ],
            [
                'id'    => 25,
                'title' => 'asset_location_show',
            ],
            [
                'id'    => 26,
                'title' => 'asset_location_delete',
            ],
            [
                'id'    => 27,
                'title' => 'asset_location_access',
            ],
            [
                'id'    => 28,
                'title' => 'asset_status_create',
            ],
            [
                'id'    => 29,
                'title' => 'asset_status_edit',
            ],
            [
                'id'    => 30,
                'title' => 'asset_status_show',
            ],
            [
                'id'    => 31,
                'title' => 'asset_status_delete',
            ],
            [
                'id'    => 32,
                'title' => 'asset_status_access',
            ],
            [
                'id'    => 33,
                'title' => 'asset_create',
            ],
            [
                'id'    => 34,
                'title' => 'asset_edit',
            ],
            [
                'id'    => 35,
                'title' => 'asset_show',
            ],
            [
                'id'    => 36,
                'title' => 'asset_delete',
            ],
            [
                'id'    => 37,
                'title' => 'asset_access',
            ],
            [
                'id'    => 38,
                'title' => 'assets_history_access',
            ],
            [
                'id'    => 39,
                'title' => 'opcje_access',
            ],
            [
                'id'    => 40,
                'title' => 'user_pppo_access',
            ],
            [
                'id'    => 41,
                'title' => 'pppo_create',
            ],
            [
                'id'    => 42,
                'title' => 'pppo_edit',
            ],
            [
                'id'    => 43,
                'title' => 'pppo_show',
            ],
            [
                'id'    => 44,
                'title' => 'pppo_delete',
            ],
            [
                'id'    => 45,
                'title' => 'pppo_access',
            ],
            [
                'id'    => 46,
                'title' => 'kompart_create',
            ],
            [
                'id'    => 47,
                'title' => 'kompart_edit',
            ],
            [
                'id'    => 48,
                'title' => 'kompart_show',
            ],
            [
                'id'    => 49,
                'title' => 'kompart_delete',
            ],
            [
                'id'    => 50,
                'title' => 'kompart_access',
            ],
            [
                'id'    => 51,
                'title' => 'kompartnadajniki_create',
            ],
            [
                'id'    => 52,
                'title' => 'kompartnadajniki_edit',
            ],
            [
                'id'    => 53,
                'title' => 'kompartnadajniki_show',
            ],
            [
                'id'    => 54,
                'title' => 'kompartnadajniki_delete',
            ],
            [
                'id'    => 55,
                'title' => 'kompartnadajniki_access',
            ],
            [
                'id'    => 56,
                'title' => 'menu_access',
            ],
            [
                'id'    => 57,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
