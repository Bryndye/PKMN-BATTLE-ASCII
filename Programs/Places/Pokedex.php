<?php
function addPkmnToPokedex($pkmn, $type){
    $main = getSave(getSavePath('myGame'));
    if(!array_key_exists($pkmn['N Pokedex'], $main['Pokedex'])){
        $main['Pokedex'][$pkmn['N Pokedex']] = getTypePkmnToPokedex($type);
    }
    ksort($main['Pokedex']);
    setData($main['Pokedex'], 'Pokedex', getSavePath('myGame'));
}

function getTypePkmnToPokedex($type){
    // type : 0, 1:see, 2:catch
    switch($type){
        default:
            return 0;
        case 'see':
            return 1;
        case 'catch':
            return 2;
    }
}

function countPkmnCatchFromPokedex(){
    $main = getSave(getSavePath('myGame'));
    $result = array_filter($main['Pokedex'], function($value) {
        return $value == 2;
    });
    return count($result);
}

function getLastNPokedex(){
    global $pokemonPokedex;
    $lastKey = array_key_last($pokemonPokedex);
    return $pokemonPokedex[$lastKey]['N Pokedex'];
}

function pokedexInterface(){
    $indexPokedex = 1;
    $lastNPokdex = getLastNPokedex();
    $pkmnSeeAndCatch = getDataFromSave('Pokedex',getSavePath('myGame'));
    while(true){
        clearGameScreen();
        messageBoiteDialogue(getMessageBoiteDialogue('count','Navigate into the Pokedex :'));
        $currentPkmnUsing = getPokemon($indexPokedex);
        listPokedexRight($currentPkmnUsing['Name'], $pkmnSeeAndCatch);
        $currentPokemon = getPokemon($indexPokedex);
        $existsInException = is_array($pkmnSeeAndCatch) && array_key_exists($currentPkmnUsing['N Pokedex'], $pkmnSeeAndCatch);
        displayPkmnLeftMenu($existsInException ? $currentPokemon : null);


        $choice = waitForInput(getPosChoice(), null, ' Select '. leaveInputMenu() .' : ');
        if($choice == 's'){
            $indexPokedex++;
        }
        elseif($choice == 'z'){
            $indexPokedex--;
        }
        elseif(is_numeric($choice)){
            $indexPokedex = $choice <= $lastNPokdex ? $choice : $indexPokedex;
        }
        elseif($choice == 'c'){
            break;
        }
        if($indexPokedex > $lastNPokdex){
            $indexPokedex = 0;
        }
        elseif($indexPokedex <= 0){
            $indexPokedex = $lastNPokdex;
        }
    }
}

function listPokedexRight($startKey, $exception = null) {
    $x = 35;
    $y = 2;
    global $pokemonPokedex;

    $keys = array_keys($pokemonPokedex);
    $startIndex = array_search($startKey, $keys);

    $slice = array_slice($pokemonPokedex, $startIndex, 10, true);
    $newListPokemonToDraw = [];
    $pointerFlag = false;

    foreach ($slice as $pkmn) {
        $pokedexNumber = $pkmn['N Pokedex'];
        $pokedexNumberString = sprintf("%03d", $pokedexNumber);
        $pokedexName = $pkmn['Name'];

        $existsInException = is_array($exception) && array_key_exists($pokedexNumber, $exception);
        $pointer = (!$pointerFlag ? ' <-' : '');
        
        if (!$existsInException) {
            $string = $pokedexNumberString . ' : -----------' . $pointer;
            $pointerFlag = true;
        } else {
            $string = $pokedexNumberString . ' : ' . $pokedexName . $pointer;
            $pointerFlag = true;
        }

        array_push($newListPokemonToDraw, $string);
    }

    drawBoxTextJusitfy([$y, $x], $newListPokemonToDraw);
}

?>