<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        /*Permission::create(['name' => 'dashboard.access']);

        Permission::create(['name' => 'organisations.index']);
        Permission::create(['name' => 'organisations.store']);
        Permission::create(['name' => 'organisations.archive']);
        Permission::create(['name' => 'organisations.show']);
        Permission::create(['name' => 'organisations.update']);
        Permission::create(['name' => 'organisations.approve']);
        Permission::create(['name' => 'organisations.suspend']);
        Permission::create(['name' => 'organisations.delete']);
        Permission::create(['name' => 'organisations.hard-delete']);

        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.verify']);
        Permission::create(['name' => 'users.store']);
        Permission::create(['name' => 'users.archive']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.approve']);
        Permission::create(['name' => 'users.suspend']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.hard-delete']);

        Permission::create(['name' => 'resumes.index']);
        Permission::create(['name' => 'resumes.store']);
        Permission::create(['name' => 'resumes.archive']);
        Permission::create(['name' => 'resumes.show']);
        Permission::create(['name' => 'resumes.update']);
        Permission::create(['name' => 'resumes.approve']);
        Permission::create(['name' => 'resumes.suspend']);
        Permission::create(['name' => 'resumes.delete']);
        Permission::create(['name' => 'resumes.hard-delete']);

        Permission::create(['name' => 'events.index']);
        Permission::create(['name' => 'events.store']);
        Permission::create(['name' => 'events.archive']);
        Permission::create(['name' => 'events.show']);
        Permission::create(['name' => 'events.update']);
        Permission::create(['name' => 'events.approve']);
        Permission::create(['name' => 'events.suspend']);
        Permission::create(['name' => 'events.delete']);
        Permission::create(['name' => 'events.hard-delete']);

        Permission::create(['name' => 'offers.index']);
        Permission::create(['name' => 'offers.store']);
        Permission::create(['name' => 'offers.archive']);
        Permission::create(['name' => 'offers.show']);
        Permission::create(['name' => 'offers.update']);
        Permission::create(['name' => 'offers.approve']);
        Permission::create(['name' => 'offers.suspend']);
        Permission::create(['name' => 'offers.delete']);
        Permission::create(['name' => 'offers.hard-delete']);

        Permission::create(['name' => 'profiles.index']);
        Permission::create(['name' => 'profiles.store']);
        Permission::create(['name' => 'profiles.archive']);
        Permission::create(['name' => 'profiles.show']);
        Permission::create(['name' => 'profiles.update']);
        Permission::create(['name' => 'profiles.approve']);
        Permission::create(['name' => 'profiles.suspend']);
        Permission::create(['name' => 'profiles.delete']);
        Permission::create(['name' => 'profiles.hard-delete']);

        Permission::create(['name' => 'references']);
        Permission::create(['name' => 'references.index']);
        Permission::create(['name' => 'references.store']);
        Permission::create(['name' => 'references.archive']);
        Permission::create(['name' => 'references.show']);
        Permission::create(['name' => 'references.update']);
        Permission::create(['name' => 'references.approve']);
        Permission::create(['name' => 'references.suspend']);
        Permission::create(['name' => 'references.delete']);
        Permission::create(['name' => 'references.hard-delete']);

        Permission::create(['name' => 'options']);
        Permission::create(['name' => 'options.index']);
        Permission::create(['name' => 'options.store']);
        Permission::create(['name' => 'options.archive']);
        Permission::create(['name' => 'options.show']);
        Permission::create(['name' => 'options.update']);
        Permission::create(['name' => 'options.approve']);
        Permission::create(['name' => 'options.suspend']);
        Permission::create(['name' => 'options.delete']);
        Permission::create(['name' => 'options.hard-delete']);

        Permission::create(['name' => 'settings']);
        Permission::create(['name' => 'settings.index']);
        Permission::create(['name' => 'settings.store']);
        Permission::create(['name' => 'settings.archive']);
        Permission::create(['name' => 'settings.show']);
        Permission::create(['name' => 'settings.update']);
        Permission::create(['name' => 'settings.approve']);
        Permission::create(['name' => 'settings.suspend']);
        Permission::create(['name' => 'settings.delete']);
        Permission::create(['name' => 'settings.hard-delete']);

        Permission::create(['name' => 'statistics']);
        Permission::create(['name' => 'statistics.index']);
        Permission::create(['name' => 'statistics.store']);
        Permission::create(['name' => 'statistics.archive']);
        Permission::create(['name' => 'statistics.show']);
        Permission::create(['name' => 'statistics.update']);
        Permission::create(['name' => 'statistics.approve']);
        Permission::create(['name' => 'statistics.suspend']);
        Permission::create(['name' => 'statistics.delete']);
        Permission::create(['name' => 'statistics.hard-delete']);

        $guest = Role::create(['name' => Role::GUEST]);
        $subscriber = Role::create(['name' => Role::SUBSCRIBER]);
        $user = Role::create(['name' => Role::USER]);
        $member = Role::create(['name' => Role::MEMBER]);
        $author = Role::create(['name' => Role::AUTHOR]);
        $moderator = Role::create(['name' => Role::MODERATOR]);
        $admin = Role::create(['name' => Role::ADMIN]);

        $admin->givePermissionTo(Permission::all());*/

        $guestPermissions = [
            "users.register",
            'reviews.index',
            'reviews.store'
        ];

        $subscriberPermissions = [];
        $userPermissions = [
            "users.show", "users.update", "users.delete",
            "organisations.index", "organisations.store", "organisations.show","organisations.update", "organisations.delete",
            "resumes.store", "resumes.index", "resumes.show","resumes.update", "resumes.delete",
            "events.store", "events.index", "events.show","events.update", "events.delete",
            "offers.store", "offers.index", "offers.show","offers.update", "offers.delete",
        ];
        $memberPermissions = [];
        $authorPermissions = [
            "events.alterFields.all",
            "offers.alterFields.all",
        ];
        $moderatorPermissions = [
            "dashboard.access", "dashboard.organisations", "dashboard.events", "dashboard.offers", "dashboard.users",
            "users.verify", "users.alterFields.all", "users.store", "users.index", "users.show.any", "users.update.any", "users.delete.any",
            "organisations.index.any", "organisations.show.any", "organisations.alterFields.all", "organisations.update.any", "organisations.delete.any",
            "resumes.index.any", "resumes.show.any", "resumes.alterFields.all", "resumes.update.any", "resumes.delete.any",
            "reviews.show", "reviews.show.any", "reviews.alterFields.all", "reviews.update", "reviews.update.any", "reviews.delete", "reviews.delete.any",
            "offers.index.any", "offers.show.any","offers.update.any", "offers.delete.any",
            "events.index.any", "events.show.any", "events.update.any", "events.delete.any",
        ];

        $adminPermissions = [
            "statistics.index",
            "settings.index", "settings.show", "settings.update", "settings.create", "settings.rollback", "settings.delete", "settings.hardDelete",
            "users.hardDelete",
            "resumes.hardDelete",
            "reviews.hardDelete",
            "organisations.hardDelete",
            "offers.hardDelete",
            "events.hardDelete",
        ];


        $permissionsByRole = [
            Role::GUEST => $guestPermissions,
            Role::SUBSCRIBER => $subscriberPermissions,
            Role::USER => $userPermissions,
            Role::MEMBER => $memberPermissions,
            Role::AUTHOR => $authorPermissions,
            Role::MODERATOR => $moderatorPermissions,
            Role::ADMIN => $adminPermissions,
        ];

        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(fn ($name) => DB::table('permissions')->insertGetId(['name' => $name, 'guard_name' => 'web']))
            ->toArray();

        $permissionIdsByRole = [
            Role::GUEST => $insertPermissions(Role::GUEST),
            Role::SUBSCRIBER => $insertPermissions(Role::SUBSCRIBER),
            Role::USER => $insertPermissions(Role::USER),
            Role::MEMBER => $insertPermissions(Role::MEMBER),
            Role::AUTHOR => $insertPermissions(Role::AUTHOR),
            Role::MODERATOR => $insertPermissions(Role::MODERATOR),
            Role::ADMIN => $insertPermissions(Role::ADMIN),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::findOrCreate($role);

            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(fn ($id) => [
                        'role_id' => $role->id,
                        'permission_id' => $id
                    ])->toArray()
                );
        }
    }
}
