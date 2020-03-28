<?php

namespace Tests\Feature;

use App\Post;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    /** @test */
    public function New_Post_can_Be_add(){
        //$this->withoutExceptionHandling();
        $response = $this->json('post','/CreatePost',[
            'title' => '逗狗樂園 POS點餐系統',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);
        $response->assertOk();
        $this->assertCount(1,Post::all());  
    }

    /** @test */
    public function a_title_is_required(){
        //$this->withoutExceptionHandling();

        $response = $this->json('post','/CreatePost',[
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

        $this->json('post','/CreatePost',[
            'title' => '逗狗樂園 POS點餐系統',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);

        $this->json('patch','/UpdatePost/'.Post::first()->id,[
            'title'=>'New Title',
            'date' => Carbon::today()->format('Y-m-d'),
            'content' => '前台點餐Vue 發票上傳 列印發票Ｃ＃',
            'url' => 'www.google.com',
            'Is_Public' => true,
        ]);

        $this->assertEquals('New Title',Post::first()->title);
    }
}
