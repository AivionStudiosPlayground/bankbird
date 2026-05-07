@php
    use App\Support\Demo;
    use App\Support\Version;

    if (Demo::active()) {
        return;
    }

    $hasUpdate = rescue(fn () => Version::hasUpdate(), false, false);

    if (! $hasUpdate) {
        return;
    }

    $latest = Version::latest();
    $current = Version::current();
@endphp

<div id="bankbird-update-banner-{{ $latest }}"
     data-update-banner="{{ $latest }}"
     style="
        display: none;
        position: relative; z-index: 50;
        background: linear-gradient(90deg, #FF8A3D 0%, #FF6B1A 100%);
        color: white;
        padding: 0.625rem 1.5rem;
        font-size: 0.875rem; font-weight: 500;
        box-shadow: 0 2px 12px rgba(255,138,61,0.3);
        ">
    <div style="max-width: 1400px; margin: 0 auto; display: flex; align-items: center; justify-content: center; gap: 1rem; flex-wrap: wrap;">
        <span style="display: flex; align-items: center; gap: 0.5rem;">
            <span style="background: rgba(255,255,255,0.25); font-size: 0.6875rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 99px; text-transform: uppercase; letter-spacing: 0.06em;">Update</span>
            BankBird <strong>v{{ $latest }}</strong> is beschikbaar
            (huidig: v{{ $current }})
            &mdash;
            <a href="{{ url('/admin/updates') }}" style="color: white; font-weight: 700; text-decoration: underline; text-underline-offset: 2px;">
                bekijk wijzigingen en update-instructies →
            </a>
        </span>
        <button onclick="window.bankbirdDismissUpdateBanner('{{ $latest }}')"
                aria-label="Update-melding sluiten"
                style="background: rgba(255,255,255,0.2); border: none; cursor: pointer; color: white; width: 1.5rem; height: 1.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; line-height: 1; flex-shrink: 0; transition: background 0.15s;"
                onmouseover="this.style.background='rgba(255,255,255,0.35)'"
                onmouseout="this.style.background='rgba(255,255,255,0.2)'">✕</button>
    </div>
</div>

<script>
    (function () {
        var version = @json($latest);
        var dismissedKey = 'bankbird.updateBannerDismissed.' + version;
        var banner = document.querySelector('[data-update-banner="' + version + '"]');
        if (! banner) { return; }
        if (localStorage.getItem(dismissedKey) !== '1') {
            banner.style.display = 'block';
        }
        window.bankbirdDismissUpdateBanner = function (v) {
            localStorage.setItem('bankbird.updateBannerDismissed.' + v, '1');
            var b = document.querySelector('[data-update-banner="' + v + '"]');
            if (b) { b.style.display = 'none'; }
        };
    })();
</script>
