<x-filament-panels::page>

    {{-- Edit-modus banner --}}
    @if ($this->isEditing)
        <div class="bb-dashboard-edit-banner">
            <div class="bb-dashboard-edit-banner__icon">
                <x-filament::icon icon="heroicon-o-cog-6-tooth" />
            </div>
            <div class="bb-dashboard-edit-banner__body">
                <p class="bb-dashboard-edit-banner__title">Dashboard aanpassen</p>
                <p class="bb-dashboard-edit-banner__subtitle">
                    Sleep widgets, kies hun breedte (1/2/3) of gebruik het potlood voor instellingen.
                    Wijzigingen worden automatisch opgeslagen.
                </p>
            </div>
            <div class="bb-dashboard-edit-banner__action">
                <x-filament::button
                    color="success"
                    icon="heroicon-o-check"
                    size="lg"
                    wire:click="finishEditing"
                >
                    Opslaan
                </x-filament::button>
            </div>
        </div>
    @endif

    {{-- Hoofdgrid met widgets --}}
    <div
        x-data="dashboardSortable({ enabled: @js($this->isEditing) })"
        x-init="init()"
        x-on:edit-mode-changed.window="setEnabled($event.detail.enabled)"
        @class([
            'bb-dashboard-grid',
            'bb-dashboard-grid--editing' => $this->isEditing,
        ])
    >
        @foreach ($this->getVisibleWidgets() as $w)
            @php
                $entry = $w['entry'];
                $spec = $w['spec'];
                $span = (int) $entry['span'];
                $hasOptions = ! empty($spec['editableOptions']);
                // Knop-waarde 1/2/3 = "hoeveel widgets passen op deze rij".
                // Vertaal naar CSS-grid-span op een 12-koloms grid:
                //   1 widget per rij  → span 12 (volle breedte)
                //   2 widgets per rij → span 6  (halve breedte)
                //   3 widgets per rij → span 4  (derde breedte)
                $cssSpan = match ($span) {
                    1 => 12,
                    2 => 6,
                    3 => 4,
                    default => 12,
                };
                // Hash zodat Livewire de widget opnieuw mount zodra een
                // instelling wijzigt — direct visueel resultaat.
                $optionsHash = substr(md5(json_encode($entry['options'] ?? []).':'.$span), 0, 8);
                $widgetConfig = new \Filament\Widgets\WidgetConfiguration(
                    widget: $spec['class'],
                    properties: (array) ($entry['options'] ?? []),
                );
            @endphp
            <div
                wire:key="bb-widget-{{ $entry['id'] }}-{{ $optionsHash }}"
                data-widget-id="{{ $entry['id'] }}"
                @class([
                    'bb-dashboard-tile',
                    'bb-dashboard-tile--editing' => $this->isEditing,
                ])
                style="--bb-tile-span: {{ $cssSpan }};"
            >
                @if ($this->isEditing)
                    <div class="bb-dashboard-tile__overlay">
                        <span class="bb-dashboard-tile__label">
                            <x-filament::icon :icon="$spec['icon']" class="bb-dashboard-tile__label-icon" />
                            {{ $spec['label'] }}
                        </span>

                        <span class="bb-dashboard-tile__actions">
                            {{-- Breedte-segment-control --}}
                            <span class="bb-dashboard-tile__span-group" role="group" aria-label="Breedte">
                                @foreach ([1, 2, 3] as $option)
                                    <button
                                        type="button"
                                        @class([
                                            'bb-dashboard-tile__span-btn',
                                            'bb-dashboard-tile__span-btn--active' => $span === $option,
                                        ])
                                        title="{{ $option }} kolom{{ $option === 1 ? '' : 'men' }}"
                                        wire:click="setSpan('{{ $entry['id'] }}', {{ $option }})"
                                    >{{ $option }}</button>
                                @endforeach
                            </span>

                            @if ($hasOptions)
                                <button
                                    type="button"
                                    title="Instellingen"
                                    class="bb-dashboard-tile__action"
                                    wire:click="mountAction('editWidget', { id: '{{ $entry['id'] }}' })"
                                >
                                    <x-filament::icon icon="heroicon-o-pencil-square" />
                                </button>
                            @endif

                            <button
                                type="button"
                                title="Verbergen"
                                class="bb-dashboard-tile__action"
                                wire:click="hideWidget('{{ $entry['id'] }}')"
                            >
                                <x-filament::icon icon="heroicon-o-eye-slash" />
                            </button>

                            <span class="bb-dashboard-tile__action bb-dashboard-tile__handle" title="Verplaatsen">
                                <x-filament::icon icon="heroicon-o-arrows-up-down" />
                            </span>
                        </span>
                    </div>
                @endif

                <div @class(['bb-dashboard-tile__content', 'bb-dashboard-tile__content--editing' => $this->isEditing])>
                    <x-filament-widgets::widgets
                        :columns="['default' => 1]"
                        :widgets="[$widgetConfig]"
                    />
                </div>
            </div>
        @endforeach
    </div>

    {{-- Beschikbare widgets-overlay --}}
    @if ($this->isEditing)
        @php $hidden = $this->getHiddenWidgets(); @endphp
        <div class="bb-dashboard-library">
            <div class="bb-dashboard-library__header">
                <p class="bb-dashboard-library__title">Beschikbare widgets</p>
                <p class="bb-dashboard-library__subtitle">
                    @if (count($hidden) === 0)
                        Alle widgets staan al op je dashboard.
                    @else
                        Klik om toe te voegen aan je dashboard.
                    @endif
                </p>
            </div>
            @if (count($hidden) > 0)
                <div class="bb-dashboard-library__items">
                    @foreach ($hidden as $w)
                        <button
                            type="button"
                            wire:click="showWidget('{{ $w['entry']['id'] }}')"
                            class="bb-dashboard-library__item"
                        >
                            <span class="bb-dashboard-library__item-icon">
                                <x-filament::icon :icon="$w['spec']['icon']" />
                            </span>
                            <span class="bb-dashboard-library__item-text">
                                <span class="bb-dashboard-library__item-label">{{ $w['spec']['label'] }}</span>
                                <span class="bb-dashboard-library__item-desc">{{ $w['spec']['description'] }}</span>
                            </span>
                            <x-filament::icon icon="heroicon-o-plus" class="bb-dashboard-library__item-add" />
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- Notify Alpine wanneer Livewire de edit-status wijzigt --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', ({ component }) => {
                if (component.name && component.name.endsWith('dashboard')) {
                    window.dispatchEvent(new CustomEvent('edit-mode-changed', {
                        detail: { enabled: component.snapshot.data.isEditing }
                    }));
                }
            });
        });
    </script>

    {{-- SortableJS via CDN — alleen tijdens edit-modus actief --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js" defer></script>
    <script>
        window.dashboardSortable = function ({ enabled }) {
            return {
                instance: null,
                enabled,
                init() {
                    this.applyState();
                    this.$watch('enabled', () => this.applyState());
                },
                setEnabled(value) {
                    this.enabled = !! value;
                },
                applyState() {
                    if (this.enabled) {
                        this.activate();
                    } else {
                        this.deactivate();
                    }
                },
                activate() {
                    if (this.instance) return;
                    if (typeof Sortable === 'undefined') {
                        setTimeout(() => this.activate(), 100);
                        return;
                    }
                    this.instance = Sortable.create(this.$el, {
                        animation: 150,
                        handle: '.bb-dashboard-tile__handle',
                        draggable: '.bb-dashboard-tile',
                        ghostClass: 'bb-dashboard-tile--ghost',
                        chosenClass: 'bb-dashboard-tile--chosen',
                        dragClass: 'bb-dashboard-tile--dragging',
                        onEnd: () => {
                            const ids = Array.from(this.$el.querySelectorAll('[data-widget-id]'))
                                .map(el => el.getAttribute('data-widget-id'));
                            this.$wire.reorderWidgets(ids);
                        },
                    });
                },
                deactivate() {
                    if (this.instance) {
                        this.instance.destroy();
                        this.instance = null;
                    }
                },
            };
        };
    </script>
</x-filament-panels::page>
