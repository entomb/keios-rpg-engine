<?php
namespace SkillBook;
use Skill;


Class Vampirism extends Skill{



    function onMyAtackFaseEnd(&$obj){
        if($obj->damage>0){
            $turn_damage = $obj->damage;
            $vamp_absorb = ceil($turn_damage/20);
            $this->HP+=$vamp_absorb;

            $obj->_registerAction($this->_parent,$this->_parent->_target,$vamp_absorb,'heal',"{p} Heals for {n} HP because of {o}",$this->name);

            $this->_registerEventLog(__METHOD__);
        }
    }

}

?>