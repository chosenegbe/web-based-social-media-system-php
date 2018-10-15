<?php
require_once 'header_inc/connect/connect.php';


@$user = @$_GET['u'];
@$username = @$_GET['un'];
@$chat = @$_POST['chat'];
	
			if($username != $user && !empty($chat)){
			//$IM_body = &$_POST['message'];
						$time = time();
							$sql = 'INSERT INTO pvt_im
									(user_from, user_to, IM_body,date_send)
										VALUES
									("'.$user.'","'.$username.'","'.$chat.'","'.$time.'") ';
							$result = mysql_query($sql) or die(mysql_error());
			
	}
	
	@$lastid = @$_POST['lastid'];
	
		
	@$sql = mysql_query("SELECT * FROM pvt_im WHERE user_from = ".$user." AND user_to= ".$username." AND id > ".$lastid." OR
	 user_from = ".$username." AND user_to= ".$user." AND id > ".$lastid."
	 ORDER BY date_send ASC");
	
	while(@$get = mysql_fetch_array($sql)){
		$json['lastid'] = @$get['id'];
		//$json['session'] = $get['session'];
		//$json['check'] = $_SESSION['username'];
		$json['msg'] = @$get['IM_body'].'<br />';
		}
					
 	echo json_encode($json);

?>

<style>
 #colorThings{
	color:#FF5FAA; 
	 }
</style>


