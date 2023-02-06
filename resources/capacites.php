<?php
$json = file_get_contents('json/capacitesv2.json');
$capacites = json_decode($json, true);


function getCapacite($name){
    global $capacites;
    if(isset($capacites[$name])){
        $capacites[$name]['PP'] = $capacites[$name]['PP Max'];
        unset($capacites[$name]['Pkmns Learned']);
        return $capacites[$name];
    }
    else return null;
}
?>