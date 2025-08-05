<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveToGuildsTable extends Migration
{
    public function up(): void
    {
        Schema::table('guilds', function (Blueprint $table)
        {
            $table->boolean('active')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('guilds', function (Blueprint $table)
        {
            $table->dropColumn('active');
        });
    }
}
