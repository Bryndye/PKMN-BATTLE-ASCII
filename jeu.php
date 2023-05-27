<?php
// INIT SCRIPTS
include_once 'Programs/Helpers/config.php';
include_once 'Programs/Helpers/inputs.php';

// Visuals
include_once 'Programs/Visuals/graphics.php'; 
include_once 'Resources/sprites.php';
include_once 'Programs/Visuals/hudfight.php';
include_once 'Programs/Visuals/hud.php';

// MAIN
include_once 'Programs/Places/bagManager.php'; // item avant save
include_once 'Programs/Save/saveManager.php';
include_once 'Programs/Helpers/pokemonManager.php';
include_once 'Programs/Helpers/typeMatchUp.php';
include_once 'Programs/Places/routesManager.php';
include_once 'Programs/Fight/fightSystem.php';

// PLACES
include_once 'Programs/Places/SpecificScreens.php';
include_once 'Programs/Places/hub.php';
include_once 'Programs/Places/shopManager.php';


// INIT LAST PROGRAMS
include_once 'Programs/Visuals/animations.php';
include_once 'Resources/trainersAndRoutes.php';



//// SET THE GAME ////
clear();
hideCursor();
// shell_exec('mode con: cols=60 lines=33');
// intro();
startGame();

//// GAME ////
while(true){
    menuStart();

    //Sauvegardes joueur
    $saveProfile = saveMainManager();
    $saveParty = savePartyManager();
    $pkmnTeamJoueur = &$saveParty['Team'];
    // array_push($pkmnTeamJoueur, generatePkmnBattle('eevee',10));
    giveItemFromResources($saveParty['Bag'], 'Firestone');
    giveItemFromResources($saveParty['Bag'], 'Waterstone');
    giveItemFromResources($saveParty['Bag'], 'Thunderstone');

    setData($pkmnTeamJoueur, 'Team', getSavePath('save'));

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
    giveItemFromResources($saveParty["Bag"], 'Potion', 5);
    giveItemFromResources($saveParty["Bag"], 'Revive', 5);
    giveItemFromResources($saveParty["Bag"], 'Super potion', 5);
    giveItemFromResources($saveParty["Bag"], 'PokeBall', 5);
    giveItemFromResources($saveParty["Bag"], 'MasterBall', 5);
    giveItemFromResources($saveParty["Bag"], 'Surf', 5);
    giveItemFromResources($saveParty["Bag"], 'Hyper-Beam', 5);
    giveItemFromResources($saveParty["Bag"], 'Flamethrower', 5);

    // Need to reload Trainers because Rival's starter
    generateIAs();

    // Loop gameplay if team alive
    while(true){
        // HUB
        drawHub($saveParty);

        // Doit generer la route puis IA en fct de celle-ci
        // Choix de route a la fin dune arene si plusieurs sont proposees
        
        // generer IA pkmn team
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
            setFile($saveParty, getSavePath('save'));
        }
        waitForInput(getPosChoice());


        //Ajouter condition while var global pour arreter le while
        if($IndexFloor == 94){
            cinematicLeagueEnding($saveParty);
        }
        else if($IndexFloor > $IndexFloorMax){
            cinematicEnding($saveParty);
            endGame();
            break;
        }
        // continueToFight();
    }
}
?>