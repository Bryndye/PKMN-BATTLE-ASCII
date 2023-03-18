<?php

// fct sert a recuperer la save ou la creer si elle nexiste pas
function getSaveIfExist(){ 
    if(!isSaveExist()){
        return setFirstSave();
    }
    else{
        $file = file_get_contents('json/save.json');
        $array = json_decode($file, true);

        if(!isset($array['Team'])){
            deleteSave();
            return setFirstSave();
        }
        else{
            return $array;
        }
    }   
}

function setFirstSave($pathFile = 'json/save.json'){ // Team JOUEUR TEMP FCT
    createSaveFights();
    $file = file_get_contents('json/save.json');
    $array = json_decode($file, true);
    $array['Team'] = chooseFirstPokemon();
    return $array;
}

function isSaveExist($path = 'json/save.json',$inTitle = false){
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

function MyGameSaveExist(){
    if(!isSaveExist('json/myGame.json')){
        $json = [
            'name' => waitForInput([31,0], null, 'Choose your name : '),
            'Game wins' => 0,
            'IndexFloor Max' => 100,
            'Pokedex' => [],
            'wins' => 0,
            'loses' => 0
        ];
        $json = json_encode($json);
        file_put_contents('json/myGame.json', $json);
    }
    else{
        $file = file_get_contents('json/myGame.json');
        $array = json_decode($file, true);

        if(!isset($array['name'])){
            deleteSave('json/myGame.json');
            createSaveMyGame();
        }
    }
}
function createSaveMyGame(){
    $json = [
        'name' => waitForInput([31,0], null, 'Choose your name : '),
        'Game wins' => 0,
        'IndexFloor Max' => 100,
        'Pokedex' => [],
        'wins' => 0,
        'loses' => 0
    ];
    $json = json_encode($json);
    file_put_contents('json/myGame.json', $json);
}
function createSaveFights(){
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
    file_put_contents('json/save.json', $json);
}

function saveFile($save, $path = 'json/save.json'){
    $array = $save;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
}

function saveData($data, $key, $path = 'json/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    $array[$key] = $data;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
    // print_r($array[$key]);
    // sleep(50);
}

function addData($data, $key, $path = 'json/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    $array[$key] += $data;
    $json = json_encode($array, true);
    file_put_contents($path, $json);
    
    // $array = json_decode($file, true);
    // print($array[$key]);
    // sleep(1);
}



function getSave($path = 'json/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    return $array;
}

function getDataFromSave($key, $path = 'json/save.json'){
    $file = file_get_contents($path);
    $array = json_decode($file, true);
    return $array[$key];
}

function deleteSave($path = 'json/save.json'){
    unlink($path);
}
?>