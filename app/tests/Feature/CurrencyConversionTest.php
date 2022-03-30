<?php

namespace Tests\Feature;

use App\Models\Conversion;
use App\Models\Currency;
use Database\Seeders\EurRonConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyConversionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * Run a specific seeder before each test.
     *
     * @var string
     */
    protected $seeder = EurRonConversion::class;

    public function test_it_converts_from_eur_to_ron()
    {
        /** @var Currency $base */
        $base = Currency::query()->where('name', '=', 'EUR')->first();

        /** @var Currency $quote */
        $quote = Currency::query()->where('name', '=', 'RON')->first();

        $conversion = new Conversion();
        $conversion->make($base, $quote, 10, new \DateTime());

        $this->assertEquals(50, $conversion->value);
    }

    public function test_it_converts_from_usd_to_ron()
    {
        /** @var Currency $base */
        $base = Currency::query()->where('name', '=', 'USD')->first();

        /** @var Currency $quote */
        $quote = Currency::query()->where('name', '=', 'RON')->first();

        $conversion = new Conversion();
        $conversion->make($base, $quote, 10, new \DateTime());

        $this->assertEquals(40, $conversion->value);
    }

    public function test_it_converts_from_ron_to_eur()
    {
        /** @var Currency $base */
        $base = Currency::query()->where('name', '=', 'RON')->first();

        /** @var Currency $quote */
        $quote = Currency::query()->where('name', '=', 'EUR')->first();

        $conversion = new Conversion();
        $conversion->make($base, $quote, 50, new \DateTime());

        $this->assertEquals(10, $conversion->value);
    }

    public function test_it_converts_from_eur_to_usd()
    {
        /** @var Currency $base */
        $base = Currency::query()->where('name', '=', 'EUR')->first();

        /** @var Currency $quote */
        $quote = Currency::query()->where('name', '=', 'USD')->first();

        $conversion = new Conversion();
        $conversion->make($base, $quote, 10, new \DateTime());

        $this->assertEquals(12.5, $conversion->value); // 10(EUR) => 50(RON) ; 50(RON) => 12.5(USD)
    }
}
