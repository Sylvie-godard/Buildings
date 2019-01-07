<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalculateWaterSquareCommand extends Command
{
    protected static $defaultName = 'CalculateWaterSquare';
    private $tab = [];
    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::IS_ARRAY, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    //created by make:command
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if (count($arg1) < 3) {
            $io->error(sprintf("You need 3 arguments at least"));
            return;
        }

        foreach($arg1 as $arg){
            if(!ctype_digit($arg)){
                $io->error(sprintf("You need to put an integer only !"));
                return;
            }
            array_push($this->tab, intval($arg));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $result = $this->getSolution();
        echo "result: $result";
        $io->success('command status : success');
        
        
    }

    /**
     *  find a building egual or bigger than the first building
     * 
     * @param $indexStart (int) -> the index where we start
     * @return $indexSecondBuilding (int)            -> index of the Second Building
     */
    
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

    /**
     *  how much water for one building
     * 
     * @param $firstBuilding (int)   -> first building to compare
     * @param $secondBuilding (int)  -> second building to compare
     * @param $betweenBuilding (int) -> building between firstBuilding and secondBuilding
     * @return $totalwater (int)     -> totalwater for one building
     */
    public function Water($firstBuilding, $secondBuilding, $betweenBuilding){
        if($firstBuilding < $secondBuilding){
            $totalwater = $firstBuilding - $betweenBuilding;
            return $totalwater;
        }else{
            $totalwater = $secondBuilding - $betweenBuilding;
            return $totalwater;
        }
    }

    /**
     *  return all the water
     * 
     * @return $water (int) -> return all water of everybuilding
     */
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
