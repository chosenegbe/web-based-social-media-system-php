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

$picId = @$_GET['picId'];

$getProfilePic = mysql_query("SELECT * FROM users WHERE id = '$picId' ") or die(mysql_error());
	$getRow = mysql_fetch_assoc($getProfilePic);
	$profile_pic_db = $getRow['profile_pic'];
	$userId = $getRow['id'];
	$profile_pic = '';
	if($profile_pic_db == ""){
				$profile_pic = "../img/default_pic.png";
			}
			
		else{
					$profile_pic = "../userdata/profile_pic/".$profile_pic_db;
			}

echo '<img src='.$profile_pic.' width="190" height="210"  />';	
		
?>

