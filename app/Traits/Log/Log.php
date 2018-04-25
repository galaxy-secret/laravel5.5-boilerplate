<?php
/**
 * Created by PhpStorm.
 * User: pandaria
 * Date: 2018/4/13 17:33
 */

namespace App\Traits\Log;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

trait Log {

    protected function createLogChannel($name, $storage_path, $level) {
        $log = new Logger($name);
        $rotating_handler = new RotatingFileHandler($storage_path, 0,$level);
        $rotating_handler->setFormatter( new LineFormatter(null, null, true, true));
        $log->pushHandler($rotating_handler);
        return $log;
    }

    protected function prepareMessage($message) {
        if (is_array($message)){
            $_message = '';
            foreach ($message as $key => $value) {
                $_message .= ' ' . $key . '=' . $value . ' ';
            }
            $return = $_message;
        }else{
            $return = $message;
        }
        return $return;
    }
}