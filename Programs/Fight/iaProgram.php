<?php
//// GENERATION D'UN PNJ //////////////////////////////////
function generatePNJ($indexFloor, $level){
    $pnj = managerPNJGenerate($indexFloor, $level);
    return $pnj;
}

function managerPNJGenerate($indexFloor, $level){
    global $pnjs;
    if(array_key_exists($indexFloor, $pnjs)){
        $pnj = $pnjs[$indexFloor];
    }

    if(!isset($pnj)){
        $pnj = generateWildPkmn($indexFloor, $level);
    }
    return $pnj;
}
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
        'Reward' => 1000,
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
        'Reward' => 1000,
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
        'Reward' => 1500,
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
        'Reward' => 1500,
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
        'Reward' => 1500,
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
        'Reward' => 2000,
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
        'Reward' => 2000,
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
        'Reward' => 2000,
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
        'Reward' => 3500,
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
        'Reward' => 3500,
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
        'Reward' => 3500,
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
        'Reward' => 3500,
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
        'Reward' => 4000,
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

function generateWildPkmn($indexFloor, $level){
    // prendre un pokemon dans une list par rapport indexFloor
    $pkmn = generatePkmnTeam($level);
    $pnj = [
        'Name' => $pkmn[0]['Name'],
        'type' => 'wild',
        'Sprite' => $pkmn[0]['Sprite'],
        'Dialogues' => [
            'entrance' => 'A wild Pokemon appears. '
        ],
        'Reward' => null,
        'Bag' => [],
        'Team' => $pkmn
    ];
    return $pnj;
}

function generatePkmnTeam($level = 5, $count = 1){
    $pkmnTeam = [];
    for($i=0; $i<rand(1,$count); ++$i){
        array_push($pkmnTeam, generatePkmnBattle(rand(0,151), $level + rand(-4,-1)));
    }
    return $pkmnTeam;
}

function iaChoice(&$pkmnTeamJ, &$pkmnTeamE){
    $choice;
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
        // print_r($currentPkmnE);
        // print_r($currentPkmnE['Capacites']);
        // sleep(5);
        for($i=0; $i<count($currentPkmnE['Capacites']); ++$i){
            $puissance = $currentPkmnE['Capacites'][$i]['Power'];
            // $efficacite = $currentPkmnE['Capacites'][$i]['Type'];
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

function choosePkmn(&$teamPkmn){
    $pkmnIndex;
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            $pkmnIndex = $i;
        }
    }

    switchPkmn($teamPkmn, $pkmnIndex);
}
?>