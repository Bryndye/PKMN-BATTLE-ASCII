<?php

function displayBag(&$bag, &$pkmnTeam){
    clearInGame();
    displayBoiteDialogue();

    $i = 0;
    $y = 1;
    $choice = ['c'];
    foreach($bag as $key => $item){
        moveCursor([4+$i,5]);
        echo $item['name'] . ' x ' . $item['quantity'];
        $i += 2;
        $choice[$y] = $key;
        $y++;
    }
    limitSentence('Which item to use?');
    // tant que l'item utilisé n'est pas correctement utilisé sur le bon pkmn, reste dans la boucle
    //exception a 'c'
    while(true){
        $choice1 = waitForInput([31,0], $choice);
        $choicesPkmnTeam = displayPkmnTeam($pkmnTeam);
        $choice2 = selectPkmn($pkmnTeam, 0, true);
        // il faut maintenant faire agir le choix
    }
    return "$choice1 $choice2";
}

function manageBag(&$bag, &$item){
    // useItem($item);
    if($item['quantity'] <= 0){
        unset($bag,$item);
    }
}

function useItem(&$bag, &$item, &$pkmn){
    $file = file_get_contents('json/items.json');
    $array = json_decode($file, true);
    $effect = $array[$item];

    --$item['quantity'];
}
?>