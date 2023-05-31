<?php 

function translate($sprite, $posInit, $posFinal, $time=1, $laps=0.01){
    $distance = array_map(function($a, $b) { 
        return $a - $b; 
    }, $posFinal, $posInit);
    $countToExecuteAnimation = intval($time/$laps);

    $moveXPerLaps = $distance[1]/ $countToExecuteAnimation;
    $moveYPerLaps = $distance[0]/ $countToExecuteAnimation;;

    $posY = $posInit[0];
    $posX = $posInit[1];
    for($i=0;$i<$countToExecuteAnimation; ++$i){
        $posX += $moveXPerLaps;
        $posY += $moveYPerLaps;
        // debugLog("x:$posX y:$posY \n", 0);
        // textArea("x:$posX y:$posY \n",[0,0]);
        drawSprite($sprite, [$posY,$posX]);
        usleep($laps*1000);
        if($i != $countToExecuteAnimation-1){
            clearArea(countLinesAndColumns($sprite),[$posY,$posX]);
        }
    }
}

function animationPkmnAppearinBattle($isJoueur, $pkmn /*, $animPkBall = false*/){
    clearSpritePkmn($isJoueur);
    drawSprite(getSprites('Pokeball_1'), getPosSpritePkmn($isJoueur));
    usleep(500000);
    clearSpritePkmn($isJoueur, 1);
    drawSpritePkmn($pkmn, $isJoueur);
}

function drawEntirePkmnBattle($pkmnTeam, $isJoueur){
    drawPkmnTeamHUD($pkmnTeam, getPosTeam($isJoueur));
    drawPkmnHUD(getPosHealthPkmn($isJoueur), $pkmnTeam[0]);
}

