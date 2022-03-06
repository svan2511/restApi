<?php 

namespace Root\Config;

use mysqli;

class Database
{
    private $host;
    private $db_name;
    private $dbuser_name;
    private $dbpassword;
    private $connection;

    public function __construct()
    {
      
        $this->host = "localhost";
        $this->db_name = "rest_api";
        $this->dbuser_name = "root";
        $this->dbpassword = "";
        
    }


    public function connect()
    {
        $this->connection = new mysqli( $this->host, $this->dbuser_name, $this->dbpassword ,$this->db_name);

        // Check connection
      
        if ( $this->connection->connect_error ) 
        {
           
        die("Connection failed: " . $this->connection->connect_error);
        }
      

        return $this->connection;
    }
}


?>