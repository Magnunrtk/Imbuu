<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebGuildApplicationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_guild_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('player_id');
            $table->integer('guild_id');
            $table->text('text');
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->foreign('guild_id')->references('id')->on('guilds')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_guild_applications');
    }
}
