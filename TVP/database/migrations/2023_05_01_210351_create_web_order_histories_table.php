<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebOrderHistoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_order_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');
            $table->string('status');
            $table->decimal('price', 6, 2);
            $table->integer('coins');
            $table->string('session_id');
            $table->string('email')->nullable();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_order_histories');
    }
};
