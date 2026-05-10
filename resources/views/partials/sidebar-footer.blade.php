@php
    use App\Support\Demo;
    use App\Support\Version;
    $hasUpdate = rescue(fn () => Version::hasUpdate(), false, false);
    $latest = $hasUpdate ? Version::latest() : null;
    $updatesUrl = Demo::panelUrl('updates');
@endphp
<div class="ma-sidebar-footer">
    <span>
        BankBird
        <a href="{{ $updatesUrl }}" style="color: inherit; text-decoration: none; opacity: 0.85;">
            v{{ Version::current() }}
        </a>
        @if ($hasUpdate)
            <a href="{{ $updatesUrl }}" style="display:inline-flex; align-items:center; gap:0.25rem; background:#FF8A3D; color:white; font-size:0.625rem; font-weight:700; padding:0.1rem 0.45rem; border-radius:99px; text-decoration:none; margin-left:0.4rem; vertical-align:middle;" title="Nieuwe versie v{{ $latest }} beschikbaar">
                ↑ v{{ $latest }}
            </a>
        @endif
    </span>
    <span>Built with care by <a href="https://aivionstudios.nl" target="_blank" rel="noopener">Aivion Studios</a></span>
</div>
