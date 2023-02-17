<?php
$json = file_get_contents('json/capacitesv5.json');
$capacites = json_decode($json, true);


function getCapacite($name){
    global $capacites;
    if(isset($capacites[$name])){
        // $capacites[$name]['PP'] = $capacites[$name]['PP Max'];
        // unset($capacites[$name]['Pkmns Learned']);
        return setCapacitePlayable($capacites[$name]);
    }
    else return null;
}

function getRandCapacites(){
    global $capacites;
    $keys = array_keys($capacites);
    $randomIndex = array_rand($keys);
    $capacite = setCapacitePlayable($capacites[$keys[$randomIndex]]);
    return $capacite;
}

function setCapacitePlayable($capacite){
    $capacite['PP Max'] = $capacite['PP'];
    unset($capacite['Pkmns Learned']);
    return $capacite;
}
?>