<?php

namespace App\Console\Commands;

use App\Models\Merchant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class CacheMerchantLogos extends Command
{
    protected $signature = 'merchants:cache-logos
                            {--connection= : Database-connection (bv. sqlite_dev)}
                            {--force : Hercache ook merchants die al een lokaal pad hebben}';

    protected $description = "Download merchant-logo's en sla ze lokaal op in public/images/merchants/";

    public function handle(): int
    {
        $connection = $this->option('connection');
        $force = (bool) $this->option('force');

        $directory = public_path('images/merchants');
        File::ensureDirectoryExists($directory);

        $query = $connection
            ? Merchant::on($connection)
            : Merchant::query();

        $merchants = $query->orderBy('name')->get();

        $this->info("Logo-cache voor {$merchants->count()} merchants → {$directory}");
        $this->newLine();

        $cached = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($merchants as $merchant) {
            $current = (string) $merchant->getRawOriginal('logo_url');

            if (! $force && str_starts_with($current, '/images/merchants/')) {
                $this->line("  <fg=cyan>~</> {$merchant->name} <fg=gray>(al lokaal)</>");
                $skipped++;

                continue;
            }

            if (! str_starts_with($current, 'http://') && ! str_starts_with($current, 'https://')) {
                $this->line("  <fg=gray>—</> {$merchant->name} <fg=gray>(geen externe logo_url)</>");
                $skipped++;

                continue;
            }

            $localPath = $this->download($current, $merchant->normalized_name, $directory);

            if ($localPath === null) {
                $this->line("  <fg=red>✗</> {$merchant->name} <fg=gray>(download mislukt)</>");
                $failed++;

                continue;
            }

            $merchant->forceFill(['logo_url' => $localPath])->save();
            $this->line("  <fg=green>✓</> {$merchant->name} <fg=gray>→ {$localPath}</>");
            $cached++;
        }

        $this->newLine();
        $this->info("Klaar: {$cached} gecached, {$skipped} overgeslagen, {$failed} mislukt");

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function download(string $url, string $slug, string $directory): ?string
    {
        try {
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'BankBird/1.0 (logo cache)'])
                ->get($url);
        } catch (\Throwable) {
            return null;
        }

        if (! $response->successful()) {
            return null;
        }

        $extension = $this->resolveExtension($response->header('Content-Type'), $url);
        $filename = "{$slug}.{$extension}";
        $absolutePath = $directory.DIRECTORY_SEPARATOR.$filename;

        File::put($absolutePath, $response->body());

        return "/images/merchants/{$filename}";
    }

    private function resolveExtension(?string $contentType, string $url): string
    {
        $type = strtolower((string) $contentType);

        return match (true) {
            str_contains($type, 'svg') => 'svg',
            str_contains($type, 'jpeg'), str_contains($type, 'jpg') => 'jpg',
            str_contains($type, 'webp') => 'webp',
            str_contains($type, 'gif') => 'gif',
            str_contains($type, 'ico') => 'ico',
            default => str_ends_with(strtolower($url), '.svg') ? 'svg' : 'png',
        };
    }
}
