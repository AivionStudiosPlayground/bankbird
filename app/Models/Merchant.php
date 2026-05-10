<?php

namespace App\Models;

use App\Services\MerchantPatternService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    protected $fillable = [
        'name', 'normalized_name', 'category_id', 'logo_url', 'match_patterns',
    ];

    protected function casts(): array
    {
        return [
            'match_patterns' => 'array',
        ];
    }

    /**
     * Resolveer relatieve paden naar absolute URL's zodat Filament's
     * ImageColumn ze als geldige URL ziet (filter_var FILTER_VALIDATE_URL
     * accepteert geen scheme-loze paden). Externe URL's en data-URI's
     * blijven onveranderd.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): ?string {
                if (! $value) {
                    return null;
                }

                if (str_starts_with($value, 'http://')
                    || str_starts_with($value, 'https://')
                    || str_starts_with($value, 'data:')
                ) {
                    return $value;
                }

                return url($value);
            },
        );
    }

    protected static function booted(): void
    {
        static::updated(function (Merchant $merchant) {
            if ($merchant->wasChanged('category_id')) {
                $merchant->transactions()->update([
                    'category_id' => $merchant->category_id,
                ]);
            }

            if ($merchant->wasChanged('match_patterns')) {
                app(MerchantPatternService::class)->syncMerchant($merchant);
            }
        });

        static::created(function (Merchant $merchant) {
            if (! empty($merchant->match_patterns)) {
                app(MerchantPatternService::class)->syncMerchant($merchant);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
