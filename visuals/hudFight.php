<?php
// -- HUD PKMN--
// - Afficher HUD du pkmn joueur -
// createPkmnHUD(17,34, $pkmn1);
// displaySprite($sprites[$pkmn1['Sprite']], 9, 3); 
// - Afficher HUD du pkmn ennemi -
// createPkmnHUD(2,3, $pkmn2);
// displaySprite($sprites[$pkmn2['Sprite']], 1, 35);



//// CREATE HUD INGAME //////////////////////////
function displaySkeletonHUD(){
    displayGameCadre();
    displayBoiteDialogue();
}


function displayGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy){
    clearInGame();
    displaySkeletonHUD();
    include 'visuals/sprites.php';
    
    // Afficher HUD du pkmn joueur
    refreshDisplayOnePkmn($pkmnTeamJoueur, true);
    
    // Afficher HUD du pkmn ennemi
    refreshDisplayOnePkmn($pkmnTeamEnemy, false);
}


//// DISPLAY INFO PKMN ///////////////////////////////////////////
function refreshDisplayOnePkmn(&$pkmnTeam, $isJoueur){
    include 'visuals/sprites.php';
    
    createPkmnHUD(getPosHealthPkmn($isJoueur), $pkmnTeam[0], $isJoueur);
    displaySprite($sprites[$pkmnTeam[0]['Sprite']], getPosSpritePkmn($isJoueur));
    displayPkmnTeamHUD($pkmnTeam,getPosTeam($isJoueur));
}
function refreshHUDloopFight(&$pkmnTeamJoueur ,&$pkmnTeamEnemy){
    displayPkmnTeamHUD($pkmnTeamJoueur, getPosTeam(true));
    displayPkmnTeamHUD($pkmnTeamEnemy, getPosTeam(false));
    createPkmnHUD(getPosHealthPkmn(true), $pkmnTeamJoueur[0]);
    createPkmnHUD(getPosHealthPkmn(false), $pkmnTeamEnemy[0], false);
}

