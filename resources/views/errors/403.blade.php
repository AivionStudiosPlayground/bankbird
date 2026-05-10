@php
    $isDemo = \App\Support\Demo::active();
    $title = $isDemo ? 'Niet beschikbaar in demo' : 'Geen toegang';
    $message = $isDemo
        ? 'Aanmaken, bewerken en verwijderen zijn uitgeschakeld in de demo-omgeving. Klik hieronder om terug te gaan en de demo verder te bekijken.'
        : ($exception->getMessage() ?: 'Je hebt geen toegang tot deze pagina.');
@endphp
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — BankBird</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #EEF5FF 0%, #E3F2FD 100%);
            color: #0B1F3A;
            padding: 2rem;
        }
        .card {
            background: white;
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            max-width: 32rem;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 50px rgba(30, 136, 229, 0.15);
            border: 1px solid rgba(30, 136, 229, 0.08);
        }
        .icon {
            width: 5rem;
            height: 5rem;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #FFF4E6, #FFE9D1);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            margin-bottom: 0.75rem;
        }
        p {
            color: #6B7A99;
            line-height: 1.65;
            font-size: 0.9375rem;
            margin-bottom: 2rem;
        }
        .actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.15s, box-shadow 0.15s;
            cursor: pointer;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1E88E5, #1565C0);
            color: white;
            box-shadow: 0 4px 12px rgba(30, 136, 229, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(30, 136, 229, 0.4);
        }
        .btn-secondary {
            background: #F0F6FF;
            color: #1565C0;
        }
        .btn-secondary:hover {
            background: #DBEAFE;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #FFF4E6;
            color: #FF8A3D;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">@if($isDemo)👀@else🔒@endif</div>
        @if($isDemo)
            <span class="badge">Demo-modus</span>
        @endif
        <h1>{{ $title }}</h1>
        <p>{{ $message }}</p>
        <div class="actions">
            <button class="btn btn-primary" onclick="history.back()">
                ← Terug
            </button>
            @if($isDemo)
                <a href="{{ url('/demo') }}" class="btn btn-secondary">Naar dashboard</a>
            @endif
        </div>
    </div>
</body>
</html>
