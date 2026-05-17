<?php

namespace App\Filament\Resources\MerchantResource\Pages;

use App\Filament\Resources\MerchantResource;
use App\Services\MerchantPatternService;
use App\Support\Demo;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListMerchants extends ListRecords
{
    protected static string $resource = MerchantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->icon('heroicon-o-plus'),

            Action::make('sync_all')
                ->label('Alles synchroniseren')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->requiresConfirmation()
                ->modalHeading('Alle transacties synchroniseren')
                ->modalDescription('Alle transacties worden opnieuw vergeleken met de patronen van alle merchants. Dit kan even duren bij grote datasets.')
                ->action(function () {
                    if (Demo::active()) {
                        Notification::make()->warning()->title('Demo-modus')->body('Synchroniseren is uitgeschakeld in de demo.')->send();

                        return;
                    }

                    $count = app(MerchantPatternService::class)->syncAll();

                    Notification::make()
                        ->success()
                        ->title("{$count} transactie(s) bijgewerkt")
                        ->send();
                }),
        ];
    }
}
