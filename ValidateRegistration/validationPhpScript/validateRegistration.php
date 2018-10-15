<?php
		$username = &$_POST['usernames'];
		$email = &$_POST['emails'];
		
		if($username != ""){
			
			include("../../header_inc/connect/connect.php");
			$username = mysql_query("SELECT username FROM users WHERE username ='$username'");
			$count = mysql_num_rows($username); 
			
			if($count != 0){
				echo 1;
			}
			else{
				echo 0;
			}
		}
		if($email !=""){
			include("../../header_inc/connect/connect.php");
			
			$useremail = mysql_query("SELECT email FROM users WHERE email ='$email'");
			$countemail = mysql_num_rows($useremail);
			
			if($countemail != 0){
				echo 1;
			}
			else{
				echo 0;
			}
		}
?>