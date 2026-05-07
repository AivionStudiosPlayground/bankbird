<?php

namespace Tests\Unit;

use App\Services\UpdateChecker;
use App\Support\Version;
use Mockery;
use Tests\TestCase;

class VersionTest extends TestCase
{
    public function test_current_returns_configured_version(): void
    {
        config(['app.version' => '1.2.3']);

        $this->assertSame('1.2.3', Version::current());
    }

    public function test_current_falls_back_to_zero_when_unconfigured(): void
    {
        config(['app.version' => null]);

        $this->assertSame('0.0.0', Version::current());
    }

    public function test_repository_returns_configured_repo(): void
    {
        config(['app.github_repo' => 'foo/bar']);

        $this->assertSame('foo/bar', Version::repository());
    }

    public function test_has_update_returns_true_when_remote_is_newer(): void
    {
        config(['app.version' => '1.0.0']);
        $this->mockUpdateCheckerLatest('1.1.0');

        $this->assertTrue(Version::hasUpdate());
    }

    public function test_has_update_returns_false_when_local_matches_remote(): void
    {
        config(['app.version' => '1.0.0']);
        $this->mockUpdateCheckerLatest('1.0.0');

        $this->assertFalse(Version::hasUpdate());
    }

    public function test_has_update_returns_false_when_local_is_newer(): void
    {
        config(['app.version' => '2.0.0']);
        $this->mockUpdateCheckerLatest('1.0.0');

        $this->assertFalse(Version::hasUpdate());
    }

    public function test_has_update_returns_false_when_remote_is_unreachable(): void
    {
        config(['app.version' => '1.0.0']);
        $this->mockUpdateCheckerLatest(null);

        $this->assertFalse(Version::hasUpdate());
    }

    private function mockUpdateCheckerLatest(?string $version): void
    {
        $mock = Mockery::mock(UpdateChecker::class);
        $mock->shouldReceive('latestVersion')->andReturn($version);
        $this->app->instance(UpdateChecker::class, $mock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
