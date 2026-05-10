@extends('pdf.layouts.report')

@section('title', 'Jaaroverzicht ' . $report['year'])
@section('header_title', 'Jaaroverzicht ' . $report['year'])
@section('header_subtitle', 'Maand voor maand')

@section('content')
    {{-- Totals --}}
    <table class="totals">
        <tr>
            <td class="bg-green">
                <p class="label">Totaal inkomsten</p>
                <p class="value">€ {{ number_format($report['totalIncome'], 2, ',', '.') }}</p>
            </td>
            <td class="bg-orange">
                <p class="label">Totaal uitgaven</p>
                <p class="value">€ {{ number_format($report['totalExpenses'], 2, ',', '.') }}</p>
            </td>
            <td class="{{ $report['totalNet'] >= 0 ? 'bg-blue' : 'bg-navy' }}">
                <p class="label">Netto over jaar</p>
                <p class="value">€ {{ number_format($report['totalNet'], 2, ',', '.') }}</p>
            </td>
        </tr>
    </table>

    {{-- Maandtabel --}}
    <div class="section">
        <h2 class="section-title">{{ $report['year'] }} — maand voor maand</h2>

        <table class="data data--compact">
            <thead>
                <tr>
                    <th>Maand</th>
                    <th class="text-right">Inkomsten</th>
                    <th class="text-right">Uitgaven</th>
                    <th class="text-right">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report['rows'] as $row)
                    <tr>
                        <td><span class="strong" style="text-transform: capitalize;">{{ $row['month'] }}</span></td>
                        <td class="text-right {{ $row['income'] > 0 ? 'pos' : 'muted' }}">
                            {{ $row['income'] > 0 ? '€ ' . number_format($row['income'], 2, ',', '.') : '—' }}
                        </td>
                        <td class="text-right {{ $row['expenses'] > 0 ? 'neg' : 'muted' }}">
                            {{ $row['expenses'] > 0 ? '€ ' . number_format($row['expenses'], 2, ',', '.') : '—' }}
                        </td>
                        <td class="text-right strong {{ $row['net'] >= 0 ? 'pos' : 'neg' }}">
                            € {{ number_format($row['net'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="strong">Totaal</td>
                    <td class="text-right pos">€ {{ number_format($report['totalIncome'], 2, ',', '.') }}</td>
                    <td class="text-right neg">€ {{ number_format($report['totalExpenses'], 2, ',', '.') }}</td>
                    <td class="text-right strong {{ $report['totalNet'] >= 0 ? 'pos' : 'neg' }}">
                        € {{ number_format($report['totalNet'], 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Categorieën totaal jaar --}}
    @if ($categoryBreakdown->isNotEmpty())
        <div class="section section--keep-together">
            <h2 class="section-title">Uitgaven per categorie (heel jaar)</h2>
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
                    @foreach ($categoryBreakdown as $cat)
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
        </div>
    @endif

    {{-- Top merchants jaar --}}
    @if ($topMerchants->isNotEmpty())
        <div class="section section--keep-together">
            <h2 class="section-title">Top merchants (heel jaar)</h2>
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
