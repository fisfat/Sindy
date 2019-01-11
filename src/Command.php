<?php namespace Console;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Database\Connection;



class Command extends SymfonyCommand
{
    
    public function __construct()
    {
        parent::__construct();
    }
    protected function greetUser(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output -> writeln([
            '====**** SINDY IS HERE FOR YOU ****====',
            '==========================================',
            '',
        ]);
        
        // outputs a message without adding a "\n" at the end of the line
        $output -> writeln($this -> getGreeting() .', '. $input -> getArgument('username').'. '. "How can i help you?");
        $output ->writeln( "you can type './sindy --help' for you to see my functions.");
    }
    private function getGreeting()
    {
        /* This sets the $time variable to the current hour in the 24 hour clock format */
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            return "Morning";
        } else
        /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        if ($time >= "12" && $time < "17") {
            return "Afternoon";
        } else
        /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        if ($time >= "17" && $time < "19") {
            return "Evening";
        } else
        /* Finally, show good night if the time is greater than or equal to 1900 hours */
        if ($time >= "19") {
            return "Night";
        }   
        
    }

    public function tellMeTime(InputInterface $input, OutputInterface $output){
        $time = date("H:i:s");
       
        $output->write($input -> getArgument('username'). ', ' . "The time is: " . $time .  " in the " .$this->getGreeting());
    }

    public function saveMyDay(InputInterface $input, OutputInterface $output){
        $helper = $this->getHelper('question');

        $default = 'Good';
        $output_question = new Question($this->getGreeting(). ' Boss, How is your day going [' .$default. ']:', $default);
        $answer1 = $helper->ask($input, $output, $output_question);
            if($answer1){
                $default = 'yes';
                $new_output_question = new Question('Did you work today ['.$default.']?:' , $default);
                $answer2 = $helper->ask($input, $output, $new_output_question);
                if($answer2){
                    $default = 'Not bad';
                    $new_output_question = new Question('Tell me about your day ['.$default.']?:' , $default);
                    $answer3 = $helper->ask($input, $output, $new_output_question);
                    if($answer3){
                        $default = 'No';
                        $new_output_question = new Question('Did you meet someone new today ['.$default.']?:' , $default);
                        $answer4 = $helper->ask($input, $output, $new_output_question);
                        if($answer4){
                            $default = 'No';
                            $new_output_question = new Question('Did you snap today (give me the link if you did) ['.$default.']?:' , $default);
                            $answer5 = $helper->ask($input, $output, $new_output_question);
                            if($answer5){
                                $default = '100';
                                $new_output_question = new Question('How much did you spend today? [ #'.$default.' ]?:' , $default);
                                $answer6 = $helper->ask($input, $output, $new_output_question);
                                if($answer6){
                                    $default = '1';
                                    $new_output_question = new Question('How many meals did you have today? [ #'.$default.' ]?:' , $default);
                                    $answer7 = $helper->ask($input, $output, $new_output_question);
                                    if($answer7){
                                        $default = 'Yes';
                                        $new_output_question = new Question('Should i save your day? ['.$default.']?:' , $default);
                                        $answer8 = $helper->ask($input, $output, $new_output_question);
                                        if($answer8 == 'Yes'){
                                            $time = Date("l jS \of F Y h:i:s");
                                            $filename = "log.txt";
                                            $file = fopen($filename, "a");
                                            $what_to_write = '[' .$time. ']' . '-----' . $answer1 . '-----' . $answer2 . '-----' . $answer3 . '-----' . $answer4 . '-----' . $answer5 . '-----' . $answer6 .'-----' . $answer7 . "\n" ;
                                            fwrite($file, $what_to_write);
                                            fclose($file);
                                            $conn = new Connection();
                                            $conn->save($answer1, $answer2, $answer3, $answer4, $answer5, $answer6, $answer7, $time);
                                        }
                                        
                                    }

                                }
                            }
                        }
                    }
                }
            }
        $output->writeln('i\'d keep the record sir. You can ask me for it anytime. See you next time :)');
    }

    public function login(InputInterface $input, OutputInterface $output){
        $conn = new Connection();
        $username = $input -> getArgument('username');
        $helper = $this->getHelper('question');

        if(!empty($username)){
            $validity = $conn->check_username($username);
            if($validity == true){
                $question = new Question('Input your Password: ');
                $answer = $helper->ask($input, $output, $question);
                $status = $conn->login($username, $answer);
                if($status != false){
                    $_SESSION['user_id'] = $status;
                    if(isset($_SESSION['user_id'])){
                        $output->writeln('You are logged in '.$username .'. I\'m here for your service');
                    }else{
                        $output->writeln('Your details were correct but i couldn\'t create a session for you at this time');
                    }
                    
                }else{
                    $output->writeln('OOOOPS ' .$username. '. Your password is wrong. You cant access me this time.');
                }
            }else{
               $output -> writeln('The username you entered doesn\'t exist in the database. You probably mis-spelt.');
            }

        }else{
            $question = new Question('Input your Username: ');
            $answer1 = $helper->ask($input, $output, $question);
            $validity = $conn->check_username($answer1);
            if($validity == true){
                $question = new Question('Input your Password: ');
                $answer2 = $helper->ask($input, $output, $question);
                $status = $conn->login($answer1, $answer2);
                if($status != false){
                    $_SESSION['user_id'] = $status;
                    if(isset($_SESSION['user_id'])){  
                        $output->writeln('You are logged in '.$username .'. I\'m here for your service');
                    }else{
                        $output->writeln('Your details were correct but i couldn\'t create a session for you at this time');
                    }
                    
                }else{
                    $output->writeln('OOOOPS ' .$username. '. Your password is wrong. You cant access me this time.');
                }
            }else{
               $output -> writeln('<options=bold,underscore>The username you entered doesn\'t exist in the database. You probably mis-spelt.</>');                
            }
        }
    }

    public function fetch_record(){
        
    }

    public function subtract(InputInterface $input, OutputInterface $output){
        $val1 = $input -> getArgument('val1');
        $val2 = $input -> getArgument('val2');

        $value = $val1 - $val2;
        $output->writeln($value);
    }

    public function add(InputInterface $input, OutputInterface $output){
        $val1 = $input -> getArgument('val1');
        $val2 = $input -> getArgument('val2');

        $value = $val1 + $val2;
        $output->writeln($value);
    }
}