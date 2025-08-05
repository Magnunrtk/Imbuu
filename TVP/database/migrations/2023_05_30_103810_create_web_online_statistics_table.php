<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebOnlineStatisticsTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_online_statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('player_count');
            $table->integer('world_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_online_statistics');
    }
};
