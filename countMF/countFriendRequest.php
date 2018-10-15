<?php

 require_once '../header_inc/connect/connect.php';
 
 session_start();
 $user = "";
if(!isset($_SESSION["userlogin"])){
	$user ="";
	
}else{
	//header("location: homepage.php");
	
}
$user =@$_SESSION["userlogin"];


  $query = mysql_query("SELECT * FROM friend_requests WHERE user_to='$user'");
  $count_num_rows = mysql_num_rows($query);

 	 echo '('.$count_num_rows.')';
  
 
 

?>