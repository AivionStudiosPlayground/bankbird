<?php

namespace App\Services;

use App\Support\Version;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UpdateChecker
{
    private const CACHE_KEY = 'bankbird.latest_release';

    private const CACHE_TTL_SECONDS = 3600;

    /**
     * @return array{tag: string, name: string, body: string, url: string, published_at: string}|null
     */
    public function latestRelease(): ?array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
            $repo = Version::repository();

            $response = Http::timeout(5)
                ->withHeaders(['Accept' => 'application/vnd.github+json'])
                ->get("https://api.github.com/repos/{$repo}/releases/latest");

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();

            return [
                'tag' => ltrim((string) ($data['tag_name'] ?? ''), 'v'),
                'name' => (string) ($data['name'] ?? ''),
                'body' => (string) ($data['body'] ?? ''),
                'url' => (string) ($data['html_url'] ?? ''),
                'published_at' => (string) ($data['published_at'] ?? ''),
            ];
        });
    }

    public function latestVersion(): ?string
    {
        $release = $this->latestRelease();

        return $release === null ? null : ($release['tag'] ?: null);
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
