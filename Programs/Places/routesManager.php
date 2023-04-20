<?php
//// FIND ROUTES AND GET ENCOUNTER ////////////////////////////////////////////////////////////////////////////

function getRouteFromIndex($indexFloor, $onlyName = false) {
    global $routes;
    foreach ($routes as $route => $details) {
        $floors = $details['Floors'];
        if ($indexFloor >= $floors[0] && $indexFloor <= $floors[1]) {
            return $onlyName ? $route : $details;
        }
    }
    return null; // Retourne null si aucun correspondance n'est trouvée
}

function generateEncounter($floorData, $chance) {
    $floorMin = $floorData['Floors'][0];
    $floorMax = $floorData['Floors'][1];

    $indexFloor = rand($floorMin, $floorMax);

    if ($indexFloor >= $floorMin && $indexFloor <= $floorMax) {
        if(isset($floorData['Trainers']) && checkAllTrainersAvailable($floorData['Trainers'])){
            $encounterType = (rand(1, 100) <= $chance) ? 'Pokemon savages' : 'Trainers';
        }
        else{
            $encounterType = 'Pokemon savages';
        }

        if ($encounterType == 'Pokemon savages') {
            $pokemonData = $floorData[$encounterType];
            $totalRate = 0;
            foreach ($pokemonData as $pokemonName => $pokemonInfo) {
                $totalRate += $pokemonInfo['rate'];
            }

            $randomNumber = rand(1, $totalRate);
            $currentRate = 0;

            foreach ($pokemonData as $pokemonName => $pokemonInfo) {
                $currentRate += $pokemonInfo['rate'];
                if ($randomNumber <= $currentRate) {
                    return [$pokemonName, $pokemonInfo['level']];
                }
            }
        } else if ($encounterType == 'Trainers') {
            $trainersData = $floorData[$encounterType];
            $trainerIndex = 0;

            while (isset($trainersData[$trainerIndex])) {
                if (!isset($trainersData[$trainerIndex]['used']) || $trainersData[$trainerIndex]['used'] == false) {
                    $trainersData[$trainerIndex]['used'] = true;
                    print($trainersData[$trainerIndex]['used']);
                    return $trainerIndex;
                }
                $trainerIndex++;
            }
        }
    }

    return null;
}
?>