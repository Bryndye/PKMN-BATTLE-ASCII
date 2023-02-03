<?php
$capacites = [
    'Tackle' => [
        'Name' => 'Tackle',
        'Type' => 'normal',
        'categorie' => 'physic',
        'Power' => 50,
        'PP Max' => 35,
        'Precision' => 100
    ],
    'Scratch' => [
        'Name' => 'Scratch',
        'Type' => 'normal',
        'categorie' => 'physic',
        'Power' => 50,
        'PP Max' => 35,
        'Precision' => 100
    ],
    'HyperBeam' => [
        'Name' => 'HyperBeam',
        'Type' => 'normal',
        'categorie' => 'physic',
        'Power' => 150,
        'PP Max' => 5,
        'Precision' => 90
    ],
    'Hydrocanon' => [
        'Name' => 'HyperBeam',
        'Type' => 'water',
        'categorie' => 'special',
        'Power' => 130,
        'PP Max' => 5,
        'Precision' => 90
    ],
    'bite' => [
        'Name' => 'bite',
        'Type' => 'normal',
        'categorie' => 'special',
        'Power' => 200,
        'PP Max' => 15,
        'Precision' => 90
    ]
];

function getCapacite($name){
    global $capacites;
    if(isset($capacites[$name])){
        $capacites[$name]['PP'] = $capacites[$name]['PP Max'];
        // print_r($capacites);
        // sleep(5);
        return $capacites[$name];
    }
    else return null;
}
?>