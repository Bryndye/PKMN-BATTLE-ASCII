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
            displayPkmnTeam($pkmnTeamJoueur, $pkmnTeamEnemy[0], $statOpen);
        }
        else{
            searchNewPkmnInTeam($pkmnTeamJoueur);
        }
        // searchNewPkmnInTeam($pkmnTeamJoueur);
        // searchNewPkmnInTeam($pkmnTeamEnemy);
        // ICI MESSAGE PKMN LANCEr de pokeball
        displayGameHUD($pkmnTeamJoueur[0], $pkmnTeamEnemy[0]);
    
        // lance le combat quand les pkmns sont en combat
        loopFight($pkmnTeamJoueur, $pkmnTeamEnemy);
    }
}

// FIGHT SYSTEM
function loopFight(&$pkmnTeamJoueur, &$pkmnTeamEnemy){
    while($pkmnTeamJoueur[0]['Stats']['Health'] > 0 && $pkmnTeamEnemy[0]['Stats']['Health'] > 0 ){
        // if($currentPkmnEnemy['Stats']['Health'] > 0 && $currentPkmnJoueur['Stats']['Health'] > 0 ){
        //     break;
        // }
        // DISPLAY PKMN TEAM 
        // print($currentPkmnJoueurG['Name'] . rand(1,1000));
        displayPkmnTeamHUD($pkmnTeamJoueur, [17,34]);
        displayPkmnTeamHUD($pkmnTeamEnemy, [7,3]);
        $choice = waitForInput(getPosChoice(),[1,2,4]);

        if($choice == 1){
            interfaceCapacities($pkmnTeamJoueur[0]['Capacites']);
            // passe a la selection des capacites
            // selectCapacite();
            $arrayChoise2 = [];
            for($i=0;$i<4;++$i){
                if(isset($pkmnTeamJoueur[0]['Capacites'][$i]['Name'])){
                    array_push($arrayChoise2, ($i));
                }
            }
            // -- VERIFIER SI PP SUP A 0 --
            $choice2 = waitForInput(getPosChoice(), $arrayChoise2);
            // lance animation de combat une fois capacite choisi
            fight($pkmnTeamJoueur[0], $pkmnTeamEnemy[0], 
            $pkmnTeamJoueur[0]['Capacites'][$choice2]);
        }
        elseif($choice == 2){
            managePkmnTeamHUD($pkmnTeamJoueur,$pkmnTeamEnemy[0], $statOpen);
            // si le joueur switch, le pkmn enemy attacks
        }
        elseif($choice == 4){
            exitGame();
        }
    } 
}


// -- FUNCTIONS TO CALL FOR FIGHT --
function fight(&$pkmnJoueur,&$pkmnEnemy, &$capacite){
    // le choix de la capacite doit se faire ici 
    clearArea(getScaleDialogue(),getPosDialogue()); //clear boite dialogue
    
    if($pkmnJoueur['Stats']['Vit'] > $pkmnEnemy['Stats']['Vit']){
        attackBehaviourPkmn($pkmnJoueur, $pkmnEnemy,false, $capacite);
        if(!isPkmnDead($pkmnEnemy, false)){
            attackBehaviourPkmn($pkmnEnemy, $pkmnJoueur,true);
            isPkmnDead($pkmnJoueur, true);
        }
    }
    else{
        attackBehaviourPkmn($pkmnEnemy, $pkmnJoueur,true);
        if (!isPkmnDead($pkmnJoueur, true)){
            attackBehaviourPkmn($pkmnJoueur, $pkmnEnemy,false, $capacite);
            isPkmnDead($pkmnEnemy, false);
        }
    }
    
    // reinitialiser HUD apres combat
    displayInterfaceMenu();
}

function attackBehaviourPkmn(&$pkmnAtk, &$pkmnDef, $isJoueur = true, &$capacite = null){
    // A CHANGER CAR IA NE CHOISIT PAS SON ATK
    if($capacite == null){
        $capacite = getCapacite('tackle');
    }
    $capacite['PP'] -= 1;
    messageBoiteDialogue($pkmnAtk['Name'] . ' use ' . $capacite['Name'] .'!');
    sleep(1);
    $posClearSprite = getPosSpritePkmn($isJoueur);
    $posClearSprite = [$posClearSprite[0]+1,$posClearSprite[1]];
    $scaleClear = getScaleSpritePkmn();
    
    sleep(1);
    clearArea($scaleClear,$posClearSprite);
    sleep(1);
    displaySpritePkmn($pkmnDef, $isJoueur);
    sleep(1);
    damageCalculator($pkmnAtk,$pkmnDef, $capacite);
    updateHealthPkmn(getPosHealthPkmn($isJoueur),$pkmnDef['Stats']['Health'], $pkmnDef['Stats']['Health Max']);
    sleep(1);
}

