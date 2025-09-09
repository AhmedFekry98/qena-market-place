<?php

namespace Database\Seeders\SystemManagements;

use App\Features\SystemManagements\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // General Dashboard
            ['group' => 'General Dashboard', 'name' => 'dashboard_view', 'caption' => 'show dashboard'],
            ['group' => 'General Dashboard', 'name' => 'dashboard_stats', 'caption' => 'show dashboard stats'],

            // Marketing Dashboard
            ['group' => 'Marketing Dashboard', 'name' => 'marketing_dashboard_view', 'caption' => 'show marketing dashboard'],
            ['group' => 'Marketing Dashboard', 'name' => 'marketing_campaigns_manage', 'caption' => 'manage marketing campaigns'],

            // Sales Management
            ['group' => 'Sales Management', 'name' => 'sales_list', 'caption' => 'show sales list'],
            ['group' => 'Sales Management', 'name' => 'sales_edit', 'caption' => 'edit sales'],
            ['group' => 'Sales Management', 'name' => 'sales_create', 'caption' => 'create new sale'],
            ['group' => 'Sales Management', 'name' => 'sales_delete', 'caption' => 'delete sale'],

            // User Management
            ['group' => 'User Management', 'name' => 'users_list', 'caption' => 'show users list'],
            ['group' => 'User Management', 'name' => 'users_create', 'caption' => 'create new user'],
            ['group' => 'User Management', 'name' => 'users_edit', 'caption' => 'edit user'],
            ['group' => 'User Management', 'name' => 'users_delete', 'caption' => 'delete user'],

            // System Settings
            ['group' => 'System Settings', 'name' => 'settings_view', 'caption' => 'show settings'],
            ['group' => 'System Settings', 'name' => 'settings_edit', 'caption' => 'edit settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}
