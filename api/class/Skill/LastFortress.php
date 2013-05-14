<?php
namespace SkillBook;
use Skill;


Class LastFortress extends Skill{

    var $is_active = false;

    private function _applyDefenceBoost(){
        $this->is_active = true;
        $_boost = ($this->_parent->PDEF/2);
        $this->_parent->PDEF+=$_boost;
        return $_boost;
    }

    private function _checkForLowHP(){
        return (bool)($this->_parent->HP < ($this->_parent->BASE_HP/8));
    }

    function onEnemyTurnEnd(&$obj){
        if($this->is_active) return;

        if($this->_checkForLowHP()){
            $_boost = $this->_applyDefenceBoost();

            $obj->_registerAction($this->_parent,$this->_parent,$_boost,'shield',"{p} shields himself for a {n} DEF boost using {o}",$this->name);

            $this->_registerEventLog(__METHOD__);
        }

    }

    function onStatCalculation(){
        if($this->is_active) return;

        if($this->_checkForLowHP()){
            $this->_applyDefenceBoost();
        }
    }

    function onTurnStart(&$obj){
        if(!$this->_checkForLowHP()){
            $this->is_active = false;
            $this->_parent->_recalculateStats();
        }
    }



}

?>