<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebBlacklistEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('web_blacklist_entries', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable()->unique();
            $table->string('ip')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('web_blacklist_entries');
    }
}
