<?php

function managerShop(&$save){
    $indexCategory = 0;
    $currentIndexItemTEMP = 0;
    $listIemsShop = getSave('Resources/items.json'); // TEMP
    $listIemsShop = listItemsBuyableInShop($save['IndexFloor']);
    while(true){
         Display::clearGameScreen();

        $categories = Parameters::getAllCategoriesItem();

        // Create list depends on category selected
        $currentListItemTEMP = [];
        foreach($listIemsShop as $key => &$item){
            // CustomFunctions::debugLog($item);
            if($item['type'] == Parameters::getCategoryName($categories, $indexCategory)){
                array_push($currentListItemTEMP, ['key'=>$key, 'item'=>$item]);
            }
        }
        $moveChoice = inputsNavigate($categories, $currentListItemTEMP);

        // Draw & write before action
        drawRefreshInterfaceList($currentListItemTEMP, $currentIndexItemTEMP);
        drawCategoryBag(Parameters::getAllCategoriesItem(), $indexCategory);
        Display_Game::messageBoiteDialogue(Parameters::getMessageBoiteDialogue('use','Which item do you want to buy?'));
        drawMoney(null, $save['Money']);

        // Action
        $move = waitForInput(Parameters::getPosChoice(),$moveChoice);
        if($move == leaveInputMenu()){
            return leaveInputMenu();
        }
        // Validation item
        elseif($move == 'v'){
            while(true){
                Display_Game::messageBoiteDialogue('How many '.$currentListItemTEMP[$currentIndexItemTEMP]['item']['name'].' do you want?');
                $quantity = waitForInput(Parameters::getPosChoice(), '', ' Quantity? ');
                if(!is_numeric($quantity)){
                    Display_Game::messageBoiteDialogue('Please insert a number.',-1);
                    continue;
                }elseif($quantity == 0 || $quantity == null){
                    Display_Game::messageBoiteDialogue('Cancel purchase',-1);
                    break;
                }
                else{
                    break;
                }
            }
            if(buyItem($save, $currentListItemTEMP[$currentIndexItemTEMP]['item'], $quantity)){
                giveItemByItem($save['Bag'], $currentListItemTEMP[$currentIndexItemTEMP]['item'], $quantity);
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

function buyItem(&$save, $itemToBuy, $quantity = 1){
    $money = &$save['Money'];
    if($money < $itemToBuy['price']*$quantity){
        Display_Game::messageBoiteDialogue("You don't have enough money for ".$itemToBuy['name'].' x '.$quantity.'.');
        waitForInput();
        return false;
    }
    $money -= $itemToBuy['price'] * $quantity;
    Display_Game::messageBoiteDialogue('You bought '.$itemToBuy['name'].' x '.$quantity.'.',1);
    return true;
}

function listItemsBuyableInShop($indexFloor){
    $items = [];
    $allItems = getSave('Resources/items.json');
    foreach($allItems as $item){
        if($item['indexFloor'] <= $indexFloor){
            array_push($items, $item);
        }
    }
    return $items;
}
?>