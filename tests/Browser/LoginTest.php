<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\User;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testViewLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/login')
                ->assertSee('SIGN IN');
        });
    }

    public function testValidUserCanLogin()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->visit('/login')
                ->assertSee('SIGN IN')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('LOGIN')
                ->assertSee('Dashboard')
                ->logout();
        });
    }

    public function testInvalidUserCantLogin()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->visit('/login')
                ->assertSee('SIGN IN')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('LOGIN')
                ->assertSee('These credentials do not match our records');
        });
    }
}
