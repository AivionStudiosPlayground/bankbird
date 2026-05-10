<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>BankBird — @yield('title')</title>
    <style>
        /* Vervolgpagina's krijgen 60pt top + 70pt bottom marge zodat
           tekst niet onder de printer-rand valt. De eerste pagina heeft
           geen top-marge zodat de blauwe header tegen de bovenrand zit. */
        @page { margin: 60pt 0 70pt 0; }
        @page :first { margin-top: 0; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            color: #1a2332;
            font-size: 10pt;
            line-height: 1.5;
        }

        .page { padding: 32px 40px 56px 40px; }

        /* ───── Header ───── */
        .header {
            background: #1E88E5;
            color: #ffffff;
            padding: 28px 40px 32px 40px;
            margin: 0 0 24px 0;
        }
        .header table { width: 100%; border-collapse: collapse; }
        .header td { vertical-align: middle; padding: 0; }
        .header .logo { width: 80px; }
        .header .logo img { height: 64px; width: auto; display: block; }
        .header .title { padding-left: 20px; }
        .header .title h1 {
            margin: 0;
            font-size: 22pt;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.15;
        }
        .header .title p {
            margin: 4px 0 0 0;
            font-size: 11pt;
            opacity: 0.85;
        }

        /* ───── Totals cards ───── */
        .totals { width: 100%; border-collapse: separate; border-spacing: 8px 0; margin-bottom: 28px; }
        .totals tr { page-break-inside: avoid; }
        .totals td {
            border-radius: 8px;
            padding: 18px 16px;
            color: #ffffff;
            width: 33.33%;
            vertical-align: top;
        }
        .totals .label {
            font-size: 9pt;
            opacity: 0.85;
            margin: 0 0 6px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .totals .value {
            font-size: 17pt;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.3px;
        }
        .bg-green { background: #16C784; }
        .bg-orange { background: #FF8A3D; }
        .bg-blue { background: #1E88E5; }
        .bg-navy { background: #0D47A1; }

        /* ───── Section ───── */
        .section { margin-bottom: 28px; }
        /* Opt-in: alleen kleine secties die als blok bij elkaar moeten blijven */
        .section--keep-together { page-break-inside: avoid; }
        .section-title {
            font-size: 12pt;
            font-weight: 800;
            color: #1a2332;
            margin: 0 0 12px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #E5EDF5;
            page-break-after: avoid;
        }

        /* ───── Tables ───── */
        table.data {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }
        table.data thead { display: table-header-group; }
        table.data tr { page-break-inside: avoid; }
        table.data th {
            background: #F0F6FF;
            color: #344054;
            font-weight: 700;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid #DDEAF3;
            font-size: 8.5pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table.data td {
            padding: 10px 12px;
            border-bottom: 1px solid #EEF3F7;
            vertical-align: middle;
        }
        table.data tr:last-child td { border-bottom: 0; }

        /* Compacte variant — voor lange tabellen die anders te veel ruimte
           innemen (zoals het maand-voor-maand jaaroverzicht). */
        table.data--compact th { padding: 7px 12px; }
        table.data--compact td { padding: 5px 12px; }
        table.data tfoot td {
            background: #F0F6FF;
            font-weight: 700;
            border-top: 2px solid #DDEAF3;
            border-bottom: 0;
        }
        .text-right { text-align: right; }
        .muted { color: #667085; }
        .strong { font-weight: 700; }
        .pos { color: #0A9660; }
        .neg { color: #D02B2B; }

        .swatch {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            margin-right: 8px;
            vertical-align: middle;
        }

        .merchant-logo {
            height: 18px;
            width: auto;
            vertical-align: middle;
            margin-right: 8px;
        }

        .empty {
            text-align: center;
            color: #667085;
            font-style: italic;
            padding: 20px;
        }

        /* ───── Footer ───── */
        .footer {
            position: fixed;
            bottom: 18pt;
            left: 40pt;
            right: 40pt;
            border-top: 1px solid #E5EDF5;
            padding-top: 10pt;
            font-size: 8pt;
            color: #667085;
        }
        .footer table { width: 100%; border-collapse: collapse; }
        .footer td { padding: 0; vertical-align: top; }
        .footer .col-mid { text-align: center; }
        .footer .col-right { text-align: right; }
        .footer .made {
            font-weight: 700;
            color: #1E88E5;
        }
    </style>
</head>
<body>

<div class="header">
    <table>
        <tr>
            <td class="logo">
                @if (file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="BankBird">
                @endif
            </td>
            <td class="title">
                <h1>@yield('header_title')</h1>
                <p>@yield('header_subtitle')</p>
            </td>
        </tr>
    </table>
</div>

<div class="page">
    @yield('content')
</div>

<div class="footer">
    <table>
        <tr>
            <td>
                Made with <span class="made">BankBird</span> v{{ $version }} · bankbird.app
            </td>
            <td class="col-mid">
                Gegenereerd op {{ $generatedAt }}
            </td>
            {{-- Derde cel blijft visueel leeg; page_text vult 'm met "Pagina X van Y" --}}
            <td class="col-right">&nbsp;</td>
        </tr>
    </table>
</div>

{{-- Pagina-teller op elke pagina via DomPDF page_text (counter(pages) is in
     DomPDF onbetrouwbaar — page_text vervangt {PAGE_NUM} en {PAGE_COUNT}
     correct na de tweede render-pass). Vereist isPhpEnabled in DomPDF. --}}
<script type="text/php">
if (isset($pdf)) {
    $font = $fontMetrics->getFont("DejaVu Sans", "normal");
    $size = 8;
    $text = "Pagina {PAGE_NUM} van {PAGE_COUNT}";
    $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
    $pageWidth = 595;
    $rightMargin = 40;
    $yPos = 814; // gelijk aan footer-baseline (842pt - 28pt)
    $pdf->page_text($pageWidth - $rightMargin - $textWidth, $yPos, $text, $font, $size, [0.40, 0.44, 0.52]);
}
</script>

</body>
</html>
