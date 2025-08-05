<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDescriptionFromGuildsTable extends Migration
{
    public function up()
    {
        Schema::table('guilds', function (Blueprint $table)
        {
            $table->dropColumn('description');
        });
    }

    public function down(): void
    {
        Schema::create('guilds', function (Blueprint $table) {
            $table->string('description');
        });
    }
}
