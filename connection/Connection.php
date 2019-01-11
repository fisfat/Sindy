<?php
namespace Database;

use PDO;

    class Connection {
        public $db;
  


        public function __construct(){
      
            try{
                $this->db = new PDO("mysql:host=localhost;dbname=sindy", 'root');
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e){
                 echo 'an error occured while connecting to database' .$e->getMessage();
            }
        }

        public function save($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $time){
            try{
                $query = "INSERT INTO day (q1, q2, q3, q4, q5, q6, q7, created_at) VALUES (:q1, :q2, :q3, :q4, :q5, :q6, :q7, :created_at)";
                $stmt = $this->db->prepare($query);
                $stmt->execute(array(':q1' => $arg1, ':q2' => $arg2, ':q3' => $arg3, ':q4' => $arg4, ':q5' => $arg5, ':q6' => $arg6, 'q7'=>$arg7, ':created_at' => $time));
            }catch (PDOException $e){
                 echo 'an error occured while connecting to database' .$e->getMessage();
            }   
        }

        public function check_username($username){
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(':username' => $username));
            if($stmt -> rowCount() >= 1){
                return true;
            }else{
                return false;
            }
        }

        public function login($username, $password){
            $query = "SELECT * FROM users WHERE username = :username AND passkey = :passkey LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute(array(':username' => $username, ':passkey' => $password));
            if($stmt->rowCount() == 1){
                $row = $stmt->fetch(PDO::FETCH_BOTH);
                $id = $row[0];
                return $id;
            }else{
                return false;
            }
        }

        public function fetch_record(){
            $weekly_spending = "SELECT SUM(q6) FROM day order by id desc limit 7";
            $monthly_spending = "SELECT SUM(q6) FROM day order by id desc limit 30";

            $weekly_meal = "SELECT AVG(q7) FROM day order by id desc limit 7";
            $monthly_meal = "SELECT AVG(q7) FROM day order by id desc limit 30";

            

        }


    }