<?php
//// GENERATION D'UN PNJ //////////////////////////////////
function generatePNJ($indexFloor, $level){
    $pnj = generatePNJSpe($indexFloor, $level);
    return $pnj;
}

function generatePNJSpe($indexFloor, $level){
    global $pnjs;
    if(array_key_exists($indexFloor, $pnjs)){
        $pnj = $pnjs[$indexFloor];
    }

    if(!isset($pnj)){
        $pnj = [
            'Nom' => 'PaBigOuf',
            'type' => 'trainer',
            'Sprite' => 'trainer',
            'Dialogues' => [
                'entrance' => "Tu vas prendre cher l'ami!",
                'end' => "You are lucky! Next time you will lose."
            ],
            'Bag' => [],
            'Team' => generatePkmnTeam($level),
        ];
    }
    return $pnj;
}
$pnjs = [
    10 => [
        'Nom' => 'Gym Leader Brock',
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
        'Nom' => 'Gym Leader Misty',
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
        'Nom' => 'Gym Leader Lt. Surge',
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
        'Nom' => 'Gym Leader Erika',
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
        'Nom' => 'Gym Leader Koga',
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
        'Nom' => 'Gym Leader Sabrina',
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
            generatePkmnBattle('mr.mime', 37),
            generatePkmnBattle('venomoth', 38),
            generatePkmnBattle('alakazam', 43),
        ],
    ],
    70 => [
        'Nom' => 'Gym Leader Blaine',
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
        'Nom' => 'Gym Leader Giovanni',
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
        'Nom' => 'Elite four Lorelei',
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
        'Nom' => 'Elite four Bruno',
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
        'Nom' => 'Elite four Olga',
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
        'Nom' => 'Elite four Peter Lance',
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

function generatePkmnTeam($level = 5){
    $pkmnTeam = [];
    for($i=0; $i<rand(1,1); ++$i){
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