<?php

// fct sert a recuperer la save ou la creer si elle nexiste pas
function getSaveIfExist(){ 
    if(!file_exists('json/save.json')){
        return setFirstSave();
    }
    else{
        $file = file_get_contents('json/save.json');
        $array = json_decode($file, true);

        if(!isset($array['team'])){
            deleteSave();
            return setFirstSave();
        }
        else{
            return $array;
        }
    }   
}

function setFirstSave(){ // TEAM JOUEUR TEMP FCT
    createSave();
    $file = file_get_contents('json/save.json');
    $array = json_decode($file, true);
    $array['team'][0] = chooseFirstPokemon();

    // $pkmnTeamJoueur = [
    //     generatePkmnBattle('mewtwo', 10),
    //     generatePkmnBattle(25, 50),
    //     generatePkmnBattle(54, 50),
    //     generatePkmnBattle(68, 50),
    //     generatePkmnBattle(19, 50),
    //     generatePkmnBattle(27, 50)
    // ];
    return $array;
}

///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
function createSave(){
    $json = [
        'name' => 'test',
        'team' => null,
        'money' => 1000,
        'items' => [
            'potion' => 5
        ]
    ];
    $json = json_encode($json);
    file_put_contents('json/save.json', $json);
}

function saveData($data, $key){
    $file = file_get_contents('json/save.json');
    $array = json_decode($file, true);
    $array[$key] = $data;
    $json = json_encode($array, true);
    file_put_contents('json/save.json', $json);
    // print_r($array[$key]);
    // sleep(50);
}

function getDataFromSave($key){
    $file = file_get_contents('json/save.json');
    $array = json_decode($file, true);
    return $array[$key];
}

function deleteSave(){
    unlink('json/save.json');
}
?>