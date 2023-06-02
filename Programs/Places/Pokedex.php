<?php
function addPkmnToPokedex($pkmn, $type){
    $main = getSave(getSavePath('myGame'));
    if(!array_key_exists($pkmn['N Pokedex'], $main['Pokedex'])){ // SEE
        $main['Pokedex'][$pkmn['N Pokedex']] = getTypePkmnToPokedex($type);
    }
    else{
        if($main['Pokedex'][$pkmn['N Pokedex']] == 2){ // CATCH
            // debugLog($main['Pokedex'][$pkmn['N Pokedex']].' already caugth',2);
            return;
        }
        else{
            $main['Pokedex'][$pkmn['N Pokedex']] = getTypePkmnToPokedex($type);
        }
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

function getCountPokedex(){
    global $pokemonPokedex;
    // $lastKey = array_key_last($pokemonPokedex);
    return count($pokemonPokedex);
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

        $exceptionValue = $pkmnSeeAndCatch[$currentPkmnUsing['N Pokedex']] ?? null;
        $catchInfo = $exceptionValue == 2 ? 'Catch' : ($exceptionValue == 1 ? 'See' : null);

        displayPkmnLeftMenu($exceptionValue ? $currentPkmnUsing : null, $catchInfo);

        $choice = waitForInput(getPosChoice(), null, ' Select '. leaveInputMenu() .' : ');

        if(is_numeric($choice)){
            $indexPokedex = $choice <= $lastNPokdex ? $choice : $indexPokedex;
        } else {
            switch ($choice){
                case 's': $indexPokedex++; break;
                case 'z': $indexPokedex--; break;
                case 'c': return;
            }
        }

        $indexPokedex = ($indexPokedex > $lastNPokdex) ? 0 : (($indexPokedex <= 0) ? $lastNPokdex : $indexPokedex);
    }
}

function listPokedexRight($startKey, $exception = null){
    $x = 35;
    $y = 5;
    global $pokemonPokedex;

    $keys = array_keys($pokemonPokedex);
    $startIndex = array_search($startKey, $keys);

    $slice = array_slice($pokemonPokedex, $startIndex, 8, true);

    $newListPokemonToDraw = [];
    $pointerFlag = false;

    $counts = array_count_values($exception);
    drawBox([3,25],[2,$x]);

    $countS = array_key_exists('1',$counts) ? $counts['1'] : 0;
    $countC = array_key_exists('2',$counts) ? $counts['2'] : 0;
    justifyText('C:'.$countC.' S:'.($countS+$countC), 21, [3,$x+2], 'right');
    textArea('Total:'.getCountPokedex(), [3,$x+2]);

    foreach($slice as $pkmn){
        $pokedexNumber = $pkmn['N Pokedex'];
        $pokedexNumberString = sprintf("%03d", $pokedexNumber);
        $pokedexName = $pkmn['Name'];

        $exceptionValue = $exception[$pokedexNumber] ?? null;
        $pointer = (!$pointerFlag ? ' <' : '');
        $pointerFlag = true;

        if ($exceptionValue){
            $catch = $exceptionValue == 2 ? 'C ' : 'S ';
            $newListPokemonToDraw[] = $catch . $pokedexNumberString . ' : ' . $pokedexName . $pointer;
        } else {
            $newListPokemonToDraw[] = '  ' . $pokedexNumberString . ' : --------- ' . $pointer;
        }
    }
    drawBoxTextJusitfy([$y, $x], $newListPokemonToDraw);
}

?>