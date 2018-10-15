<?php
	include("header_inc/header.php");
	if($user){
		
	}
	else{
			die("You must be logged in to view this page");
		}
	//take the user back
	if($user){
		if(isset($_POST['no'])){
			header("location: accountSetting.php");
		}
		
		else{
		if(isset($_POST['yes'])){
			$close_account = mysql_query("UPDATE users SET closed ='yes' WHERE username= '$user'");
			echo 'Your account has been closed';
			session_destroy();
			
		}
		}
	}
?>
<br />

<center>
<form action = "closeaccount.php" method = "POST">
Are your sure your want to close your account? <br />
	<input type ="submit" name ="no" value = "No, take me back!">
    <input type ="submit" name ="yes" value = "Yes i`m sure">
</form>
</center>