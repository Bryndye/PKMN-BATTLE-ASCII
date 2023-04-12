<?php

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
    return $joueurPriority;
}


function attackByJustOnePkmn(&$pkmnAtk,&$pkmnDef, &$capacite, $isJoueurTakeDamage = false){
    attackBehaviourPkmn($pkmnAtk, $pkmnDef,$isJoueurTakeDamage,$capacite);
    return isPkmnDead($pkmnDef, $isJoueurTakeDamage);
}


function attackBehaviourPkmn(&$pkmnAtk, &$pkmnDef, $isJoueurTakeDamage, &$capacite){
    $ailmentParalysis = false;
    $cantPlay = ailmentStartTurnEffect($pkmnAtk);
    if($cantPlay){
        return;
    }
    
    $capacite['PP'] -= 1;
    messageBoiteDialogue($pkmnAtk['Name'] . ' use ' . $capacite['Name'] .'!');

    // failed capacity
    usleep(500000);
    $chanceAccuracy = rand(0,100);
    if($chanceAccuracy > $capacite['Accuracy']){
        messageBoiteDialogue('But it failed!');
        return;
    }
    $chanceEvasion = rand(0,100);
    if($chanceEvasion < $pkmnDef['Stats Temp']['evasion']){
        messageBoiteDialogue($pkmnDef['Name'].' misses the attack!');
        return;
    }

    // penser au Power="reset" et status qui applique status="PSN"
    if($capacite['Category'] == 'status'){

        $ailment = $capacite['effects']['Ailment'];
        if($capacite['Power'] == 'reset'){
            resetAllStatsTempToPkmn($pkmnDef);
        }
        else if(is_null($ailment['ailment'])){
            ailmentChanceOnpKmn($capacite, $pkmnDef, true);
        }
        else{
            boostStatsTemp($pkmnAtk, $pkmnDef, $capacite);           
        }
    }
    else{
        damageCalculator($pkmnAtk,$pkmnDef, $capacite, !$isJoueurTakeDamage);
    }
    createPkmnHUD(getPosHealthPkmn($isJoueurTakeDamage), $pkmnDef, $isJoueurTakeDamage);
    usleep(500000);
}


// fct calculator dmg capacite + stats
function damageCalculator(&$pkmnAtk, &$pkmnDef, $capacite, $isJoueur){  
    $power = $capacite['Power'];
    if(is_string($capacite['Power'])){
        if($capacite['Power'] == 'ko'){
            $power = setPowerCapacityToOS($pkmnDef, $capacite);
        }
        else if($capacite['Power'] == 'weight'){
            $power = setPowerCapacityPourcentByWeight($pkmnAtk);
        }else if($capacite['Power'] == 'speed'){
            $power = setPowerCapacityPourcentBySpeed($pkmnAtk, $pkmnDef, $capacite);
        }
        else if($capacite['Power'] == 'random'){
            $capacite = getRandCapacites();
        }
    }
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
        $statAtkToUsed = $pkmnAtk['Stats']['Atk'] * calculateBoostTemps($pkmnAtk,'Atk');
        $statDefToUsed = $pkmnDef['Stats']['Def'] * calculateBoostTemps($pkmnAtk,'Def');
    }
    else if($capacite['Category'] == 'special'){
        $statAtkToUsed = $pkmnAtk['Stats']['Atk Spe'] * calculateBoostTemps($pkmnAtk,'Atk Spe');
        $statDefToUsed = $pkmnDef['Stats']['Def Spe'] * calculateBoostTemps($pkmnAtk,'Def Spe');
    }
    $b = $statAtkToUsed / $statDefToUsed;

    // 3eme etape = all modifier
    $stab = 1;
    if($capacite['Type'] == $pkmnAtk['Type 1'] || $capacite['Type'] == $pkmnAtk['Type 2']){
        $stab = 1.5;
    }
    $isCrit = rand(0,100) <= ($pkmnAtk['Stats Temp']['critical']+$capacite['crit_rate']*12.5); // doit creer le crit avec capacite
    $efficace = checkTypeMatchup($capacite['Type'], $pkmnDef['Type 1']) * checkTypeMatchup($capacite['Type'], $pkmnDef['Type 2']);
    $random = rand(85,100) / 100;
    $c = $power * $stab * $efficace * $isBurned * $random * ($isCrit ? 2 :1);
    // c = Capacite Base atk* STAB(1-2)* Type(0.5-4)* Critical(1-2)* random([0.85,1]}

    $finalDamage = ceil($a * $b * $c); // final damage

    //  check if its multiple hits
    $timesHit = 1;
    if($capacite['effects']['hits']['min hits'] != null && $capacite['effects']['hits']['max hits']){
        $timesHit = getHits($capacite['effects']['hits']['min hits'], $capacite['effects']['hits']['max hits']);
        messageBoiteDialogue($pkmnAtk['Name']." hits " .  $timesHit.'.');
    }
    pkmnTakesDmg($pkmnDef, $finalDamage * $timesHit, !$isJoueur);
    
    // update health pkmn def before drain
    createPkmnHUD(getPosHealthPkmn(!$isJoueur), $pkmnDef, !$isJoueur);
    usleep(500000);
    
    // MESSAGE CONDITION
    if($finalDamage == 0){
        messageBoiteDialogue("It didn't affect ".$pkmnDef['Name']);
        return;
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
    if($capacite['effects']['Drain'] != 0){
        pkmnTakesDmg($pkmnAtk, -ceil(($capacite['effects']['Drain']/100) * $finalDamage), $isJoueur);

        if($capacite['effects']['Drain'] <= 0){
            messageBoiteDialogue($pkmnAtk['Name']." takes damage from recoil!");

            // update health pkmn atk after drain
            createPkmnHUD(getPosHealthPkmn($isJoueur), $pkmnAtk, $isJoueur);
        }
    }
}

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

