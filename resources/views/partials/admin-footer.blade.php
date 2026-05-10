@php
    use App\Support\Version;
    $hasUpdate = rescue(fn () => Version::hasUpdate(), false, false);
    $latest = $hasUpdate ? Version::latest() : null;
    $updatesUrl = 'https://bankbird.app/updates';
@endphp
<div class="ma-page-footer">
    <span>
        BankBird
        <a href="{{ $updatesUrl }}" target="_blank" rel="noopener">v{{ Version::current() }}</a>
        @if ($hasUpdate)
            <a href="{{ $updatesUrl }}" target="_blank" rel="noopener" class="ma-page-footer__update" title="Nieuwe versie v{{ $latest }} beschikbaar">
                ↑ v{{ $latest }}
            </a>
        @endif
    </span>
    <span class="ma-page-footer__sep">·</span>
    <span>Built with care by <a href="https://aivionstudios.nl" target="_blank" rel="noopener">Aivion Studios</a></span>
</div>
