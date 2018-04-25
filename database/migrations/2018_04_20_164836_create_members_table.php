<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 用户表
         */
        $table_name = 'members';
        Schema::create($table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 12)->comment('用户名');
            $table->string('phone', 20)->unique()->comment('手机');
            $table->string('password');
            $table->string('email', 100)->unique()->comment('邮箱');
            $table->string('head_pic', 100)->default('')->comment('头像');
            $table->string('sn', 20)->unique()->comment('dvb mac作为SN');
            $table->tinyInteger('status')->default(1)->comment('用户状态 1: 正常; 2: 锁定; -1: 注销; 默认是1');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` comment "用户表"');
        /**
         * 修改时间戳为 int
         */
        migration_timestamp_2_int($table_name);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
