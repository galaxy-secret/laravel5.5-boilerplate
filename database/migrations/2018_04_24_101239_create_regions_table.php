<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'regions';
        Schema::create($table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('父级ID');
            $table->string('name', 120)->comment('省份、城市、区域名');
            $table->tinyInteger('node_level')->default(0)->comment('节点级别');
            $table->string('zone_code', 30)->comment('区号');
            $table->string('zip_code', 30)->comment('邮编');
            $table->string('path_info', 120)->comment('路径信息');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` comment "省份城市区域表"');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }

}
