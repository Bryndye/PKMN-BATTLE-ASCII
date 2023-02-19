<?php
// INIT SCRIPTS
include_once 'launchAndExit.php';
include_once 'resources/inputs.php';
include_once 'resources/config.php';
include_once 'resources/pokemonList.php';
include_once 'resources/typeMatchUp.php';
include_once 'visuals/graphics.php'; 
include_once 'visuals/sprites.php';
include_once 'fightSystem.php';
include_once 'visuals/hudfight.php';
include_once 'resources/programFight.php';
include_once 'resources/iaProgram.php';
include_once 'shopEchange.php';

clear(); // Clear the screen
// intro(); // INTRO & MENU START
echo "\033[?25l"; // hide cursor
// shell_exec('mode con: cols=60 lines=32');
// init team battle : Le joueur a une team "fixe" 
$pkmnTeamJoueur = [
    generatePkmnBattle('mewtwo', 10),
    generatePkmnBattle(25, 50),
    generatePkmnBattle(54, 50),
    generatePkmnBattle(68, 50),
    generatePkmnBattle(19, 50),
    generatePkmnBattle(27, 50)
];
// print_r($pkmnTeamJoueur[0]);
// sleep(10);
// Loop fight tant que Equipe joueur a des pkmn en vie (a creer condition)
while(true){
    // generer IA pkmn team
    // $pkmnTeamEnemy = generatePkmnTeam();
    $pnj = generatePNJ(0, $pkmnTeamJoueur[0]['Level']);
    startFight($pkmnTeamJoueur, $pnj);
}
// $pkmnTest = generatePkmnBattle(1,10);

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