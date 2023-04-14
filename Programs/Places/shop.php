<?php

function managerShop(&$save){
    while(true){
        clearGameScreen();
        drawBoiteDialogue();

        $itemsAvailable = listItemsBuyable($save['Money']);
        messageBoiteDialogueContinue('Which item do you want to buy?');
        $choice = waitForInput([31,0], $itemsAvailable[1]);
        if($choice == 'c'){
            messageBoiteDialogueContinue('Are you sure to leave the shop? ');
            $choice2 = waitForInput([31,0], ['y','n']);
            if($choice2 == 'y'){
                break;
            }
            else{
                continue;
            }
        }
        $quantity = waitForInput([31,0], '', 'quantity? ');
        buyItem($save, $itemsAvailable[0][$choice], $quantity);
        giveItemByItem($save['Bag'], $itemsAvailable[0][$choice]);
    }
}
function drawShop($items){
    drawMoney();
    $i = 0;
    $y = 0;
    $choice = [];
    foreach($items as $key => $item){
        moveCursor([4+$i,5]);
        $key = $y;
        $name = '';
        if(isset($item['name'])){
            $name = $item['name'];
        }
        else{
            $name = $key;
        }
        echo $y . '. '.$name . ' : ' . $item['price'];
        $choice[$y] = $item;
        $i += 2;
        $y++;
    }
    return $choice;
}

function listItemsBuyable($currentMoney){
    $file = file_get_contents('Resources/items.json');
    $array = json_decode($file, true);
    $list = drawShop($array);
    $choice = ['c'];
    for($i=1;$i<count($list)+1;++$i){
        if($currentMoney >= $list[$i-1]['price']){
            $choice[$i] = $i-1;
        }
    }
    return [$list, $choice];
}

function buyItem(&$save, $itemToBuy, $quantity = 1){
    $money = &$save['Money'];
    if($money < $itemToBuy['price']*$quantity){
        messageBoiteDialogue("You can't buy ".$itemToBuy['name'].' x '.$quantity.' times.');
        return;
    }
    $money -= $itemToBuy['price'] * $quantity;
    messageBoiteDialogue('You bought '.$itemToBuy['name'].' x '.$quantity.'.');
}
?>