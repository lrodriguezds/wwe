<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoutesTest extends TestCase
{
    
    public function testLandingPageRoute()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testLoginPageRoute()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testRegistrationPageRoute()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testVideosPageRoute()
    {
        $response = $this->get('/videos');
        $response->assertStatus(302);
    }

    public function testVideoUploadPageRoute()
    {
        $response = $this->get('/videos/create');
        $response->assertStatus(302);
    }

}
