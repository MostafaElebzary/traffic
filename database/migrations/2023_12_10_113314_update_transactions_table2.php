<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->double('num_extinguisher')->nullable()->comment(' عدد طفاية ');
            $table->double('price_extinguisher')->nullable()->comment('سعر الطفاية');
            $table->double('num_internet_card')->nullable()->comment(' عدد طفاية ');
            $table->double('price_internet_card')->nullable()->comment('سعر الطفاية');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
