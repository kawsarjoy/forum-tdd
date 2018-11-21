<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Spam;

class SpamTest extends TestCase
{

    //use DatabaseMigrations;
    
    /** @test */
    public function it_validates_spam()
    {
        $spam = new Spam();


        $this->assertFalse($spam->detect('Innocent Reply'));
    }
}
