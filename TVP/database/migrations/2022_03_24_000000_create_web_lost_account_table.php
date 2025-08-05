<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebLostAccountTable extends Migration
{
    public function up(): void
    {
        Schema::create('web_lost_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->text('email');
            $table->string('confirmation_key', 30)->unique();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_lost_account');
    }
}
