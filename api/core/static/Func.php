<?php


Class Func{

    static function memoryUsage($decimals = 2){
            $result = 0;
            if (function_exists('memory_get_usage')){
                $result = memory_get_usage() / 1024;
            }else{
                if (function_exists('exec')){
                    $output = array();
                    if (substr(strtoupper(PHP_OS), 0, 3) == 'WIN'){
                        exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);
                        $result = preg_replace('/[\D]/', '', $output[5]);
                    }else{
                        exec('ps -eo%mem,rss,pid | grep ' . getmypid(), $output);
                        $output = explode('  ', $output[0]);
                        $result = $output[1];
                    }
                }
            }

        return number_format(intval($result) / 1024, $decimals, '.', '')."MB";
    }

}

?>