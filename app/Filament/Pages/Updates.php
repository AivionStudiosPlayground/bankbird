<?php

namespace App\Filament\Pages;

use App\Support\Version;
use Filament\Pages\Page;
use Illuminate\Support\Str;

class Updates extends Page
{
    protected string $view = 'filament.pages.updates';

    protected static ?string $navigationLabel = 'Updates';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static string|\UnitEnum|null $navigationGroup = 'Beheer';

    protected static ?int $navigationSort = 90;

    protected static ?string $title = 'Updates';

    public function getCurrentVersion(): string
    {
        return Version::current();
    }

    public function getReleaseDate(): ?string
    {
        return Version::releaseDate();
    }

    public function getLatestRelease(): ?array
    {
        return rescue(fn () => Version::latestRelease(), null, false);
    }

    public function hasUpdate(): bool
    {
        return rescue(fn () => Version::hasUpdate(), false, false);
    }

    public function getRepositoryUrl(): string
    {
        return 'https://github.com/'.Version::repository();
    }

    public function getUpdatePrompt(): string
    {
        return 'Update BankBird ('.$this->getRepositoryUrl().') voor me.';
    }

    public function getReleaseNotesHtml(): ?string
    {
        $release = $this->getLatestRelease();

        if ($release === null || ($release['body'] ?? '') === '') {
            return null;
        }

        return Str::markdown($release['body']);
    }
}
