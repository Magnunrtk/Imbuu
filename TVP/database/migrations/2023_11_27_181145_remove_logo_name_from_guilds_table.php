<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLogoNameFromGuildsTable extends Migration
{
    public function up(): void
    {
        Schema::table('guilds', function (Blueprint $table) {
            $table->dropColumn('logo_name');
        });
    }

    public function down(): void
    {
        Schema::table('guilds', function (Blueprint $table)
        {
            $table->string('logo_name')->default('default_logo.gif')->after('motd');
        });
    }
}
