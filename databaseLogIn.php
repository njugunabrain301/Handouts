<?php

class connection{
    private $server = "localhost";
    protected $database ="handouts";
    private $charset ="utf8";
    private $username = "root";
    private $pwd = "";
    
    protected function connect(){
     try {
        $dsn= "mysql:host=".$this->server.";dbname=".$this->database.";charset".$this->charset;

        $pdo_conn= new PDO($dsn, $this->username, $this->pwd);

        $pdo_conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


        return $pdo_conn;
            
        } 
        catch (PDOException $e) {
            echo "Connection Failed: ". $e->getMessage();
            die;
            
        }   
    }
    
    public function encode($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}     
?>