<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        self::sync();
    }

    /**
     * Voeg ontbrekende default-categorieën toe (idempotent). Wordt zowel
     * vanuit de seeder als vanuit een migratie aangeroepen zodat bestaande
     * installs de nieuwe categorieën binnenkrijgen bij een `migrate`.
     */
    public static function sync(): void
    {
        foreach (self::defaults() as $data) {
            $parentId = null;
            if (! empty($data['parent'])) {
                $parent = Category::where('name', $data['parent'])->whereNull('parent_id')->first();
                if (! $parent) {
                    continue;
                }
                $parentId = $parent->id;
            }

            Category::firstOrCreate(
                ['name' => $data['name'], 'parent_id' => $parentId],
                [
                    'icon' => $data['icon'],
                    'color' => $data['color'],
                    'is_system' => true,
                ],
            );
        }
    }

    /**
     * Default-set categorieën. Top-level eerst zodat sub-categorieën via
     * `parent`-name resolven naar de juiste parent_id.
     *
     * @return array<int, array{name: string, icon: string, color: string, parent?: string}>
     */
    public static function defaults(): array
    {
        return [
            // Top-level
            ['name' => 'Boodschappen',     'icon' => 'shopping-cart',       'color' => '#22c55e'],
            ['name' => 'Restaurant/Eten',  'icon' => 'fire',                'color' => '#f97316'],
            ['name' => 'Transport',        'icon' => 'truck',               'color' => '#3b82f6'],
            ['name' => 'Wonen',            'icon' => 'home',                'color' => '#a855f7'],
            ['name' => 'Abonnementen',     'icon' => 'device-phone-mobile', 'color' => '#06b6d4'],
            ['name' => 'Kleding',          'icon' => 'scissors',            'color' => '#ec4899'],
            ['name' => 'Gezondheid',       'icon' => 'heart',               'color' => '#ef4444'],
            ['name' => 'Entertainment',    'icon' => 'musical-note',        'color' => '#8b5cf6'],
            ['name' => 'Inkomen',          'icon' => 'arrow-trending-up',   'color' => '#10b981'],
            ['name' => 'Sparen',           'icon' => 'archive-box',         'color' => '#14b8a6'],
            ['name' => 'Sport & Fitness',  'icon' => 'trophy',              'color' => '#14532d'],
            ['name' => 'Vakantie',         'icon' => 'paper-airplane',      'color' => '#0ea5e9'],
            ['name' => 'Cadeaus & Donaties', 'icon' => 'gift',              'color' => '#db2777'],
            ['name' => 'Onderwijs',        'icon' => 'academic-cap',        'color' => '#6366f1'],
            ['name' => 'Kinderen',         'icon' => 'face-smile',          'color' => '#fb923c'],
            ['name' => 'Belastingen',      'icon' => 'calculator',          'color' => '#475569'],
            ['name' => 'Bankkosten',       'icon' => 'banknotes',           'color' => '#71717a'],
            ['name' => 'Verzekeringen',    'icon' => 'plus-circle',         'color' => '#0284c7'],
            ['name' => 'Zakelijk',         'icon' => 'briefcase',           'color' => '#1f2937'],
            ['name' => 'Overig',           'icon' => 'ellipsis-horizontal', 'color' => '#94a3b8'],

            // Sub-categorieën
            ['name' => 'Supermarkt',          'icon' => 'shopping-bag',       'color' => '#16a34a', 'parent' => 'Boodschappen'],
            ['name' => 'Lunch',               'icon' => 'cake',               'color' => '#fb923c', 'parent' => 'Restaurant/Eten'],
            ['name' => 'Café & Bar',          'icon' => 'beaker',             'color' => '#f59e0b', 'parent' => 'Restaurant/Eten'],
            ['name' => 'Bezorging',           'icon' => 'truck',              'color' => '#ea580c', 'parent' => 'Restaurant/Eten'],
            ['name' => 'Brandstof',           'icon' => 'fire',               'color' => '#1e40af', 'parent' => 'Transport'],
            ['name' => 'Openbaar vervoer',    'icon' => 'map',                'color' => '#1d4ed8', 'parent' => 'Transport'],
            ['name' => 'Parkeren',            'icon' => 'map-pin',            'color' => '#2563eb', 'parent' => 'Transport'],
            ['name' => 'Huur / Hypotheek',    'icon' => 'key',                'color' => '#9333ea', 'parent' => 'Wonen'],
            ['name' => 'Energie',             'icon' => 'bolt',               'color' => '#facc15', 'parent' => 'Wonen'],
            ['name' => 'Internet & telefoon', 'icon' => 'wifi',               'color' => '#0ea5e9', 'parent' => 'Wonen'],
            ['name' => 'Onderhoud',           'icon' => 'wrench-screwdriver', 'color' => '#7c3aed', 'parent' => 'Wonen'],
            ['name' => 'Streaming',           'icon' => 'film',               'color' => '#ec4899', 'parent' => 'Abonnementen'],
            ['name' => 'Software',            'icon' => 'computer-desktop',   'color' => '#14b8a6', 'parent' => 'Abonnementen'],
            ['name' => 'Salaris',             'icon' => 'briefcase',          'color' => '#059669', 'parent' => 'Inkomen'],
            ['name' => 'Tikkie & verkoop',    'icon' => 'currency-euro',      'color' => '#047857', 'parent' => 'Inkomen'],
        ];
    }
}
