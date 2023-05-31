<?php
include_once 'Programs/Fight/iaProgram.php';
include_once 'Programs/Fight/programFight.php';
include_once 'Programs/Fight/status.php';
// Animations de lancement de combat
function startFight(&$joueur, &$pnj){
    drawSkeletonHUD();
    $pkmnTeamEnemy = &$pnj['Team'];
    $pkmnTeamJoueur = &$joueur['Team'];

    // animation entrer dresseurs
    drawBoiteDialogue();
    animationCharactersEnterBattle(getSprites('trainerBack'),getSprites($pnj['Sprite']));

    messageBoiteDialogue($pnj['Dialogues']['entrance'], -1); // message trainer 
    messageBoiteDialogue($pnj['Name'].' wants to fight!',-1); // message trainer 

    // animation pokeball
    if($pnj['type'] == 'trainer'){
        animationPkmnAppearinBattle(false, $pkmnTeamEnemy[0]);// faire apparaitre pkmn E
        sleep(1);
    }
    messageBoiteDialogue($pkmnTeamJoueur[0]['Name'].', Go!',1);
    animationPkmnAppearinBattle(true, $pkmnTeamJoueur[0]);// faire apparaitre pkmn j
    sleep(1);

    gameplayLoop($joueur, $pnj);
}

// Début du tour
function gameplayLoop(&$joueur, &$pnj){
    $pkmnTeamEnemy = &$pnj['Team'];
    $pkmnTeamJoueur = &$joueur['Team'];
    // while dun combat tant que les equipes sont pleines
    while(isTeamPkmnAlive($pkmnTeamJoueur) && isTeamPkmnAlive($pkmnTeamEnemy)){
        // selectionne un pkmn si currentPkmn = vide (enemy ou joueur)
        if(isPkmnDead_simple($pkmnTeamEnemy[0])){
            choosePkmn($pkmnTeamEnemy);
            animationPkmnAppearinBattle(false, $pkmnTeamEnemy[0]);// faire apparaitre pkmn j
        }
        if(isPkmnDead_simple($pkmnTeamJoueur[0])){
            $choice2 = selectPkmn($pkmnTeamJoueur, 1);
            
            switchPkmn($pkmnTeamJoueur ,$choice2);
            animationPkmnAppearinBattle(true, $pkmnTeamJoueur[0]);// faire apparaitre pkmn j
        }
        addPkmnToPokedex($pkmnTeamEnemy[0], 'see');
        // lance le combat quand les pkmns sont en combat
        loopFight($joueur, $pnj);
    }

    // fct after battle
    endBattle($joueur, $pnj);
}

// Selection du choix joueur et enemy
function loopFight(&$joueur, &$pnj){

    $pkmnTeamEnemy = &$pnj['Team'];
    $pkmnTeamJoueur = &$joueur['Team'];
    while($pkmnTeamJoueur[0]['Stats']['Health'] > 0 && $pkmnTeamEnemy[0]['Stats']['Health'] > 0 ){

        drawGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy);
        interfaceMenu();

        // init var choice of Player
        $choice = waitForInput(getPosChoice(),[1,2,3]);

        $actionJoueur = null;
        if($choice == 1){
            interfaceCapacities($pkmnTeamJoueur[0]['Capacites']);
            $arrayChoise2 = [leaveInputMenu()];
            for($i=0;$i<4;++$i){
                if(isset($pkmnTeamJoueur[0]['Capacites'][$i]['Name']) && $pkmnTeamJoueur[0]['Capacites'][$i]['PP'] > 0){
                    array_push($arrayChoise2, $i+1);
                }
            }
            $choice2 = waitForInput(getPosChoice(), $arrayChoise2); 
            $choice2 = is_numeric($choice2) ? $choice2-1 : $choice2;// -1 cause of choices +1 for players
        }
        elseif($choice == 2){
            $choice2 = selectPkmn($pkmnTeamJoueur);
            if($choice2 != leaveInputMenu()){           
                drawGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy);
            }
        }
        elseif($choice == 3){
            $choice2 = enterIntoBag($joueur, $pnj['type']);
            // si item type == capture, jouer autre fonction
            drawGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy);
        }
        $actionJoueur = "$choice $choice2";

        // Si aucune action choisie, retour au début
        if($actionJoueur == null || substr($choice2, 0, 1) == leaveInputMenu()){            
            continue;
        }

        //  CHOIX DE IA SUR ATK
        $actionEnemy = iaChoice($pkmnTeamJoueur, $pnj, $pnj['Bag']);
        
        // COMBAT AVEC ACTION JOUEUR ET ACTION ENEMY
        $var = fight($pkmnTeamJoueur, $pkmnTeamEnemy, 
        $actionJoueur, $actionEnemy, $joueur['Bag'], $pnj['Bag']); 

        if($var == 'captured'){
            break;
        }
    } 
    if($pkmnTeamEnemy[0]['Stats']['Health'] == 0){
        endPkmnDied($pkmnTeamJoueur,$pkmnTeamEnemy[0]);
    }
    elseif($var == 'captured'){
        endPkmnCaptured($joueur, $pkmnTeamEnemy[0]);
        $pkmnTeamEnemy[0]['Stats']['Health'] = 0;
    }
}

