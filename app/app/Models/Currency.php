<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property ?int $id
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
    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public function rate(\DateTime $dateTime): null|Rate|Model
    {
        $dateTime->setTime(0, 0);

        if ($this->name === self::BRIDGE_CURRENCY) {
            return Rate::factory()->makeOne();
        }

        /** @var null|Rate $rate */
        return Rate::query()
            ->where('currency_id', $this->id)
            ->where('created_at', '<=', $dateTime)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
