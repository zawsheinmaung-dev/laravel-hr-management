<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_role()
    {
        $this->seed();
        $this->assertDatabaseHas('roles',[
            'name'=>'Super Admin'
        ]);
        $this->assertDatabaseHas('roles',[
            'name'=>'HR Manager'
        ]);
        $this->assertDatabaseHas('roles',[
            'name'=>'Department Manager'
        ]);
        $this->assertDatabaseHas('roles',[
            'name'=>'Payroll Officer'
        ]);
        $this->assertDatabaseHas('roles',[
            'name'=>'Recruitment Officer'
        ]);
        $this->assertDatabaseHas('roles',[
            'name'=>'Employee'
        ]);
    }

    public function test_permissions()
    {
        $this->seed();
        $role =Role::findByName('Super Admin');
        $allPermissions =Permission::all();

        foreach($allPermissions as $permission)
            {
                // $this->assertTrue(
                //     $role->hasPermissionTo($permission),
                // "Missing Permission: {$permission->name}"
                // );
                $this->assertCount(Permission::count(),$role->permissions);

            }
        
    }

    
}
