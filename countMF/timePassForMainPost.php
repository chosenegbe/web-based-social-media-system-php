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
$post_id = @$_GET['post_id'];

$getposts = mysql_query("SELECT * FROM posts WHERE  id ='$post_id'") or die(mysql_error());
$id = '';
$date_added ='';
	while($rows = mysql_fetch_assoc($getposts)){
				$id = $rows['id'];
				$body = $rows['body'];
				$date_added = $rows['date_added'];
				
				$added_by = $rows['added_by'];
				$user_posted_to = $rows['user_posted_to'];
			
			
				echo time_elapsed_string($date_added);
				
					//count the numberv of comments available
	}


	function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
		
?>