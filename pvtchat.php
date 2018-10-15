
<link rel="stylesheet" type="text/css" href="messagesFolder/cssForChat.css" />
<?php require_once 'header_inc/header.php';
	if($user){
		
	}
	else{
			die("You must be logged in to view this page");
		}


if(isset($_GET['u'])){
			$username = mysql_real_escape_string($_GET['u']);
			if(ctype_alnum($username)) {// checks user exist
				$check = mysql_query("SELECT username FROM users WHERE username = '$username'");
				if(mysql_num_rows($check)==1){
					$get = mysql_fetch_assoc($check);
					$username = $get['username'];	

				}
				
			}
	}

?>

<div class="backgroundImage">
  <div class="chatBox">
	<div class="user">
    	<a href="<?php echo $username; ?>"><?php echo $username.'  chat'; ?></a>
    </div><!--End of user class-->
 	<!--<div class="main">	
    
    </div><!--End of main class-->
    <div id="main" class="main">	
    
    </div><!--End of main class-->
    <div class="messageBox">
             <form name ="newMessage" id ="newMessage" onsubmit="return false" action="send_messagepvtim.php?u=<?php echo $username?>">
            <div class ="left">
            	<textarea name ="newMessageContent" id="newMessageContent"  id="IM_body"></textarea>
            </div>	<!--End of left class-->
            </form>
    </div><!--End of message class-->
</div><!--End of chatBox class-->
</div> <!--End of backgroundImage class-->





<?php
 //This section gets the user friend list
 $friendArray = "";
	$friendArray25 =""; //slice the array in 25 parts
	$countFriends = "";
	$addAsFriend = "";		
	$i = 0;
	
	//querying the user database
	$selectFriendQuery = mysql_query("SELECT friend_array FROM users WHERE username ='$user'");
	$friendRow = mysql_fetch_assoc($selectFriendQuery);
	$friendArray = $friendRow['friend_array'];
	
	if($friendArray != ""){
		$friendArray = explode(",",$friendArray);
		$countFriends = count($friendArray);
		$friendArray25 = array_slice($friendArray,0,25);
	}
?>
<link rel ="stylesheet" type="text/css" href="css/chatsidebar.css" />
<div class="chat_box">
	<div class="chat_head">Chatbox</div>
	<div class="chat_body">
 <?php 
  if($countFriends !=0){
		foreach($friendArray25 as $key => $value){
			$i++;
			$getFriendQuery = mysql_query("SELECT * FROM users WHERE username= '$value' LIMIT 1");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$friendUsername = $getFriendRow['username'];
			echo '<div class="user"><a href = "pvtchat.php?u='.$friendUsername.'"> '.$friendUsername. '</a><br /></div>';
			
		}
  }
 ?>
    </div>
</div>


<!--<script type="text/javascript" src="refresh_messagelogpvtim.js" ></script>-->




<script type="text/javascript">
$(function(){
	
	
$('textarea').keypress(
	 	function(e){
		 if(e.keyCode==13){
					var message = $('#newMessageContent').val();
		
				if(message == "" || message == "Enter your message here"){
						return false;
					}
		var dataString = 'message='+ message;
		
		$.ajax({
			type: "POST",
			url: "send_messagepvtim.php?u=<?php echo $username; ?>",
			data: dataString,
			success: function(){
				document.newMessage.newMessageContent.value = "";
				
				}
			
			});
		}
			
});

	
$.ajaxSetup({
	cache: false
	});

$(setInterval(function(){
		$('.main').load('display_messagespvtim.php?u=<?php echo $username; ?>');
		$('.main').scrollTop($('.main')[0].scrollHeight);
	},500));
	
	//document.getElementById('main').scrollTop = document.getElementById('main')[0].scrollHeight;	
		
	});
	

</script>
