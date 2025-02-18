<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        Vite::fake([
            'resources/js/app.js' => '',
            'resources/js/Pages/Welcome.vue' => '',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
