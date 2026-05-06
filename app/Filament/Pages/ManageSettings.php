<?php

namespace App\Filament\Pages;

use App\Models\AppSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

/**
 * @property-read Schema $form
 */
class ManageSettings extends Page
{
    protected string $view = 'filament.pages.manage-settings';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Instellingen';

    protected static ?string $title = 'Instellingen';

    protected static ?int $navigationSort = 99;

    protected static bool $shouldRegisterNavigation = false;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AppSetting::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Huisstijl')
                    ->description('Logo en favicon van de applicatie.')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions([null, '16:9', '4:3', '3:1', '1:1'])
                            ->imageEditorViewportWidth(1200)
                            ->imageEditorViewportHeight(400)
                            ->disk('public')
                            ->directory('settings')
                            ->maxSize(10240)
                            ->helperText('Klik op het potlood om bij te snijden of te verkleinen. Verwijder het logo om terug te vallen op het standaard logo. Max. 10 MB.')
                            ->columnSpanFull(),

                        Select::make('logo_height')
                            ->label('Logo grootte (in de navigatiebalk)')
                            ->options([
                                '1.5rem' => 'Klein (1.5rem)',
                                '2rem' => 'Normaal (2rem) — standaard',
                                '2.5rem' => 'Middel (2.5rem)',
                                '3rem' => 'Groot (3rem)',
                                '4rem' => 'Extra groot (4rem)',
                                '5rem' => 'Maximaal (5rem)',
                            ])
                            ->default('2rem')
                            ->selectablePlaceholder(false),

                        FileUpload::make('favicon_path')
                            ->label('Favicon')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions(['1:1'])
                            ->imageEditorViewportWidth(512)
                            ->imageEditorViewportHeight(512)
                            ->disk('public')
                            ->directory('settings')
                            ->maxSize(10240)
                            ->helperText('Klik op het potlood om bij te snijden. Vierkant formaat vereist. Max. 10 MB.')
                            ->columnSpanFull(),
                    ]),

                Section::make('AI Categorisatie')
                    ->description('Automatisch transacties categoriseren met behulp van AI.')
                    ->schema([
                        Placeholder::make('privacy_notice')
                            ->label('')
                            ->content(new HtmlString(
                                '<div style="padding: 0.75rem 1rem; border-radius: 0.5rem; background: #fefce8; border: 1px solid #fde047; color: #713f12; font-size: 0.875rem; line-height: 1.5;">'
                                .'<strong>⚠️ Let op — privacy</strong><br>'
                                .'Wanneer u AI-categorisatie inschakelt, worden uw transactieomschrijvingen en -bedragen verstuurd naar de servers van <strong>Anthropic (Claude)</strong> of <strong>OpenAI</strong>. '
                                .'Uw financiële gegevens zijn zichtbaar voor deze externe partijen en worden verwerkt conform hun privacybeleid. '
                                .'Schakel dit alleen in als u hiermee akkoord gaat.'
                                .'</div>'
                            ))
                            ->columnSpanFull(),

                        Toggle::make('ai_enabled')
                            ->label('AI categorisatie inschakelen')
                            ->live()
                            ->columnSpanFull(),

                        Select::make('ai_provider')
                            ->label('AI Provider')
                            ->options([
                                'claude' => 'Claude (Anthropic)',
                                'openai' => 'OpenAI (ChatGPT)',
                            ])
                            ->default('claude')
                            ->live()
                            ->visible(fn (Get $get) => (bool) $get('ai_enabled'))
                            ->required(fn (Get $get) => (bool) $get('ai_enabled')),

                        TextInput::make('claude_api_key')
                            ->label('Claude API-sleutel')
                            ->password()
                            ->revealable()
                            ->placeholder('sk-ant-...')
                            ->helperText('Verkrijgbaar via console.anthropic.com → API Keys.')
                            ->visible(fn (Get $get) => (bool) $get('ai_enabled') && $get('ai_provider') !== 'openai'),

                        TextInput::make('openai_api_key')
                            ->label('OpenAI API-sleutel')
                            ->password()
                            ->revealable()
                            ->placeholder('sk-...')
                            ->helperText('Verkrijgbaar via platform.openai.com → API Keys.')
                            ->visible(fn (Get $get) => (bool) $get('ai_enabled') && $get('ai_provider') === 'openai'),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Opslaan')
                ->icon('heroicon-o-cloud-arrow-up')
                ->action('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function save(): void
    {
        if (config('app.demo_mode', false)) {
            Notification::make()
                ->warning()
                ->title('Demo-modus')
                ->body('Wijzigingen zijn uitgeschakeld in de demo-omgeving.')
                ->send();

            return;
        }

        $data = $this->form->getState();

        $setting = AppSetting::current();
        $setting->fill($data);
        $setting->save();

        Notification::make()
            ->success()
            ->title('Instellingen opgeslagen')
            ->send();
    }
}