// fct calculator dmg capacite + stats
function damageCalculator(&$pkmnAtk, &$pkmnDef, $capacite){    
    // 1ere etape
    $a = (2 * $pkmnAtk['Level'] +10)/250;

    // 2eme etape -> Category d'atk
    // b = stat Atk utilisé pour la capacite / stat def utilisé contre la capacité
    if($capacite['Category'] == 'physical'){
        $statAtkToUsed = $pkmnAtk['Stats']['Atk'];
        $statDefToUsed = $pkmnDef['Stats']['Def'];
    }
    else if($capacite['Category'] == 'special'){
        $statAtkToUsed = $pkmnAtk['Stats']['Atk Spe'];
        $statDefToUsed = $pkmnDef['Stats']['Def Spe'];
    }
    $b = $statAtkToUsed / $statDefToUsed;

    // 3eme etape = all modifier
    $stab = 1;
    if($capacite['Type'] == $pkmnAtk['Type 1'] || $capacite['Type'] == $pkmnAtk['Type 2']){
        $stab = 1.5;
    }

    $efficace = checkTypeMatchup($capacite['Type'], $pkmnDef['Type 1']) * checkTypeMatchup($capacite['Type'], $pkmnDef['Type 2']);
    $random = rand(85,100) / 100;
    $c = $capacite['Power'] * $stab * $efficace * $random;
    // c = Capacite Base atk* STAB(1-2)* Type(0.5-4)* Critical(1-2)* random([0.85,1]}
    
    // final = a*b*c
    $finalDamage = intval($a * $b * $c);
    $pkmnDef['Stats']['Health'] -= $finalDamage;

    // une fois dmg sur pkmn, sentence super efficace/ coup critique
    if($pkmnDef['Stats']['Health'] < 0){
        $pkmnDef['Stats']['Health'] = 0;
    }

    // MESSAGE CONDITION
    if($finalDamage == 0){
        messageBoiteDialogue("Nothing happens...");
    }
    else if($efficace > 1){
        messageBoiteDialogue("It's super effective !");
    }
    else if($efficace < 1){
        messageBoiteDialogue("It's not very effective !");
    }
    // A ajouter le msg si crit
}

// DEATH PKMN -- A FIX CE SOUCIS --
function isPkmnDead(&$pkmn, $isJoueur){
    // sleep(5);
    if($pkmn['Stats']['Health'] <= 0){
        PkmnKO($pkmn, $isJoueur);
        return true;
    }
    else{
        return false;
    }
}

function isPkmnDead_simple(&$pkmn){
    // sleep(5);
    if($pkmn['Stats']['Health'] <= 0){
        return true;
    }
    else{
        return false;
    }
}
// ----------------------------------
function PkmnKO($pkmn, $isJoueur){
    clearArea(getScaleDialogue(),getPosDialogue()); //clear boite dialogue
    clearArea(getScaleHUDPkmn(), getPosHealthPkmn($isJoueur)); //clear HUD pkmn life

    // Clear sprite pkmn
    $posClearSprite = getPosSpritePkmn($isJoueur);
    $posClearSprite = [$posClearSprite[0]+1,$posClearSprite[1]];
    $scaleClear = getScaleSpritePkmn();
    clearArea($scaleClear,$posClearSprite);

    messageBoiteDialogue($pkmn['Name'] . ' is K.O.');
    sleep(1);
}

function isTeamPkmnKO($teamPkmn){
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            return true;
        }
    }
    return false;
}

function searchNewPkmnInTeam(&$teamPkmn){
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            switchPkmn($teamPkmn, $i);
            return;
        }
    }
    return null;
}

function switchPkmn(&$pkmnTeam ,$index){

    $a = &$pkmnTeam[$index];
    array_unshift($pkmnTeam, $a); // ajoute $a en premier index
    for($i=1;$i<count($pkmnTeam);++$i){
        if($pkmnTeam[$i] == $a){
            array_splice($pkmnTeam, $i, 1);
        }

    }
    // for($i=0;$i<count($pkmnTeam);++$i){
    //     if(isset($pkmnTeam[$i])){
    //         print_r($pkmnTeam[$i]['Name'] . "\n");
    //     }
    //     else{
    //         $pkmnTeam[$i];
    //     }
    // }
}
?>