<?php

namespace Tests\Feature;

use App\Http\Middleware\BlockDemoUserOutsideDemoHost;
use App\Models\User;
use App\Support\Demo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class BlockDemoUserOutsideDemoHostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/test-protected', fn () => 'OK')
            ->middleware(['web', 'auth', BlockDemoUserOutsideDemoHost::class]);
    }

    public function test_demo_user_passes_through_on_demo_host(): void
    {
        $demoUser = User::factory()->create(['email' => Demo::USER_EMAIL]);

        $response = $this->actingAs($demoUser)
            ->get('http://demo.bankbird.app/test-protected');

        $response->assertStatus(200);
        $response->assertSee('OK');
        $this->assertTrue(auth()->check());
    }

    public function test_demo_user_is_logged_out_and_redirected_on_other_host(): void
    {
        $demoUser = User::factory()->create(['email' => Demo::USER_EMAIL]);

        $response = $this->actingAs($demoUser)
            ->get('http://dev.bankbird.app/test-protected');

        $response->assertRedirect('https://demo.bankbird.app/');
        $this->assertFalse(auth()->check());
    }

    public function test_regular_user_is_unaffected_on_dev_host(): void
    {
        $regularUser = User::factory()->create(['email' => 'regular@example.com']);

        $response = $this->actingAs($regularUser)
            ->get('http://dev.bankbird.app/test-protected');

        $response->assertStatus(200);
        $response->assertSee('OK');
        $this->assertTrue(auth()->check());
    }
}
