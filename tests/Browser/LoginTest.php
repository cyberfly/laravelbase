<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    public function testLogin()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->visit('/login')
                ->assertSee('SIGN IN')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOGIN')
                ->visit('/logout')
                ->logout()
                ->visit('/login')
                ->assertSee('SIGN IN');    
        });
    }

    public function testViewLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('SIGN IN');
        });
    }
}
