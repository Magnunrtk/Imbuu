<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebChangePasswordTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_change_passwords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->text('email');
            $table->text('confirmation_key');
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_change_passwords');
    }
}
