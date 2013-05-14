<?php

Class Skill extends EventListener{
    var $name;
    protected static $_skill_info;

    function __construct($tagname,&$obj){
        $this->tagname = $tagname;
        $this->_info = Skill::getInfo($tagname);
        $this->name  = $this->_info['skill'];
        $this->_parent = &$obj;
    }

    private static function _loadClassFile($name){
        $filePath = "class/Skill/$name.php";
        if(file_exists($filePath)){
            include($filePath);
            return true;
        }else{
            return false;
        }
    }

    static function load($name,&$_parent){
        $namespace_name = "SkillBook\\$name";
        if(class_exists($namespace_name)){
            return new $namespace_name($name,$_parent);
        }elseif(self::_loadClassFile($name)){ //defined skill
            return new $namespace_name($name,$_parent);
        }else{
            return new Skill($name,$_parent);
        }
    }

    static function getInfo($name){
        if(isset(self::$_skill_info[$name])){
            return self::$_skill_info[$name];
        }

        $row = DB::mysql()->query("SELECT * FROM skills WHERE classname = ?",array($name))->fetchArray();

        self::$_skill_info[$name]=$row;
        return $row;
    }

}