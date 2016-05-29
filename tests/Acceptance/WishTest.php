<?php

namespace Tests\Acceptance;

use App\Wish;
use Auth;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WishTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_wish_to_owner()
    {
        $user = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $user->id]);
        Auth::login($user);

        $this->visit(route('wishes.show', $wish->id))
            ->seeStatusCode(200)
            ->see($wish->name)
            ->see($wish->description)
            ->see('Изменить')
            ->see('Удалить');
    }

    /** @test */
    public function it_shows_someones_wish_to_unauthorized_user()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        $this->visit(route('wishes.show', $wish->id))
            ->seeStatusCode(200)
            ->see($wish->name)
            ->see($wish->description)
            ->dontSee('Изменить')
            ->dontSee('Удалить');
    }

    /** @test */
    public function it_shows_someones_wish_to_authorized_user()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);
        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.show', $wish->id))
            ->seeStatusCode(200)
            ->see($wish->name)
            ->see($wish->description)
            ->dontSeeLink('Изменить')
            ->dontSee('Удалить');
    }

    /** @test */
    public function it_shows_edit_form_to_owner()
    {
        $user = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $user->id]);
        Auth::login($user);

        $this->visit(route('wishes.edit', $wish->id))
            ->seeStatusCode(200)
            ->see($wish->name)
            ->see($wish->description)
            ->see('Сохранить');
    }

    /** @test */
    public function it_does_not_show_edit_form_to_unauthorized_user()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        $this->visit(route('wishes.edit', $wish->id))
            ->see($wish->name)
            ->see($wish->description)
            ->seePageIs(route('wishes.show', $wish->id))
            ->see('Ошибка!');
    }

    /** @test */
    public function it_does_not_show_edit_form_to_authorized_user()
    {
        $someone = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $someone->id]);

        Auth::login(factory(User::class)->create());

        $this->visit(route('wishes.edit', $wish->id))
            ->see($wish->name)
            ->see($wish->description)
            ->seePageIs(route('wishes.show', $wish->id))
            ->see('Ошибка!');
    }
}
