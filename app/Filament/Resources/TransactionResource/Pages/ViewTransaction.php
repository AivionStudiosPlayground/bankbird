<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Enums\TransactionType;
use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Transactie')
                ->columns(3)
                ->components([
                    TextEntry::make('date')
                        ->label('Datum')
                        ->date('d-m-Y'),

                    TextEntry::make('amount')
                        ->label('Bedrag')
                        ->money('EUR')
                        ->color(fn (Transaction $record): string => $record->type === TransactionType::Debit ? 'danger' : 'success')
                        ->weight('bold'),

                    TextEntry::make('type')
                        ->label('Type')
                        ->badge(),

                    TextEntry::make('description')
                        ->label('Omschrijving')
                        ->columnSpanFull(),

                    TextEntry::make('raw_description')
                        ->label('Originele omschrijving')
                        ->columnSpanFull()
                        ->fontFamily('mono')
                        ->color('gray')
                        ->placeholder('—'),
                ]),

            Section::make('Koppelingen')
                ->columns(3)
                ->components([
                    ImageEntry::make('account.bank_logo_url')
                        ->label('Bank')
                        ->disk(null)
                        ->height(28)
                        ->square()
                        ->extraImgAttributes(['class' => 'object-contain']),

                    TextEntry::make('account.name')
                        ->label('Rekening')
                        ->badge()
                        ->color('primary')
                        ->placeholder('—'),

                    TextEntry::make('counterpart_iban')
                        ->label('Tegenrekening')
                        ->fontFamily('mono')
                        ->placeholder('—')
                        ->copyable(),

                    ImageEntry::make('merchant.logo_url')
                        ->label('Merchant logo')
                        ->disk(null)
                        ->height(28)
                        ->square()
                        ->extraImgAttributes(['class' => 'object-contain'])
                        ->placeholder('—'),

                    TextEntry::make('merchant.name')
                        ->label('Merchant')
                        ->placeholder('—')
                        ->url(fn (Transaction $record): ?string => $record->merchant
                            ? route('filament.admin.resources.merchants.edit', $record->merchant)
                            : null),

                    TextEntry::make('category.name')
                        ->label('Categorie')
                        ->badge()
                        ->color(fn (Transaction $record) => $record->category?->color ? 'gray' : 'gray')
                        ->placeholder('—'),
                ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Bewerken')
                ->icon('heroicon-o-pencil-square'),

            Action::make('back')
                ->label('Terug naar overzicht')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(ListTransactions::getUrl()),
        ];
    }
}
