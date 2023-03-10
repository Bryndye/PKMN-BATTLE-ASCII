<?php

function chooseItems(&$bag, &$pkmnTeam, $type = ''){
    while(true){
        clearInGame();
        $choice = displayBag($bag, $type);
        displayBoiteDialogue();
        limitSentence('Which item to use?');
        
        $choice2 = "";
        $choice1 = waitForInput([31,0], $choice);
        if($choice1 == 'c'){
            break;
        }
        
        $choicesPkmnTeam = displayPkmnTeam($pkmnTeam);
        displayBoiteDialogue();
        limitSentence('Use '.$bag[(int)$choice1]['name'] .' on?');

        $choice2 = selectPkmn($pkmnTeam, 0, true);
        if($choice2 == 'c'){
            continue;
        }
        break;
        // il faut maintenant faire agir le choix
    }
    return "$choice1 $choice2";
}

function displayBag($bag, $typeEnemy = ''){
    $i = 0;
    $y = 1;
    $choice = ['c'];
    foreach($bag as $key => $item){
        moveCursor([4+$i,5]);
        if($typeEnemy == 'trainer' && $item['type'] == 'heal'){
            echo $key . '. '.$item['name'] . ' x ' . $item['quantity'];
            $choice[$y] = $key;
        }
        else{
            echo $key . '. '.$item['name'] . ' x ' . $item['quantity'];
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

function useItem(&$bag, &$item, &$pkmn){
    --$item['quantity'];
    manageBag($bag, $item);

    // utilisation des items
    switch($item['type']){
        case 'heal':
            healPkmn($item, $pkmn);
            break;
        case 'capture':
            captureItem($item, $pkmn);
            break;
    }
}

function healPkmn($item, &$pkmn){
    if(strpos($item['effect'], '%') ){
        if(isPkmnDead_simple($pkmn)){
            $parts = explode("%", $str);
            $value = intval($parts[0]);
            $pkmn['Stats']['Health'] = $value * $pkmn['Stats']['Health Max'];
            messageBoiteDialogue($pkmn['Name'] . " revives!");
        }
        else{
            messageBoiteDialogue($pkmn['Name'] . " is already alive!");
        }
    }
    elseif(!isPkmnDead_simple($pkmn)){    
        $pkmn['Stats']['Health'] += $item['effect'];
        healthInBloc($pkmn);
        messageBoiteDialogue($pkmn['Name'] . " uses ". $item['name']."!");
        print($pkmn['Stats']['Health']);
    }
}

function captureItem($item, $pkmn){
    // chance sur ...
    // si var < chance = capture
    // pkmn to json ?
}

// Pas tester
function giveItem(&$bag, $itemName, $quantity = 1){
    $file = file_get_contents('json/items.json');
    $array = json_decode($file, true);
    
    $info = $array[$itemName];


    $findPlace = false;
    foreach($bag as $key=>$itemInBag){
        if($itemInBag['name'] == $key){
            $bag[$itemInBag['name']]['quantity'] += $quantity;
            $findPlace = true;
        }
    }
    if(!$findPlace){
        $item = [
            "name"=>$itemName, 
            "type"=>$info['type'],
            "effect"=>$info['effect'],
            "quantity"=>$quantity
        ];
        array_push($bag, $item);
    }
}
?>