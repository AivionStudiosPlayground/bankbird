<?php

namespace Tests\Unit;

use App\Support\Demo;
use Illuminate\Http\Request;
use Tests\TestCase;

class DemoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.home_host' => 'bankbird.app',
            'app.demo_host' => 'demo.bankbird.app',
            'app.local_host' => 'bankbird.app.test',
        ]);
    }

    private function fakeRequest(string $host, string $path = '/'): void
    {
        $this->app->instance('request', Request::create('http://'.$host.$path));
    }

    public function test_production_marketing_host_is_marketing_site(): void
    {
        $this->fakeRequest('bankbird.app', '/');

        $this->assertTrue(Demo::isMarketingSite());
        $this->assertFalse(Demo::active());
        $this->assertFalse(Demo::isLocalCombined());
    }

    public function test_production_demo_host_is_active(): void
    {
        $this->fakeRequest('demo.bankbird.app', '/');

        $this->assertTrue(Demo::active());
        $this->assertFalse(Demo::isMarketingSite());
        $this->assertSame('', Demo::panelPath());
    }

    public function test_production_other_host_uses_root_panel_path(): void
    {
        $this->fakeRequest('dev.bankbird.app', '/');

        $this->assertFalse(Demo::active());
        $this->assertFalse(Demo::isMarketingSite());
        $this->assertSame('', Demo::panelPath());
    }

    public function test_marketing_host_keeps_admin_panel_path(): void
    {
        $this->fakeRequest('bankbird.app', '/admin');

        $this->assertTrue(Demo::isMarketingSite());
        $this->assertSame('admin', Demo::panelPath());
    }

    public function test_panel_url_resolves_per_host(): void
    {
        $this->fakeRequest('bankbird.app', '/');
        $this->assertSame(url('/admin/updates'), Demo::panelUrl('updates'));

        $this->fakeRequest('demo.bankbird.app', '/');
        $this->assertSame(url('/updates'), Demo::panelUrl('updates'));

        $this->fakeRequest('selfhosted.example.com', '/');
        $this->assertSame(url('/updates'), Demo::panelUrl('updates'));

        $this->fakeRequest('bankbird.app.test', '/dev');
        $this->assertSame(url('/dev/updates'), Demo::panelUrl('updates'));
    }

    public function test_local_host_root_serves_marketing(): void
    {
        $this->fakeRequest('bankbird.app.test', '/');

        $this->assertTrue(Demo::isMarketingSite());
        $this->assertFalse(Demo::active());
        $this->assertTrue(Demo::isLocalCombined());
    }

    public function test_local_host_demo_path_is_demo_panel(): void
    {
        $this->fakeRequest('bankbird.app.test', '/demo');

        $this->assertTrue(Demo::active());
        $this->assertFalse(Demo::isMarketingSite());
        $this->assertSame('demo', Demo::panelPath());
    }

    public function test_local_host_demo_subpath_is_demo_panel(): void
    {
        $this->fakeRequest('bankbird.app.test', '/demo/login');

        $this->assertTrue(Demo::active());
        $this->assertFalse(Demo::isMarketingSite());
    }

    public function test_local_host_dev_path_is_admin_panel(): void
    {
        $this->fakeRequest('bankbird.app.test', '/dev');

        $this->assertFalse(Demo::active());
        $this->assertFalse(Demo::isMarketingSite());
        $this->assertSame('dev', Demo::panelPath());
    }

    public function test_local_host_dev_subpath_is_admin_panel(): void
    {
        $this->fakeRequest('bankbird.app.test', '/dev/users');

        $this->assertFalse(Demo::active());
        $this->assertFalse(Demo::isMarketingSite());
    }

    public function test_local_host_other_marketing_path_is_marketing(): void
    {
        $this->fakeRequest('bankbird.app.test', '/install');

        $this->assertTrue(Demo::isMarketingSite());
        $this->assertFalse(Demo::active());
    }

    public function test_local_combined_disabled_when_local_host_blank(): void
    {
        config(['app.local_host' => null]);
        $this->fakeRequest('bankbird.app.test', '/demo');

        $this->assertFalse(Demo::isLocalCombined());
        $this->assertFalse(Demo::active());
        $this->assertFalse(Demo::isMarketingSite());
    }

    public function test_path_prefix_does_not_match_similar_segment(): void
    {
        $this->fakeRequest('bankbird.app.test', '/development');

        $this->assertFalse(Demo::active());
        $this->assertTrue(Demo::isMarketingSite());
    }
}
