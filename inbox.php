<?php
	
    include("header_inc/header.php");
	
	

//ignore warnings
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


<?php
		$queryMessages = mysql_query("SELECT * FROM pvt_messages WHERE user_to = '$user' AND deleted = 'no'");
		if(mysql_num_rows($queryMessages)  != 0){?>
  <form name="deleteMsg" method="post" action="">
            
     <table id="tableHeader" cellspacing="0" cellpadding="0" border="0">  
            <tr id="tableHeaderRow">
			<th id="tableTH"><input type="submit" name="delMsg"  id = "delMsg" value="Delete" style="border-radius: 0px; background-color: #FF0000; border:  0px;;" /></th>           
            <th id="tableTH"><a href="inbox.php" id="inboxMSg"><img src="img/inbox.jpg" width="15" height="15" alt="Inbox Message" title="My Inbox"/>Inbox</a></th>
            <th id="tableTH"><a href="sent_outbox.php" id="sentMsg"><img src="img/sent_icon.jpg" width="15" height="15" alt="Sent _message" title="Sent Messages"/>Sent</a></th> 
            <th id="tableTH"><a href="trash.php"><img src="img/trash_bin.jpg" width="15" height="15" alt="Trash"  title="Trash Folder"/>Trash</a></th>
          </tr>
          
         
        
               }
               
         <tr>
         <td style="background: #FFFFFF;">&nbsp;</td>
         <td style="background: #FFFFFF;">&nbsp;</td>
         <td style="background: #FFFFFF;">&nbsp;</td>
         <td style="background: #FFFFFF;">&nbsp;</td>
         </tr>
          
    </table>  
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
			
	   		echo '<td class="read"><input type="checkbox" name="deleteCheckes[]" id="checked['.$id.']" value="'.stripslashes($id).'"/></td>';
	   		echo '<td class="read"><a href="?msg='.$id.'">'.$from.'</a></td>';
			echo '<td class="read"><a href="?msg='.$id.'">'.$subject.'</a></td>';
			echo '<td class="read"><a href="?msg='.$id.'">'.$date.' - '.$time.'</a></td>';
			echo '<td class="read"><a href="?msg='.$id.'">'.$status.'</a></td>';	
			
			echo '</div>';
	  		echo '</tr>';
		 
			 }
   
	   

	   
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

