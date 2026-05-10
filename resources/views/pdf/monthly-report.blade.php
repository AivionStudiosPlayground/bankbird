@extends('pdf.layouts.report')

@section('title', 'Maandrapport ' . $monthLabel)
@section('header_title', 'Maandrapport')
@section('header_subtitle', ucfirst($monthLabel))

@section('content')
    {{-- Totals --}}
    <table class="totals">
        <tr>
            <td class="bg-green">
                <p class="label">Inkomsten</p>
                <p class="value">€ {{ number_format($report['totalIncome'], 2, ',', '.') }}</p>
            </td>
            <td class="bg-orange">
                <p class="label">Uitgaven</p>
                <p class="value">€ {{ number_format($report['totalExpenses'], 2, ',', '.') }}</p>
            </td>
            <td class="{{ $report['net'] >= 0 ? 'bg-blue' : 'bg-navy' }}">
                <p class="label">Netto saldo</p>
                <p class="value">€ {{ number_format($report['net'], 2, ',', '.') }}</p>
            </td>
        </tr>
    </table>

    {{-- Categorieoverzicht --}}
    <div class="section section--keep-together">
        <h2 class="section-title">Uitgaven per categorie</h2>

        @if ($report['categoryBreakdown']->isEmpty())
            <p class="empty">Geen uitgaven gevonden voor deze maand.</p>
        @else
            <table class="data">
                <thead>
                    <tr>
                        <th>Categorie</th>
                        <th class="text-right">Transacties</th>
                        <th class="text-right">Bedrag</th>
                        <th class="text-right">%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report['categoryBreakdown'] as $cat)
                        <tr>
                            <td>
                                <span class="swatch" style="background-color: {{ $cat['color'] }};"></span>
                                <span class="strong">{{ $cat['name'] }}</span>
                            </td>
                            <td class="text-right muted">{{ $cat['count'] }}</td>
                            <td class="text-right strong">€ {{ number_format($cat['amount'], 2, ',', '.') }}</td>
                            <td class="text-right muted">{{ $cat['percentage'] }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Top merchants --}}
    @if ($topMerchants->isNotEmpty())
        <div class="section section--keep-together">
            <h2 class="section-title">Top merchants</h2>
            <table class="data">
                <thead>
                    <tr>
                        <th>Merchant</th>
                        <th>Categorie</th>
                        <th class="text-right">Transacties</th>
                        <th class="text-right">Bedrag</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topMerchants as $m)
                        @php
                            $rawLogo = $m['logo_url'] ? ltrim(parse_url($m['logo_url'], PHP_URL_PATH) ?? '', '/') : null;
                            $logoFile = $rawLogo ? public_path($rawLogo) : null;
                            $hasLogo = $logoFile && file_exists($logoFile);
                        @endphp
                        <tr>
                            <td>
                                @if ($hasLogo)
                                    <img class="merchant-logo" src="{{ $logoFile }}" alt="">
                                @endif
                                <span class="strong">{{ $m['name'] }}</span>
                            </td>
                            <td>
                                @if ($m['category'])
                                    <span class="swatch" style="background-color: {{ $m['category_color'] }};"></span>
                                    <span class="muted">{{ $m['category'] }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td class="text-right muted">{{ $m['count'] }}</td>
                            <td class="text-right strong">€ {{ number_format($m['amount'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
