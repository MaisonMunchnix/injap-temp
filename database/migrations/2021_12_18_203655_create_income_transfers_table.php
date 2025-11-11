<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('from_user_id');
            $table->smallInteger('to_user_id');
            $table->decimal('amount');
            $table->decimal('tax');
            $table->decimal('process_fee')->default(50);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('income_transfers');
    }
}
