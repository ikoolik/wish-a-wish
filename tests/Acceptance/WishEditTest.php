<?php

namespace Tests\Acceptance;

use App\User;
use App\Wish;
use Auth;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WishEditTest extends TestCase
{
    use DatabaseTransactions;

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

    /** @test */
    public function it_changes_name_and_description()
    {
        $user = factory(User::class)->create();
        $wish = factory(Wish::class)->create(['user_id' => $user->id]);
        Auth::login($user);

        $name = $this->faker->title;
        $description = $this->faker->sentence();

        $this->visit(route('wishes.edit', $wish->id))
            ->seeStatusCode(200)
            ->type($name, 'name')
            ->type($description, 'description')
            ->see('Сохранить')
            ->press('Сохранить')
            ->seePageIs(route('wishes.show', $wish->id))
            ->dontSee($wish->name)
            ->dontSee($wish->description)
            ->see($name)
            ->see($description);
    }
}
