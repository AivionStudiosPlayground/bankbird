<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Merchant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MerchantSeeder extends Seeder
{
    /**
     * Seed de standaardlijst Nederlandse merchants. Wordt zowel door
     * DemoSeeder als losstaand gebruikt om dev-databases te vullen.
     *
     * @return array<string, Merchant>
     */
    public function run(): array
    {
        $categories = Category::all()->keyBy('name');

        $definitions = [
            // Boodschappen
            ['name' => 'Albert Heijn',                 'cat' => 'Boodschappen',    'logo' => '/images/merchants/albert-heijn.png',                'patterns' => ['albert heijn', 'ah.nl']],
            ['name' => 'Jumbo',                        'cat' => 'Boodschappen',    'logo' => '/images/merchants/jumbo.png',                       'patterns' => ['jumbo']],
            ['name' => 'Lidl',                         'cat' => 'Boodschappen',    'logo' => '/images/merchants/lidl.png',                        'patterns' => ['lidl']],
            ['name' => 'Aldi',                         'cat' => 'Boodschappen',    'logo' => '/images/merchants/aldi.png',                        'patterns' => ['aldi']],
            ['name' => 'Coop',                         'cat' => 'Boodschappen',    'logo' => '/images/merchants/coop.png',                        'patterns' => ['coop']],
            ['name' => 'Plus',                         'cat' => 'Boodschappen',    'logo' => '/images/merchants/plus.png',                        'patterns' => ['plus supermarkt', 'plus.nl']],
            ['name' => 'Makro',                        'cat' => 'Boodschappen',    'logo' => '/images/merchants/makro.png',                       'patterns' => ['makro']],
            ['name' => 'Zuivelhoeve',                  'cat' => 'Boodschappen',    'logo' => '/images/merchants/zuivelhoeve.png',                 'patterns' => ['zuivelhoeve', 'de zuivelhoeve']],

            // Restaurant/Eten
            ['name' => 'McDonald\'s',                  'cat' => 'Restaurant/Eten', 'logo' => '/images/merchants/mcdonalds.png',                   'patterns' => ["mcdonald's", 'mcdonalds']],
            ['name' => 'Thuisbezorgd',                 'cat' => 'Restaurant/Eten', 'logo' => '/images/merchants/thuisbezorgd.png',                'patterns' => ['thuisbezorgd']],

            // Transport
            ['name' => 'Shell',                        'cat' => 'Transport',       'logo' => '/images/merchants/shell.png',                       'patterns' => ['shell']],
            ['name' => 'NS Reizigers',                 'cat' => 'Transport',       'logo' => '/images/merchants/ns-reizigers.jpg',                'patterns' => ['ns reizigers', 'ov-chipkaart']],
            ['name' => 'NS / OV',                      'cat' => 'Transport',       'logo' => '/images/merchants/ns-ov.jpg',                       'patterns' => ['ov-chipkaart', 'ov chipkaart']],

            // Wonen
            ['name' => 'Energiedirect',                'cat' => 'Wonen',           'logo' => '/images/merchants/energiedirect.png',               'patterns' => ['energiedirect']],
            ['name' => 'Essent',                       'cat' => 'Wonen',           'logo' => '/images/merchants/essent.png',                      'patterns' => ['essent']],
            ['name' => 'Vitens',                       'cat' => 'Wonen',           'logo' => '/images/merchants/vitens.png',                      'patterns' => ['vitens']],
            ['name' => 'Vivare (huur)',                'cat' => 'Wonen',           'logo' => '/images/merchants/vivare-huur.png',                 'patterns' => ['vivare', 'vivare huur']],
            ['name' => 'IKEA',                         'cat' => 'Wonen',           'logo' => '/images/merchants/ikea.png',                        'patterns' => ['ikea']],
            ['name' => 'Gamma',                        'cat' => 'Wonen',           'logo' => '/images/merchants/gamma.png',                       'patterns' => ['gamma']],
            ['name' => 'Hornbach',                     'cat' => 'Wonen',           'logo' => '/images/merchants/hornbach.png',                    'patterns' => ['hornbach']],
            ['name' => 'Ring',                         'cat' => 'Wonen',           'logo' => '/images/merchants/ring.png',                        'patterns' => ['ring.com', 'ring doorbell']],

            // Abonnementen
            ['name' => 'Netflix',                      'cat' => 'Abonnementen',    'logo' => '/images/merchants/netflix.png',                     'patterns' => ['netflix']],
            ['name' => 'Spotify',                      'cat' => 'Abonnementen',    'logo' => '/images/merchants/spotify.png',                     'patterns' => ['spotify']],
            ['name' => 'Disney+',                      'cat' => 'Abonnementen',    'logo' => '/images/merchants/disney.png',                      'patterns' => ['disney+', 'disney plus', 'disneyplus']],
            ['name' => 'HBO Max',                      'cat' => 'Abonnementen',    'logo' => '/images/merchants/hbo-max.png',                     'patterns' => ['hbo max', 'max.com']],
            ['name' => 'Prime Video',                  'cat' => 'Abonnementen',    'logo' => '/images/merchants/prime-video.png',                 'patterns' => ['prime video', 'amazon prime video']],
            ['name' => 'SkyShowtime',                  'cat' => 'Abonnementen',    'logo' => '/images/merchants/skyshowtime.png',                 'patterns' => ['skyshowtime', 'sky showtime']],
            ['name' => 'Videoland',                    'cat' => 'Abonnementen',    'logo' => '/images/merchants/videoland.png',                   'patterns' => ['videoland']],
            ['name' => 'HelloTV',                      'cat' => 'Abonnementen',    'logo' => '/images/merchants/hellotv.png',                     'patterns' => ['hellotv', 'hello tv']],
            ['name' => 'Ziggo',                        'cat' => 'Abonnementen',    'logo' => '/images/merchants/ziggo.png',                       'patterns' => ['ziggo']],
            ['name' => 'KPN',                          'cat' => 'Abonnementen',    'logo' => '/images/merchants/kpn.png',                         'patterns' => ['kpn']],
            ['name' => 'Adobe',                        'cat' => 'Abonnementen',    'logo' => '/images/merchants/adobe.png',                       'patterns' => ['adobe', 'creative cloud', 'adobe systems']],
            ['name' => 'Microsoft',                    'cat' => 'Abonnementen',    'logo' => '/images/merchants/microsoft.png',                   'patterns' => ['microsoft', 'microsoft 365']],
            ['name' => 'Google',                       'cat' => 'Abonnementen',    'logo' => '/images/merchants/google.png',                      'patterns' => ['google ireland', 'google llc']],
            ['name' => 'Google One',                   'cat' => 'Abonnementen',    'logo' => '/images/merchants/google-one.png',                  'patterns' => ['google one']],
            ['name' => 'Apple Subscriptions',          'cat' => 'Abonnementen',    'logo' => '/images/merchants/apple-subscriptions.png',         'patterns' => ['apple.com/bill', 'apple subscriptions']],
            ['name' => 'JetBrains',                    'cat' => 'Abonnementen',    'logo' => '/images/merchants/jetbrains.png',                   'patterns' => ['jetbrains']],
            ['name' => 'Envato',                       'cat' => 'Abonnementen',    'logo' => '/images/merchants/envato.png',                      'patterns' => ['envato', 'envato pty']],
            ['name' => 'OpenAI / AI Tools',            'cat' => 'Abonnementen',    'logo' => '/images/merchants/openai-ai-tools.png',             'patterns' => ['openai', 'chatgpt', 'anthropic', 'claude.ai', 'ai tools']],
            ['name' => 'iStock',                       'cat' => 'Abonnementen',    'logo' => '/images/merchants/istock.png',                      'patterns' => ['istock', 'istockphoto']],
            ['name' => 'HP Instant Ink',               'cat' => 'Abonnementen',    'logo' => '/images/merchants/hp-instant-ink.png',              'patterns' => ['hp instant ink', 'instant ink']],
            ['name' => 'Linktree',                     'cat' => 'Abonnementen',    'logo' => '/images/merchants/linktree.png',                    'patterns' => ['linktree', 'linktr.ee']],
            ['name' => 'Tipeee',                       'cat' => 'Abonnementen',    'logo' => '/images/merchants/tipeee.png',                      'patterns' => ['tipeee']],
            ['name' => 'OnlyFans',                     'cat' => 'Abonnementen',    'logo' => '/images/merchants/onlyfans.png',                    'patterns' => ['onlyfans', 'only fans']],
            ['name' => 'X (twitter)',                  'cat' => 'Abonnementen',    'logo' => '/images/merchants/x-twitter.png',                   'patterns' => ['x corp', 'twitter']],
            ['name' => 'X Premium',                    'cat' => 'Abonnementen',    'logo' => '/images/merchants/x-premium.png',                   'patterns' => ['x premium', 'twitter blue']],
            ['name' => 'Zen.com',                      'cat' => 'Abonnementen',    'logo' => '/images/merchants/zencom.png',                      'patterns' => ['zen.com']],
            ['name' => 'Versio Hosting',               'cat' => 'Abonnementen',    'logo' => '/images/merchants/versio-hosting.png',              'patterns' => ['versio', 'versio hosting']],
            ['name' => 'Vimexx Hosting',               'cat' => 'Abonnementen',    'logo' => '/images/merchants/vimexx-hosting.png',              'patterns' => ['vimexx', 'vimexx hosting']],

            // Kleding
            ['name' => 'HEMA',                         'cat' => 'Kleding',         'logo' => '/images/merchants/hema.png',                        'patterns' => ['hema']],
            ['name' => 'Zalando',                      'cat' => 'Kleding',         'logo' => '/images/merchants/zalando.png',                     'patterns' => ['zalando']],
            ['name' => 'C&A',                          'cat' => 'Kleding',         'logo' => '/images/merchants/ca.png',                          'patterns' => ['c&a', 'c en a']],
            ['name' => 'Primark',                      'cat' => 'Kleding',         'logo' => '/images/merchants/primark.png',                     'patterns' => ['primark']],
            ['name' => 'Decathlon',                    'cat' => 'Kleding',         'logo' => '/images/merchants/decathlon.png',                   'patterns' => ['decathlon']],
            ['name' => 'Scapino',                      'cat' => 'Kleding',         'logo' => '/images/merchants/scapino.png',                     'patterns' => ['scapino']],
            ['name' => 'Zeeman',                       'cat' => 'Kleding',         'logo' => '/images/merchants/zeeman.png',                      'patterns' => ['zeeman']],
            ['name' => 'Kik',                          'cat' => 'Kleding',         'logo' => '/images/merchants/kik.png',                         'patterns' => ['kik textilien', 'kik nl']],
            ['name' => 'Galeria Kaufhof',              'cat' => 'Kleding',         'logo' => '/images/merchants/galeria-kaufhof.png',             'patterns' => ['galeria kaufhof', 'galeria']],
            ['name' => 'Atlas for Men',                'cat' => 'Kleding',         'logo' => '/images/merchants/atlas-for-men.png',               'patterns' => ['atlas for men', 'atlasformen']],
            ['name' => 'Euroshoegroup',                'cat' => 'Kleding',         'logo' => null,                                                'patterns' => ['euroshoegroup', 'euroshoe']],
            ['name' => 'Jumper XXL',                   'cat' => 'Kleding',         'logo' => null,                                                'patterns' => ['jumper xxl']],

            // Gezondheid
            ['name' => 'CZ Zorgverzekering',           'cat' => 'Gezondheid',      'logo' => '/images/merchants/cz-zorgverzekering.png',          'patterns' => ['cz zorgverzekering', 'cz groep']],
            ['name' => 'Etos',                         'cat' => 'Gezondheid',      'logo' => '/images/merchants/etos.png',                        'patterns' => ['etos']],
            ['name' => 'Basic-Fit',                    'cat' => 'Gezondheid',      'logo' => '/images/merchants/basic-fit.png',                   'patterns' => ['basic-fit', 'basicfit']],
            ['name' => 'Kruidvat',                     'cat' => 'Gezondheid',      'logo' => '/images/merchants/kruidvat.png',                    'patterns' => ['kruidvat']],
            ['name' => 'Hans Anders',                  'cat' => 'Gezondheid',      'logo' => '/images/merchants/hans-anders.png',                 'patterns' => ['hans anders']],

            // Entertainment
            ['name' => 'Pathé',                        'cat' => 'Entertainment',   'logo' => '/images/merchants/pathe.png',                       'patterns' => ['pathé', 'pathe']],
            ['name' => 'Steam',                        'cat' => 'Entertainment',   'logo' => '/images/merchants/steam.png',                       'patterns' => ['steam', 'steampowered', 'valve']],
            ['name' => 'PlayStation',                  'cat' => 'Entertainment',   'logo' => '/images/merchants/playstation.jpg',                 'patterns' => ['playstation', 'sony interactive']],
            ['name' => 'Nintendo',                     'cat' => 'Entertainment',   'logo' => '/images/merchants/nintendo.png',                    'patterns' => ['nintendo', 'nintendo switch']],

            // Inkomen
            ['name' => 'Werkgever BV',                 'cat' => 'Inkomen',         'logo' => null,                                                'patterns' => ['werkgever bv', 'salarisbetaling']],
            ['name' => 'Belastingdienst (teruggave)',  'cat' => 'Inkomen',         'logo' => '/images/merchants/belastingdienst-teruggave.png',   'patterns' => ['belastingdienst teruggave', 'teruggave belastingdienst']],

            // Overig
            ['name' => 'Bol.com',                      'cat' => 'Overig',          'logo' => '/images/merchants/bolcom.png',                      'patterns' => ['bol.com']],
            ['name' => 'Amazon',                       'cat' => 'Overig',          'logo' => '/images/merchants/amazon.png',                      'patterns' => ['amazon', 'amazon.nl', 'amazon.com', 'amzn']],
            ['name' => 'Amazon overig',                'cat' => 'Overig',          'logo' => '/images/merchants/amazon-overig.png',               'patterns' => ['amazon overig', 'amazon services', 'amazon eu']],
            ['name' => 'AliExpress',                   'cat' => 'Overig',          'logo' => '/images/merchants/aliexpress.png',                  'patterns' => ['aliexpress', 'ali express']],
            ['name' => 'Temu',                         'cat' => 'Overig',          'logo' => '/images/merchants/temu.png',                        'patterns' => ['temu']],
            ['name' => 'Coolshop',                     'cat' => 'Overig',          'logo' => '/images/merchants/coolshop.png',                    'patterns' => ['coolshop']],
            ['name' => 'American Express afrekening',  'cat' => 'Overig',          'logo' => '/images/merchants/american-express-afrekening.png', 'patterns' => ['american express', 'amex']],
            ['name' => 'Belastingdienst (te betalen)', 'cat' => 'Overig',          'logo' => '/images/merchants/belastingdienst-te-betalen.png',  'patterns' => ['belastingdienst', 'belastingdienst te betalen']],
            ['name' => 'Paiq',                         'cat' => 'Overig',          'logo' => '/images/merchants/paiq.jpg',                        'patterns' => ['paiq']],
            ['name' => 'CME Nederland',                'cat' => 'Overig',          'logo' => null,                                                'patterns' => ['cme nederland']],
        ];

        $result = [];

        foreach ($definitions as $def) {
            $category = $categories[$def['cat']] ?? null;
            $merchant = Merchant::firstOrCreate(
                ['normalized_name' => Str::slug($def['name'])],
                [
                    'name' => $def['name'],
                    'category_id' => $category?->id,
                    'logo_url' => $def['logo'],
                    'match_patterns' => $def['patterns'],
                ]
            );
            $result[$def['name']] = $merchant;
        }

        return $result;
    }
}
