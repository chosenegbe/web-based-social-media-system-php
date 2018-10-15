
<?php include("connect/connect.php");
session_start();
$user = "";
if(!isset($_SESSION["userlogin"])){
	$user ="";
	
}else{
	//header("location: homepage.php");
	
}
  $user =@$_SESSION["userlogin"];
 
 	/*This is to get the number of rows of poke messages*/
	$get_unread_query = mysql_query("SELECT opened FROM pvt_messages WHERE user_to ='$user' AND opened = 'no'");
	$get_unread_rows = mysql_fetch_assoc($get_unread_query);
	$unread_numrows = mysql_num_rows($get_unread_query);
	
 	/*Get the number of friend requests*/
	$get_number_of_friends = mysql_query("SELECT * FROM friend_requests WHERE  user_to = '$user' ");
	$get_friend_row = mysql_fetch_assoc($get_number_of_friends );
	$friend_requests_count = mysql_num_rows($get_number_of_friends);
		
	
 
 
?>
<!doctype html>
<html lang ="en">
<head>
    <meta charset="utf-8" />
    <title>UConnect</title>
  	<meta name="viewport" content ="width-device=width,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <link rel="stylesheet" type="text/css" href="css/mainstyle1.css" />
   
    <link rel="stylesheet" type="text/css" href="css/registerForm.css" />
    <link rel="stylesheet" type="text/css" href="cssHomePage/homepage.css" />
    <link rel="stylesheet" type ="text/css" href="css/chatSider.css" />

 
    <!--JQuery UI libraries-->
	<link href="jqueryuicustom/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="jqueryuicustom/jquery-ui.min.css" />
    <link rel="stylesheet" href="jqueryuicustom/jquery-ui.structure.css" />
    <link rel="stylesheet" href="jqueryuicustom/jquery-ui.structure.min.css" />
    <link rel="stylesheet" href="jqueryuicustom/jquery-ui.theme.css" />
    <link rel="stylesheet" href="jqueryuicustom/jquery-ui.theme.min.css" />
    <script type="text/javascript" src="jqueryuicustom/external/jquery/jquery.js"></script>
    <script type="text/javascript" src="jqueryuicustom/jquery-ui.min.js"></script> 
    <script type="text/javascript" src="jqueryuicustom/jquery-ui.js"></script>
	<script type="text/javascript" src ="http://jqueryui.com/themeroller/themeswitchertool/"></script>   
    
	
	<!--Script for country, chat sider and date of birth-->
	<script type="text/javascript" src="js/dateOfBirth.js"></script>   
 	<script type="text/javascript" src="js/countries.js"></script>
    <script type="text/javascript" src="js/scriptSider.js"></script> 
    
    <!--Javascript for registration validation-->
    <script type="text/javascript" src="ValidateRegistration/jsForValidation/validateRegistration.js"></script>  
    
    <!--Javascript for background image on index page--> 
   	<script type="text/javascript" src="js/jsForBackgroundIndexPage/script.js"></script>
    
    

    	
</head>

<body>
     <div class="headerMenu">
     	 <div id="wrapper">
         	<div class="logo">
            	<img src="img/logo/logo.png" />
            </div>
            <div class="search_box">
            	<form action="search.php" method="GET" id="search">
                	<!--<input type="text" placeholder="search" name ="query_search"  size="60"/>-->
                </form>
            </div>
 <?php 
   if($user){
	   
	    echo '	
            <div id="menu">
				<a href="'.$user.'">'.$user.' Profile</a> 
				<a href="myfeed.php" />Home</a>';
            
           if($unread_numrows >= 1)  { 
                echo'
       			  <a href="inbox.php" />Messages<span class= "unreadMessage"></span></a> ';
               } 
               else if($unread_numrows == 0){
                  echo '<a href="inbox.php" />Messages<span class= "unreadMessage"></span></a> ';
               }
          if($friend_requests_count >= 1){
              echo' <a href="friend_requests_system.php" />Friend Request<span class="displayFriendRequest">'.$friend_requests_count.'</span></a> ';
              }
              else if($friend_requests_count == 0){
                echo' <a href="friend_requests_system.php" />Friend Request<span class="displayFriendRequest"></span></a> ';
              }
              
              echo ' <a href="accountSetting.php" />Account Settings</a> 
				<a href="logout.php" />Logout </a> 
            
            </div> ';
   
	   
	   }
 else{
 
 echo '

            <div id="menu">
       			<a href="#" />Home</a> 
                <a href="#" />About</a> 
                
            
            </div>';
 }
 ?>
 <script type="text/javascript">

$.ajaxSetup({
	cache: false
	});
$(setInterval(function(){
		$('.displayFriendRequest').load('countMF/countFriendRequest.php');
		$('.unreadMessage').load('countMF/countUnreadMessage.php');
		},500));
</script>
 
         </div>
	</div>
   
    <br clear="all"/>
    <br clear="all"/>
    <br clear="all"/>