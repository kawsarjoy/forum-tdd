<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RecordsActivity;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
