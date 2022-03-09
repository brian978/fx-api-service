<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->nullable(false);
            $table->dateTime('updated_at')->nullable()->useCurrentOnUpdate();
            $table->double('value')->nullable(false);
            $table->double('multiplier')->nullable();

            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->foreignId('ref_currency_id')->constrained('currencies')->cascadeOnDelete();

            $table->unique(['created_at', 'currency_id'], 'uq_rate_entry');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
};
