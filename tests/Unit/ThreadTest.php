<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Notifications\ThreadWasUpdated;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_thread_can_have_a_string_path()
    {
        $this->assertEquals(
            "/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path()
        );
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'foo',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    function a_threas_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        \Notification::fake();

        $this->signIn()

             ->thread

             ->subscribe()

             ->addReply([

                'body' => 'foo',
                'user_id' => 54894899

            ]);

        \Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);

    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    /** @test */
    function a_thread_can_be_subscribe_to()
    {
        $this->thread->subscribe($userId = 1);

        $this->assertEquals(1, $this->thread->subscriptions()->where('user_id', $userId)->count());
    }
    
    /** @test */
    function a_thread_can_be_unsubscribe_from()
    {
        $this->thread->subscribe($userId = 1);

        $this->thread->unSubscribe($userId);

        $this->assertCount(0, $this->thread->subscriptions);
    }

    /** @test */
    function it_knows_if_a_subscribe_user_is_subscribe_to_it()
    {
        $this->signIn();

        $this->assertFalse($this->thread->isSubscribedTo);


        $this->thread->subscribe();

        $this->assertTrue($this->thread->isSubscribedTo);
    }

    /** @test */
    function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();

        tap(auth()->user(), function($user){


            $this->assertTrue($this->thread->hasUpdatesFor($user));

            $user->read($this->thread);
    
            $this->assertFalse($this->thread->hasUpdatesFor($user));

        });

    }
}
