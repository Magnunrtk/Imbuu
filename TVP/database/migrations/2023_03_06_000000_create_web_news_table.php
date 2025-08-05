<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebNewsTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('body');
            $table->integer('type');
            $table->tinyInteger('category');
            $table->integer('player_id');
            $table->integer('last_modified_by')->nullable();
            $table->longText('article_text')->nullable();
            $table->longText('article_image')->nullable();
            $table->tinyInteger('hidden')->default(false);
            $table->timestamps();
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('last_modified_by')->references('id')->on('players')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_news');
    }
}
