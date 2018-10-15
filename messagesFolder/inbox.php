<?php
	include("header_inc/connect/connect.php");


//ignore warnings

 session_start();
 $user = "";
if(!isset($_SESSION["userlogin"])){
	$user ="";
	
}else{
	//header("location: homepage.php");
	
}
$user =@$_SESSION["userlogin"];
 error_reporting(E_ALL & ~E_NOTICE & ~8192);
 ob_start();	

	
?>

	<link rel="stylesheet" type="text/css" href="css/styleForInboxMessages.css" />
	

<?php

 if(isset($_GET['msg'])){
	 $id = $_GET['msg'];
	 $update = mysql_query("UPDATE pvt_messages SET opened = 'yes' WHERE id = '$id' AND deleted = 'no'");
	 $msg = mysql_query("SELECT * FROM pvt_messages WHERE id = '$id' AND user_to = '$user' AND deleted = 'no'");
	 $row = mysql_fetch_assoc($msg);
	  
	  //$id = $row['id'];
	   $from = $row['user_from'];
	   $subject = $row['msg_title'];
	   $message = $row['msg_body'];
	   $date = $row['date'];
	   $status = $row['opened'];
	   $deleted = $row['deleted'];
	  // $time = $row['time'];
	 
?>
<div id="msg">
<a class="back"href="inbox.php?p=<?php echo 1; ?>">--Back to Inbox</a>
	<table>
    	
        <tr> 
        	<th>From: <?php echo $from; ?></td>
            <th>Subject:  <?php echo $subject; ?></td>
            <th>Date: <?php echo $date; ?></td>
            
        </tr>
    
    	
    </table>
    
    <pre><?php echo $message; ?></pre>
    <a  class="remove" href ="?remove= <?php echo $id;?>">Delete this message</a>&nbsp;&nbsp;<a  class="reply" href ="msg_reply.php?u=<?php echo $from;?>">Reply to this message</a>
</div>
<?php
 exit(); }

?>
<?php
  if(isset($_GET['remove'])){
	  $id = $_GET['remove'];
	 $remove = mysql_query("UPDATE pvt_messages SET deleted = 'yes' WHERE id = '$id'");
	  if($remove){
		  echo '<script>window.location = "inbox.php?p=1";</script>';
		}
		else{
				die("Please refresh the page");
			}
	  
	 // exit();
	  }

?>
 
<script type = "text/javascript">
	$(function(){
		$('#checkAll').click(function(){
			var check_status = this.checked;
				$('input[name = "deleteCheckes[]"]').each(function(index, element) {
                    this.checked = check_status;
                });
			});
		/*return false when delete form is is submitted*/
		$('#delMsg').submit(function(e){
			return false;
			});

		//display message item
		var $msgDel = $('<div></div>')
			.html('Message successfully deleted')
			.dialog({
				autoOpen:false,
				title: 'Error',
				draggable: false,
				resizable: false,
				});
		var $msgDel2 = $('<div></div>')
			.html('No message selected')
			.dialog({
				autoOpen:false,
				title: 'Error',
				
				draggable: false,
				resizable: false,	
				
				open: function(event, ui) {
   				 var dlg = $(this);
    				setTimeout(function(){
      				  dlg.dialog("close");
       				 },
       				 300000); 
        },
  			modal: true,
  		opacity: 1
						
				});
		
		//When button is click
  	$("#delMsg").click(function() {
    	 if ($('input[type=checkbox]').is(':checked')){
       		 $( "#dialog-confirm" ).dialog({
                modal: false,
				draggable: false,
				resizable: false,
				height: 'auto',
				width: 500,
				dialogClass: 'no-close',
				
                buttons: {
                     "Delete  messages": function() {
                          $(this ).dialog("close");
                          var data = $(":checkbox:checked").map(function(i,n)
                                   {
                                      return $(n).val();
                                   }).get();
                                    $.post("messagesFolder/delMsg.php", { 'deleteCheckes[]': data },
                                          function(){
                                                 $('body').load('inbox.php', function() {
                                                 $msgDel.dialog({title: 'Item(s) Deleted'});
												 
                                                  });
                                   });
                          },
                Cancel: function() {
                 $(this).dialog( "close" );
                 return false;
             }
      } //end buttons
	 
    });
		return false;
    }
    	else
    		{
         		$msgDel2.dialog("open");
				return false;
    		}
			
		});


	});	
	     
</script>
<style>
#dialog-confirm{
		display:none;
	}
#inboxMsg{
		border:inset;
	}
#composeMail{
		display:none;
		background-color:#FFF8DC ;
	}
