<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use App\Mail\AssetBorrowRequestMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetBorrowedEmp extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
