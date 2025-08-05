<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCreatedAtToGuildMembershipTable extends Migration
{
    public function up(): void
    {
        Schema::table('guild_membership', function (Blueprint $table)
        {
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::table('guild_membership', function (Blueprint $table)
        {
            $table->dropColumn('created_at');
        });
    }
}
