<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropOldAacTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('medivia_coins');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('packages_history');
        Schema::dropIfExists('pagseguro_transactions');
        Schema::dropIfExists('payment_history');
        Schema::dropIfExists('pagseguro_transactions');
        Schema::dropIfExists('crypto_history');
        Schema::dropIfExists('crypto_payments');
        Schema::dropIfExists('mp_hist');
        Schema::dropIfExists('streamers');
        //Schema::dropIfExists('dirkyh_items');
        //Schema::dropIfExists('allow_request');
        $myaacTables = DB::select('SHOW TABLES LIKE "myaac_%"');
        foreach ($myaacTables as $table) {
            $tableName = reset($table);
            if (Schema::hasTable($tableName)) {
                Schema::dropIfExists($tableName);
            }
        }

        $zTables = DB::select('SHOW TABLES LIKE "z_%"');
        foreach ($zTables as $table) {
            $tableName = reset($table);
            if (Schema::hasTable($tableName)) {
                Schema::dropIfExists($tableName);
            }
        }
    }

    public function down()
    {
    }
}
