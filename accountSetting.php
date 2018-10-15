 <?php include("header_inc/header.php");
 ob_start();
	if($user){
		
	}
	else{
			die("You must be logged in to view this page");
		}


?>
	<!-- Bootstrap -->
			<link href="csss/bootstrap.css" rel="stylesheet" media="screen" />
			<link href="csss/bootstrap-responsive.css" rel="stylesheet" media="screen" />
			<link href="csss/docs.css" rel="stylesheet" media="screen" />
			<link href="csss/diapo.css" rel="stylesheet" media="screen" />
			<link href="csss/font-awesome.css" rel="stylesheet" media="screen" />
			<link rel="stylesheet" type="text/css" href="csss/style.css" />
			<link rel="stylesheet" type="text/css" href="csss/DT_bootstrap.css" />
	
        	<!-- js -->			
            <script src="jss/jquery-1.7.2.min.js"></script>
            <script src="jss/bootstrap.js"></script>
        	<script src="jss/jquery.hoverdir.js"></script>
        	<script type="text/javascript" charset="utf-8" language="javascript" src="jss/jquery.dataTables.js"></script>
            <script type="text/javascript" charset="utf-8" language="javascript" src="jss/DT_bootstrap.js"></script>
    
            
            <script type="text/javascript" charset="utf-8" language="javascript" src="jss/jquery.dataTables.js"></script>
            <script type="text/javascript" charset="utf-8" language="javascript" src="jss/DT_bootstrap.js"></script>
        	<script type='text/javascript' src='scriptss/jquery.easing.1.3.js'></script> 
            <script type='text/javascript' src='scriptss/jquery.hoverIntent.minified.js'></script> 
            <script type='text/javascript' src='scriptss/diapo.js'></script> 

		
<style>
 body{
    	background-color: #FFFAFA  ;
}
</style> 
 <link rel="stylesheet" href="css/accountsettingstyle2.css" />
 
 <script type="text/javascript" src="js/countries.js"></script>
<script>
	$(document).ready(function(){
	   $("changepwd").click(function(){ 
	        $('#changePassSuccess').hide(5000);
	   });
		 
		});
			
	});
</script> 


<?php
	$senddata =@$_POST['senddata'];
	//password variable
	$old_password =@$_POST['oldpassword'];
	$new_password = @$_POST['newpassword'];
	$repeat_password = @$_POST['newpassword2'];
	
	$changePwd = "";
	$profilePic = "";
	
	if($senddata){
		//If the form is submitted ...
		$password_query = mysql_query("SELECT * FROM users WHERE username ='$user'");
		while($row=mysql_fetch_assoc($password_query)){
				$db_password = $row['password'];
				
				//md5 the old password before we check the matches
				$old_password_md5 = md5($old_password);
				
				//check whether old password equals $db_password
				if($old_password_md5 == $db_password){
					
					//continue chnaging the users password
					//check whether the two new password match
					if($new_password == $repeat_password){
					
						if(strlen($new_password)<=4){
								$changePwd = '<div style="color: #FF0000; font-size: 14px;">Sorry! But your password must be at least 5 character<div>';
							}
						else{
					
						//md5 the new password before we add to the database
							$new_password_md5 = md5($new_password);
							
						//Great: Update the users passwords
					mysql_query("UPDATE users SET password='$new_password_md5' WHERE username='$user'");
						$changePwd = '<div style="color: #00CD00; font-size: 14px;">Password update successful!</div>';
						}
						}
					else{
						$changePwd = '<div style="color: #FF0000; font-size: 14px;">You passwords don`t match</div>';	
					}
					
				}
				else{
						$changePwd = '<div style="color: #FF0000; font-size: 14px;">The old password is incorrect  </div>';
					}
			}
	}
	else{
	
		}	
			
			//Check whether the user has upload a profile pic or not
		$check_pic = mysql_query("SELECT profile_pic FROM users WHERE username ='$user'");
		$get_pic_row = mysql_fetch_assoc($check_pic);
        $profile_pic ="";
		$profile_pic_db = $get_pic_row['profile_pic'];
        //check if user is male or female
        $checkIfMale = mysql_query("SELECT profile_pic, sex FROM users WHERE username ='$user' AND sex ='Male'");
        $countCheckMale = mysql_num_rows($checkIfMale);
		if($profile_pic_db == ""){
		       if($countCheckMale != 0 && $countCheckMale != -1){
				    $profile_pic = "img/male_default_pic.jpg";
                    }
                else{
                    $profile_pic = "img/female_default_pic.jpg";
                }
			}
			
		else{
					$profile_pic = "userpictures/profile_pic/".$profile_pic_db;
			}
			
			
			
			
				
	
	//Profile Image upload script
		if(isset($_FILES['profilepic'])){
			if(((@$_FILES["profilepic"]["type"]=="image/jpeg") ||(@$_FILES["profilepic"]["type"]=="image/png") || (@$_FILES["profilepic"]['type']=="image/gif") || (@$_FILES["profilepic"]["type"]=="image/bmp")) &&((@$_FILES["profilepic"]["type"]<1048576))){  //1 MEgabytes
				
				$chars ="abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUQXYZ0123456789";
				$rand_dir_name = substr(str_shuffle($chars),0,45); // display a random first 15 characters
				mkdir("userpictures/profile_pic/$rand_dir_name");
				
				if(file_exists("userpictures/profile_pic/$rand_dir_name/".@$_FILES["profilepic"]["name"]))
				{
					$profilePic = '<div style="color: #00CD00; font-size: 14px;">'.@$_FILES['profilepic']["name"]."Already exists</div>";		
					
				}
				else{
					move_uploaded_file($_FILES["profilepic"]["tmp_name"],"userpictures/profile_pic/$rand_dir_name/".@$_FILES["profilepic"]["name"]);
					//echo "Uploaded and stored in userdata/profile_pic/$rand_dir_name/".$_FILES['profilepic']['name'];
				$profile_pic_name = $_FILES['profilepic']['name'];
				$profile_pic_query= mysql_query("UPDATE users SET profile_pic='$rand_dir_name/$profile_pic_name' WHERE username= '$user'");
				
				//header("location: account_settings.php");
				$profilePic ="<div style='color: #00CD00; font-size: 14px;'>Picture uploaded successfully</div>";
				}
				}
				else{
						$profilePic= '<div style="color: #FF0000; font-size: 14px;">Invalid File Your Image must be no larger than 1MB and it must either be a .jpg, .gif, .bmp. .png</div>';
					}
			}
		
		
