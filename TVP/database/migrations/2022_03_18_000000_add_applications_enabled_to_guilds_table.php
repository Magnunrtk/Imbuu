<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApplicationsEnabledToGuildsTable extends Migration
{
    public function up(): void
    {
        Schema::table('guilds', function (Blueprint $table)
        {
            $table->tinyInteger('applications_enabled')->default(1)->after('active');
        });
    }

    public function down(): void
    {
        Schema::table('guilds', function (Blueprint $table)
        {
            $table->dropColumn('applications_enabled');
        });
    }
}
