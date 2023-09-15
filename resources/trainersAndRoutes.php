<?php
$Routes = [
    "Route 1" => [
        'Floors' => [1,9],
        'Pokemon savages' => [
            'rattata' => [
                'level' => [3,4],
                'rate' => 30
            ],
            'pidgey' => [
                'level' => [3,5],
                'rate' => 35
            ],
            'nidoran-f' => [
                'level' => [4,4],
                'rate' => 15
            ],
            'nidoran-m' => [
                'level' => [4,5],
                'rate' => 15
            ],
            'mankey' => [
                'level' => [4,5],
                'rate' => 5
            ]
        ],
        'Trainers' => [
            createTrainer('Bug Catcher', 
                'bugCatcher',
                [
                    'entrance' => "There is so many bugs here! This is my paradise!",
                    'end' => [
                        "I'm gonna catch more to defeat you next time!"
                    ]
                ],
                1000,
                [],
                [
                    generatePkmnBattle('weedle', 6),
                    generatePkmnBattle('metapod', 6),
                    generatePkmnBattle('caterpie', 6),
                    generatePkmnBattle('kakuna', 6)
                ]
            )
        ]
    ],
    "Route 2" => [
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
                'bugCatcher',
                [
                    'entrance' => "There is Pikachu into this forest. Did you see one?",
                    'end' => [
                        "I'm gonna catch more to defeat you next time!"
                    ]
                ],
                2000,
                [],
                [
                    generatePkmnBattle('pidgey', 10),
                    generatePkmnBattle('pikachu', 9),
                    generatePkmnBattle('caterpie', 11)
                ]
            )
        ]
    ],
    "Cave" => [
        'Floors' => [16,19],
        'Pokemon savages' => [
            'geodude' => [
                'level' => [13,14],
                'rate' => 45
            ],
            'onix' => [
                'level' => [13,14],
                'rate' => 35
            ],
            'cubone' => [
                'level' => [13,13],
                'rate' => 5
            ],
            'graveler' => [
                'level' => [15,16],
                'rate' => 5
            ],
            'bellsprout' => [
                'level' => [8,12],
                'rate' => 20
            ],
            'zubat' => [
                'level' => [10,12],
                'rate' => 40
            ],
            'abra' => [
                'level' => [15,17],
                'rate' => 15
            ]
        ],
        'Trainers' => [
            createTrainer('A Mountain Man', 
                'mountain',
                [
                    'entrance' => "Hello!",
                    'end' => [
                        "Bye!"
                    ]
                ],
                3000,
                [],
                [
                    generatePkmnBattle('geodude', 11),
                    generatePkmnBattle('diglett', 12),
                    generatePkmnBattle('onix', 13)
                ]
                ),
            createTrainer('A Mountain Man', 
                'mountain',
                [
                    'entrance' => "Hello!",
                    'end' => [
                        "Bye!"
                    ]
                ],
                3000,
                [],
                [
                    generatePkmnBattle('zubat', 13),
                    generatePkmnBattle('magnemite', 14)
                ]
            )
        ]
    ],
    "Route 3" => [
        'Floors' => [21,29],
        'Pokemon savages' => [
            'diglett' => [
                'level' => [16,18],
                'rate' => 30
            ],
            'spearow' => [
                'level' => [18,18],
                'rate' => 30
            ],
            'doduo' => [
                'level' => [19,19],
                'rate' => 30
            ],
            'dugtrio' => [
                'level' => [23,23],
                'rate' => 5
            ],
            'meowth' => [
                'level' => [18,20],
                'rate' => 30
            ],
            'magnemite' => [
                'level' => [20,20],
                'rate' => 20
            ],
            'abra' => [
                'level' => [15,20],
                'rate' => 15
            ],
            'jigglypuff' => [
                'level' => [18,20],
                'rate' => 5
            ]
        ],
        'Trainers' => [
            createTrainer('A Scientist', 
                'scientist',
                [
                    'entrance' => "Get away! I'm working.",
                    'end' => [
                        "Tsss! You're wasting my time."
                    ]
                ],
                4000,
                [],
                [
                    generatePkmnBattle('magnemite', 18),
                    generatePkmnBattle('magnemite', 19)
                ]
                ),
            createTrainer('A Pokemaniac', 
                'scientist',
                [
                    'entrance' => "How many Pokemon did you catch?",
                    'end' => [
                        "You are really good! Maybe you are the next Champion."
                    ]
                ],
                4000,
                [],
                [
                    generatePkmnBattle('jigglypuff', 18),
                    generatePkmnBattle('growlithe', 20),
                    generatePkmnBattle('vulpix', 20)
                ]
            )
        ]
    ],
    "Route 4" => [
        'Floors' => [31,39],
        'Pokemon savages' => [
            'sandshrew' => [
                'level' => [22,24],
                'rate' => 30
            ],
            'ekans' => [
                'level' => [22,25],
                'rate' => 30
            ],
            'growlithe' => [
                'level' => [22,25],
                'rate' => 15
            ],
            'vulpix' => [
                'level' => [22,25],
                'rate' => 15
            ],
            'kadabra' => [
                'level' => [22,27],
                'rate' => 5
            ],
            'gastly' => [
                'level' => [24,24],
                'rate' => 5
            ],
        ],
        'Trainers' => [
            createTrainer('Old man', 
                'oldman',
                [
                    'entrance' => "oh?! A battle?",
                    'end' => [
                        "Thank to you, I'm going to practice to be Champion!"
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('kadabra', 22),
                    generatePkmnBattle('haunter', 23),
                    generatePkmnBattle('spearow', 25),
                ]
            ),
            createTrainer('A fisher', 
                'fisher',
                [
                    'entrance' => "How many Pokemon did you catch?",
                    'end' => [
                        "You are really good! Maybe you are the next Champion."
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('magikarp', 30),
                    generatePkmnBattle('magikarp', 30),
                    generatePkmnBattle('magikarp', 30),
                    generatePkmnBattle('magikarp', 30),
                    generatePkmnBattle('goldeen', 26),
                    generatePkmnBattle('poliwag', 26),
                ]
            )
        ]
    ],
    "Route 5" => [
        'Floors' => [41,49],
        'Pokemon savages' => [
            'eevee' => [
                'level' => [30,34],
                'rate' => 10
            ],
            'voltorb' => [
                'level' => [30,34],
                'rate' => 10
            ],
            'gloom' => [
                'level' => [30,31],
                'rate' => 20
            ],
            'rhyhorn' => [
                'level' => [30,34],
                'rate' => 15
            ],
            'lickitung' => [
                'level' => [30,36],
                'rate' => 25
            ],
        ],
        'Trainers' => [
            createTrainer('A Boy', 
                'boy',
                [
                    'entrance' => "Do you want to be my friend?",
                    'end' => [
                        "I guess you won't..."
                    ]
                ],
                6000,
                [],
                [
                    generatePkmnBattle('onix', 30),
                    generatePkmnBattle('eevee', 32),
                    generatePkmnBattle('slowpoke', 36),
                    generatePkmnBattle('growlithe', 31),
                ]
            ),
            createTrainer('A Girl', 
                'girl',
                [
                    'entrance' => "My brother doesn't stop to ask everyone if they want to be his friend.",
                    'end' => [
                        "I guess you won't. Good for him."
                    ]
                ],
                5400,
                [],
                [
                    generatePkmnBattle('cloyster', 30),
                    generatePkmnBattle('eevee', 32),
                    generatePkmnBattle('slowpoke', 35),
                    generatePkmnBattle('vulpix', 31),
                ]
            ),
        ]
    ],
    "Route 6" => [
        'Floors' => [51,59],
        'Pokemon savages' => [
            'horsea' => [
                'level' => [34,35],
                'rate' => 5
            ],
            'krabby' => [
                'level' => [34,35],
                'rate' => 25
            ],
            'slowpoke' => [
                'level' => [34,35],
                'rate' => 25
            ],
            'poliwag' => [
                'level' => [34,38],
                'rate' => 20
            ],
            'goldeen' => [
                'level' => [34,38],
                'rate' => 20
            ],
            'magikarp' => [
                'level' => [35,36],
                'rate' => 5
            ],
            'psyduck' => [
                'level' => [34,38],
                'rate' => 25
            ],
            'snorlax' => [
                'level' => [33,35],
                'rate' => 5
            ],
        ],
        'Trainers' => [
            createTrainer('A fisher boy', 
                'boy',
                [
                    'entrance' => "Do you like fishing?",
                    'end' => [
                        "I really thought Magikarp was good..."
                    ]
                ],
                6000,
                [],
                [
                    generatePkmnBattle('magikarp', 50),
                    generatePkmnBattle('magikarp', 50),
                    generatePkmnBattle('magikarp', 50),
                    generatePkmnBattle('magikarp', 50),
                    generatePkmnBattle('magikarp', 50),
                    generatePkmnBattle('gyarados', 40),
                ]
                ),
                createTrainer('A fisher man', 
                'fisher',
                [
                    'entrance' => "Did you see my son?",
                    'end' => [
                        "If he's met you I know he's gone to see his mother in tears."
                    ]
                ],
                6000,
                [],
                [
                    generatePkmnBattle('dratini', 35),
                    generatePkmnBattle('gyarados', 40),
                    generatePkmnBattle('gyarados', 48)
                ]
            )
        ]
    ],
    "Route 7" => [
        'Floors' => [61,69],
        'Pokemon savages' => [
            'drowzee' => [
                'level' => [38,40],
                'rate' => 10
            ],
            'mr-mime' => [
                'level' => [38,40],
                'rate' => 10
            ],            
            'venonat' => [
                'level' => [35,40],
                'rate' => 20
            ],
            'tauros' => [
                'level' => [33,40],
                'rate' => 10
            ],
            'jynx' => [
                'level' => [32,38],
                'rate' => 20
            ],
            'farfetchd' => [
                'level' => [35,40],
                'rate' => 10
            ],
            'machop' => [
                'level' => [38,40],
                'rate' => 20
            ],
            'snorlax' => [
                'level' => [35,40],
                'rate' => 10
            ],
        ],
        'Trainers' => [
            createTrainer('A Biker', 
                'mountain',
                [
                    'entrance' => "What are you looking at?",
                    'end' => [
                        "Next time, you will suffer!"
                    ]
                ],
                6000,
                [],
                [
                    generatePkmnBattle('muk', 44),
                    generatePkmnBattle('weezing', 40),
                    generatePkmnBattle('haunter', 42),
                    generatePkmnBattle('nidoqueen', 41),
                ]
            ),
            createTrainer('A Biker', 
                'mountain',
                [
                    'entrance' => "What are you looking at?",
                    'end' => [
                        "Next time, you will suffer!"
                    ]
                ],
                6000,
                [],
                [
                    generatePkmnBattle('muk', 40),
                    generatePkmnBattle('weezing', 40),
                    generatePkmnBattle('gengar', 42),
                    generatePkmnBattle('nidoking', 40),
                ]
            ),
        ]
    ],
    "Route 8" => [
        'Floors' => [71,79],
        'Pokemon savages' => [
            'abra' => [
                'level' => [42,44],
                'rate' => 5
            ],
            'koffing' => [
                'level' => [46,47],
                'rate' => 25
            ],
            'weepinbell' => [
                'level' => [43,44],
                'rate' => 20
            ],
            'tentacool' => [
                'level' => [43,44],
                'rate' => 25
            ],
            'ponyta' => [
                'level' => [42,45],
                'rate' => 25
            ],
            'ditto' => [
                'level' => [45,45],
                'rate' => 5
            ],
            'lapras' => [
                'level' => [40,50],
                'rate' => 15
            ],
        ],
        'Trainers' => [
            createTrainer('A Mountain Man', 
                'mountain',
                [
                    'entrance' => "Get ready!",
                    'end' => [
                        "You just destroy my dream to be Champion!"
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('kangaskhan', 48),
                    generatePkmnBattle('machamp', 47),
                    generatePkmnBattle('arbok', 46),
                    generatePkmnBattle('nidoking', 50),
                ]
            ),
            createTrainer('A Mountain Man', 
                'mountain',
                [
                    'entrance' => "Can you climb any walls here? I can!",
                    'end' => [
                        "Let me do it for you."
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('golem', 48),
                    generatePkmnBattle('onix', 47),
                    generatePkmnBattle('dugtrio', 46),
                    generatePkmnBattle('sandslash', 46),
                ]
            )
        ]
    ],
    "Victory Road - Part 1" => [
        'Floors' => [81,89],
        'Pokemon savages' => [
            'machoke' => [
                'level' => [45,47],
                'rate' => 20
            ],
            'marowak' => [
                'level' => [40,48],
                'rate' => 25
            ],
            'grimer' => [
                'level' => [48,50],
                'rate' => 5
            ],
            'clefairy' => [
                'level' => [47,50],
                'rate' => 20
            ],
            'electabuzz' => [
                'level' => [48,50],
                'rate' => 10
            ],
            'magmar' => [
                'level' => [48,50],
                'rate' => 10
            ],
            'dratini' => [
                'level' => [40,50],
                'rate' => 5
            ],
        ],
        'Trainers' => [
            createTrainer('A Ranger', 
                'ranger',
                [
                    'entrance' => "Get ready!",
                    'end' => [
                        "You just destroy my dream to be Champion!"
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('rhyhorn', 50),
                    generatePkmnBattle('gyarados', 51),
                    generatePkmnBattle('exeggutor', 50),
                    generatePkmnBattle('pidgeot', 52),
                    generatePkmnBattle('blastoise', 53),
                ]
            ),
            createTrainer('A Ranger', 
                'ranger',
                [
                    'entrance' => "Get ready!",
                    'end' => [
                        "You just destroy my dream to be Champion!"
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('machamp', 50),
                    generatePkmnBattle('electrode', 51),
                    generatePkmnBattle('starmie', 50),
                    generatePkmnBattle('proygon', 52),
                    generatePkmnBattle('parasect', 50),
                ]
            )
        ]
    ],
    "Victory Road - Part 2" => [
        'Floors' => [91,99],
        'Pokemon savages' => [
            'chansey' => [
                'level' => [44,50],
                'rate' => 15
            ],
            'haunter' => [
                'level' => [43,44],
                'rate' => 15
            ],
            'kangaskhan' => [
                'level' => [44,46],
                'rate' => 30
            ],
            'hitmonlee' => [
                'level' => [44,44],
                'rate' => 20
            ],
            'hitmonchan' => [
                'level' => [44,44],
                'rate' => 20
            ],
            'dratini' => [
                'level' => [42,42],
                'rate' => 5
            ],
        ],
        'Trainers' => [
            createTrainer('A Ranger', 
                'ranger',
                [
                    'entrance' => "Get ready!",
                    'end' => [
                        "You just destroy my dream to be Champion!"
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('arcanine', 54),
                    generatePkmnBattle('rapidash', 51),
                    generatePkmnBattle('ninetales', 54),
                    generatePkmnBattle('magmar', 49),
                    generatePkmnBattle('charizard', 49),
                    generatePkmnBattle('flareon', 49),
                ]
            ),
            createTrainer('A Ranger', 
                'ranger',
                [
                    'entrance' => "Get ready!",
                    'end' => [
                        "You just destroy my dream to be Champion!"
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('victreebel', 54),
                    generatePkmnBattle('exeggutor', 51),
                    generatePkmnBattle('scyther', 54),
                    generatePkmnBattle('venusaur', 49),
                    generatePkmnBattle('vileplume', 48),
                ]
            ),
            createTrainer('A Ranger', 
                'ranger',
                [
                    'entrance' => "Get ready!",
                    'end' => [
                        "You just destroy my dream to be Champion!"
                    ]
                ],
                5000,
                [],
                [
                    generatePkmnBattle('golduck', 54),
                    generatePkmnBattle('seadra', 51),
                    generatePkmnBattle('dewgong', 54),
                    generatePkmnBattle('lapras', 47),
                    generatePkmnBattle('vaporeon', 49),
                ]
            ),
        ]
    ],
    "Route 9" => [
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
                'rate' => 30
            ],
            'dratini' => [
                'level' => [44,45],
                'rate' => 5
            ],
        ],
        'Trainers' => null
    ],
    "Safari 2" => [
        'Floors' => [111,119],
        'Pokemon savages' => [
            'porygon' => [
                'level' => [55,60],
                'rate' => 10
            ],
            'exeggutor' => [
                'level' => [55,60],
                'rate' => 10
            ],
            'muk' => [
                'level' => [55,60],
                'rate' => 10
            ],
            'poliwrath' => [
                'level' => [55,60],
                'rate' => 10
            ],
            'eevee' => [
                'level' => [55,60],
                'rate' => 10
            ],
            'kadabra' => [
                'level' => [55,60],
                'rate' => 10
            ],
        ],
        'Trainers' => null
    ],
    "Route 10" => [
        'Floors' => [121,129],
        'Pokemon savages' => [
            'horsea' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'kingler' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'muk' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'poliwrath' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'eevee' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'kadabra' => [
                'level' => [60,65],
                'rate' => 10
            ],
        ],
        'Trainers' => [
            createTrainer('Something???', 
                'ghost',
                [
                    'entrance' => "...",
                    'end' => [
                        "..."
                    ]
                ],
                10000,
                [],
                [
                    generatePkmnBattle('gastly', 60),
                    generatePkmnBattle('haunter', 59),
                    generatePkmnBattle('gastly', 60),
                    generatePkmnBattle('haunter', 59),
                    generatePkmnBattle('gengar', 59),
                ]
            ),
            createTrainer('A Ghost Haunter', 
                'ranger',
                [
                    'entrance' => "I'm from another region. I heard there were ghosts here!",
                    'end' => [
                        "You tell me when you see one!"
                    ]
                ],
                10000,
                [],
                [
                    generatePkmnBattle('golbat', 61),
                    generatePkmnBattle('scyther', 62),
                    generatePkmnBattle('pinsir', 62),
                    generatePkmnBattle('tauros', 61),
                    generatePkmnBattle('snorlax', 60),
                    generatePkmnBattle('venusaur', 60)
                ]
            ),
        ]
    ],
    "Route 11" => [
        'Floors' => [131,139],
        'Pokemon savages' => [
            'scyther' => [
                'level' => [50,50],
                'rate' => 10
            ],
            'pinsir' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'porygon' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'omanyte' => [
                'level' =>[60,65],
                'rate' => 10
            ],
            'kabuto' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'aerodactyl' => [
                'level' => [60,65],
                'rate' => 10
            ],
            'tangela' => [
                'level' => [60,65],
                'rate' => 55
            ],
        ],
        'Trainers' => [
            createTrainer('A Ranger', 
                'ranger',
                [
                    'entrance' => "There is the master of this area top of here.",
                    'end' => [
                        "I never managed to beat him once. And it's not today..."
                    ]
                ],
                10000,
                [],
                [
                    generatePkmnBattle('jynx', 65),
                    generatePkmnBattle('hitmonlee', 63),
                    generatePkmnBattle('dragonite', 65),
                    generatePkmnBattle('wigglytuff', 64),
                    generatePkmnBattle('starmie', 62),
                    generatePkmnBattle('marowak', 66)
                ]
            ),
            createTrainer('A Ranger', 
                'ranger',
                [
                    'entrance' => "My goal is to beat the boss with 1 Pokemon!",
                    'end' => [
                        "Hmm... This may not be a good strategy."
                    ]
                ],
                10000,
                [],
                [
                    generatePkmnBattle(150, 100),
                ]
            ),
        ]
    ],
];

$pnjs = [];
function generateIAs(){
    global $pnjs;
    $pnjs = [
        1 => createTrainer('Tony', 
            'trainer',
            [
                'entrance' => "Do you like short pants?",
                'end' => [
                    "It's ok if you don't like it."
                ]
            ],
            300,
            [],
            [
                generatePkmnBattle('rattata', 2),
                generatePkmnBattle('rattata', 3),
            ],
            0
        ),
        // 1 => createTrainer('TEST TRAINER', 
        //     'trainer',
        //     [
        //         'entrance' => "Do you like short pants?",
        //         'end' => []
        //     ],
        //     0,
        //     [],
        //     [
        //         generatePkmnBattle('rattata', 1),
        //     ],
        //     0
        // ),
        5 =>  createTrainer('???', 
                'rival',
                [
                    'entrance' => "You have a Pokedex too?",
                    'end' => [
                        "Tsss! Out of my sight!"
                    ]
                ],
                1000,
                [],
                [
                    generatePkmnBattle('pidgey', 6,0,['gust','tackle','growl']),
                    generatePkmnBattle(selectStarterRival(0), 8,0),
                ],
                1,
                'Rival'
            ),
        10 =>  createTrainer('Gym Leader Brock', 
            'pierre',
            [
                'entrance' => "I'm thougher than you think.",
                'end' => [
                    "You obtained the Boulder Badge!",
                    "You are solid as a rock! Keep going, your journey start here!"
                ]
            ],
            1000,
            [],
            [
                generatePkmnBattle('geodude', 12,0,["rock-throw", "tackle","harden"]),
                generatePkmnBattle('onix', 14,0,["rock-throw","harden","tackle"]),
            ],
            1,'Gym Leader'
        ),
        15 =>  createTrainer('Blue', 
            'rival',
            [
                'entrance' => "My grandfather has something to tell me? After the fight!",
                'end' => [
                    "What?! I have a dream, let me to be the next Champion!"
                ]
            ],
            2000,
            [],
            [
                generatePkmnBattle('pidgey', 12),
                generatePkmnBattle('rattata', 10),
                generatePkmnBattle('mankey', 11),
                generatePkmnBattle(selectStarterRival(0), 13),
            ],
            1,
            'Rival'
        ),
        20 =>  createTrainer('Gym Leader Misty', 
            'ondine',
            [
                'entrance' => "Don't run around the pool!",
                'end' => [
                    "You obtained the Cascade Badge!",
                    "I'm going to swim with my pokemons."
                ]
            ],
            3000,
            [
                getItemObject('Potion',2)
            ],
            [
                generatePkmnBattle('staryu', 18,0,["bubble","water-gun","tackle"]),
                generatePkmnBattle('starmie', 21,0,["bubble","thunder-shock","amnesia","water-gun"]),
            ],
            1,'Gym Leader'
        ),
        25 =>  createTrainer('Blue', 
            'rival',
            [
                'entrance' => "You? Again?",
                'end' => [
                    "Tsss! Out of my sight!"
                ]
            ],
            3000,
            [],
            [
                generatePkmnBattle('pidgeotto', 16),
                generatePkmnBattle('rattata', 18),
                generatePkmnBattle('mankey', 17),
                generatePkmnBattle(selectStarterRival(1), 20),
            ],
            1,
            'Rival'
        ),
        30 =>  createTrainer('Gym Leader Lt. Surge', 
            'surge',
            [
                'entrance' => "Do you want to go to the army?",
                'end' => [
                    "You obtained the Thunder Badge!",
                    "The army needs guys like you!"
                ]
            ],
            3500,
            [
                getItemObject('Super potion',2)
            ],            [
                generatePkmnBattle('voltorb', 23,0,["thunder-shock","tackle"]),
                generatePkmnBattle('pikachu', 22,0,["thunder-shock","quick-attack","surf"]),
                generatePkmnBattle('raichu', 25,0,["thunder-shock","tail-whip","quick-attack"]),
            ],
            1,'Gym Leader'
        ),
        35 =>  createTrainer('Blue', 
            'rival',
            [
                'entrance' => "Why are you here? You don't have any dead pokemon.",
                'end' => [
                    "..."
                ]
            ],
            3000,
            [],
            [
                generatePkmnBattle('primeape', 26),
                generatePkmnBattle('pidgeotto', 24),
                generatePkmnBattle('kadabra', 25),
                generatePkmnBattle(selectStarterRival(2), 28),
            ],
            1,
            'Rival'
        ),
        40 =>  createTrainer('Gym Leader Erika', 
            'erika',
            [
                'entrance' => "I'm the leader of grass type! Prepare your antidotes.",
                'end' => [
                    "You obtained the Rainbow Badge!",
                    "Have a nice day!"
                ]
            ],
            4000,
            [
                getItemObject('Super potion',2)
            ],            
            [
                generatePkmnBattle('victreebel', 29,0,['vine-whip','toxic']),
                generatePkmnBattle('tangela', 26,0,['vine-whip','absorb']),
                generatePkmnBattle('vileplume', 29,0,['vine-whip','sleep-powder','mega-drain']),
            ],
            1,'Gym Leader'
        ),
        45 =>  createTrainer('Blue', 
            'rival',
            [
                'entrance' => "Did you see any Team Rocket member?",
                'end' => [
                    "You are useless! Go back to your mother."
                ]
            ],
            3000,
            [],
            [
                generatePkmnBattle('primeape', 33),
                generatePkmnBattle('pidgeot', 32),
                generatePkmnBattle('kadabra', 34),
                generatePkmnBattle(selectStarterRival(2), 32),
            ],
            1,
            'Rival'
        ),
        50 =>  createTrainer('Gym Leader Sabrina', 
            'sabrina',
            [
                'entrance' => "What are you looking at?",
                'end' => [
                    "You obtained the Marsh Badge!",
                    "Get out!"
                ]
            ],
            5000,
            [
                getItemObject('Super potion',2)
            ],            
            [
                generatePkmnBattle('kadabra', 35,0,['recover','psychic']),
                generatePkmnBattle('mr-mime', 36,0,['confusion','harden','light-screen']),
                generatePkmnBattle('venomoth', 36,0,['psybeam','leech-life']),
                generatePkmnBattle('alakazam', 38,0,['recover','psychic','amnesia']),
            ],
            1,'Gym Leader'
        ),
        55 =>  createTrainer('Blue', 
            'rival',
            [
            'entrance' => "I almost destroyed the entire Team Rocket base, and you? What did you do?",
            'end' => [
                "Tsss! How can you be so strong and do nothing to help people..."
                ]
            ],
            5000,
            [],
            [
                generatePkmnBattle('pidgeot', 36),
                generatePkmnBattle('raticate', 38),
                generatePkmnBattle('alakazam', 40),
                generatePkmnBattle('primeape', 38),
                generatePkmnBattle(selectStarterRival(2), 40),
            ],
            1,
            'Rival'
        ),
        60 =>  createTrainer('Gym Leader Koga', 
            'koga',
            [
                'entrance' => "I'm a ninja! Could you see me?",
                'end' => [
                    "You obtained the Soul Badge!",
                    "I'm not as fast as I used to be. I need to train with the team more often!"
                ]
            ],
            4500,
            [
                getItemObject('Super potion',2)
            ],            
            [
                generatePkmnBattle('koffing', 37,0,['sludge','sludge-bomb']),
                generatePkmnBattle('muk', 39,0,['sludge','sludge-bomb']),
                generatePkmnBattle('koffing', 37,0,['sludge','sludge-bomb']),
                generatePkmnBattle('weezing', 43,0,['sludge','sludge-bomb']),
            ],
            1,'Gym Leader'
        ),
        65 =>  createTrainer('Blue', 
            'rival',
            [
                'entrance' => "Team Rocket is out! I think you don't know huh?",
                'end' => [
                    "Never mind if i loose. My dream is stronger than you!"
                ]
            ],
            4000,
            [],
            [
                generatePkmnBattle('pidgeot', 46),
                generatePkmnBattle('magikarp', 50),
                generatePkmnBattle('exeggutor', 45),
                generatePkmnBattle('alakazam', 42),
                generatePkmnBattle('primeape', 45),
                generatePkmnBattle(selectStarterRival(2), 42),
            ],
            1,
            'Rival'
        ),
        70 =>  createTrainer('Gym Leader Blaine', 
            'blaine',
            [
                'entrance' => "I hope you bring water pokemon because the sun is shining hard!",
                'end' => [
                    "You obtained the Flame Badge!",
                    "Well done! Just one Badge and you will be in the Pokemons League!"
                ]
            ],
            5500,
            [
                getItemObject('Hyper potion',2)
            ],            
            [
                generatePkmnBattle('growlithe', 42,0,['ember','growl','take-down']),
                generatePkmnBattle('ponyta', 40,0,['tail-whip','growl','stomp','fire-spin']),
                generatePkmnBattle('rapidash', 42,0,['tail-whip','growl','stomp','fire-spin']),
                generatePkmnBattle('arcanine', 47,0,['flamethrower','growl','take-down','fire-blast']),
            ],
            1,'Gym Leader'
        ),
        80 =>  createTrainer('Gym Leader Giovanni', 
            'giovanni',
            [
                'entrance' => "I will have my revenge.",
                'end' => [
                    "You obtained the Earth Badge!",
                    "..."
                ]
            ],
            6000,
            [
                getItemObject('Hyper potion',2)
            ],            
            [
                generatePkmnBattle('rhyhorn', 45,0,['earthquake','tail-whip','stomp','fissure']),
                generatePkmnBattle('dugtrio', 42,0,['earthquake','trash']),
                generatePkmnBattle('nidoqueen', 44,0,['earthquake','tail-whip','poison-sting','thunder']),
                generatePkmnBattle('nidoking', 45,0,['earthquake','tail-whip','poison-sting','thunder']),
                generatePkmnBattle('rhydon', 50,0,['earthquake','tail-whip','stomp','fissure']),
            ],
            1,'Gym Leader'
        ),
        100 =>  createTrainer('Elite Four Lorelei', 
            'lorelei',
            [
                'entrance' => "...",
                'end' => [
                    "You are colder than I imagined"
                ]
            ],
            8000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('dewgong', 54,0, ['growl', 'take-down','rest','aurora-beam']),
                generatePkmnBattle('cloyster', 53,0,['aurora-beam','clamp','spike-cannon']),
                generatePkmnBattle('slowbro', 54,0,['water-gun','amnesia','growl','withdraw']),
                generatePkmnBattle('jynx', 56,0,['body-slam','ice-punch','double-slap','trash']),
                generatePkmnBattle('lapras', 56,0,['body-slam','hydro-pump','blizzard','confuse-ray'])
            ],
            1,'Elite Four'
        ),
        101 =>  createTrainer('Elite Four Bruno', 
            'bruno',
            [
                'entrance' => "Let the training session start!",
                'end' => [
                    "We're not trained enough!"
                ]
            ],
            8000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('onix', 53,0, ['rage', 'rock-throw','slam','harden']),
                generatePkmnBattle('hitmonchan', 55,0,['ice-punch','fire-punch','thunder-punch','quick-attack']),
                generatePkmnBattle('hitmonlee', 55,0,['jump-kick', 'high-jump-kick','mega-kick','focus-energy']),
                generatePkmnBattle('onix', 56,0,['rage', 'rock-throw','slam','harden']),
                generatePkmnBattle('machamp', 58,0,['leer','focus-energy','sacrifice','fissure']),
            ],
            1,'Elite Four'
        ),
        102 =>  createTrainer('Elite Four Agatha', 
            'agatha',
            [
                'entrance' => "I am not old! Get ready to loose brat!",
                'end' => [
                    "I see that you are the trainer trained by Prof. Twig.",
                    "One Elite Four left! He's the strongest from us. Good luck!",
                    "Maybe i'm too old to do this..."                
                    ]
            ],
            8000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('gengar', 56,0, ['hypnosis', 'night-shade','dream-eater']),
                generatePkmnBattle('golbat', 56,0,['confuse-ray','wing-attack','haze']),
                generatePkmnBattle('haunter', 55,0,['amnesia','toxic','sludge-bomb','night-shade']),
                generatePkmnBattle('arbok', 58,0,['hypnosis','bite','screech','acid']),
                generatePkmnBattle('gengar', 60,0,['hypnosis','night-shade','toxic','dream-eater']),
            ],
            1,'Elite Four'
        ),
        103 =>  createTrainer('Elite Four Peter Lance', 
            ['peter','peter2','peter3','peter2','peter'],
            [
                'entrance' => "I'm the master of Pokemons Dragon! Prepare you!",
                'end' => [
                    "Congratulation! You deafeat Elites 4!",
                    "But there is still someone to beat."
                ]
            ],
            8000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('gyarados', 58,0, ['outrage', 'dragon-dance','thunder','hyper-beam']),
                generatePkmnBattle('dragonair', 56,0,['outrage','slam','hyper-beam','dragon-dance','dragon-dance']),
                generatePkmnBattle('dragonair', 56,0,['outrage','slam','sludge-bomb','solar-beam']),
                generatePkmnBattle('aerodactyl', 58,0,['bite','take-down','surf','rock-slide']),
                generatePkmnBattle('dragonite', 60,0,['hyper-beam','earthquake','outrage','trash']),
            ],
            1,'Elite Four'
        ),
        104 =>  createTrainer('Champion Blue', 
            'rival',
            [
                'entrance' => "What?! You here?! How?!",
                'end' => [
                    "How?! Impossible!",
                    "You destroy my dream! I've just become Champion...",
                ]
            ],
            10000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('pidgeot', 56,0, ['quick-attack', 'wing-attack','fly','hyper-beam']),
                generatePkmnBattle('exeggutor', 58,0,['egg-bomb','slam','psychic','solar-beam']),
                generatePkmnBattle('arcanine', 56,0,['hyper-beam','flamethrower','swift','growl']),
                generatePkmnBattle('gyarados', 58,0, ['hydro-pump', 'gust','thunder','hyper-beam']),
                generatePkmnBattle(selectStarterRival(2), 56),
                generatePkmnBattle('alakazam', 54,0,['psychic','recover','amnesia','flamethrower']),
            ],
            1,'Champion'
        ),
        110 => createWildPkmn(70,'mewtwo', 
            [
                'entrance' => "Who is that Pokemon? The pressure is high...",
                'end' => "You've beaten the strongest Pokemon."
            ],          
            'Legendary'
        ),
        120 =>  createTrainer('Champion Blue', 
            'rival',
            [
                'entrance' => "What?! You here?! Anyway, you will lose!",
                'end' => [
                    "How?! Impossible!",
                ]
            ],
            10000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('pidgeot', 60,0, ['quick-attack', 'wing-attack','growl','hyper-beam']),
                generatePkmnBattle('exeggutor', 65,0,['egg-bomb','slam','psychic','solar-beam']),
                generatePkmnBattle('arcanine', 65,0,['hyper-beam','flamethrower','swift','growl']),
                generatePkmnBattle('gyarados', 65,0, ['hydro-pump', 'gust','thunder','hyper-beam']),
                generatePkmnBattle(selectStarterRival(2), 66),
                generatePkmnBattle('alakazam', 63,0,['psychic','recover','amnesia','flamethrower']),
            ],
            1,'Champion'
        ),
        130 =>  createTrainer('Champion Red', 
            ['red','red2','red3','red4'],
            [
                'entrance' => "...",
                'end' => "..."
            ],
            10000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('pikachu', 88,0, ['thunderbolt', 'quick-attack','thunder']),
                generatePkmnBattle('charizard', 77,0,['hyper-beam','flamethrower','wing-attack']),
                generatePkmnBattle('venusaur', 77,0,['razor-leaf','toxic','sludge-bomb','solar-beam']),
                generatePkmnBattle('blastoise', 77,0,['hydro-pump','hyper-beam','surf','take-down']),
                generatePkmnBattle('snorlax', 75,0,['hyper-beam','earthquake','rest','trash']),
                generatePkmnBattle('lapras', 80,0,['surf','hydro-pump','ice-beam','take-down'])
            ],
            1,'Champion'
        ),
        140 =>  createTrainer('Prof. Twig', 
            'trainer',
            [
                'entrance' => "Hehe! What do you think? That i'm not a trainer? Of course i'm!",
                'end' => [
                    "...",
                    "You're stronger than I thought.",
                    "I heard a story about a strange Pokemon hides behind a truck at Vermilion City.",
                    "Here some money to buy what you need to capture it!",
                    "Good luck!",
                ]
            ],
            30000,
            [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],            
            [
                generatePkmnBattle('pidgeot', 85,0, ['quick-attack', 'wing-attack','swords-dance','hyper-beam']),
                generatePkmnBattle('gengar', 86,0,['hyper-beam','flamethrower','psychic','amnesia']),
                generatePkmnBattle("farfetchd", 100,0,['razor-leaf','trash','hyper-beam','swords-dance']),
                generatePkmnBattle('alakazam', 90,0,['psychic','hydro-pump','flamethrower','amnesia']),
                generatePkmnBattle('tauros', 90,0,['hyper-beam','earthquake','rest','trash']),
                generatePkmnBattle('mew', 80,0,['psychic','hydro-pump','ice-beam','amnesia'])
            ],
            1,'Prof'
        ),
        141 => createWildPkmn(70,'mew', 
            [
                'entrance' => "Who is that Pokemon? The pressure is high...",
                'end' => "You've beaten the strongest Pokemon."
            ],          
            'Legendary'
        ),
    ];
}

$towns = [
    2 =>   'Pallet Town',
    5 =>   'Viridian City',
    10 =>  'Pewter City',
    15 =>  'Mt Moon',
    20 =>  'Cerulean City',
    25 =>  'S.S. Anne',
    30 =>  'Vermilion City',
    35 =>  'Lavender Town',
    40 =>  'Celadon City',
    45 =>  'Celadon City',
    50 =>  'Saffron City',
    55 =>  'Celadon City',
    60 =>  'Fuchsia City',
    65 =>  'Fuchsia City',
    70 =>  "Cinnabar Isl'",
    75 =>  'Pallet Town',
    80 =>  'Viridian City',
    85 =>  'Victory Road',
    90 =>  'Victory Road',
    95 =>  'Victory Road',
    100 => 'Indigo League',
    105 => 'Indigo League',
    110 => 'Cerulean City',
    111 => 'Cerulean City', // After mewtwo caugth or not
    115 => 'Safari 2',
    120 => 'Safari 2',
    125 => 'Sevii Islands',
    130 => 'Sevii Islands',
    135 => 'Sevii Islands',
    140 => 'Tower ???',
    141 => 'Vermilion City'
]
?>