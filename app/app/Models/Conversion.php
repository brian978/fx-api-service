<?php

declare(strict_types=1);

namespace App\Models;

class Conversion
{
    public const BRIDGE_CURRENCY = 'RON';

    public \DateTimeInterface $date;
    public float $value = 0.0;

    public function make(Currency $from, Currency $to, float $value, \DateTime $dateTime): self
    {
        $this->date = $dateTime;

        // Convert to bridge currency (RON)
        $rate = $from->rate($dateTime);
        if (null === $rate) {
            return $this;
        }

        $this->date = $rate->date();

        $bridgeValue = round($rate->value * $value, 4);
        if (self::BRIDGE_CURRENCY === $to->name) {
            $this->value = $bridgeValue;
            return $this;
        }

        // Convert the bridge value to the destination currency
        $quoteRate = $to->rate($dateTime);
        if (null === $quoteRate) {
            $this->value = 0;
            return $this;
        }

        $this->value = round($bridgeValue / $quoteRate->value, 4);

        return $this;
    }
}
