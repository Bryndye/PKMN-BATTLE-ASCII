<?php 
function animationPkmnAppearinBattle($isJoueur, $pkmn /*, $animPkBall = false*/){
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

function animationEnterBattle(){
    animationEnterSpirale();
}

function animationEnterRowByRow(){
    for($i=0;$i<6;++$i){
        for($y=0;$y<6;++$y){
            displayFullBox([5,10],[1+$i*5,1+$y*10]);
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
            displayFullBox([$boxHeight, $boxWidth], [$boxHeight*$i, $y*$boxWidth]);
            usleep(25000);
            $lastPos = [$boxHeight*$i, $y*$boxWidth];
        }

        // Mouvement vers le bas
        for ($y = 0; $y < ($terminalHeight/$boxHeight)-$i; ++$y) {
            displayFullBox([$boxHeight, $boxWidth], [$boxHeight*$y, $terminalWidth-($i+1)*$boxWidth]);
            usleep(25000);
        }

        // Mouvement vers la gauche
        for ($y = 0; $y < ($terminalWidth/$boxWidth)-$i; ++$y) {
            displayFullBox([$boxHeight, $boxWidth], [$terminalHeight-($i+1)*$boxHeight, $terminalWidth-$boxWidth*($y+1)]);
            usleep(25000);
        }

        // Mouvement vers le haut
        for ($y = 0; $y < ($terminalHeight/$boxHeight)-$i; ++$y) {
            displayFullBox([$boxHeight, $boxWidth], [$terminalHeight-$boxHeight*($y+1), $i*$boxWidth]);
            usleep(25000);
        }
    }
}
?>