<?php

Class CharacterSlots {

    var $head;
    var $body;
    var $hands;
    var $feet;

    var $weapon;
    var $shield;


    var $neck;
    var $amulet;
    var $relic;


    function __construct(&$obj){
        $this->_parent = $obj;

        $this->head = Equip::load('helmet');
    }


}