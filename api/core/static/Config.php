<?php



Class Config{

    private static $mysql = array(
            "hostname" => "localhost",
            "database" => "keios",
            "username" => "root",
            "password" => "",
            "exit_on_error" => true,
        );

    static function key($k){
        return self::$$k;
    }
}