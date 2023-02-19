<?php 
include 'resources/capacites.php';

$json = file_get_contents('json/pokemonsv1.json');
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
    // print_r($pokemonPokedex[$keys[$index]]);
    // sleep(10);
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

function generatePkmnBattle($index, $level, $exp = 0){
    $pkmn = getPokemon($index);
    $ivs = [
        'Health' => rand(1,31),
        'Atk' => rand(1,31),
        'Def' => rand(1,31),
        'Atk Spe' => rand(1,31),
        'Def Spe' => rand(1,31),
        'Vit' => rand(1,31),
    ];
    $pokemonBattle = [
        'Name'=> $pkmn['Name'],
        'N Pokedex' => $pkmn['N Pokedex'],
        'Level' => $level,
        'exp' => $exp,
        'expToLevel' => getNextLevelExp($level),
        'exp base' => 64,
        'Type 1' => $pkmn['Type 1'],
        'Type 2' => $pkmn['Type 2'],
        'StatsBase' => [
            'Health' => $pkmn['StatsBase']['Health'],
            'Atk' => $pkmn['StatsBase']['Atk'],
            'Def' => $pkmn['StatsBase']['Def'],
            'Atk Spe' => $pkmn['StatsBase']['Atk Spe'],
            'Def Spe' => $pkmn['StatsBase']['Def Spe'],
            'Vit' => $pkmn['StatsBase']['Vit'],
        ],
        'ivs' => $ivs,
        'evs' =>[
            'Health' => 0,
            'Atk' => 0,
            'Def' => 0,
            'Atk Spe' => 0,
            'Def Spe' => 0,
            'Vit' => 0,
        ],
        'Stats' => [
            'Health' => calculateHealth($pkmn['StatsBase']['Health'],$level, $ivs['Health']),
            'Health Max' => calculateHealth($pkmn['StatsBase']['Health'],$level, $ivs['Health']),
            'Atk' => calculateStats($pkmn['StatsBase']['Atk'], $level, $ivs['Atk']),
            'Def' => calculateStats($pkmn['StatsBase']['Def'], $level, $ivs['Def']),
            'Atk Spe' => calculateStats($pkmn['StatsBase']['Atk Spe'], $level, $ivs['Atk Spe']),
            'Def Spe' => calculateStats($pkmn['StatsBase']['Def Spe'], $level, $ivs['Def Spe']),
            'Vit' => calculateStats($pkmn['StatsBase']['Vit'], $level, $ivs['Vit']),
        ],
        'Stats Temp' => [
            'Atk' => 0,
            'Def' => 0,
            'Atk Spe' => 0,
            'Def Spe' => 0,
            'Vit' => 0,
            'protected' => false,
            'Substitute' => [
                'Health Max' => 3,
                'Health' => 0,
                'Used' => false
            ]
        ],
        'Capacites' => [
            '0' => getCapacite('mega-drain'),
            '1' => getRandCapacites(),
            '2' => getCapacite('hyper-beam'),
            '3' => getRandCapacites()
        ],
        'Sprite' => $pkmn['Sprite'],
        'Status' => ''
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
function levelUp(&$pkmn, $expLeft){
    messageBoiteDialogue($pkmn['Name'].' level up!');
    sleep(1);
    $pkmn['Level']++;
    $pkmn['expToLevel'] = getNextLevelExp($pkmn['Level']);
    $pkmn['exp'] = 0;

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
    
    // print_r($pkmn['ivs']);
    // sleep(5);
    getExp($pkmn, $expLeft);
}

function getExp(&$pkmn, $exp){
    $pkmn['exp'] += $exp;
    messageBoiteDialogue($pkmn['Name'].' obtained '.$exp.'!');
    sleep(1);
    if($pkmn['exp'] >= $pkmn['expToLevel']){
        $expLeft = $pkmn['exp'] - $pkmn['expToLevel'];
        levelUp($pkmn, $expLeft);
    }
}

function getNextLevelExp($currentLevel) {
    $expToNextLevel = (int)((4 * $currentLevel * $currentLevel * $currentLevel) / 5);
    // $result = pow(2, $currentLevel / 7) * 50;
    return intval($expToNextLevel);
}

function expToGive($pkmnAtk, $pkmnDef){
    $exp = ((1.5 * $pkmnDef['Level'] + 10) * $pkmnDef['exp base'] * $pkmnAtk['Level']) / (($pkmnDef['Level'] + $pkmnAtk['Level'] + 10) * 5);
    return intval($exp)* 20;
}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function healthInBloc(&$pkmn){
    if($pkmn['Stats']['Health'] > $pkmn['Stats']['Health Max']){
        $pkmn['Stats']['Health'] = $pkmn['Stats']['Health Max'];
    }
    else if($pkmn['Stats']['Health'] < 0){
        $pkmn['Stats']['Health'] = 0;
    }
}
?>