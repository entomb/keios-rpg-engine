<?php


Class Combat {

    var $ATK_char;
    var $DEF_char;

    var $actions = array();
    var $turns = array();
    var $pivot;

    private $_combo_streak=0;

    function __construct(&$ATK_char,&$DEF_char){

        $this->ATK_char = $ATK_char;
        $this->DEF_char = $DEF_char;

        //focus
        $this->pivot = $this->ATK_char;


        //set Targets
        $this->ATK_char->_target = &$this->DEF_char;
        $this->DEF_char->_target = &$this->ATK_char;

        $this->ATK_char->prepareCombat();
        $this->DEF_char->prepareCombat();

    }

    function fight(){
        $this->trowEvent('EnterCombat');

        while($this->checkForWin()){
            $this->resolveTurn();
        }

        $this->trowEvent('EndCombat');
        $this->_calculateExpGain();
    }

    protected function _calculateExpGain(){

        $BASE_EXP = count($this->turns)*($this->ATK_char->LVL+$this->DEF_char->LVL);
        $BASE_EXP = $BASE_EXP/10;

        $this->winner_exp = $BASE_EXP*2;
        $this->loser_exp  = round($BASE_EXP/3);

    }

    protected function checkForWin(){

        if($this->ATK_char->HP<=0){
            $this->trowEvent('LoseCombat',$this->DEF_char);
            $this->trowEvent('WinCombat',$this->ATK_char);
            $this->winner = $this->DEF_char;
            return false;
        }

        if($this->DEF_char->HP<=0){
            $this->trowEvent('LoseCombat',$this->ATK_char);
            $this->trowEvent('WinCombat',$this->DEF_char);
            $this->winner = $this->ATK_char;
            return false;
        }

        return true;

    }

    protected function resolveTurn(){
        $this->pivot = $this->getNextPivot();
        $_turn = new CombatTurn($this->pivot,$this);
        $this->turns[] = $_turn;

    }


    static function parseLogText($action){
        $text = $action['text'];

        $text = str_replace("{p}","<b class='pivot'>{p}</b>", $text);
        $text = str_replace("{t}","<b class='target'>{t}</b>", $text);
        $text = str_replace("{o}","<b class='origin'>{o}</b>", $text);
        $text = str_replace("{n}","<b class='number'>{n}</b>", $text);

        $text = str_replace("{p}",$action['pivot']->name, $text);
        $text = str_replace("{t}",$action['target']->name, $text);
        $text = str_replace("{o}",$action['origin'], $text);
        $text = str_replace("{n}",$action['number'], $text);

        return $text;
    }


    function _registerAction(&$pivot,&$target,$number,$action,$text,$origin){
        $this->actions[] = array(
                                  'pivot'  => (object)(array)$pivot,
                                  'target' => (object)(array)$target,
                                  'action' => $action,
                                  'number' => $number,
                                  'text'   => $text,
                                  'origin' => $origin,
                                );
    }


    private function getNextPivot(){

        //double-strike chance
        if(Chance::percent($this->pivot->SPEED/(($this->_combo_streak/3)+1))){
            $this->_combo_streak++;
            return $this->pivot;
        }

        //fumble chance
        if($this->pivot->LVL > $this->pivot->_target->LVL-5){
            if(Chance::coin()){
                return $this->pivot;
            }
        }


        //switch fase
        $this->_combo_streak = 0;
        if($this->pivot->id_character==$this->ATK_char->id_character){
            return $this->DEF_char;
        }else{
            return $this->ATK_char;
        }

    }

    function trowEvent($event,&$char=null){
        if($char){
            $char->trowEvent($event,$this);
        }elseif($this->pivot){
            $this->pivot->trowEvent($event,$this);
            $this->pivot->_target->trowEvent($event,$this);
        }
    }

}


?>