<?php
//// AILMENT PROBLEM ///////////////////////////////////////
function ailmentChanceOnPkmn(&$capacite, &$pkmn, $isStatusCap = false){
    $ailment = $capacite['effects']['Ailment'];
    if(is_null(status( $ailment['ailment']))){
        return;
    }
    $ailmentChance = $ailment['ailment_chance'] ?? 0;
    $isStatus = $capacite['Category'] == 'status';

    if(hasStatus($pkmn)){
        if($isStatus){
            messageBoiteDialogue($pkmn['Name'].' already has an ailment.',1);
        }
        return;
    }

    $isRandomAilment = !$isStatus && $ailmentChance != 0 && rand(0,100) <= $ailmentChance;

    if($isStatus || $isRandomAilment){
        if(hasStatus($pkmn)){
            messageBoiteDialogue($pkmn['Name'].' already has an ailment.',1);
            return;
        }
        if($ailment['ailment'] == 'poison'){ // reset stat temp damage per turn
            $pkmn['Stats Temp']['poisonned'] = 0;
        }
        $pkmn['Status'] = $ailment['ailment'];
        messageBoiteDialogue($pkmn['Name'].' get '. $ailment['ailment'].'!',1);
    }
    elseif($isStatusCap){
        messageBoiteDialogue('But it failed');
    }
}


function hasStatus($pkmn){
    return !is_null($pkmn['Status']);
}


function ailmentStartTurnEffect(&$pkmn){
    $ailments = [
        'paralysis' => ['chance' => 20, 'message' => 'is paralysed...'],
        'frozen' => ['chance' => 80, 'message' => 'is frozen...', 'recover_message' => 'is up!'],
        'sleep' => ['chance' => 80, 'message' => 'is sleeping...', 'recover_message' => 'is awake!'],
    ];

    $ailment = $pkmn['Status'];

    if (isset($ailments[$ailment])) {
        $isAilment = rand(0, 100) < $ailments[$ailment]['chance'];

        if ($isAilment) {
            messageBoiteDialogue($pkmn['Name'] . ' ' . $ailments[$ailment]['message'],1);
            return true;
        } elseif (isset($ailments[$ailment]['recover_message'])) {
            messageBoiteDialogue($pkmn['Name'] . ' ' . $ailments[$ailment]['recover_message'],1);
            $pkmn['Status'] = null;
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
    return null;
}

function getStatusEffect($status, $mode) {
    if($mode == 'capture'){
        $effect = 1;
    }
    else{
        $effect = 0;
    }
    
    switch($status) {
        case 'burn':
            if($mode == 'battle') {
                $effect = 0.06;
            } else if($mode == 'capture') {
                $effect = 1.5;
            }
            break;
        case 'poison':
            if($mode == 'battle') {
                $effect = 0.1;
            } else if($mode == 'capture') {
                $effect = 1.5;
            }
            break;
        case 'paralysis':
            if($mode == 'battle') {
                $effect = 'stun temp';
            } else if($mode == 'capture') {
                $effect = 2;
            }
            break;
        case 'sleep':
            if($mode == 'battle') {
                $effect = 'stun';
            } else if($mode == 'capture') {
                $effect = 2;
            }
            break;
        case 'frozen':
            if($mode == 'battle') {
                $effect = 'stun';
            } else if($mode == 'capture') {
                $effect = 2;
            }
            break;
        default:
            if($mode == 'battle') {
                $effect = '';
            } else if($mode == 'capture') {
                $effect = 1;
            }
    }
    
    return $effect;
}

function damageTurn(&$pkmn, $isJoueur){
    if($pkmn['Status'] == 'burn' || $pkmn['Status'] == 'poison'){

        if($pkmn['Status'] == 'burn'){
            takeDamagePkmn($pkmn, intval($pkmn['Stats']['Health Max'] * getStatusEffect($pkmn['Status'], 'battle')), $isJoueur);
        }

        else if($pkmn['Status'] == 'poison'){
            $pkmn['Stats Temp']['poisonned'] += getStatusEffect($pkmn['Status'], 'battle');
            takeDamagePkmn($pkmn, intval($pkmn['Stats']['Health Max'] * $pkmn['Stats Temp']['poisonned']), $isJoueur);
        }
        messageBoiteDialogue($pkmn['Name'] . ' takes damage from its status!',1);
        updateHealthPkmn($pkmn['Stats']['Health'], $pkmn['Stats']['Health Max'], $isJoueur);
        sleep(1);
        isPkmnDead($pkmn, $isJoueur);
    }
}
?>