<?php

function managerShop(&$save){
    $indexCategory = 0;
    $currentIndexItemTEMP = 0;
    $listIemsShop = getSave('Resources/items.json'); // TEMP
    $listIemsShop = listItemsBuyableInShop($save['IndexFloor']);
    while(true){
        clearGameScreen();

        $categories = getAllCategoriesItem();

        // Create list depends on category selected
        $currentListItemTEMP = [];
        foreach($listIemsShop as $key => &$item){
            // debugLog($item);
            if($item['type'] == getCategoryName($categories, $indexCategory)){
                array_push($currentListItemTEMP, ['key'=>$key, 'item'=>$item]);
            }
        }
        $moveChoice = inputsNavigate($categories, $currentListItemTEMP);

        // Draw & write before action
        drawRefreshInterfaceList($currentListItemTEMP, $currentIndexItemTEMP);
        drawCategoryBag(getAllCategoriesItem(), $indexCategory);
        messageBoiteDialogue("Which item do you want to buy?\n   z   \n<q   d> Use=v\n   s");
        drawMoney(null, $save['Money']);

        // Action
        $move = waitForInput(getPosChoice(),$moveChoice);
        if($move == leaveInputMenu()){
            return leaveInputMenu();
        }
        // Validation item
        elseif($move == 'v'){
            while(true){
                messageBoiteDialogue('How many '.$currentListItemTEMP[$currentIndexItemTEMP]['key'].' do you want?');
                $quantity = waitForInput(getPosChoice(), '', 'quantity? ');
                if(!is_numeric($quantity)){
                    messageBoiteDialogue('Please insert a number.',-1);
                    continue;
                }elseif($quantity == 0 || $quantity == null){
                    messageBoiteDialogue('Cancel purchase',-1);
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
        messageBoiteDialogue("You don't have enough money for ".$itemToBuy['name'].' x '.$quantity.'.');
        waitForInput();
        return false;
    }
    $money -= $itemToBuy['price'] * $quantity;
    messageBoiteDialogue('You bought '.$itemToBuy['name'].' x '.$quantity.'.',1);
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

//// OLD
// function drawShop($items){
//     drawMoney();
//     $i = 0;
//     $y = 0;
//     $choice = [];
//     foreach($items as $key => $item){
//         $key = $y;
//         $name = '';
//         if(isset($item['name'])){
//             $name = $item['name'];
//         }
//         else{
//             $name = $key;
//         }
//         textArea($y . '. '.$name . ' : ' . $item['price'], [4+$i,5]);

//         $choice[$y] = $item;
//         $i += 2;
//         $y++;
//     }
//     return $choice;
// }

// function listItemsBuyable($items, $currentMoney){
//     $list = drawShop($items);
//     $choice = [leaveInputMenu()];
//     for($i=1;$i<count($list)+1;++$i){
//         if($currentMoney >= $list[$i-1]['price']){
//             $choice[$i] = $i-1;
//         }
//     }
//     return [$list, $choice];
// }
?>