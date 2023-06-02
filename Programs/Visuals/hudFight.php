<?php
// -- HUD PKMN--
// - Afficher HUD du pkmn joueur -
// drawPkmnHUD(17,34, $pkmn1);
// drawSprite($sprites[$pkmn1['Sprite']], 9, 3); 
// - Afficher HUD du pkmn ennemi -
// drawPkmnHUD(2,3, $pkmn2);
// drawSprite($sprites[$pkmn2['Sprite']], 1, 35);



//// CREATE HUD INGAME //////////////////////////
function drawSkeletonHUD(){
    drawGameCadre();
    drawBoiteDialogue();
}


function drawGameHUD($pkmnTeamJoueur, $pkmnTeamEnemy){
    clearGameScreen();
    drawSkeletonHUD();

    // Afficher HUD du pkmn joueur
    drawPkmnSideHUD($pkmnTeamJoueur, true);
    
    // Afficher HUD du pkmn ennemi
    drawPkmnSideHUD($pkmnTeamEnemy, false);
}


//// draw INFO PKMN ///////////////////////////////////////////
function drawPkmnSideHUD(&$pkmnTeam, $isJoueur){  
    drawPkmnHUD(getPosHealthPkmn($isJoueur), $pkmnTeam[0], $isJoueur);
    drawSprite(getSprites($pkmnTeam[0]['Sprite']), getPosSpritePkmn($isJoueur));
    drawPkmnTeamHUD($pkmnTeam,getPosTeam($isJoueur));
}

function drawPkmnTeamHUD($pkmnTeam, $pos){
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
    textArea($message, $pos);
}



function clearPkmnHUD($isJoueur){
    clearArea(getScaleHUDPkmn(),getPosHealthPkmn($isJoueur));
}

function drawPkmnHUD($pos, $pkmn, $isJoueur = true){
    clearArea(getScaleHUDPkmn(),$pos);
    drawBox(getScaleHUDPkmn(),$pos,'|','-', true);

    textArea($pkmn['Name'], [$pos[0]+1, $pos[1]+2]);
    $displayLevel = $pkmn['Status'] == null ? "Lv".$pkmn['Level'] : status($pkmn['Status']);
    textArea($displayLevel, [$pos[0]+1, $pos[1]+19]);
    textArea('<          >', [$pos[0]+2, $pos[1]+10]);

    updateHealthPkmn($pkmn['Stats']['Health'],$pkmn['Stats']['Health Max'], $isJoueur, $pos);
    if($isJoueur){
        updateExpPkmn($pos,$pkmn['exp'], $pkmn['expToLevel']);
    }
} 

function updateHealthPkmn($health, $healthMax, $isJoueur = true, $pos=null){
    $pourcentage = $health/$healthMax;
    if(is_null($pos)){
        $pos = getPosHealthPkmn($isJoueur);
    }
    //Set health text
    clearArea([1,7],[$pos[0]+2,$pos[1]+2]); //clear pour eviter 
    if($isJoueur){
        textArea($health.'/'.$healthMax,[$pos[0]+2,$pos[1]+2] );
    }
    
    //Set health graphic style + color
    moveCursor([$pos[0]+2,$pos[1]+11]);
    
    
    if($pourcentage > 0.5){
        selectColor('green');
    }elseif($pourcentage < 0.2){
        selectColor('red');
    }
    else{
        selectColor('orange');
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
    drawBox([10,20], [7,39]);
    $pos = [7,39];

    $keys = array_keys($oldStats);

    $differences = [];
    for($i=0;$i<count($newStats);++$i){
        array_push($differences, $newStats[$keys[$i]]-$oldStats[$keys[$i]]);
    }
    // $i = 1;
    // foreach($oldStats as $key=>$stat){
    //     textArea($key, [$pos[0]+$i,$pos[1]+2]);
    //     $phrase_alignee = str_pad($stat, 3, " ", STR_PAD_LEFT);
    //     textArea($phrase_alignee, [$pos[0]+$i,$pos[1]+15]);
    //     ++$i;
    // }
    displayStats($oldStats, $pos);

    // sleep(2);
    waitForInput();
    for($i=0;$i<count($newStats);++$i){
        $phrase_alignee = str_pad($differences[$i].'->', 4, " ", STR_PAD_LEFT);
        textArea($phrase_alignee, [$pos[0]+$i+1,$pos[1]+10]);
    }
    waitForInput();
    $i = 1;
    clearArea([6,6], [$pos[0]+1,$pos[1]+10]);
    displayStats($newStats, $pos);
    // foreach($newStats as $key=>$stat){
    //     textArea($key, [$pos[0]+$i,$pos[1]+2]);
    //     $phrase_alignee = str_pad($stat, 3, " ", STR_PAD_LEFT);
    //     textArea($phrase_alignee, [$pos[0]+$i,$pos[1]+15]);
    //     ++$i;
    // }
    waitForInput();
    clearArea([10,20], [7,39]);
}
 
function displayStats($stats, $pos){
    $i = 1;
    foreach($stats as $key=>$stat){
        textArea($key, [$pos[0]+$i,$pos[1]+2]);
        $phrase_alignee = str_pad($stat, 3, " ", STR_PAD_LEFT);
        textArea($phrase_alignee, [$pos[0]+$i,$pos[1]+15]);
        ++$i;
    }
}

//// draw MENU ///////////////////////////////////

function drawPkmnTeam($pkmnTeam){
    clearGameScreen();
    
    for($i=0;$i<count($pkmnTeam);++$i){
        $x = ($i % 2 == 0) ? 3 : 33;
        $y = ($i+1) * 3;
        $pos = [$y,$x];
        drawPkmnHUD($pos, $pkmnTeam[$i]);
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
            textAreaLimited(($i+1).' : ',23,[$posY,$posX]);
            getColorByType($capacites[$i]['Type']);
            textAreaLimited($capacites[$i]['Name'],23,[$posY,$posX+4]);
            selectColor('reset');
            textAreaLimited('PP : '.$capacites[$i]['PP'].'/'.$capacites[$i]['PP Max'],23,[$posY+1,$posX]);
        }
    }
}

function interfaceMenu(){
    $screenScale = getScreenScale();
    $posYInit = $screenScale[0] - 6;
    $posXInit = $screenScale[1] - 14;
    $posY = $screenScale[0] - 5;
    $posX = $screenScale[1] - 12;
    drawBox([7,15],[$posYInit,$posXInit]); // cadre des choix

    textArea( '1 : ATTACK', [$posY,$posX]);
    textArea('2 : PKMN', [$posY+1,$posX]);
    textArea('3 : BAG', [$posY+2,$posX]);
}
?>