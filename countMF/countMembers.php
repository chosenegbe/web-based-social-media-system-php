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


 $countNumberofUsers = mysql_query("SELECT sex FROM users ");
 $countgroupBySex = mysql_num_rows($countNumberofUsers);
 
 echo "<font size ='15px' color ='#FF69B4'><strong><b>" .$countgroupBySex."</b></strong></font>";
  
 
 

?>