<?php

Class Chance{


    static function range($low,$high){
        if($high<$low){
            return 0;
        }
        self::_seed();
        return mt_rand($low,$high);
    }

    static function percent($percent=null){
        if($percent){
            return (bool)(self::range(0,100)<=(int)$percent);
        }else{
            return self::range(0,100);
        }
    }

    static function d6($num=null){
        if($num){
            return (bool)(self::range(1,6)<=(int)$num);
        }else{
            return self::range(1,6);
        }
    }

    static function d12($num=null){
        if($num){
            return (bool)(self::range(1,12)<=(int)$num);
        }else{
            return self::range(1,12);
        }
    }


    static function d20($num=null){
        if($num){
            return (bool)(self::range(1,20)<=(int)$num);
        }else{
            return self::range(1,20);
        }
    }


    static function coin(){
        return (bool)(self::range(1,100)<=50);
    }


    private static function _seed(){
        list($micro, $sec) = explode(' ', microtime());
        $seed = (float)$sec +((float)$micro*100000);
        mt_srand($seed);
    }

}