?>
 <div id = "accountSettingPage">
    <div id ="wrapSettings">
        <span id="editInfo"><h2>Welcome to my Account Settings</h2></span>
        <hr />

<?php /*?>This part handle the form for the upload image file<?php */?>

<?php 
   //Check whether the user has upload a profile pic or not
	$getProfilePic = mysql_query("SELECT * FROM users WHERE username = '$user'");
	$profile_pic ='';
	$userId = '';
	while($getRow = mysql_fetch_assoc($getProfilePic)){
	$profile_pic_db = $getRow['profile_pic'];
	$userId = $getRow['id'];
    
    //check if user is male or female
    $checkIfMale = mysql_query("SELECT profile_pic, sex FROM users WHERE username ='$user' AND sex ='Male'");
    $countCheckMale = mysql_num_rows($checkIfMale);
	if($profile_pic_db == ""){
		       if($countCheckMale != 0 && $countCheckMale != -1){
				    $profile_pic = "img/male_default_pic.jpg";
                    }
                else{
                    $profile_pic = "img/female_default_pic.jpg";
                }
			}
			
		else{
					$profile_pic = "userpictures/profile_pic/".$profile_pic_db;
			}
	
?>
<div style='width : 40%;float:left;' >
<form action="accountSetting.php" method ="POST" enctype ="multipart/form-data">

<span id="profilepicInfo<?php echo $userId; ?>"><img src="<?php echo $profile_pic; ?> " width="190" height="210"  /></span>

<input type="file" name = "profilepic" /> <br />
<input type="submit" name="uploadpic" value ="Upload Image" id="uploadprofilepic"/><span id="profilepicInfo"><?php echo $profilePic;?></span>
</div>
<?php

	}
?>



