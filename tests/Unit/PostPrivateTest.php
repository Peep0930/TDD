<?php

namespace Tests\Unit;

use App\Post;
use App\User;
use Tests\TestCase;
use App\PrivateList;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostPrivateTest extends TestCase
{
   
    use RefreshDatabase;
    use DatabaseMigrations;
    /** @test */
   public function A_Post_Can_Be_Private(){
        $Post = factory(Post::class)->create();
        $User = factory(User::class)->create();

        $Post->setPrivateFor($User);

        $this->assertCount(1,PrivateList::all());
        $this->assertEquals($Post->id,PrivateList::first()->post_id);
        $this->assertEquals($User->id,PrivateList::first()->user_id);
        $this->assertEquals(now(),PrivateList::first()->start_time);
   }

    /** @test */
    public function A_PostPrivate_Can_Be_Cancel(){
        $Post = factory(Post::class)->create();
        $User = factory(User::class)->create();

        $Post->setPrivateFor($User);
        $Post->CancelPrivate($User);

        $this->assertCount(1,PrivateList::all());
        $this->assertEquals($Post->id,PrivateList::first()->post_id);
        $this->assertEquals($User->id,PrivateList::first()->user_id);
        $this->assertEquals(now(),PrivateList::first()->start_time);
        $this->assertEquals(now(),PrivateList::first()->end_time);
    }

    /** @test */   
    public function A_Post_Can_Be_Private_Twice(){
        $this->withoutExceptionHandling();
        $Post = factory(Post::class)->create();
        $User = factory(User::class)->create();

        $Post->setPrivateFor($User);
        $Post->CancelPrivate($User);
        $Post->setPrivateFor($User);

        $this->assertCount(2,PrivateList::all());
        // dd(PrivateList::all());
        $this->assertEquals($Post->id,PrivateList::find(2)->post_id);
        $this->assertEquals($User->id,PrivateList::find(2)->user_id);
        $this->assertEquals(now(),PrivateList::find(2)->start_time);
        $this->assertNull(PrivateList::find(2)->end_time);

        $Post->CancelPrivate($User);
        $this->assertCount(2,PrivateList::all());
        $this->assertEquals($Post->id,PrivateList::find(2)->post_id);
        $this->assertEquals($User->id,PrivateList::find(2)->user_id);
        $this->assertEquals(now(),PrivateList::find(2)->start_time);
        $this->assertNotNull(PrivateList::find(2)->end_time);

    }

    //Exception @todo
    
}
