<?php
// FUNCTION TO LAUNCH GAME & PLAY
// displayBox(29,60,1,1); // Cadre du jeu
// clearArea(27,58,2,2); // Efface l'écran

// CREATE HUD INGAME
function displayGameHUD($pkmn1, $pkmn2){
    clearArea([27,58],[2,2]); // Efface l'écran
    displayHUDFight();
    include 'visuals/sprites.php';

    // Afficher HUD du pkmn joueur
    createPkmnHUD(getPosHealthPkmn(true), $pkmn1, true);
    displaySprite($pokemonSprites[$pkmn1['Sprite']], getPosSpritePkmn(true));
    interfaceCapacities($pkmn1['Capacites']);
    
    // Afficher HUD du pkmn ennemi
    createPkmnHUD(getPosHealthPkmn(false), $pkmn2);
    displaySprite($pokemonSprites[$pkmn2['Sprite']], getPosSpritePkmn(false));
}
function displayHUDFight(){
    displayBox([7,60],[23,0]);
    displayBox([7,1],[23,43]);
    interfaceMenu();
}
function displayPkmnTeam($pkmnTeam, $pos){
    moveCursor($pos);
    $message = '<';
    for($i = 0; $i < 6; $i++){
        if($i < count($pkmnTeam)){
            if($pkmnTeam[$i]['Stats']['Health'] > 0){
                $message .= '0';
            }else{
                $message .= 'X';
            }
        }else{
            $message .= '-';
        }
    }
    $message .= '>';
    echo $message;
}



// https://tldp.org/HOWTO/Bash-Prompt-HOWTO/x329.html
function selectColor(){
    //\033[0m permet de remettre la couleur par defaut
    //\033[31;40m 31:rouge & 40:noir
    echo "\033[31;40mtexte rouge sur fond noir\033[0m";
}

function moveCursor($pos){
    echo "\033[".$pos[0].";".$pos[1]."H";
}   

// DISPLAY A BOX
function displayBox($scale, $pos, $styleH='*', $styleL='*'){
    moveCursor($pos);
    // echo "\033[".$pos[0].";".$pos[1]."H";
    
    for ($i = 0; $i < $scale[0]; $i++) {
        echo "\033[".$pos[0]+$i.";".$pos[1]."H";
        for ($j = 0; $j < $scale[1]; $j++) {
            if ($i == 0 || $i == $scale[0] - 1) {
                echo $styleL;
            } elseif ($j == 0 || $j == $scale[1] - 1) {
                echo $styleH;
            } else {
                echo ' ';
            }
        }
    }
}

function clearArea($scale, $pos){
    for ($i = 0; $i <  $scale[0]; $i++) {
        echo "\033[".$pos[0]+$i.";".$pos[1]."H";
        for ($j = 0; $j <  $scale[1]; $j++) {
            echo ' ';
        }
    }
}

function clear(){
    echo "\033c";
}

function displaySprite($sprite, $pos) {
    $lines = explode("\n", $sprite); // séparer les lignes du sprite
    for ($i = 1; $i < count($lines); $i++) {
        echo "\033[".$pos[0]+$i.";".$pos[1]."H";
        echo $lines[$i]; // afficher chaque ligne du sprite
        echo "\n";
    }
}

function debugLog($pos, $msg){
    moveCursor($pos);
    if(is_array($msg)){
        print_r($msg);
    }
    else{
        echo 'Debug : ' . $msg;
    }
}

// HUD PKMN
function createPkmnHUD($pos, $pkmn, $isJoueur = false){
    clearArea(getScaleHUDPkmn(),$pos);
    displayBox(getScaleHUDPkmn(),$pos,'|','-');
    echo "\033[".($pos[0]+1).";".($pos[1]+2)."H";
    echo $pkmn['Name'];
    echo "\033[".($pos[0]+1).";".($pos[1]+19)."H";
    echo "Lv".$pkmn['Level'];
    echo "\033[".($pos[0]+2).";".($pos[1]+10)."H";
    echo '<';
    echo "\033[".($pos[0]+2).";".($pos[1]+21)."H";
    echo '>';
    updateHealthPkmn(getPosHealthPkmn($isJoueur), $pkmn['Stats']['Health'],$pkmn['Stats']['Health Max']);
}   
function updateHealthPkmn($pos,$health, $healthMax){
    $pourcentage = $health/$healthMax;
    $color = '0;32';
    if($pourcentage > 0.5){
        $color = '0;32';
    }elseif($pourcentage < 0.2){
        $color = '0;31';
    }
    else{
        $color = '38;2;255;165;0';
    }
    //Set health text
    clearArea([1,7],[$pos[0]+2,$pos[1]+2]); //clear pour eviter 
    echo "\033[".($pos[0]+2).";".($pos[1]+2)."H";
    echo $health.'/'.$healthMax;
    
    //Set health graphic style + color
    echo "\033[".($pos[0]+2).";".($pos[1]+11)."H";
    echo "\033[".$color."m";
    for($i=0;$i<10;++$i){
        if (($pourcentage*10) > $i){
            echo '=';
        } else {
            echo ' ';
        }
    }
    echo "\033[0m";
}

