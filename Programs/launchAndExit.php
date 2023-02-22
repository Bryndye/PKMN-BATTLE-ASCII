<?php
// include 'graphics.php';
function intro(){
    displayGameCadre();
    echo "\033[?25l";
    
    // Animation de * en diagonale sur l'écran
    for ($i = 0; $i < 30; $i++) {
        clearArea([28,58],[2,2]); // Efface l'écran
        // echo "\033[?25l"; //hide cursor
        echo "\033[".$i.";".($i+$i)."H";
        echo "*";
        usleep(10000); // Arrête l'exécution d'un programme durant un laps de temps
    }
    
    // Fait apparaitre un Charizard au milieu de l'écran pendant x TEMPS
    include 'visuals/sprites.php';
    animationIntro();


    // Menu titre + press pour joueur
    displayGameCadre();
    displaySprite($sprites['title'],[10,6]);
    
    // echo 'Press any to enter';
    waitForInput([25,20]);
}

function animationIntro(){
    include 'visuals/sprites.php';
    displaySprite($pokemonSprites['Charizard'],[1,2]);
    sleep(2);
    displaySprite($sprites['effectTitle'],[1,2]);
    sleep(1);
    displaySprite($sprites['effectFireTitle'],[22,53]);
    sleep(1);
    displaySprite($sprites['effectFireTitle2'],[21,4]);
    sleep(1);
}
function menuStart(){
    clearArea([28,58],[2,2]); // Efface l'écran
    displayGameCadre();
    displayBox([7,20],[5,5]);

    echo "\033[7;7H";
    echo isSaveExist('json/save.json',true) ? '1 : CONTINUE' : "1 : NEW GAME";
    echo "\033[9;7H";
    echo "2 : QUIT";
    displayStatsFromSaveToMenu();

    // Attend la selection entre 1 et 2
    $choice = waitForInput([31,0],[1,2]);
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

function displayStatsFromSaveToMenu(){
    if(isSaveExist('json/myGame.json')){
        displayBox([25,30],[3,28]);
        $save = getSave('json/myGame.json');
        writeSentence('Name : '.$save['name'], [5,30]);
        writeSentence('Wins : '.$save['wins'], [7,30]);
        writeSentence('Loses : '.$save['loses'], [9,30]);

        if(isSaveExist()){
            $saveFight = getSave();
            
            writeSentence("Money : ".$saveFight['money'], [11,30]);
            
            $y = 0;
            // writeSentence('--------- Team ----------', [11,30]);
            foreach($saveFight['team'] as $key => $pkmn){
                writeSentence($pkmn['Name']."  Lv: ".$pkmn['Level'], [13+$y,30]);
                $y +=2;
            }
        }
    }
}

function chooseFirstPokemon(){
    displayBoiteDialogue();
    messageBoiteDialogue('Choose your first Pokemon :    
1 : Bulbasaur  2 : Squirtle  3 : Charmander');
    include 'visuals/sprites.php';
    displaySprite($pokemonSprites["Cat"], [-3,16]);
    displaySprite($pokemonSprites["Cat"], [8,2]);
    displaySprite($pokemonSprites["Cat"], [8,32]);

    $choice = waitForInput([31,0], [1,2,3]);
    if($choice == 1){
        return generatePkmnBattle('bulbasaur', 15);
    }
    else if($choice == 2){
        return generatePkmnBattle('squirtle', 15);
    }
    else if($choice == 3){
        return generatePkmnBattle('charmander', 15);
    }
}
?>