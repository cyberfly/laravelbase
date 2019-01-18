<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\User;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testViewRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertSee('SIGN UP');
        });
    }
    
    public function testUserCanRegister()
    {
        $user = factory(User::class)->make();

        $this->browse(function (Browser $browser) use ($user) {
            $browser
                ->visit('/register')
                ->assertSee('SIGN UP')
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('SIGN UP')
                ->logout();
        });
    }

}
