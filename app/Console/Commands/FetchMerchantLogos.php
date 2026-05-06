<?php

namespace App\Console\Commands;

use App\Models\Merchant;
use Illuminate\Console\Command;

class FetchMerchantLogos extends Command
{
    protected $signature = 'merchants:fetch-logos {--force : Overschrijf bestaande logo URLs}';

    protected $description = "Haal logo's op voor merchants via Google Favicons";

    private const DOMAIN_MAP = [
        'adobe' => 'adobe.com',
        'albert heijn' => 'ah.nl',
        'aldi' => 'aldi.nl',
        'aliexpress' => 'aliexpress.com',
        'amazon' => 'amazon.nl',
        'amazon overig' => 'amazon.nl',
        'american express afrekening' => 'americanexpress.com',
        'apple subscriptions' => 'apple.com',
        'atlas for men' => 'atlasformen.nl',
        'belastingdienst (te betalen)' => 'belastingdienst.nl',
        'belastingdienst (teruggave)' => 'belastingdienst.nl',
        'bol.com' => 'bol.com',
        'c&a' => 'c-and-a.com',
        'coolshop' => 'coolshop.nl',
        'coop' => 'coop.nl',
        'decathlon' => 'decathlon.nl',
        'disney+' => 'disneyplus.com',
        'envato' => 'envato.com',
        'essent' => 'essent.nl',
        'galeria kaufhof' => 'galeria.de',
        'gamma' => 'gamma.nl',
        'google' => 'google.com',
        'google one' => 'google.com',
        'hbo max' => 'max.com',
        'hp instant ink' => 'hp.com',
        'hans anders' => 'hansanders.nl',
        'hellotv' => 'hellotv.nl',
        'hornbach' => 'hornbach.nl',
        'ikea' => 'ikea.com',
        'jetbrains' => 'jetbrains.com',
        'jumbo' => 'jumbo.com',
        'kpn' => 'kpn.com',
        'kik' => 'kik.de',
        'kruidvat' => 'kruidvat.nl',
        'lidl' => 'lidl.nl',
        'linktree' => 'linktr.ee',
        'makro' => 'makro.nl',
        'microsoft' => 'microsoft.com',
        'netflix' => 'netflix.com',
        'nintendo' => 'nintendo.com',
        'onlyfans' => 'onlyfans.com',
        'openai / ai tools' => 'openai.com',
        'paypal overig' => 'paypal.com',
        'playstation' => 'playstation.com',
        'plus' => 'plus.nl',
        'primark' => 'primark.com',
        'prime video' => 'primevideo.com',
        'ring' => 'ring.com',
        'scapino' => 'scapino.nl',
        'skyshowtime' => 'skyshowtime.com',
        'steam' => 'steampowered.com',
        'temu' => 'temu.com',
        'tipeee' => 'tipeee.com',
        'versio hosting' => 'versio.nl',
        'videoland' => 'videoland.com',
        'vimexx hosting' => 'vimexx.nl',
        'vitens' => 'vitens.nl',
        'vivare (huur)' => 'vivare.nl',
        'x (twitter)' => 'x.com',
        'x premium' => 'x.com',
        'zeeman' => 'zeeman.com',
        'zen.com' => 'zen.com',
        'ziggo' => 'ziggo.nl',
        'zuivelhoeve' => 'dezuivelhoeve.nl',
        'istock' => 'istockphoto.com',
        'ns / ov' => 'ns.nl',
        'paiq' => 'paiq.nl',
        'cme nederland' => 'cmeneederland.nl',
        'euroshoegroup' => 'euroshoegroup.com',
        'jumper xxl' => 'jumperxxl.nl',
    ];

    public function handle(): int
    {
        $force = $this->option('force');
        $found = 0;
        $skipped = 0;
        $noMapping = 0;

        $merchants = Merchant::orderBy('name')->get();

        $this->info("Logo's ophalen voor {$merchants->count()} merchants...");
        $this->newLine();

        foreach ($merchants as $merchant) {
            $key = strtolower($merchant->name);

            if (! isset(self::DOMAIN_MAP[$key])) {
                $this->line("  <fg=gray>—</> {$merchant->name}");
                $noMapping++;

                continue;
            }

            if ($merchant->logo_url && ! $force) {
                $this->line("  <fg=cyan>~</> {$merchant->name} <fg=gray>(al ingesteld, gebruik --force om te overschrijven)</>");
                $skipped++;

                continue;
            }

            $domain = self::DOMAIN_MAP[$key];

            $logoUrl = $this->resolveLogoUrl($domain);
            $merchant->update(['logo_url' => $logoUrl]);
            $this->line("  <fg=green>✓</> {$merchant->name} <fg=gray>→ {$domain}</>");
            $found++;
        }

        $this->newLine();
        $this->info("Klaar: {$found} gevonden, {$skipped} overgeslagen, {$noMapping} geen mapping");

        return self::SUCCESS;
    }

    private function resolveLogoUrl(string $domain): string
    {
        return "https://www.google.com/s2/favicons?domain={$domain}&sz=128";
    }
}
