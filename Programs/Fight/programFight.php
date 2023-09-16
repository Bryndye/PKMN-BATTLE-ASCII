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
    $cantPlay = ailmentStartTurnEffect($pkmnAtk);
    if($cantPlay){
        return;
    }
    
    $capacite['PP'] -= 1;
    Display_Game::messageBoiteDialogue(ucfirst($pkmnAtk['Name']) . ' use ' . $capacite['Name'] .'!',1);

    // Accuracy capacity
    $chanceAccuracy = rand(0,100);
    if(!is_null($capacite['Accuracy']) && $chanceAccuracy > $capacite['Accuracy']*calculateBoostTemps($pkmnAtk, 'Accuracy')){
        Display_Game::messageBoiteDialogue($pkmnAtk['Name'].' misses his attack!',1);
        return;
    }

    if(is_string($capacite['Power']) && $capacite['Power'] == 'randomReplace'){
        $capacite = getRandCapacites('randomReplace');
        Display_Game::messageBoiteDialogue($pkmnAtk['Name'].' replaces his attack with '. $capacite['Name'].'!',1);
    }
    // Set new Capacite ref depend on metronome
    if(is_string($capacite['Power']) && $capacite['Power'] == 'random'){
        $newCapacite = getRandCapacites('metronome');
        Display_Game::messageBoiteDialogue($pkmnAtk['Name'].' invokes '. $newCapacite['Name'].'!',1);
    }
    else {
        $newCapacite = &$capacite;
    }
    
    // Now use $newCapacite in the remaining code
    if($newCapacite['Category'] == 'status'){
        statusCapacityPkmn($pkmnAtk,$pkmnDef, $newCapacite, !$isJoueurTakeDamage);
    }
    else{ // CAPACITE PHYSICAL/SPECIAL
        // Evasion fiscal
        $chanceEvasion = rand(0,100);
        if($chanceEvasion < $pkmnDef['Stats Temp']['evasion']){
            Display_Game::messageBoiteDialogue($pkmnDef['Name'].' dodges the attack!',1);
            return;
        }
        Animations::attack($pkmnAtk, !$isJoueurTakeDamage);
        attackPkmnCalculator($pkmnAtk,$pkmnDef, $newCapacite, !$isJoueurTakeDamage);
    }
    Display_Fight::drawPkmnInfoHUD(Parameters::getPosHealthPkmn($isJoueurTakeDamage), $pkmnDef, $isJoueurTakeDamage);
    sleep(1);
}


// fct calculator dmg capacite + stats
function attackPkmnCalculator(&$pkmnAtk, &$pkmnDef, $capacite, $isJoueur){  
    //// Capacity Special ¨Power /////////////////////////////////////////////////////////////////////
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
        else if($capacite['Power'] == 'level'){
            $power = setPowerCapacityPourcentByLevel($pkmnAtk, $pkmnDef, $capacite);
        }
    }
    //// 1ere etape //////////////////////////////////////////////////////////////////////////////////
    $a = (2 * $pkmnAtk['Level'] +10)/250;

    // 2eme etape = Category d'atk ///////////////////////////////////////////////////////////////////
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

    //// 3eme etape = all modifier //////////////////////////////////////////////////////////////////
    $stab = 1;
    if($capacite['Type'] == $pkmnAtk['Type 1'] || $capacite['Type'] == $pkmnAtk['Type 2']){
        $stab = 1.5;
    }
    $isCrit = rand(0,100) <= ($pkmnAtk['Stats Temp']['critical']*12.5+$capacite['crit_rate']*12.5+12.5); // doit creer le crit avec capacite
    $efficace = checkTypeMatchup($capacite['Type'], $pkmnDef['Type 1']) * checkTypeMatchup($capacite['Type'], $pkmnDef['Type 2']);
    $random = rand(85,100) / 100;
    $c = $power * $stab * $efficace * $isBurned * $random * ($isCrit ? 2 :1);
    if($efficace == 0){
        Display_Game::messageBoiteDialogue("It didn't affect ".$pkmnDef['Name'],1);
        return;
    }
    // c = Capacite Base atk* STAB(1-2)* Type(0.5-4)* Critical(1-2)* random([0.85,1]}

    $finalDamage = ceil($a * $b * $c); // final damage

    //// check if its multiple hits /////////////////////////////////////////////////////////////////
    $timesHit = 1;
    if($capacite['effects']['hits']['min hits'] != null && $capacite['effects']['hits']['max hits']){
        $timesHit = getHits($capacite['effects']['hits']['min hits'], $capacite['effects']['hits']['max hits']);
        Display_Game::messageBoiteDialogue($pkmnAtk['Name']." hits " .  $timesHit.'.',1);
    }
    takeDamagePkmn($pkmnDef, $finalDamage * $timesHit, !$isJoueur);
    
    //// update health pkmn def before drain ////////////////////////////////////////////////////////
    Display_Fight::drawPkmnInfoHUD(Parameters::getPosHealthPkmn(!$isJoueur), $pkmnDef, !$isJoueur);
    usleep(500000);
    
    //// MESSAGE CONDITION //////////////////////////////////////////////////////////////////////////
    if($isCrit){
        Display_Game::messageBoiteDialogue("Critical hit!",1);
    }
    else if($efficace > 1){
        Display_Game::messageBoiteDialogue("It's super effective!",1);
    }
    else if($efficace < 1){
        Display_Game::messageBoiteDialogue("It's not very effective!",1);
    }

    ailmentChanceOnpKmn($capacite, $pkmnDef);
    if($capacite['effects']['Drain'] != 0){
        takeDamagePkmn($pkmnAtk, -ceil(($capacite['effects']['Drain']/100) * $finalDamage), $isJoueur);

        if($capacite['effects']['Drain'] <= 0){
            Display_Game::messageBoiteDialogue($pkmnAtk['Name']." takes damage from recoil!",1);
        }  
        // update health pkmn atk after drain
        Display_Fight::drawPkmnInfoHUD(Parameters::getPosHealthPkmn($isJoueur), $pkmnAtk, $isJoueur);
    }
}

