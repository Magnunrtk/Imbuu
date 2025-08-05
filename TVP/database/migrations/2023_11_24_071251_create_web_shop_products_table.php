<?php

use Database\Seeders\WebShopProductsSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebShopProductsTable extends Migration
{
    public function up()
    {
        Schema::create('web_shop_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->decimal('value', 6);
            $table->integer('coins');
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->unsignedBigInteger('payment_option_id');
            $table->tinyInteger('decimals')->default(2);
            $table->tinyInteger('active')->default(true);
            $table->timestamps();
            $table->foreign('payment_option_id')->references('id')->on('web_payment_options')->onDelete('cascade');
        });
        (new WebShopProductsSeeder())->run();
    }

    public function down()
    {
        Schema::dropIfExists('web_shop_products');
    }
}
