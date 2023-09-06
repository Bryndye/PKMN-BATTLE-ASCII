<?php
// v2
function enterIntoBag(&$save, $type = 'hub'){ 
    $pkmnTeam = &$save['Team'];
    $allItemsBag = &$save['Bag'];
    $indexCategory = 0;
    $currentIndexItemTEMP = 0;
    while(true){
         Display::clearGameScreen();
        
        // Set interface depends on category of items
        if($type == 'wild'){
            $categories = ['Heals','PokeBalls'];
        }
        elseif($type == 'trainer'){
            $categories = ['Heals'];
        }
        elseif($type == 'hub'){
            $categories = Parameters::getAllCategoriesItem();
        }

        // Create list depends on category selected
        $currentListItemTEMP = [];
        foreach($allItemsBag as $key => &$item){
            // CustomFunctions::debugLog($categories[$indexCategory]);
            if($item['type'] == Parameters::getCategoryName($categories, $indexCategory)){
                array_push($currentListItemTEMP, ['key'=>$key, 'item'=>$item]);
            }
        }

        // Create list inputs depends on listItem
        if($type == 'wild' || $type == 'trainer'){
            $moveChoice = inputsNavigate($categories, $currentListItemTEMP);
        }
        elseif($type == 'hub'){
            if(Parameters::getCategoryName($categories, $indexCategory) != 'PokeBalls'){
                $moveChoice = inputsNavigate($categories, $currentListItemTEMP);
            }
            else{
                $moveChoice = inputsNavigate($categories, $currentListItemTEMP, false);
            }
        }
        
        // Draw & write before action
        Display_Game::messageBoiteDialogue(Parameters::getMessageBoiteDialogue());
        drawRefreshInterfaceList($currentListItemTEMP, $currentIndexItemTEMP);
        drawCategoryBag($categories, $indexCategory);

        // Action
        $move = waitForInput(Parameters::getPosChoice(),$moveChoice);
        if($move == leaveInputMenu()){
            return leaveInputMenu();
        }
        // Validation item
        elseif($move == 'v'){
            $choice = useItemOn($allItemsBag, $currentListItemTEMP[$currentIndexItemTEMP]['key'], $pkmnTeam);
            if($choice == leaveInputMenu()){
                continue;
            }
            else{
                return $choice;
            }
        }

        // Move cursor inside list items
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
    Display_Fight::drawPkmnTeam($pkmnTeam);
    sleep(1);
}

function drawRefreshInterfaceList($listItems, $indexItem = 0){
    $i = 2;
    $y = 1;

    foreach($listItems as $key => $item){
        $itemBag = $item['item'];
        $isInBag = array_key_exists('quantity', $itemBag);
        if($isInBag){
            $valueToShow = $itemBag['quantity'];

            if(isset($itemBag['name'])){
                $name = $itemBag['name'];
            }
            else{
                $name = $key;
            }
        }
        else{
            $valueToShow = CustomFunctions::formatMoney($itemBag['price']);
            $name = $itemBag['name'];
        }

        $sign = $isInBag ? ' x ' : ' : ';
        if($key == $indexItem){
            Display::textArea('-> '/*.$key . '. keyBag:'.$keyBag.' '*/.$name . $sign . $valueToShow, [4+$i,5]);
        }
        else{
            Display::textArea(/*$key . '. keyBag:'.$keyBag.' '.*/$name . $sign . $valueToShow, [4+$i,5]);
        }
        $i += 2;
        $y++;
    }
}
function drawCategoryBag($categories, $actualCategory = 0){
    if(is_int($actualCategory)){
        $actualCategory = $categories[$actualCategory];
    }
    drawCategorySelected($categories ,$actualCategory,[4,2]);
}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function useItemOn(&$bag, $indexItem, &$pkmnTeam){
    while(true){
        $choice2 = "";
        $itemToUse = &$bag[$indexItem];
        // Si item pokeball, pas bsoin de choisir un pokemon de la team
        if($itemToUse['type'] == 'PokeBalls'){
            return "$indexItem $choice2";
        }
        Display_Fight::drawPkmnTeam($pkmnTeam);
        $exceptions = getExceptionsItemToPkmnTeam($pkmnTeam, $itemToUse);

        // Select Pkmn to heal
        $choice2 = selectPkmn($pkmnTeam, $exceptions, true, 'Use '.$itemToUse['name'] .' on?');
        if($choice2 == leaveInputMenu()){
            return leaveInputMenu();
        }
        return "$indexItem $choice2";
    }
}


function useItem(&$bag, &$item, &$pkmn){
    $usedItem = true;
    // utilisation des items
    switch($item['type']){
        case 'Heals':
            if(isStatusItem($item)){ // verifie si string et si contient status
                healStatusToPkmn($pkmn);
            }
            else{
                healPkmn($item, $pkmn);
            }
            break;
        case 'PokeBalls':
            removeItem($bag, $item); // exception qui a besoin dun return de capture
            return captureItem($item, $pkmn);
        case 'status':
            healStatusToPkmn($pkmn);
            break;
        case 'TMs':
            $usedItem = setCapacityToPkmn($pkmn, getCapacite($item['name']));
            break;
        case 'Items':
            verifyIfPkmnCanEvolve($pkmn, $item);
            break;
    }
    // CustomFunctions::debugLog($usedItem);
    if(is_bool($usedItem) && $usedItem){
        removeItem($bag, $item);
    }
    else{
        removeItem($bag, $item);
    }
}

function getExceptionsItemToPkmnTeam($pkmnTeam, $item){
    $exceptions = [];
    if($item['type'] == 'Heals'){
        if(isStatusItem($item)){
            foreach($pkmnTeam as $key=>$pkmn){
                if(!hasStatus($pkmn) || $pkmn['Stats']['Health'] <= 0){
                    array_push($exceptions, $key);
                }
            }
        }
        elseif(isReviveItem($item)){
            foreach($pkmnTeam as $key=>$pkmn){
                if($pkmn['Stats']['Health'] > 0){
                    array_push($exceptions, $key);
                }
            }
        }
        else{
            foreach($pkmnTeam as $key=>$pkmn){
                if($pkmn['Stats']['Health'] == $pkmn['Stats']['Health Max'] || $pkmn['Stats']['Health'] <= 0){
                    array_push($exceptions, $key);
                }
            }
        }
        return $exceptions;
    }
}

function isStatusItem($item){
    if(is_string($item['effect']) && strpos($item['effect'], 'status') !== false){
        return true;
    }
    else{
        return false;
    }
}

function isReviveItem($item){
    if(strpos($item['effect'], '%')){
        return true;
    }
    else{
        return false;
    }
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


function removeItem(&$bag, &$item){
    --$item['quantity'];
    if($item['quantity'] <= 0){
        CustomFunctions::remove($item, $bag);
    }
}
?>