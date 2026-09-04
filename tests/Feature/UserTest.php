<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_user_index(): void
    {
        $user = User::factory()->create();
        $resp = $this->actingAs($user)->get(route('users.index'));
        $resp->assertStatus(200);
    }

    public function user_create() : void
    {
        $user = User::factory()->create();
        $resp = $this->actingAs($user)->post(route('users.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'roles' => ['Employee'],
        ]);

        $resp->assertRedirect();;
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function user_update(): void
    {
        $admin=User::factory()->create();
        $user=User::factory()->create();
        $resp =$this->actingAs($admin)->put(route('users.update'),[
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '',
            'password_confirmation' => '',
            'roles' => ['Employee'],
        ]);
        $resp->assertRedirect();
        $this->assertDatabaseHas('users',[
            'id'=>$user->id,
            'name' => 'John',
        ]);

    }

    public function user_delete(): void
    {
        $admin=User::factory()->create();
        $user=User::factory()->create();
        $resp =$this->actingAs($admin)->delete(route('users.destroy',$user));
        $resp->assertRedirect();
        $this->assertDatabaseMissing('users',[
            'id'=>$user->id
        ]);
    }
}
