<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CerberusTest extends TestCase
{

    use RefreshDatabase;

    /***
     * @return void
     */
    public function test_that_permissions_are_properly_registered()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user);

        $this->assertTrue(\Auth::user()->can('dashboard'));
        $this->assertFalse(\Auth::user()->can('users-destroy'));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_get_a_list_of_all_permissions()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cerberus.authorizations'));

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_an_unauthenticated_user_can_not_get_a_list_of_all_permissions()
    {
        $response = $this->get(route('cerberus.authorizations'));

        $response->assertRedirect(route('login'));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_request_check_of_its_own_permissions()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cerberus.authorizations.check', ['ability' => 'dashboard']));

        $this->assertFalse(json_decode($response->getContent()));
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function test_an_unauthenticated_user_can_not_request_check_of_its_own_permissions()
    {
        $response = $this->get(route('cerberus.authorizations.check', ['ability' => 'dashboard']));

        $response->assertRedirect(route('login'));
    }
}
