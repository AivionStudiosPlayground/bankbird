<x-filament-widgets::widget>
    <x-filament::section :icon="$icon">
        <x-slot name="heading">
            {{ $heading }}
            @if (! empty($items) && count($items) > 0)
                <span style="color:#94a3b8;font-weight:500;font-size:0.875rem;margin-left:0.375rem;">({{ count($items) }})</span>
            @endif
        </x-slot>

        @if (count($items) === 0)
            <p style="color:#6b7280;font-size:0.875rem;font-style:italic;margin:0;">{{ $emptyMessage }}</p>
        @else
            <ul style="display:flex;flex-direction:column;gap:0.5rem;list-style:none;margin:0;padding:0;">
                @foreach ($items as $item)
                    <li>
                        @php $clickable = ! empty($item['filter_url']); @endphp
                        <{{ $clickable ? 'a' : 'div' }}
                            @if ($clickable) href="{{ $item['filter_url'] }}" wire:navigate @endif
                            style="display:flex;align-items:center;gap:0.875rem;padding:0.625rem 0.75rem;border:1px solid #E5EDF5;border-radius:0.625rem;background:#ffffff;text-decoration:none;color:inherit;{{ $clickable ? 'cursor:pointer;transition:background 0.15s, border-color 0.15s;' : '' }}"
                            @if ($clickable) onmouseover="this.style.background='#F0F6FF';this.style.borderColor='#1E88E5';" onmouseout="this.style.background='#ffffff';this.style.borderColor='#E5EDF5';" @endif
                        >
                            {{-- Logo --}}
                            <div style="flex-shrink:0;width:32px;height:32px;border-radius:0.5rem;background:#F0F6FF;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                @if ($item['logo_url'])
                                    <img src="{{ $item['logo_url'] }}" alt="" style="max-width:100%;max-height:100%;object-fit:contain;">
                                @else
                                    <x-filament::icon icon="heroicon-o-arrow-path" style="width:1rem;height:1rem;color:#94A3B8;" />
                                @endif
                            </div>

                            {{-- Naam + subtitle --}}
                            <div style="flex:1;min-width:0;">
                                <div style="font-weight:600;color:#1a2332;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item['name'] }}</div>
                                <div style="font-size:0.75rem;color:#6b7280;">
                                    elke maand rond de {{ $item['day_of_month'] }}{{ in_array($item['day_of_month'], [1, 8, 21, 28]) ? 'ste' : 'e' }}
                                    @if ($item['subtitle'])
                                        · {{ $item['subtitle'] }}
                                    @endif
                                </div>
                            </div>

                            {{-- Bedrag --}}
                            <div style="flex-shrink:0;text-align:right;">
                                <div style="font-weight:700;color:{{ $amountColor }};font-size:0.9375rem;">€&nbsp;{{ number_format($item['average_amount'], 2, ',', '.') }}</div>
                                <div style="font-size:0.6875rem;color:#94a3b8;">{{ $item['occurrences'] }}× binnen 3 maanden</div>
                            </div>

                            {{-- Doorklik-pijl --}}
                            @if ($clickable)
                                <x-filament::icon icon="heroicon-m-chevron-right" style="width:1rem;height:1rem;color:#94A3B8;flex-shrink:0;" />
                            @endif
                        </{{ $clickable ? 'a' : 'div' }}>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
