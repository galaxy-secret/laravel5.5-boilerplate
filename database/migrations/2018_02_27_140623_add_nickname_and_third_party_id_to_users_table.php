<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNicknameAndThirdPartyIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nick_name')->default('')->comment('第三方的昵称');
            $table->string('third_party_id')->default('')->comment('第三方open_id');
            $table->integer('third_party_type')->default(0)->comment('第三方类型: 1微信,2qq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nick_name', 'third_party_id', 'third_party_type']);
        });
    }
}
