<?php
// Tout ce qui concerne IA
// $pkmnTeamEnemy = [
//     generatePkmnBattle('151', 100),
//     generatePkmnBattle('150', 100),
//     generatePkmnBattle('149', 100)
// ];
function generatePNJ($indexFloor, $level){
    $pnj = [
        'Nom' => 'PaBigOuf',
        'Sprite' => 'trainer',
        'Dialogues' => [
            'entrance' => "Tu vas prendre cher l'ami!",
            'end' => "De toute façon je voulais chier..."
        ],
        'Team' => generatePkmnTeam($level),
    ];
    return $pnj;
}

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