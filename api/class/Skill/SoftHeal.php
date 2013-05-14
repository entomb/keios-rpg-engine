<?php
namespace SkillBook;
use Skill;
use Chance;


Class SoftHeal extends Skill{



    function onMyTurnStart(&$obj){
        if($this->_parent->HP<$this->_parent->BASE_HP/3){
            if(Chance::percent(30)){
                $_heal = round($this->_parent->HP/12);
                if($_heal<1) $_heal = 1;
                $this->_parent->HP+=$_heal;
                $obj->_registerAction($this->_parent,$this->_parent,$_heal,'heal',"{p} Heals for {n} HP using {o}",$this->name);
            }
        }

        $this->_registerEventLog(__METHOD__);
    }

}

?>