<?php
namespace SkillBook;
use Skill;


Class Buffed extends Skill{


    function onLoad(&$e){
        $_con = 1+($this->_parent->LVL);

        $this->_parent->addCON($_con);

        $this->_registerEventLog(__METHOD__);
    }

}

?>