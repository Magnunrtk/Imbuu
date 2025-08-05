<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToWebOrderHistoriesTable extends Migration
{
    public function up(): void
    {
        Schema::table('web_order_histories', function (Blueprint $table)
        {
            $table->unsignedBigInteger('product_id')->nullable()->after('session_id');
            $table->foreign('product_id')->references('id')->on('web_shop_products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('web_order_histories', function (Blueprint $table)
        {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
        });
    }
}