function animationCapture(){
    clearSpritePkmn(false,500000);
    drawSprite(getSprites('Pokeball_1'),getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite(getSprites('Pokeball_2'),getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite(getSprites('Pokeball_1'),getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite(getSprites('Pokeball_3'),getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite(getSprites('Pokeball_1'),getPosSpritePkmn(false));
}

//// ANIMATION ENTER BATTLE /////////////////////////////////////////////
function animationEnterBattle(){
    animationEnterSpirale();
}

function animationEnterRowByRow(){
    for($i=0;$i<6;++$i){
        for($y=0;$y<6;++$y){
            drawFullBox([5,10],[1+$i*5,1+$y*10],['█','█','█']);
            usleep(50000);
        }
    } 
}

function animationEnterSpirale(){
    $screenScale = getScreenScale();
    // Configuration de la taille du terminal
    $terminalHeight = $screenScale[0];
    $terminalWidth = $screenScale[1];

    // Position initiale de la boîte
    $boxHeight = 5;
    $boxWidth = 10;

    // Boucle pour afficher la spirale
    for ($i = 0; $i < 3; ++$i) {
        // Mouvement vers la droite
        for ($y = 0; $y < ($terminalWidth/$boxWidth)-$i; ++$y) {
            drawFullBox([$boxHeight, $boxWidth], [$boxHeight*$i, $y*$boxWidth]);
            usleep(25000);
            $lastPos = [$boxHeight*$i, $y*$boxWidth];
        }

        // Mouvement vers le bas
        for ($y = 0; $y < ($terminalHeight/$boxHeight)-$i; ++$y) {
            drawFullBox([$boxHeight, $boxWidth], [$boxHeight*$y, $terminalWidth-($i+1)*$boxWidth]);
            usleep(25000);
        }

        // Mouvement vers la gauche
        for ($y = 0; $y < ($terminalWidth/$boxWidth)-$i; ++$y) {
            drawFullBox([$boxHeight, $boxWidth], [$terminalHeight-($i+1)*$boxHeight, $terminalWidth-$boxWidth*($y+1)]);
            usleep(25000);
        }

        // Mouvement vers le haut
        for ($y = 0; $y < ($terminalHeight/$boxHeight)-$i; ++$y) {
            drawFullBox([$boxHeight, $boxWidth], [$terminalHeight-$boxHeight*($y+1), $i*$boxWidth]);
            usleep(25000);
        }
    }
}

function animationVersusLeader($spriteName){
    clearGameScreen();
    drawGameCadre();
    if(is_null($spriteName)){
        $sprite = getSprites('trainer');
    }else{
        $sprite = getSprites($spriteName);
    }

    $screenScale = getScreenScale();
    $posY = 8;
    drawBox([2,$screenScale[1]-2],[$screenScale[0]-6,2], '|','-',true,['-','-','-','-']);
    drawBox([2,$screenScale[1]-2],[$screenScale[0]-23,2], '|','-',true,['-','-','-','-']);

    $scaleSprite = countLinesAndColumns($sprite);
    $scaleSpriteVersus = countLinesAndColumns(getSprites('Versus'));

    $posInit = [$posY+1, $screenScale[1]-$scaleSprite[1]];
    $posFinal = [$posY+1, $scaleSpriteVersus[1]/2+5]; // Weird stuff

    drawSprite(getSprites('Versus'),[$posY+3,3]);
    selectColor('reset');
    translate($sprite, $posInit, $posFinal, 2);

    // TRANSITION TO GREY
    selectColor('grey');
    drawBox([2,$screenScale[1]-2],[$screenScale[0]-6,2], '|','-',true,['-','-','-','-']);
    drawBox([2,$screenScale[1]-2],[$screenScale[0]-23,2], '|','-',true,['-','-','-','-']);
    drawSprite($sprite,$posFinal);
    drawSprite(getSprites('Versus'),[$posY+3,3]);
    selectColor('reset');
    sleep(1);
    clearArea([$screenScale[0]-2,$screenScale[1]-2],[2,2]);
    
    sleep(1);
}


//// ANIAMTIONS BATTLE //////////////////////////////////////////////////

function animationCharactersEnterBattle($spriteJoueur, $spriteEnemy){
    $screenScale = getScreenScale();
    $posJoueur = getPosSpritePkmn(true);
    $posEnemy = getPosSpritePkmn(false);

    $distance = $screenScale[1]-1-getScaleSpritePkmn()[1];

    for($i=0;$i<$distance;++$i){
        drawSprite($spriteEnemy, [$posEnemy[0], 2+$i]);
        drawSprite($spriteJoueur, [$posJoueur[0], $screenScale[1]-$i-getScaleSpritePkmn()[1]]);
        usleep(1000);
        clearGameplayScreen();
    }

    drawSprite($spriteJoueur, getPosSpritePkmn(true));
    drawSprite($spriteEnemy, getPosSpritePkmn(false));
}

function animationAttack($pkmn, $isJoueur){
    $pos = getPosSpritePkmn($isJoueur);
    $decalage = $isJoueur ? 1 : -1;

    clearSpritePkmn($isJoueur);
    drawSprite(getSprites($pkmn['Sprite']),[$pos[0],$pos[1]+$decalage]);
    sleep(1);
    clearSprite([$pos[0]-1,$pos[1]+$decalage]);
    drawSpritePkmn($pkmn, $isJoueur);
}

function animationDown($pkmn, $isJoueur){
    $pos = getPosSpritePkmn($isJoueur);
    $scaleSprite = getScaleSpritePkmn();
    for($i=0;$i<3;++$i){
        clearSpritePkmn($isJoueur);
        drawSprite(getSprites($pkmn['Sprite']),$pos);

        selectColor('red');
        drawSprite(getSprites('down'), [$pos[0]+($i+1)*2+intval($scaleSprite[0]/4),$pos[1]+intval($scaleSprite[1]/2)-6]);
        selectColor('reset');
        usleep(250000);
    }
    clearSpritePkmn($isJoueur);
    drawSprite(getSprites($pkmn['Sprite']),$pos);
}

function animationUp($pkmn, $isJoueur){
    $pos = getPosSpritePkmn($isJoueur);
    $scaleSprite = getScaleSpritePkmn();
    for($i=0;$i<3;++$i){
        clearSpritePkmn($isJoueur);
        drawSprite(getSprites($pkmn['Sprite']),$pos);

        selectColor('green');
        drawSprite(getSprites('up'), [$pos[0]+$scaleSprite[0]-($i+1)*2-intval($scaleSprite[0]/4),$pos[1]+intval($scaleSprite[1]/2)-6]);
        selectColor('reset');
        usleep(250000);
    }
    clearSpritePkmn($isJoueur);
    drawSprite(getSprites($pkmn['Sprite']),$pos);
}

function animationTakeDamage($pkmn, $isJoueur){
    usleep(250000);
    clearSpritePkmn($isJoueur);
    usleep(250000);
    drawSpritePkmn($pkmn, $isJoueur);
    usleep(250000);
    clearSpritePkmn($isJoueur);
    usleep(250000);
    drawSpritePkmn($pkmn, $isJoueur);
    usleep(250000);
}
?>