<?php 

namespace Root\Classes;

class Posts 
{

    // Define Some public & private Properties 

    public $title;
    public $discription;
    public $user_id;
    
    private $connection;
    private $post_table;
  


    public function __construct( $db )
    {
        
        $this->connection = $db ;
        $this->post_table = "tbl_posts";
       
       
    }

    public function create_new_post()
    {
        $query = "INSERT INTO $this->post_table ( title, post_desc, post_user_id ) VALUES ( ?,?,?)";
        $post_obj = $this->connection->prepare($query);
        
        $post_obj->bind_param("ssi",$this->title,$this->discription,$this->user_id);
        if ( $post_obj->execute() )
        {
            return true;
            
        }
        else
        {
            return false;
        }

    }

    public function get_all_posts()
    {
        $query = "SELECT title ,post_desc FROM $this->post_table WHERE post_user_id = ? ";
        $post_obj = $this->connection->prepare($query);
        $post_obj->bind_param("i",$this->user_id);
        if ( $post_obj->execute() )
        {
            return $post_obj->get_result();
            
        }
        else
        {
            return  array();
        }
       
    }



}

?>