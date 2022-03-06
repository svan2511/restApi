<?php 

        require_once __DIR__ . '/../vendor/autoload.php';

        use Firebase\JWT\JWT;
        use Root\Classes\Authenticate;
        use Root\Config\Database;

        // Include Headers 

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Content-type: application/json; charset=UTF-8");

        
        $dbObj = new Database();
        $auth_obj = new Authenticate( $dbObj->connect() );

        if ( $_SERVER['REQUEST_METHOD'] === "POST")
        {

           $user_data = json_decode( file_get_contents("php://input") );

         

                if( !empty( $user_data->email ) && !empty( $user_data->password ) )
                {
                   
                    
                    $auth_obj->email = $user_data->email;
                    $auth_obj->password = $user_data->password;

                    $user_details = $auth_obj->check_login();
                    if ( $user_details === 2 )
                    {
                        http_response_code(503);
                            echo json_encode( 
                                
                                ["status" => 0 ,"messsage" => "Invalid Password." ]
    
                            );
                    }
                    else if ( $user_details === 3 )
                    {
                        http_response_code(503);
                            echo json_encode( 
                                
                                ["status" => 0 ,"messsage" => "Email Not Exist." ]
    
                            );
                    }
                    else
                    {
                        $iat = time();
                        $secrate_key = "USERTESTAPI";
                        $payload = [
                            "iss" => "localhost",
                            "aud" => "user-login-api",
                            "iat" => $iat,
                            "nbf" => $iat + 10,
                            "exp" => $iat + 760,
                            "user_data" => [
                                "id" => $user_details['user_id'],
                                "firstname" => $user_details['user_fname'],
                                "email" =>$user_details['user_email']
                            ]
                            ];

                       $jwt_token =  JWT::encode($payload,$secrate_key,"HS256");

                        http_response_code(200);
                            echo json_encode( 
                                
                                ["status" => 1 ,"messsage" => "Login Successfully.","jwt_token" => $jwt_token, ]
    
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