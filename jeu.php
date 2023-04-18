<?php
// INIT SCRIPTS
include_once 'Resources/config.php';
include_once 'Resources/inputs.php';
include_once 'Programs/Visuals/graphics.php'; 
include_once 'Resources/sprites.php';
include_once 'Programs/Visuals/hudfight.php';

include_once 'Programs/Places/itemsManager.php'; // item avant save
include_once 'Programs/Save/saveManager.php';
include_once 'Programs/Visuals/hud.php';
include_once 'Resources/Pokemons/pokemonList.php';
include_once 'Resources/Pokemons/typeMatchUp.php';


include_once 'Programs/Places/SpecificScreens.php';
include_once 'Programs/Places/hub.php';
include_once 'Programs/Places/shop.php';

include_once 'Programs/Fight/fightSystem.php';
include_once 'Programs/Places/routesManager.php';

include_once 'Programs/Visuals/animations.php';



//// SET THE GAME ////
clear();
echo "\033[?25l"; // hide cursor
// shell_exec('mode con: cols=60 lines=32');
// intro();
// startGame();

//// GAME ////
while(true){
    menuStart();
    //Sauvegardes joueur
    $saveProfile = saveMainManager();
    $saveParty = savePartyManager();
    $pkmnTeamJoueur = &$saveParty['Team'];
    setData($pkmnTeamJoueur, 'Team');

    if(array_key_exists('IndexFloor', $saveParty)){
        $IndexFloor = $saveParty['IndexFloor'];
    }
    else{
        $IndexFloor = 1;
    }
    if(array_key_exists('IndexFloor Max', $saveProfile)){
        $IndexFloorMax = $saveProfile['IndexFloor Max'];
    }
    else{
        $IndexFloorMax = 100;
    }
    
    // item TEMP
    // giveItemFromResources($saveParty["Bag"], 'Potion', 5);
    // giveItemFromResources($saveParty["Bag"], 'Revive', 5);
    // giveItemFromResources($saveParty["Bag"], 'Super potion', 5);
    // giveItemFromResources($saveParty["Bag"], 'PokeBall', 5);
    // giveItemFromResources($saveParty["Bag"], 'MasterBall', 5);
    generateIAs();
    // Loop gameplay if team alive
    while(true){
        // HUB
        drawHub($saveParty);

        // generer IA pkmn team
        // regarder abord si pnj script existe sinon route
        
        $pnj = generatePNJ($IndexFloor, $pkmnTeamJoueur[0]['Level']);
        startFight($saveParty, $pnj);


        // Screen end turn floor
        if(!isTeamPkmnAlive($pkmnTeamJoueur)){
            screenLose();
            break;
        }
        else{
            ++$IndexFloor;
            $saveParty['IndexFloor'] = $IndexFloor;
            setFile($saveParty);
        }
        waitForInput([31,0]);

        if($IndexFloor == 94){
            cinematicLeagueEnding($saveParty);
        }
        else if($IndexFloor > $IndexFloorMax){
            cinematicEnding($saveParty);
            endGame();
            break;
        }
        continueToFight();
    }
}
?>