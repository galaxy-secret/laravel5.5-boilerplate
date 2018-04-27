<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'member_address';
        Schema::create($table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->comment('member_id');
            $table->integer('province_id')->comment('省份id');
            $table->string('province_name', 20)->comment('省份名称');
            $table->integer('city_id')->comment('城市id');
            $table->string('city_name', 20)->comment('城市名称');
            $table->integer('area_id')->comment('区域(县)id');
            $table->string('area_name', 20)->comment('区域(县)名称');
            $table->string('address', 200)->comment('具体地址，街道，楼等');
            $table->string('longitude', 20)->comment('经度');
            $table->string('latitude', 20)->comment('纬度');
            $table->string('tag', 20)->default('')->comment('标签 ex: 家; 公司; 学校; 宿舍; 出租屋等');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` comment "用户地址表"');
        migration_timestamp_2_int($table_name);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_address');
    }
}
