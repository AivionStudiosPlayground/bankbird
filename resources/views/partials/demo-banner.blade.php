@if(config('app.demo_mode', false))
    <div
        x-data="{ visible: true }"
        x-show="visible"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="
            background: linear-gradient(90deg, #0D47A1 0%, #1565C0 45%, #1E88E5 100%);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 0.6rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.875rem;
            position: relative;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            box-shadow: 0 2px 12px rgba(13,71,161,0.25);
        "
    >
        {{-- Bird icon --}}
        <span style="font-size:1.25rem;line-height:1;flex-shrink:0;" aria-hidden="true">🐦</span>

        {{-- Message --}}
        <span style="color:rgba(255,255,255,0.92);font-size:0.8125rem;font-weight:500;line-height:1.4;">
            <strong style="font-weight:700;color:white;">Demo-modus</strong>
            &mdash; Je bekijkt BankBird met voorbeelddata. Inloggen kan, wijzigingen niet.
        </span>

        {{-- CTA --}}
        <a
            href="{{ url('/install') }}"
            style="
                display: inline-flex;
                align-items: center;
                gap: 0.3rem;
                background: white;
                color: #1565C0;
                border-radius: 99px;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 0.3rem 0.875rem;
                text-decoration: none;
                white-space: nowrap;
                flex-shrink: 0;
                box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                transition: opacity 0.15s;
            "
            onmouseover="this.style.opacity='0.85'"
            onmouseout="this.style.opacity='1'"
        >
            Zelf installeren →
        </a>

        {{-- Close --}}
        <button
            @click="visible = false"
            style="
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255,255,255,0.12);
                border: 1px solid rgba(255,255,255,0.2);
                cursor: pointer;
                width: 26px;
                height: 26px;
                border-radius: 50%;
                color: white;
                font-size: 0.875rem;
                line-height: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.15s;
                flex-shrink: 0;
            "
            onmouseover="this.style.background='rgba(255,255,255,0.22)'"
            onmouseout="this.style.background='rgba(255,255,255,0.12)'"
            aria-label="Sluiten"
        >×</button>
    </div>
@endif
