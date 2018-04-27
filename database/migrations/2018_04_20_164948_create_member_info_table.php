<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 用户信息表
         */
        $table_name = 'member_info';
        Schema::create($table_name, function (Blueprint $table) {
            /**
             * 用户扩展信息表，预留表  目前没什么用
             */
            $table->increments('id');
            $table->integer('member_id')->comment('用户id');
            $table->tinyInteger('sex')->default(2)->comment('性别 1: 男; 2: 女; 3: 保密');
            $table->unsignedTinyInteger('age')->comment('年龄');
            $table->string('identity_card', 20)->default('')->comment('身份证号');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` comment "用户信息表"');
        migration_timestamp_2_int($table_name);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_info');
    }
}
