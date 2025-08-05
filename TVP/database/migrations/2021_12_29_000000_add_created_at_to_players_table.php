<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCreatedAtToPlayersTable extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table)
        {
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        DB::table('players')->get()->each(function ($player) {
            $createdAt = $player->created ? Carbon::createFromTimestamp($player->created) : Carbon::now();
            DB::table('players')
                ->where('id', $player->id)
                ->update(['created_at' => $createdAt]);
        });

        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('created');
        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table)
        {
            $table->dropColumn('created_at');
        });
    }
}
