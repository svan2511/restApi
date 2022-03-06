<?php 

        require_once __DIR__ . '/../vendor/autoload.php';

        use Root\Classes\Users;
        use Root\Config\Database;

        // Include Headers 

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Content-type: application/json; charset=UTF-8");

        
        $dbObj = new Database();
        $user_obj = new Users( $dbObj->connect() );

        if ( $_SERVER['REQUEST_METHOD'] === "POST")
        {
           
           $user_data = json_decode( file_get_contents("php://input") );

           
                if( !empty( $user_data->name ) && !empty( $user_data->email ) && !empty( $user_data->password ) )
                {
                   
                    $user_obj->name = $user_data->name;
                    $user_obj->email = $user_data->email;
                    $user_obj->password = $user_data->password;

                    $result = $user_obj->is_uniqueMail();

                    if ( $result->num_rows > 0 )
                    {
                        http_response_code(503);
                        echo json_encode( 
                            
                            ["status" =>0 ,"messsage" => "Email Already Exist , Try with another Email." ]

                        );die;
                    }

                    if ($user_obj->user_register())
                    {
                        http_response_code(200);
                        echo json_encode( 
                            
                            ["status" =>1 ,"messsage" => "User Created Successfully." ]

                        );
                    }

                    else
                    {
                      
                        http_response_code(500);
                        echo json_encode( 
                            
                            ["status" =>0 ,"messsage" => "Some Internel Error." ]

                        );
                    }
                }
                    else
                    {
                      
                        http_response_code(500);
                        echo json_encode( 
                            
                            ["status" =>0 ,"messsage" => "All Fields Required." ]

                        );
                    }

                }

            
        else
        {
            http_response_code(503);
            echo json_encode( 
                
                ["status" =>0 ,"messsage" => "Invalid Request." ]

            );
        }

 ?>