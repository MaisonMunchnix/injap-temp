<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductCodeToUserApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_applications')) {
            Schema::create('user_applications', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->string('product_code', 100);
                $table->string('sponsor_id', 50)->nullable();
                $table->string('sponsor_input', 50)->nullable();
                $table->string('member_type', 50)->nullable();
                $table->string('status')->default('pending');
                $table->text('rejection_reason')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('user_applications', function (Blueprint $table) {
                if (!Schema::hasColumn('user_applications', 'product_code')) {
                    $table->string('product_code', 100)->after('user_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_applications');
    }
}
