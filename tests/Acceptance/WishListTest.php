<?php

namespace Tests\Acceptance;

use App\Wish;
use Auth;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WishListTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_the_add_wish_link()
    {
        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.index'))->seeStatusCode(200)->see('Новое желание');
    }

    /** @test */
    public function it_shows_the_wish_in_the_list()
    {
        $user = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $user->id]);
        Auth::login($user);

        $this->visit(route('wishes.index'))->seeStatusCode(200)->see($wish->name);
    }

    /** @test */
    public function it_shows_someones_list_to_unauthorized_user()
    {
        $someone = factory(User::class)->create();

        $this->visit(route('wishes.user_index', $someone->id))->seeStatusCode(200);
    }

    /** @test */
    public function it_shows_someones_wishes_to_unauthorized_user()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        $this->visit(route('wishes.user_index', $someone->id))->seeStatusCode(200)->see($wish->name);
    }

    /** @test */
    public function it_does_not_show_add_wish_link_in_someones_list_to_unauthorized_user()
    {
        $someone = factory(User::class)->create();

        $this->visit(route('wishes.user_index', $someone->id))->seeStatusCode(200)->dontSee('Новое желание');
    }

    /** @test */
    public function it_shows_someones_list_to_authorized_user()
    {
        $someone = factory(User::class)->create();
        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.user_index', $someone->id))->seeStatusCode(200);
    }

    /** @test */
    public function it_shows_someones_wishes_to_authorized_user()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.user_index', $someone->id))->seeStatusCode(200)->see($wish->name);
    }

    /** @test */
    public function it_does_not_show_add_wish_link_in_someones_list_to_authorized_user()
    {
        $someone = factory(User::class)->create();
        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.user_index', $someone->id))->seeStatusCode(200)->dontSee('Новое желание');
    }
}
