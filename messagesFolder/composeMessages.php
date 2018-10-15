
	<div id="edit<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body">
			<div class="alert alert-info"><strong>Compose Message</strong></div>
	<form class="form-horizontal" method="post">
			<div class="control-group">
				<label class="control-label" for="inputEmail">Usernames</label>
				<div class="controls">
				<input type="hidden" id="inputEmail" name="id" value="<?php echo $userData['id']; ?>" required>
                
                        <?php 
                            $queryusernames = mysql_query("SELECT id,username FROM users ");
                            $num_users = mysql_num_rows($queryusernames);
                           
                            $select ='<select name="select">';
                            if($num_users >0){
                                while($rows = mysql_fetch_assoc($queryusernames)){
                                    $select.='<option value ="'.$rows['id'].'">'.$rows['username'].'</option>';
                                }
                            }
                             $select.='</select>';
                             echo $select;
                        
                        ?>
              </div>  
			</div>
			<div class="control-group">
                    <label class="control-label" for="inputEmail">Subject</label>
        			<div class="controls">
                        
        				<input type="text" id="inputEmail" name="msg_title" size ="70"required />
        	        </div>	
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">MessageBody</label>
				<div class="controls">
	
				<textarea cols="70" rows="10"></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
				<button name="edit" type="submit" class="btn btn-success"><i class="icon-save icon-large"></i>&nbsp;Update</button>
				</div>
			</div>
    </form>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
		</div>
    </div>
	
	<?php
	if (isset($_POST['edit'])){
	
	$user_id = $_POST['id'];
	$username = $_POST['username'];
	$password=$_POST['password'];
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	
	mysql_query("update users set username='$username', password='$password' , First_name = '$firstname' , Last_name = '$lastname'  where id='$id'")or die(mysql_error()); ?>
	<script>
	window.location="../Uconnect/accountSetting.php";
	</script>
	<?php
	}
	?>