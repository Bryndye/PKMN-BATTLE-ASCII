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
        // clearGameScreen();
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


//// ANIAMTIONS BATTLE //////////////////////////////////////////////////
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
        $sprite = getSprites('rival');
    }else{
        $sprite = getSprites($spriteName);
    }

    $screenScale = getScreenScale();
    $posY = 8;
    drawBox([getScaleSpritePkmn()[0]+4,$screenScale[1]],[$posY-1,1], '|','-', true);
    drawBox([getScaleSpritePkmn()[0]+2,$screenScale[1]],[$posY,1], '|','-', true);

    $scaleSprite = countLinesAndColumns($sprite);

    $posInit = [$posY+1, $screenScale[1]-$scaleSprite[1]];
    $posFinal = [$posY+1, $screenScale[1]-$scaleSprite[1]-10];
    drawSprite(getSprites('Versus'),[$posY+3,3]);
    // drawSprite($sprite,[$posY+1,30]);

    translate($sprite, $posInit, $posFinal, 2);

    // selectColor('grey');
    // drawSprite($sprite,[$posY+1,30]);
    // drawSprite(getSprites('Versus'),[$posY+3,3]);
    // selectColor('reset');
    // sleep(1);
    // clearArea([getScaleSpritePkmn()[0],$screenScale[1]-2],[$posY+1,2]);
    
    sleep(1);
}

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