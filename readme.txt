  
  (1) : Create User Api  ==> You can Register User By this Api .
     
	 URL : http://localhost/restApi/users
	 
	 METHOD : POST
	 
	 parameters : 
	 {
		 "name":"YOUR NAME",
		"email":"YOUR EMAIL",
		"password":"YOUR PASSWORD"
	 }
	 
	 
  (2) : Login Api  ==> Register User can logged in.
     
	 URL :http://localhost/restApi/login
	 
	 METHOD : POST
	 
	 parameters : 
	 {
		"email":"YOUR EMAIL",
		"password":"YOUR PASSWORD"
	 }
	 
   (3) : Posts Api  ==> Logged in users can create and see his particular posts By this Api .
   
   
       ( A )
     
	 URL : http://localhost/restApi/posts
	 
	 METHOD : GET
	 
	 parameters : Jwt Token via Headers with key 'Authorization' 
	 
   ( B )
     
	 URL : http://localhost/restApi/posts
	 
	 METHOD : POST
	 
	 parameters : Jwt Token via Headers with key 'Authorization' AND 
	 
	 {
		"title":"POST TITLE",
		"description":"POST DESCRIPTION"
	 }