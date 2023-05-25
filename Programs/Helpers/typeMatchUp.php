<?php

// Array of type effectiveness
$typeEffectiveness = [
    'normal' => [
        'rock' => 0.5,
        'ghost' => 0,
        'steel' => 0.5
    ],
    'fire' => [
        'fire' => 0.5,
        'water' => 0.5,
        'grass' => 2,
        'ice' => 2,
        'bug' => 2,
        'rock' => 0.5,
        'dragon' => 0.5,
        'steel' => 2
    ],
    'water' => [
        'fire' => 2,
        'water' => 0.5,
        'grass' => 0.5,
        'ground' => 2,
        'rock' => 2,
        'dragon' => 0.5
    ],
    'electric' => [
        'water' => 2,
        'electric' => 0.5,
        'grass' => 0.5,
        'ground' => 0,
        'flying' => 2,
        'dragon' => 0.5
    ],
    'bug' => [
        'dark' => 2,
        'psychic' => 2,
        'grass' => 2,
        'fire' => 0.5,
        'fighting' => 0.5,
        'poison' => 0.5,
        'flying' => 0.5
    ],
    'grass' => [
        'fire' => 0.5,
        'water' => 2,
        'grass' => 0.5,
        'poison' => 0.5,
        'ground' => 2,
        'flying' => 0.5,
        'bug' => 0.5,
        'rock' => 2,
        'dragon' => 0.5,
        'steel' => 0.5
    ],
    'ice' => [
        'fire' => 0.5,
        'water' => 0.5,
        'grass' => 2,
        'ice' => 0.5,
        'ground' => 2,
        'flying' => 2,
        'dragon' => 2,
        'steel' => 0.5
    ],
    'fighting' => [
        'normal' => 2,
        'ice' => 2,
        'poison' => 0.5,
        'flying' => 0.5,
        'psychic' => 0.5,
        'bug' => 0.5,
        'rock' => 2,
        'ghost' => 0,
        'dark' => 2,
        'fairy' => 0.5
    ],
    'poison' => [
        'grass' => 2,
        'poison' => 0.5,
        'ground' => 0.5,
        'rock' => 0.5,
        'ghost' => 0.5,
        'steel' => 0,
        'fairy' => 2
    ],
    'ground' => [
        'fire' => 2,
        'electric' => 2,
        'grass' => 0.5,
        'poison' => 2,
        'flying' => 0,
        'bug' => 0.5,
        'rock' => 2,
        'steel' => 2
    ],
    'flying' => [
        'electric' => 0.5,
        'grass' => 2,
        'bug' => 2
    ],
    'psychic' => [
        'fighting' => 2,
        'poison' => 2,
        'bug' => 0.5,
        'dark' => 0
    ],
    'ghost' => [
        'psychic' => 2,
        'normal' => 0,
        'bug' => 2
    ],
    'fairy' => [
        'steel' => 0.5,
        'dragon' => 2
    ],
    'dark' => [
        'psychic' => 2,
        'ghost' => 2,
        'bug' => 0.5
    ],
    'steel' =>[
        'rock' => 2,
        'steel' => 0.5,
        'fire' => 0.5,
        'water' => 0.5,
        'electric' => 0.5
    ],
    'dragon' => [
        'steel' => 0.5,
        'fairy' => 0,
        'dragon' => 2
    ]
]; 
// Function to check type matchup
function checkTypeMatchup($attackerType, $defenderType) {
    global $typeEffectiveness;
    if (isset($typeEffectiveness[$attackerType][$defenderType])) {
        return $typeEffectiveness[$attackerType][$defenderType];
    } elseif (isset($typeEffectiveness[$attackerType]) && isset($typeEffectiveness[$attackerType][$defenderType]) && $typeEffectiveness[$attackerType][$defenderType] == 1) {
        return 1;
    } else {
        return 1;
    }
}

// Example usage
// $attackerType = "fire";
// $defenderType = "grass";
// echo "The matchup between $attackerType and $defenderType is: " . checkTypeMatchup($attackerType, $defenderType);
// echo isset($typeEffectiveness["fire"]["grass"]);

?>