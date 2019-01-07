<?php

// Variable pour que le programme soit plus verbeux (a associer avec --verbose)
// Set le a false pour l'enlever
$IF_VERBOSE = true;

/**
 * Fonction qui sert a trouver le prochain immeuble qui :
 *  - est plus grand OU de la meme taille que notre immeuble actuel
 *  - si il n'y a plus d'immeuble plus grand OU de la meme taille que nous, on va chercher le plus grand de ceux qui reste
 * @param $start : Index du tableau de notre immeuble actuel
 * @param $arrayBuildings : Tableau des immeubles (original)
 * @return int : l'index du prochain immeuble
 */
function findNextBuildingToTreat($start, $arrayBuildings)
{
    $curSize = $arrayBuildings[$start]; // Taille de notre immeuble de depart

    $nextSize = -1;
    $nextIndex = -1;

    // On creer une boucle qui part de notre index de depart + 1, jusqu'a la fin du tableau des immeubles
    for ($i = $start + 1; $i < sizeof($arrayBuildings); $i++) {
        if ($arrayBuildings[$i] >= $curSize) {
            return $i;
        } else if ($arrayBuildings[$i] > $nextSize) {
            $nextSize = $arrayBuildings[$i];
            $nextIndex = $i;
        }
    }

    global $IF_VERBOSE;
    if ($IF_VERBOSE === true) {
        echo "[DEBUG] Find next Building to treat, START:" . $start . ", NEXT: " . $nextIndex . "\n";
    }
    return $nextIndex;
}


/**
 * Calcul le nombre d'eau entre 2 immeuble par leur index
 * @param $start : index du premier immeuble du tableau a traiter
 * @param $end : index du dernier immeuble du tableau a traiter
 * @param $arrayBuildings : tableau des immeubles (original)
 * @return int: nombre de carree d'eau entre les 2 immeubles
 */
function calculateRemainingWater($start, $end, $arrayBuildings)
{
    if ($arrayBuildings[$start] >= $arrayBuildings[$end]) {
        $max = $arrayBuildings[$end];
    } else {
        $max = $arrayBuildings[$start];
    }

    $remainingWater = 0;
    for ($i = $start; $i < $end; $i++) { // ici, notre boucle va parcourir les elements du tableau qui sont entre le debut et fin (exclus)
        $water = $max - $arrayBuildings[$i];
        if ($water > 0) {
            $remainingWater += $water;
        }
    }

    global $IF_VERBOSE;
    if ($IF_VERBOSE === true) {
        echo "[DEBUG] WATER :" . $remainingWater . " between START:" . $start . ", END: " . $end . "\n";
    }
    return $remainingWater;
}

/**
 * Calcul le nombre d'eau restant par rapport au immeubles
 * @param $buildings : tableau des immeubles
 * @return int: nombre de carree d'eau restant
 */
function getSolution($buildings)
{
    if (sizeof($buildings) < 3) {
        return -1;
    }

    global $IF_VERBOSE;
    if ($IF_VERBOSE === true) {
        echo "[DEBUG] Buildings composition: " . join("|", $buildings) . "\n";
    }
    $currentIndex = 0; // on commence a l'index 0 de notre tableau
    $nextBuildingIndex = 0;
    $totalWater = 0;
    while ($nextBuildingIndex < sizeof($buildings) - 1) { // Tant que le prochain building n'est pas le dernier du tableau
        $nextBuildingIndex = findNextBuildingToTreat($currentIndex, $buildings);
        $totalWater += calculateRemainingWater($currentIndex, $nextBuildingIndex, $buildings);
        $currentIndex = $nextBuildingIndex; // On place notre position actuelle au prochain immeuble et on reboucle jusqu'a ce qu'on arrive au dernier immeuble
    }
    return $totalWater;
}


// main

// JE commente pour le moment, car on est en debug

/*if($argc < 4) {
    echo ("At Least 3 arguments");
    exit(1);
} else {
    unset($argv[0]);
    $result = getSolution(...$argv);
}*/

// Partie Debug
function debugGetSolution($args, $solution)
{
    $res = getSolution($args);
    if ($res == $solution) {
        echo "OK\n";
    } else {
        echo "NOK! Attendu: " . $solution . "; Recu: ", $res . "\n";
    }
}

debugGetSolution([6, 4, 6, 2, 8, 2, 4, 1, 2, 1], 9);
debugGetSolution([6, 1, 9, 5, 8, 3, 4, 1], 9);
debugGetSolution([8, 1, 1, 1, 8], 21);
// ETC
debugGetSolution([3, 2], -1); // return -1 si moins de 3 arguments

