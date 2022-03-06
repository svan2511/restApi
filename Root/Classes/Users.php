<?php 

namespace Root\Classes;

class Users 
{

    // Define Some public & private Properties 

    public $name;
    public $email;
    public $password;

    private $connection;
    private $user_table;
    


    public function __construct( $db )
    {
        
        $this->connection = $db ;
        $this->user_table = "tbl_users";
       
    }

    public function user_register()
    {
        $query = "INSERT INTO $this->user_table ( user_fname, user_email, user_password ) VALUES ( ?,?,?)";
        $user_object = $this->connection->prepare($query);

        // Sainitize Variables 
        $name = htmlspecialchars( $this->name, ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars( $this->email, ENT_QUOTES, 'UTF-8');
        $pass = htmlspecialchars( $this->password, ENT_QUOTES, 'UTF-8');
        $user_pass = password_hash( $pass, PASSWORD_DEFAULT);
        
        $user_object->bind_param("sss", $name , $email, $user_pass);
        if ( $user_object->execute() )
        {
            return true;
            
        }
        else
        {
            return false;
        }

    }

    public function is_uniqueMail()
    {
        $query = "SELECT * FROM $this->user_table WHERE user_email = ?";
        $user_object = $this->connection->prepare($query);
        $user_object->bind_param("s",$this->email);
        if ( $user_object->execute() )
        {
            return $user_object->get_result();
            
        }
        else
        {
            return false;
        }

    }

  


}

?>