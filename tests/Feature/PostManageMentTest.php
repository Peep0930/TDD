<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostManageMentTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    /** @test */
    public function New_Post_can_Be_add(){
        //$this->withoutExceptionHandling();
        $response = $this->json('post','/Posts',$this->data());
        // $response->assertOk();
        $response->assertRedirect(Post::first()->path());

        $this->assertCount(1,Post::all());  
    }

    /** @test */
    public function a_title_is_required(){
        //$this->withoutExceptionHandling();

        $response = $this->json('post','/Posts',array_merge($this->data(), ['title' => '']));
        $response->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function a_post_can_update(){
        // $this->withoutExceptionHandling();

        $this->json('post','/Posts',$this->data());
        $Post = Post::first();
        $response = $this->json('patch',$Post->path(),array_merge($this->data(),['user_id' => 'Kelly','title' => 'New Title']));
        $this->assertEquals(2,$Post->fresh()->user_id);
        $response->assertRedirect($Post->fresh()->path());
    }

    /** @test */
    public function a_post_can_be_delete(){
        $this->withoutExceptionHandling();
        $this->json('POST','/Posts',$this->data());
        $this->assertCount(1,Post::all());

        
        $response = $this->json('DELETE',Post::first()->path());
        $this->assertCount(0,Post::all());
        
        $response->assertRedirect('/Posts');
    }

    //Cos the test data is same, so use A function to mang
    private function data(){
        return [
            'title' => 'A Great Post System',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
            'user_id' => 'Elliot',
        ];
    }
}
