<?php


Class CharacterStats extends Stats{

    var $EXP;
    var $LVL;
    var $HP;
    var $BASE_HP;

    var $SPEED;
    var $DODGE;

    var $PDEF;
    var $PATK;

    var $CRITC;
    var $CRITR;


    /*
    var $FIRE_RES;
    var $WATER_RES;
    var $EARTH_RES;
    var $WIND_RES;
    var $LIGHT_RES;
    var $DARK_RES;
    */

    function __construct(){
        $this->_recalculateStats();

        //one time calculations


    }

    function takeDamage($dmg){
       $this->HP-=(int)$dmg;
    }



    function _recalculateStats(){
        $this->trowEvent('StatCalculation');

        $this->BASE_HP   = Formula::HP($this);
        $this->LVL       = Formula::LVL($this);

        $this->PATK = Formula::PATK($this);
        $this->PDEF = Formula::PDEF($this);

        $this->DODGE    = Formula::DODGE($this);
        $this->SPEED    = Formula::SPEED($this);
        $this->CRITC    = Formula::CRITC($this);
        $this->CRITR    = Formula::CRITR($this);

    }


}

