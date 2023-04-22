<?php
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

$pnjs = [];
function generateIAs(){
    global $pnjs;
    $pnjs = [
        1 => [
            'Name' => 'Tony',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "Do you like short pants?",
                'end' => [
                    "It's ok if you don't like it."
                ]
            ],
            'Reward' => 150,
            'Bag' => [
            ],
            'Team' => [
                generatePkmnBattle('rattata', 3),
                generatePkmnBattle('rattata', 4),
            ]
        ],
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
                    generatePkmnBattle('pidgey', 6),
                    generatePkmnBattle(selectStarterRival(0), 8),
                ],
                1
            ),
        10 => [
            'Name' => 'Gym Leader Brock',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "I'm tougher than you think",
                'end' => [
                    "You obtained the Boulder Badge!",
                    "You are solid as a rock! Keep going, your journey start here!"
                ]
            ],
            'Reward' => 200,
            'Bag' => [
            ],
            'Team' => [
                generatePkmnBattle('geodude', 12,0,["rock-throw", "tackle","harden"]),
                generatePkmnBattle('onix', 14,0,["rock-throw","harden","tackle"]),
            ],
        ],
        20 => [
            'Name' => 'Gym Leader Misty',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "Don't run around the pool!",
                'end' => [
                    "You obtained the Cascade Badge!",
                    "I'm going to swim with my pokemons."
                ]
            ],
            'Reward' => 3000,
            'Bag' => [
                getItemObject('Potion',2)
            ],
            'Team' => [
                generatePkmnBattle('staryu', 18,0,["bubble","water-gun","tackle"]),
                generatePkmnBattle('starmie', 21,0,["bubble","thunder-shock","amnesia","water-gun"]),
            ],
        ],
        30 => [
            'Name' => 'Gym Leader Lt. Surge',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "Do you want to go to the army?",
                'end' => [
                    "You obtained the Thunder Badge!",
                    "The army needs guys like you!"
                ]
            ],
            'Reward' => 3500,
            'Bag' => [
                getItemObject('Super potion',2)
            ],
            'Team' => [
                generatePkmnBattle('voltorb', 21,0,["thunder-shock","tackle"]),
                generatePkmnBattle('pikachu', 18,0,["thunder-shock","quick-attack","tail-whip","surf"]),
                generatePkmnBattle('raichu', 24,0,["thunder-shock","tail-whip","quick-attack"]),
            ],
        ],
        40 => [
            'Name' => 'Gym Leader Erika',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "I'm the leader of grass type! Prepare your antidotes.",
                'end' => [
                    "You obtained the Rainbow Badge!",
                    "Be the sun with you!"
                ]
            ],
            'Reward' => 4000,
            'Bag' => [
                getItemObject('Super potion',2)
            ],
            'Team' => [
                generatePkmnBattle('victreebel', 29,0,['vine-whip','toxic']),
                generatePkmnBattle('tangela', 24,0,['vine-whip','absorb']),
                generatePkmnBattle('vileplume', 29,0,['vine-whip','sleep-powder','mega-drain']),
            ],
        ],
        50 => [
            'Name' => 'Gym Leader Koga',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "I'm a ninja! Could you see me?",
                'end' => [
                    "You obtained the Soul Badge!",
                    "I'm not as fast as I used to be. I need to train with the team more often!"
                ]
            ],
            'Reward' => 4500,
            'Bag' => [
                getItemObject('Super potion',2)
            ],
            'Team' => [
                generatePkmnBattle('koffing', 37,0,['sludge','sludge-bomb']),
                generatePkmnBattle('muk', 39,0,['sludge','sludge-bomb']),
                generatePkmnBattle('koffing', 37,0,['sludge','sludge-bomb']),
                generatePkmnBattle('weezing', 43,0,['sludge','sludge-bomb']),
            ],
        ],
        60 => [
            'Name' => 'Gym Leader Sabrina',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "What are you looking at?",
                'end' => [
                    "You obtained the Marsh Badge!",
                    "Get out!"
                ]
            ],
            'Reward' => 5000,
            'Bag' => [
                getItemObject('Super potion',2)
            ],
            'Team' => [
                generatePkmnBattle('kadabra', 38,0,['recover','psychic']),
                generatePkmnBattle('mr-mime', 37,0,['confusion','protect','light-screen']),
                generatePkmnBattle('venomoth', 38,0,['psybeam','leech-life']),
                generatePkmnBattle('alakazam', 43,0,['recover','psychic','amnesia']),
            ],
        ],
        70 => [
            'Name' => 'Gym Leader Blaine',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "Do you like short pants?",
                'end' => [
                    "You obtained the Flame Badge!",
                    "Well done! Just one Badge and you will be in the Pokemons League!"
                ]
            ],
            'Reward' => 5500,
            'Bag' => [
                getItemObject('Hyper potion',2)
            ],
            'Team' => [
                generatePkmnBattle('growlithe', 42,0,['ember','growl','take-down']),
                generatePkmnBattle('ponyta', 40,0,['tail-whip','growl','stomp','fire-spin']),
                generatePkmnBattle('rapidash', 42,0,['tail-whip','growl','stomp','fire-spin']),
                generatePkmnBattle('arcanine', 47,0,['flamethrower','growl','take-down','fire-blast']),
            ],
        ],
        80 => [
            'Name' => 'Gym Leader Giovanni',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "I will have my revenge.",
                'end' => [
                    "You obtained the Earth Badge!",
                    "..."
                ]
            ],
            'Reward' => 6000,
            'Bag' => [
                getItemObject('Hyper potion',2)
            ],
            'Team' => [
                generatePkmnBattle('rhyhorn', 45,0,['earthquake','tail-whip','stomp','fissure']),
                generatePkmnBattle('dugtrio', 42,0,['earthquake','trash']),
                generatePkmnBattle('nidoqueen', 44,0,['earthquake','tail-whip','poison-sting','thunder']),
                generatePkmnBattle('nidoking', 45,0,['earthquake','tail-whip','poison-sting','thunder']),
                generatePkmnBattle('rhydon', 50,0,['earthquake','tail-whip','stomp','fissure']),
            ],
        ],
        90 => [
            'Name' => 'Elite four Lorelei',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "...",
                'end' => [
                    "You are colder than I imagined"
                ]
            ],
            'Reward' => 8000,
            'Bag' => [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],
            'Team' => [
                generatePkmnBattle('dewgong', 54,0, ['growl', 'take-down','rest','aurora-beam']),
                generatePkmnBattle('cloyster', 53,0,['aurora-beam','clamp','spike-cannon']),
                generatePkmnBattle('slowbro', 54,0,['water-gun','amnesia','growl','withdraw']),
                generatePkmnBattle('jynx', 56,0,['body-slam','ice-punch','double-slap','trash']),
                generatePkmnBattle('lapras', 56,0,['body-slam','hydro-pump','blizzard','confuse-ray'])
            ],
        ],
        91 => [
            'Name' => 'Elite four Bruno',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "Let the training session start!",
                'end' => [
                    "We're not trained enough!"
                ]
            ],
            'Reward' => 8000,
            'Bag' => [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],
            'Team' => [
                generatePkmnBattle('onix', 53,0, ['rage', 'rock-throw','slam','harden']),
                generatePkmnBattle('hitmonchan', 55,0,['ice-punch','fire-punch','thunder-punch','quick-attack']),
                generatePkmnBattle('hitmonlee', 55,0,['jump-kick', 'high-jump-kick','mega-kick','focus-energy']),
                generatePkmnBattle('onix', 56,0,['rage', 'rock-throw','slam','harden']),
                generatePkmnBattle('machamp', 58,0,['leer','focus-energy','sacrifice','fissure']),
            ],
        ],
        92 => [
            'Name' => 'Elite four Olga',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "I am not old! Get ready to loose brat!",
                'end' => [
                    "I see that you are the trainer trained by Prof. Twig.",
                    "One Elite four left! He's the strongest from us. Good luck!",
                    "Maybe i'm too old to do this..."
                ]
            ],
            'Reward' => 8000,
            'Bag' => [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],
            'Team' => [
                generatePkmnBattle('gengar', 56,0, ['hypnosis', 'night-shade','dream-eater']),
                generatePkmnBattle('golbat', 56,0,['confuse-ray','wing-attack','haze']),
                generatePkmnBattle('haunter', 55,0,['amnesia','toxic','sludge-bomb','night-shade']),
                generatePkmnBattle('arbok', 58,0,['hypnosis','bite','screech','acid']),
                generatePkmnBattle('gengar', 60,0,['hypnosis','night-shade','toxic','dream-eater']),
            ],
        ],
        93 => [
            'Name' => 'Elite four Peter Lance',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "I'm the master of Pokemons Dragon! Prepare you!",
                'end' => [
                    "Congratulation! You deafeat Elites 4 but there is more challenge.",
                    "He's waiting for you..."
                ]
            ],
            'Reward' => 8000,
            'Bag' => [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],
            'Team' => [
                generatePkmnBattle('gyarados', 58,0, ['dragon-rage', 'slam','thunder','hyper-beam']),
                generatePkmnBattle('dragonair', 56,0,['dragon-rage','slam','hyper-beam']),
                generatePkmnBattle('dragonair', 56,0,['dragon-rage','slam','sludge-bomb','solar-beam']),
                generatePkmnBattle('aerodactyl', 60,0,['bite','take-down','surf','take-down']),
                generatePkmnBattle('dragonite', 62,0,['hyper-beam','earthquake','thunder','trash']),
            ],
        ],
        94 => [
            'Name' => 'Champion Blue',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "What?! You here?! Anyway, you will lose!",
                'end' => [
                    "How?! Impossible!",
                    "Congratulation! You are the new Champion!"
                ]
            ],
            'Reward' => 10000,
            'Bag' => [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],
            'Team' => [           
                generatePkmnBattle('pidgeot', 56,0, ['quick-attack', 'wing-attack','growl','hyper-beam']),
                generatePkmnBattle('exeggutor', 58,0,['egg-bomb','slam','psychic','solar-beam']),
                generatePkmnBattle('arcanine', 56,0,['extreme-speed','flamethrower','swift','growl']),
                generatePkmnBattle('gyarados', 58,0, ['hydro-pum', 'twister','thunder','hyper-beam']),
                generatePkmnBattle('rhydon', 56,0,['rock-slide','earthquake','hyper-beam','fury-attack']),
                generatePkmnBattle('alakazam', 54,0,['psychic','recover','amnesia','protect']),
            ],
        ],
        100 => [
            'Name' => 'mewtwo',
            'type' => 'wild',
            'Sprite' => 'thumbnail',
            'Dialogues' => [
                'entrance' => "Who is that Pokemon? The pressure is high...",
                'end' => "You've beaten the strongest Pokemon."
            ],
            'Reward' => 0,
            'Bag' => [],
            'Team' => [
                generatePkmnBattle('mewtwo', 70,0,["psychic","flamethrower","amnesia","hyper-beam"]),
            ],
        ],
        110 => [
            'Name' => 'Champion Red',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "...",
                'end' => "..."
            ],
            'Reward' => 15000,
            'Bag' => [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],
            'Team' => [
                generatePkmnBattle('pikachu', 88,0, ['thunderbolt', 'quick-attack','thunder']),
                generatePkmnBattle('charizard', 77,0,['hyper-beam','flamethrower','wing-attack']),
                generatePkmnBattle('venusaur', 77,0,['razor-leaf','toxic','sludge-bomb','solar-beam']),
                generatePkmnBattle('blastoise', 77,0,['hydro-pump','hyper-beam','surf','take-down']),
                generatePkmnBattle('snorlax', 75,0,['hyper-beam','earthquake','rest','trash']),
                generatePkmnBattle('lapras', 80,0,['surf','hydro-pump','ice-beam','take-down'])
            ],
        ],
        120 => [
            'Name' => 'Prof. Twig',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "Hehe! What do you think? That i'm not a trainer? Of course i'm!",
                'end' => [
                    "...",
                    "I'm going back to my development. this game needs some updates..."
                ]
            ],
            'Reward' => 30000,
            'Bag' => [
                getItemObject('Hyper potion',5),
                getItemObject('Revive',5),
            ],
            'Team' => [
                generatePkmnBattle('pidgeot', 85,0, ['quick-attack', 'wing-attack','swords-dance','hyper-beam']),
                generatePkmnBattle('gengar', 86,0,['hyper-beam','flamethrower','psychic','amnesia']),
                generatePkmnBattle("farfetchd", 100,0,['razor-leaf','trash','hyper-beam','swords-dance']),
                generatePkmnBattle('alakazam', 90,0,['psychic','hydro-pump','flamethrower','amnesia']),
                generatePkmnBattle('tauros', 90,0,['hyper-beam','earthquake','rest','trash']),
                generatePkmnBattle('mew', 80,0,['psychic','hydro-pump','ice-beam','amnesia'])
            ],
        ],
    ];
}
?>