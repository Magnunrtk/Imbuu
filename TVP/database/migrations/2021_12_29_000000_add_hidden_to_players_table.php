<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddHiddenToPlayersTable extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->renameColumn('hidden', 'hidden_old');
        });

        Schema::table('players', function (Blueprint $table) {
            $table->boolean('hidden')->default(false);
        });

        DB::table('players')->update(['hidden' => DB::raw('hidden_old')]);

        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('hidden_old');
        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table)
        {
            $table->dropColumn('hidden');
        });
    }
}
