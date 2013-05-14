<?php

Class Character extends CharacterStats{

    var $_log_events_trow;
    var $_log_events_catch;
    var $_log_stats_changes;

    function __construct($id=null){

        $this->skills = array();
        $this->equip = new CharacterSlots($this);
        $this->trowEvent('Init');

        if($id){
            $this->_loadCharacter((int)$id);
        }

        //prepare HP
        $this->HP = $this->BASE_HP;

        $this->trowEvent('Load');
        $this->trowEvent('Ready');
    }



    function _loadCharacter($id){

        $sql = "SELECT * FROM pl_character WHERE id_character=? LIMIT 1";
        $Char = DB::mysql()->query($sql,array($id))->fetch();

        if($Char){
            $this->db_instace = $Char;
            $this->id_character = $Char['id_character'];

            $this->name     = $Char['name'];
            $this->id_race  = $Char['id_race'];


            $this->LVL      = (int)$Char['LVL'];
            $this->BASE_STR = (int)$Char['BASE_STR'];
            $this->BASE_CON = (int)$Char['BASE_CON'];
            $this->BASE_DEX = (int)$Char['BASE_DEX'];

            $this->_importBaseAttributes();
        }

        $sql = "SELECT *
                  FROM skills
                  JOIN pl_character_skills USING(id_skill)
                 WHERE id_character = ?";
        $this->db_skillbook = DB::mysql()->query($sql,array($id))->fetchAll();
        foreach($this->db_skillbook as $_row){
            $this->skills[] = Skill::load($_row['classname'],$this);
        }
    }

    function hasSkill($name){
        if(!isset($this->skills)){
            return false;
        }

        foreach($this->skills as &$skill){
            if($skill->tagname==$tagname){
                return true;
            }
        }

        return false;
    }

    function prepareCombat(){
        $this->HP = $this->BASE_HP;
        $this->_recalculateStats();
    }


    function trowEvent($event,&$context=null){
        $eventName = "on$event";
        $this->_log_events_trow[] = $eventName;
        foreach($this->skills as $k => &$_skill){
            if(method_exists($_skill, $eventName)){
                $_skill->{$eventName}($context);
            }
        }
    }

}



