<?php

function createTrainer($name, $sprite, $dialogues, $reward, $bag, $team, $iaLevel=0, $title=''){
    $pnj = [
        'Name' => $name,
        'type' => 'trainer',
        'title' => $title,
        'level' => $iaLevel,
        'Sprite' => $sprite,
        'Dialogues' => [
            'entrance' => $dialogues['entrance'],
            'end' => $dialogues['end']
        ],
        'Reward' => $reward,
        'Bag' => $bag,
        'Team' => $team,
        'used' => false
    ];
    return $pnj;
}

function createWildPkmn($level, $name, $dialogues = null, $title = null){
    // prendre un pokemon dans une list par rapport indexFloor
    $pkmn = generatePkmnTeam($level, $name);
    $wildPkmn = [
        'Name' => $pkmn[0]['Name'],
        'type' => 'wild',
        'title' => $title,
        'Sprite' => $pkmn[0]['Sprite'],
        'Dialogues' => [
            'entrance' => isset($dialogues['entrance']) ? $dialogues['entrance'] : 'A wild Pokemon appears.',
            'end' => isset($dialogues['end']) ? $dialogues['end'] : ''
        ],
        'Reward' => null,
        'Bag' => [],
        'Team' => $pkmn
    ];
    return $wildPkmn;
}
//// GENERATION D'UN PNJ //////////////////////////////////
function generatePNJ($indexFloor, $level){
    $pnj = managerPNJGenerate($indexFloor, $level);
    return $pnj;
}

function managerPNJGenerate($indexFloor, $level){
    $pnj = checkPNJExist($indexFloor);

    if(!isset($pnj)){
        $route = getRouteFromIndex($indexFloor);  
        $data = generateEncounter($route, 50);
        if(is_int($data)){
            return $pnj;
        }
        else{
            return createWildPkmn(rand($data[1][0],$data[1][1]), $data[0]);
        }
    }
    return $pnj;
}

function checkPNJExist($indexFloor){
    global $pnjs;
    if(array_key_exists($indexFloor, $pnjs)){
        return $pnjs[$indexFloor];
    }
    else{
        return null;
    }
}

function checkAllTrainersAvailable($trainersData) {
    $trainerIndex = 0;
    while (isset($trainersData[$trainerIndex])) {
        if (!isset($trainersData[$trainerIndex]['used']) || $trainersData[$trainerIndex]['used'] == false) {
            return true;
        }
        $trainerIndex++;
    }
    return false; // Retourne -1 si tous les dresseurs sont déjà utilisés
}

function generatePkmnTeam($level = 1, $pkmnName = null, $count = 1){
    $pkmnTeam = [];
    $pokemonNameOrIndex = isset($pkmnName) ? $pkmnName : rand(0,151);
    for($i=0; $i<rand(1,$count); ++$i){
        array_push($pkmnTeam, generatePkmnBattle($pokemonNameOrIndex, $level));
    }
    return $pkmnTeam;
}

//// FUNCTION IA CHOICE FIGHT //////////////////////////////////////////////////////////////////////////////////////////
function iaChoice(&$pkmnTeamJ, &$pkmnTeamE){
    $choice = null;
    $currentPkmnJ = &$pkmnTeamJ[0];
    $currentPkmnE = &$pkmnTeamE[0];

    if($pkmnTeamE[0]['Stats']['Health'] <= $pkmnTeamE[0]['Stats']['Health Max'] * 0.2){
        // heal or switch
        $choice = '2 1'; // 1 par defaut mais il faut choisir 
    }
    else{
        $meilleureCapacite = "";
        $maxEfficacite = 0;
        $maxPuissance = 0;
        for($i=0; $i<count($currentPkmnE['Capacites']); ++$i){
            $puissance = $currentPkmnE['Capacites'][$i]['Power'];
            $efficacite = checkTypeMatchup($currentPkmnE['Capacites'][$i]['Type'], $currentPkmnJ['Type 1']) * 
                checkTypeMatchup($currentPkmnE['Capacites'][$i]['Type'], $currentPkmnJ['Type 2']);

            if($efficacite > $maxEfficacite || ($efficacite == $maxEfficacite && $puissance > $maxPuissance)){
                $maxEfficacite = $efficacite;
                $maxPuissance = $puissance;
                $meilleureCapacite = $i;
            }
        }
        return "1 $meilleureCapacite";
    }
    return '1 0'; // choice default
}

function iaLevel1(&$pkmnTeam){ // -> random
    $choice = [];
    foreach($pkmnTeam['Team'][0]['Capacites'] as $key=>$capacite){
        array_push($choice, $key);
    }
    debugLog($choice);
    return $choice;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function choosePkmn(&$teamPkmn){
    $pkmnIndex = null;
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            $pkmnIndex = $i;
        }
    }

    switchPkmn($teamPkmn, $pkmnIndex);
}

function selectStarterRival($stadeEvol = 0){
    $starter = getDataFromSave('Starter');
    switch($starter){
        case 1:
          $starter = 'bulbasaur';  
          break;
        case 2:
            $starter = 'squirtle';  
            break;
        case 3:
            $starter = 'charmander';  
            break;
    }

    $rivalPokemonMap = array(
        'bulbasaur' => array(
            'charmander',
            'charmeleon',
            'charizard'
        ),
        'charmander' => array(
            'squirtle',
            'wartortle',
            'blastoise'
        ),
        'squirtle' => array(
            'bulbasaur',
            'ivysaur',
            'venusaur'
        )
    );

    // Vérifier si le nom du starter est présent dans le tableau
    if (array_key_exists($starter, $rivalPokemonMap)) {
        // Retourner le nom du Pokémon rival associé au starter
        return $rivalPokemonMap[$starter][$stadeEvol];
    } else {
        // Retourner un message d'erreur si le starter n'est pas valide
        return 'Erreur : Starter invalide.';
    }
}
?>