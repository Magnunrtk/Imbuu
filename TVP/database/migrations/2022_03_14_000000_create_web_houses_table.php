<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebHousesTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->unsignedBigInteger('house_id');
            $table->unsignedBigInteger('entry_x');
            $table->unsignedBigInteger('entry_y');
            $table->unsignedBigInteger('entry_z');
            $table->unsignedBigInteger('rent');
            $table->unsignedBigInteger('town_id');
            $table->unsignedBigInteger('size');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_houses');
    }
}
