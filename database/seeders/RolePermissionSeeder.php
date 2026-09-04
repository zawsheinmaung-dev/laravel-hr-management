<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions
        $permissions = [

            'employee.create',
            'employee.view',
            'employee.edit',
            'employee.delete',

            'department.manage',

            'attendance.create',
            'attendance.view',
            'attendance.edit',

            'leave.request',
            'leave.approve',
            'leave.reject',

            'payroll.generate',
            'payroll.manage',
            'payroll.view',

            'report.view',

            'settings.manage',

            'role.manage',
            'permission.manage',

            // Recruitment
            'job.manage',
            'applicant.create',
            'applicant.view',
            'applicant.edit',
            'applicant.delete',
            'interview.manage',

            // Training
            'training.manage',
            'training.view',

            // Performance
            'performance.manage',
            'performance.view',
            'profile.view',
    'profile.edit',
        ];


        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }


        // Roles
        $roles = [

            'Super Admin',
            'HR Manager',
            'Department Manager',
            'Payroll Officer',
            'Recruitment Officer',
            'Employee',

        ];


        foreach ($roles as $role) {

            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }


        // Super Admin = All Permission

        $superAdmin = Role::findByName('Super Admin');

        $superAdmin->givePermissionTo(
            Permission::all()
        );

        $hrManager = Role::findByName('HR Manager');

        $hrManager->givePermissionTo([

            // Employee
            'employee.create',
            'employee.view',
            'employee.edit',
            'employee.delete',

            // Department
            'department.manage',

            // Attendance
            'attendance.view',
            'attendance.edit',

            // Leave
            'leave.approve',
            'leave.reject',

            // Reports
            'report.view',

            'attendance.create',

        ]);

        $departmentManager = Role::findByName('Department Manager');

        $departmentManager->givePermissionTo([

            'employee.view',

            'attendance.view',

            'leave.approve',

            'leave.reject',

            'report.view',

        ]);

        $payrollOfficer = Role::findByName('Payroll Officer');

        $payrollOfficer->givePermissionTo([

            'payroll.generate',
            'payroll.manage',
            'payroll.view',

            'report.view',

        ]);

        $recruitmentOfficer = Role::findByName('Recruitment Officer');

        $recruitmentOfficer->givePermissionTo([

            'job.manage',

            'applicant.create',
            'applicant.view',
            'applicant.edit',
            'applicant.delete',

            'interview.manage',

            'report.view',

        ]);


        // Employee

        $employee = Role::findByName('Employee');

        $employee->givePermissionTo([

    'profile.view',
    'profile.edit',

    'attendance.create',
    'attendance.view',

    'leave.request',

]);
    }
}
