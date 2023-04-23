<?php
// v2
function enterIntoBag(&$save, $type = 'hub'){ 
    $pkmnTeam = &$save['Team'];
    $allItemsBag = &$save['Bag'];
    $indexCategory = 0;
    $currentIndexItemTEMP = 0;
    while(true){
        clearGameScreen();

        // savoir les categoires a mettre sur interface
        // recuperer list du premier onglet interface
        if($type == 'wild'){
            $categories = ['Heals','PokeBalls'];
        }
        elseif($type == 'trainer'){
            $categories = ['Heals'];
        }
        elseif($type == 'hub'){
            $categories = getAllCategoriesItem();
        }

        // Create list depends on category selected
        $currentListItemTEMP = [];
        foreach($allItemsBag as $key => &$item){
            // debugLog($categories[$indexCategory]);
            if($item['type'] == getCategoryName($categories, $indexCategory)){
                array_push($currentListItemTEMP, ['key'=>$key, 'item'=>$item]);
            }
        }

        // Create list inputs depends on listItem
        if($type == 'wild' || $type == 'trainer'){
            $moveChoice = inputsNavigate($categories, $currentListItemTEMP);
        }
        elseif($type == 'hub'){
            if(getCategoryName($categories, $categories[$indexCategory]) != 'PokeBalls'){
                $moveChoice = inputsNavigate($categories, $currentListItemTEMP);
            }
            else{
                $moveChoice = inputsNavigate($categories, $currentListItemTEMP, false);
            }
        }
        // debugLog($currentListItemTEMP);
        messageBoiteDialogue('Which item to use?');
        drawBag2($currentListItemTEMP, $currentIndexItemTEMP);
        drawCategoryBag($categories, $indexCategory);

        // Action
        $move = waitForInput(getPosChoice(),$moveChoice);
        if($move == 'c'){
            return 'c';
        }
        elseif($move == 'v'){
            $choice = useItemOn($allItemsBag, $currentListItemTEMP[$currentIndexItemTEMP]['key'], $pkmnTeam);
            if($choice == 'c'){
                continue;
            }
            else{
                return $choice;
            }
        }

        // deplacement des categories
        elseif($move == 'q'){
            if($indexCategory > 0){
                $indexCategory -= 1;
            }
            else{
                $indexCategory = count($categories)-1;
            }
            $currentIndexItemTEMP = 0;
        }
        elseif($move == 'd'){
            if($indexCategory < count($categories)-1){
                $indexCategory += 1;
            }
            else{
                $indexCategory = 0;
            }
            $currentIndexItemTEMP = 0;
        }

        elseif($move == 'z'){
            if($currentIndexItemTEMP > 0){
                $currentIndexItemTEMP -= 1;
            }
            else{
                $currentIndexItemTEMP = count($currentListItemTEMP)-1;
            }
        }
        elseif($move == 's'){
            if($currentIndexItemTEMP < count($currentListItemTEMP)-1){
                $currentIndexItemTEMP += 1;
            }
            else{
                $currentIndexItemTEMP = 0;
            }
        }
    }
}

function actionBagHub(&$save, &$pkmnTeam, $choice){
    $action = explode(" ", $choice);
    useItem($save['Bag'], $save['Bag'][$action[0]], $pkmnTeam[$action[1]]);
    drawPkmnTeam($pkmnTeam);
    sleep(1);
}

function drawBag2(&$listItems, $indexItem = 0){
    $i = 2;
    $y = 1;

    foreach($listItems as $key => $item){

        $keyBag = $item['key'];
        $itemBag = $item['item'];
        $name = '';
        if(isset($itemBag['name'])){
            $name = $itemBag['name'];
        }
        else{
            $name = $key;
        }
        if($key == $indexItem){
            textArea('-> '.$key . '. keyBag:'.$keyBag.' '.$name . ' x ' . $itemBag['quantity'], [4+$i,5]);
        }
        else{
            textArea($key . '. keyBag:'.$keyBag.' '.$name . ' x ' . $itemBag['quantity'], [4+$i,5]);
        }
        $i += 2;
        $y++;
    }
}

function useItemOn(&$bag, $indexItem, &$pkmnTeam){
    while(true){
        drawPkmnTeam($pkmnTeam);
        $choice2 = "";
        $itemToUse = &$bag[$indexItem];
        // Si item pokeball, pas bsoin de choisir un pokemon de la team
        if($itemToUse['type'] == 'PokeBalls'){
            return "$indexItem $choice2";
        }
        // Select Pkmn to heal
        $choice2 = selectPkmn($pkmnTeam, 0, true, 'Use '.$itemToUse['name'] .' on?');
        if($choice2 == 'c'){
            return 'c';
        }
        return "$indexItem $choice2";
    }
}

