<?php

$statOpen = false;
$stopLoop = false;
$pkmnTeamJoueur = [];
$pkmnTeamEnemy = [];
$currentPkmnJoueur;
$currentPkmnEnemy;

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
        $currentPkmnJoueur = &$pkmnTeamJoueur[searchNewPkmnInTeam($pkmnTeamJoueur)];
        $currentPkmnEnemy = &$pkmnTeamEnemy[searchNewPkmnInTeam($pkmnTeamEnemy)];
        // ICI MESSAGE PKMN LANCEr de pokeball
        displayGameHUD($currentPkmnJoueur, $currentPkmnEnemy);
        
        // DISPLAY PKMN TEAM 
        displayPkmnTeamHUD($pkmnTeamJoueur, [17,34]);
        displayPkmnTeamHUD($pkmnTeamEnemy, [7,3]);
        // lance le combat quand les pkmns sont en combat
        loopFight($currentPkmnJoueur, $currentPkmnEnemy, $pkmnTeamJoueur);
    }
}

// FIGHT SYSTEM
function loopFight(&$currentPkmnJoueur, &$currentPkmnEnemy, &$pkmnTeamJoueur){
    while($currentPkmnEnemy['Stats']['Health'] > 0 && $currentPkmnJoueur['Stats']['Health'] > 0 ){
    
        $choice = waitForInput(getPosChoice(),[1,2,4]);
        if($choice == 1){
            // passe a la selection des capacites
            // selectCapacite();
            $arrayChoise2 = [];
            for($i=0;$i<4;++$i){
                if(isset($currentPkmnJoueur['Capacites'][$i]['Name'])){
                    array_push($arrayChoise2, ($i));
                }
            }
            // -- VERIFIER SI PP SUP A 0 --
            $choice2 = waitForInput(getPosChoice(), $arrayChoise2);
            // lance animation de combat une fois capacite choisi
            fight($currentPkmnJoueur, $currentPkmnEnemy, 
            $currentPkmnJoueur['Capacites'][$choice2]);
        }elseif($choice == 2){
            // displayPkmnTeam($pkmnTeamJoueur, $currentPkmnJoueur);
            manageStatPkmn($currentPkmnJoueur,$currentPkmnEnemy, 
            $pkmnTeamJoueur, $statOpen);
        }
        elseif($choice == 4){
            exitGame();
        }
    } 
}


// -- FUNCTIONS TO CALL FOR FIGHT --
function fight(&$pkmn1,&$pkmn2, &$capacite){
    clearArea(getScaleDialogue(),getPosDialogue()); //clear boite dialogue
    
    if($pkmn1['Stats']['Vit'] > $pkmn2['Stats']['Vit']){
        attackBehaviourPkmn($pkmn1, $pkmn2,false, $capacite);
        if(!isPkmnDead($pkmn2, false)){
            attackBehaviourPkmn($pkmn2, $pkmn1,true);
            isPkmnDead($pkmn1, true);
        }
    }
    else{
        attackBehaviourPkmn($pkmn2, $pkmn1,true);
        if (!isPkmnDead($pkmn1, true)){
            attackBehaviourPkmn($pkmn1, $pkmn2,false, $capacite);
            isPkmnDead($pkmn2, false);
        }
    }
    
    // reinitialiser HUD apres combat
    displayHUDFight();
    interfaceCapacities($pkmn1['Capacites']);
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
    // $pkmnDef['Stats']['Health'] -= $pkmnAtk['Stats']['Atk']; //atk simple
    
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
    if($efficace > 1){
        messageBoiteDialogue("It's super effective !");
    }
    else if($efficace < 1){
        messageBoiteDialogue("It's not very effective !");
    }
    // A ajouter le msg si crit
}

// DEATH PKMN
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

function switchPkmn(){

}
function searchNewPkmnInTeam(&$teamPkmn){
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            return $i;
        }
    }
    return null;
}
?>