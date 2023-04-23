<?php
//// AILMENT PROBLEM ///////////////////////////////////////
function ailmentChanceOnpKmn(&$capacite, &$pkmnDef, $isStatusCap = false){
    $ailment = $capacite['effects']['Ailment'];
    if(!is_null($pkmnDef['Status'])){
        return;
    }

    if($capacite['Category'] == 'status'){
        $pkmnDef['Status'] = status($ailment['ailment']);
        messageBoiteDialogue($pkmnDef['Name']." get ". $ailment['ailment'],1);
        return;
    }
    else if(isset($ailment['ailment_chance']) && $ailment['ailment_chance'] != 0){
        $chance = rand(0,100);
        if($chance <= $ailment['ailment_chance']){
            $pkmnDef['Status'] = status($ailment['ailment']);
            messageBoiteDialogue($pkmnDef['Name']." get ". $ailment['ailment'],1);
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
    if($mode == "capture"){
        $effect = 1;
    }
    else{
        $effect = 0;
    }
    
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
            takeDamagePkmn($pkmn, intval($pkmn['Stats']['Health Max'] * 0.06), $isJoueur);
            // $pkmn['Stats']['Health'] -= intval($pkmn['Stats']['Health Max'] * 0.06);
        }
        else if($pkmn['Status'] == 'PSN'){
            takeDamagePkmn($pkmn, intval($pkmn['Stats']['Health Max'] * 0.10), $isJoueur);
        }
        messageBoiteDialogue($pkmn['Name'] . ' takes damage from its status!',1);
        updateHealthPkmn(getPosHealthPkmn($isJoueur),$pkmn['Stats']['Health'], $pkmn['Stats']['Health Max']);
        clearBoiteDialogue();
        sleep(1);
        isPkmnDead($pkmn, $isJoueur);
    }
}
///////////////////////////////////////////////////////////
?>