function drawCategoryBag($categories, $actualCategory = 0){
    if(is_int($actualCategory)){
        $actualCategory = $categories[$actualCategory];
    }
    drawCategorySelected($categories ,$actualCategory,[4,2]);
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
        case 'Heals':
            healPkmn($item, $pkmn);
            break;
        case 'PokeBalls':
            return captureItem($item, $pkmn);
        case 'status':
            healStatusToPkmn($pkmn);
            break;
        case 'TM':
            healStatusToPkmn($pkmn);
            break;
        case 'evolution':
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
            messageBoiteDialogue($pkmn['Name'] . " revives!",1);
        }
        else{
            messageBoiteDialogue($pkmn['Name'] . " is already alive!",1);
        }
    }
    elseif(!isPkmnDead_simple($pkmn)){    
        $pkmn['Stats']['Health'] += $item['effect'];
        healthInBloc($pkmn);
        messageBoiteDialogue("Use ". $item['name'].' on '.$pkmn['Name'] . "!",1);
        print($pkmn['Stats']['Health']);
    }
}

function healStatusToPkmn(&$pkmn){
    $pkmn['Status'] = null;
    messageBoiteDialogue($pkmn['Name'] . ' is cured of its ailment!',1);
}

function captureItem($pokeball, $pkmn){
    animationCapture();
    // $a = (1 - (2/3)*($pkmn['Stats']['Health']/$pkmn['Stats']['Health Max'])) * 200 *  $pokeball['effect'] * getStatusEffect($pkmn['Status'], 'capture');
    // // a >= 255 -> captured
    // // debugLog((1 - (2/3)*($pkmn['Stats']['Health']/$pkmn['Stats']['Health Max'])));
    // // debugLog(200 *  $pokeball['effect'] * getStatusEffect($pkmn['Status'], 'capture'));
    // debugLog($a);
    // if($a < 255){

    // }

    $f = floor(($pkmn['Stats']['Health Max'] * 255 * 4) / ($pkmn['Stats']['Health'] * $pokeball['effect']));

    $captureRate = (((3 * $pkmn['Stats']['Health Max'] - 2 * $pkmn['Stats']['Health']) * 0.5 * $pokeball['effect']) 
    / (3 * $pkmn['Stats']['Health Max'])) * getStatusEffect('', 'PokeBalls');

    $randomNumber = rand(0, 100) / 100; // Génère un nombre aléatoire entre 0 et 1
    sleep(1);
    if($randomNumber <= $captureRate || $pokeball['effect'] >= 255) {
        messageBoiteDialogue('The Pokemon has been captured!',1);
        return true;
    } else {
        messageBoiteDialogue('Oh no! The Pokemon escapes the ball!',1);
        drawSpritePkmn($pkmn, false);
        return false;
    }

}

// $probabilite = probaCapture(20, 20, 255, 1, 1);
// echo "La probabilité d'attraper le Chenipan est de : " . round($probabilite * 100, 2) . "%";
// sleep(10);
function probaCapture($pvActuels, $pvMax, $tauxCapture, $bonusStatut, $bonusBall) {
    $a = (3 * $pvMax - 2 * $pvActuels) * $tauxCapture * $bonusStatut / (3 * $pvMax) * $bonusBall;
    $a = min(max($a, 1), 255);
    $b = 65536 / pow(255 / $a, 0.1875);
    $probCapture = (pow($b, 0.3) * $tauxCapture * $bonusStatut) / (pow(255, 0.3) * $bonusBall);
    return $probCapture;
}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function giveItemFromResources(&$bag, $itemName, $quantity = 1){
    $file = file_get_contents('Resources/items.json');
    $array = json_decode($file, true);
    
    $info = $array[$itemName];

    $findPlace = false;
    foreach($bag as $key=>$itemInBag){
        if(!key_exists('name',$itemInBag)){
            print_r($itemInBag);
            sleep(5);
        }
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

function getItemObject($itemName, $quantity = 1){
    $file = file_get_contents('Resources/items.json');
    $array = json_decode($file, true);
    $item = $array[$itemName];
    $item['quantity'] = $quantity;
    return $item;
}
?>