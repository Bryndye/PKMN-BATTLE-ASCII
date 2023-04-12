<?php

function saveMainManager(){
    if(isSaveExist('Save/myGame.json')){
        return getSave('Save/myGame.json');
    }
    else{
        if(is_dir('Save')){
            return createMainSave();
        }
        else{
            mkdir('Save', 0777, true);
            return createMainSave();
        }
    }
}

function savePartyManager(){
    if(isSaveExist('Save/save.json')){
        $saveParty = getSave();
        // Si la partie est créée mais sans pkmn starter, delete.
        if(!isset($saveParty['Team'])){
            deleteSave();
            return createPartySave();
        }
        return $saveParty;
    }
    else{
        if(is_dir('Save')){
            return createPartySave();
        }
        else{
            mkdir('Save', 0777, true);
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
    $datasMainSave['name'] = waitForInput([31,0], null, 'Choose your name : ');
    $json = json_encode($datasMainSave);
    file_put_contents('Save/myGame.json', $json);
    return $datasMainSave;
}

function mainSaveExist(){
    if(!isSaveExist('Save/myGame.json')){
        createMainSave();
    }
    else{
        $file = file_get_contents('Save/myGame.json');
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave('Save/myGame.json');
            createMainSave();
        }
    }
}

function createPartySave(){
    $datasPartySave = [
        'Team' => null,
        'IndexFloor' => 1,
        'Money' => 1000,
        'Bag' => [
            getItemObject('Potion',1),
            getItemObject('PokeBall',5)
        ]
    ];

    $datasPartySave['Team'] = chooseFirstPokemon();
    $json = json_encode($datasPartySave);
    file_put_contents('Save/save.json', $json);
    return $datasPartySave;
}

//////////////////////////////////////////////////////////////////
//// CUSTOM FUNCTIONS SAVE ///////////////////////////////////////
function saveFile($save, $path = 'Save/save.json'){
    $array = $save;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
}

function saveData($data, $key, $path = 'Save/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    $array[$key] = $data;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
}

function addData($data, $key, $path = 'Save/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    $array[$key] += $data;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
}


function getSave($path = 'Save/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    return $array;
}

function getDataFromSave($key, $path = 'Save/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    return $array[$key];
}

function deleteSave($path = 'Save/save.json'){
    unlink($path);
}

function isSaveExist($path = 'Save/save.json'){
    if(file_exists($path)){
        return true;
    }
    return false;
}
?>