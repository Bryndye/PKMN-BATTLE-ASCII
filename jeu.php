<?php
// INIT SCRIPTS
include_once 'Programs/saveManager.php';
include_once 'Programs/launchAndExit.php';
include_once 'resources/inputs.php';
include_once 'resources/config.php';
include_once 'resources/pokemonList.php';
include_once 'resources/typeMatchUp.php';
include_once 'visuals/graphics.php'; 
include_once 'visuals/sprites.php';
include_once 'Programs/fightSystem.php';
include_once 'visuals/hudfight.php';
include_once 'Programs/programFight.php';
include_once 'Programs/iaProgram.php';
include_once 'Programs/shopEchange.php';
include_once 'Programs/itemsManager.php';


//// SET THE GAME ////
clear(); // Clear the screen
echo "\033[?25l"; // hide cursor
// shell_exec('mode con: cols=60 lines=32');

// intro();

startGame();

//// GAME ////
while(true){
    menuStart();

    //Sauvegardes joueur
    $save = getSaveIfExist();
    $pkmnTeamJoueur = &$save['Team'];
    saveData($pkmnTeamJoueur, 'Team');


    // Loop fight tant que Equipe joueur a des pkmn en vie
    if(array_key_exists('IndexFloor', $save)){
        $IndexFloor = $save['IndexFloor'];
    }
    else{
        $IndexFloor = 1;
    }
    giveItem($save["Bag"], 'Revive', 5);
    giveItem($save["Bag"], 'Super potion', 5);
    giveItem($save["Bag"], 'PokeBall', 5);

    while(true){
        // generer IA pkmn team
        $pnj = generatePNJ($IndexFloor, $pkmnTeamJoueur[0]['Level']);
        startFight($save, $pnj);

        if(!isTeamPkmnAlive($pkmnTeamJoueur)){
            addData(1, 'loses', 'json/myGame.json');
            deleteSave();
            break;
        }
        else{
            ++$IndexFloor;
            addData(1, 'wins', 'json/myGame.json');
            addData($IndexFloor, 'IndexFloor', 'json/myGame.json');
            saveData($pkmnTeamJoueur, 'Team');
        }
        // Choisir nouveau Pkmn ajout a lequipe
        waitForInput([31,0]);
        // wantNewPkmn();
        
        // wild pokemon ou pokemon a donner
    }
    // voulez vous continuez a jouer ? 
    // si non save et break boucle
}




// FIN DU JEU 
clear();

displayBox([5,30],[12,25]);
echo "\033[14;35H";
echo "END";
sleep(2);
echo "\033c";

?>