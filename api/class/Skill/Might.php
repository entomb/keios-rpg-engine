<?php
namespace SkillBook;
use Skill;


Class Might extends Skill{


    function onLoad(&$e){
        $_str = 1+($this->_parent->LVL);
        $this->_parent->addSTR($_str);

        $this->_registerEventLog(__METHOD__);
    }

}