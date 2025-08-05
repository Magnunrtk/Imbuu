<?php

declare(strict_types=1);

use Database\Seeders\RolesTableSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->integer('level')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
        (new RolesTableSeeder())->run();
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
}
