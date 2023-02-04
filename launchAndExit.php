<?php
// include 'graphics.php';
function intro(){
    displayGameCadre();
    echo "\033[?25l";
    
    // Animation de * en diagonale sur l'écran
    for ($i = 0; $i < 30; $i++) {
        clearArea([27,58],[2,2]); // Efface l'écran
        echo "\033[?25l"; //hide cursor
        echo "\033[".$i.";".($i+$i)."H";
        echo "*";
        usleep(10000); // Arrête l'exécution d'un programme durant un laps de temps
    }
    
    // Fait apparaitre un Charizard au milieu de l'écran pendant x TEMPS
    include 'visuals/sprites.php';
    animationIntro();


    // Menu titre + press pour joueur
    clearArea([27,58],[2,2]); // Efface l'écran
    echo displaySprite($sprites['title'],[10,6]);
    
    // echo "\033[25;20H";
    // echo 'Press any to enter';
    waitForInput([25,20]);

    // Lance le menu après être passé par l'intro
    menuStart();
}

function animationIntro(){
    include 'visuals/sprites.php';
    echo displaySprite($pokemonSprites['Charizard'],[1,2]);
    sleep(2);
    echo displaySprite($sprites['effectTitle'],[1,2]);
    sleep(1);
    echo displaySprite($sprites['effectFireTitle'],[21,53]);
    sleep(1);
    echo displaySprite($sprites['effectFireTitle2'],[20,4]);
    sleep(1);
}
function menuStart(){
    clearArea([27,58],[2,2]); // Efface l'écran
    displayBox([7,20],[5,5]);
    echo "\033[7;7H";
    echo "1 : NEW GAME";
    echo "\033[9;7H";
    echo "2 : QUIT";
    // Attend la selection entre 1 et 2
    $choice = waitForInput([30,0],[1,2]);
    if($choice == 2){
        exitGame();
    }
    displayBox([29,60],[1,1]); // Cadre du jeu
    clearArea([27,58],[2,2]); // Efface l'écran
}
function exitGame(){
    echo "\033c";
    exit();
}
?>