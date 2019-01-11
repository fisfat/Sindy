<?php
namespace Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\Command;

class Add extends Command{
    public function configure(){
        $this->setName('add')
        -> setDescription('Basic addition arithmetic')
        -> setHelp('This command allows you to do Basic addition arithmetic')
        -> addArgument('val1', InputArgument::REQUIRED, 'first value')
        -> addArgument('val2', InputArgument::REQUIRED, 'second value');
    }

    public function execute(InputInterface $input, OutputInterface $output){
        $this->add($input, $output);
    }
}