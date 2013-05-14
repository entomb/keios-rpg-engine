<?php
Class EventListener{

    function onLoad(&$e){}
    function onEnterCombat(&$e){}
    function onTest(&$e){}


    function _registerEventLog($catcher){
        $this->_parent->_log_events_catch[]=$catcher;
    }
}