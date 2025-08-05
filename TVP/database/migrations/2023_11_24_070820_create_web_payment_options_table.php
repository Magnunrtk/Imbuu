<?php

use Database\Seeders\WebPaymentOptionsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebPaymentOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('web_payment_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->tinyInteger('processing_time');
            $table->string('additional_title')->nullable();
            $table->string('additional_text')->nullable();
            $table->tinyInteger('active')->default(true);
            $table->timestamps();
        });
        (new WebPaymentOptionsSeeder())->run();
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('web_payment_options');
        Schema::enableForeignKeyConstraints();
    }
}
