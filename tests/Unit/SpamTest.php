<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Inspections\Spam;

class SpamTest extends TestCase
{

    //use DatabaseMigrations;
    
    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();


        $this->assertFalse($spam->detect('Innocent Reply'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_checks_for_any_key_held_down()
    {
        $spam = new Spam();
        
        $this->expectException('Exception');

        $spam->detect('fsdffffffffffffffffffff');
    }
}
