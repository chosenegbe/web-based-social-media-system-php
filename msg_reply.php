
<?php

 include("header_inc/header.php");
 ob_start();
 ?>

<!--Section for the text editor-->

<script type = "text/javascript" src = "js/js/tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
  tinyMCE.init({
	mode: "textareas",
	element: "msg_body", 
	height: "255px",
	width: "700px"
  });
</script>

<style type="text/css">
	textarea { resize: none; }
	#msg_header{
		height: 30px;
		}
</style>

<link rel = "stylesheet" type = "text/css" href = "css/cloudAnimation.css" /> 

 <style>
	body{
	/*background-color: #16a085;*/
	background-color: #FFFAFA  ;
		}
</style>  
<?php
if(isset($_GET['u'])){
			$username = mysql_real_escape_string($_GET['u']);
			if(ctype_alnum($username)) {// checks user exist
				$check = mysql_query("SELECT username FROM users WHERE username = '$username'");
				if(mysql_num_rows($check)==1){
					$get = mysql_fetch_assoc($check);
					$username = $get['username'];	
					
					//check user isn`t sending themself a private message
				if($username != $user){
					if(isset($_POST['submit'])){
							$msg_title = strip_tags(@$_POST['msg_title']);
							$msg_body = strip_tags(@$_POST['msg_body']);
							$date = date("Y-m-d");
							$opened = "no";
							$deleted = "no";
							$delSent = "no";
							$delTrash = "no";
							
					if($msg_body == ""){
								echo "Please write a message"; 
								exit;
							}
					else if($msg_title == ""){
								echo "Please write a message subject"; 
								exit;
							}
					else{	
						$send_msg = mysql_query("INSERT INTO pvt_messages VALUES('','$user','$username','$msg_title','$msg_body','$date','$opened','$deleted','$delSent','$delTrash')");
							echo 'Your message has been send';
						echo "<meta http-equiv=\"refresh\"content=\"0; url = http://localhost/UConnect/inbox.php\">";
					}
						}						
					echo "
					<div id= 'chatRoom' style='height: auto;'>
					<span id='clouds'>
						<form action ='send_msg.php?u=$username' method ='POST' >
				<p class='cloud x1'></p>
							<h2 style='color:#ecf0f1; font-style: bolder;'>Compose a message to $username:</h2>
							<span style='color:#ecf0f1; font-style: bolder;'>Subject: </span><input type = 'text' id= 'msg_header' name ='msg_title' size = '80' onClick = \"value =''\" /><p /><br />
							<textarea  id = 'msg_body' name ='msg_body' ></textarea>
							<input type = 'submit' name ='submit' value = 'Send Message' />
							<p class='cloud x2'></p>
						<p class='cloud x3'></p>
						<p class='cloud x4'></p>
						<p class='cloud x5'></p>
						</form>
						
						</span>
					</div>
						";
						
					}
					else{
						echo "<meta http-equiv=\"refresh\"content=\"0; url = http://localhost/UConnect/msg_reply.php?u=".$user."\">";
						}
					
					
					}
			}
}
					
?>
<br clear="all" />
<br clear="all" />
<br clear="all" />
<?php include("header_inc/footer.php"); ?>