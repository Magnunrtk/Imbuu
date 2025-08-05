<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebManualTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('web_manual_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->string('external_name');
            $table->string('receiver_name');
            $table->string('server_name')->nullable();
            $table->integer('price');
            $table->integer('coins')->default(0);
            $table->string('payment_method');
            $table->tinyInteger('status')->default(0)->comment('pending, approved, rejected');
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('web_manual_transactions');
    }
}
