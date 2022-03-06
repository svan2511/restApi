<?php 

        require_once __DIR__ . '/../vendor/autoload.php';

        use Firebase\JWT\JWT;
        use Firebase\JWT\Key;
        use Root\Classes\Posts;
        use Root\Config\Database;

        // Include Headers 

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST,GET");
        header("Content-type: application/json; charset=UTF-8");

        
        $dbObj = new Database();
        $post_obj = new Posts( $dbObj->connect() );

        if ( $_SERVER['REQUEST_METHOD'] === "POST" || $_SERVER['REQUEST_METHOD'] === "GET" )
        {

           //$user_data = json_decode( file_get_contents("php://input") );
           $user_data = getallheaders();

           $secrate_key = "USERTESTAPI";

                if( !empty( $user_data['Authorization'] ) )
                {

                  
                    try 
                    {
                        $decoded_data = JWT::decode( $user_data['Authorization'] , new Key($secrate_key, 'HS256'));
                        
                    }

                    catch ( Exception $ex )
                    {
                        http_response_code(500);
                        echo json_encode( 
                            
                            ["status" =>0 ,"messsage" => $ex->getMessage()]

                        );
                        die;
                    }

                    if ( $_SERVER['REQUEST_METHOD'] === "POST" )
                    {
                       
                        $post_data = json_decode( file_get_contents("php://input") );


                        if( !empty( $post_data->title ) && !empty( $post_data->description ) )
                        {
                            
                       
                        $post_obj->discription = $post_data->description;
                        $post_obj->title = $post_data->title;
                        $post_obj->user_id = $decoded_data->user_data->id;
                        if ( $post_obj->create_new_post() )
                        {
                            http_response_code(200);
                            echo json_encode( 
                            
                            ["status" =>1 ,"messsage" => "Post Created Successfully"]

                        );

                        }
                        else
                        {
                            http_response_code(500);
                            echo json_encode( 
                            
                            ["status" =>0 ,"messsage" => "Some Internel Error"]

                        );

                        }

                        }
                        else
                        {
                            http_response_code(500);
                            echo json_encode( 
                            
                            ["status" =>0 ,"messsage" => "All Field Required ."]

                        );
                        die;
                        }
                    }

                    if ( $_SERVER['REQUEST_METHOD'] === "GET" )
                    {
                        $post_obj->user_id = $decoded_data->user_data->id;
                        $result = $post_obj->get_all_posts();
                        if ($result->num_rows > 0 )
                        {
                            $allPosts =[];
                            while( $row = $result->fetch_assoc())
                            {
                                $allPosts[] = $row;
                            }
                            http_response_code(200);
                                echo json_encode( 
                                
                                ["status" =>1 ,"messsage" => "You Have $result->num_rows Posts .",'posts' =>$allPosts]
    
                            );
                        }
                        else
                        {
                            http_response_code(200);
                            echo json_encode( 
                            
                            ["status" =>1 ,"messsage" => "No Posts Found."]

                        );

                        }
                        
                    }
    
                }
                    else
                    {
                      
                        http_response_code(500);
                        echo json_encode( 
                            
                            ["status" =>0 ,"messsage" => "Token Required ." ]

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