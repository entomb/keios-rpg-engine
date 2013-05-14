<?php




class CombatTurn extends Combat{

    var $action_log = "";

    function __construct(&$pivot){

        $this->pivot=&$pivot;
        $this->trowEvent("TurnStart");

        $this->trowEvent('MyTurnStart',$this->pivot);
        $this->trowEvent('EnemyTurnStart',$this->pivot->_target);


        $this->_pre_atack();
        $this->_atack();
        $this->_pos_atack();


        $this->trowEvent("TurnEnd");

        $this->trowEvent('MyTurnEnd',$this->pivot);
        $this->trowEvent('EnemyTurnEnd',$this->pivot->_target);
    }


    function _pre_atack(){
        $this->trowEvent("AtackFaseStart");

        $this->trowEvent('MyAtackFaseStart',$this->pivot);
        $this->trowEvent('EnemyAtackFaseStart',$this->pivot->_target);

    }

    function _atack(){
        $this->trowEvent("AtackFase");

        $this->trowEvent('MyAtackFase',$this->pivot);
        $this->trowEvent('EnemyAtackFase',$this->pivot->_target);

        //natural damage
        $this->damage = Formula::damage($this->pivot,$this->pivot->_target);


        //critical hit?
        $is_critical_hit = false;
        if(Chance::percent($this->pivot->CRITC)){
            $is_critical_hit=true;
            $this->damage*$this->pivot->CRITR;
        }

        //dodge
        if(!$is_critical_hit){
            if(Chance::percent($this->pivot->_target->DODGE)){
                $this->damage = 0;
            }
        }

        if($this->damage==0){
            $this->pivot->trowEvent('TargetMissed',$this);
            $this->pivot->_target->trowEvent('DodgedAttack',$this);
            $this->_registerAction($this->pivot,$this->pivot->_target,$this->damage,'miss',"{p} missed the attack on {t}",'combat');
            return;
        }



        $this->pivot->_target->takeDamage($this->damage);

        $this->pivot->_target->trowEvent('TakeDamage',$this);
        $this->pivot->trowEvent('AssignDamage',$this);

        if($is_critical_hit){
            $this->_registerAction($this->pivot,$this->pivot->_target,$this->damage,'atack',"CRITICAL HIT! {p} hits {t} for {n} critical damage",'combat');
        }else{
            $this->_registerAction($this->pivot,$this->pivot->_target,$this->damage,'atack',"{p} hits {t} for {n} damage","combat");
        }


    }


    function _pos_atack(){
        $this->pivot->_last_hit_damage = $this->damage;
        $this->pivot->_target->_last_received_damage = $this->damage;
        $this->trowEvent("AtackFaseEnd");

        $this->trowEvent('MyAtackFaseEnd',$this->pivot);
        $this->trowEvent('EnemyAtackFaseEnd',$this->pivot->_target);

    }

}