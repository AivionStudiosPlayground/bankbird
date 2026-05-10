@extends('layouts.public')

@section('title', 'Demo — BankBird')
@section('description', 'Bekijk een volledige demo van BankBird. Dashboard, transacties, imports, merchants, categorieën en rapporten.')

@section('content')

{{-- Hero --}}
<section style="background:linear-gradient(145deg,#0D47A1,#1565C0,#1E88E5);padding:4rem 1.5rem 6rem;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:40%;right:-80px;width:500px;height:500px;background:radial-gradient(circle,rgba(255,255,255,0.07) 0%,transparent 70%);pointer-events:none;"></div>
    <div class="bb-wrap" style="position:relative;z-index:1;">
        <div style="display:flex;align-items:center;gap:2rem;flex-wrap:wrap;">
            <div style="flex:1;min-width:280px;">
                <div class="bb-pill" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);color:white;margin-bottom:1rem;">🎬 Live demo</div>
                <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:white;margin:0 0 1rem;line-height:1.1;letter-spacing:-0.02em;">
                    Zie BankBird<br>in actie
                </h1>
                <p style="font-size:1.0625rem;color:rgba(255,255,255,0.8);margin:0;max-width:480px;line-height:1.65;">
                    Scroll door alle schermen van BankBird. Van dashboard tot import, van categorieën tot rapporten.
                </p>
            </div>
            <div style="flex-shrink:0;animation:float 4.5s ease-in-out infinite;">
                <img src="{{ asset('images/bird.png') }}" alt="BankBird" class="bb-hero-img" style="height:190px;width:auto;filter:drop-shadow(0 16px 32px rgba(0,0,0,0.25));">
            </div>
        </div>
    </div>
    <div style="position:absolute;bottom:0;left:0;right:0;">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;width:100%;">
            <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#F0F6FF"/>
        </svg>
    </div>
</section>

