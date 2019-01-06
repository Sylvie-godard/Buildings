<?php

unset($argv[0]);

if(count($argv) < 3){
    echo "To few arguments, need at least 3 arguments";
}else{

}


class Building {
    private $tab = [];
    // entire map of buildings
    public function __construct($argv){
        foreach($argv as $arg){
            array_push($this->tab, intval($arg));
        }
        return $tab;
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


    //find a building egual or bigger than the first building
    public function findOtherBuilding(){
        $firstBuilding = null;
        $secondBuilding = null;
        for($i = 0; $i < count($this->tab) ; $i++){
            if($firstBuilding == null){
                $firstBuilding = $this->tab[$i]; // set building variable
            }else{
                if($this->tab[$i] >= $firstBuilding){
                    $secondBuilding = $this->tab[$i]; 
                    return $secondBuilding;            
                }
            }
        }

        if($secondBuilding == null){
            for($i=0; $i < count($this->tab); $i++){
                if($this->tab[$i] == $firstBuilding - 1){
                    $secondBuilding = $this->tab[$i];
                    return $secondBuilding;    
                }
            }
        }
    }


    private function findSmall($first, $second){
        $value = abs($first - $second);
        return $value;
    }

    

    public function allBiggerBuildings(){
        $buildings = []; // array : buildings which are bigger than the building next to them
        for($i = 0; $i < count($this->tab) - 1; $i++){
            if($this->tab[$i+1] < $this->tab[$i]){
                array_push($buildings, $this->tab[$i]);
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

    

    //return last bigger value
    public function lastBigBuilding($tab){
        return end($tab);
    }
}

$test = new Building($argv);
$building = $test->findOtherBuilding();
var_dump($building);
?>