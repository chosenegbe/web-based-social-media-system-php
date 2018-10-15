<?php require_once 'inc/header.inc.php'; 
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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Chat</title>
<link rel="stylesheet" type="text/css" href="messageFolder/cssForChat.css" />
<link rel ="stylesheet" type="text/css" href="css/chatsidebar.css" />


</head>

<body>

<?php
    $friendArray = "";
	$friendArray25 = ""; //slice the array in 25 parts
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
		$friendArray25 = array_slice($friendArray,0,50);
		$friendUsername ='';
	}
?>
   <!--         <?php 
  if($countFriends !=0){
		foreach($friendArray25 as $key => $value){
			$i++;
			$getFriendQuery = mysql_query("SELECT * FROM users WHERE username= '$value' LIMIT 1");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$friendUsername = $getFriendRow['username'];
			?>
			 <li id ="friendList"><a href = "#" onClick = "changeURL('<?php echo $user; ?>','<?php echo $friendUsername; ?>')"><?php echo $friendUsername; ?></a></li>
            
              
             
             
		<?php	

		}
      
  }
  
 ?>-->
<style>
 #main{
	 border: 1px solid #FF0000;
	 }
 #positionTextArea{
	 
	 position:absolute;
	 width: 100%;
	 height: 65px;
	 bottom: 0px;
	 }
 #sendMessage:hover{
	 border-top: 3px solid #0FF;
	 }
 #messages{
	 overflow:auto;
	 background-color: #FFFBF0;
	 height: 420px;
	 padding-bottom:2px;
	 }
</style>


<div style="width: 80%; border:#FF0000 thin solid; height: 500px; position:relative; margin-top:2%; margin: 0px auto; border:3px solid #0FF;">
 <div style=" width: 20%;  margin-bottom: 2%;  height:99%; border:3px solid #6B450C ; position:absolute;">
 	      <?php 
  if($countFriends !=0){
		foreach($friendArray25 as $key => $value){
			$i++;
			$getFriendQuery = mysql_query("SELECT * FROM users WHERE username= '$value' LIMIT 1");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$friendUsername = $getFriendRow['username'];
			?>
			 <li id ="friendList"><a href = "#" onClick = "changeURL('<?php echo $user; ?>','<?php echo $friendUsername; ?>')"><?php echo $friendUsername; ?></a></li>
            
              
             
             
		<?php	

		}
      
  }
  ?>
 
 </div>
 
 
 <div style="width: 79.5%;  height: 99%; border: 3px solid #808080;  margin-left:20%; position:absolute; top:0%;">
 
 <div id = "main">
 	<div>
    	
    </div><!--End of id messages where messages are been displayed-->
  <div id="positionTextArea">
  	<div style="width:auto; height: 63px; position:relative;">
  			<!--<textarea style="position: absolute; width: 100%; height: 100%; resize:none; " id="sendMessage"></textarea>-->
  	</div>
  </div><!--End of id positionTextArea -->
  </div><!--End of id main where the whole messages and textarea is been displayed-->
 </div>
 
</div> <!-- end of div wrapper -->

 

 

 
 
<div id="color"></div>
<script type="text/javascript">
$(function(){	
$.ajaxSetup({
	cache: false
	});	
	});
</script>
<script type="text/javascript">
	function changeURL(u,un){
					$('#main').load('displayMessagerevise.php?u='+u+'&un='+un);
					$('#messages').scrollTop($('#messages')[0].scrollHeight);
	}
</script>
</body>
</html>
