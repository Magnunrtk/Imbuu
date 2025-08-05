<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyWebManualTransactionsTable extends Migration
{
    public function up(): void
    {
        Schema::table('web_manual_transactions', function (Blueprint $table)
        {
            $table->dropColumn('payment_method');
            $table->unsignedBigInteger('payment_option_id')->after('coins')->nullable();
            $table->unsignedBigInteger('product_id')->after('payment_option_id')->nullable();
            $table->foreign('payment_option_id')->references('id')->on('web_payment_options')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('web_shop_products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('web_manual_transactions', function (Blueprint $table)
        {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->dropForeign(['payment_option_id']);
            $table->dropColumn('payment_option_id');
            $table->string('payment_method')->after('coins');
        });
    }
}
