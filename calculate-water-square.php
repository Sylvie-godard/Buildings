<?php

unset($argv[0]);

if(ver)
if(count($argv) < 3){
    die("To few arguments, need at least 3 arguments");
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

    //find a building egual or bigger than the first building
    public function findIndexSecondBuilding($indexStart){
        $firstBuilding = null;
        $indexFirstBuilding = null;
        $indexSecondBuilding = null;
        for($i = $indexStart; $i < count($this->tab) ; $i++){
            if($indexFirstBuilding == null && $firstBuilding == null){
                $firstBuilding = $this->tab[$i]; // set building variable
            }else{
                if($this->tab[$i] >= $firstBuilding){
                    $indexSecondBuilding = $i; // second building >= firstbuilding
                    return $indexSecondBuilding;            
                }
            }
        }

        // find the bigger building 
        if($indexSecondBuilding == null){
            $currentIndex = null;
            for($i = $indexStart + 1; $i < count($this->tab); $i++){
                if($currentIndex == null){
                    $currentIndex = $i;
                }else if($this->tab[$i] >= $this->tab[$currentIndex]){
                    $currentIndex = $i;
                }
            }
            return $currentIndex;
        }
    }

    // how much water for one building
    public function Water($firstBuilding, $secondBuilding, $betweenBuilding){
        if($firstBuilding < $secondBuilding){
            $totalwater = $firstBuilding - $betweenBuilding;
            return $totalwater;
        }else{
            $totalwater = $secondBuilding - $betweenBuilding;
            return $totalwater;
        }
    }


    // return all the water
    public function getSolution(){
        $water = 0;
        $indexSecondBuilding = 0;
        for($i = 0; $i < count($this->tab); $i++){
            $i = $indexSecondBuilding;
            $indexSecondBuilding = $this->findIndexSecondBuilding($i);
            for($j = $i + 1; $j < $indexSecondBuilding; $j++){
                $water += $this->Water($this->tab[$i], $this->tab[$indexSecondBuilding], $this->tab[$j]);
            }
        }
        return $water;
    }
}

$test = new Building($argv);

$indexSecBuild = $test->findIndexSecondBuilding(0);
$autre = $test->getSolution();
var_dump($autre);
var_dump($indexSecBuild);
?>