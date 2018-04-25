<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/19 14:14
 */


if (!function_exists('check_user_stateful')) {
    /**
     * @param $provider
     * @return mixed
     * @author pandaria
     * @date 2018/4/25 15:03
     */
    function check_user_stateful($provider) {
        return \Illuminate\Support\Facades\Auth::guard($provider)->user();
    }
}

if (!function_exists('check_frontend_user')) {
    /**
     * @return mixed
     * @author pandaria
     * @date 2018/4/25 15:03
     */
    function check_frontend_user() {
        return check_user_stateful('api_frontend');
    }
}

if (!function_exists('check_backend_user')) {
    /**
     * @return mixed
     * @author pandaria
     * @date 2018/4/25 15:03
     */
    function check_backend_user() {
        return check_user_stateful('api_backend');
    }
}

if (!function_exists('str_to_hex')) {
    /**
     * 字符串转二进制形式
     * @param $str
     * @return mixed
     * @author pandaria
     * @date 2018/4/25 15:03
     */
    function str_to_hex($str) {
        $hex_str = unpack('H*', $str);
        return array_shift($hex_str);
    }
}

if (!function_exists('hex_to_str')) {
    /**
     * 二进制转字符串
     * @param $hex
     * @return bool|string
     * @author pandaria
     * @date 2018/4/25 15:03
     */
    function hex_to_str($hex) {
        return hex2bin($hex);
    }
}

if (!function_exists('migration_timestamp_2_int')) {
    /**
     * 修改 默认的 laravel 数据迁移 建表时 时间戳为 int
     * @param $table_name
     * @author pandaria
     * @date 2018/4/25 15:03
     */
    function migration_timestamp_2_int($table_name) {
        DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` MODIFY COLUMN created_at integer unsigned default 0 not null comment "创建时间" ');
        DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` MODIFY COLUMN updated_at integer unsigned default 0 not null comment "更新时间" ');
        if (Schema::hasColumn($table_name, 'deleted_at')) {
            DB::statement('ALTER TABLE `'.config('database.connections.mysql.prefix') . $table_name .'` MODIFY COLUMN deleted_at integer unsigned default 0 not null comment "删除时间" ');
        }
    }
}