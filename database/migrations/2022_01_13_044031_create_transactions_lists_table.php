<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions_lists', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->string('transaction_id',25);
            $table->string('product_id',25);
            $table->bigInteger('subtotal_qty');
            $table->bigInteger('subtotal_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions_lists');
    }
}
