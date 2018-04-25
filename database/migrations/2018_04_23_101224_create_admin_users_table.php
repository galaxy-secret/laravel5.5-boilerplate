<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'admin_users';
        Schema::create($table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 12)->comment('名称');
            $table->string('email', 100)->unique()->comment('邮箱');
            $table->string('phone', 20)->unique()->comment('手机号');
            $table->string('password');
            $table->string('head_pic', 100)->comment('头像');
            $table->tinyInteger('status')->default(1)->comment('用户状态 1: 正常; 2: 锁定; -1: 注销; 默认是1');
            $table->rememberToken();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` comment "后台管理员表"');
        migration_timestamp_2_int($table_name);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