function statusCapacityPkmn(&$pkmnAtk,&$pkmnDef, &$capacite, $isJoueurAttack){
    $ailment = $capacite['effects']['Ailment'];
    if($capacite['Power'] == 'reset'){
        resetAllStatsTempToPkmn($pkmnDef);
    }
    else if(!is_null($ailment['ailment'])){
        ailmentChanceOnpKmn($capacite, $pkmnDef, true);
    }
    else{
        boostStatsTemp($pkmnAtk, $pkmnDef, $capacite, $isJoueurAttack);           
    }
    if($capacite['effects']['Healing'] != 0){
        $pkmnAtk['Stats']['Health'] += intval(($capacite['effects']['Healing'] / 100) * $pkmnAtk['Stats']['Health Max']);
        checkHealthOutRange($pkmnAtk);
        Display_Fight::drawPkmnInfoHUD(Parameters::getPosHealthPkmn($isJoueurAttack),$pkmnAtk, $isJoueurAttack);
    }
}

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

function boostStatsTemp(&$pkmnAtk, &$pkmnDef, $capacite, $isJoueurAttack){
    $effects = $capacite['effects'];
    if(isset($effects['Stats Self'])){
        foreach($effects['Stats Self'] as $stat){
            $chance = rand(0,100);
            if($chance <= $stat[2]){ 
                if($pkmnAtk['Stats Temp'][$stat[1]] < 6){
                    $pkmnAtk['Stats Temp'][$stat[1]] += $stat[0];
                    if($pkmnAtk['Stats Temp'][$stat[1]] > 0){
                        Animations::attackUp($pkmnAtk,$isJoueurAttack);
                        Display_Game::messageBoiteDialogue($pkmnAtk['Name']." increases ". $stat[1]."!",1);
                    }
                    else{
                        Animations::attackDown($pkmnAtk,$isJoueurAttack);
                        Display_Game::messageBoiteDialogue($pkmnAtk['Name']." decreases ". $stat[1]."!",1);
                    }
                }
                else{
                    Display_Game::messageBoiteDialogue("Can't modify ". $stat[1]."!",1);
                }
            }
        }
    }
    if(isset($effects['Stats Target'])){
        foreach($effects['Stats Target'] as $stat){
            $chance = rand(0,100);
            if($chance <= $stat[2]){ 
                if($pkmnDef['Stats Temp'][$stat[1]] > -6){
                    $pkmnDef['Stats Temp'][$stat[1]] += $stat[0];
                    // Display_Game::messageBoiteDialogue($pkmnDef['Name']." decreases ". $stat[1]."!",1);
                    if($pkmnDef['Stats Temp'][$stat[1]] > 0){
                        Animations::attackUp($pkmnDef,!$isJoueurAttack);
                        Display_Game::messageBoiteDialogue($pkmnDef['Name']." increases ". $stat[1]."!",1);
                    }
                    else{
                        Animations::attackDown($pkmnDef,!$isJoueurAttack);
                        Display_Game::messageBoiteDialogue($pkmnDef['Name']." decreases ". $stat[1]."!",1);
                    }
                }
                else{
                    Display_Game::messageBoiteDialogue("Can't modify ". $stat[1]."!",1);
                }
            }
        }
    }
}

