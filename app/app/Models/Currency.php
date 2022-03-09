<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property \DateTimeInterface $created_at
 * @property \DateTimeInterface $updated_at
 * @property string $name
 */
class Currency extends Model
{
    use HasFactory;

    public const BRIDGE_CURRENCY = 'RON';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_at', 'name'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = ['name'];

    /**
     * Get the rates for the currency.
     */
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function convert(float $value, \DateTime $dateTime): float
    {
        /** @var Rate $rate */
        $rate = Rate::query()
            ->where('currency_id', $this->id)
            ->where('created_at', $dateTime) // TODO: get nearest date either -- check first down then up
            ->first();

        if (null === $rate) {
            return 0;
        }

        return round($rate->value / $value, 4);
    }

    public function convertTo(self $quote, float $value, \DateTime $dateTime): float
    {
        /** @var Rate $baseRate */
        $baseRate = Rate::query()
            ->where('currency_id', $this->id)
            ->where('created_at', $dateTime)
            ->first();

        if (null === $baseRate) {
            return 0;
        }

        $bridgeValue = round($baseRate->value / $value, 4);

        // Getting the rate for the quote currency
        /** @var Rate $quoteRate */
        $quoteRate = Rate::query()
            ->where('currency_id', $quote->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (null === $quoteRate) {
            return 0;
        }

        return round($bridgeValue / $quoteRate->value, 4);
    }
}
