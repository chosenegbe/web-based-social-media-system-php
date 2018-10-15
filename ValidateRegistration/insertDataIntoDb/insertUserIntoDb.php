<?php
	include("../../header_inc/connect/connect.php");
	
	$sendDatatoRegisterUsera = @$_POST['sendDatatoRegisterUser'];
	$fname= "";
	$lname="";
	$email= "";
	$pass1 ="";
	$pass2 ="";
	$username ="";
	$d =""; //sign up date
	$u_check =""; //check if user name exist
	$country ='';
	$state ='';
    $sex = '';
    $dayOfBirth = '';
    $monthOfBirth = '';
    $yearOfBirth = '';
	
	
	$fname = strip_tags(@$_POST['fname']);
	$lname = strip_tags(@$_POST['lname']);
	$username = strip_tags(@$_POST['Uname']);
	$email = strip_tags(@$_POST['email']);
	$pass1 =  strip_tags(@$_POST['pass1']);
	$pass2 =  strip_tags(@$_POST['pass2']);
	$d = date("Y-m-d"); //Year-Month-Day
	$country = strip_tags(@$_POST['country']);
	$state = strip_tags(@$_POST['state']);
    $sex = strip_tags(@$_POST['sex']);
    
    $dayOfBirth = strip_tags(@$_POST['day']);
    $monthOfBirth = strip_tags(@$_POST['month']);
    $yearOfBirth = strip_tags(@$_POST['year']);
    
	
	
			
			$useremail = mysql_query("SELECT email FROM users WHERE email ='$email'");
			$countemail = mysql_num_rows($useremail);
			$username1 = mysql_query("SELECT username FROM users WHERE username ='$username'");
			$countuserName = mysql_num_rows($username1);
			
	if($countemail ==0 && $countuserName ==0){
				
		if($fname&&$lname&&$username&&$email&&$pass1&&$pass2){
				//check the password match for match
				 			$pass1 = md5($pass1);
							$pass2 = md5($pass2);
							$random = rand(23456789,98765432);
       if($dayOfBirth != '' && $monthOfBirth != '' && $yearOfBirth != ''){
		$query = mysql_query("INSERT INTO users VALUES('','$username','$fname','$lname','$email','$pass1','$sex','$dayOfBirth','$monthOfBirth','$yearOfBirth','$country','$state','$d','','','','','','no')");
		  echo 1;
        }
        else{
         $query = mysql_query("INSERT INTO users VALUES('','$username','$fname','$lname','$email','$pass1','$sex','','','','$country','$state','$d','','','','','','no')");  
		  echo 1;
           }			
      }
	}
	
else{
		echo 0;
		
		}
		
?>