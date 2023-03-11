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
    10 => [
        'Name' => 'Gym Leader Brock',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('geodude', 12),
            generatePkmnBattle('onix', 14),
        ],
    ],
    20 => [
        'Name' => 'Gym Leader Misty',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('staryu', 18),
            generatePkmnBattle('starmie', 21),
        ],
    ],
    30 => [
        'Name' => 'Gym Leader Lt. Surge',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('voltorb', 21),
            generatePkmnBattle('pikachu', 18),
            generatePkmnBattle('raichu', 24),
        ],
    ],
    40 => [
        'Name' => 'Gym Leader Erika',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('victreebel', 29),
            generatePkmnBattle('tangela', 24),
            generatePkmnBattle('vileplume', 29),
        ],
    ],
    50 => [
        'Name' => 'Gym Leader Koga',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('koffing', 37),
            generatePkmnBattle('muk', 39),
            generatePkmnBattle('koffing', 37),
            generatePkmnBattle('weezing', 43),
        ],
    ],
    60 => [
        'Name' => 'Gym Leader Sabrina',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('kadabra', 38),
            generatePkmnBattle('mr-mime', 37),
            generatePkmnBattle('venomoth', 38),
            generatePkmnBattle('alakazam', 43),
        ],
    ],
    70 => [
        'Name' => 'Gym Leader Blaine',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('growlithe', 42),
            generatePkmnBattle('ponyta', 40),
            generatePkmnBattle('rapidash', 42),
            generatePkmnBattle('arcanine', 47),
        ],
    ],
    80 => [
        'Name' => 'Gym Leader Giovanni',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('rhyhorn', 45),
            generatePkmnBattle('dugtrio', 42),
            generatePkmnBattle('nidoqueen', 44),
            generatePkmnBattle('nidoking', 45),
            generatePkmnBattle('rhydon', 50),
        ],
    ],
    90 => [
        'Name' => 'Elite four Lorelei',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('geodude', 12),
            generatePkmnBattle('onix', 14),
        ],
    ],
    91 => [
        'Name' => 'Elite four Bruno',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('geodude', 12),
            generatePkmnBattle('onix', 14),
        ],
    ],
    92 => [
        'Name' => 'Elite four Olga',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('geodude', 12),
            generatePkmnBattle('onix', 14),
        ],
    ],
    93 => [
        'Name' => 'Elite four Peter Lance',
        'type' => 'trainer',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "You are lucky! Next time you will lose."
        ],
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ],
        'Team' => [
            generatePkmnBattle('geodude', 12),
            generatePkmnBattle('onix', 14),
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