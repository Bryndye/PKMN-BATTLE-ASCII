<?php
function managerShop(&$save){
    while(true){
        clearInGame();
        displayBoiteDialogue();
        limitSentence('Which item do you want to buy?');
        $itemsAvailable = listItemsBuyable(); // info item + price
        $choice = waitForInput([31,0], $itemsAvailable[1]);
        if($choice == 'c'){
            limitSentence('Are you sure to leave the shop? ');
            $choice2 = waitForInput([31,0], ['y','n']);
            if($choice2 == 'y'){
                break;
            }
            else{
                continue;
            }
        }
        giveItemByItem($save['Bag'], $itemsAvailable[0][$choice]);
    }
}
function displayShop($items){
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

function listItemsBuyable(){
    $file = file_get_contents('json/items.json');
    $array = json_decode($file, true);
    $list = displayShop($array);
    $choice = ['c'];
    for($i=1;$i<count($list)+1;++$i){
        $choice[$i] = $i-1;
    }
    return [$list, $choice];
}

function buyItem(&$save, $itemToBuy){
    $money = &$save['Money'];
}
?>