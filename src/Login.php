<?php
    namespace Console;

    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;
    use Console\Command;

    class Login extends Command {
        public function configure()
    {
        $this -> setName('login')
                -> setDescription('Start a session for a reegistered User.')
                -> setHelp('This command creates a session for you')
                -> addArgument('username', InputArgument::OPTIONAL, 'The registered username of the user.');
    }

        public function execute( InputInterface $input, OutputInterface $output){
                $this -> login($input, $output);
        }
    } 
    

?>