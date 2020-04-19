<?php

namespace Tests\Feature;

use App\PrivateList;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Post;
use App\User;
class PostPrivateTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    /** @test */
    public function A_Auth_Can_Private_Post(){
        $this->withoutExceptionHandling();
        $Post = factory(Post::class)->create();
        $this->actingAs($User = factory(User::class)->create())
            ->post('/Private/'.$Post->id);

        $this->assertCount(1,PrivateList::all());
        $this->assertEquals($Post->id,PrivateList::first()->post_id);
        $this->assertEquals($User->id,PrivateList::first()->user_id);
        $this->assertEquals(now(),PrivateList::first()->start_time);
    }

    /** @test */
    public function No_login_cannot_private_post(){
        //$this->withoutExceptionHandling();
        $Post = factory(Post::class)->create();
        $this->post('/Private/'.$Post->id)->assertRedirect('/login');
        $this->assertCount(0,PrivateList::all());
    }
    /** @test */
    public function only_really_post_can_private(){
        $this->actingAs($User = factory(User::class)->create())
            ->post('/Private/'.'123')
            ->assertStatus(404);
        $this->assertCount(0,PrivateList::all());
    }

    /** @test */
    public function a_post_can_be_cancel_private(){
        $this->withoutExceptionHandling();
        $Post = factory(Post::class)->create();
        $User = factory(User::class)->create();
        $this->actingAs($User)
            ->post('/Private/'.$Post->id);

        $this->actingAs($User)
            ->post('/CancelPrivate/'.$Post->id);

        $this->assertCount(1,PrivateList::all());
        $this->assertEquals($Post->id,PrivateList::first()->post_id);
        $this->assertEquals($User->id,PrivateList::first()->user_id);
        $this->assertEquals(now(),PrivateList::first()->start_time);
        $this->assertEquals(now(),PrivateList::first()->end_time);
    }

    /** @test */
    public function only_login_can_be_cancel_private()
    {
        //$this->withoutExceptionHandling();
        $Post = factory(Post::class)->create();
        $User = factory(User::class)->create();
        $this->actingAs($User)
            ->post('/Private/'.$Post->id);
        Auth::logout();
        $this->post('/CancelPrivate/'.$Post->id)
        ->assertRedirect('/login');

        $this->assertCount(1,PrivateList::all());
        $this->assertEquals(now(),PrivateList::first()->start_time);
    }

    /** @test */
    public function A_404_is_thrown_by_no_Private_first()
    {
        $Post = factory(Post::class)->create();
        $User = factory(User::class)->create();

        $this->actingAs($User)
            ->post('/CancelPrivate/'.$Post->id)
            ->assertStatus(404);
        $this->assertCount(0,PrivateList::all());
    }
}
