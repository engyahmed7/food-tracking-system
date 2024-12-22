<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneShippingRatesTable extends Migration
{
    public function up()
    {
        Schema::create('zone_shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->constrained()->onDelete('cascade');
            $table->decimal('rate', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zone_shipping_rates');
    }
}
