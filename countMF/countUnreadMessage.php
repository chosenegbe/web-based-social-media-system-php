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

	$get_unread_query = mysql_query("SELECT opened FROM pvt_messages WHERE user_to ='$user' AND opened = 'no'");
	$get_unread_rows = mysql_fetch_assoc($get_unread_query);
	$unread_numrows = mysql_num_rows($get_unread_query);
	
	
	echo '('.$unread_numrows.')';
	
?>