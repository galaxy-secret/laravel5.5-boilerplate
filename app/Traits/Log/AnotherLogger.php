<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/11
 * Time: 18:56
 */

namespace App\Traits\Log;

use Monolog\Logger;
/**
 * Trait Logger
 * @package App\Traits
 * @author pandaria
 * @date 2018/4/12 15:46
 */
trait AnotherLogger {

    use Log;

    public function anotherApiLoggerWarning($message, array $context = []) {
        $log = $this->createLogChannel('another',storage_path('logs/another/error.log'),  Logger::WARNING );
        $log->warning($this->prepareMessage($message), $context);
    }

    public function anotherApiLoggerInfo($message, array $context = []) {

        $log = $this->createLogChannel('another',storage_path('logs/another/access.log'),  Logger::INFO );
        $log->info($this->prepareMessage($message), $context);
    }

}