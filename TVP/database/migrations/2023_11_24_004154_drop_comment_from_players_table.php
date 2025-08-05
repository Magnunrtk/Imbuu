<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCommentFromPlayersTable extends Migration
{
    public function up()
    {
        Schema::table('players', function (Blueprint $table)
        {
            $table->dropColumn('comment');
        });
    }

    public function down(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->string('comment');
        });
    }
}
