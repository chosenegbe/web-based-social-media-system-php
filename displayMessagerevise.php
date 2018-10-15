
<!-- 2Corithians 2:20 -->

<style type="text/css">
.msg_a{
	margin-left: 20px;
	margin-top:7px;
	margin-right: 20px;
	padding: 15px;
	background: #99FFCC;
	position:relative;
	border-radius: 5px;
	min-height:15px;
	}
.msg_a:before{
	content:"";
	position:absolute;
	width:0px;
	height: 0px;
	left:-20px;
	border: 10px solid;
	border-color:  transparent #99FFCC transparent transparent;
	
	}
.msg_b{
	margin-left: 20px;
	margin-top:7px;
	margin-right: 20px;
	padding: 15px;
	background: #FFFF99;
	position:relative;
	border-radius: 5px;
	min-height:15px;
	}
.msg_b:before{
	content:"";
	position:absolute;
	width:0px;
	height: 0px;
	right:-20px;
	border: 10px solid;
	border-color:  transparent  transparent transparent #FFFF99;
	}

</style>

<?php
require_once 'header_inc/connect/connect.php';
session_start();
@$user= @$_GET['u'];
@$username = @$_GET['un'];




$grab_messages = mysql_query("SELECT * FROM pvt_im WHERE user_from = '$user' AND user_to= '$username' 
							  OR user_from = '$username' AND user_to= '$user' ORDER BY date_send ASC");

?>
<script type="text/javascript">
<?php 
 
	@$sql = mysql_query("SELECT * FROM pvt_im WHERE user_from = '$user' AND user_to= '$username' 
							  OR user_from = '$username' AND user_to= '$user'ORDER BY id DESC LIMIT 1 ");
						
	@$fetch = mysql_fetch_array($sql);
?>
	var lastid = <?php echo $fetch['id']; ?>
</script>
<script type="text/javascript">

	
	$(document).ready(function(e) {
		var timer = setInterval(get,1000);
        $("#sendMessage<?php echo $username; ?>").keydown(function(e){
			//clearInterval(timer );
			var chat = $(this).val();
			if(e.keyCode==13 && !chat==""){
				$.post("sendMessageChat.php?u=<?php echo $user;?>&un=<?php echo $username; ?>",{chat:chat},function(){
					$("#sendMessage<?php echo $username; ?>").val("");
						setInterval(get,1000);
						
					});
				}
			});
	function get(){
			$.post("sendMessageChat.php?u=<?php echo $user;?>&un=<?php echo $username; ?>",{lastid:lastid},function(data){
				   $('#messages').append(data.msg);	
				   	lastid = data.lastid;
				},'json')	
				}
    });
	 
</script>    
     
	<div id="messages">
 <?php	    	
			$sql = mysql_query("SELECT * FROM pvt_im WHERE user_from = '$user' AND user_to= '$username'
				OR user_from = '$username' AND user_to= '$user'
			 ORDER BY date_send ASC");
			
			while(@$get = mysql_fetch_array($sql)){
				$hoursAndMinutes = $get['date_send'];
				$user_from = $get['user_from'];
				echo $json['msg'] = $get['IM_body'].'<br />';
			/*	echo ($user == $user_from) ? '<div class="msg_a"><p><strong><font color="#66CDAA">'.$user_from.'
				</font></strong>: <em>-'.$hoursAndMinutes.':</em> '.$json['msg'] = $get['IM_body'].'</p></div>' : 
				'<div class="msg_b"><p><strong><font color="#00FF7F">'.$user_from.'
				</font></strong>: <em>-'.$hoursAndMinutes.':</em>'.$json['msg'] = $get['IM_body'].'</p></div>';
				}
			*/
	}
	
?>
    </div><!--End of id messages where messages are been displayed-->
  <div id="positionTextArea">
  	<div style="width:auto; height: 63px; position:relative; padding-top: -1%;">

  			<textarea style="position: absolute; width: 100%; height: 100%; resize:none; " id="sendMessage<?php echo $username; ?>" name="chat" placeholder="chat with...<?php echo $username;?>"></textarea>
  	</div>
  </div><!--End of id positionTextArea -->
<!--
<script>
  $(document).ready(function(e) {

	$('#sendMessage').keypress(
		
	 	function(e){	
		 if(e.keyCode==13){
					var message = $('#sendMessage').val();
					message.replace(/</g,'&lt;').replace(/>/g,'&gt;')
					if(message == "" || message == "Enter your message here"){
						 return false;
					 }
		var dataString = 'message='+ message;
		
		
		
		$.ajax({
			type: "POST",
			url: 'send_messagepvtim.php?u=<?php echo $user; ?>&un=<?php echo $username; ?>',
			data: dataString,
			success: function(data){
				$('#sendMessage').val('');
				
				}
			
				});
			}
			
		});

	
		
    
});
</script>

-->





     
         
        		 