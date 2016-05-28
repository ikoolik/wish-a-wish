<?php

namespace Tests\Acceptance;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class StaticContentTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_shows_the_main_page()
    {
        $this->visit('/')->seeStatusCode(200)->see('Вишенка');
    }
}
