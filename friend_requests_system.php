<?php include("header_inc/header.php");?>

<?php
	//find friend requests
	
	$findRequests = mysql_query("SELECT * FROM friend_requests WHERE user_to = '$user'");
	$numrows = mysql_num_rows($findRequests);
	if($numrows == 0){
			echo '<h2>You have no friend requests</h2>';
			$user_from = "";
	}
	else{
		while($get_row = mysql_fetch_assoc($findRequests)){
			$id = $get_row['id'];
			$user_from = $get_row['user_from'];
			$user_to = $get_row['user_to'];
			
			echo '<h2>'. $user_from. ' wants to be friend </h2> ';

	
 ?>
  <?php /*?>Handle the accept and ignore request  submit button <?php */?>
 <?php
 	
 	if(isset($_POST['acceptrequest'.$user_from])){
			/*echo "<h6>Friend request accepted</h6>";*/
			//select the friend_array row from the login user
			//select the friend_array row from the who send the friend requests
			// if the user has no friends, we just concat the friends username
			
			//Get friend array for logged in user
		$get_friend_check = mysql_query("SELECT friend_array FROM users WHERE username='$user'");
		$get_friend_row = mysql_fetch_assoc($get_friend_check);
		$friend_array= $get_friend_row['friend_array'];
		$friendArray_explode = explode(",",$friend_array);
		$friendArray_count = count($friendArray_explode);
		/*echo '<br />'. $friendArray_count;*/
		
			//get friend array for person who sent request
		$get_friend_check_friend = mysql_query("SELECT friend_array FROM users WHERE username='$user_from'");
		$get_friend_row_friend = mysql_fetch_assoc($get_friend_check_friend);
		$friend_array_friend= $get_friend_row_friend['friend_array'];
		$friendArray_explode_friend = explode(",",$friend_array_friend);
		$friendArray_count_friend = count($friendArray_explode_friend);
		
		/*echo $friendArray_count;*/
		if($friend_array == ""){
			$friendArray_count = count(NULL);
		}
		if($friend_array_friend == ""){
			$friendArray_count_friend = count(NULL);
		}
		/*echo $friendArray_count;*/
		if($friendArray_count == NULL){
			$add_friend_query = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,'$user_from') WHERE username = '$user'");
		
		}
		if($friendArray_count_friend == NULL){
			$add_friend_query_friend = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,'$user_to') WHERE username = '$user_from'");
			
		}
		// If the user had friends before
		if($friendArray_count >= 1){
			$add_friend_query_friend = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,',$user_from') WHERE username = '$user'");
			
		}
		if($friendArray_count_friend >= 1){
			$add_friend_query_friend = mysql_query("UPDATE users SET friend_array = CONCAT(friend_array,',$user_to') WHERE username = '$user_from'");
			
		}
		//do this to prevent the user accepting request multiple number of time
		
		$delete_request = mysql_query("DELETE FROM friend_requests WHERE user_from ='$user_from' AND user_to ='$user_to' ");
		echo '<h6>You are now friends!</h6>';
		header("location: friend_requests_system.php");
		}
		if(isset($_POST['ignorerequest'. $user_from])){
			$delete_request = mysql_query("DELETE FROM friend_requests WHERE user_from ='$user_from' AND user_to ='$user_to' ");
			echo 'Request ignore';
			header("location: friend_requests_system.php");
		}
 ?>

<form action "friend_requests.php" method ="POST">
 	<input type="submit" name ="acceptrequest<?php echo $user_from; ?>" value="Accept Request" />
   <input type="submit" name ="ignorerequest<?php echo $user_from; ?>" value="Ignore Request" />
 </form>
<?php
	}
	}
?>
<div  class="footerlocate">
</div>