<?php

$statOpen = false;
$stopLoop = false;
// Transformer la function en selection de pkmn ?
function startFight(&$pkmnJoueur, &$pkmnEnemy){
    // animation entrer dresseurs
    gameplayLoop($pkmnJoueur, $pkmnEnemy);
}

// Start the game loop
function gameplayLoop(&$pkmnTeamJoueur, &$pkmnTeamEnemy){

    // while dun combat tant que les equipes sont pleines
    while(isTeamPkmnKO($pkmnTeamJoueur) && isTeamPkmnKO($pkmnTeamEnemy)){
        // selectionne un pkmn si currentPkmn = vide (enemy ou joueur)
        if(isPkmnDead_simple($pkmnTeamEnemy[0])){
            searchNewPkmnInTeam($pkmnTeamEnemy);
        }
        if(isPkmnDead_simple($pkmnTeamJoueur[0])){
            displayPkmnTeam($pkmnTeamJoueur, $pkmnTeamEnemy[0], $statOpen, true);
        }
        else{
            searchNewPkmnInTeam($pkmnTeamJoueur);
        }
        displayPkmnTeams($pkmnTeamJoueur, $pkmnTeamEnemy);
        displayGameHUD($pkmnTeamJoueur[0], $pkmnTeamEnemy[0]);
    
        // lance le combat quand les pkmns sont en combat
        loopFight($pkmnTeamJoueur, $pkmnTeamEnemy);
    }
}

// FIGHT SYSTEM
function loopFight(&$pkmnTeamJoueur, &$pkmnTeamEnemy){
    while($pkmnTeamJoueur[0]['Stats']['Health'] > 0 && $pkmnTeamEnemy[0]['Stats']['Health'] > 0 ){
        refreshHUDloopFight($pkmnTeamJoueur, $pkmnTeamEnemy);

        $choice = waitForInput(getPosChoice(),[1,2,4]);

        if($choice == 1){
            interfaceCapacities($pkmnTeamJoueur[0]['Capacites']);
            $arrayChoise2 = [];
            for($i=0;$i<4;++$i){
                if(isset($pkmnTeamJoueur[0]['Capacites'][$i]['Name'])){
                    array_push($arrayChoise2, ($i));
                }
            }
            // -- VERIFIER SI PP SUP A 0 --
            $choice2 = waitForInput(getPosChoice(), $arrayChoise2);

            //  CHOIX DE IA SUR ATK
            $capaciteE = getCapacite('tackle');

            fight($pkmnTeamJoueur[0], $pkmnTeamEnemy[0], 
            $pkmnTeamJoueur[0]['Capacites'][$choice2], $capaciteE);
        }
        elseif($choice == 2){
            managePkmnTeamHUD($pkmnTeamJoueur,$pkmnTeamEnemy[0], $statOpen);
        }
        elseif($choice == 4){
            exitGame();
        }
        
        if(!isPkmnDead_simple($pkmnTeamJoueur[0])){
            damageTurn($pkmnTeamJoueur[0], true);
        }
        if(!isPkmnDead_simple($pkmnTeamEnemy[0])){
            damageTurn($pkmnTeamEnemy[0], false);
        }
        displayInterfaceMenu();
    } 
}
?>