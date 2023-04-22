<?php 
include 'Resources/Capacites/capacites.php';

$json = file_get_contents('Resources/Pokemons/pokemonsv2.json');
$pokemonPokedex = json_decode($json, true);


//// GET POKEMONS ///////////////////////////////////
/////////////////////////////////////////////////////
function getPokemon($pkmn){
    if(is_numeric($pkmn)){
        return getPokemonByIndex($pkmn);
    }
    elseif(is_string($pkmn)){
        return getPkmnFromPokedex($pkmn);
    }
}

function getPkmnFromPokedex($name){
    global $pokemonPokedex;
    return $pokemonPokedex[$name];
}

function getPokemonByIndex($index = 1){
    global $pokemonPokedex;
    $keys = ["ignore this value"];
    $keys = array_merge($keys, array_keys($pokemonPokedex));
    if(isset($pokemonPokedex[$keys[$index]])){
        return $pokemonPokedex[$keys[$index]];
    }
    else{
        return $pokemonPokedex[$keys[1]];
    }
}

function getPokemonByName($name){
    global $pokemonPokedex;

    if(isset($pokemonPokedex[$name])){
        return $pokemonPokedex[$name];
    }
    else{
        return $pokemonPokedex['bulbasaur'];
    }
}
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////

function generatePkmnBattle($index, $level, $exp = 0, $capacites = []){
    $pkmn = getPokemon($index);
    if(is_null($pkmn)){
        print_r($pkmn);
        sleep(5);
    }
    $newCapacites = [];
    if(count($capacites) > 0){
        foreach($capacites as $capacite){
            array_push($newCapacites, getCapacite($capacite));
        }
    }
    else{
        $capacitesCanLearn = $pkmn['capacites'];
        $capTemp = getLastFourElements($capacitesCanLearn, $level, $level);
        foreach($capTemp as $capacite){
            array_push($newCapacites, getCapacite($capacite['name']));
        }
    }

    $ivs = [
        'Health' => rand(1,31),
        'Atk' => rand(1,31),
        'Def' => rand(1,31),
        'Atk Spe' => rand(1,31),
        'Def Spe' => rand(1,31),
        'Vit' => rand(1,31),
    ];
    $pokemonBattle = $pkmn;
    unset($pokemonBattle['capacites']);
    $pokemonBattle['Level'] = $level;
    $pokemonBattle['exp'] = $exp;
    $pokemonBattle['expToLevel'] = getNextLevelExp($level);
    $pokemonBattle['Stats'] = [
        'Health' => calculateHealth($pkmn['StatsBase']['Health'],$level, $ivs['Health']),
        'Health Max' => calculateHealth($pkmn['StatsBase']['Health'],$level, $ivs['Health']),//error 
        'Atk' => calculateStats($pkmn['StatsBase']['Atk'], $level, $ivs['Atk']),
        'Def' => calculateStats($pkmn['StatsBase']['Def'], $level, $ivs['Def']),
        'Atk Spe' => calculateStats($pkmn['StatsBase']['Atk Spe'], $level, $ivs['Atk Spe']),
        'Def Spe' => calculateStats($pkmn['StatsBase']['Def Spe'], $level, $ivs['Def Spe']),
        'Vit' => calculateStats($pkmn['StatsBase']['Vit'], $level, $ivs['Vit']),
    ];
    $pokemonBattle['ivs'] = $ivs;
    $pokemonBattle['evs'] = [
        'Health' => 0,
        'Atk' => 0,
        'Def' => 0,
        'Atk Spe' => 0,
        'Def Spe' => 0,
        'Vit' => 0,
    ];
    $pokemonBattle['Stats Temp'] = [
        'Atk' => 0,
        'Def' => 0,
        'Atk Spe' => 0,
        'Def Spe' => 0,
        'Vit' => 0,
        'evasion' => 10,
        'critical' => 0,
        'Accuracy' => 0,
        'protected' => false,
        'Substitute' => [
            'Health Max' => 3,
            'Health' => 0,
            'Used' => false
        ]
    ];
    $pokemonBattle['Capacites'] = $newCapacites;
    $pokemonBattle['Status'] = '';
    $pokemonBattle['evolution'] = [
        'Name' => is_array($pkmn['evolution']['after']) ? $pkmn['evolution']['after']['Name'] : null,
        'Level' => is_array($pkmn['evolution']['after']) ? $pkmn['evolution']['after']['min level'] : null
    ];

    return $pokemonBattle;
}
function calculateHealth($statBase, $level, $iv, $ev = 0){
    $result = ((2 * ($statBase + $iv) * $level)/100)+$level+10;
    return intval($result);
}