#compose span{
		cursor:pointer;
		color:white;
		background-color: #2A1FFF;
		padding: 5px 5px 5px 5px;
		margin-left: 4%;
		margin-top: .25%;
		font-size: 12px;
		clear:both;
		position: absolute;
	}
 input[type="text"]{
	border: 2px solid #2A1FFF;
	}
textarea{
	 resize:none;
	}
</style>





<script>
	$(document).ready(function(e) {
     
$("#compose").click(function(){
 	$("#composeMail").attr('title','Compose Mail').dialog({
		width: 550,
		closeOnEscape: false, 
		draggable: false,
		resizable: false,
		show: 'fade',
		modal: true
		
		});
	});
});	
</script>
      <div id="dialog-confirm" title="Delete Item(s)?">
         <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">nbsp;</span>
                These items will be permanently deleted and cannot be recovered. Are you sure?
         </p>
      </div>
      <div id="compose"><span>Compose Mail</span>
      	<div id="composeMail">
        	
        	<select><option>
      
            
            </option></select> OR<br />
            <input type="text" size="40"placeholder="Enter recipient name or email " /><br /><br />
            <input type="text" size="40" placeholder="subject"/><br /><br />
      		<textarea rows="10" cols ="50"></textarea>
            <input type="submit" value="send" id="sendComposeMsg" name ="sendComposeMsg" />
         </div>
      </div>

<?php
		$queryMessages = mysql_query("SELECT * FROM pvt_messages WHERE user_to = '$user' AND deleted = 'no'");
			if(mysql_num_rows($queryMessages) && mysql_num_rows($queryMessages) != 0){?>
            <form name="deleteMsg" method="post" action="">
    <span style="  margin-left: 12%;  position:relative; padding: 5px 5px 5px 5px; clear:both;">
			<input type="submit" name="delMsg"  id = "delMsg" value="Delete" />
            <a href="inbox.php" id="inboxMSg"><img src="img/inbox.jpg" width="30" height="20" alt="Inbox Message" title="My Inbox"/></a>
            <a href="sent_outbox.php" id="sentMsg"><img src="img/sent_icon.jpg" width="30" height="20" alt="Sent _message" title="Sent Messages"/></a> 
            <a href="trash.php"><img src="img/trash_bin.jpg" width="30" height="20" alt="Trash"  title="Trash Folder"/> </a>
            
    </span>
            

           
            

<table>
	
	<tr>
    	<th width="7%">Check all <br /><input type="checkbox" name="deleteCheckes[]" id="checkAll" /></th>
        <th width="10%">From</th>
        <th>Subject</th>
        <th width="10%" >Date</th>
        <th width="6%">Status</th>
        
        
    </tr>

<?php

	$limit = 25;
	$p = '';
	$p = @$_GET['p'];
	
	$get_total = mysql_num_rows(mysql_query("SELECT * FROM pvt_messages WHERE user_to = '$user' AND deleted ='no'" ));
 	$total = ceil($get_total/$limit);
	if(!isset($_GET['p']) || $p <=0){
		$offset = 0;
	}
	else{
		$offset = ceil($p - 1) * $limit;
		}
 
 
 
 $inbox = mysql_query("SELECT * FROM pvt_messages WHERE user_to ='$user' AND deleted = 'no' ORDER BY id DESC LIMIT $offset,$limit");
   
   
   while($row = mysql_fetch_assoc($inbox)){
	   $id = $row['id'];
	   $from = $row['user_from'];
	   $subject = $row['msg_title'];
	   $date = $row['date'];
	   $status = $row['opened'];
	   //$deleted = $row['deleted'];
	   $time = $row['date'];
	   
	
	   
	 if($row['opened'] == "no"){
				   $status = 'Unread';
	 echo '<tr bgcolor="#F00">';
		
		
	   	echo '<td class="unread"><input type="checkbox" name="deleteCheckes[]" id="checked['.$id.']" value="'.stripslashes($id).'"/></td>';
	   	echo '<td class="unread"><a href="?msg='.$id.'">'.$from.'</a></td>';
		echo '<td class="unread"><a href="?msg='.$id.'">'.$subject.'</a></td>';
		echo '<td class="unread"><a href="?msg='.$id.'">'.$date.' - '.$time.'</a></td>';
		echo '<td class="unread"><a href="?msg='.$id.'">'.$status.'</a></td>';	
		
	  echo '</tr>';	
		   }
		 else{
			 $status = 'Read';
		 
			echo '<tr>';
			echo '<div id="read">';
			
	   		echo '<td><input type="checkbox" name="deleteCheckes[]" id="checked['.$id.']" value="'.stripslashes($id).'"/></td>';
	   		echo '<td><a href="?msg='.$id.'">'.$from.'</a></td>';
			echo '<td><a href="?msg='.$id.'">'.$subject.'</a></td>';
			echo '<td><a href="?msg='.$id.'">'.$date.' - '.$time.'</a></td>';
			echo '<td><a href="?msg='.$id.'">'.$status.'</a></td>';	
			
			echo '</div>';
	  		echo '</tr>';
		 
			 }
   
	   

	   
  		 }
		 echo '</form>';
		}
		else{?>
		<table>
				<tr>
                        <th width="9px;">Check all <br /><input type="checkbox" name="deleteCheckes[]" id="checkAll" /></th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
        
        <span style="font-size: 20px; color: #FFFFFF; text-align:center; "><!--You have no message in your inbox folder--></span>
    			</tr>
                <tr>
                 <td colspan="4">
        <span style="font-size: 20px; color:#F00; text-align:center;height: 70px; ">You have no message in your inbox folder</span>
        	<td>
                </tr>
               
    	</table>
			
	   <?php }

