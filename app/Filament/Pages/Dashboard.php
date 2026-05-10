<?php

namespace App\Filament\Pages;

use App\Models\DashboardLayout;
use App\Support\DashboardWidgetRegistry;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-home';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.pages.dashboard';

    /**
     * Geordende widget-stack zoals de gebruiker hem ziet. Elk item:
     * { id: string, hidden: bool, span: int, options: array }.
     *
     * @var array<int, array{id: string, hidden: bool, span: int, options: array<string, mixed>}>
     */
    public array $widgetLayout = [];

    public bool $isEditing = false;

    public static function getNavigationLabel(): string
    {
        return 'Dashboard';
    }

    public function getTitle(): string
    {
        return 'Dashboard';
    }

    public function getColumns(): int|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 3,
            '2xl' => 3,
        ];
    }

    public function mount(): void
    {
        $this->widgetLayout = $this->loadLayout();
    }

    /**
     * @return array<int, array{id: string, hidden: bool, options: array<string, mixed>}>
     */
    protected function loadLayout(): array
    {
        $userId = auth()->id();
        if (! $userId) {
            return DashboardWidgetRegistry::defaultLayout();
        }

        $row = DashboardLayout::where('user_id', $userId)->first();
        $stored = $row?->widgets ?? [];

        if (empty($stored)) {
            return DashboardWidgetRegistry::defaultLayout();
        }

        // Saneer: filter onbekende widgets eruit, voeg eventueel
        // nieuwe widgets uit de registry achteraan toe (verborgen)
        // zodat updates niet stilletjes verloren gaan.
        $known = collect(DashboardWidgetRegistry::all())->keys();
        $sanitised = collect($stored)
            ->filter(fn (array $entry) => $known->contains($entry['id'] ?? null))
            ->map(fn (array $entry) => [
                'id' => $entry['id'],
                'hidden' => (bool) ($entry['hidden'] ?? false),
                'span' => $entry['span'] ?? null,
                'options' => (array) ($entry['options'] ?? []),
            ])
            ->values();

        $missingIds = $known->diff($sanitised->pluck('id'));
        foreach ($missingIds as $id) {
            $spec = DashboardWidgetRegistry::find($id);
            if (! $spec) {
                continue;
            }
            $sanitised->push([
                'id' => $id,
                'hidden' => true,
                'span' => (int) $spec['defaultSpan'],
                'options' => $spec['defaultOptions'],
            ]);
        }

        // Saneer: zorg dat elke entry een geldige span en options heeft
        // (forward-compat: oudere layouts hebben mogelijk nog geen span).
        return $sanitised
            ->map(function (array $entry): array {
                $spec = DashboardWidgetRegistry::find($entry['id']);
                $defaultSpan = $spec ? (int) $spec['defaultSpan'] : 1;

                $span = (int) ($entry['span'] ?? $defaultSpan);
                if (! in_array($span, DashboardWidgetRegistry::SPAN_CHOICES, true)) {
                    $span = $defaultSpan;
                }

                return [
                    'id' => $entry['id'],
                    'hidden' => (bool) ($entry['hidden'] ?? false),
                    'span' => $span,
                    'options' => array_merge(
                        $spec['defaultOptions'] ?? [],
                        (array) ($entry['options'] ?? [])
                    ),
                ];
            })
            ->values()
            ->all();
    }

    /**
     * Filament rendert in z'n default-view de uitkomst van getWidgets().
     * We negeren dat in onze custom view en renderen via $layout zelf;
     * we returnen alle ge-discoverde widgets zodat Livewire ze allemaal
     * registreert (anders zijn ze niet beschikbaar wanneer we ze later
     * dynamisch tonen).
     */
    public function getWidgets(): array
    {
        return collect(DashboardWidgetRegistry::all())
            ->pluck('class')
            ->all();
    }

    /**
     * Lijst widget-instanties zoals ze nu gerenderd moeten worden,
     * gefilterd op zichtbaarheid en gesorteerd zoals in de layout.
     *
     * @return array<int, array{spec: array<string, mixed>, entry: array<string, mixed>}>
     */
    public function getVisibleWidgets(): array
    {
        return collect($this->widgetLayout)
            ->reject(fn (array $entry) => $entry['hidden'])
            ->map(function (array $entry): ?array {
                $spec = DashboardWidgetRegistry::find($entry['id']);

                return $spec ? ['spec' => $spec, 'entry' => $entry] : null;
            })
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{spec: array<string, mixed>, entry: array<string, mixed>}>
     */
    public function getHiddenWidgets(): array
    {
        return collect($this->widgetLayout)
            ->filter(fn (array $entry) => $entry['hidden'])
            ->map(function (array $entry): ?array {
                $spec = DashboardWidgetRegistry::find($entry['id']);

                return $spec ? ['spec' => $spec, 'entry' => $entry] : null;
            })
            ->filter()
            ->values()
            ->all();
    }

    // ─────────────────────────────────────────────────────────────────
    // Edit-modus actions
    // ─────────────────────────────────────────────────────────────────

    /**
     * Alle actions zijn altijd geregistreerd; de zichtbaarheid wordt per
     * render geëvalueerd via `visible()`. Filament cached anders de mount-
     * tijd-set en wisselt actions niet op state-wijziging zonder reload.
     *
     * @return array<int, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('editLayout')
                ->label('Aanpassen')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('gray')
                ->visible(fn () => ! $this->isEditing)
                ->action(fn () => $this->startEditing()),

            Action::make('resetLayout')
                ->label('Standaard')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->visible(fn () => $this->isEditing)
                ->requiresConfirmation()
                ->modalHeading('Layout terugzetten')
                ->modalDescription('Alle widgets worden teruggezet naar de standaard-volgorde, breedte en zichtbaarheid.')
                ->action(fn () => $this->resetLayout()),
        ];
    }

    public function startEditing(): void
    {
        $this->isEditing = true;
    }

    public function finishEditing(): void
    {
        $this->isEditing = false;
    }

    public function resetLayout(): void
    {
        $this->widgetLayout = DashboardWidgetRegistry::defaultLayout();
        $this->persist();
    }

    /**
     * Schrijf de huidige `widgetLayout` direct naar de DB. Wordt
     * aangeroepen na elke wijziging (drag-drop, span, hide/show, edit
     * options) zodat de gebruiker geen aparte "Opslaan"-stap nodig heeft.
     */
    private function persist(): void
    {
        $userId = auth()->id();
        if (! $userId) {
            return;
        }

        DashboardLayout::updateOrCreate(
            ['user_id' => $userId],
            ['widgets' => $this->widgetLayout],
        );
    }

    /**
     * Wordt aangeroepen door het sortable.js-onEnd-event vanuit Alpine
     * met de nieuwe geordende lijst van widget-id's.
     *
     * @param  array<int, string>  $orderedIds
     */
    public function reorderWidgets(array $orderedIds): void
    {
        $byId = collect($this->widgetLayout)->keyBy('id');
        $reordered = collect($orderedIds)
            ->map(fn (string $id) => $byId->get($id))
            ->filter()
            ->values()
            ->all();

        // Verborgen widgets die niet in de drag-volgorde voorkomen,
        // bewaren we achter de zichtbare lijst zodat ze niet verloren gaan.
        $hiddenRemainder = collect($this->widgetLayout)
            ->whereNotIn('id', $orderedIds)
            ->values()
            ->all();

        $this->widgetLayout = array_merge($reordered, $hiddenRemainder);
        $this->persist();
    }

    public function hideWidget(string $id): void
    {
        $this->widgetLayout = collect($this->widgetLayout)
            ->map(fn (array $entry) => $entry['id'] === $id
                ? array_merge($entry, ['hidden' => true])
                : $entry)
            ->values()
            ->all();
        $this->persist();
    }

    public function showWidget(string $id): void
    {
        $this->widgetLayout = collect($this->widgetLayout)
            ->map(fn (array $entry) => $entry['id'] === $id
                ? array_merge($entry, ['hidden' => false])
                : $entry)
            ->values()
            ->all();
        $this->persist();
    }

    /**
     * Zet de breedte van een tegel naar 1, 2 of 3 kolommen.
     */
    public function setSpan(string $id, int $span): void
    {
        if (! in_array($span, DashboardWidgetRegistry::SPAN_CHOICES, true)) {
            return;
        }

        $this->widgetLayout = collect($this->widgetLayout)
            ->map(fn (array $entry) => $entry['id'] === $id
                ? array_merge($entry, ['span' => $span])
                : $entry)
            ->values()
            ->all();
        $this->persist();
    }

    /**
     * Per-widget configuratie-modal. Het schema wordt dynamisch opgebouwd
     * uit de `editableOptions` in de WidgetRegistry.
     */
    public function editWidgetAction(): Action
    {
        return Action::make('editWidget')
            ->label('Widget instellen')
            ->modalHeading(fn (array $arguments): string => 'Instellingen — '.($this->resolveSpec($arguments)['label'] ?? ''))
            ->modalDescription('De wijziging wordt direct doorgevoerd en automatisch opgeslagen.')
            ->modalSubmitActionLabel('Toepassen')
            ->modalCancelActionLabel('Annuleren')
            ->modalWidth('md')
            ->schema(fn (array $arguments): array => $this->buildOptionsSchema($arguments))
            ->fillForm(fn (array $arguments): array => $this->resolveCurrentOptions($arguments))
            ->action(function (array $arguments, array $data): void {
                $id = $arguments['id'] ?? null;
                if ($id === null) {
                    return;
                }

                $this->widgetLayout = collect($this->widgetLayout)
                    ->map(function (array $entry) use ($id, $data) {
                        if ($entry['id'] !== $id) {
                            return $entry;
                        }

                        $current = (array) ($entry['options'] ?? []);

                        return array_merge($entry, [
                            'options' => array_merge($current, $data),
                        ]);
                    })
                    ->values()
                    ->all();

                $this->persist();

                Notification::make()
                    ->success()
                    ->title('Widget bijgewerkt')
                    ->send();
            });
    }

    /**
     * @param  array<string, mixed>  $arguments
     * @return array<string, mixed>|null
     */
    private function resolveSpec(array $arguments): ?array
    {
        return DashboardWidgetRegistry::find($arguments['id'] ?? '');
    }

    /**
     * @param  array<string, mixed>  $arguments
     * @return array<string, mixed>
     */
    private function resolveCurrentOptions(array $arguments): array
    {
        $id = $arguments['id'] ?? null;
        if ($id === null) {
            return [];
        }

        $entry = collect($this->widgetLayout)->firstWhere('id', $id);

        return (array) ($entry['options'] ?? []);
    }

    /**
     * Bouw form-schema uit `editableOptions` van de gevonden widget.
     *
     * @param  array<string, mixed>  $arguments
     * @return array<int, mixed>
     */
    private function buildOptionsSchema(array $arguments): array
    {
        $spec = $this->resolveSpec($arguments);
        if (! $spec) {
            return [];
        }

        return collect($spec['editableOptions'] ?? [])
            ->map(function (array $field) {
                return match ($field['type'] ?? 'text') {
                    'number' => TextInput::make($field['name'])
                        ->label($field['label'] ?? $field['name'])
                        ->numeric()
                        ->minValue($field['min'] ?? 1)
                        ->maxValue($field['max'] ?? 100)
                        ->required()
                        ->default($field['default'] ?? null),

                    'select' => Select::make($field['name'])
                        ->label($field['label'] ?? $field['name'])
                        ->options($field['options'] ?? [])
                        ->required()
                        ->default($field['default'] ?? null),

                    default => TextInput::make($field['name'])
                        ->label($field['label'] ?? $field['name'])
                        ->default($field['default'] ?? null),
                };
            })
            ->all();
    }
}
