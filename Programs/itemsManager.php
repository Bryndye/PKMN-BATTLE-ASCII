<?php

function managerItemsIntoMenu(&$save){
    $pkmnTeamJoueur = &$save['Team'];
    while(true){
        $choice = chooseItems($save['Bag'], $pkmnTeamJoueur, 'trainer');
        if(substr($choice, 0, 1) == 'c'){
            break;
        }
        elseif(substr($choice, 1, 1) == 'c'){
            continue;
        }
        else{
            $action = explode(" ", $choice);
            useItem($save['Bag'], $save['Bag'][$action[0]], $pkmnTeamJoueur[$action[1]]);
            displayPkmnTeam($pkmnTeamJoueur);
            sleep(1);
        }
    }
}

function chooseItems(&$bag, &$pkmnTeam, $type = ''){
    while(true){
        clearInGame();
        $choice = displayBag($bag, $type);
        displayBoiteDialogue();
        messageBoiteDialogueContinue('Which item to use?');

        $choice2 = "";
        $choice1 = waitForInput([31,0], $choice);
        if($choice1 == 'c'){
            break;
        }
        
        $choicesPkmnTeam = displayPkmnTeam($pkmnTeam);

        // Si item pokeball, pas bsoin de choisir un pokemon de la team
        if($bag[(int)$choice1]['type'] == 'capture'){
            return "$choice1 $choice2";
        }
        // Select Pkmn to heal
        $choice2 = selectPkmn($pkmnTeam, 0, true, 'Use '.$bag[(int)$choice1]['name'] .' on?');
        if($choice2 == 'c'){
            continue;
        }
        break;
    }
    return "$choice1 $choice2";
}

function displayBag($bag, $typeEnemy = ''){
    $i = 0;
    $y = 1;
    $choice = ['c'];
    foreach($bag as $key => $item){
        moveCursor([4+$i,5]);
        $name = '';
        if(isset($item['name'])){
            $name = $item['name'];
        }
        else{
            $name = $key;
        }

        if($typeEnemy == 'trainer' && ($item['type'] == 'heal' || $item['type'] == 'status')){
            echo $key . '. '.$name . ' x ' . $item['quantity'];
            $choice[$y] = $key;
        }
        elseif($typeEnemy == 'wild'){
            echo $key . '. '.$name . ' x ' . $item['quantity'];
            $choice[$y] = $key;
        }
        $i += 2;
        $y++;
    }
    return $choice;
}

function manageBag(&$bag, &$item){
    if($item['quantity'] <= 0){
        remove($item, $bag);
    }
}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function useItem(&$bag, &$item, &$pkmn){
    --$item['quantity'];
    manageBag($bag, $item);

    // utilisation des items
    switch($item['type']){
        case 'heal':
            healPkmn($item, $pkmn);
            break;
        case 'capture':
            return captureItem($item, $pkmn);
        case 'status':
            healStatusToPkmn($pkmn);
            break;
    }
}

function healPkmn($item, &$pkmn){
    if(strpos($item['effect'], '%') ){
        if(isPkmnDead_simple($pkmn)){
            $parts = explode("%", $item['effect']);
            $value = intval($parts[0]);
            $pkmn['Stats']['Health'] = intval(($value/100) * $pkmn['Stats']['Health Max']);
            messageBoiteDialogue($pkmn['Name'] . " revives!");
        }
        else{
            messageBoiteDialogue($pkmn['Name'] . " is already alive!");
        }
    }
    elseif(!isPkmnDead_simple($pkmn)){    
        $pkmn['Stats']['Health'] += $item['effect'];
        healthInBloc($pkmn);
        messageBoiteDialogue("Use ". $item['name'].' on '.$pkmn['Name'] . "!");
        print($pkmn['Stats']['Health']);
    }
}

function healStatusToPkmn(&$pkmn){
    $pkmn['Status'] = null;
    messageBoiteDialogue($pkmn['Name'] . ' is cured of its ailment!');
}

function captureItem($pokeball, $pkmn){
    include 'visuals/sprites.php';
    animationCapture();

    $f = floor(($pkmn['Stats']['Health Max'] * 255 * 4) / ($pkmn['Stats']['Health'] * $pokeball['effect']));

    $captureRate = (((3 * $pkmn['Stats']['Health Max'] - 2 * $pkmn['Stats']['Health']) * 0.5 * $pokeball['effect']) 
    / (3 * $pkmn['Stats']['Health Max'])) * getStatusEffect('', 'capture');

    $randomNumber = rand(0, 100) / 100; // Génère un nombre aléatoire entre 0 et 1
    sleep(1);
    if($randomNumber <= $captureRate) {
        messageBoiteDialogue('The Pokemon has been captured!');
        return true;
    } else {
        messageBoiteDialogue('Oh no! The Pokemon escapes the ball!');
        displaySpritePkmn($pkmn, false);
        return false;
    }
}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function giveItemFromResources(&$bag, $itemName, $quantity = 1){
    $file = file_get_contents('json/items.json');
    $array = json_decode($file, true);
    
    $info = $array[$itemName];

    $findPlace = false;
    foreach($bag as $key=>$itemInBag){
        if($itemInBag['name'] == $itemName){
            $bag[$key]['quantity'] += $quantity;
            $findPlace = true;
        }
    }
    if(!$findPlace){
        $item = $info;
        $item['quantity'] = $quantity;
        array_push($bag, $item);
    }
}

function giveItemByItem(&$bag, $item, $quantity = 1){
    $findPlace = false;
    foreach($bag as $key=>$itemInBag){
        if($itemInBag['name'] == $item['name']){
            $bag[$key]['quantity'] += $quantity;
            $findPlace = true;
        }
    }
    if(!$findPlace){
        $item['quantity'] = $quantity;
        array_push($bag, $item);
    }
}

function itemReturn($item, $quantity = 1){
    $file = file_get_contents('json/items.json');
    $array = json_decode($file, true);
    
    return $array[$item];
}
?>