function boostStatsTemp(&$pkmnAtk, $pkmnDef, $capacite){
    $effects = $capacite['effects'];
    if(isset($effects['Stats Self'])){
        foreach($effects['Stats Self'] as $stat){
            $chance = rand(0,100);
            if($chance < $stat[2]){ 
                $pkmnAtk['Stats Temp'][$stat[1]] > 6 ?
                    6:  $pkmnAtk['Stats Temp'][$stat[1]] += $stat[0]; // nom de la stat edit
            }

            messageBoiteDialogue($pkmnAtk['Name']." increases ". $stat[1]."!");
        }
    }
    if(isset($effects['Stats Target'])){
        foreach($effects['Stats Target'] as $stat){
            $chance = rand(0,100);
            if($chance < $stat[2]){ 
                $pkmnDef['Stats Temp'][$stat[1]] < -6 ?
                    -6:  $pkmnDef['Stats Temp'][$stat[1]] += $stat[0]; // nom de la stat edit
            }

            messageBoiteDialogue($pkmnDef['Name']." decreases ". $stat[1]."!");
        }
    }
}

function calculateBoostTemps($pkmn, $stat){
    if(!isset($stat)){
        return 1;
    }
    $varTop = 3;
    $varBot = 3;
    if($pkmn['Stats Temp'][$stat] > 0){
        $varTop = $pkmn['Stats Temp'][$stat] + 3;
    }
    else{
        $varBot = abs($pkmn['Stats Temp'][$stat]) + 3;
    }
    
    return $varTop / $varBot;
}

function resetAllStatsTempToPkmn(&$pkmn){
    $pkmn['Stats Temp']['Atk'] = 0;
    $pkmn['Stats Temp']['Def'] = 0;
    $pkmn['Stats Temp']['Atk Spe'] = 0;
    $pkmn['Stats Temp']['Def Spe'] = 0;
    $pkmn['Stats Temp']['Vit'] = 0;
    $pkmn['Stats Temp']['evasion'] = 0;
    $pkmn['Stats Temp']['critical'] = 12.5;
    messageBoiteDialogue($pkmn['Name'] . ' reset all changes.');
}

function getHits($minHits, $maxHits) {
    $totalHits = 0;
    $chance = 5;
    $hitsLeft = $maxHits - $minHits + 1;
    while ($hitsLeft > 0 && mt_rand(1, $hitsLeft) <= $chance) {
        $totalHits++;
        $hitsLeft--;
        $chance = $chance / 2;
    }
    return $minHits + $totalHits;
}

function pkmnTakesDmg(&$pkmn, $damage, $isJoueur){
    // animation hit pkmn
    usleep(500000);
    clearSpritePkmn($isJoueur);
    usleep(500000);
    drawSpritePkmn($pkmn, $isJoueur);
    usleep(500000);
    if($damage < 0){
        messageBoiteDialogue($pkmn['Name'] . ' heals ' . -$damage . ' Hp.');
    }

    $pkmn['Stats']['Health'] -= $damage;
    healthInBloc($pkmn);
}
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////


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
    clearBoiteDialogue();
    clearArea(getScaleHUDPkmn(), getPosHealthPkmn($isJoueur)); //clear HUD pkmn life

    // Clear sprite pkmn
    $posClearSprite = getPosSpritePkmn($isJoueur);
    $posClearSprite = [$posClearSprite[0]+1,$posClearSprite[1]];
    $scaleClear = getScaleSpritePkmn();
    clearArea($scaleClear,$posClearSprite);

    messageBoiteDialogue($pkmn['Name'] . ' is K.O.');
}