function calculateBoostTemps($pkmn, $stat){
    if(!isset($stat)){
        print('aps de stat');
        return 1;
    }
    $varTop = 3;
    $varBot = 3;
    if(!array_key_exists($stat, $pkmn['Stats Temp'])){
        print_r($pkmn['Stats Temp']);
        sleep(5);
    }
    if($pkmn['Stats Temp'][$stat] > 0){
        $varTop = $pkmn['Stats Temp'][$stat] + 3;
    }
    else{
        $varBot = abs($pkmn['Stats Temp'][$stat]) + 3;
    }
    return $varTop / $varBot;
}

function resetAllStatsTempToPkmn(&$pkmn){
    $pkmn['Stats Temp'] = [
        'Atk' => 0,
        'Def' => 0,
        'Atk Spe' => 0,
        'Def Spe' => 0,
        'Vit' => 0,
        'evasion' => 10,
        'critical' => 0,
        'Accuracy' => 0,
        'protected' => false,
        'Substitute' => [
            'Health Max' => 3,
            'Health' => 0,
            'Used' => false
        ]
    ];
    Display_Game::messageBoiteDialogue(ucfirst($pkmn['Name']) . ' reset all changes.',1);
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

function takeDamagePkmn(&$pkmn, $damage, $isJoueur){
    Animations::takeDamage($pkmn, $isJoueur);
    if($damage < 0){
        Display_Game::messageBoiteDialogue(ucfirst($pkmn['Name']) . ' drains ' . -$damage . ' Hp.',1);
    }

    $pkmn['Stats']['Health'] -= $damage;
    checkHealthOutRange($pkmn);

    if($pkmn['Stats']['Health'] <= 0){ // If pkmn dead, reset status
        $pkmn['Status'] = null;
    }
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
    Display_Game::clearBoiteDialogue();
    Display::clearArea(Parameters::getScaleHUDPkmn(), Parameters::getPosHealthPkmn($isJoueur)); //clear HUD pkmn life

    // Clear sprite pkmn
    $posClearSprite = Parameters::getPosSpritePkmn($isJoueur);
    $scaleClear = Parameters::getScaleSpritePkmn();
    Display::clearArea($scaleClear,$posClearSprite);

    Display_Game::messageBoiteDialogue(ucfirst($pkmn['Name']) . ' is K.O.',1);
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
function selectPkmn(&$pkmnTeam, $exception = [], $pkmnDeadSelect = true, $string='Which Pokemon do you want?'){
    Display_Fight::drawPkmnTeam($pkmnTeam);
    Display_Game::drawBoiteDialogue();
    Display_Game::messageBoiteDialogue($string);
    
    $arrayChoice = [];
    array_push($arrayChoice, leaveInputMenu());
    if(!is_array($exception)){
        $exception = is_null($exception) ? [999] : [$exception];
    }
    for($i=0;$i<count($pkmnTeam);++$i){
        $nextPkmn = false;
        for ($y = 0; $y < count($exception); $y++) {
            if ($exception[$y] == $i) {
                $nextPkmn = true;
                break;
            }
        }
        if($nextPkmn){
            continue;
        }
        else if($pkmnDeadSelect || !isPkmnDead_simple($pkmnTeam[$i])){
            array_push($arrayChoice, ($i+1));
        }
    }
    $choice = waitForInput(Parameters::getPosChoice(),$arrayChoice);
    $choice = is_numeric($choice) ? $choice-1 : $choice;// -1 cause of choices +1 for players
    return $choice;
}

function switchPkmn(&$pkmnTeam ,$index, $inBattle = true){
    $a = &$pkmnTeam[$index];
    array_unshift($pkmnTeam, $a); // ajoute $a en premier index
    for($i=1;$i<count($pkmnTeam);++$i){
        if($pkmnTeam[$i] == $a){
            array_splice($pkmnTeam, $i, 1);
        }
    }
    if($inBattle) {
        Display_Game::messageBoiteDialogue(ucfirst($pkmnTeam[0]['Name']) .', Go!',1);
    }
}
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
?>