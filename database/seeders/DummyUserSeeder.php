<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * DEMO DATA ONLY. Refuses to run in production.
 * Requires RolePermissionSeeder to have run first (roles must exist).
 */
class DummyUserSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->command->error('Dummy users cannot be seeded in production.');
            return;
        }

        // [employee_no, name, email, position, role]
        $users = [
            ['DUMMY-0001', 'Dummy Admin',       'admin@example.test',       'System Admin',      'Admin'],
            ['DUMMY-0002', 'Dummy Procurement', 'procurement@example.test', 'Procurement Staff', 'Procurement'],
            ['DUMMY-0003', 'Dummy MMS Staff A', 'mms.a@example.test',       'MMS Staff',         'MMS Staff'],
            ['DUMMY-0004', 'Dummy MMS Staff B', 'mms.b@example.test',       'MMS Staff',         'MMS Staff'],
            ['DUMMY-0005', 'Dummy MMS Staff C', 'mms.c@example.test',       'MMS Staff',         'MMS Staff'],
            ['DUMMY-0006', 'Dummy MMS Head',    'mmshead@example.test',     'MMS Head',          'MMS Head'],
            ['DUMMY-0007', 'Dummy Finance',     'finance@example.test',     'Finance Cashier',   'Finance'],
        ];

        foreach ($users as [$employeeNo, $name, $email, $position, $role]) {
            $user = User::updateOrCreate(
                ['employee_no' => $employeeNo],
                [
                    'name'              => $name,
                    'email'             => $email,
                    'position'          => $position,
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active'         => true,
                ]
            );

            $user->syncRoles([$role]);
        }

        $this->command->info('Dummy users seeded. Default password for all: "password"');
    }
}