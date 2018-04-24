<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table_name = 'regions';
        $this->fillRegionsTable($table_name);
    }



    protected function fillRegionsTable($table_name) {
        $sql_file_path = __DIR__ . DIRECTORY_SEPARATOR .'regions.sql';
        if (file_exists($sql_file_path)){
            $table_prefix = config('database.connections.mysql.prefix');
            $time = date('Y-m-d H:i:s');
            $fp = fopen($sql_file_path, 'r+');
            while (! feof($fp)) {
                $line = fgets($fp);
                if (!empty($line)){
                    $line = str_replace('{####}', $table_prefix . $table_name,$line);
                    $line = str_replace(');', ', "'.$time.'", "'.$time.'");', $line);
                    \Illuminate\Support\Facades\DB::statement($line);
                }
            }
            fclose($fp);
        }
    }

}
