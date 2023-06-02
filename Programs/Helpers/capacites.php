<?php
$json = file_get_contents('Resources/Capacites/capacitesv5.json');
$capacites = json_decode($json, true);


function getCapacite($name){
    global $capacites;
    $name = strtolower($name);
    if(isset($capacites[$name])){
        return setCapacitePlayable($capacites[$name]);
    }
    else return null;
}

function getRandCapacites($exception = null){
    global $capacites;
    $keys = array_keys($capacites);
    $randomIndex = array_rand($keys);

    if(!is_null($exception)){
        $filteredCapacites = array_filter($capacites, function($value) use ($exception) {
            return $value !== $exception;
        });
        $capacite = setCapacitePlayable($filteredCapacites[$keys[$randomIndex]]);
        return $capacite;
    }
    else{
        $capacite = setCapacitePlayable($capacites[$keys[$randomIndex]]);
        return $capacite;
    }
}

function setCapacitePlayable($capacite){
    $capacite['PP Max'] = $capacite['PP'];
    unset($capacite['Pkmns Learned']);
    return $capacite;
}

function setPowerCapacityPourcentByWeight($pkmn){
    $weight = $pkmn['scale']['weight']; 
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
    $reversedArray = array_reverse($array);
    foreach ($reversedArray as $element) {
        if ($element['level'] <= $level) {
            $lastFour[] = $element;
            if (count($lastFour) == 4) {
                break;
            }
        }
    }
    $lastFour = array_reverse($lastFour);
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

        // Premiere boucle : vouloir apprendre la capacite ?
        $replace = false;
        while(!$replace){
            messageBoiteDialogue($pkmn['Name'].' wants to learn '.$capacite['Name'].'.');
            messageBoiteDialogue('Do you want to learn '.$capacite['Name'].'? ');
            $choice = binaryChoice();
            if(!$choice){
                messageBoiteDialogue($pkmn['Name']." didn't learned " .$capacite['Name'].'...');
                break;
            }
            clearGameScreen();
            displayPkmnLeftMenu($pkmn);
            displayCapacitiesMenu($pkmn);
    
            // Deuxieme boucle : remplacer par quelle capacite ?
            while(true){
                messageBoiteDialogue('Which capacity to removes?');
                $choice = waitForInput([31,0], [leaveInputMenu(),1,2,3,4]);
                $choice = is_numeric($choice) ? $choice-1 : $choice;// -1 cause of choices +1 for players
                if($choice == leaveInputMenu()){
                    break;
                }
                messageBoiteDialogue('Are you sure to leave '.$pkmn['Capacites'][$choice]['Name'].'? ');
                $choice2 = binaryChoice();
                if($choice2){
                    $pkmn['Capacites'][$choice] = $capacite;
                    $replace = true;
                    messageBoiteDialogue($pkmn['Name'].' has learned ' .$capacite['Name'].'!');
                    break;
                }
                else{
                    continue;
                }
            }
            clearGameScreen();
        }
    }
    else{
        array_push($pkmn['Capacites'], $capacite);
        messageBoiteDialogue($pkmn['Name'].' has learned ' .$capacite['Name'].'!');
    }
}
?>