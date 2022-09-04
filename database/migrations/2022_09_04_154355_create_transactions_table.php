<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->foreignId('state_id')->constrained('states')->onDelete('restrict');
            $table->bigInteger('num_private_transport')->comment("ملاكي ونقل");
            $table->double('price_private_transport')->comment("ملاكي ونقل");
            $table->bigInteger('num_taxi_motorbike')->comment('اجرة ودراجه نارية');
            $table->double('price_taxi_motorbike')->comment('اجرة ودراجه نارية');
            $table->bigInteger('num_private_without_exam')->comment('ملاكي بدون فحص');
            $table->double('price_private_without_exam')->comment('ملاكي بدون فحص');
            $table->bigInteger('num_permissions_data')->comment("تصاريح وبيانات");
            $table->double('price_permissions_data')->comment("تصاريح وبيانات");
            $table->bigInteger('num_driving')->comment('قيادة');
            $table->double('price_driving')->comment('قيادة');
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
        Schema::dropIfExists('transactions');
    }
}