function manageStatPkmn($pkmn1,$pkmn2, &$statOpen){
    if(!$statOpen){
        displayStatPkmn($pkmn1);
        $statOpen = true;
    }
    else{
        displayGameHUD($pkmn1,$pkmn2);
        $statOpen = false;
    }
}
function displayStatPkmn($pkmn){
    displayBox([15,20],[8,40],'|','-');
    $posY = 10;
    $posX = 40;
    $infos = array_keys($pkmn);
    for ($i = 0; $i < count($infos); $i++) {
        echo "\033[".$posY+$i.";".($posX+1)."H";
        echo $infos[$i]." : ". $pkmn[$infos[$i]];
    }
}

function messageBoiteDialogue($message){
    clearArea([5,58],[24,2]); //clear boite dialogue
    echo "\033[25;3H";
    echo $message;
    // waitForInput([30,0]);
}

function displaySpritePkmn($pkmn, $isJoueur){
    $posFinal = getPosSpritePkmn($isJoueur);
    
    include 'visuals/sprites.php';
    displaySprite($pokemonSprites[$pkmn['Sprite']], $posFinal);
}
function clearSpritePkmn($isJoueur){
    $posFinal = getPosSpritePkmn($isJoueur);
    // clear area pkmn sprite in battle
    clearArea([13,25],$posFinal);
}

// TEST HUD PLACEMENT
function interfaceCapacities($capacites){
    $posY = 24;
    $posX = 5;
    for($i=0;$i<4;++$i){
        if(isset($capacites[$i]['Name']))
        {
            if ($i == 0) {
                $posY = 24;
                $posX = 5;
            }elseif ($i == 1) {
                $posY = 24;
                $posX = 25;
            }elseif ($i == 2) {
                $posY = 27;
                $posX = 5;
            }elseif ($i == 3) {
                $posY = 27;
                $posX = 25;
            }
            $stringName = $i . ' : ';
            $stringPP = 'PP : ' ;
            if(isset($capacites[$i]['PP'])){
                $stringPP .= $capacites[$i]['PP'] . "/";
            }
            echo "\033[".($posY).";".($posX)."H";
            echo $stringName.$capacites[$i]['Name'];
            echo "\033[".($posY+1).";".($posX)."H";
            echo $stringPP.$capacites[$i]['PP Max'];
        }
    }
    // echo "\033[".($posY).";".($posX)."H";
    // echo "1 : TACKLE";
    // echo "\033[".($posY+1).";".($posX)."H";
    // echo "INFINITE PP";
    
    // ECRIRE FOR POUR GENERER LES CAPACITES QUA UN PKMN
    // echo "\033[".($posY+3).";".($posX)."H";
    // echo "3 : GROWL";
    // echo "\033[".($posY+4).";".($posX)."H";
    // echo "30/30 PP";
    
    // echo "\033[".($posY).";".($posX+20)."H";
    // echo "2 : EMBER";
    // echo "\033[".($posY+1).";".($posX+20)."H";
    // echo "10/15 PP";
    
    // echo "\033[".($posY+3).";".($posX+20)."H";
    // echo "4 : FLAMETHROWER";
    // echo "\033[".($posY+4).";".($posX+20)."H";
    // echo "8/10 PP";
}

function interfaceMenu(){
    $posY = 24;
    $posX = 46;
    echo "\033[".($posY).";".($posX)."H";
    echo "1 : ATTACK";
    
    echo "\033[".($posY+1).";".($posX)."H";
    echo "2 : STAT";
    
    echo "\033[".($posY+2).";".($posX)."H";
    echo "3 : BAG";
    
    echo "\033[".($posY+3).";".($posX)."H";
    echo "4 : RUN";
}
?>