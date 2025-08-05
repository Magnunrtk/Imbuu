<?php

declare(strict_types=1);

use App\Http\Traits\RecoveryKey;
use App\Models\Account;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebAccountsTable extends Migration
{
    use RecoveryKey;

    public function up(): void
    {
        Schema::create('web_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('account_id');
            $table->text('rl_name')->nullable();
            $table->text('location')->nullable();
            $table->text('recovery_key');
            $table->unsignedBigInteger('shop_coins')->default(0);
            $table->string('referral')->nullable();
            $table->integer('referred_by')->nullable();
            $table->integer('referral_bonus')->default(25);
            $table->text('confirmation_key')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamp('next_resend')->nullable();
            $table->integer('confirmations_count')->default(0);
            $table->string('country_code')->nullable();
            $table->text('creation_ip')->nullable();
            $table->timestamps();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });

        Account::all()->each(function ($account) {
            $created = Carbon::now();
            if ($account->created != 0) {
                $created = Carbon::createFromTimestamp($account->created);
            }

            $insertData = [
                'account_id' => $account->id,
                'shop_coins' => $account->premium_points,
                'created_at' => $created,
                'updated_at' => now(),
                'confirmation_key' => hash('sha256', (string) (time() + rand(100, 99999))),
                'recovery_key' => $this->recoveryKeyGenerate(),
            ];

            if (!empty($account->rlname)) {
                $insertData['rl_name'] = $account->rlname;
            }

            if (!empty($account->location)) {
                $insertData['location'] = $account->location;
            }

            if (!empty($account->country)) {
                $insertData['country_code'] = $account->country;
            }

            DB::table('web_accounts')->insert($insertData);

            $insertData2 = [
                'account_id' => $account->id,
                'role_id' => 2,
                'created_at' => $created,
                'updated_at' => $created,
            ];
            DB::table('role_user')->insert($insertData2);
        });

        Schema::table('accounts', function (Blueprint $table)
        {
            $table->dropColumn('blocked');
            $table->dropColumn('created');
            $table->dropColumn('rlname');
            $table->dropColumn('location');
            $table->dropColumn('country');
            $table->dropColumn('web_lastlogin');
            $table->dropColumn('key');
            $table->dropColumn('web_flags');
            $table->dropColumn('email_hash');
            $table->dropColumn('email_next');
            $table->dropColumn('email_new');
            $table->dropColumn('email_new_time');
            $table->dropColumn('email_code');
            $table->dropColumn('email_verified');
            $table->dropColumn('creation');
            $table->dropColumn('premium_points');
            $table->dropColumn('vote');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('web_accounts');
    }
}
