<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?int $id
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 * @property int $currency_id
 * @property Currency $currency
 * @property Currency $refCurrency
 * @property int $ref_currency_id
 * @property double $value
 * @property double $multiplier
 */
class Rate extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i:s',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_at', 'currency_id', 'value', 'ref_currency_id'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['created_at', 'value'];

    /**
     * Get the currency for the rate.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the reference currency for the rate.
     */
    public function refCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function date(): \DateTimeInterface
    {
        return $this->created_at;
    }
}
