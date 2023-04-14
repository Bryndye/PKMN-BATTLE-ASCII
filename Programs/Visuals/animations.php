<?php 
function animationPkmnAppearinBattle($isJoueur, $pkmn /*, $animPkBall = false*/){
    include 'Resources/sprites.php';
    clearSpritePkmn($isJoueur);
    drawSprite($sprites['Pokeball_1'], getPosSpritePkmn($isJoueur));
    usleep(500000);
    clearSpritePkmn($isJoueur, 1);
    drawSpritePkmn($pkmn, $isJoueur);
}

function drawEntirePkmnBattle($pkmnTeam, $isJoueur){
    drawPkmnTeamHUD($pkmnTeam, getPosTeam($isJoueur));
    createPkmnHUD(getPosHealthPkmn($isJoueur), $pkmnTeam[0]);
}

function animationCapture(){
    include 'Resources/sprites.php';
    clearSpritePkmn(false,500000);
    drawSprite($sprites['Pokeball_1'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite($sprites['Pokeball_2'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite($sprites['Pokeball_1'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite($sprites['Pokeball_3'],getPosSpritePkmn(false));
    clearSpritePkmn(false,500000);
    drawSprite($sprites['Pokeball_1'],getPosSpritePkmn(false));
}


//// ANIAMTIONS BATTLE //////////////////////////////////////////////////
function animationEnterBattle(){
    animationEnterSpirale();
}

function animationEnterRowByRow(){
    for($i=0;$i<6;++$i){
        for($y=0;$y<6;++$y){
            drawFullBox([5,10],[1+$i*5,1+$y*10]);
            usleep(50000);
        }
    } 
}

function animationEnterSpirale(){
    // Configuration de la taille du terminal
    $terminalHeight = 30;
    $terminalWidth = 60;

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

function animationCharactersEnterBattle($spriteJoueur, $spriteEnemy){
    // include 'Resources/sprites.php';
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
?>