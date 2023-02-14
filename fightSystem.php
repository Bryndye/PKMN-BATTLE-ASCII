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
            $choicesPkmnTeam = displayPkmnTeam($pkmnTeamJoueur);
            $choice2 = selectPkmn($choicesPkmnTeam, $pkmnTeamJoueur, $pkmnTeamEnemy[0]);
            switchPkmn($pkmnTeamJoueur ,$choice2);
        }
        else{
            searchNewPkmnInTeam($pkmnTeamJoueur);
        }
        // displayPkmnTeams($pkmnTeamJoueur, $pkmnTeamEnemy);
        // displayGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy);
    
        // lance le combat quand les pkmns sont en combat
        loopFight($pkmnTeamJoueur, $pkmnTeamEnemy);
    }
}

// FIGHT SYSTEM
function loopFight(&$pkmnTeamJoueur, &$pkmnTeamEnemy){
    while($pkmnTeamJoueur[0]['Stats']['Health'] > 0 && $pkmnTeamEnemy[0]['Stats']['Health'] > 0 ){
        displayGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy);
        displayInterfaceMenu();

        // init var choice of Player
        $choice = waitForInput(getPosChoice(),[1,2/*,4*/]);
        $choice2;

        $actionJoueur = null;
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

        }
        elseif($choice == 2){
            $a = $pkmnTeamJoueur[0];
            $choicesPkmnTeam = displayPkmnTeam($pkmnTeamJoueur);
            $choice2 = selectPkmn($choicesPkmnTeam, $pkmnTeamJoueur, $pkmnTeamEnemy[0]);
            if($choice2 != 'c'){           
                displayGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy);
            }
        }
        // elseif($choice == 4){
            //     exitGame();
            // }
        $actionJoueur = "$choice $choice2";

        // Si aucune action choisie, retour au début
        if($actionJoueur == null || $choice2 == 'c'){            
            continue;
        }      

        //  CHOIX DE IA SUR ATK
        $actionEnemy = '1 0';
        
        // COMBAT AVEC ACTION JOUEUR ET ACTION ENEMY
        fight($pkmnTeamJoueur, $pkmnTeamEnemy, 
        $actionJoueur, $actionEnemy); 
    } 
}

function fight(&$pkmnTeamJoueur,&$pkmnTeamEnemy, $actionJoueur, $actionEnemy){
    clearArea(getScaleDialogue(),getPosDialogue()); //clear boite dialogue
    
    $actionsTurn = [];

    // voir quelle action a choisi le joueur 
    $arrayJoueur = explode(" ", $actionJoueur);
    $actionJoueur = ['choice' => $arrayJoueur, 'teamAtk' => &$pkmnTeamJoueur, 'teamDef' => &$pkmnTeamEnemy, 'isjoueur' =>true];
    // voir quelle action a choisi l'ennemi 
    $arrayEnemy = explode(" ", $actionEnemy);
    $actionEnemy = ['choice' => $arrayEnemy, 'teamAtk' => &$pkmnTeamEnemy, 'teamDef' => &$pkmnTeamJoueur, 'isjoueur' =>false];
    
    array_push($actionsTurn, $actionEnemy,$actionJoueur);
    // array_push($actionsTurn, $actionJoueur); // first

    $joueurPriority = whichPkmnHasPriority($pkmnTeamJoueur[0],$pkmnTeamEnemy[0], $pkmnTeamJoueur[0]['Capacites'][$arrayJoueur[1]], $pkmnTeamEnemy[0]['Capacites'][$arrayEnemy[1]]);
    
    $actionPriority = false;
    foreach($actionsTurn as $action){
        // print("BOUH");
        // sleep(2);
        if($action['choice'][0] == '2' || $action['choice'][0] == '3'){
            // $actionPriority = $action['isjoueur'];
            $a = &$action;
            array_unshift($actionsTurn, $a); // ajoute $a en premier index
            for($i=1;$i<count($actionsTurn);++$i){
                if($actionsTurn[$i] == $a){
                    array_splice($actionsTurn, $i, 1);
                }
            }
        }
    }
    // print_r($actionsTurn[0]);
    // sleep(4);
    // print_r(count($actionsTurn));
    // sleep(4);
    // if($joueurPriority /*|| $actionPriority*/){   
    //     array_push($actionsTurn, $actionEnemy);
    //     array_push($actionsTurn, $actionJoueur); // first
    // }
    // else{
    //     array_push($actionsTurn, $actionJoueur);
    //     array_push($actionsTurn, $actionEnemy); // first
    // }

    // si switch/ item, priorite sur les actions
    $aPkmnIsDead = false;
    foreach($actionsTurn as &$action){
        // print_r($action['choice']);
        // sleep(5);
        if($action['choice'][0] == '1' && !$aPkmnIsDead){
            $pkmnAtk = &$action['teamAtk'][0]; // first pkmn de l'attaquant
            $pkmnDef = &$action['teamDef'][0]; // first pkmn du défenseur
            $capacite = &$action['teamAtk'][0]['Capacites'][$action['choice'][1]];
            $aPkmnIsDead = attackByJustOnePkmn($pkmnAtk,$pkmnDef, $capacite, !$action['isjoueur']);
        }
        elseif($action['choice'][0] == '2'){
            switchPkmn($action['teamAtk'], $action['choice'][1]);
            sleep(1);
            refreshDisplayOnePkmn($pkmnTeamJoueur, $action['isjoueur']);
            // displayOffMenuTeam($pkmnTeamJoueur[0],$pkmnTeamEnemy[0]);
        }
    }
    if(!isPkmnDead_simple($pkmnTeamJoueur[0])){
        damageTurn($pkmnTeamJoueur[0], true);
    }
    if(!isPkmnDead_simple($pkmnTeamEnemy[0])){
        damageTurn($pkmnTeamEnemy[0], false);
    }  
}
?>