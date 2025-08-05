<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebGuildResignLeadershipsTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_guild_resign_leaderships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('player_id');
            $table->integer('guild_id');
            $table->integer('new_player_id');
            $table->timestamps();
            $table->foreign('guild_id')->references('id')->on('guilds')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('new_player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_guild_resign_leaderships');
    }
}
