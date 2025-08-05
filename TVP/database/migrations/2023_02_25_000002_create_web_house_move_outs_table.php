<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebHouseMoveOutsTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_house_move_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('house_id');
            $table->timestamp('date');
            $table->bigInteger('time');
            $table->timestamps();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_house_move_outs');
    }
}
