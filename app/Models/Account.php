<?php

namespace App\Models;

use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    /**
     * IBAN-bankcode (positie 5-8 in het IBAN) → bank-info.
     * Logo's staan in public/images/banks/ en worden lokaal geserveerd.
     */
    private const BANK_REGISTRY = [
        'INGB' => ['name' => 'ING', 'logo' => '/images/banks/ing.png'],
        'RABO' => ['name' => 'Rabobank', 'logo' => '/images/banks/rabobank.png'],
        'ABNA' => ['name' => 'ABN AMRO', 'logo' => '/images/banks/abnamro.png'],
        'TRIO' => ['name' => 'Triodos', 'logo' => '/images/banks/triodos.png'],
        'KNAB' => ['name' => 'Knab', 'logo' => '/images/banks/knab.png'],
        'BUNQ' => ['name' => 'bunq', 'logo' => '/images/banks/bunq.png'],
        'ASNB' => ['name' => 'ASN Bank', 'logo' => '/images/banks/asn.png'],
        'SNSB' => ['name' => 'SNS', 'logo' => '/images/banks/sns.png'],
        'RBRB' => ['name' => 'RegioBank', 'logo' => '/images/banks/regiobank.png'],
    ];

    protected $fillable = [
        'user_id', 'name', 'type', 'iban', 'color', 'icon', 'balance', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'type' => AccountType::class,
            'balance' => 'decimal:2',
            'is_active' => 'boolean',
            'iban' => 'encrypted',
        ];
    }

    /** Vier-letter bankcode uit het IBAN (positie 5-8), of null. */
    protected function bankCode(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                $iban = strtoupper((string) ($this->iban ?? ''));
                if (strlen($iban) < 8) {
                    return null;
                }

                return substr($iban, 4, 4);
            },
        );
    }

    /** Naam van de bank (ING, Rabobank, …) op basis van het IBAN. */
    protected function bankName(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => self::BANK_REGISTRY[$this->bank_code]['name'] ?? null,
        );
    }

    /** Pad naar het lokale bank-logo, of null als de bank onbekend is. */
    protected function bankLogoUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                $path = self::BANK_REGISTRY[$this->bank_code]['logo'] ?? null;

                return $path ? url($path) : null;
            },
        );
    }

    protected static function booted(): void
    {
        static::addGlobalScope('user', function (Builder $query) {
            if (auth()->check()) {
                $query->where('accounts.user_id', auth()->id());
            }
        });

        static::creating(function (Account $account) {
            if (! $account->user_id && auth()->check()) {
                $account->user_id = auth()->id();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function imports(): HasMany
    {
        return $this->hasMany(Import::class);
    }

    public static function recalculateBalance(int $accountId): void
    {
        $account = static::withoutGlobalScopes()->findOrFail($accountId);

        $balance = Transaction::withoutGlobalScopes()
            ->where('account_id', $accountId)
            ->selectRaw("SUM(CASE WHEN type = 'credit' THEN amount ELSE -amount END) as net")
            ->value('net') ?? 0;

        $account->update(['balance' => $balance]);
    }
}
