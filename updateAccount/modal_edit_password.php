    <div id="edit<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body">
			<div class="alert alert-info"><strong>Edit Password</strong></div>
	<form class="form-horizontal" method="post">
            <div class="control-group">
				<label class="control-label" for="inputEmail">Old Password</label>
				<div class="controls">
				<input type="hidden" id="inputEmail" name="id" value="<?php echo $userRow['id']; ?>" required>
				<input type="password" id="inputEmail"  name="oldpassword" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">New Password </label>
				<div class="controls">
				<input type="hidden" id="inputEmail" name="id" value="<?php echo $userRow['id']; ?>" required>
				<input type="text" id="inputEmail" name="newPassword"  required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Confirm Password </label>
				<div class="controls">
				<input type="hidden" id="inputEmail" name="id" value="<?php echo $userRow['id']; ?>" required >
				<input type="text" id="inputEmail" name="confirmPassword"  required >
				</div>
			</div>          
			<div class="control-group">
				<div class="controls">
				<button name="edit" type="submit" class="btn btn-success"><i class="icon-save icon-large"></i>&nbsp;Update password</button>
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
	
	mysql_query("update users set  First_name = '$firstname' , Last_name = '$lastname'  where id='$id'")or die(mysql_error()); ?>
	<script>
	window.location="../Uconnect/accountSetting.php";
	</script>
	<?php
	}
	?>