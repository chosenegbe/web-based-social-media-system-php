
<?php 
	include("header_inc/header.php");
	ob_start();
//ignore warnings
	error_reporting(E_ALL & ~E_NOTICE & ~8192);
	

	
?>

	<link rel="stylesheet" type="text/css" href="css/styleForInboxMessages.css" />
	

<?php

 if(isset($_GET['msg'])){
	 $id = $_GET['msg'];
	 $msg = mysql_query("SELECT * FROM pvt_messages WHERE id = '$id' AND user_from = '$user' AND delSent = 'no'");
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
<a class="back"href="sent_outbox.php?p=<?php echo 1; ?>">--Back to sent messages</a>
	<table>
    	
        <tr> 
        	<th>From: <?php echo $from; ?></td>
            <th>Subject:  <?php echo $subject; ?></td>
            <th>Date: <?php echo $date; ?></td>
            
        </tr>
    
    	
    </table>
    
    <pre><?php echo $message; ?></pre>
    <a  class="remove" href ="?remove= <?php echo $id;?>">Delete this message</a>&nbsp;&nbsp;<!--<a  class="reply" href ="msg_reply.php?u=<?php echo $from;?>">Reply to this message</a>-->
</div>
<?php
 exit(); }

?>
<?php
  if(isset($_GET['remove'])){
	  $id = $_GET['remove'];
	 $remove = mysql_query("UPDATE pvt_messages SET delSent= 'yes' WHERE id = '$id'");
	  if($remove){
		  echo '<script>window.location = "sent_outbox.php?p=1";</script>';
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
		$('#delSentMsg').submit(function(e){
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
  	$("#delSentMsg").click(function() {
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
                                    $.post("messagesFolder/delSentMsg.php", { 'deleteCheckes[]': data },
                                          function(){
                                                 $('body').load('sent_outbox.php', function() {
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
</style>
      <div id="dialog-confirm" title="Delete Item(s)?">
         <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">nbsp;</span>
                These items will be permanently deleted and cannot be recovered. Are you sure?
         </p>
      </div>
<?php
	$sentMsg = mysql_real_escape_string(@$_POST['sentmail']);
	if($sentMsg){
		echo "<meta http-equiv=\"refresh\"content=\"0; url = http://localhost/UConnect/sent_outbox.php\">";
		}
?>
<?php
		$queryMessages = mysql_query("SELECT * FROM pvt_messages WHERE user_from = '$user' AND delSent = 'no'");
			if(mysql_num_rows($queryMessages)  != 0){?>
            <form name="deleteMsg" method="post" action="">
     <table id="tableHeader" cellspacing="0" cellpadding="0" border="0">  
          <tr id="tableHeaderRow">  
			<th id="tableTH"><input type="submit" name="delSentMsg"  id = "delSentMsg" value="Delete" style="border-radius: 0px; background-color: #FF0000; border:  0px;;" /></th>
            <th id="tableTH"><a href="inbox.php" id="inboxMSg"><img src="img/inbox.jpg" width="15" height="15" alt="Inbox Message" title="My Inbox"/>Inbox</a></th>
            <th id="tableTH"><a href="sent_outbox.php" id="sentMsg"><img src="img/sent_icon.jpg" width="15" height="15" alt="Sent _message" title="Sent Messages"/>Sent</a></th> 
            <th id="tableTH"><a href="trash.php"><img src="img/trash_bin.jpg" width="15" height="15" alt="Trash"  title="Trash Folder"/>Trash</a></th>
          </tr>
    </table>  
        
<table>
	
	<tr>
    	<th width="9px;">Check all <br /><input type="checkbox" name="deleteCheckes[]" id="checkAll" /></th>
      
        <th>Subject</th>
        <th width="10%" >Date Sent</th>
      
        
        
    </tr>

<?php

	$limit = 10;
	$p = '';
	$p = $_GET['p'];
	
	$get_total = mysql_num_rows(mysql_query("SELECT * FROM pvt_messages  WHERE user_from ='$user' AND delSent ='no'"));
 	$total = ceil($get_total/$limit);
	if(!isset($_GET['p']) || $p <=0){
		$offset = 0;
	}
	else{
		$offset = ceil($p - 1) * $limit;
		}
 
 
 
 $inbox = mysql_query("SELECT * FROM pvt_messages WHERE user_from ='$user' AND delSent ='no' ORDER BY id DESC LIMIT $offset,$limit");
   
   
   while($row = mysql_fetch_assoc($inbox)){
	   $id = $row['id'];
	   $from = $row['user_from'];
	   $subject = $row['msg_title'];
	   $date = $row['date'];
	   $status = $row['opened'];
	   //$deleted = $row['deleted'];
	   $time = $row['date'];
	   
	
	   
	
				   
	 echo '<tr>';
		
		
	   	echo '<td class="unread"><input type="checkbox" name="deleteCheckes[]" id="checked['.$id.']" value="'.stripslashes($id).'"/></td>';
	   
		echo '<td class="unread"><a href="?msg='.$id.'">'.$subject.'</a></td>';
		echo '<td class="unread"><a href="?msg='.$id.'">'.$date.' - '.$time.'</a></td>';
		
		
	  echo '</tr>';	
		   
			echo '</div>';
	  		echo '</tr>';
		 
			 }
   
	   

	   
  		 
		 echo '</form>';
		}
		else{?>
        
                    
     <table id="tableHeader" cellspacing="0" cellpadding="0" border="0">  
            <tr id="tableHeaderRow">  
            <th id="tableTH"><a href="inbox.php" id="inboxMSg"><img src="img/inbox.jpg" width="15" height="15" alt="Inbox Message" title="My Inbox"/>Inbox</a></th>
            <th id="tableTH"><a href="sent_outbox.php" id="sentMsg"><img src="img/sent_icon.jpg" width="15" height="15" alt="Sent _message" title="Sent Messages"/>Sent</a></th> 
            <th id="tableTH"><a href="trash.php"><img src="img/trash_bin.jpg" width="15" height="15" alt="Trash"  title="Trash Folder"/>Trash</a></th>
          </tr>
          
    </table> 
		<table>
				<tr>
                        <th width="9px;">Check all <br /><input type="checkbox" name="deleteCheckes[]" id="checkAll" /></th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Date</th>
                       
        
        <span style="font-size: 20px; color: #FFFFFF; text-align:center; "><!--You have no message in your inbox folder--></span>
    			</tr>
                <tr>
                 <td colspan="4">
        <span style="font-size: 20px; color:#F00; text-align:center;height: 70px; ">You haven`t sent any message</span>
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







