<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @returnUnauthenticated.void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsByRole = collect([
            'super-admin' => [
                'create_admin',
                'delete_admin',
                'user_admin',
                'company_admin',
                'change_standard_fields',
                'configure_forms',
                'send_notifications_global',
                'add_platforms',
                'delete_platforms',
                'report_licences',
                'monitor_licences',
                'add_features',
                'update_local_form',
                'add_local_form',
                'delete_local_form',
                ],
            'admin' => [
                'can_activate_form',
                'can_deactivate_form',
                'update_local_form',
                'add_local_form',
                'delete_local_form',
                'user_admin',
                'project_admin',
                'add_local_user',
                'delete_local_user',
                'update_local_user',
                'add_local_group',
                'update_local_group',
                'delete_local_group',
                'can_create_role',
                'can_create_permission',
                'can_configure_reports',
                'can_configure_notifications',
                'can_configure_automations',            ],
            'user' => [
                'can_have_multiple_roles',
                'can_read_platform',
                'can_update_own_profile',
                'can_update_own_favorite',
                'can_access_tutorial',
                'can_access_information',
                'user',
            ],
        ]);

//        $systemAPIPermissions = collect([
//            'updateInstitutionData'
//        ]);

        # Update Permissions
        # Web Guard
        /** @var Collection $uniquePermissions */
        $uniquePermissions = $permissionsByRole->reduce(fn($r, $v, $k) => $r->merge($v), collect([]))->unique();
        $permissionToID = self::syncPermissionsBetween($uniquePermissions, 'web');

        # System API guard
//        self::syncPermissionsBetween($systemAPIPermissions, 'system_token');

        $mapByRole = fn($role) => $permissionToID->filter(fn($v, $k) => in_array($k, $permissionsByRole->get($role)))
                                                 ->values();

        $permissionIdsByRole = $permissionsByRole->map(fn($v, $k) => $mapByRole($k));

        $rolesToID = DB::table(\Config::get('permission.table_names.roles'))->pluck('id', 'name');
        DB::table(\Config::get('permission.table_names.role_has_permissions'))->truncate();

        # Update roles
        foreach ($permissionIdsByRole as $role => $permissionIds) {
            if ($rolesToID->has($role)) {
                $roleId = $rolesToID->get($role);
            } else {
                $roleId = Role::insertGetId([
                    'name' => $role,
                    'guard_name' => 'web'
                ]);
            }

            DB::table(\Config::get('permission.table_names.role_has_permissions'))
              ->insert($permissionIds->map(fn($id) => [
                    'role_id' => $roleId,
                    'permission_id' => $id
                ])->toArray());
        }
    }

    public static function syncPermissionsBetween(Collection $targetPermissions, string $guard = 'web'): Collection
    {
        $permissionToID = DB::table(\Config::get('permission.table_names.permissions'))
                            ->where('guard_name', $guard)
                            ->pluck('id', 'name');

        $missingPermissions = $permissionToID->keys()->diff($targetPermissions);
        DB::table(\Config::get('permission.table_names.permissions'))
            ->where('guard_name', $guard)
            ->whereIn('name', $missingPermissions->values())
            ->delete();

        $newPermissions = $targetPermissions->diff($permissionToID->keys());
        return $permissionToID->merge($newPermissions->mapWithKeys(fn($v, $k) => [
            $v => DB::table(\Config::get('permission.table_names.permissions'))->insertGetId([
                'name' => $v,
                'guard_name' => $guard
            ])
        ]));
    }
}
