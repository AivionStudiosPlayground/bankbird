<?php

namespace Tests\Feature;

use App\Services\UpdateChecker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UpdateCheckerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();
        config(['app.github_repo' => 'AivionStudiosPlayground/bankbird']);
    }

    public function test_latest_release_parses_github_response(): void
    {
        Http::fake([
            'api.github.com/repos/AivionStudiosPlayground/bankbird/releases/latest' => Http::response([
                'tag_name' => 'v1.5.2',
                'name' => 'v1.5.2 - Release notes',
                'body' => '## Wat is nieuw',
                'html_url' => 'https://github.com/AivionStudiosPlayground/bankbird/releases/tag/v1.5.2',
                'published_at' => '2026-06-01T10:00:00Z',
            ]),
        ]);

        $release = app(UpdateChecker::class)->latestRelease();

        $this->assertSame('1.5.2', $release['tag']);
        $this->assertSame('v1.5.2 - Release notes', $release['name']);
        $this->assertSame('## Wat is nieuw', $release['body']);
        $this->assertStringContainsString('v1.5.2', $release['url']);
    }

    public function test_latest_version_returns_null_on_api_failure(): void
    {
        Http::fake([
            'api.github.com/*' => Http::response(null, 503),
        ]);

        $this->assertNull(app(UpdateChecker::class)->latestVersion());
    }

    public function test_results_are_cached_to_avoid_rate_limiting(): void
    {
        Http::fake([
            'api.github.com/repos/AivionStudiosPlayground/bankbird/releases/latest' => Http::response([
                'tag_name' => 'v2.0.0',
            ]),
        ]);

        $checker = app(UpdateChecker::class);
        $checker->latestVersion();
        $checker->latestVersion();
        $checker->latestVersion();

        Http::assertSentCount(1);
    }

    public function test_clear_cache_forces_refetch(): void
    {
        Http::fake([
            'api.github.com/repos/AivionStudiosPlayground/bankbird/releases/latest' => Http::response([
                'tag_name' => 'v1.0.0',
            ]),
        ]);

        $checker = app(UpdateChecker::class);
        $checker->latestVersion();
        $checker->clearCache();
        $checker->latestVersion();

        Http::assertSentCount(2);
    }
}
