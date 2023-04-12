<?php
$json = file_get_contents('Resources/Capacites/capacitesv5.json');
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
        if ($element['level'] <= $level) {
            $lastFour[] = $element;
            if (count($lastFour) == 4) {
                break;
            }
        }
    }
    return $lastFour;
}

function getLastElements($array, $level) {
    $capacity = null;
    foreach ($array as $element) {
        if ($element['level'] == $level) {
            $capacity = $element;
            break;
        }
    }
    return $capacity;
}

function setCapacityToPkmn(&$pkmn, $capacite){
    if(count($pkmn['Capacites']) == 4){

        clearInGame();
        include 'Resources/sprites.php';
        drawSprite($sprites[$pkmn['Sprite']], [5,3]);
        limitSentence($pkmn['Name'],30,[3,5]);
        limitSentence('Lv:'.$pkmn['Level'].'  '.$pkmn['Type 1'] .'  '.$pkmn['Type 2'],30,[4,5]);

        $i = 0;
        $y = 0;
        foreach($pkmn['Capacites'] as $capacitePkmn){
            drawBox([5,25],[2+$i,30]);
            limitSentence($y.' '.$capacitePkmn['Name'],23,[3+$i,32]);
            limitSentence('PP : '.$capacitePkmn['PP'].'/'.$capacitePkmn['PP Max'],23,[4+$i,32]);
            ++$y;
            $i += 5;
        }

        // Premiere boucle : vouloir apprendre la capacite ?
        $replace = false;
        while(!$replace){
            messageBoiteDialogue('Do you want to learn '.$capacite['Name'].'? ');
            $choice = waitForInput([31,0], ['y','n']);
            if($choice == 'n'){
                messageBoiteDialogue($pkmn['Name']." didn'y learned " .$capacite['Name'].'...');
                break;
            }
            // Deuxieme boucle : remplacer par quelle capacite ?
            while(true){
                messageBoiteDialogue('Which capacity to removes?');
                $choice = waitForInput([31,0], ['c',0,1,2,3]);
                if($choice == 'c'){
                    break;
                }
                messageBoiteDialogue('Are you sure to leave '.$pkmn['Capacites'][$choice]['Name'].'? ');
                $choice2 = waitForInput([31,0], ['y','n']);
                if($choice2 == 'y'){
                    $pkmn['Capacites'][$choice] = $capacite;
                    $replace = true;
                    break;
                }
                else{
                    continue;
                }
            }
        }
        clearInGame();
    }
    else{
        array_push($pkmn['Capacites'], $capacite);
        messageBoiteDialogue($pkmn['Name'].' has learned ' .$capacite['Name'].'!');
    }
}
?>