?>
</tr>
</table>


<?php
if($get_total > $limit){
	 echo "<div id='pages'>";
 for($i = 1; $i <= $total; $i++){
	
	 
	  echo ($i ==$p) ? '<a class="active">'.$i.'</a>':'<a href = "?p='.$i.'">'.$i.'</a>';
	 // echo '<a href = "?p='.$i.'">'.$i.'</a>';
	 
	  } 
	  echo "</div>";
	}
	

?>










<!--
<link rel = "stylesheet" type="text/css" href="css/my_messages.css" />
<link rel ="stylesheet" type="text/css" href="css/chatsidebar.css" />
<style>
	body{
	background-color: #16a085;
		}
</style>
<style type="text/css">

table{
	table-layout: fixed;
	width: 100%;
	margin: 10px auto 0px auto;
	}
@media only screen and (min-width:150px) and (max-width: 600px){
		table tr td{ width: 100%;
			color: purple;
		}
		table tr{ width: 100%;
			color: purple;
		}
		}
</style>
<div class="wrapMessage">
<?php  ob_start();?>

<?php
 
	echo '<div style=" text-align:center; margin: 0px auto"><h2>My Unread Messages</h2></div><br />';
	echo '<table><tr>';
	echo '<td style="color:green; font-size: 18px; ">From</td>
		  <td style="color:green; font-size: 18px;" >Subject</td> 
		  <td style="float:right;color:green; font-size: 18px;">Action</td>';
	
	echo '</tr></table>';
	
	//Grab the messages for the logged in user
	$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to = '$user' AND opened = 'no' AND deleted = 'no'");
	$numrows_unread = mysql_num_rows($grab_messages);
