<?php
//// FIND ROUTES AND GET ENCOUNTER ////////////////////////////////////////////////////////////////////////////

function getRouteFromIndex($indexFloor, $onlyName = false) {
    global $routes;
    foreach ($routes as $route => $details) {
        $floors = $details['Floors'];
        if ($indexFloor >= $floors[0] && $indexFloor <= $floors[1]) {
            return $onlyName ? $route : $details;
        }
    }
    return null; // Retourne null si aucun correspondance n'est trouvée
}

function generateEncounter($floorData, $chance) {
    $floorMin = $floorData['Floors'][0];
    $floorMax = $floorData['Floors'][1];

    $indexFloor = rand($floorMin, $floorMax);

    if ($indexFloor >= $floorMin && $indexFloor <= $floorMax) {
        if(isset($floorData['Trainers']) && checkAllTrainersAvailable($floorData['Trainers'])){
            $encounterType = (rand(1, 100) <= $chance) ? 'Pokemon savages' : 'Trainers';
        }
        else{
            $encounterType = 'Pokemon savages';
        }

        if ($encounterType == 'Pokemon savages') {
            $pokemonData = $floorData[$encounterType];
            $totalRate = 0;
            foreach ($pokemonData as $pokemonName => $pokemonInfo) {
                $totalRate += $pokemonInfo['rate'];
            }

            $randomNumber = rand(1, $totalRate);
            $currentRate = 0;

            foreach ($pokemonData as $pokemonName => $pokemonInfo) {
                $currentRate += $pokemonInfo['rate'];
                if ($randomNumber <= $currentRate) {
                    return [$pokemonName, $pokemonInfo['level']];
                }
            }
        } else if ($encounterType == 'Trainers') {
            $trainersData = $floorData[$encounterType];
            $trainerIndex = 0;

            while (isset($trainersData[$trainerIndex])) {
                if (!isset($trainersData[$trainerIndex]['used']) || $trainersData[$trainerIndex]['used'] == false) {
                    $trainersData[$trainerIndex]['used'] = true;
                    print($trainersData[$trainerIndex]['used']);
                    return $trainerIndex;
                }
                $trainerIndex++;
            }
        }
    }

    return null;
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
        'Trainers' => [
            createTrainer('Bug Catcher', 
                'trainer',
                [
                    'entrance' => "There is so many bugs here! This is my paradise!",
                    'end' => [
                        "I'm gonna catch more to defeat you next time!"
                    ]
                ],
                500,
                [],
                generatePkmnBattle('weedle', 6),
                generatePkmnBattle('metapod', 6),
                generatePkmnBattle('caterpie', 6),
                generatePkmnBattle('kakuna', 6)
            ),
            createTrainer('Bug Catcher', 
                'trainer',
                [
                    'entrance' => "There is Pikachu into this forest. Did you see one?",
                    'end' => [
                        "I'm gonna catch more to defeat you next time!"
                    ]
                ],
                500,
                [],
                generatePkmnBattle('pidgeot', 8),
                generatePkmnBattle('pikachu', 8),
                generatePkmnBattle('caterpie', 6)
            )
        ]
    ],
    "Cave" => [
        'Floors' => [16,19],
        'Pokemon savages' => [
            'geodude' => [
                'level' => [10,12],
                'rate' => 55
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
            'dugtrio' => [
                'level' => [25,28],
                'rate' => 5
            ],
            'meowth' => [
                'level' => [18,22],
                'rate' => 40
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
        ],
        'Trainers' => null
    ],
    "route 7" => [
        'Floors' => [61,69],
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
            'farfetch-d' => [
                'level' => [35,45],
                'rate' => 5
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
            'rattata' => [
                'level' => [2,4],
                'rate' => 45
            ],
            'pidgey' => [
                'level' => [2,5],
                'rate' => 55
            ]
            ],
            'Trainers' => null
    ],
    "route 10" => [
        'Floors' => [91,99],
        'Pokemon savages' => [
            'rattata' => [
                'level' => [2,4],
                'rate' => 45
            ],
            'pidgey' => [
                'level' => [2,5],
                'rate' => 55
            ]
            ],
            'Trainers' => null
    ],
    "route 11" => [
        'Floors' => [101,109],
        'Pokemon savages' => [
            'rattata' => [
                'level' => [2,4],
                'rate' => 45
            ],
            'pidgey' => [
                'level' => [2,5],
                'rate' => 55
            ]
            ],
            'Trainers' => null
    ],
    // "route 12" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 13" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 14" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 15" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 16" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 17" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 18" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 19" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 20" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 21" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 22" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 23" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 24" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    // "route 25" => [
    //     'Floors' => [1,5],
    //     'Pokemon savages' => [
    //         'rattata' => [
    //             'level' => [2,4],
    //             'rate' => 45
    //         ],
    //         'pidgey' => [
    //             'level' => [2,5],
    //             'rate' => 55
    //         ]
    //         ],
    //         'Trainers' => null
    // ],
    
]
?>