function calculateStats($statBase, $level, $iv, $ev = 0){
    $result = ((2 * ($statBase + $iv) * $level)/100+5);
    return intval($result);
}


//// EXPERIENCE FCTS ////////////////////////////////////////////////////////////////////
function levelUp(&$pkmn, $expLeft, $inThisFct = false, $notFirstPkmn = true){
    $pkmn['Level']++;
    if($pkmn['Level'] >= 100){
        $pkmn['Level'] = 100;
        $pkmn['expToLevel'] = 1;
        $pkmn['exp'] = 1;
        return;
    }
    $pkmn['expToLevel'] = getNextLevelExp($pkmn['Level']);
    $pkmn['exp'] = 0;

    messageBoiteDialogue($pkmn['Name'].' levels up to '.$pkmn['Level'].'!');
    sleep(1);

    $newStats = [];
    $oldStats= [];
    foreach($pkmn['Stats'] as $key =>&$stat){
        if($key == 'Health'){
            continue;
        }
        if($key != 'Health Max'){
            $oldStats[$key] = $pkmn['Stats'][$key];
        }
        if($key == 'Health Max'){
            $oldStats['Health'] = $pkmn['Stats'][$key];
            $newStats['Health'] = calculateHealth($pkmn['StatsBase']['Health'],$pkmn['Level'], $pkmn['ivs']['Health']);
            $stat = $newStats['Health'];
            $pkmn['Stats']['Health'] += $newStats['Health']-$oldStats['Health'];
        }
        else{
            $newStats[$key] = calculateStats($pkmn['StatsBase'][$key],$pkmn['Level'], $pkmn['ivs'][$key]);
            $stat = $newStats[$key];
        }
    }
    levelUpWindow($oldStats, $newStats);
    checkThingsToDoLevelUp($pkmn);
    getExp($pkmn, $expLeft, true, $notFirstPkmn);
}

function getExp(&$pkmn, $exp, $inThisFct = false, $notFirstPkmn = true){
    if($pkmn['Level'] >= 100){
        return;
    }

    $pkmn['exp'] += $exp;
    if(!$inThisFct && $notFirstPkmn){
        messageBoiteDialogue($pkmn['Name'].' gets '.$exp.' exp!');
    }

    sleep(1);
    if($pkmn['exp'] >= $pkmn['expToLevel']){
        $expLeft = $pkmn['exp'] - $pkmn['expToLevel'];
        levelUp($pkmn, $expLeft, $inThisFct, $notFirstPkmn);
    }
}

function getNextLevelExp($currentLevel) {
    $expToNextLevel = (int)((4 * $currentLevel * $currentLevel * $currentLevel) / 5);
    return intval($expToNextLevel);
}

function expToGive($pkmnAtk, $pkmnDef){
    $exp = ((1.5 * $pkmnDef['Level'] + 10) * $pkmnDef['base experience'] * $pkmnAtk['Level']) / (($pkmnDef['Level'] + $pkmnAtk['Level'] + 10) * 5);
    return intval($exp);
}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function fullHealTeam(&$teamPkmn){
    foreach($teamPkmn as &$pkmn){
        $pkmn['Stats']['Health'] = $pkmn['Stats']['Health Max'];
        $pkmn['Status'] = '';
    }
}

function healthInBloc(&$pkmn){
    if($pkmn['Stats']['Health'] > $pkmn['Stats']['Health Max']){
        $pkmn['Stats']['Health'] = $pkmn['Stats']['Health Max'];
    }
    else if($pkmn['Stats']['Health'] < 0){
        $pkmn['Stats']['Health'] = 0;
    }
}

