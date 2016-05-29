<?php

namespace Tests\Acceptance;

use App\User;
use App\Wish;
use Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WishCreateTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_create_form_to_authorized_user()
    {
        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.create'))
            ->seeStatusCode(200)
            ->seePageIs(route('wishes.create'))
            ->see('Сохранить');
    }

    /** @test */
    public function it_does_not_show_create_form_to_unauthorized_user()
    {
        $this->visit(route('wishes.create'))
            ->seePageIs(url('/login'));
    }

    /** @test */
    public function it_creates_wish()
    {
        Auth::login(factory(User::class)->create());

        $name = $this->faker->name;
        $description = $this->faker->sentence();
        $this->visit(route('wishes.create'))
            ->type($name, 'name')
            ->type($description, 'description')
            ->press('Сохранить')
            ->seePageIs(route('wishes.index'))
            ->see($name);
    }

    /** @test */
    public function it_redirects_unauthorized_post_to_login_screen()
    {
        $this->post(route('wishes.store'))
            ->followRedirects()
            ->seePageIs(url('/login'));
    }
}
