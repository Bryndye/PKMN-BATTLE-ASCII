<?php
$json = file_get_contents('json/capacitesv5.json');
$capacites = json_decode($json, true);


function getCapacite($name){
    global $capacites;
    if(isset($capacites[$name])){
        return setCapacitePlayable($capacites[$name]);
    }
    else return null;
}

function getRandCapacites(){
    global $capacites;
    $keys = array_keys($capacites);
    $randomIndex = array_rand($keys);
    $capacite = setCapacitePlayable($capacites[$keys[$randomIndex]]);
    return $capacite;
}

function setCapacitePlayable($capacite){
    $capacite['PP Max'] = $capacite['PP'];
    unset($capacite['Pkmns Learned']);
    return $capacite;
}

function setPowerCapacityPourcentByWeight($pkmn){
    $weight = $pkmn['weight']; 
    $power = 20;  
    if($weight < 10){
        $power = 20;
    }
    else if ($weight < 25) {
        $power = 40;
    } 
    else if ($weight < 50) {
        $power = 60;
    }
    else if ($weight < 100) {
        $power = 80;
    }
    else if ($weight <= 200) {
        $power = 100;
    }
    else{
        $power = 120;
    }   
    return $power;
}   

function setPowerCapacityPourcentBySpeed($pkmnAtk, $pkmnDef, $capacite){
    $power = $capacite['Power'];
    $factor = multipleOf($power, 2);
    return $factor * 20; 
}

function setPowerCapacityToOS($pkmnDef, $capacite){
    return 100000000;
}

function getLastFourElements($array, $level) {
    $lastFour = [];
    foreach ($array as $element) {
        if ($element['level'] < $level) {
            $lastFour[] = $element;
            if (count($lastFour) == 4) {
                break;
            }
        }
    }
    // $missingElements = 4 - count($lastFour);
    // if ($missingElements > 0) {
    //     $lastFour = array_merge(array_fill(0, $missingElements, ['name' => '', 'level' => 0]), $lastFour);
    // }
    return $lastFour;
}

?>