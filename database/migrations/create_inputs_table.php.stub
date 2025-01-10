<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Homeful\Common\Classes\Input;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inputs', function (Blueprint $table) {
            $table->id();
            $table->string(Input::SKU)->nullable();
            $table->float(Input::WAGES)->nullable();
            $table->float(Input::TCP)->nullable();
            $table->float(Input::PERCENT_DP)->nullable();
            $table->float(Input::PERCENT_MF)->nullable();
            $table->integer(Input::DP_TERM)->nullable();
            $table->integer(Input::BP_TERM)->nullable();
            $table->float(Input::BP_INTEREST_RATE)->nullable();
            $table->string(Input::SELLER_COMMISSION_CODE)->nullable();
            $table->string(Input::PROMO_CODE)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inputs');
    }
};
