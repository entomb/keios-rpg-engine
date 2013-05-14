<?php
namespace SkillBook;
use Skill;


Class AgileMovement extends Skill{


    function onLoad(&$e){
        $_dex = 1+($this->_parent->LVL);

        $this->_parent->addDEX($_dex);

        $this->_registerEventLog(__METHOD__);
    }

}

?>