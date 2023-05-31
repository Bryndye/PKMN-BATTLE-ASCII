<?php

function saveMainManager(){
    // Si joueur a deja sauvegarde
    if(isSaveExist(getSavePath('myGame'))){
        $save = getSave(getSavePath('myGame'));
        adaptMainSave();
        if(!isset($save['name'])){
            deleteSave(getSavePath('myGame'));
            cinematicPresentation();
        }
        return $save;
    }
    else{
        // Si le dossier existe
        if(is_dir(getFolderSave(getParameterPathSave()))){
            return createMainSave();
        }
        else{
            // Creer le dossier sil existe pas
            mkdir(getFolderSave(getParameterPathSave()), 0777, true);
            return createMainSave();
        }
    }
}

function savePartyManager(){
    if(isSaveExist(getSavePath('save'))){
        $saveParty = getSave(getSavePath('save'));

        // Si la partie est créée mais sans pkmn starter, delete.
        if(!isset($saveParty['Team'])){
            deleteSave(getSavePath('save'));
            return createPartySave();
        }
        return $saveParty;
    }
    else{
        if(is_dir(getFolderSave(getParameterPathSave()))){
            return createPartySave();
        }
        else{
            mkdir(getFolderSave(getParameterPathSave()), 0777, true);
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
        'IndexFloor Max' => 100,
        'Pokedex' => [],
        'wins' => 0,
        'loses' => 0
    ];
    $datasMainSave['name'] = waitForInput(getPosChoice(), null, 'Choose your name : ');
    $json = json_encode($datasMainSave);
    file_put_contents(getSavePath('myGame'), $json);
    return $datasMainSave;
}

function mainSaveExist(){
    if(!isSaveExist(getSavePath('myGame'))){
        createMainSave();
    }
    else{
        $file = file_get_contents(getSavePath('myGame'));
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave(getSavePath('myGame'));
            createMainSave();
        }
    }
}

function createPartySave(){
    $datasPartySave = [
        'Team' => null,
        'Starter' => null,
        'IndexFloor' => 1,
        'Money' => 1000,
        'Bag' => [
            getItemObject('Potion',1),
            getItemObject('PokeBall',5)
        ]
    ];
    $var =  chooseFirstPokemon();
    $datasPartySave['Team'] = $var[0];
    $json = json_encode($datasPartySave);
    file_put_contents(getSavePath('save'), $json);
    setData($var[1], 'Starter', getSavePath('save')); // SECURITY STARTER IF PLAYER QUIT BEFORE SAVE
    $datasPartySave['Starter'] = $var[1]; // SAVE INTO VAR TO SAVE LATER
    return $datasPartySave;
}

//// MANAGER DATAS FROM SAVES ////////////////////////////////////

function adaptMainSave(){
    // add key and default value if doesnt exist
    $main = getSave(getSavePath('myGame'));
    if(!array_key_exists('Pokedex', $main)){
        $main['Pokedex'] = [];
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
    $path = isPathNull($path);
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    return $array[$key];
}

function deleteSave($path){
    $path = isPathNull($path);
    unlink($path);
}

function isSaveExist($path){
    $path = isPathNull($path);
    if(file_exists($path)){
        return true;
    }
    return false;
}

function isPathNull($path){
    if(is_null($path)){
        return getSavePath('save');
    }
    else{
        return $path;
    }
}
?>