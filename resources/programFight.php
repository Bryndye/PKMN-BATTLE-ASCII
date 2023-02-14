<?php

// FUNCTION TO LAUNCH GAME & PLAY
// displayBox(29,60,1,1); // Cadre du jeu
// clearArea(27,58,2,2); // Efface l'écran

//// FUNCTIONS TO CALL FOR FIGHT ///////////////////////////
function whichPkmnHasPriority($pkmnJoueur, $pkmnEnemy, $capacite, $capaciteE){
    $joueurPriority = true;
    $vitJoueur = $pkmnJoueur['Stats']['Vit'];
    $vitEnemy = $pkmnEnemy['Stats']['Vit'];

    if($capacite['priority'] == $capaciteE['priority']){
        if($pkmnJoueur['Status'] == 'PAR'){
            $vitJoueur *= 0.5;
        }
        if($pkmnEnemy['Status'] == 'PAR'){
            $vitEnemy *= 0.5;
        }
        $joueurPriority = $pkmnJoueur['Stats']['Vit'] > $pkmnEnemy['Stats']['Vit'];
    }
    else {     
        $joueurPriority = $capacite['priority'] > $capaciteE['priority'];
    }
}

function attackByJustOnePkmn(&$pkmnAtk,&$pkmnDef, &$capacite, $isJoueurTakeDamage = false){
    attackBehaviourPkmn($pkmnAtk, $pkmnDef,$isJoueurTakeDamage,$capacite);
    return isPkmnDead($pkmnDef, $isJoueurTakeDamage);
}

function attackBehaviourPkmn(&$pkmnAtk, &$pkmnDef, $isJoueurTakeDamage = true, &$capacite){
    $ailmentParalysis = false;
    if($pkmnAtk['Status'] == 'PAR'){
        $ailmentParalysis = rand(0,100) < 20;
        if($ailmentParalysis){
            messageBoiteDialogue($pkmnAtk['Name'] . ' is paralysed');
            return;
        }
    }
    $capacite['PP'] -= 1;
    messageBoiteDialogue($pkmnAtk['Name'] . ' use ' . $capacite['Name'] .'!');

    clearSpritePkmn($isJoueurTakeDamage, 1);
    sleep(1);
    displaySpritePkmn($pkmnDef, $isJoueurTakeDamage);
    sleep(1);
    damageCalculator($pkmnAtk,$pkmnDef, $capacite);
    updateHealthPkmn(getPosHealthPkmn($isJoueurTakeDamage),$pkmnDef['Stats']['Health'], $pkmnDef['Stats']['Health Max']);
    sleep(1);
}

// fct calculator dmg capacite + stats
function damageCalculator(&$pkmnAtk, &$pkmnDef, $capacite){    
    // 1ere etape
    $a = (2 * $pkmnAtk['Level'] +10)/250;

    // 2eme etape -> Category d'atk
    // b = stat Atk utilisé pour la capacite / stat def utilisé contre la capacité
    $isBurned = 1;
    if($capacite['Category'] == 'physical'){
        // damage reduce 0.5 if pkmn burn
        if($pkmnAtk['Status'] == 'BRN'){
            $isBurned = 0.5;
        }
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
    $isCrit = false; // doit creer le crit avec capacite
    $efficace = checkTypeMatchup($capacite['Type'], $pkmnDef['Type 1']) * checkTypeMatchup($capacite['Type'], $pkmnDef['Type 2']);
    $random = rand(85,100) / 100;
    $c = $capacite['Power'] * $stab * $efficace * $isBurned * $random;
    // c = Capacite Base atk* STAB(1-2)* Type(0.5-4)* Critical(1-2)* random([0.85,1]}

    $finalDamage = ceil($a * $b * $c); // final
    $pkmnDef['Stats']['Health'] -= $finalDamage;

    // une fois dmg sur pkmn, sentence super efficace/ coup critique
    if($pkmnDef['Stats']['Health'] < 0){
        $pkmnDef['Stats']['Health'] = 0;
    }

    // MESSAGE CONDITION
    if($finalDamage == 0){
        messageBoiteDialogue("Nothing happens...");
    }
    else if($isCrit){
        messageBoiteDialogue("Critical hit!");
    }
    else if($efficace > 1){
        messageBoiteDialogue("It's super effective!");
    }
    else if($efficace < 1){
        messageBoiteDialogue("It's not very effective!");
    }
    ailmentChanceOnpKmn($capacite, $pkmnDef);
    // A ajouter le msg si crit
}

///// POKEMON DEATH FUNCTIONS //////////////////////////////////
function isPkmnDead(&$pkmn, $isJoueur){
    if($pkmn['Stats']['Health'] <= 0){
        animatePkmnKo($pkmn, $isJoueur);
        return true;
    }
    else{
        return false;
    }
}
function animatePkmnKo($pkmn, $isJoueur){
    clearArea(getScaleDialogue(),getPosDialogue()); //clear boite dialogue
    clearArea(getScaleHUDPkmn(), getPosHealthPkmn($isJoueur)); //clear HUD pkmn life

    // Clear sprite pkmn
    $posClearSprite = getPosSpritePkmn($isJoueur);
    $posClearSprite = [$posClearSprite[0]+1,$posClearSprite[1]];
    $scaleClear = getScaleSpritePkmn();
    clearArea($scaleClear,$posClearSprite);

    messageBoiteDialogue($pkmn['Name'] . ' is K.O.');
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

function isTeamPkmnKO($teamPkmn){
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            return true;
        }
    }
    return false;
}
///////////////////////////////////////////////////////////



