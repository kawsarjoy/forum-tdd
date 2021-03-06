<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInThreadsTest extends TestCase
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

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $this->thread->fresh()->replies_count);
    }

    /** @test */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
    
        $this->post($this->thread->path() . '/replies', ['body' => null])
             ->assertSessionHasErrors('body');
    }

    /** @test */
    function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
             ->assertRedirect('login');

        $this->signIn()
             ->delete("/replies/{$reply->id}")
             ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}");

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
             ->assertRedirect('login');

        $this->signIn()
             ->patch("/replies/{$reply->id}")
             ->assertStatus(403);
    }

    /** @test */
    function authorized_user_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'You have been changed, fool';

        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id,'body' => $updatedReply]);

    }

    /** @test */
    function replies_that_contain_spam_may_not_be_participated()
    {
        $this->be(factory('App\User')->create());

        $reply = factory('App\Reply')->make([

            'body' => 'Yahoo Customer Support'
        ]);

        $this->post($this->thread->path() . '/replies', $reply->toArray())
             ->assertStatus(422);


    }

    /** @test */
    function users_may_only_reply_a_maximum_once_per_minute()
    {
        $this->be(factory('App\User')->create());

        $reply = factory('App\Reply')->make([

            'body' => 'A Simply Reply'
        ]);

        $this->post($this->thread->path() . '/replies', $reply->toArray())
             ->assertStatus(200);

        $this->post($this->thread->path() . '/replies', $reply->toArray())
             ->assertStatus(422);

    }
}
