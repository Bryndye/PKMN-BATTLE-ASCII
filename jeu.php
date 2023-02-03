<?php
// INIT SCRIPTS
include_once 'launchAndExit.php';
include_once 'resources/inputs.php';
include_once 'resources/config.php';
include_once 'visuals/graphics.php'; 
include_once 'visuals/sprites.php';
include_once 'resources/pokemonList.php';
include_once 'fightSystem.php';
include_once 'resources/typeMatchUp.php';
include_once 'shopEchange.php';

clear(); // Clear the screen
intro(); // INTRO & MENU START

// init team battle : Le joueur a une team "fixe" 
// enemy a une team genere proceduralement 
$pkmnTeamJoueur = [
    generatePkmnBattle('25', 50),
    generatePkmnBattle('25', 5)
];
$pkmnTeamEnemy = [
    generatePkmnBattle('19', 100),
    generatePkmnBattle('20', 100),
    generatePkmnBattle('19', 100)
];
// print_r($pkmnTeamJoueur);
// sleep(500);
// Loop fight tant que Equipe joueur a des pkmn en vie (a creer condition)
// while(true){
//     // generer IA pkmn team
// print_r($pkmnTeamJoueur);
// print_r($pkmnTeamJoueur[0]['Capacites'][0]['Name']);
// sleep(500);
    startFight($pkmnTeamJoueur, $pkmnTeamEnemy);
// }
// $pkmnTest = generatePkmnBattle(1,10);
// print_r($pkmnTest);
// waitForInput([30,0]);
// Choisir nouveau Pkmn ajout a lequipe
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