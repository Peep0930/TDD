<?php

namespace Tests\Feature;

use App\Post;
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
        $response = $this->json('post','/Posts',[
            'title' => 'A Great Post System',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);
        // $response->assertOk();
        $response->assertRedirect(Post::first()->path());

        $this->assertCount(1,Post::all());  
    }

    /** @test */
    public function a_title_is_required(){
        //$this->withoutExceptionHandling();

        $response = $this->json('post','/Posts',[
            'title' => '',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);
        $response->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function a_post_can_update(){
        // $this->withoutExceptionHandling();

        $this->json('post','/Posts',[
            'title' => 'A Great Post System',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);
        $Post = Post::first();
        $response = $this->json('patch',$Post->path(),[
            'title'=>'New Title',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);

        $this->assertEquals('New Title',$Post->fresh()->title);
        $response->assertRedirect($Post->fresh()->path());
    }

    /** @test */
    public function a_post_can_be_delete(){
        $this->withoutExceptionHandling();
        $this->json('POST','/Posts',[
            'title' => 'A Great Post System',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);
        $this->assertCount(1,Post::all());

        
        $response = $this->json('DELETE',Post::first()->path());
        $this->assertCount(0,Post::all());
        
        $response->assertRedirect('/Posts');
    }
}
