<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BankBird') — Persoonlijke Financiële Administratie</title>
    <meta name="description" content="@yield('description', 'BankBird is jouw vriendelijke open-source financiële administratie. Importeer bankafschriften, categoriseer automatisch en krijg helder inzicht in je geld.')">
    <link rel="icon" type="image/png" href="{{ asset('images/bird.png') }}">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:title"       content="@yield('title', 'BankBird') — Persoonlijke Financiële Administratie">
    <meta property="og:description" content="@yield('description', 'BankBird is jouw vriendelijke open-source financiële administratie. Importeer bankafschriften, categoriseer automatisch en krijg helder inzicht in je geld.')">
    <meta property="og:image"       content="{{ asset('images/og-image.png') }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name"   content="BankBird">
    <meta property="og:locale"      content="nl_NL">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', 'BankBird') — Persoonlijke Financiële Administratie">
    <meta name="twitter:description" content="@yield('description', 'BankBird is jouw vriendelijke open-source financiële administratie.')">
    <meta name="twitter:image"       content="{{ asset('images/og-image.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; overflow-x: hidden; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #F0F6FF;
            color: #0B1F3A;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }
        /* Prevent long words / URLs from breaking layout */
        p, li, td, th { overflow-wrap: break-word; word-break: break-word; }
        code { overflow-wrap: break-word; word-break: break-all; font-family: 'JetBrains Mono','Fira Code',ui-monospace,monospace; }

        /* ── Tokens ─────────────────────────────── */
        :root {
            --blue:       #1E88E5;
            --blue-mid:   #1565C0;
            --blue-dark:  #0D47A1;
            --blue-light: #E3F2FD;
            --blue-soft:  #EEF5FF;
            --navy:       #0B1F3A;
            --green:      #16C784;
            --orange:     #FF8A3D;
            --surface:    #FFFFFF;
            --border:     #DDEAF3;
            --muted:      #6B7A99;
            --radius-sm:  0.625rem;
            --radius-md:  1rem;
            --radius-lg:  1.5rem;
            --shadow-sm:  0 2px 8px rgba(30,136,229,0.08);
            --shadow-md:  0 4px 24px rgba(30,136,229,0.12);
            --shadow-lg:  0 8px 48px rgba(30,136,229,0.16);
        }

        /* ── Animations ─────────────────────────── */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-1deg); }
            50%       { transform: translateY(-14px) rotate(1deg); }
        }
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-8px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(30,136,229,0.3); }
            50%       { box-shadow: 0 0 0 12px rgba(30,136,229,0); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        /* ── Navbar ─────────────────────────────── */
        .bb-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(30,136,229,0.1);
            box-shadow: 0 1px 20px rgba(30,136,229,0.08);
            overflow: visible;
        }
        .bb-nav-inner {
            max-width: 1200px; margin: 0 auto;
            padding: 0 1.5rem;
            height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            overflow: visible;
        }
        @keyframes logo-waddle {
            0%   { transform: rotate(-2deg) translateY(0px); }
            25%  { transform: rotate(1.5deg) translateY(-4px); }
            50%  { transform: rotate(-1deg) translateY(-2px); }
            75%  { transform: rotate(2deg) translateY(-5px); }
            100% { transform: rotate(-2deg) translateY(0px); }
        }
        @keyframes logo-boing {
            0%   { transform: scale(1) rotate(0deg); }
            30%  { transform: scale(1.12) rotate(-4deg); }
            50%  { transform: scale(0.95) rotate(3deg); }
            70%  { transform: scale(1.08) rotate(-2deg); }
            100% { transform: scale(1) rotate(0deg); }
        }
        .bb-logo-wrap {
            display: flex; align-items: flex-end;
            position: relative; z-index: 101;
            margin-bottom: -80px;
        }
        .bb-logo-img {
            height: 170px; width: auto; display: block;
            filter: drop-shadow(0 10px 28px rgba(30,136,229,0.28));
            animation: logo-waddle 3.5s ease-in-out infinite;
            cursor: pointer;
        }
        .bb-logo-img:hover { animation: logo-boing 0.55s ease forwards; }
        .bb-nav-links { display: flex; align-items: center; gap: 0.25rem; }
        .bb-nav-link {
            font-size: 0.875rem; font-weight: 500; color: #6B7A99;
            text-decoration: none; padding: 0.4rem 0.875rem;
            border-radius: 0.5rem;
            transition: color 0.15s, background 0.15s;
        }
        .bb-nav-link:hover { color: #1E88E5; background: #EEF5FF; }
        .bb-nav-link.active { color: #1E88E5; background: #EEF5FF; font-weight: 600; }
        .bb-nav-link.github { display: flex; align-items: center; gap: 0.375rem; }

        /* ── Hamburger ───────────────────────────── */
        .bb-hamburger {
            display: none; flex-direction: column; gap: 5px;
            background: none; border: none; cursor: pointer;
            padding: 0.5rem; border-radius: 0.5rem;
            transition: background 0.15s;
        }
        .bb-hamburger:hover { background: #EEF5FF; }
        .bb-hamburger span {
            display: block; width: 22px; height: 2px;
            background: #0B1F3A; border-radius: 99px;
            transition: transform 0.25s, opacity 0.25s;
        }
        .bb-mobile-menu {
            display: none; position: fixed; inset: 0; z-index: 99;
        }
        .bb-mobile-menu.open { display: block; }
        .bb-mobile-overlay {
            position: absolute; inset: 0;
            background: rgba(11,31,58,0.4);
            backdrop-filter: blur(4px);
        }
        .bb-mobile-panel {
            position: absolute; top: 0; left: 0; right: 0;
            background: white;
            padding: 1rem 1.5rem 2rem;
            border-radius: 0 0 1.5rem 1.5rem;
            box-shadow: 0 8px 40px rgba(11,31,58,0.15);
            transform: translateY(-100%);
            transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
        }
        .bb-mobile-menu.open .bb-mobile-panel { transform: translateY(0); }
        .bb-mobile-panel-top {
            display: flex; align-items: center; justify-content: space-between;
            height: 64px; margin-bottom: 1rem;
            border-bottom: 1px solid #EEF5FF; padding-bottom: 1rem;
        }
        .bb-mobile-nav { display: flex; flex-direction: column; gap: 0.25rem; }
        .bb-mobile-nav a {
            font-size: 1rem; font-weight: 600; color: #0B1F3A;
            text-decoration: none; padding: 0.75rem 1rem;
            border-radius: 0.75rem; transition: background 0.15s, color 0.15s;
            display: flex; align-items: center; justify-content: space-between;
        }
        .bb-mobile-nav a:hover { background: #EEF5FF; color: #1E88E5; }
        .bb-mobile-nav a.active { background: #EEF5FF; color: #1E88E5; }
        .bb-close-btn {
            background: #F0F6FF; border: none; cursor: pointer;
            width: 2.25rem; height: 2.25rem; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.125rem; color: #6B7A99; transition: background 0.15s;
        }
        .bb-close-btn:hover { background: #DDEAF3; }

        /* ── Buttons ─────────────────────────────── */
        .bb-btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: linear-gradient(135deg, #1E88E5, #1565C0);
            color: #fff; border-radius: 0.75rem;
            font-weight: 700; font-size: 0.9375rem;
            padding: 0.65rem 1.5rem; text-decoration: none; border: none; cursor: pointer;
            box-shadow: 0 4px 16px rgba(30,136,229,0.35);
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .bb-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(30,136,229,0.45); }
        .bb-btn:active { transform: translateY(0); }
        .bb-btn-sm { padding: 0.45rem 1rem; font-size: 0.8125rem; border-radius: 0.625rem; }
        .bb-btn-lg { padding: 0.875rem 2rem; font-size: 1.0625rem; }
        .bb-btn-outline {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: white; color: #1E88E5;
            border: 2px solid #1E88E5; border-radius: 0.75rem;
            font-weight: 700; font-size: 0.9375rem;
            padding: 0.625rem 1.5rem; text-decoration: none; cursor: pointer;
            transition: transform 0.18s, background 0.15s, box-shadow 0.18s;
        }
        .bb-btn-outline:hover { background: #EEF5FF; transform: translateY(-2px); }
        .bb-btn-white {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: white; color: #1E88E5;
            border-radius: 0.75rem; font-weight: 700; font-size: 0.9375rem;
            padding: 0.65rem 1.5rem; text-decoration: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .bb-btn-white:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(0,0,0,0.2); }
        .bb-btn-ghost-white {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(255,255,255,0.12); color: white;
            border: 2px solid rgba(255,255,255,0.3); border-radius: 0.75rem;
            font-weight: 600; font-size: 0.9375rem;
            padding: 0.625rem 1.5rem; text-decoration: none;
            transition: background 0.15s, transform 0.18s;
        }
        .bb-btn-ghost-white:hover { background: rgba(255,255,255,0.22); transform: translateY(-2px); }

        /* ── Cards ─────────────────────────────── */
        .bb-card {
            background: white;
            border: 1px solid rgba(30,136,229,0.1);
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px rgba(30,136,229,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .bb-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(30,136,229,0.14); }
        .bb-card-flat {
            background: white;
            border: 1px solid rgba(30,136,229,0.1);
            border-radius: 1.25rem;
        }

        /* ── Badges ─────────────────────────────── */
        .bb-pill {
            display: inline-flex; align-items: center; gap: 0.375rem;
            background: #E3F2FD; color: #1565C0;
            border: 1px solid rgba(30,136,229,0.25);
            border-radius: 99px; font-size: 0.75rem; font-weight: 700;
            padding: 0.25rem 0.875rem;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        .bb-pill-green  { background: #E8F5E9; color: #1B5E20; border-color: rgba(22,199,132,0.3); }
        .bb-pill-orange { background: #FFF3E0; color: #BF360C; border-color: rgba(255,138,61,0.3); }

        /* ── Section helpers ────────────────────── */
        .bb-section    { padding: 6rem 1.5rem; }
        .bb-section-sm { padding: 4rem 1.5rem; }
        .bb-wrap    { max-width: 1200px; margin: 0 auto; }
        .bb-wrap-sm { max-width: 860px;  margin: 0 auto; }

        /* ── Responsive grid helpers ─────────────── */
        .bb-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; }
        .bb-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem; }
        .bb-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.5rem; }
        .bb-grid-5 { display: grid; grid-template-columns: repeat(5,1fr); gap: 1rem; }
        /* Prevent children from expanding grid beyond viewport (min-width:auto default causes pre/code overflow) */
        .bb-grid-2 > *, .bb-grid-3 > *, .bb-grid-4 > *, .bb-grid-5 > * { min-width: 0; }
        /* Code blocks: never wider than their container */
        .bb-code-block { max-width: 100%; }

        /* ── Gradient text ──────────────────────── */
        .bb-gradient-text {
            background: linear-gradient(135deg, #1E88E5 0%, #42A5F5 50%, #1565C0 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
        }

        /* ── Code blocks ────────────────────────── */
        .bb-code-block {
            background: #0D1B2E;
            border-radius: 1rem; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.06);
        }
        .bb-code-bar {
            display: flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            background: rgba(255,255,255,0.03);
        }
        .bb-dot { width: 11px; height: 11px; border-radius: 50%; }
        .bb-code-block pre {
            margin: 0; padding: 1.25rem;
            font-family: 'JetBrains Mono', 'Fira Code', ui-monospace, monospace;
            font-size: 0.8125rem; line-height: 1.8;
            color: rgba(255,255,255,0.82); overflow-x: auto;
        }
        .tok-k  { color: #7EC8E3; }
        .tok-s  { color: #95E88A; }
        .tok-c  { color: rgba(255,255,255,0.32); }
        .tok-v  { color: #FFD080; }
        .tok-fn { color: #C792EA; }

        /* ── Footer ─────────────────────────────── */
        .bb-footer { background: linear-gradient(180deg, #0B1F3A 0%, #071424 100%); }

        /* ── Scroll-reveal ──────────────────────── */
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.5s ease, transform 0.5s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── Alert boxes ────────────────────────── */
        .bb-alert { border-radius: 0.875rem; padding: 1rem 1.25rem; display: flex; gap: 0.75rem; align-items: flex-start; }
        .bb-alert-blue   { background: #EEF5FF; border: 1px solid rgba(30,136,229,0.2);   color: #1565C0; }
        .bb-alert-green  { background: #E8F5E9; border: 1px solid rgba(22,199,132,0.25);  color: #1B5E20; }
        .bb-alert-orange { background: #FFF3E0; border: 1px solid rgba(255,138,61,0.25);  color: #BF360C; }

        /* ══ RESPONSIVE ══════════════════════════════ */

        /* Tablet (≤ 860px) */
        @media (max-width: 860px) {
            .hidden-mobile { display: none !important; }
            [class*="bb-grid-2"] { grid-template-columns: 1fr !important; gap: 2rem !important; }
            .bb-grid-5 { grid-template-columns: repeat(3,1fr) !important; }
        }

        /* Mobile (≤ 640px) */
        @media (max-width: 640px) {
            .bb-hamburger  { display: flex; }
            .bb-nav-links  { display: none; }
            .bb-btn.bb-btn-sm { display: none; }

            .bb-nav-inner  { height: 56px; }
            main           { padding-top: 56px !important; }

            .bb-logo-wrap  { margin-bottom: -30px; }
            .bb-logo-img   { height: 100px; }

            .bb-section    { padding: 3rem 1.25rem; }
            .bb-section-sm { padding: 2.5rem 1.25rem; }

            .bb-grid-3 { grid-template-columns: 1fr !important; }
            .bb-grid-4 { grid-template-columns: repeat(2,1fr) !important; gap: 0.875rem !important; }
            .bb-grid-5 { grid-template-columns: repeat(2,1fr) !important; }

            .bb-hero-bird-col { display: none !important; }

            /* Hero images: don't let them overflow on small screens */
            .bb-hero-img { max-height: 160px !important; max-width: calc(100vw - 3rem) !important; width: auto !important; }

            /* Reduce card padding on small screens */
            .bb-card, .bb-card-flat { padding: 1.25rem !important; }

            /* Center button groups in CTAs */
            .bb-flex-center { justify-content: center !important; }

            .bb-btn-lg { padding: 0.75rem 1.375rem; font-size: 0.9375rem; }

            /* Clip decorative blobs so they don't cause horizontal overflow */
            section { overflow: hidden; }

            /* Reduce padding on gradient cards that don't use .bb-card */
            .bb-gradient-card { padding: 1.5rem !important; }

            /* Prevent pre/code from causing horizontal overflow on mobile */
            .bb-code-block pre { white-space: pre-wrap; overflow-wrap: break-word; word-break: break-all; }
            pre { max-width: 100%; overflow-x: auto; }

            /* Responsive data tables: scroll within container, not the page */
            .bb-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }

        /* Extra small (≤ 400px) */
        @media (max-width: 400px) {
            .bb-grid-4 { grid-template-columns: 1fr 1fr !important; }
        }
    </style>
</head>
<body>

<nav class="bb-nav">
    <div class="bb-nav-inner">
        <a href="{{ url('/') }}" class="bb-logo-wrap" style="text-decoration:none;">
            <img src="{{ asset('images/bankbird-logo.png') }}" alt="BankBird" class="bb-logo-img">
        </a>

        <div class="bb-nav-links">
            <a href="{{ url('/') }}"           class="bb-nav-link @if(request()->is('/'))          active @endif">Home</a>
            <a href="{{ url('/install') }}"     class="bb-nav-link @if(request()->is('install'))    active @endif">Installatie</a>
            <a href="{{ url('/kennisbank') }}"  class="bb-nav-link @if(request()->is('kennisbank')) active @endif">Kennisbank</a>
            <a href="{{ url('/docs') }}"        class="bb-nav-link @if(request()->is('docs'))       active @endif">Docs</a>
            <a href="{{ url('/vibe-dev') }}"    class="bb-nav-link @if(request()->is('vibe-dev'))   active @endif">Vibe Dev</a>
            <a href="{{ url('/over') }}"        class="bb-nav-link @if(request()->is('over'))       active @endif">Over</a>
            <a href="{{ url('/updates') }}"     class="bb-nav-link @if(request()->is('updates'))    active @endif" style="position:relative;">
                Updates
                <span style="position:absolute;top:-4px;right:-8px;background:#FF8A3D;color:white;font-size:0.5rem;font-weight:800;padding:0.1rem 0.35rem;border-radius:99px;text-transform:uppercase;letter-spacing:0.04em;">Nieuw</span>
            </a>
            <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank" class="bb-nav-link github">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                GitHub
            </a>
        </div>

        <div style="display:flex;align-items:center;gap:0.75rem;">
            <a href="https://demo.bankbird.app/" target="_blank" class="bb-btn bb-btn-sm">
                🐦 Demo
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
            </a>
            <a href="{{ url('/install') }}" class="bb-btn bb-btn-sm">
                Aan de slag
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"/></svg>
            </a>
            <button class="bb-hamburger" onclick="openMobileMenu()" aria-label="Menu openen">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

{{-- Mobile menu --}}
<div class="bb-mobile-menu" id="mobileMenu">
    <div class="bb-mobile-overlay" onclick="closeMobileMenu()"></div>
    <div class="bb-mobile-panel">
        <div class="bb-mobile-panel-top">
            <img src="{{ asset('images/bankbird-logo.png') }}" alt="BankBird" style="height:36px;width:auto;">
            <button class="bb-close-btn" onclick="closeMobileMenu()" aria-label="Menu sluiten">✕</button>
        </div>
        <nav class="bb-mobile-nav">
            <a href="{{ url('/') }}"           class="@if(request()->is('/'))          active @endif">🏠 Home <span>→</span></a>
            <a href="{{ url('/install') }}"     class="@if(request()->is('install'))    active @endif">🚀 Installatie <span>→</span></a>
            <a href="{{ url('/kennisbank') }}"  class="@if(request()->is('kennisbank')) active @endif">📖 Kennisbank <span>→</span></a>
            <a href="{{ url('/docs') }}"        class="@if(request()->is('docs'))       active @endif">📚 Documentatie <span>→</span></a>
            <a href="{{ url('/vibe-dev') }}"    class="@if(request()->is('vibe-dev'))   active @endif">🛠️ Vibe Development <span>→</span></a>
            <a href="{{ url('/over') }}"        class="@if(request()->is('over'))       active @endif">👋 Over <span>→</span></a>
            <a href="{{ url('/updates') }}"     class="@if(request()->is('updates'))    active @endif">✨ Updates <span style="background:#FF8A3D;color:white;font-size:0.625rem;font-weight:800;padding:0.1rem 0.5rem;border-radius:99px;">Nieuw</span></a>
            <a href="https://github.com/AivionStudiosPlayground/bankbird" target="_blank">💻 GitHub <span>↗</span></a>
        </nav>
        <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #EEF5FF;">
            <a href="{{ url('/install') }}" class="bb-btn" style="width:100%;justify-content:center;" onclick="closeMobileMenu()">
                Aan de slag →
            </a>
        </div>
    </div>
</div>

<main style="padding-top: 64px; position: relative; z-index: 1;">
    @yield('content')
</main>

<footer class="bb-footer" style="padding: 3.5rem 1.5rem;">
    <div class="bb-wrap">
        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:2rem; margin-bottom:2rem;">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <img src="{{ asset('images/bird.png') }}" alt="BankBird" style="height:48px;width:auto;">
                <div>
                    <div style="font-size:1.125rem;font-weight:800;color:white;">BankBird</div>
                    <div style="font-size:0.75rem;color:rgba(255,255,255,0.4);">Open-source · AGPL-3.0</div>
                </div>
            </div>
            <nav style="display:flex; flex-wrap:wrap; gap:0.25rem;">
                @foreach([['/', 'Home'], ['/demo', 'Demo'], ['/install', 'Installatie'], ['/kennisbank', 'Kennisbank'], ['/docs', 'Documentatie'], ['/vibe-dev', 'Vibe Dev'], ['/over', 'Over'], ['/updates', 'Updates'], ['https://github.com/AivionStudiosPlayground/bankbird', 'GitHub ↗']] as [$href, $label])
                    <a href="{{ $href }}" style="font-size:0.875rem;color:rgba(255,255,255,0.45);text-decoration:none;padding:0.4rem 0.75rem;border-radius:0.5rem;transition:color 0.15s,background 0.15s;"
                       onmouseover="this.style.color='white';this.style.background='rgba(255,255,255,0.07)'" onmouseout="this.style.color='rgba(255,255,255,0.45)';this.style.background='transparent'">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.06);padding-top:1.5rem;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:1rem;">
            <div style="display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;">
                <p style="margin:0;font-size:0.75rem;color:rgba(255,255,255,0.25);">© 2026 BankBird</p>
                <a href="{{ url('/legal') }}" style="font-size:0.75rem;color:rgba(255,255,255,0.3);text-decoration:none;transition:color 0.15s;" onmouseover="this.style.color='rgba(255,255,255,0.6)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">Voorwaarden & Privacy</a>
            </div>
            <p style="margin:0;font-size:0.75rem;color:rgba(255,255,255,0.25);">
                Built with care by <a href="https://aivionstudios.nl" target="_blank" rel="noopener" style="color:rgba(255,255,255,0.45);text-decoration:none;font-weight:600;transition:color 0.15s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.45)'">Aivion Studios</a>
            </p>
        </div>
    </div>
</footer>

{{-- Beta announcement bar --}}
<div id="betaBar" style="
    position: fixed; bottom: 0; left: 0; right: 0; z-index: 200;
    background: linear-gradient(90deg, #FF8A3D 0%, #FF6B1A 100%);
    color: white;
    padding: 0.6rem 1.5rem;
    display: flex; align-items: center; justify-content: center; gap: 1rem;
    font-size: 0.8125rem; font-weight: 500;
    box-shadow: 0 -2px 20px rgba(255,138,61,0.4);
">
    <span style="display:flex;align-items:center;gap:0.5rem;">
        <span style="background:rgba(255,255,255,0.25);font-size:0.6875rem;font-weight:800;padding:0.15rem 0.5rem;border-radius:99px;text-transform:uppercase;letter-spacing:0.06em;">Beta</span>
        BankBird v1.0 is gelanceerd op 6 mei 2026 — de app kan nog instabiel zijn. Bugs melden via
        <a href="https://github.com/AivionStudiosPlayground/bankbird/issues" target="_blank" rel="noopener"
           style="color:white;font-weight:700;text-decoration:underline;text-underline-offset:2px;">GitHub Issues</a>.
    </span>
    <button onclick="closeBetaBar()" aria-label="Melding sluiten" style="
        background: rgba(255,255,255,0.2); border: none; cursor: pointer;
        color: white; width: 1.5rem; height: 1.5rem; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.875rem; line-height: 1; flex-shrink: 0;
        transition: background 0.15s;
    " onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">✕</button>
</div>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "BankBird",
  "description": "Open-source persoonlijke financiële administratie. Importeer bankafschriften, categoriseer automatisch met AI en krijg helder inzicht in je financiën.",
  "applicationCategory": "FinanceApplication",
  "operatingSystem": "Web",
  "offers": { "@type": "Offer", "price": "0", "priceCurrency": "EUR" },
  "author": { "@type": "Organization", "name": "Avion Studios", "email": "mail@avionstudios.nl" },
  "url": "{{ url('/') }}",
  "license": "https://www.gnu.org/licenses/agpl-3.0.html",
  "inLanguage": "nl"
}
</script>

<script>
    // Beta bar
    (function() {
        if (localStorage.getItem('betaBarDismissed') === '1') {
            var bar = document.getElementById('betaBar');
            if (bar) bar.style.display = 'none';
        }
    })();
    function closeBetaBar() {
        localStorage.setItem('betaBarDismissed', '1');
        document.getElementById('betaBar').style.display = 'none';
    }

    // Scroll-reveal
    const reveals = document.querySelectorAll('.reveal');
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
    }, { threshold: 0.1 });
    reveals.forEach(el => io.observe(el));

    // Mobile menu
    function openMobileMenu() {
        const m = document.getElementById('mobileMenu');
        m.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeMobileMenu() {
        const m = document.getElementById('mobileMenu');
        m.classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMobileMenu(); });
</script>

</body>
</html>
