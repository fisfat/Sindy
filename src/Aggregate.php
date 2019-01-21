<?php
namespace Console;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\Command;

class Aggregate extends Command
{
    
    public function configure()
    {
        $this -> setName('record')
            -> setDescription('Allows you to check a record your spending and feeding record')
            -> setHelp('This command allows you to check a record your spending and feeding record')
            -> addArgument('type', InputArgument::REQUIRED, 'The aggregate type.')
            -> addArgument('time',  InputArgument::REQUIRED, 'The aggregate time.');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this -> fetch_record($input, $output);
    }
}