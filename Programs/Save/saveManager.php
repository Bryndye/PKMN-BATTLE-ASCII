<?php

function getSaveIfExist(){ 
    if(!isSaveExist()){
        return getMainSave();
    }
    else{
        $file = file_get_contents('Save/save.json');
        $array = json_decode($file, true);

        if(!isset($array['Team'])){
            deleteSave();
            return getMainSave();
        }
        else{
            return $array;
        }
    }   
}

function getMainSave($pathFile = 'Save/save.json'){ // Team JOUEUR TEMP FCT
    createPartySave();
    $file = file_get_contents('Save/save.json');
    $array = json_decode($file, true);
    $array['Team'] = chooseFirstPokemon();
    return $array;
}

function isSaveExist($path = 'Save/save.json',$inTitle = false){
    if(file_exists($path)){
        // Si la sauvegarde est existe mais pas de Team alors delete et recommence
        if($inTitle){
            $file = file_get_contents($path);
            $array = json_decode($file, true);
    
            if(!isset($array['Team'])){
                deleteSave();
                return false;
            }
        }
        return true;
    }
    return false;
}

///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////

function mainSaveExist(){
    if(!isSaveExist('Save/myGame.json')){
        $json = [
            'name' => waitForInput([31,0], null, 'Choose your name : '),
            'Game wins' => 0,
            'IndexFloor Max' => 100,
            'Pokedex' => [],
            'wins' => 0,
            'loses' => 0
        ];
        $json = json_encode($json);
        file_put_contents('Save/myGame.json', $json);
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
function createMainSave(){
    $json = [
        'name' => waitForInput([31,0], null, 'Choose your name : '),
        'Game wins' => 0,
        'IndexFloor Max' => 100,
        'Pokedex' => [],
        'wins' => 0,
        'loses' => 0
    ];
    $json = json_encode($json);
    file_put_contents('Save/myGame.json', $json);
}
function createPartySave(){
    $json = [
        'Team' => null,
        'IndexFloor' => 1,
        'Money' => 1000,
        'Bag' => [
            [
                "name"=>"Potion", 
                "type"=>"heal",
                "effect"=>"20",
                "quantity"=>1
            ]
        ]
    ];
    $json = json_encode($json);
    file_put_contents('Save/save.json', $json);
}


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
?>