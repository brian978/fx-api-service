<?php

declare(strict_types=1);

namespace App\Models;

class Conversion
{
    public \DateTimeInterface $date;
    public float $value = 0.0;

    public function make(Currency $from, Currency $to, float $value, \DateTime $dateTime): self
    {
        $this->date = $dateTime;

        // Get the rate of the currency against RON; RON does not have a rate against itself so this will be NULL
        $rate = $from->rate($dateTime);
        if (null === $rate) {
            return $this;
        }

        $this->date = $rate->date();

        $bridgeValue = round($rate->value * $value, 4);
        if (Currency::BRIDGE_CURRENCY === $to->name) {
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
