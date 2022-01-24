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
            $table->id();
            $table->string('transaction_id',25);
            $table->bigInteger('product_id');
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