function isPkmnDead_simple(&$pkmn){
    if($pkmn['Stats']['Health'] <= 0){
        return true;
    }
    else{
        return false;
    }
}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function resetTeamStatsTemp(&$pkmnTeam){
    foreach($pkmnTeam as $pkmn){
        resetStatsTemp($pkmn);
    }
}

function resetStatsTemp(&$pkmn){
    foreach($pkmn['Stats Temp'] as $statTemp){
        if(is_numeric($statTemp)){
            $statTemp = 0;
        }
        else if(is_bool($statTemp)){
            $statTemp = false;
        }
        else if($statTemp == 'Substitute'){
            foreach($statTemp as $stats){
                $stats['Health Max'] =  3;
                $stats['Health'] = 0;
                $stats['Used'] = false;
            }
        }
    }
}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function checkThingsToDoLevelUp(&$pkmn){
    $pkmnCapaList = getPokemon($pkmn['Name'])['capacites'];
    $newCapa = getLastElements($pkmnCapaList, $pkmn['Level']);
    
    if(!is_null($newCapa)){
        setCapacityToPkmn($pkmn, getCapacite($newCapa['name']));
    }
    if(isset($pkmn['evolution']['Name']) && $pkmn['Level'] >= $pkmn['evolution']['Level']){
        evolution($pkmn);
    }
}

function evolution(&$pkmn){
    clearGameScreen();
    drawBoiteDialogue();
    messageBoiteDialogue($pkmn['Name'] .' evolves into '. $pkmn['evolution']['Name']);
    $pkmnEvol = getPokemon($pkmn['evolution']['Name']);

    drawSprite(getSprites(getSprites('Sprite')), [5,16]);
    sleep(1);
    clearSprite([5,16]);
    sleep(1);
    drawSprite(getSprites($pkmnEvol['Sprite']), [5,16]);
    setStatsToEvol($pkmn, $pkmnEvol);
    sleep(1);
    messageBoiteDialogue('Tadadaa...');
}

function setStatsToEvol(&$pkmn, $pkmnToEvolve){
    foreach($pkmnToEvolve as $key=>$stat){
        if($key == 'evolution'){ // JAI ECHOUE
            $pkmn[$key] = [
                'Name' => is_array($pkmnToEvolve['evolution']['after']) ? $pkmnToEvolve['evolution']['after']['Name'] : null,
                'Level' => is_array($pkmnToEvolve['evolution']['after']) ? $pkmnToEvolve['evolution']['after']['min level'] : null
            ];
        }
        else{
            $pkmn[$key] = $stat;
        }
    }
    $pkmn['expToLevel'] = getNextLevelExp($pkmn['Level']);

    $newStats = [];
    $oldStats= [];
    foreach($pkmn['Stats'] as $key =>&$stat){
        if($key == 'Health'){
            continue;
        }
        if($key != 'Health Max'){
            $oldStats[$key] = $pkmn['Stats'][$key];
        }
        if($key == 'Health Max'){
            $oldStats['Health'] = $pkmn['Stats'][$key];
            $newStats['Health'] = calculateHealth($pkmn['StatsBase']['Health'],$pkmn['Level'], $pkmn['ivs']['Health']);
            $stat = $newStats['Health'];
            $pkmn['Stats']['Health'] += $newStats['Health']-$oldStats['Health'];
        }
        else{
            $newStats[$key] = calculateStats($pkmn['StatsBase'][$key],$pkmn['Level'], $pkmn['ivs'][$key]);
            $stat = $newStats[$key];
        }
    }
    // charmeleon evole into charmeleon
}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function getPokemonFromCapture(&$pkmnTeam, $pkmn){
    if(count($pkmnTeam)>=6){
        // too much pokemon, fired one
        while(true){
            $choice = selectPkmn($pkmnTeam, 0, true);
            textAreaLimited('Are you sure to leave '.$pkmnTeam[$choice]['Name'].'? ');
            $choice2 = sureToLeave();
            if($choice2){
                $pkmnTeam[$choice] = $pkmn;
                break;
            }
            else{
                continue;
            }
        }
    }
    else{
        array_push($pkmnTeam, $pkmn);
    }
}

?>