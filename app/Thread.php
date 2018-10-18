<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RecordsActivity;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function($builder){
        //     $builder->withCount('replies');
        // });

        static::deleting(function($thread){

            $thread->replies->each->delete();

            // $thread->replies->each(function($reply){

            //     $reply->delete();
            // });
        });

    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function addReply($reply)
    {
       return $this->replies()->create($reply);

        // $this->increment('replies_count');

        // return $reply;
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([

            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unSubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id' , $userId ?: auth()->id())->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }
}
