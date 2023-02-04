<?php
// FUNCTION TO LAUNCH GAME & PLAY
// displayBox(29,60,1,1); // Cadre du jeu
// clearArea(27,58,2,2); // Efface l'écran

// CREATE HUD INGAME
function displayGameHUD($pkmn1, $pkmn2){
    displayGameCadre();
    clearArea([27,58],[2,2]); // Efface l'écran
    displayHUDFight();
    include 'visuals/sprites.php';

    // Afficher HUD du pkmn joueur
    createPkmnHUD(getPosHealthPkmn(true), $pkmn1);
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
function displayPkmnTeamHUD($pkmnTeam, $pos){
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


// HUD PKMN
function createPkmnHUD($pos, $pkmn){
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
    updateHealthPkmn($pos, $pkmn['Stats']['Health'],$pkmn['Stats']['Health Max']);
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
    
// -- DOIT CHANGER LES PARAM A INTEGRER
function manageStatPkmn(&$currentPkmnJ,&$currentPkmnE,&$pkmnTeamJoueur,&$statOpen){
    if(!$statOpen){
        displayPkmnTeam($pkmnTeamJoueur, $currentPkmnJ);
        $statOpen = true;
    }
    else{
        displayGameHUD($currentPkmnJ,$currentPkmnE);
        $statOpen = false;
    }
}
function displayPkmnTeam(&$pkmnTeam, &$currentPkmn){
    clearInGame();
    createPkmnHUD([13,3], $currentPkmn);

    for($i=1;$i<count($pkmnTeam);++$i){
        $pos = [($i * 5) - 2,33];
        createPkmnHUD($pos, $pkmnTeam[$i]);
    }
    $arrayChoice = [];
    for($i=0;$i<count($pkmnTeam);++$i){
        array_push($arrayChoice, ($i));
    }
    array_push($arrayChoice, 'c');
    $choice = waitForInput(getPosChoice(),$arrayChoice);
    // -- DOIT CREER LE CHOIX DE REVENIR AU COMBAT
    // if($choice == 'c'){
    //     manageStatPkmn();
    // }
    displayStatPkmn($pkmnTeam[$i]);
}
// DISPLAY STAT FOR ONE PKMN
function displayStatPkmn(&$pkmn){
    clearInGame();
    displayBox([15,20],[8,40],'|','-');
    moveCursor([10,10]);
    // echo $pkmn['Name'];
    print_r($pkmn);

    // -- DOIT CREER LE CHOIX DE REVENIR AU MENU DISPLAYTEAMPKMN
    $choice = waitForInput(getPosChoice(),$arrayChoice);
    if($choice == 'c'){
        manageStatPkmn();
    }
    // $posY = 10;
    // $posX = 40;
    // $infos = array_keys($pkmn);
    // for ($i = 0; $i < count($infos); $i++) {
    //     echo "\033[".$posY+$i.";".($posX+1)."H";
    //     echo $infos[$i]." : ". $pkmn[$infos[$i]];
    // }
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
}

function interfaceMenu(){
    $posY = 24;
    $posX = 46;
    echo "\033[".($posY).";".($posX)."H";
    echo "1 : ATTACK";
    
    echo "\033[".($posY+1).";".($posX)."H";
    echo "2 : PKMN";
    
    echo "\033[".($posY+2).";".($posX)."H";
    echo "3 : BAG";
    
    echo "\033[".($posY+3).";".($posX)."H";
    echo "4 : RUN";
}
?>