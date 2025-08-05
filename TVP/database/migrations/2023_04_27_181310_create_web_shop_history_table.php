<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebShopHistoryTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_shop_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->integer('player_id');
            $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('title');
            $table->integer('price');
            $table->integer('count')->default(0);
            $table->string('target')->nullable();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_shop_history');
    }
}
