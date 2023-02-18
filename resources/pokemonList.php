<?php 
include 'resources/capacites.php';

$json = file_get_contents('json/pokemons.json');
$pokemonPokedex = json_decode($json, true);

function getPkmnFromPokedex($index){
    global $pokemonPokedex;
    return $pokemonPokedex[$index];
}

function getPokedex($pkmn = '1'){
    global $pokemonPokedex;
    if(isset($pokemonPokedex[$pkmn])){
        return $pokemonPokedex[$pkmn];
    }
    else{
        return $pokemonPokedex['1'];
    }
}

function generatePkmnBattle($index, $level, $exp = 0){
    $pkmn = getPkmnFromPokedex($index);
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
        'Stats' => [
            'Health' => calculateHealth($pkmn['StatsBase']['Health'],$level),
            'Health Max' => calculateHealth($pkmn['StatsBase']['Health'],$level),
            'Atk' => calculateStats($pkmn['StatsBase']['Atk'], $level),
            'Def' => calculateStats($pkmn['StatsBase']['Def'], $level),
            'Atk Spe' => calculateStats($pkmn['StatsBase']['Atk Spe'], $level),
            'Def Spe' => calculateStats($pkmn['StatsBase']['Def Spe'], $level),
            'Vit' => calculateStats($pkmn['StatsBase']['Vit'], $level),
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
function calculateHealth($stat, $level){
    // $health = ((2 * $pkmn['StatsBase']['Health']* $level)/100)+$level+10;
    $result = ((2 * $stat* $level)/100)+$level+10;
    return intval($result);
}

function calculateStats($stat, $level){
    // $stat = ((2 * $pkmn['StatsBase']['Health']* $level)/100+5);
    $result = ((2 * $stat * $level)/100+5);
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
    foreach($pkmn['StatsBase'] as $key =>&$stat){
        if($key == 'Health'){
            $newStats[$key] = calculateHealth($stat,$pkmn['Level']);
        }
        else{
            $newStats[$key] = calculateStats($stat,$pkmn['Level']);
        }
        $oldStats[$key] = $pkmn['Stats'][$key];
        $pkmn['Stats'][$key] = $newStats[$key];
    }
    levelUpWindow($oldStats, $newStats);

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
    return intval($exp) *20;
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