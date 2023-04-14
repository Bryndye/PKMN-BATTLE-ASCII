<?php
// -- HUD PKMN--
// - Afficher HUD du pkmn joueur -
// createPkmnHUD(17,34, $pkmn1);
// drawSprite($sprites[$pkmn1['Sprite']], 9, 3); 
// - Afficher HUD du pkmn ennemi -
// createPkmnHUD(2,3, $pkmn2);
// drawSprite($sprites[$pkmn2['Sprite']], 1, 35);



//// CREATE HUD INGAME //////////////////////////
function drawSkeletonHUD(){
    drawGameCadre();
    drawBoiteDialogue();
}


function drawGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy){
    clearGameScreen();
    drawSkeletonHUD();
    include 'Resources/sprites.php';
    
    // Afficher HUD du pkmn joueur
    refreshdrawOnePkmn($pkmnTeamJoueur, true);
    
    // Afficher HUD du pkmn ennemi
    refreshdrawOnePkmn($pkmnTeamEnemy, false);
}


//// draw INFO PKMN ///////////////////////////////////////////
function refreshdrawOnePkmn(&$pkmnTeam, $isJoueur){
    include 'Resources/sprites.php';
    
    createPkmnHUD(getPosHealthPkmn($isJoueur), $pkmnTeam[0], $isJoueur);
    drawSprite($sprites[$pkmnTeam[0]['Sprite']], getPosSpritePkmn($isJoueur));
    drawPkmnTeamHUD($pkmnTeam,getPosTeam($isJoueur));
}
function refreshHUDloopFight(&$pkmnTeamJoueur ,&$pkmnTeamEnemy){
    drawPkmnTeamHUD($pkmnTeamJoueur, getPosTeam(true));
    drawPkmnTeamHUD($pkmnTeamEnemy, getPosTeam(false));
    createPkmnHUD(getPosHealthPkmn(true), $pkmnTeamJoueur[0]);
    createPkmnHUD(getPosHealthPkmn(false), $pkmnTeamEnemy[0], false);
}

function drawPkmnTeams(&$pkmnTeamJoueur, &$pkmnTeamEnemy){
    drawPkmnTeamHUD($pkmnTeamJoueur, [17,34]);
    drawPkmnTeamHUD($pkmnTeamEnemy, [7,3]);
}

function drawPkmnTeamHUD($pkmnTeam, $pos){
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



function clearPkmnHUD($isJoueur){
    clearArea(getScaleHUDPkmn(),getPosHealthPkmn($isJoueur));
}
function createPkmnHUD($pos, $pkmn, $showExp = true){
    clearArea(getScaleHUDPkmn(),$pos);
    drawBox(getScaleHUDPkmn(),$pos,'|','-');

    textArea($pkmn['Name'], [$pos[0]+1, $pos[1]+2]);
    $displayLevel = $pkmn['Status'] == null ? "Lv".$pkmn['Level'] : $pkmn['Status'];
    textArea($displayLevel, [$pos[0]+1, $pos[1]+19]);
    textArea('<          >', [$pos[0]+2, $pos[1]+10]);

    updateHealthPkmn($pos, $pkmn['Stats']['Health'],$pkmn['Stats']['Health Max']);
    if($showExp){
        updateExpPkmn($pos,$pkmn['exp'], $pkmn['expToLevel']);
    }
}   
function updateHealthPkmn($pos,$health, $healthMax){
    $pourcentage = $health/$healthMax;

    //Set health text
    clearArea([1,7],[$pos[0]+2,$pos[1]+2]); //clear pour eviter 
    textArea($health.'/'.$healthMax,[$pos[0]+2,$pos[1]+2] );
    
    //Set health graphic style + color
    moveCursor([$pos[0]+2,$pos[1]+11]);
    
    
    if($pourcentage > 0.5){
        selectColor('green');
    }elseif($pourcentage < 0.2){
        selectColor('orange');
    }
    else{
        selectColor('red');
    }
    for($i=0;$i<10;++$i){
        if (($pourcentage*10) > $i){
            echo '=';
        } else {
            echo ' ';
        }
    }
    selectColor('reset');
}
function updateExpPkmn($pos,$exp, $expMax){
    $pourcentage = $exp/$expMax;

    //Set exp text
    clearArea([1,7],[$pos[0]+3,$pos[1]+3]); //clear pour eviter 
    textArea('<          >', [$pos[0]+3, $pos[1]+10]);

    //Set health graphic style + color
    moveCursor([$pos[0]+3,$pos[1]+11]);
    selectColor('blue');
    for($i=0;$i<10;++$i){
        if (($pourcentage*10) > $i){
            echo '=';
        } else {
            echo ' ';
        }
    }
    selectColor('reset');
}

function levelUpWindow($oldStats, $newStats){
    drawBox([10,20], [7,39], '|', '-');
    $pos = [7,39];

    $keys = array_keys($oldStats);

    $differences = [];
    for($i=0;$i<count($newStats);++$i){
        array_push($differences, $newStats[$keys[$i]]-$oldStats[$keys[$i]]);
    }
    $i = 1;
    foreach($oldStats as $key=>$stat){
        textArea($key, [$pos[0]+$i,$pos[1]+2]);
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
        textArea($key, [$pos[0]+$i,$pos[1]+2]);
        $phrase_alignee = str_pad($stat, 3, " ", STR_PAD_LEFT);
        moveCursor([$pos[0]+$i,$pos[1]+15]);
    
        echo $phrase_alignee;
        ++$i;
    }
    sleep(2);
    clearArea([10,20], [7,39]);
}
    

//// draw MENU ///////////////////////////////////

function drawPkmnTeam($pkmnTeam){
    clearGameScreen();
    
    for($i=0;$i<count($pkmnTeam);++$i){
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
            textAreaLimited($i.' : '.$capacites[$i]['Name'],23,[$posY,$posX]);
            textAreaLimited('PP : '.$capacites[$i]['PP'].'/'.$capacites[$i]['PP Max'],23,[$posY+1,$posX]);
        }
    }
}

function interfaceMenu(){
    $posY = 25;
    $posX = 48;
    drawBox([7,15],[24,46]); // draw line to seperate

    textArea( '1 : ATTACK', [$posY,$posX]);
    textArea('2 : PKMN', [$posY+1,$posX]);
    textArea('3 : BAG', [$posY+2,$posX]);
}
?>