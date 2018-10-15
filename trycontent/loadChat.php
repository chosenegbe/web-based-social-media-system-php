<?php

mysql_connect('localhost','chosen','chosen');
mysql_select_db('findfriends');
$u = @$_GET['u'];
$un = @$_GET['un'];

$fiveMinutesAgo = time() - 600;


$grab_messages = mysql_query("SELECT * FROM pvt_im WHERE user_from = '$u' AND user_to= '$un' OR user_from = '$un' AND user_to= '$u'");

$sql = 'SELECT * FROM pvt_im WHERE date_send > "$fiveMinutesAgo" ORDER BY date_send';
$result = mysql_query($sql) or die(mysql_error($connect));

while($row = mysql_fetch_assoc($grab_messages)){
		$hoursAndMinutes = date('g:ia',$row['date_send']);
		$user_from = $row['user_from'];
		echo ($u == $user_from) ?'<div class="msg_a"><p><strong><font color="#66CDAA">'. $row['user_from'].'</font></strong>: <em>-'.$hoursAndMinutes.':</em> '.$row['IM_body'].'</p></div>':
		'<div class="msg_b"><p><strong><font color="#00FF7F">'. $row['user_from'].'</font></strong>: <em>:'.$hoursAndMinutes.':</em>-'.$row['IM_body'].'</p></div>';
	}




?>