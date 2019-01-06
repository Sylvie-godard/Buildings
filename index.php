<?php

unset($argv[0]);

if(count($argv) < 3){
    echo "To few arguments, need at least 3 arguments";
}else{

}


class Carre {
    //fonction pour voir si le carré suivant est inférieur au carré précédent

    public function __construct(){

    }

    private function findSmall($first, $second){
        $value = abs($first - $second);
        return $value;
    }

    // array whith all values
    public function entireBuilding($argv){
        $tab = [];
        foreach($argv as $arg){
            array_push($tab, intval($arg));
        }
        return $tab;
    }

    public function allBiggerBuildings($argv){
        $tab = $this->entireBuilding($argv);
        $buildings = []; // array : buildings which are bigger than the building next to them
        $lasValue = end($tab);
        for($i = 0; $i < count($tab) - 1; $i++){
            if($tab[$i+1] < $tab[$i]){
                array_push($buildings, $tab[$i]);
            } 
        }
        return $buildings;
    }


    public function allSmallBuildings($argv){
        $tab = $this->entireBuilding($argv);
        $buildings = []; // array : buildings which are bigger than the building next to them
        $lasValue = end($tab);
        for($i = 0; $i < count($tab) - 1; $i++){
            if($tab[$i+1] < $tab[$i]){
                array_push($buildings, $tab[$i+1]);
            } 
        }
        return $buildings;
    }


    // return position (id) of a value from a table
    public function position($value, $tab){
        for($i = 0; $i < count($tab); $i++){
            if($value == $tab[$i]){
                $key = array_search($value, $tab);
                return $key;
            }
        }
    }

    //return last bigger value
    public function lastBigBuilding($tab){
        return end($tab);
    }
    
}

$test = new Carre;
$allBuildings = $test->entireBuilding($argv);
$bigBuildings = $test->allBiggerBuildings($argv);
$last = $test->lastBigBuilding($bigBuildings);

$smallBuildings = $test->allSmallBuildings($argv);
var_dump($last);
// var_dump($bigBuildings);
// var_dump($smallBuildings);
// $lastBigValues = $test->lastBigBuilding()

?>