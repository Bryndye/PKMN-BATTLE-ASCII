<?php 
$json = file_get_contents('../Resources/Pokemons/pokemonsv2.json');
$pokemons = json_decode($json, true);

$pokedex = [];
foreach($pokemons as $pkmn){
    $pokedex[$pkmn['Name']] = 0;
}

$routes = [
    "route 1" => [
        'Floors' => [1,9],
        'Pokemon savages' => [
            'rattata' => [
                'level' => [2,4],
                'rate' => 30
            ],
            'pidgey' => [
                'level' => [2,5],
                'rate' => 35
            ],
            'nidoran-f' => [
                'level' => [3,4],
                'rate' => 15
            ],
            'nidoran-m' => [
                'level' => [3,5],
                'rate' => 15
            ],
            'mankey' => [
                'level' => [3,5],
                'rate' => 5
            ]
        ],
        'Trainers' => null
    ],
    "route 2" => [
        'Floors' => [11,15],
        'Pokemon savages' => [
            'weedle' => [
                'level' => [7,8],
                'rate' => 30
            ],
            'caterpie' => [
                'level' => [7,8],
                'rate' => 30
            ],
            'oddish' => [
                'level' => [8,10],
                'rate' => 20
            ],
            'paras' => [
                'level' => [8,10],
                'rate' => 14
            ],
            'pikachu' => [
                'level' => [8,8],
                'rate' => 5
            ],
            'pidgeotto' => [
                'level' => [10,10],
                'rate' => 1
            ]
        ],
    ],
    "Cave" => [
        'Floors' => [16,19],
        'Pokemon savages' => [
            'geodude' => [
                'level' => [10,12],
                'rate' => 45
            ],
            'onix' => [
                'level' => [10,14],
                'rate' => 35
            ],
            'cubone' => [
                'level' => [8,13],
                'rate' => 5
            ],
            'graveler' => [
                'level' => [10,14],
                'rate' => 5
            ],
            'doduo' => [
                'level' => [10,14],
                'rate' => 15
            ],
            'zubat' => [
                'level' => [8,12],
                'rate' => 40
            ]
        ],
        'Trainers' => null
    ],
    "route 3" => [
        'Floors' => [21,29],
        'Pokemon savages' => [
            'diglett' => [
                'level' => [20,22],
                'rate' => 45
            ],
            'spearow' => [
                'level' => [18,24],
                'rate' => 40
            ],
            'doduo' => [
                'level' => [20,44],
                'rate' => 35
            ],
            'dugtrio' => [
                'level' => [25,28],
                'rate' => 5
            ],
            'meowth' => [
                'level' => [18,22],
                'rate' => 40
            ],
            'magnemite' => [
                'level' => [20,20],
                'rate' => 20
            ],
            'abra' => [
                'level' => [15,26],
                'rate' => 5
            ],
            'jigglypuff' => [
                'level' => [19,28],
                'rate' => 5
            ]
        ],
        'Trainers' => null
    ],
    "route 4" => [
        'Floors' => [31,39],
        'Pokemon savages' => [
            'sandshrew' => [
                'level' => [19,24],
                'rate' => 25
            ],
            'pidgey' => [
                'level' => [20,24],
                'rate' => 25
            ],
            'ekans' => [
                'level' => [15,20],
                'rate' => 25
            ],
            'growlithe' => [
                'level' => [20,25],
                'rate' => 10
            ],
            'vulpix' => [
                'level' => [20,25],
                'rate' => 10
            ],
            'kadabra' => [
                'level' => [20,27],
                'rate' => 5
            ],
        ],
        'Trainers' => null
    ],
    "route 5" => [
        'Floors' => [41,49],
        'Pokemon savages' => [
            'nidorino' => [
                'level' => [22,24],
                'rate' => 25
            ],
            'nidorina' => [
                'level' => [22,24],
                'rate' => 25
            ],
            'raticate' => [
                'level' => [24,26],
                'rate' => 25
            ],
            'fearow' => [
                'level' => [24,28],
                'rate' => 10
            ],
            'voltorb' => [
                'level' => [24,26],
                'rate' => 10
            ],
            'magikarp' => [
                'level' => [30,35],
                'rate' => 5
            ],
            'rhyhorn' => [
                'level' => [32,35],
                'rate' => 5
            ],
            'lickitung' => [
                'level' => [32,32],
                'rate' => 5
            ],
        ],
        'Trainers' => null
    ],
    "route 6" => [
        'Floors' => [51,59],
        'Pokemon savages' => [
            'horsea' => [
                'level' => [24,28],
                'rate' => 5
            ],
            'krabby' => [
                'level' => [25,28],
                'rate' => 25
            ],
            'slowpoke' => [
                'level' => [24,26],
                'rate' => 25
            ],
            'poliwag' => [
                'level' => [24,28],
                'rate' => 20
            ],
            'goldeen' => [
                'level' => [28,30],
                'rate' => 20
            ],
            'magikarp' => [
                'level' => [35,45],
                'rate' => 5
            ],
            'psyduck' => [
                'level' => [30,32],
                'rate' => 25
            ],
        ],
        'Trainers' => null
    ],
    "route 7" => [
        'Floors' => [61,69],
        'Pokemon savages' => [
            'drowzee' => [
                'level' => [24,28],
                'rate' => 15
            ],
            'mr-mime' => [
                'level' => [30,30],
                'rate' => 5
            ],            
            'venonat' => [
                'level' => [25,28],
                'rate' => 25
            ],
            'gloom' => [
                'level' => [24,26],
                'rate' => 25
            ],
            'tauros' => [
                'level' => [24,28],
                'rate' => 5
            ],
            'weepinbell' => [
                'level' => [28,30],
                'rate' => 20
            ],
            'farfetchd' => [
                'level' => [35,45],
                'rate' => 15
            ],
            'machop' => [
                'level' => [24,26],
                'rate' => 20
            ],
        ],
        'Trainers' => null
    ],
    "route 8" => [
        'Floors' => [71,79],
        'Pokemon savages' => [
            'drowzee' => [
                'level' => [24,28],
                'rate' => 5
            ],
            'venonat' => [
                'level' => [25,28],
                'rate' => 25
            ],
            'gloom' => [
                'level' => [24,26],
                'rate' => 25
            ],
            'bellsprout' => [
                'level' => [24,28],
                'rate' => 20
            ],
            'weepinbell' => [
                'level' => [28,30],
                'rate' => 20
            ],
            'tentacool' => [
                'level' => [28,32],
                'rate' => 25
            ],
            'ponyta' => [
                'level' => [32,36],
                'rate' => 25
            ],
            'ditto' => [
                'level' => [35,45],
                'rate' => 5
            ],
        ],
        'Trainers' => null
    ],
    "route 9" => [
        'Floors' => [81,89],
        'Pokemon savages' => [
            'onix' => [
                'level' => [38,42],
                'rate' => 30
            ],
            'machoke' => [
                'level' => [35,40],
                'rate' => 20
            ],
            'marowak' => [
                'level' => [40,44],
                'rate' => 25
            ],
            'graveler' => [
                'level' => [43,45],
                'rate' => 20
            ],
            'muk' => [
                'level' => [30,34],
                'rate' => 5
            ],
            'clefairy' => [
                'level' => [25,30],
                'rate' => 20
            ],
        ],
        'Trainers' => null
    ],
    "route 10" => [
        'Floors' => [91,99],
        'Pokemon savages' => [
            'magneton' => [
                'level' => [38,42],
                'rate' => 20
            ],
            'hypno' => [
                'level' => [35,40],
                'rate' => 10
            ],
            'dodrio' => [
                'level' => [40,44],
                'rate' => 20
            ],
            'parasect' => [
                'level' => [43,45],
                'rate' => 10
            ],
            'raichu' => [
                'level' => [30,34],
                'rate' => 10
            ],
            'arbok' => [
                'level' => [25,30],
                'rate' => 20
            ],
            'rapidash' => [
                'level' => [30,34],
                'rate' => 5
            ],
            'chansey' => [
                'level' => [25,30],
                'rate' => 5
            ],
        ],
        'Trainers' => null
    ],
    "route 11" => [
        'Floors' => [101,109],
        'Pokemon savages' => [
            'lapras' => [
                'level' => [51,54],
                'rate' => 5
            ],
            'seel' => [
                'level' => [50,54],
                'rate' => 55
            ],
            'shellder' => [
                'level' => [50,54],
                'rate' => 55
            ],
            'staryu' => [
                'level' => [50,54],
                'rate' => 55
            ],
            'seel' => [
                'level' => [50,54],
                'rate' => 55
            ],
        ],
        'Trainers' => null
    ],
    "route 12" => [
        'Floors' => [111,119],
        'Pokemon savages' => [
            'grimer' => [
                'level' => [2,4],
                'rate' => 45
            ],
            'exeggcute' => [
                'level' => [2,5],
                'rate' => 55
            ],
            'grimer' => [
                'level' => [2,4],
                'rate' => 45
            ],
        ],
        'Trainers' => null
    ],
    "route 13" => [
        'Floors' => [121,129],
        'Pokemon savages' => [
            'gastly' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'haunter' => [
                'level' => [40,40],
                'rate' => 45
            ]
        ],
        'Trainers' => null
    ],
    "route 14" => [
        'Floors' => [131,139],
        'Pokemon savages' => [
            'hitmonlee' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'hitmonchan' => [
                'level' => [40,40],
                'rate' => 45
            ],
            'kangaskhan' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'scyther' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'pinsir' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'porygon' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'omanyte' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'kabuto' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'aerodactyl' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'snorlax' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'koffing' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'electabuzz' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'magmar' => [
                'level' => [34,38],
                'rate' => 55
            ],
            'dratini' => [
                'level' => [34,38],
                'rate' => 55
            ],
        ],
        'Trainers' => null
    ],
];
foreach($routes as $route){
    foreach($route['Pokemon savages'] as $key=> $pkmn){
        // print_r($key);
        // sleep(5);
        $pokedex[$key] = $pokedex[$key]+ 1;
    } 
}   
print_r($pokedex);
sleep(5);

?>