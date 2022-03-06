<?php 

namespace Root\Classes;

class Authenticate
{
    public $email;
    public $password;

    public function __construct( $db )
    {
        
        $this->connection = $db ;
        $this->user_table = "tbl_users";
       
       
    }

public function check_login()
{
    
    $query = "SELECT *  FROM $this->user_table WHERE user_email = ?";
    $auth_object = $this->connection->prepare($query);
    $auth_object->bind_param("s",$this->email);
    $auth_object->execute();
    $result = $auth_object->get_result();
    if ($result->num_rows > 0)
    {
        $user_details =  $result->fetch_assoc();

        if ( password_verify( $this->password , $user_details['user_password'] ) )
        {
         return $user_details;
        } 
        else
        {
            return 2;
        }
    } 
    else
    {
        return 3;
    }
        
}


}


?>