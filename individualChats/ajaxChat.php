<?php
include("../header_inc/connect/connect.php");
session_start();
$user = "";
if(!isset($_SESSION["userlogin"])){
	$user ="";
	
}else{
	//header("location: homepage.php");
	
}
$user =@$_SESSION["userlogin"];

@$username = @$_GET['un'];
$d =time();
 	@$chat = @$_POST['chat'];
	//@$session = @$_POST['chat'];
		if(!empty($chat)){
			mysql_query("INSERT INTO pvt_im (user_from,user_to,IM_body,date_send)
						 VALUES('$user','$username','$chat','$d')");
			}
			
	@$lastid = @$_POST['lastid'];		
	$sql = mysql_query("SELECT * FROM pvt_im WHERE user_from = '$user' AND user_to= '$username' AND id > '$lastid' OR
	 user_from = '$username' AND user_to= '$user' AND id > '$lastid' ORDER BY date_send ASC");
		
	while(@$get = mysql_fetch_array($sql)){
	    $hoursAndMinutes = date('g:ia',$get['date_send']);
		$json['lastid'] = $get['id'];
        
        $user_from = $get['user_from'];
        
     
          
     
		//$json['session'] = $get['session'];
		//$json['check'] = $_SESSION['username'];
        if($user == $user_from){
		  $json['msg'] = '<div class="msg_a"><p><strong><font color="#66CDAA">'. $get['user_from'].'</font></strong>: <em>-'.$hoursAndMinutes.':</em> '.$get['IM_body'].'</p></div>';
        }else{
          $json['msg'] = '<div class="msg_b"><p><strong><font color="#00FF7F">'. $get['user_from'].'</font></strong>: <em>:'.$hoursAndMinutes.':</em>-'.$get['IM_body'].'</p></div>';
        }
        
		}			
  echo json_encode(@$json);
?>