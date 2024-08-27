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
            $table->float(Input::PERCENT_DP);
            $table->float(Input::PERCENT_MF);
            $table->integer(Input::DP_TERM);
            $table->integer(Input::BP_TERM);
            $table->float(Input::BP_INTEREST_RATE);
            $table->string(Input::SELLER_COMMISSION_CODE);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inputs');
    }
};
