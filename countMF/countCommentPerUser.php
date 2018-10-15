<?php
include("../inc/connect.inc.php");
$user = "";
session_start();
if(!isset($_SESSION["user_login"])){
	$user ="";	
	}
else{
	$user = $_SESSION["user_login"];
	}

$commentID = @$_GET['commentID'];

$getComments = mysql_query("SELECT * FROM post_comments WHERE post_id = '$commentID' ") or die(mysql_error());
$countXC = mysql_num_rows($getComments);

echo $countXC;
	
		
?>