<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function unauthenticated_users_may_not_added_replies()
    {
        $this->withExceptionHandling()
             ->post('threads/channel-slug/1/replies', [])
             ->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_may_participated_in_forum_threads()
    {
        $this->be(factory('App\User')->create());

        $reply = factory('App\Reply')->make();

        $this->post($this->thread->path() . '/replies', $reply->toArray());

        $this->get($this->thread->path())
             ->assertSee($reply->body);
    }
}