function displayPkmnTeams(&$pkmnTeamJoueur, &$pkmnTeamEnemy){
    displayPkmnTeamHUD($pkmnTeamJoueur, [17,34]);
    displayPkmnTeamHUD($pkmnTeamEnemy, [7,3]);
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

function pkmnAppearinBattle($isJoueur, $pkmn /*, $animPkBall = false*/){
    include 'visuals/sprites.php';
    clearSpritePkmn($isJoueur);
    displaySprite($sprites['Pokeball_1'], getPosSpritePkmn($isJoueur));
    usleep(500000);
    clearSpritePkmn($isJoueur, 1);
    displaySpritePkmn($pkmn, $isJoueur);
}

function displayEntirePkmnBattle($pkmnTeam, $isJoueur){
    displayPkmnTeamHUD($pkmnTeam, getPosTeam($isJoueur));
    createPkmnHUD(getPosHealthPkmn($isJoueur), $pkmnTeam[0]);
}

function clearPkmnHUD($isJoueur){
    clearArea(getScaleHUDPkmn(),getPosHealthPkmn($isJoueur));
}
function createPkmnHUD($pos, $pkmn, $showExp = true){
    clearArea(getScaleHUDPkmn(),$pos);
    displayBox(getScaleHUDPkmn(),$pos,'|','-');
    echo "\033[".($pos[0]+1).";".($pos[1]+2)."H";
    echo $pkmn['Name'];
    echo "\033[".($pos[0]+1).";".($pos[1]+19)."H";
    $string = $pkmn['Status'] == null ? "Lv".$pkmn['Level'] : $pkmn['Status'];
    echo $string;
    echo "\033[".($pos[0]+2).";".($pos[1]+10)."H";
    echo '<';
    echo "\033[".($pos[0]+2).";".($pos[1]+21)."H";
    echo '>';
    updateHealthPkmn($pos, $pkmn['Stats']['Health'],$pkmn['Stats']['Health Max']);
    if($showExp){
        updateExpPkmn($pos,$pkmn['exp'], $pkmn['expToLevel']);
    }
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
function updateExpPkmn($pos,$exp, $expMax){
    $pourcentage = $exp/$expMax;

    //Set exp text
    clearArea([1,7],[$pos[0]+3,$pos[1]+3]); //clear pour eviter 
    echo "\033[".($pos[0]+3).";".($pos[1]+10)."H";
    echo '<';
    echo "\033[".($pos[0]+3).";".($pos[1]+21)."H";
    echo '>';
    
    //Set health graphic style + color
    echo "\033[".($pos[0]+3).";".($pos[1]+11)."H";
    echo "\033[34m";
    for($i=0;$i<10;++$i){
        if (($pourcentage*10) > $i){
            echo '=';
        } else {
            echo ' ';
        }
    }
    echo "\033[0m";
}

function levelUpWindow($oldStats, $newStats){
    displayBox([10,20], [7,39], '|', '-');
    $pos = [7,39];

    $keys = array_keys($oldStats);

    $differences = [];
    for($i=0;$i<count($newStats);++$i){
        array_push($differences, $newStats[$keys[$i]]-$oldStats[$keys[$i]]);
    }
    $i = 1;
    foreach($oldStats as $key=>$stat){
        writeSentence($key, [$pos[0]+$i,$pos[1]+2]);
        $phrase_alignee = str_pad($stat, 3, " ", STR_PAD_LEFT);
        moveCursor([$pos[0]+$i,$pos[1]+15]);
    
        echo $phrase_alignee;
        ++$i;
    }
    sleep(2);
    for($i=0;$i<count($newStats);++$i){
        $phrase_alignee = str_pad($differences[$i].'->', 4, " ", STR_PAD_LEFT);
        moveCursor([$pos[0]+$i+1,$pos[1]+10]);

        echo $phrase_alignee;
    }
    sleep(2);
    $i = 1;
    foreach($newStats as $key=>$stat){
        writeSentence($key, [$pos[0]+$i,$pos[1]+2]);
        $phrase_alignee = str_pad($stat, 3, " ", STR_PAD_LEFT);
        moveCursor([$pos[0]+$i,$pos[1]+15]);
    
        echo $phrase_alignee;
        ++$i;
    }
    sleep(2);
    clearArea([10,20], [7,39]);
}
    

//// DISPLAY MENU ///////////////////////////////////
function displayOffMenuTeam(&$currentPkmnJ,&$currentPkmnE){
    displayGameHUD($currentPkmnJ,$currentPkmnE);
}

function displayPkmnTeam($pkmnTeam){
    clearInGame();
    
    for($i=0;$i<count($pkmnTeam);++$i){
        // $pos = [($i * 5) - 2,33];
        $x = ($i % 2 == 0) ? 3 : 33;
        $y = ($i+1) * 3;
        $pos = [$y,$x];
        createPkmnHUD($pos, $pkmnTeam[$i]);
    }
}

// MENU INTERFACE CHOICE PLAYER
function interfaceCapacities($capacites){
    $posYInit = 25;
    $posXInit = 5;
    for($i=0;$i<4;++$i){
        if(isset($capacites[$i]['Name']))
        {
            $posY = $posYInit;
            $posX = $posXInit;
            if ($i == 1) {
                $posX = $posXInit + 20;
            }elseif ($i == 2) {
                $posY = $posY + 3;
            }elseif ($i == 3) {
                $posY = $posYInit +3;
                $posX = $posXInit +20;
            }
            limitSentence($i.' : '.$capacites[$i]['Name'],23,[$posY,$posX]);
            limitSentence('PP : '.$capacites[$i]['PP'].'/'.$capacites[$i]['PP Max'],23,[$posY+1,$posX]);
        }
    }
}

function interfaceMenu(){
    $posY = 25;
    $posX = 48;
    displayBox([7,15],[24,46]); // display line to seperate

    writeSentence( '1 : ATTACK', [$posY,$posX]);
    writeSentence('2 : PKMN', [$posY+1,$posX]);
    writeSentence('3 : BAG', [$posY+2,$posX]);
}


function animationCapture(){
    include 'visuals/sprites.php';
    clearSpritePkmn(false,500000);
    displaySprite($sprites['Pokeball_1'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    displaySprite($sprites['Pokeball_2'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    displaySprite($sprites['Pokeball_1'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    displaySprite($sprites['Pokeball_3'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    displaySprite($sprites['Pokeball_1'],getPosSpritePkmn(false));
  }
?>