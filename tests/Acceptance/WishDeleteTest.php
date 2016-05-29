<?php

namespace Tests\Acceptance;

use App\User;
use App\Wish;
use Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WishDeleteTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_delete_button_to_owner_on_show_page()
    {
        $user = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $user->id]);
        Auth::login($user);

        $this->visit(route('wishes.show', $wish->id))
            ->seeStatusCode(200)
            ->see("Удалить");
    }

    /** @test */
    public function it_does_not_show_delete_button_to_unauthorized()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        $this->visit(route('wishes.show', $wish->id))
            ->seeStatusCode(200)
            ->dontSee("Удалить");
    }

    /** @test */
    public function it_does_not_show_someones_delete_button_to_authorized()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.show', $wish->id))
            ->seeStatusCode(200)
            ->dontSee("Удалить");
    }

    /** @test */
    public function delete_button_deletes_the_wish()
    {
        $user = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $user->id]);
        Auth::login($user);

        $this->visit(route('wishes.show', $wish->id))
            ->seeInDatabase('wishes', $wish->toArray())
            ->press("Удалить")
            ->seePageIs(route('wishes.index'))
            ->dontSee($wish->name)
            ->dontSeeInDatabase('wishes', $wish->toArray());
    }

    /** @test */
    public function it_returns_403_to_unauthorized_destroy_attempt()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        $this->delete(route('wishes.destroy', $wish->id))
            ->seeStatusCode(403)
            ->seeInDatabase('wishes', $wish->toArray());
    }

    /** @test */
    public function it_returns_403_to_someones_put_attempt()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        Auth::login(factory(User::class)->create());

        $this->delete(route('wishes.destroy', $wish->id))
            ->seeStatusCode(403)
            ->seeInDatabase('wishes', $wish->toArray());
    }
}
