 <script type="text/javascript" src="../js/countries.js"></script>
 <link rel="stylesheet" type="text/css" href="registerForm.css" />
    <div id="edit<?php echo $id; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body">
			<div class="alert alert-info"><strong>Edit User</strong></div>
	<form class="form-horizontal" method="post" id="customRegistrationForm">
            <div class="control-group">
				<label class="control-label" for="inputEmail">User name</label>
				<div class="controls">
				<input type="hidden" id="inputEmail" name="id" value="<?php echo $userRow['id']; ?>" required>
				<input type="text" id="inputEmail" disabled="disabled"name="username" value="<?php echo $userRow['username']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">First Name</label><span id="fnameInfo"></span>
				<div class="controls">
				<input type="hidden" id="inputEmail" name="id" value="<?php echo $userRow['id']; ?>" required>
				<input type="text" id="inputEmail"  class="firstname" name="firstname" value="<?php echo $userRow['First_name']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputPassword">Last Name</label><span id="lnameInfo"></span>
				<div class="controls">
				<input type="text"  class="lastname" name="lastname" id="inputPassword" value="<?php echo $userRow['Last_name']; ?>" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Email</label>
				<div class="controls">
	
				<input type="text" id="inputEmail"  disabled="disabled" name="email" value="<?php echo $userRow['email']; ?>" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Phone number</label><span id="phoneInfo"></span>
				<div class="controls">

				<input type="text" id="inputEmail" class="phone" name="phone_number" value="<?php echo ($phone !='' || $phone != -1)? $userRow['phone_number'] : '' ; ?>" required >
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">Country</label><span id="countryInfo"></span>
				<div class="controls">
                
            
				<input type="text" id="inputEmail"  disabled="disabled" name="OldCountry" value="<?php echo $userRow['country']; ?>" required  ><br />
	Change Country <select id="country" class="country" name ="country" onChange="populateCountries(this.id,'state')"></select><span id ="countryInfo">(Optional)</span>
                </div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">State</label><span id="stateInfo"></span>
				<div class="controls">
                

				<input type="text" id="inputEmail"  disabled="disabled" name="OldState" value="<?php echo $userRow['state']; ?>" required ><br />
    Change State <select class="state" name ="state" id ="state"></select><span id ="stateInfo">(Optional)</span>
                    	<script language="javascript">
        				populateCountries("country", "state");
         			</script> 	
               
                </div>
			</div>  
			<div class="control-group">
				<label class="control-label" for="inputEmail">Enter your life tweet</label><span id="bioInfo"></span>
				<div class="controls">
             <textarea id="inputEmail"  class="bio" name="bio_info" rows="3" cols="50" style="resize: none;"><?php echo$userRow['bio']; ?></textarea>
				
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
	
	$user_id = @$_POST['id'];
	$fn= @$_POST['firstname'];
	$ln= @$_POST['lastname'];
    $bio = @$_POST['bio_info'];
    $ph = @$_POST['phone_number'];
    $country = @$_POST['country'];
    $state = @$_POST['state'];
     if($fn&&$ln){
        if( strlen($fn) >= 2 && strlen($ln) >= 2 && $state != '' && $state != -1 && $country != '' && $country != -1){
           	mysql_query("update users set First_name = '$fn',Last_name = '$ln', phone_number = '$ph', bio ='$bio',
                 state ='$state', country ='$country' where id='$user_id'")or die(mysql_error()); 
        }
        else if(strlen($fn) >= 2 && strlen($ln) >= 2){
            mysql_query("update users set First_name = '$fn',Last_name = '$ln', phone_number = '$ph', bio ='$bio'
                 where id='$user_id'")or die(mysql_error());             
        }
        else{
            echo 'Your first and last name should be at least 2 letters';
        }
     }else{
        echo 'Your first name and last name should not be empty';
     }
    
	
 ?>
	<script>
	window.location="../Uconnect/accountSetting.php";
	</script>
	<?php
	}
	?>