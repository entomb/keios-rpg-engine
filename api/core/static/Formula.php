<?php

Class Formula{


    //EXP and LVL
    static $_exp_max_lvl  = 100;
    static $_exp_min_step = 300;
    static $_exp_factor   = 0.3;

    static function LVL(&$obj){
        for($k=1;$k<self::$_exp_max_lvl;$k++){

            $EXP_CALC  = $k*(self::$_exp_min_step*$k)*self::$_exp_factor;
            $EXP_BONUS = log($k*self::$_exp_min_step*self::$_exp_factor,50);

            //hard int rounder
            $EXP = round(($EXP_CALC * $EXP_BONUS)/15)*15;

            if($EXP>=$obj->EXP){
                return $k-1;
            }
        }

        return self::$_exp_max_lvl;
    }

    //CALCULATED STATS
    static function PATK(&$obj){

        $_PATK = (pow($obj->LVL,2))+(($obj->STR*2)+($obj->DEX/3));

        return round($_PATK);
    }

    static function PDEF(&$obj){

        $_PDEF = (pow($obj->LVL,2))+(($obj->CON*2)+($obj->STR/3));

        return round($_PDEF);
    }

    static function HP(&$obj){

        $_HP = (($obj->LVL*100)+pow($obj->CON,2));

        return round($_HP);
    }

    static function DODGE(&$obj){

        $_DODGE = 5+((($obj->DEX)/100)*0.8);

        if($_DODGE>40) $_DODGE = 40;

        return round($_DODGE);
    }

    static function SPEED(&$obj){

        $_SPEED = LOG((($obj->DEX)*$obj->LVL)/2,2)+($obj->LVL);

        if($_SPEED>50) $_SPEED = 50;

        return round($_SPEED);
    }

    static function CRITR(&$obj){
        $_CRIT_RATE = LOG($obj->DEX/3,5);

        if($_CRIT_RATE<1.2)  $_CRIT_RATE = 1.2;
        if($_CRIT_RATE>4) $_CRIT_RATE = 4;

        return round($_CRIT_RATE,2);
    }

    static function CRITC(&$obj){

        $_CRIT_CHANCE = 3+LOG($obj->DEX,3)+($obj->DEX/20);

        if($_CRIT_CHANCE>50) $_CRIT_CHANCE = 50;

        return round($_CRIT_CHANCE);
    }

    //DAMAGE
    static function damage(&$pivot,&$target){

        $PATK = $pivot->PATK;
        $PDEF = $target->PDEF;

        $top_margin = $PATK+($PATK/3);
        $low_margin = $PATK-($PATK/5);

        $swing_damage  = Chance::range($low_margin,$top_margin);
        $swing_defence = Chance::range($PDEF/2,$PDEF);

        $dmg = ($swing_damage-$swing_defence);

        if($dmg<1) $dmg = Chance::range(1,$pivot->LVL);

        return (int)$dmg;
    }


}