if($numrows_unread != 0){
	while($get_msg = mysql_fetch_assoc($grab_messages)){
		$id =$get_msg['id'];
		$user_from =$get_msg['user_from'];
		$user_to =$get_msg['user_to'];
		$msg_title =$get_msg['msg_title'];
		$msg_body =$get_msg['msg_body'];
		$date =$get_msg['date'];
		$opened =$get_msg['opened'];
		$deleted =$get_msg['deleted'];
?>
	<script language ="javascript">
	function toggle<?php echo $id; ?>(){
		 var element = document.getElementById("toggleText<?php echo $id; ?>");
		 var text = document.getElementById("displayText<?php echo $id; ?>>");
		 if(element.style.display =="block"){
			 element.style.display = "none";
		
			 }
		else{
				 element.style.display = "block";
			
			}
		}
	</script>


<?php

	$getFriendQuery = mysql_query("SELECT * FROM users WHERE username= '$user_from' LIMIT 1");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$friendUsername = $getFriendRow['username'];
			$friendProfilePic = $getFriendRow['profile_pic'];
		
	if(strlen ($msg_title) > 50){
		 $msg_body = substr($msg_body,0,50)."....";
		echo $msg_title;
		}
		else
			$msg_title = $msg_title;
			//process database to get profile pic	
			
	if(strlen ($msg_body) > 150){
		 $msg_body = substr($msg_body,0,150)."....";
		echo $msg_body;
		}
		else
			$msg_body = $msg_body;
			
			if (@$_POST['setopened_'.$id.'']){
				// update the pvt_messages table
				
				$setopened_query = mysql_query("UPDATE pvt_messages SET opened = 'yes' WHERE id = '$id'") or die(mysql_error() );
				if($setopened_query)
						echo "<meta http-equiv=\"refresh\"content=\"0; url = http://localhost/UConnect/inbox.php\">";
				}
				
			echo" <table style='background-color: #FFF;'><tr>
		
			
			<form method = 'POST' action = 'my_messages.php' name ='$msg_title'>
				<td><b><a href = '$user_from' >$user_from</a></b></td>
				<td><input type ='button' name ='openmsg' value ='$msg_title' onclick='javascript:toggle$id();'  />
					<div id= 'toggleText$id' style ='display:none; color:black; font-size:14px;  word-wrap: break-word;' >
				$msg_body
			</div>
				</td>
				<td style='float:right;'><input type= 'submit' name ='setopened_$id' value = \"I've read this\"  /></td>
				
			</form>
			
			
		<hr />"  ;	
		echo '</tr></table>';
	}
	
}	
else{
	echo '<br /><br /><br /><div style="margin: 0px auto; width: 400px; text-align:center; color:green">Woohoo! You\'ve read all the messages in your inbox.</div>';
	}
	
	echo '<div  text-align:center;><h2>My Read Messages</h2></div>';
	echo '<table><tr>';
	echo '<td style="color:green; font-size: 18px; ">From</td>
	<td style="margin-left: 390px; color:green; font-size: 18px; ">Subject</td>
	 <td style="float:right;color:green; font-size: 18px;">Action</td>';
	 
	echo '</tr></table>';
	//Grab the messages for the logged in user
	$grab_messages = mysql_query("SELECT * FROM pvt_messages WHERE user_to = '$user' AND opened = 'yes' AND deleted = 'no'");
	$numrows_read = mysql_num_rows($grab_messages);
	if($numrows_read != 0){
	while($get_msg = mysql_fetch_assoc($grab_messages)){
		$id =$get_msg['id'];
		$user_from =$get_msg['user_from'];
		$user_to =$get_msg['user_to'];
		$msg_title =$get_msg['msg_title'];
		$msg_body =$get_msg['msg_body'];
		$date =$get_msg['date'];
		$opened =$get_msg['opened'];
		$deleted =$get_msg['deleted'];
	?>
	<script language ="javascript">
	function toggle<?php echo $id; ?>(){
		 var element = document.getElementById("toggleText<?php echo $id; ?>");
		 var text = document.getElementById("displayText<?php echo $id; ?>>");
		 if(element.style.display =="block"){
			 element.style.display = "none";
		
			 }
		else{
				 element.style.display = "block";
			
			}
		}
	</script>


<?php
	$getFriendQuery = mysql_query("SELECT * FROM users WHERE username= '$user_from' LIMIT 1");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$friendUsername = $getFriendRow['username'];
			$friendProfilePic = $getFriendRow['profile_pic'];
		
		if(strlen ($msg_title) > 50){
		 $msg_body = substr($msg_body,0,50)."....";
		echo $msg_title;
		}
		else
			$msg_title = $msg_title;
			
		
	if(strlen ($msg_body) > 150){
		 $msg_body = substr($msg_body,0,150)."....";
		echo $msg_body;
		}
		else
			$msg_body = $msg_body;
		if(@$_POST['delete_'.$id.'']){
			 $delete_msg_query = "UPDATE pvt_messages SET deleted = 'yes' WHERE id = '$id'";
			 $result =mysql_query($delete_msg_query);
				if($result){
					echo "<meta http-equiv=\"refresh\"content=\"0; url = http://localhost/letchat1/my_messages.php\">";
					}
			}
		if(@$_POST['reply_'. $id. '']){
				echo 'Reply';
				header("location: msg_reply.php?u=$user_from");
			}
				
			echo" <table><tr>
			<form method = 'POST'  name ='$msg_title'>
				<td><b><a href = '$user_from' >$user_from</a> </b></td>
				<td><input type ='button' name ='openmsg' value ='Subject:\"$msg_title.\"' onclick='javascript:toggle$id();'/>
				<div id= 'toggleText$id'   style ='display:none; color:black; font-size:14px;'>$msg_body;</div></td>
				<td style='float:right; '><input type= 'submit' name ='delete_$id' value = \"X\" title = 'delete message'/>
				<input type= 'submit' name ='reply_$id' value = \"Reply\"/></td>
			</form>
		<hr />";		
	echo '</tr></table>';	
			
	}
}
else{
	echo '<br /><br /><br /><div style="margin: 0px auto; width: 400px; text-align:center; color:green">You havent read any message yet!</div>';
	}

?>
	</div>
<?php include("checkUserOnLineStatus.php"); ?>



-->	








	