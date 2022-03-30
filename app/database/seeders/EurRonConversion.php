<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\Rate;
use Illuminate\Database\Seeder;

class EurRonConversion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createEurRate();
        $this->createUsdRate();
    }

    private function createEurRate(): void
    {
        /** @var Currency $base */
        $base = Currency::factory()->createOne(['name' => 'EUR']);

        Rate::factory(1, [
            'value' => 5,
            'currency_id' => $base->id,
        ])->createOne();
    }

    private function createUsdRate(): void
    {
        /** @var Currency $base */
        $base = Currency::factory()->createOne(['name' => 'USD']);

        Rate::factory(1, [
            'value' => 4,
            'currency_id' => $base->id,
        ])->createOne();
    }
}