//// FUNCTIONS LOOKING FOR NEW PKMN IN BATTLE ////////////
function searchNewPkmnInTeam(&$teamPkmn){
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            switchPkmn($teamPkmn, $i);
            return;
        }
    }
    return null;
}
function selectPkmn($arrayChoice, &$pkmnTeam, &$currentPkmnE){
    array_push($arrayChoice, 'c');
    $choice = waitForInput(getPosChoice(),$arrayChoice);

    // displayOffMenuTeam($pkmnTeam[0],$currentPkmnE);
    return $choice;
}

function switchPkmn(&$pkmnTeam ,$index){
    $a = &$pkmnTeam[$index];
    array_unshift($pkmnTeam, $a); // ajoute $a en premier index
    for($i=1;$i<count($pkmnTeam);++$i){
        if($pkmnTeam[$i] == $a){
            array_splice($pkmnTeam, $i, 1);
        }
    }
    messageBoiteDialogue("Go ". $pkmnTeam[0]['Name']);
}
///////////////////////////////////////////////////////////


//// STATUS DAMAGES ///////////////////////////////////////
function ailmentChanceOnpKmn(&$capacite, &$pkmnDef){
    if($capacite['Ailment']['ailment_chance'] != 0){
        $chance = rand(0,100);
        if($chance < $capacite['Ailment']['ailment_chance']){
            $pkmnDef['Status'] = status($capacite['Ailment']['ailment']);
            messageBoiteDialogue($pkmnDef['Name']." get ". $capacite['Ailment']['ailment']);
        }
    }
}

function status($nameStatus){
    switch($nameStatus){
        case 'paralysis':
            return 'PAR';
        case 'poison':
            return 'PSN'; 
        case 'burn':
            return 'BRN';       
    }
}
function damageTurn(&$pkmn, $isJoueur){
    if($pkmn['Status'] != 'BRN' || $pkmn['Status'] != 'PSN'){
        return;
    }
    if($pkmn['Status'] == 'BRN'){
        $pkmn['Stats']['Health'] -= intval($pkmn['Stats']['Health Max'] * 0.06);
    }
    else if($pkmn['Status'] == 'PSN'){
        $pkmn['Stats']['Health'] -= intval($pkmn['Stats']['Health Max'] * 0.08);
    }
    messageBoiteDialogue($pkmn['Name'] . ' takes damage from is status!');
    sleep(1);
    updateHealthPkmn(getPosHealthPkmn($isJoueur),$pkmn['Stats']['Health'], $pkmn['Stats']['Health Max']);
    clearArea(getScaleDialogue(),getPosDialogue()); //clear boite dialogue
    isPkmnDead($pkmn, $isJoueur);
}
///////////////////////////////////////////////////////////
?>