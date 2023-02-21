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

clear(); // Clear the screen
// intro(); // INTRO & MENU START
echo "\033[?25l"; // hide cursor

// shell_exec('mode con: cols=60 lines=32');
// init team battle : Le joueur a une team "fixe" 
$save = getSaveIfExist();
// print_r(count($save['team']));
// sleep(50);
$pkmnTeamJoueur = &$save['team'];

// Loop fight tant que Equipe joueur a des pkmn en vie (a creer condition)
while(true){
    // generer IA pkmn team
    // $pkmnTeamEnemy = generatePkmnTeam();
    $pnj = generatePNJ(0, $pkmnTeamJoueur[0]['Level']);
    startFight($pkmnTeamJoueur, $pnj);
    if(!isTeamPkmnAlive($pkmnTeamJoueur)){
        deleteSave();
        break;
    }
    else{
        saveData($pkmnTeamJoueur, 'team');
    }
}
// Choisir nouveau Pkmn ajout a lequipe
// waitForInput([30,0]);
// wantNewPkmn();

// FIN DU JEU 
// Clear the screen
clear();

displayBox([5,30],[12,25]);
echo "\033[14;35H";
echo "END";
sleep(2);
echo "\033c";

?>