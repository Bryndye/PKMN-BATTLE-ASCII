<?php

function saveMainManager(){
    // Si joueur a deja sauvegarde
    if(isSaveExist(Parameters::getSavePath('myGame'))){
        $save = getSave(Parameters::getSavePath('myGame'));
        adaptMainSave();
        if(!isset($save['name'])){
            deleteSave(Parameters::getSavePath('myGame'));
            cinematicPresentation();
        }
        return $save;
    }
    else{
        // Si le dossier existe
        if(is_dir(Parameters::getFolderSave(Parameters::getParameterPathSave()))){
            return createMainSave();
        }
        else{
            // Creer le dossier sil existe pas
            mkdir(Parameters::getFolderSave(Parameters::getParameterPathSave()), 0777, true);
            return createMainSave();
        }
    }
}

function savePartyManager(){
    if(isSaveExist(Parameters::getSavePath('save'))){
        $saveParty = getSave(Parameters::getSavePath('save'));

        // Si la partie est créée mais sans pkmn starter, delete.
        if(!isset($saveParty['Team'])){
            deleteSave(Parameters::getSavePath('save'));
            return createPartySave();
        }
        return $saveParty;
    }
    else{
        if(is_dir(Parameters::getFolderSave(Parameters::getParameterPathSave()))){
            return createPartySave();
        }
        else{
            mkdir(Parameters::getFolderSave(Parameters::getParameterPathSave()), 0777, true);
            return createPartySave();
        }
    }
}


///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////

function createMainSave(){
    $datasMainSave = [
        'name' => null,
        'Game wins' => 0,
        'IndexFloor Max' => Parameters::getIndexFloorMaxOriginal(),
        'Pokedex' => [],
        'wins' => 0,
        'loses' => 0
    ];
    $datasMainSave['name'] = waitForInput(Parameters::getPosChoice(), null, 'Choose your name : ');
    $json = json_encode($datasMainSave);
    file_put_contents(Parameters::getSavePath('myGame'), $json);
    return $datasMainSave;
}

function mainSaveExist(){
    if(!isSaveExist(Parameters::getSavePath('myGame'))){
        createMainSave();
    }
    else{
        $file = file_get_contents(Parameters::getSavePath('myGame'));
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave(Parameters::getSavePath('myGame'));
            createMainSave();
        }
    }
}

function createPartySave(){
    $datasPartySave = [
        'Team' => null,
        'Starter' => null,
        'IndexFloor' => 1,
        'Money' => 3000,
        'Bag' => [
            getItemObject('Potion',5),
            getItemObject('PokeBall',10)
        ]
    ];
    $var =  chooseFirstPokemon();
    $datasPartySave['Team'] = $var[0];
    if(isPkmnAlreadyCatch('mew')){
        array_push($datasPartySave['Team'], generatePkmnBattle('mew',5));
        Display_Game::messageBoiteDialogue("You've discovered Mew, so I've decided you can have it.",-1);
    }
    $json = json_encode($datasPartySave);
    file_put_contents(Parameters::getSavePath('save'), $json);
    setData($var[1], 'Starter', Parameters::getSavePath('save')); // SECURITY STARTER IF PLAYER QUIT BEFORE SAVE
    $datasPartySave['Starter'] = $var[1]; // SAVE INTO VAR TO SAVE LATER
    return $datasPartySave;
}

//// MANAGER DATAS FROM SAVES ////////////////////////////////////

function adaptMainSave(){
    // add key and default value if doesnt exist
    $main = getSave(Parameters::getSavePath('myGame'));
    if(!array_key_exists('Pokedex', $main)){
        $main['Pokedex'] = [];
    }
    if(array_key_exists('IndexFloor Max', $main) && $main['IndexFloor Max'] < Parameters::getIndexFloorMaxOriginal()){
        $main['IndexFloor Max'] = Parameters::getIndexFloorMaxOriginal();
    }
}

//////////////////////////////////////////////////////////////////
//// CUSTOM FUNCTIONS SAVE ///////////////////////////////////////
function setFile($save, $path){
    $path = isPathNull($path);
    $array = $save;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
}

function setData($data, $key, $path){
    $path = isPathNull($path);
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    $array[$key] = $data;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
}

function addData($data, $key, $path){
    $path = isPathNull($path);
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    $array[$key] += $data;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
}


function getSave($path){
    $path = isPathNull($path);
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    return $array;
}

function getDataFromSave($key, $path){
    // $path = isPathNull($path);
    // CustomFunctions::debugLog(file_exists(Parameters::getFolderSave()));
    if(file_exists(Parameters::getFolderSave(Parameters::getParameterPathSave())) == false){
        // CustomFunctions::debugLog('NON');
        return null;
    }
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    if(!array_key_exists($key, $array)){
        return null;
    }
    return $array[$key];
}

function deleteSave($path){
    // $path = isPathNull($path);
    unlink($path);
}

function isSaveExist($path){
    if(!file_exists(Parameters::getFolderSave(Parameters::getParameterPathSave()))){
        return false;
    }
    if(file_exists($path)){
        return true;
    }
    return false;
}

function isPathNull($path){
    if(is_null($path)){
        return Parameters::getSavePath('save');
    }
    else{
        return $path;
    }
}
?>