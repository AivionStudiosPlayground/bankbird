<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevDataSeeder extends Seeder
{
    /**
     * Vul de lokale dev-database met dezelfde fixture-set als demo (twee
     * accounts + zes maanden transacties), gekoppeld aan de dev-user.
     * Eigen IBAN's zodat backups en exports niet conflicteren met de
     * demo-DB. Idempotent — kan herhaaldelijk worden gedraaid.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'dev@bankbird.app'],
            [
                'name' => 'Dev Admin',
                'password' => Hash::make('dev'),
            ]
        );

        (new DemoSeeder)->seedDataFor(
            $user,
            betaalIban: 'NL21INGB0001112223',
            spaarIban: 'NL35INGB0008889990',
        );
    }
}
