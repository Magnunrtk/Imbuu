<?php

declare(strict_types=1);

use App\Models\WebGuild;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebGuildsTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_guilds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('guild_id');
            $table->string('logo_name')->default('default_logo.gif');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('guild_id')->references('id')->on('guilds')->onDelete('cascade');
        });

        DB::table('guilds')->get()->each(function ($guild) {
            WebGuild::updateOrCreate([
                'guild_id' => $guild->id,
                'logo_name' => 'default_logo.gif',
                'description' => 'New guild. Leader must edit this text :)',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_guilds');
    }
}