// Lancer les actions des joueurs
function fight(&$pkmnTeamJoueur,&$pkmnTeamEnemy, $actionJoueur, $actionEnemy, &$bagJ, &$bajE){
    clearBoiteDialogue();
    
    $actionsTurn = [];

    // voir quelle action a choisi le joueur 
    $arrayJoueur = explode(" ", $actionJoueur);
    $actionJoueur = [
        'choice' => $arrayJoueur, 
        'teamAtk' => &$pkmnTeamJoueur, 
        'teamDef' => &$pkmnTeamEnemy, 
        'isjoueur' => true,
        'Bag' => &$bagJ
    ];
    // voir quelle action a choisi l'ennemi 
    $arrayEnemy = explode(" ", $actionEnemy);
    $actionEnemy = [
        'choice' => $arrayEnemy, 
        'teamAtk' => &$pkmnTeamEnemy, 
        'teamDef' => &$pkmnTeamJoueur, 
        'isjoueur' =>false,
        'Bag' => &$bajE
    ];  

    $priorityJoueur = isActionBePriority($pkmnTeamJoueur[0], $arrayJoueur); 
    $priorityEnemy = isActionBePriority($pkmnTeamEnemy[0], $arrayEnemy); 

    $joueurPriority = true;
    if($actionJoueur['choice'][0] == '1' && $actionEnemy['choice'][0] == '1'){
        $joueurPriority = whichPkmnHasPriority($pkmnTeamJoueur[0],$pkmnTeamEnemy[0], $priorityJoueur, $priorityEnemy);
    }
    
    if($joueurPriority){   
        array_push($actionsTurn, $actionJoueur); // first
        array_push($actionsTurn, $actionEnemy);
    }
    else{
        array_push($actionsTurn, $actionEnemy); // first
        array_push($actionsTurn, $actionJoueur);
    }

    foreach($actionsTurn as $action){

        if($action['choice'][0] == '2' || $action['choice'][0] == '3'){
            $a = &$action;
            array_unshift($actionsTurn, $a); // ajoute $a en premier index
            for($i=1;$i<count($actionsTurn);++$i){
                if($actionsTurn[$i] == $a){
                    array_splice($actionsTurn, $i, 1);
                }
            }
        }
    }

    // si switch/ item, priorite sur les actions
    $aPkmnIsDead = false;
    foreach($actionsTurn as &$action){

        if($action['choice'][0] == '1' && !$aPkmnIsDead){
            $pkmnAtk = &$action['teamAtk'][0]; // first pkmn de l'attaquant
            $pkmnDef = &$action['teamDef'][0]; // first pkmn du défenseur
            $capacite = &$action['teamAtk'][0]['Capacites'][$action['choice'][1]];
            $aPkmnIsDead = attackByJustOnePkmn($pkmnAtk,$pkmnDef, $capacite, !$action['isjoueur']);
        }
        elseif($action['choice'][0] == '2'){
            switchPkmn($action['teamAtk'], $action['choice'][1]);

            clearPkmnHUD($action['teamAtk'], $action['isjoueur']);
            animationPkmnAppearinBattle($action['isjoueur'], $action['teamAtk'][0]);// faire apparaitre pkmn j
            usleep(500000);
            drawPkmnSideHUD($action['teamAtk'], $action['isjoueur']);
        }
        elseif($action['choice'][0] == '3'){
            if($action['Bag'][$action['choice'][1]]['type'] == 'PokeBalls'){
                $didIt = useItem($action['Bag'], $action['Bag'][$action['choice'][1]], $action['teamDef'][0]);
                // FIN DU COMBAT SI CAPTURE
                if($didIt){
                    // $action['teamDef'][0]['Stats']['Health'] = -1;
                    return 'captured';
                }
            }
            else{
                useItem($action['Bag'], $action['Bag'][$action['choice'][1]], $action['teamAtk'][$action['choice'][2]]);
            }
            drawPkmnSideHUD($action['teamAtk'], $action['isjoueur']);
        }
    }
    if(!isPkmnDead_simple($pkmnTeamJoueur[0])){
        damageTurn($pkmnTeamJoueur[0], true);
    }
    if(!isPkmnDead_simple($pkmnTeamEnemy[0])){
        damageTurn($pkmnTeamEnemy[0], false);
    }  
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function isActionBePriority($pkmn, $action){
    if($action[0] != '1'){
        return 0;
    }
    $priority = isset($pkmn['Capacites'][$action[1]]) ? $pkmn['Capacites'][$action[1]] : 0;
    return $priority;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function endPkmnDied(&$pkmnTeamJoueur, &$pkmnE){
    messageBoiteDialogue("You've fainted " . $pkmnE['Name'].'.');
    for($i=0;$i<count($pkmnTeamJoueur);++$i){
        $firstPkmn = $i == 0;
        getExp($pkmnTeamJoueur[$i], expToGive($pkmnTeamJoueur[$i], $pkmnE),false, $firstPkmn);
    }
}   

function endPkmnCaptured(&$joueur, &$pkmnE){
    $pkmnTeamJoueur = &$joueur['Team'];
    for($i=0;$i<count($pkmnTeamJoueur);++$i){
        $notFirstPkmn = $i != 0;
        getExp($pkmnTeamJoueur[$i], expToGive($pkmnTeamJoueur[$i], $pkmnE, false, $notFirstPkmn));
    }
    getPokemonFromCapture($pkmnTeamJoueur, $pkmnE);
}

function endBattle(&$joueur, $pnj){
    $pkmnTeamJoueur = $joueur['Team'];
    resetTeamStatsTemp($pkmnTeamJoueur);
    if(!isTeamPkmnAlive($pkmnTeamJoueur)){
        messageBoiteDialogue("Your whole Team is k.o!",1);
        messageBoiteDialogue("You can't fight...",1);
    }
    else{
        if($pnj['type'] == 'trainer'){
            drawSprite(getSprites($pnj['Sprite']), getPosSpritePkmn(false));
        }
        if(isset($pnj['Dialogues']['end'])){
            // debugLog($pnj['Dialogues']['end']);
            if(is_array($pnj['Dialogues']['end'])){
                foreach($pnj['Dialogues']['end'] as $message){
                    if(!is_null($message)){
                                    // debugLog('1');
                        messageBoiteDialogue($message,-1);
                    }
                }
            }
            elseif(isset($pnj['Dialogues']['end'])){
                // debugLog('2');
                messageBoiteDialogue($pnj['Dialogues']['end'],-1);
            }
        }
        messageBoiteDialogue("You've defeated " . $pnj['Name'].'!',-1);
        if(!is_null($pnj['Reward']) && $pnj['Reward']>0){
            $joueur['Money'] += $pnj['Reward'];
            messageBoiteDialogue("You get " . $pnj['Reward'].' pokedollars.',1);
        }
    }
}
?>