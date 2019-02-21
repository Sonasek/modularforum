<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_cannot_see_the_create_thread_page(){
        $this->get('threads/create')
            ->assertRedirect('/login');
    }


    /** @test */
    function a_guests_may_not_create_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}