<div style='width : 60%;  float:right;'>
   <table>
    <th><h2 style="color: #00BFFF; font-family: pristina; font-size: 25px;">My personnal info</h2></th>
   
    
    
    <?php
		$Query_User = mysql_query("SELECT * FROM users WHERE username = '$user'");
		$fN ='';
		$lN='';
		$email="";
		while($userRow = mysql_fetch_assoc($Query_User)){
				$fN = $userRow['First_name'];
				$lN = $userRow['Last_name'];
                $UN = $userRow['username'];
				$email = $userRow['email'];
				$country = $userRow['country'];
				$state = $userRow['state'];
                $id = $userRow['id'];
                $phone = $userRow['phone_number'];
                //$dateOfBirth = $userRow[''];
                $dayOfBirth = $userRow['dayOfBirth'];
                $monthOfBirth = $userRow['monthOfBirth'];
                $yearOfBirth = $userRow['yearOfBirth'];
                $age = $userRow['age'];
                $aboutMe = $userRow['bio'];
                
  		
	    echo '<tr class="infoUser"><td>Username:</td>'.' <td class="info1">'.$UN.'</td></tr>';
		echo '<tr class="infoUser"><td>First name:</td>'.' <td class="info1">'.$fN.'</td></tr>';
		echo '<tr class="infoUser"><td>Last name:</td>'.' <td class="info1">'.$lN.'</td></tr>';
		echo '<tr class="infoUser"><td>User Email:</td>'.' <td class="info1">'.$email.'</td></tr>';
        if($phone != '' && $phone != -1){
            	echo '<tr class="infoUser"><td>Phone number:</td>'.' <td class="info1">'.$phone.'</td></tr>';
        }
        else{
            	echo '<tr class="infoUser"><td>Phone number:</td>'.' <td class="info1">N/A</td></tr>';
        }
	
		if($country != '' && $country != -1){
			echo '<tr class="infoUser"><td>Country:</td>'.' <td class="info1">'.$country.'</td></tr>';
			}
		else{
			echo '<tr class="infoUser"><td>Country:</td>'.' <td class="info1">N/A</td></tr>';	
				}
		if($state != '' && $state != -1){
			echo '<tr class="infoUser"><td>State:</td>'.' <td class="info1">'.$state.'</td></tr>';
			}
		else{
			echo '<tr class="infoUser"><td>State:</td>'.' <td class="info1">N/A</td></tr>';	
				}
                
        if($dayOfBirth != 0 && $monthOfBirth != 0 && $yearOfBirth != 0 && $dayOfBirth != '' && $monthOfBirth != '' && $yearOfBirth != ''){
            switch($monthOfBirth){
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                                
                case 1:
                    echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
                break;                                
            }
            
        }else{
		echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
         }
        if($age != '' && $age != -1 && $age != 0){
            echo '<tr class="infoUser"><td>Age:</td>'.' <td class="info1">'.$age.'</td></tr>';
          }
          else{
            echo '<tr class="infoUser"><td>Age:</td>'.' <td class="info1">N/A</td></tr>';
          }
        if($aboutMe != '' && $aboutMe != -1){
            echo '<tr class="infoUser"><td>User Mind:</td>'.' <td class="info1">'.$aboutMe.'</td></tr>';
        }
        else{
            echo '<tr class="infoUser"><td>User Mind:</td>'.' <td class="info1">N/A</td></tr>';
        }
        ?>
         <a rel="tooltip"  title="Edit" id="e<?php echo $id; ?>" href="#edit<?php echo $id; ?>" 
                data-toggle="modal" class="btn btn-success"><i class="icon-pencil icon-large">Edit user Info
                </i></a>
               	<?php include('updateAccount/modal_edit_user.php'); ?>
         <?php
	 }
	?>
    </table>
</div>
<style>

</style>
<br clear="all" />
<hr />
<?php /*?>SECTION FOR CHANGING PASSWORD<?php */?>
   <table>
        <tr>
            <td><form action="accountSetting.php" method="POST" id='customPassword'>
        
                <h2 style="color: #00BFFF; font-family: pristina; font-size: 25px;"><b>Change Your Password</b></h2>                
                 	      <tr>
                			<td><label for="oldpassword">Old Password</label></td>
                			<td><input id ="oldpassword" name ="oldpassword" type ="password" class="member" /></td>
                			<td><span id ="oldpasswordInfo"> What`s your oldpassword?</span></td>
                          </tr>
                          <tr>
                			<td><label for="newpassword">New Password</label></td>
                			<td><input id ="newpassword" name ="newpassword" type ="password" class="member" /></td>
                			<td><span id ="newpassword1Info"> Enter new password?</span></td>
                	      </tr>
                          <tr>
              			    <td><label for="name">Confirm password</label></td>
                			<td><input id ="newpassword2" name ="newpassword2" type ="password" class="member" /></td>
                			<td><span id ="newpassword2Info"> What`s your name?</span></td>
                         </tr>
                  <tr><td>&nbsp;</td><td><input type="submit" name ="senddata" value="Update Information"  id="changepwd"/></td></tr>
                  <div id="changePassSuccess"><?php echo $changePwd; ?> </div>
            </form>
            </td>
            
            
          </tr>
       </table>
        
     
<hr />
<h2><p>Close my account:</p></h2>
<form action="closeaccount.php" method ="POST" enctype ="multipart/form-data">
<input type="submit" name="closeaccount" value ="Close my account" />
</form >
<hr />
</div>
</div>
<br clear="all" />
<br clear="all" />


