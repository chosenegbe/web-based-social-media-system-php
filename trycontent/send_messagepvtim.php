<?php
require_once 'inc/connect.inc.php';
//require_once 'inc/header.inc.php';
session_start();
$user = @$_GET['u'];
$username = @$_GET['un'];
	
			if($username != $user){
			$IM_body = &$_POST['message'];
						$time = date("Y-m-d");
							$sql = 'INSERT INTO pvt_im
									(user_from, user_to, IM_body,date_send)
										VALUES
									("'.$user.'","'.$username.'","'.$IM_body.'","'.$time.'") ';
							$result = mysql_query($sql) or die(mysql_error($connect));
			
	}
	echo $user.'hahaha';

?>


