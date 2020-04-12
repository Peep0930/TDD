<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
   /** @test */
    use RefreshDatabase;
    use DatabaseMigrations;
    public function A_Auth_ID_is_recorded(){
        $this->withoutExceptionHandling();
        Post::Create([
            'title' => 'A title For Test',
            'date' => \Carbon\Carbon::today()->format('Y-m-d'),
            'content' => 'Test Content.....',
            'is_Public' => true,
            'user_id' => 1,
        ]);
        $this->assertCount(1,Post::all());
    }
}
