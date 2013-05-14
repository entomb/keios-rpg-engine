<?php

include("OBJ_mysql.php");
include("OBJ_mysql_result.php");


Class DB{

    static $mysql = false;

    static function mysql(){
        if(self::$mysql){
            return self::$mysql;
        }else{
            $config = Config::key('mysql');
            self::$mysql = new OBJ_mysql($config);
        }

        return self::$mysql;
    }

}
