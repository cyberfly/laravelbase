<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    
    public function testRegister()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->visit('/register')
                ->assertSee('SIGN UP')
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('SIGN UP')
                ->visit('/logout')
                ->logout()
                ->visit('/login')
                ->assertSee('SIGN IN');    
        });
    }

    public function testViewRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('SIGN UP');
        });
    }

}
