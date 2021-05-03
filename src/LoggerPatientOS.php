<?php

namespace App;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerPatientOS
{
    public function ajoutLogInfo($msg){
        $log = new Logger('logger');
        $log->pushHandler(new StreamHandler('logtest.log',Logger::INFO));
        $log->info($msg);
    }
}