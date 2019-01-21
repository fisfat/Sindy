<?php
    namespace Console;
    use Symfony\Component\Console\Input\ArrayInput;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Input\InputOption;
    use Symfony\Component\Console\Output\OutputInterface;
    use Console\Command;

    class DailyQuestion extends Command{
        public function configure(){
            $this -> setName('save-my-day')
                    -> setDescription('Sindy asks you about your day')
                    -> setHelp('This command will prompt sindy to ask you about your day.');

        }

        public function execute(InputInterface $input, OutputInterface $output)
        {
            // $command = $this->getApplication()->find('login');
            // $arguments = array(
            //     'command' => 'login',
            // );
            // $greetInput = new ArrayInput($arguments);
            // $returnCode = $command->run($greetInput, $output);
                $this -> saveMyDay($input, $output);
            
        }
    }
    
?>