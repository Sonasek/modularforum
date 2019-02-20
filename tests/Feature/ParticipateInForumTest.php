<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unautenticated_user_may_participate_in_forum_threads(){
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();
        $this->post('/threads/1/replies', []);
    }

    /** @test */
    public function an_autenticated_user_may_participate_in_forum_threads(){
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}