<section style="background:#F0F6FF;padding:3rem 1.5rem 6rem;">
    <div class="bb-wrap">
        <div style="display:flex;flex-direction:column;gap:5rem;">

            {{-- ── 1. Dashboard ── --}}
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.5rem;">
                    <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#1E88E5,#1565C0);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(30,136,229,0.3);">📊</div>
                    <div>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Dashboard</h2>
                        <p style="font-size:0.875rem;color:#6B7A99;margin:0;">Overzicht van je financiën op één plek</p>
                    </div>
                </div>
                <div class="bb-card-flat" style="overflow:hidden;">
                    {{-- Mock browser chrome --}}
                    <div style="background:#E8EAED;padding:0.625rem 1rem;display:flex;align-items:center;gap:0.5rem;border-bottom:1px solid #D0D5DD;">
                        <div style="width:11px;height:11px;background:#FF6058;border-radius:50%;"></div>
                        <div style="width:11px;height:11px;background:#FFBD2E;border-radius:50%;"></div>
                        <div style="width:11px;height:11px;background:#27C93F;border-radius:50%;"></div>
                        <div style="flex:1;background:white;border-radius:0.375rem;padding:0.25rem 0.75rem;font-size:0.75rem;color:#6B7A99;margin:0 0.5rem;max-width:300px;">localhost:8000/dashboard</div>
                    </div>
                    {{-- App layout --}}
                    <div style="display:grid;grid-template-columns:200px 1fr;min-height:400px;">
                        {{-- Sidebar --}}
                        <div style="background:#0B1F3A;padding:1.25rem 0.875rem;display:flex;flex-direction:column;gap:0.25rem;">
                            <div style="display:flex;align-items:center;gap:0.5rem;padding:0.625rem 0.75rem;margin-bottom:0.75rem;">
                                <img src="{{ asset('images/bird.png') }}" alt="" style="height:24px;width:auto;">
                                <span style="font-size:0.875rem;font-weight:700;color:white;">BankBird</span>
                            </div>
                            @foreach([
                                ['📊', 'Dashboard', true],
                                ['💳', 'Transacties', false],
                                ['🏪', 'Merchants', false],
                                ['🏷️', 'Categorieën', false],
                                ['📥', 'Importeren', false],
                                ['📈', 'Rapporten', false],
                            ] as [$icon, $label, $active])
                            <div style="display:flex;align-items:center;gap:0.625rem;padding:0.5rem 0.75rem;border-radius:0.5rem;background:{{ $active ? 'rgba(30,136,229,0.25)' : 'transparent' }};">
                                <span style="font-size:0.875rem;">{{ $icon }}</span>
                                <span style="font-size:0.8125rem;font-weight:{{ $active ? '700' : '400' }};color:{{ $active ? 'white' : 'rgba(255,255,255,0.5)' }};">{{ $label }}</span>
                            </div>
                            @endforeach
                        </div>
                        {{-- Content --}}
                        <div style="background:#F0F6FF;padding:1.5rem;">
                            <div style="font-size:1rem;font-weight:800;color:#0B1F3A;margin-bottom:1rem;">Mei 2026</div>
                            {{-- Stat cards --}}
                            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0.75rem;margin-bottom:1.25rem;">
                                @foreach([
                                    ['Inkomsten', '€ 3.850', '+5%', 'linear-gradient(135deg,#1E88E5,#1565C0)'],
                                    ['Uitgaven', '€ 2.341', '-8%', 'linear-gradient(135deg,#16C784,#0A9660)'],
                                    ['Spaargeld', '€ 1.509', '+12%', 'linear-gradient(135deg,#FF8A3D,#E65100)'],
                                    ['Transacties', '127', '↑ 14', 'linear-gradient(135deg,#0B1F3A,#1E3A5F)'],
                                ] as [$label, $val, $diff, $grad])
                                <div style="background:{{ $grad }};border-radius:0.75rem;padding:0.875rem;color:white;">
                                    <div style="font-size:0.6875rem;opacity:0.75;margin-bottom:0.25rem;">{{ $label }}</div>
                                    <div style="font-size:1.1rem;font-weight:800;margin-bottom:0.125rem;">{{ $val }}</div>
                                    <div style="font-size:0.6875rem;opacity:0.8;">{{ $diff }}</div>
                                </div>
                                @endforeach
                            </div>
                            {{-- Bar chart mock --}}
                            <div style="background:white;border-radius:0.75rem;padding:1rem;border:1px solid rgba(30,136,229,0.1);">
                                <div style="font-size:0.75rem;font-weight:700;color:#6B7A99;margin-bottom:0.75rem;">Uitgaven per categorie</div>
                                <div style="display:flex;align-items:flex-end;gap:0.375rem;height:80px;">
                                    @foreach([70,45,90,55,35,80,60,40,75,50,65,85] as $h)
                                    <div style="flex:1;background:linear-gradient(180deg,#42A5F5,#1E88E5);border-radius:0.25rem 0.25rem 0 0;height:{{ $h }}%;opacity:{{ $h > 70 ? '1' : '0.6' }};"></div>
                                    @endforeach
                                </div>
                                <div style="display:flex;justify-content:space-between;margin-top:0.375rem;">
                                    @foreach(['jan','feb','mrt','apr','mei','jun','jul','aug','sep','okt','nov','dec'] as $m)
                                    <span style="font-size:0.5625rem;color:#6B7A99;">{{ $m }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 2. Transacties ── --}}
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.5rem;">
                    <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#16C784,#0A9660);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(22,199,132,0.3);">💳</div>
                    <div>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Transacties</h2>
                        <p style="font-size:0.875rem;color:#6B7A99;margin:0;">Filter, zoek en beheer al je transacties</p>
                    </div>
                </div>
                <div class="bb-card-flat" style="overflow:hidden;">
                    <div style="background:#E8EAED;padding:0.625rem 1rem;display:flex;align-items:center;gap:0.5rem;border-bottom:1px solid #D0D5DD;">
                        <div style="width:11px;height:11px;background:#FF6058;border-radius:50%;"></div>
                        <div style="width:11px;height:11px;background:#FFBD2E;border-radius:50%;"></div>
                        <div style="width:11px;height:11px;background:#27C93F;border-radius:50%;"></div>
                        <div style="flex:1;background:white;border-radius:0.375rem;padding:0.25rem 0.75rem;font-size:0.75rem;color:#6B7A99;margin:0 0.5rem;max-width:300px;">localhost:8000/transactions</div>
                    </div>
                    <div style="padding:1.25rem;">
                        {{-- Filter bar --}}
                        <div style="display:flex;gap:0.75rem;margin-bottom:1rem;flex-wrap:wrap;">
                            <div style="background:#EEF5FF;border:1px solid rgba(30,136,229,0.2);border-radius:0.5rem;padding:0.4rem 0.875rem;font-size:0.8125rem;color:#1E88E5;font-weight:600;">📅 Mei 2026</div>
                            <div style="background:#F0FFF8;border:1px solid rgba(22,199,132,0.2);border-radius:0.5rem;padding:0.4rem 0.875rem;font-size:0.8125rem;color:#0A9660;font-weight:600;">🏷️ Alle categorieën</div>
                            <div style="background:white;border:1px solid #DDEAF3;border-radius:0.5rem;padding:0.4rem 0.875rem;font-size:0.8125rem;color:#6B7A99;">🔍 Zoeken...</div>
                        </div>
                        {{-- Table --}}
                        <div style="border:1px solid #DDEAF3;border-radius:0.75rem;overflow:hidden;">
                            <div style="display:grid;grid-template-columns:1fr 2fr 1.5fr 1fr;background:#F7FBFF;padding:0.5rem 1rem;border-bottom:1px solid #DDEAF3;">
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;text-transform:uppercase;letter-spacing:0.06em;">Datum</span>
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;text-transform:uppercase;letter-spacing:0.06em;">Omschrijving</span>
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;text-transform:uppercase;letter-spacing:0.06em;">Categorie</span>
                                <span style="font-size:0.6875rem;font-weight:700;color:#6B7A99;text-transform:uppercase;letter-spacing:0.06em;text-align:right;">Bedrag</span>
                            </div>
                            @foreach([
                                ['3 mei', 'Albert Heijn', '🛒 Boodschappen', '-€ 84,30', '#BE2929', '#FFF0F0'],
                                ['3 mei', 'Salaris Acme BV', '💼 Inkomen', '+€ 3.850,00', '#0A9660', '#F0FFF8'],
                                ['2 mei', 'NS Reizen', '🚂 Vervoer', '-€ 12,80', '#BE2929', '#FFF0F0'],
                                ['1 mei', 'Spotify', '🎵 Abonnementen', '-€ 9,99', '#BE2929', '#FFF0F0'],
                                ['1 mei', 'Thuisbezorgd', '🍕 Eten & Drinken', '-€ 31,50', '#BE2929', '#FFF0F0'],
                            ] as [$date, $desc, $cat, $amount, $amountColor, $catBg])
                            <div style="display:grid;grid-template-columns:1fr 2fr 1.5fr 1fr;padding:0.625rem 1rem;border-bottom:1px solid #E5EEF7;align-items:center;" onmouseover="this.style.background='#F7FBFF'" onmouseout="this.style.background='transparent'">
                                <span style="font-size:0.8125rem;color:#6B7A99;">{{ $date }}</span>
                                <span style="font-size:0.8125rem;font-weight:600;color:#0B1F3A;">{{ $desc }}</span>
                                <span style="font-size:0.75rem;background:{{ $catBg }};color:{{ $amountColor }};padding:0.2rem 0.625rem;border-radius:99px;font-weight:600;display:inline-block;">{{ $cat }}</span>
                                <span style="font-size:0.875rem;font-weight:700;color:{{ $amountColor }};text-align:right;">{{ $amount }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 3. Import ── --}}
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.5rem;">
                    <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#FF8A3D,#E65100);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(255,138,61,0.3);">📥</div>
                    <div>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Bankafschrift importeren</h2>
                        <p style="font-size:0.875rem;color:#6B7A99;margin:0;">Upload je PDF of CSV en BankBird doet de rest</p>
                    </div>
                </div>
                <div class="bb-grid-2" style="gap:1.25rem;">
                    {{-- Upload card --}}
                    <div class="bb-card-flat" style="padding:2rem;text-align:center;">
                        <div style="border:2px dashed rgba(30,136,229,0.3);border-radius:1rem;padding:2.5rem;background:#F7FBFF;margin-bottom:1.25rem;">
                            <div style="font-size:2.5rem;margin-bottom:0.75rem;">📄</div>
                            <div style="font-size:0.9375rem;font-weight:700;color:#0B1F3A;margin-bottom:0.375rem;">Sleep je bankafschrift hier</div>
                            <div style="font-size:0.8125rem;color:#6B7A99;margin-bottom:1rem;">PDF of CSV — ING, SNS of Knab</div>
                            <div style="display:inline-flex;background:#1E88E5;color:white;border-radius:0.625rem;padding:0.5rem 1.25rem;font-size:0.875rem;font-weight:700;">Bestand kiezen</div>
                        </div>
                        <div style="display:flex;justify-content:center;gap:0.5rem;flex-wrap:wrap;">
                            @foreach(['ING PDF' => true, 'ING CSV' => true, 'SNS PDF' => true, 'Knab PDF' => true, 'Rabobank' => false, 'ABN AMRO' => false] as $format => $supported)
                            @if($supported)
                            <span style="font-size:0.75rem;background:#EEF5FF;color:#1E88E5;border:1px solid rgba(30,136,229,0.2);padding:0.2rem 0.625rem;border-radius:99px;font-weight:600;">{{ $format }}</span>
                            @else
                            <span style="font-size:0.75rem;background:#F5F5F5;color:#9E9E9E;border:1px solid #E0E0E0;padding:0.2rem 0.625rem;border-radius:99px;font-weight:500;">{{ $format }} <span style="font-size:0.6875rem;opacity:0.8;">binnenkort</span></span>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    {{-- Result card --}}
                    <div class="bb-card-flat" style="padding:2rem;">
                        <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:1.25rem;">
                            <div style="width:10px;height:10px;background:#16C784;border-radius:50%;animation:pulse-glow 2s ease-in-out infinite;"></div>
                            <span style="font-size:0.875rem;font-weight:700;color:#0A9660;">Import geslaagd!</span>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:0.625rem;margin-bottom:1.25rem;">
                            @foreach([
                                ['Bestand', 'ING_mei_2026.pdf'],
                                ['Transacties', '127 gevonden'],
                                ['Periode', '1 – 31 mei 2026'],
                                ['Dubbelen', '0 overgeslagen'],
                                ['AI categorisatie', 'Bezig... 43/127'],
                            ] as [$label, $val])
                            <div style="display:flex;justify-content:space-between;align-items:center;padding:0.5rem 0;border-bottom:1px solid #F0F6FF;">
                                <span style="font-size:0.8125rem;color:#6B7A99;">{{ $label }}</span>
                                <span style="font-size:0.8125rem;font-weight:700;color:#0B1F3A;">{{ $val }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div style="background:linear-gradient(135deg,#F0FFF8,#E8F5E9);border-radius:0.75rem;padding:1rem;border:1px solid rgba(22,199,132,0.2);">
                            <div style="font-size:0.75rem;font-weight:700;color:#0A9660;margin-bottom:0.5rem;">AI verwerking</div>
                            <div style="background:#D4EDDA;border-radius:99px;height:8px;overflow:hidden;">
                                <div style="background:linear-gradient(90deg,#16C784,#0A9660);height:100%;width:34%;border-radius:99px;animation:shimmer 2s linear infinite;"></div>
                            </div>
                            <div style="font-size:0.75rem;color:#6B7A99;margin-top:0.375rem;">43 van 127 gecategoriseerd</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── 4. Categorieën ── --}}
            <div class="reveal">
                <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.5rem;">
                    <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#7C3AED,#5B21B6);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.125rem;box-shadow:0 4px 12px rgba(124,58,237,0.3);">🏷️</div>
                    <div>
                        <h2 style="font-size:1.375rem;font-weight:800;margin:0;color:#0B1F3A;">Categorieën</h2>
                        <p style="font-size:0.875rem;color:#6B7A99;margin:0;">Hiërarchisch ingedeeld, volledig aanpasbaar</p>
                    </div>
                </div>
                <div class="bb-card-flat" style="padding:1.5rem;">
                    <div class="bb-grid-3" style="gap:0.875rem;">
                        @foreach([
                            ['🛒', 'Boodschappen', '€ 342', '#1E88E5'],
                            ['🚂', 'Vervoer', '€ 128', '#16C784'],
                            ['🍕', 'Eten & Drinken', '€ 215', '#FF8A3D'],
                            ['🏠', 'Wonen', '€ 890', '#7C3AED'],
                            ['🎵', 'Abonnementen', '€ 67', '#1E88E5'],
                            ['💪', 'Sport & Gezondheid', '€ 45', '#16C784'],
                        ] as [$icon, $name, $amount, $color])
                        <div style="background:#F7FBFF;border-radius:0.875rem;padding:1rem;border:1px solid #DDEAF3;">
                            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.625rem;">
                                <span style="font-size:1.125rem;">{{ $icon }}</span>
                                <span style="font-size:0.875rem;font-weight:700;color:#0B1F3A;">{{ $name }}</span>
                            </div>
                            <div style="font-size:1rem;font-weight:800;color:{{ $color }};margin-bottom:0.375rem;">{{ $amount }}</div>
                            <div style="background:#E5EEF7;border-radius:99px;height:5px;overflow:hidden;">
                                <div style="background:{{ $color }};height:100%;width:{{ rand(30,85) }}%;border-radius:99px;opacity:0.7;"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── CTA ── --}}
            <div class="reveal">
                <div style="
                    background:linear-gradient(135deg,#1565C0,#1E88E5,#42A5F5);
                    border-radius:2rem;padding:3.5rem 2.5rem;text-align:center;position:relative;overflow:hidden;
                ">
                    <div style="position:absolute;top:-40px;right:-40px;width:250px;height:250px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
                    <img src="{{ asset('images/bird.png') }}" alt="BankBird" style="height:100px;width:auto;filter:drop-shadow(0 8px 16px rgba(0,0,0,0.2));animation:float 4s ease-in-out infinite;margin-bottom:1.25rem;">
                    <h2 style="font-size:2rem;font-weight:900;color:white;margin:0 0 0.875rem;letter-spacing:-0.02em;">Overtuigd? 🐦</h2>
                    <p style="font-size:1.0625rem;color:rgba(255,255,255,0.82);margin:0 auto 2rem;max-width:400px;">
                        Installeer BankBird op je eigen server en heb vandaag nog inzicht in je financiën.
                    </p>
                    <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
                        <a href="{{ url('/install') }}" class="bb-btn-white bb-btn-lg">🚀 Installeer nu</a>
                        <a href="{{ url('/docs') }}" class="bb-btn-ghost-white bb-btn-lg">Lees de docs</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
