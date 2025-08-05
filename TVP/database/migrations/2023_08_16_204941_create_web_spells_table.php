<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebSpellsTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_spells', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('words');
            $table->tinyInteger('category')->comment('undefined, instant, rune, conjuring, house');
            $table->integer('mana');
            $table->integer('mlvl');
            $table->tinyInteger('premium');
            $table->string('vocations');
            $table->tinyInteger('param');
            $table->tinyInteger('learn');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_spells');
    }
}
