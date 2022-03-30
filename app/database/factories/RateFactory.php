<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rate>
 */
class RateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|Rate>
     */
    protected $model = Rate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now()->subDay(),
            'updated_at' => null,
            'value' => 1,
            'multiplier' => null,
            'currency_id' => function () {
                return Currency::query()->firstOrCreate(['name' => 'RON']);
            },
            'ref_currency_id' => function () {
                return Currency::query()->firstOrCreate(['name' => 'RON']);
            }
        ];
    }
}
