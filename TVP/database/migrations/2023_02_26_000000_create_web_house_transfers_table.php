<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebHouseTransfersTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_house_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('move_out_id');
            $table->integer('new_owner');
            $table->unsignedBigInteger('price');
            $table->tinyInteger('accepted')->default(false);
            $table->timestamps();
            $table->foreign('move_out_id')->references('id')->on('web_house_move_outs')->onDelete('cascade');
            $table->foreign('new_owner')->references('id')->on('players')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_house_transfers');
    }
}
