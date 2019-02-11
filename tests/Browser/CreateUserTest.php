<?php

namespace Tests\Browser;

use App\Models\SpatiePermission\WebRole;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test admin can view Create User page
     */
    public function testAdminViewCreateUser()
    {
        $admin = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('/admin/users/create')
                ->assertSee('Create User');
        });
    }

    /**
     * Test Admin can successfully create user
     */
    public function testAdminCanCreateUser()
    {
        $admin = factory(User::class)->create();

        // create role

        $role = factory(WebRole::class)->create();

        $user = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($admin, $user) {
            $browser->loginAs($admin)
                ->visit('/admin/users/create')
                ->assertSee('Create User')
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->click('.multiselect__tags')
                ->click('.multiselect__option')
                ->press('Submit')
                ->pause(1000)
                ->assertSee('Good job');
        });
    }

    /**
     * Test validation error when creating user
     */
    public function testAdminCantCreateInvalidUser()
    {
        $admin = factory(User::class)->create();

        // create role

        $role = factory(WebRole::class)->create();

        $user = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($admin, $user) {
            $browser->loginAs($admin)
                ->visit('/admin/users/create')
                ->assertSee('Create User')
                ->type('name', '')
                ->type('email', $user->name)
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret123')
                ->press('Submit')
                ->pause(1000)
                ->assertSee('Validation Error')
                ->assertSee('The Name field is required.')
                ->assertSee('The email field must be a valid email.')
                ->assertSee('The password confirmation does not match.')
                ->assertSee('The Roles field is required.');
        });
    }
}