function isTeamPkmnAlive($teamPkmn){
    for($i=0; $i<count($teamPkmn);++$i){
        if($teamPkmn[$i]['Stats']['Health'] > 0){
            return true;
        }
    }
    return false;
}
///////////////////////////////////////////////////////////
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
function selectPkmn(&$pkmnTeam, $startIndex, $pkmnDeadSelect = false, $string='Which Pokemon do you want?'){
    drawPkmnTeam($pkmnTeam);
    drawBoiteDialogue();
    messageBoiteDialogueContinue($string);
    
    $arrayChoice = [];
    array_push($arrayChoice, 'c');
    for($i=$startIndex;$i<count($pkmnTeam);++$i){
        if($pkmnDeadSelect || !isPkmnDead_simple($pkmnTeam[$i])){
            array_push($arrayChoice, ($i));
        }
    }
    $choice = waitForInput(getPosChoice(),$arrayChoice);
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
    messageBoiteDialogue("Go ". $pkmnTeam[0]['Name'].'!');
}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////


//// AILMENT PROBLEM ///////////////////////////////////////
function ailmentChanceOnpKmn(&$capacite, &$pkmnDef, $isStatusCap = false){
    $ailment = $capacite['effects']['Ailment'];
    if(!is_null($pkmnDef['Status'])){
        return;
    }

    if($capacite['Category'] == 'status'){
        $pkmnDef['Status'] = status($ailment['ailment']);
        messageBoiteDialogue($pkmnDef['Name']." get ". $ailment['ailment']);
        return;
    }
    else if(isset($ailment['ailment_chance']) && $ailment['ailment_chance'] != 0){
        $chance = rand(0,100);
        if($chance <= $ailment['ailment_chance']){
            $pkmnDef['Status'] = status($ailment['ailment']);
            messageBoiteDialogue($pkmnDef['Name']." get ". $ailment['ailment']);
            return;
        }
    }
    if($isStatusCap){
        messageBoiteDialogue('But it failed');
    }
}

function ailmentStartTurnEffect(&$pkmn){
    if($pkmn['Status'] == 'PAR'){
        $ailmentParalysis = rand(0,100) < 20;
        if($ailmentParalysis){
            messageBoiteDialogue($pkmn['Name'] . ' is paralysed...');
            return true;
        }
    }
    else if($pkmn['Status'] == 'FRZ'){
        $ailment = rand(0,100) < 50;
        if($ailment){
            messageBoiteDialogue($pkmn['Name'] . ' is frozen...');
            return true;
        }
        else{
            messageBoiteDialogue($pkmn['Name'] . ' is up!');
            $pkmn['Status'] = null;
            return false;
        }
    }
    else if($pkmn['Status'] == 'SLP'){
        $ailment = rand(0,100) < 50;
        if($ailment){
            messageBoiteDialogue($pkmn['Name'] . ' is sleeping...');
            return true;
        }
        else{
            messageBoiteDialogue($pkmn['Name'] . ' is awake!');
            $pkmn['Status'] = null;
            return false;
        }
    }
    return false;
}

function status($nameStatus){
    switch($nameStatus){
        case 'paralysis':
            return 'PAR';
        case 'poison':
            return 'PSN'; 
        case 'burn':
            return 'BRN';       
        case 'frozen':
            return 'FRZ';
        case 'sleep':
            return 'SLP';
    }
}

function getStatusEffect($status, $mode) {
    $effect = 0;
    
    switch($status) {
        case "burn":
            if($mode == "battle") {
                $effect = 0.06;
            } else if($mode == "capture") {
                $effect = 12;
            }
            break;
        case "poison":
            if($mode == "battle") {
                $effect = 0.1;
            } else if($mode == "capture") {
                $effect = 12;
            }
            break;
        case "paralysis":
            if($mode == "battle") {
                $effect = 'stun temp';
            } else if($mode == "capture") {
                $effect = 12;
            }
            break;
        case "sleep":
            if($mode == "battle") {
                $effect = 'stun';
            } else if($mode == "capture") {
                $effect = 25;
            }
            break;
        case "frozen":
            if($mode == "battle") {
                $effect = 'stun';
            } else if($mode == "capture") {
                $effect = 25;
            }
            break;
        default:
            if($mode == "battle") {
                $effect = '';
            } else if($mode == "capture") {
                $effect = 1;
            }
    }
    
    return $effect;
}

function damageTurn(&$pkmn, $isJoueur){
    if($pkmn['Status'] == 'BRN' || $pkmn['Status'] == 'PSN'){

        if($pkmn['Status'] == 'BRN'){
            pkmnTakesDmg($pkmn, intval($pkmn['Stats']['Health Max'] * 0.06), $isJoueur);
            // $pkmn['Stats']['Health'] -= intval($pkmn['Stats']['Health Max'] * 0.06);
        }
        else if($pkmn['Status'] == 'PSN'){
            pkmnTakesDmg($pkmn, intval($pkmn['Stats']['Health Max'] * 0.10), $isJoueur);
        }
        messageBoiteDialogue($pkmn['Name'] . ' takes damage from its status!');
        sleep(1);
        updateHealthPkmn(getPosHealthPkmn($isJoueur),$pkmn['Stats']['Health'], $pkmn['Stats']['Health Max']);
        clearBoiteDialogue();
        sleep(1);
        isPkmnDead($pkmn, $isJoueur);
    }
}
///////////////////////////////////////////////////////////
?>