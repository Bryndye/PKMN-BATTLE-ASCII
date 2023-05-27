<?php 
include 'Programs/Helpers/capacites.php';

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
    if(is_array($pkmn['evolution']['after'])){
        if(array_key_exists('Name', $pkmn['evolution']['after'])){
            $pokemonBattle['evolution'] = [
                'Name' => $pkmn['evolution']['after']['Name'],
                'Level' => $pkmn['evolution']['after']['min level'] ?? null,
                'Item' =>  $pkmn['evolution']['after']['item'] ?? null
            ];
        }
        else{
            foreach($pkmn['evolution']['after'] as $evolPkmn){
                array_push($pokemonBattle['evolution'], [
                    'Name' => $evolPkmn['Name'],
                    'Level' => $evolPkmn['min level'] ?? null,
                    'Item' =>  $evolPkmn['item'] ?? null
                ]);
            }
        }
    }
    else{
        $pokemonBattle['evolution'] = [
            'Name' => null,
            'Level' => null,
            'Item' =>  null
        ];
    }

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

    messageBoiteDialogue($pkmn['Name'].' level up to '.$pkmn['Level'].'!');
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
    drawPkmnHUD(getPosHealthPkmn(true),$pkmn);
    verifyAddWhenEvolve($pkmn);
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
    return intval($exp) * 3;
}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
function fullHealTeam(&$teamPkmn){
    foreach($teamPkmn as &$pkmn){
        $pkmn['Stats']['Health'] = $pkmn['Stats']['Health Max'];
        $pkmn['Status'] = '';
    }
    messageBoiteDialogue('All your pokemons has been heal!');
}

function checkHealthOutRange(&$pkmn){
    if($pkmn['Stats']['Health'] > $pkmn['Stats']['Health Max']){
        $pkmn['Stats']['Health'] = $pkmn['Stats']['Health Max'];
    }
    else if($pkmn['Stats']['Health'] < 0){
        $pkmn['Stats']['Health'] = 0;
    }
}

function healPkmn($item, &$pkmn){
    if(strpos($item['effect'], '%') ){
        if(isPkmnDead_simple($pkmn)){
            $parts = explode("%", $item['effect']);
            $value = intval($parts[0]);
            $pkmn['Stats']['Health'] = intval(($value/100) * $pkmn['Stats']['Health Max']);
            messageBoiteDialogue($pkmn['Name'] . " revives!",1);
        }
        else{
            messageBoiteDialogue($pkmn['Name'] . " is already alive!",1);
        }
    }
    elseif(!isPkmnDead_simple($pkmn)){    
        $pkmn['Stats']['Health'] += $item['effect'];
        checkHealthOutRange($pkmn);
        messageBoiteDialogue("Use ". $item['name'].' on '.$pkmn['Name'] . "!",1);
        print($pkmn['Stats']['Health']);
    }
}

