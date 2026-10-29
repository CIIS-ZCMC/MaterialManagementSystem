<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Structural data: roles and permissions.
 * Safe to run in production (uses firstOrCreate / syncPermissions).
 */
class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear Spatie's permission cache before changing anything
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // PO (Part 1)
            'po.view',
            'po.upload-files',
            'po.generate',
            'po.review',
            'po.escalate',

            // Delivery and IAR (Parts 2-3)
            'delivery.encode',
            'delivery.upload-docs',
            'delivery.update-items',
            'iar.set-acceptance',
            'iar.approve',

            // Property documents and transmittals (Part 3)
            'par.generate',
            'ics.generate',
            'transmittal.print-iar',
            'transmittal.prepare-iar-coa',

            // DV processing and Finance (Part 4)
            'dv.review-checklist',
            'dv.prepare',
            'dv.forward',
            'finance.receive',
            'finance.return',
            'finance.mark-disbursed',

            // Cancellation (Flow A)
            'cancel.initiate',
            'cancel.finalize',
            'cancel.approve',

            // Replacement (Flow B)
            'replacement.initiate',
            'replacement.letter',
            'replacement.pullout-form',
            'replacement.receive',

            // Delay monitoring (Flow C)
            'delay.view',
            'delay.request-termination',
            'delay.terminate',

            // Admin
            'users.manage',
            'roles.manage',
            'audit.view',
            'reports.view',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Default permission set for each role.
        // The admin can still adjust permissions per user afterwards.
        $roles = [
            'Admin' => [
                'users.manage',
                'roles.manage',
                'audit.view',
                'reports.view',
                'po.view',
            ],

            'Procurement' => [
                'po.view',
                'po.upload-files',
                'po.generate',
            ],

            'MMS Staff' => [
                'po.view',
                'po.review',
                'po.escalate',
                'delivery.encode',
                'delivery.upload-docs',
                'delivery.update-items',
                'iar.set-acceptance',
                'par.generate',
                'ics.generate',
                'transmittal.print-iar',
                'transmittal.prepare-iar-coa',
                'dv.review-checklist',
                'dv.prepare',
                'dv.forward',
                'cancel.initiate',
                'cancel.finalize',
                'replacement.initiate',
                'replacement.letter',
                'replacement.pullout-form',
                'replacement.receive',
                'delay.view',
                'delay.request-termination',
                'delay.terminate',
                'reports.view',
            ],

            // View-all plus approval actions
            'MMS Head' => [
                'po.view',
                'delay.view',
                'iar.approve',
                'cancel.approve',
                'audit.view',
                'reports.view',
            ],

            'Finance' => [
                'po.view',
                'finance.receive',
                'finance.return',
                'finance.mark-disbursed',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePermissions);
        }
    }
}