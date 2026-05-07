<?php

namespace App\Support;

use App\Services\UpdateChecker;

class Version
{
    public static function current(): string
    {
        $version = config('app.version');

        return is_string($version) && $version !== '' ? $version : '0.0.0';
    }

    public static function releaseDate(): ?string
    {
        return config('app.release_date');
    }

    public static function repository(): string
    {
        return (string) config('app.github_repo', 'AivionStudiosPlayground/bankbird');
    }

    public static function latest(): ?string
    {
        return app(UpdateChecker::class)->latestVersion();
    }

    public static function hasUpdate(): bool
    {
        $latest = self::latest();

        if ($latest === null) {
            return false;
        }

        return version_compare($latest, self::current(), '>');
    }

    public static function latestRelease(): ?array
    {
        return app(UpdateChecker::class)->latestRelease();
    }
}
