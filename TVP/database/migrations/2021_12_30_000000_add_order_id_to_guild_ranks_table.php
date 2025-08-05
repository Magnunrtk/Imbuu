<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToGuildRanksTable extends Migration
{
    public function up(): void
    {
        Schema::table('guild_ranks', function (Blueprint $table)
        {
            $table->bigInteger('order_id')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('guild_ranks', function (Blueprint $table)
        {
            $table->dropColumn('order_id');
        });
    }
}
