<?php

Class Stats {

    var $STR;
    var $CON;
    var $DEX;


    function _importBaseAttributes(){
        $this->STR = (int)$this->BASE_STR;
        $this->CON = (int)$this->BASE_CON;
        $this->DEX = (int)$this->BASE_DEX;
        $this->_recalculateStats();
    }


    function addSTR($value){
        $this->STR+=(int)$value;
        $this->_registerStatChange("STR",$value);
        $this->_recalculateStats();
    }

    function addCON($value){
        $this->CON+=(int)$value;
        $this->_registerStatChange("CON",$value);
        $this->_recalculateStats();
    }

    function addDEX($value){
        $this->DEX+=(int)$value;
        $this->_registerStatChange("DEX",$value);
        $this->_recalculateStats();
    }


    private function _registerStatChange($stat,$value){
        if(method_exists($this,'trowEvent')){
            $this->trowEvent('StatChange');
        }

        $sign = ($value>=0) ? "+" : "-";
        $this->_log_stats_changes[] = array($stat,$sign.$value);

    }

}

