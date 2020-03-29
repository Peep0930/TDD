<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthMangeMentTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    /** @test */
    public function a_user_can_be_create(){
        $this->withoutExceptionHandling();
        $response = $this->json('POST','/Users',[
            'account' => 'AAA@gmail.com',
            'password' => '123456',
            'name' => 'Elliot',
            'Is_Admin' => 1
        ]);
        $this->assertCount(1,User::all());
        $User = User::first();
        $this->assertInstanceOf(Carbon::class,$User->created_at);
        $this->assertEquals('2020',$User->created_at->format('Y'));

    }
}
