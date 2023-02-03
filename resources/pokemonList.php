<?php 
include 'resources/capacites.php';
$pokemonPokedex = [
    '1' => [
        'Name'=> 'Bulbazaur',
        'N Pokedex' => '1',
        'Type 1' => 'grass',
        'Type 2' => 'poison',
        'StatsBase' => [
            'Health' => 45,
            'Atk' => 49,
            'Def' => 49,
            'Atk Spe' => 65,
            'Def Spe' => 65,
            'Vit' => 45,
        ],
        'Sprite' => 'Zone'
    ],
    '19' => [
        'Name'=> 'Rattata',
        'N Pokedex' => '19',
        'Type 1' => 'normal',
        'Type 2' => '',
        'StatsBase' => [
            'Health' => 30,
            'Atk' => 56,
            'Def' => 35,
            'Atk Spe' => 25,
            'Def Spe' => 35,
            'Vit' => 72,
        ],
        'Sprite' => 'Rattata'
    ],
    '20' => [
        'Name'=> 'Rattatac',
        'N Pokedex' => '20',
        'Type 1' => 'normal',
        'Type 2' => '',
        'StatsBase' => [
            'Health' => 55,
            'Atk' => 81,
            'Def' => 60,
            'Atk Spe' => 50,
            'Def Spe' => 70,
            'Vit' => 97,
        ],
        'Sprite' => 'Rattatac'
    ],
    '25' => [
        'Name'=> 'Pikachu',
        'N Pokedex' => '25',
        'Type 1' => 'electric',
        'Type 2' => '',
        'StatsBase' => [
            'Health' => 45,
            'Atk' => 49,
            'Def' => 49,
            'Atk Spe' => 65,
            'Def Spe' => 65,
            'Vit' => 150,
        ],
        'Sprite' => 'Pikachu'
    ]
];
$pokemons = [
    '1' => [
        'Name'=> 'Pikachu',
        'Level' => 100,
        'N Pokedex' => '025',
        'Type 1' => 'electric',
        'Type 2' => '',
        'exp' => 0,
        'Health Max' => 247,
        'Health' => 247,
        'Atk' => 330,
        'Defense' => 5,
        'Vit' => 100,
        'Sprite' => 'Pikachu'
    ],
    '2' => [
        'Name'=> 'Rattata',
        'Level' => 100,
        'N Pokedex' => '019',
        'Type 1' => 'normal',
        'Type 2' => '',
        'exp' => 0,
        'Health Max' => 300,
        'Health' => 300,
        'Atk' => 110,
        'Defense' => 5,
        'Vit' => 13,
        'Sprite' => 'Rattata'
    ],
    '3' => [
        'Name'=> 'Rattatac',
        'Level' => 100,
        'N Pokedex' => '020',
        'Type 1' => 'normal',
        'Type 2' => '',
        'exp' => 0,
        'Health Max' => 300,
        'Health' => 300,
        'Atk' => 11,
        'Defense' => 5,
        'Vit' => 8,
        'Sprite' => 'Rattata'
    ]
];

// function getPokedex(){
//     global $pokemonPokedex;
//     return $pokemonPokedex;
// }

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
        'Type 1' => $pkmn['Type 1'],
        'Type 2' => $pkmn['Type 2'],
        // 'StatsBase' => [
        //     'Health' => $pkmn['StatsBase']['Health'],
        //     'Atk' => $pkmn['StatsBase']['Atk'],
        //     'Def' => $pkmn['StatsBase']['Def'],
        //     'Atk Spe' => $pkmn['StatsBase']['Atk Spe'],
        //     'Def Spe' => $pkmn['StatsBase']['Def Spe'],
        //     'Vit' => $pkmn['StatsBase']['Vit'],
        // ],
        'Stats' => [
            'Health' => calculateHealth($pkmn['StatsBase']['Health'],$level),
            'Health Max' => calculateHealth($pkmn['StatsBase']['Health'],$level),
            'Atk' => calculateStats($pkmn['StatsBase']['Atk'], $level),
            'Def' => calculateStats($pkmn['StatsBase']['Def'], $level),
            'Atk Spe' => calculateStats($pkmn['StatsBase']['Atk Spe'], $level),
            'Def Spe' => calculateStats($pkmn['StatsBase']['Def Spe'], $level),
            'Vit' => calculateStats($pkmn['StatsBase']['Vit'], $level),
        ],
        'Capacites' => [
            '0' => getCapacite('Tackle'),
            '1' => getCapacite('Scratch'),
            '2' => getCapacite('HyperBeam'),
            '3' => getCapacite('bite'),
        ],
        'Sprite' => $pkmn['Sprite']
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

function getNextLevelExp($currentLevel) {
    $result = pow(2, $currentLevel / 7) * 50;
    return intval($result);
}
?>