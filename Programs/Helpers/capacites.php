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

function setPowerCapacityPourcentByLevel($pkmnAtk, $pkmnDef, $capacite){
    $power = $pkmnDef['Level'];
    // $factor = CustomFunctions::multipleOf($power, 2);
    return $power; 
}

function setPowerCapacityPourcentBySpeed($pkmnAtk, $pkmnDef, $capacite){
    $power = $capacite['Power'];
    $factor = CustomFunctions::multipleOf($power, 2);
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
            Display_Game::messageBoiteDialogue(ucfirst($pkmn['Name']).' wants to learn '.$capacite['Name'].'.');
            Display_Game::messageBoiteDialogue('Do you want to learn '.$capacite['Name'].'? ');
            $choice = binaryChoice();
            if(!$choice){
                Display_Game::messageBoiteDialogue(ucfirst($pkmn['Name'])." didn't learned " .$capacite['Name'].'...');
                 Display::clearGameScreen();
                return false; //for the bag 
                // break;
            }
             Display::clearGameScreen();
            displayPkmnLeftMenu($pkmn);
            displayCapacitiesMenu($pkmn);
            drawCapacityToLearn($capacite, [18,30]);
            // Deuxieme boucle : remplacer par quelle capacite ?
            while(true){
                Display_Game::messageBoiteDialogue('Which capacity to removes?');
                $choice = waitForInput([31,0], [leaveInputMenu(),1,2,3,4]);
                $choice = is_numeric($choice) ? $choice-1 : $choice;// -1 cause of choices +1 for players
                if($choice == leaveInputMenu()){
                    break;
                }
                Display_Game::messageBoiteDialogue('Are you sure to leave '.$pkmn['Capacites'][$choice]['Name'].'? ');
                $choice2 = binaryChoice();
                if($choice2){
                    $pkmn['Capacites'][$choice] = $capacite;
                    $replace = true;
                    Display_Game::messageBoiteDialogue(ucfirst($pkmn['Name']).' has learned ' .$capacite['Name'].'!');
                     Display::clearGameScreen();
                    return true; //for the bag 
                }
                else{
                    continue;
                }
            }
             Display::clearGameScreen();
        }
    }
    else{
        array_push($pkmn['Capacites'], $capacite);
        Display_Game::messageBoiteDialogue(ucfirst($pkmn['Name']).' has learned ' .$capacite['Name'].'!',-1);
        return true; //for the bag 
    }
}

function drawCapacityToLearn($capacity, $pos){
    $y = $pos[0];
    $x = $pos[1];
    Display_Game::setColorByType($capacity['Type']);
    Display::drawBox([4,30],[2+$y,$x],'|','-',true);
    Display::setColor('reset');

    if($capacity['Category'] != 'status'){
        Display::justifyText('Power:'.$capacity['Power'], 9, [4+$y,$x+19],'right');
    }      
    Display_Game::setColorByType($capacity['Category']);
    Display::justifyText(ucfirst($capacity['Category']), 9, [3+$y,$x+19],'right');
    Display::setColor('reset');

    Display::textAreaLimited($capacity['Name'],23,[3+$y,$x+2]);
    Display::textAreaLimited('PP : '.$capacity['PP'].'/'.$capacity['PP Max'],23,[4+$y,$x+2]);
}
?>