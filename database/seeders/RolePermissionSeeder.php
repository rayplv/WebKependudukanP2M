<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    // Set role permissions and assign roles to users
    private function setRolePermissions($roleName, $permissions, $emails): void
    {
        // Create role
        $role = Role::create(['name' => $roleName]);

        // Attach permissions to the role
        foreach ($permissions as $permission) $role->permissions()->attach($permission);

        // Assign role to users
        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->role()->associate($role);
                $user->save();
            }
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define and create permissions
        $permissions = collect([
            ['name' => 'View Dashboard', 'route' => 'dashboard.*'],
            ['name' => 'Manage Users', 'route' => 'dashboard.administrators.*'],
            ['name' => 'edit-residents', 'route' => 'datapenduduk.edit-residents'],
            ['name' => 'delete-residents', 'route' => 'datapenduduk.delete-residents'],
            ['name' => 'View Management', 'route' => 'kelolaakun.*'],
            ['name' => 'add-users', 'route' => 'kelolaakun.*'],
            ['name' => 'edit-users', 'route' => 'kelolaakun.*'],
            ['name' => 'delete-users', 'route' => 'kelolaakun.*'],
            ['name' => 'status-users', 'route' => 'kelolaakun.*'],
            // ... other permissions
        ])->map(fn($permission) => Permission::create($permission));

        // set superadmin role with all permissions
        $this->setRolePermissions('superadmin', $permissions, ['superadmin@indragiri.id']);

        // Define admin permissions excluding superadmin exclusive permissions
        $adminPermissions = $permissions->filter(fn($permission) => !in_array($permission->name, [
            'Manage Users',
            'edit-residents',
            'delete-residents',
        ]));

        // Set admin role with limited permissions
        $this->setRolePermissions('admin', $adminPermissions, ['admin1@indragiri.id']);
    }
}