function healStatusToPkmn(&$pkmn){
    $pkmn['Status'] = null;
    messageBoiteDialogue($pkmn['Name'] . ' is cured of its ailment!',1);
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
///// EVOLUTION ////////////////////////////////////////////////////////////////////////

function verifyAddWhenEvolve(&$pkmn){
    $pkmnCapaList = getPokemon($pkmn['Name'])['capacites'];
    $newCapa = getLastElements($pkmnCapaList, $pkmn['Level']);
    
    if(!is_null($newCapa)){
        setCapacityToPkmn($pkmn, getCapacite($newCapa['name']));
    }
    verifyIfPkmnCanEvolve($pkmn);
}

function verifyIfPkmnCanEvolve(&$pkmn, $item = null){
    if(array_key_exists('Name',$pkmn['evolution'])){
        debugLog('ONE EVOL');
        if(!is_null($item) && isset($pkmn['evolution']['Item'])){
            if($pkmn['evolution']['Item'] == $item['name']){
                evolution($pkmn);
            }
        }
        elseif(isset($pkmn['evolution']['Name']) && $pkmn['Level'] >= $pkmn['evolution']['Level']){
            evolution($pkmn);
        }
    }
    else{
        // debugLog('plusieurs');
        foreach($pkmn['evolution']['after'] as $key=>$evolPkmn){
            // debugLog($evolPkmn);
            if(!is_null($item) && isset($evolPkmn['item'])){
                // debugLog($item );
                // debugLog($evolPkmn['item'] );
                if($evolPkmn['item'] == $item['name']){
                    evolution($pkmn, $key);
                    return;
                }
            }
            elseif(isset($evolPkmn['Name']) && $pkmn['Level'] >= $evolPkmn['Level']){
                evolution($pkmn);
            }
        }
    }
}

function evolution(&$pkmn, $indexChoiceEvol = null){
    clearGameScreen();
    drawBoiteDialogue();
    messageBoiteDialogue('What?',-1);
    messageBoiteDialogue($pkmn['Name'] .' is evolving!',-1);

    $olderName = $pkmn['Name'];
    if(!is_null($indexChoiceEvol)){
        $pkmnEvol = getPokemon($pkmn['evolution'][$indexChoiceEvol]['Name']);
        $newName = $pkmn['evolution'][$indexChoiceEvol]['Name'];
    }
    else{
        $pkmnEvol = getPokemon($pkmn['evolution']['Name']);
        $newName = $pkmn['evolution']['Name'];
    }

    drawSprite(getSprites($pkmnEvol['Sprite']), [5,16]);
    sleep(1);
    clearSprite([4,16]);
    sleep(1);
    drawSprite(getSprites($pkmnEvol['Sprite']), [5,16]);
    setStatsToEvol($pkmn, $pkmnEvol);
    sleep(1);
    messageBoiteDialogue('Tadadaa...',-1);
    messageBoiteDialogue($olderName .' evolves into '. $newName,-1);
    sleep(1);
    clearGameScreen();
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
}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function getPokemonFromCapture(&$pkmnTeam, $pkmn){
    if(count($pkmnTeam)>=6){
        // too much pokemon, fired one
        while(true){
            $choice = selectPkmn($pkmnTeam, 0, true);
            textAreaLimited('Are you sure to leave '.$pkmnTeam[$choice]['Name'].'? ');
            $choice2 = binaryChoice();
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
// Capture Rate = (( 1 + ( MaxHP × 3 - CurrentHP × 2 ) × CatchRate × BallRate × Status# ) ÷ ( MaxHP × 3 )) ÷ 256
function capturePokemon($pokeball, $pkmn) {
    // Si l'effet de la PokeBall est de 255, la capture est garantie
    if ($pokeball['effect'] == 255) {
        return true;
    }

    // Calculer le taux de capture de base
    $ballRate = $pokeball['effect'];

    // Obtenir l'effet du statut
    $statusEffect = getStatusEffect($pkmn['Status'], 'capture');

    // Variable base catch rate du pkmn : actuellement var inexistante
    $catchRate = 122;

    // Calculer le taux de capture final en prenant en compte les points de vie et l'effet de statut
    $finalCatchRate = (( 1 + ( $pkmn['Stats']['Health Max'] * 3 - $pkmn['Stats']['Health'] * 2 ) * $catchRate * $ballRate * $statusEffect ) / ( $pkmn['Stats']['Health Max'] * 3 )) / 256;

    // debugLog($finalCatchRate."\n");
    // Si le taux de capture final est supérieur à 255, la capture est garantie
    if ($finalCatchRate*100 >= 100) {
        return true;
    }

    // Sinon, générer un nombre aléatoire entre 0 et 100
    $randomNumber = mt_rand(0, 100);
    debugLog($randomNumber."\n");

    // Si le nombre aléatoire est inférieur au taux de capture final, la capture réussit
    if ($randomNumber < $finalCatchRate*100) {
        return true;
    }

    // Sinon, la capture échoue
    return false;
}


function captureItem($pokeball, $pkmn){
    animationCapture();

    $var = capturePokemon($pokeball, $pkmn);

    sleep(1);
    if($var) {
        messageBoiteDialogue('The Pokemon has been captured!',1);
        return true;
    } else {
        messageBoiteDialogue('Oh no! The Pokemon escapes the ball!',1);
        drawSpritePkmn($pkmn, false);
        return false;
    }

}
?>