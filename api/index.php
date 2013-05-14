<?php
echo count(false);
exit();

//keios test API
function dump($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

set_time_limit(99999);

//autoload
$Core = glob("core/*.php");

$Loader = array_merge($Core,array(
                'core/static/Config.php',
                'core/db/DB.php',
                'core/static/Chance.php',
                'core/static/Formula.php',
                'core/static/Func.php',
                'class/Char/CharacterSlots.php',
                'class/Char/CharacterStats.php',
                'class/Char/Character.php',
                'class/Combat/Combat.php',
                'class/Combat/CombatTurn.php',
            )
        );

foreach($Loader as $classname){
    include($classname);
}


$Player1 = new Character(1);
$Player2 = new Character(2);

$Player1->EXP = 1010;
$Player2->EXP = 2100;

$Combat = new Combat($Player1,$Player2);
$Combat->fight();

//$Combat->printLog();


echo "<table border='1' cellpadding='3'>";
foreach($Combat->turns as $turn){
    foreach($turn->actions as $action){
        echo "<tr>";
            echo "<td>";
            if($action['pivot']->name=='entomb'){
                echo "<b style='color:green;'>".$action['pivot']->name."</b>";
            }else{
                echo "<b style='color:red;'>".$action['pivot']->name."</b>";
            }
                echo $action['pivot']->LVL;
            echo "</td>";
            echo "<td>";
                echo $action['pivot']->HP." HP";
            echo "</td>";
            echo "<td>";
                echo $action['action'];
            echo "</td>";
            echo "<td>";
                echo Combat::parseLogText($action);
            echo "</td>";
        echo "</tr>";
    }
}
echo "<tr>";
    echo "<td colspan='4'>";
        if($Combat->winner->name=='entomb'){
            echo "<b style='color:green;'>".$Combat->winner->name."</b>";
        }else{
            echo "<b style='color:red;'>".$Combat->winner->name."</b>";
        }

        echo " <b>WINS!</b> with ".$Combat->winner->HP. " HP left!";
    echo "</td>";
echo "</tr>";
echo "<tr>";
    echo "<td colspan='4'>";
        echo "this combat awards ".$Combat->winner_exp. " XP!";
    echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br/><br/><br/><br/>";


exit();

//test progression
$win = array();
for($k=0; $k<10; $k++){
    $win[$k] = array();
    for($y=0; $y<10; $y++){
        $Player1 = new Character(1);
        $Player2 = new Character(2);

        $Player1->EXP+=$k*1000;
        $Player1->CON+=$k*2;
        $Player1->STR+=$k*2;
        $Player1->DEX+=$k*2;
        $Player1->_recalculateStats();

        $Player2->EXP+=$k*1000;
        $Player2->CON+=$k*2;
        $Player2->STR+=$k*2;
        $Player2->DEX+=$k*2;
        $Player2->_recalculateStats();

        $Combat = new Combat($Player1,$Player2);
        $Combat->fight();
        $win[$k][] = $Combat->winner->name =="entomb" ? 1 : 2;
    }
}
$_avg = 0;
foreach($win as $key => $vi){
    $avg=round(array_sum($vi)/count($vi),2);
    $_avg+=$avg;
    //echo $key.">".$avg;
    //echo "<br>";
}

echo "advantage: ".((2-($_avg/count($win)))*100)."%".($_avg/count($win)<1.5 ? ' entomb' : " vladimir");
//dump($Player1);




echo "<hr>";
dump(array("memory"=>Func::memoryUsage()));
//dump(DB::mysql()->log());
?>
<style>
    * {
        font-family:arial;
    }

    .pivot{
        color:blue;
    }
    .action{
        color:#333;
    }
    .origin{
        color:#666;
    }
</style>