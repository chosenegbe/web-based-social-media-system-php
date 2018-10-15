<?php 
include("header_inc/header.php"); 
	if($user){
		
	}
	else{
			die("You must be logged in to view this page");
		}
        
 ?>
 
<!-- Add fancyBox -->
<link rel="stylesheet" href="source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="source/jquery.fancybox.pack.js"></script>
<link rel = "stylesheet" type = "text/css" href = "css/cloudAnimation.css" /> 

<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>

 <style>

 body{
	background-color: #95a5a6;
	margin: 0px;
	
	font-family: sans-serif,Tahoma, Geneva, ;
	}
    a{
        font-family: sans-serif, Tahoma, Geneva;
    }

 </style>

 
 <?php
$firstname = "";
$username = "";
$lastname = "";
$profile_pic = "";
	if(isset($_GET['u'])){
			$username = mysql_real_escape_string($_GET['u']);
			if(ctype_alnum($username)) {// checks user exist
				$check = mysql_query("SELECT username, First_name, Last_name FROM users WHERE username = '$username'");
				if(mysql_num_rows($check)==1){
					$get = mysql_fetch_assoc($check);
					$username = $get['username'];
					$firstname = $get['First_name'];
                    $lastname = $get['Last_name'];
					}
				else{
						echo "<meta http-equiv=\"refresh\"content=\"0; url = http://localhost/UConnect/index.php\">";
						exit();
					}
			}
		
		}

?>            
 <script type="text/javascript">
	$(document).ready(function(){
		$(".menu  li").hover(function(){
			$(this).children(":hidden").slideDown();
		},function(){
			$(this).parent().find("ul").slideUp();
		
		});
        
			
	});
</script> 
<?php
     if(isset($_POST['sendmsg'])){
        header("location:send_msg.php?u=$username");
     }
    
    			
		//Check whether the user has upload a profile pic or not
		$check_pic = mysql_query("SELECT profile_pic FROM users WHERE username ='$username'");
		$get_pic_row = mysql_fetch_assoc($check_pic);
        
         //check if user is male or female
        $checkIfMale = mysql_query("SELECT profile_pic, sex FROM users WHERE username ='$username' AND sex ='Male'");
        $countCheckMale = mysql_num_rows($checkIfMale);
		$profile_pic_db = $get_pic_row['profile_pic'];
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

		
        
          /*?> This section handles the friend request system<?php */
  $errorMsg ="";
 if(isset($_POST['addfriend'])){
	 	$friend_request = $_POST['addfriend'];
		
		$user_to = $username;
		$user_from = $user;
		
		if($user_to == $user){
			$errorMsg = "<script type='text/javascript'>alert('You can`t send a friend request to yourself')</script>"; 
			}
			else{
				$create_request = mysql_query("INSERT INTO friend_requests VALUES('','$user_from','$user_to')");
				$errorMsg = "<script type='text/javascript'>alert('Your request has been sent')</script>";
				}
	 }
	 
else{
	//do nothing
	
	
	}
 	

?>
<br clear="all" />
<div class="homePageBody">
<!--Beginning of LeftSider-->
  <div class="leftSider">
  	 <div class="profileImage">
       <a class="fancybox" rel="group" href ="<?php echo $profile_pic; ?>" title = "<?php echo $username; ?>`s Profile"><img src="<?php echo $profile_pic ?>" height="204" width= "100%" alt="<?php echo $username; ?>`s Profile" title = "<?php echo $username; ?>`s Profile" /></a> <br />      
       </div>
     <div><?php echo $username. "`s profile";?></div>
     
  <form action ="<?php echo $username; ?>" method="POST" >


  <?php /*?> THE NEXT PHP BLOCK IS TO PREVENT USER FROM SENDING FRIEND REQUEST MULTIPLE TIME<?php */?>
  
  

<?php

	$friendArray = "";
	$friendArray25 =""; //slice the array in 25 parts
	$countFriends = "";
	$addAsFriend = "";
	
	$count_friend_request_for_a_specify_group = "";
	//Try to query the friend request database
	$selectFromRequest = mysql_query("SELECT user_from, user_to FROM friend_requests WHERE (user_from ='$user' AND user_to ='$username') OR (user_from ='$username' AND user_to ='$user') ");
	
	//count the number of friend request 
	$count_friend_request_for_a_specify_group = mysql_num_rows($selectFromRequest);
	//querying the user database
	$selectFriendQuery = mysql_query("SELECT friend_array FROM users WHERE username ='$username'");
	$friendRow = mysql_fetch_assoc($selectFriendQuery);
	$friendArray = $friendRow['friend_array'];
	
	if($friendArray != ""){
		$friendArray = explode(",",$friendArray);
		$countFriends = count($friendArray);
		$friendArray25 = array_slice($friendArray,0,25);
		
	$i = 0;
	
	 if(is_array($friendArray) && in_array($user,$friendArray)){
		$addAsFriend = '<input type="submit" name= "removefriend" value ="Unfriend" style = "background-color:#50F; font-size: 12px;" />';
		//header("location: $username");
		}
	
	else{
		$addAsFriend = '<input type="submit" class="addFriend" name= "addfriend" value ="Add Friend" style = "background-color:#50F; font-size: 12px;" />';
		
		}
	echo  ($username != $user)? $addAsFriend: '';
	}
	else if($count_friend_request_for_a_specify_group >=1){
		$addAsFriend = '<input type="submit" name= "cancelRequest" value ="Cancel Request" style = "background-color:#50F; font-size: 12px;" />';
		
	if(@isset($_POST['cancelRequest'])){
		$delete_request = mysql_query("DELETE FROM friend_requests WHERE (user_from ='$user' AND user_to ='$username') OR (user_from ='$username' AND user_to ='$user') ");
		
		echo "<script type='text/javascript'>alert('Friend request $username has been cancelled!')</script>";
		header("location: $username");
		}
		//header('location: $user');
		echo $addAsFriend;
		}
	
	else{
			$addAsFriend = '<input type="submit" class="addFriend" name= "addfriend" value ="Add Friend" style = "background-color:#50F; font-size: 12px;"/>';
			//header("location:$username");
			echo $addAsFriend;
		}
		//user = logged in user
		//username = user who owns profile
		if(@$_POST['removefriend']){
			//Friend array for logged in users
			$add_friend_check = mysql_query("SELECT friend_array FROM users WHERE username = '$user'");
			$get_friend_row = mysql_fetch_assoc($add_friend_check);
			$friend_array = $get_friend_row['friend_array'];
			$friend_array_explode = explode(",",$friend_array);
			$friend_array_count = count($friend_array_explode);
			
			//Friend array for the users who owns profile
			$add_friend_check_username = mysql_query("SELECT friend_array FROM users WHERE username = '$username'");
			$get_friend_row_username = mysql_fetch_assoc($add_friend_check_username);
			$friend_array_username = $get_friend_row_username['friend_array'];
			$friend_array_explode_username = explode(",",$friend_array_username);
			$friend_array_count_username = count($friend_array_explode_username);
			
			
			
			//we are going to consider the ',' when checking for a user
			//so that the comma should not be counted
			
			$usernameComma = ",".$username;
			$usernameComma2 = $username . ",";
			
			$userComma = ",".$user;
			$userComma2 = $user . ",";
			$friend1 = "";
			$friend2 = "";
			if(strstr($friend_array,$usernameComma)){ //check the string for the existence of a word
				$friend1 = str_replace("$usernameComma","","$friend_array");
				}
				
			else if(strstr($friend_array,$usernameComma2)){ //check the string for the existence of a word
				$friend1 = str_replace("$usernameComma2","","$friend_array");
				//$friend1 = $friend_array - $username
				}
			else if(strstr($friend_array,$username)){ //check the string for the existence of a word
				$friend1 = str_replace("$username","","$friend_array");
				}
			
			//Remove logged in user from other persons array
			if(strstr($friend_array,$userComma)){ //check the string for the existence of a word
				$friend2 = str_replace("$userComma","","$friend_array");
				}
				
			else if(strstr($friend_array,$userComma2)){ //check the string for the existence of a word
				$friend2 = str_replace("$userComma2","","$friend_array");
				}
			else if(strstr($friend_array,$user)){ //check the string for the existence of a word
				$friend2 = str_replace("$user","","$friend_array");
				}
			$removeFriendQuery = mysql_query("UPDATE users SET friend_array='$friend1' WHERE username ='$user'");
			$removeFriendQuery_username = mysql_query("UPDATE users SET friend_array='$friend2' WHERE username ='$username'");
			echo "<script type='text/javascript'>alert('Friend Removed...')</script>";
			
			}

?>
<!--Script to handle the upload images-->
<?php  

$picture_post = @$_POST['uploadimg'];
$uploadImage = "";			
		//Profile Image upload script
		if(isset($_FILES['uploadimg'])){
			if(((@$_FILES["uploadimg"]["type"]=="image/jpeg") ||(@$_FILES["uploadimg"]["type"]=="image/png") || (@$_FILES["uploadimg"]['type']=="image/gif") || (@$_FILES["uploadimg"]["type"]=="image/bmp")) &&((@$_FILES["uploadimg"]["type"]<1048576))){  //1 MEgabytes
				
				$chars ="abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUQXYZ0123456789";
				$rand_dir_name = substr(str_shuffle($chars),0,30); // display a random first 15 characters
				mkdir("userpictures/picture_post/$rand_dir_name");
				
				if(file_exists("userpictures/picture_post/$rand_dir_name/".@$_FILES["uploadimg"]["name"]))
				{
					$picture_post = '<div style="color: #00CD00; font-size: 14px;">'.@$_FILES['uploadimg']['name'].'Already exists</div>';		
					
				}
				else{
					move_uploaded_file($_FILES["uploadimg"]["tmp_name"],"userpictures/picture_post/$rand_dir_name/".@$_FILES["uploadimg"]["name"]);
					//echo "Uploaded and stored in userdata/user_photos/$rand_dir_name/".$_FILES['uploadimg']['name'];
				$profile_pic_name = $_FILES['uploadimg']['name'];
				$uploadImage = $rand_dir_name.'/'.$profile_pic_name;
				//header("location: account_settings.php");
				
				$picture_post ="<div style='color: #00CD00; font-size: 14px;'>Picture uploaded successfully</div>";
				}
				}
				else{
				$picture_post = '<div style="color: #FF0000; font-size: 14px;">Invalid File Your Image must be no larger than 1MB and it must either be a .jpg, .gif, .bmp. .png</div>';
					}
			}


?>

<!--Section for the post form-->
<?php
		/*This handle the post section*/	
$post = mysql_real_escape_string(trim(htmlentities(@$_POST['post'])));

	if($post != "" && $picture_post != ""){
		$date_added = strtotime('NOW');
		$added_by = $user;
		$user_posted_to = $user;
		
		$sqlCommand = "INSERT INTO posts VALUES('','$added_by','$user_posted_to','$post','$uploadImage','$date_added')";
		$query = mysql_query($sqlCommand) or die(mysql_error());
	}
	else if($post != "" && $picture_post == ""){
		$date_added = strtotime('NOW');
		$added_by = $user;
		$user_posted_to = $user;
		
		$sqlCommand = "INSERT INTO posts VALUES('','$added_by','$user_posted_to','$post','','$date_added')";
		$query = mysql_query($sqlCommand) or die(mysql_error());
		}
	else if($post != "" && $picture_post != ""){
		$date_added =strtotime('NOW');
		$added_by = $user;
		$user_posted_to = $user;
		
		$sqlCommand = "INSERT INTO posts VALUES('','$added_by','$user_posted_to','$post','$uploadImage','$date_added')";
		$query = mysql_query($sqlCommand) or die(mysql_error());
		}
		
		//Check whether the user has upload a profile pic or not
		$check_pic = mysql_query("SELECT profile_pic FROM users WHERE username ='$user'");
		$get_pic_row = mysql_fetch_assoc($check_pic);
		$profile_pic_db = $get_pic_row['profile_pic'];
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
    
    <?php /*?><input type="submit" name ="addfriend" value ="Add a friend" /><?php */?>
 <?php if($user != $username){ ?>
    <input type="submit" name ="sendmsg"  value ="Send SMS" style = 'background-color:#50F; font-size: 12px;'/>
  <?php } ?>
    </form>
     <div class="userReflections">Say something captivating about yourself</div>
     
<?php
	
	$get_friend_check = mysql_query("SELECT friend_array FROM users WHERE username='$user'");
		$get_friend_row = mysql_fetch_assoc($get_friend_check);
		$friend_array= $get_friend_row['friend_array'];
		$friendArray_explode = explode(",",$friend_array);
		$friendArray_count = count($friendArray_explode);
?>
  	
     <div class="userFriendList"><h4><?php echo $username. "`s Friends"?></h4>
      <?php
        	echo '<div id = "profileFriends" style="height:auto;">';
	
	if($countFriends !=0){
		foreach($friendArray25 as $key => $value){
			$i++;
			$getFriendQuery = mysql_query("SELECT * FROM users WHERE username= '$value' LIMIT 1");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$friendUsername = $getFriendRow['username'];
			$friendProfilePic = $getFriendRow['profile_pic'];
            
            //check if user is male or female
            $checkIfMale = mysql_query("SELECT profile_pic, sex FROM users WHERE username ='$value' AND sex ='Male'");
            
            $countCheckMale = mysql_num_rows($checkIfMale);			
			if($friendProfilePic == ""){
			  if($countCheckMale != 0 && $countCheckMale != -1){
					echo "<a href = ".$friendUsername."><img src='img/male_default_pic.jpg' 
					title =\"$friendUsername's Profile\" height ='50' width = '40'
					style = \"padding-right: 6px;\"' />
					</a>";
                    }
              else{
					echo "<a href = ".$friendUsername."><img src='img/female_default_pic.jpg' 
					title =\"$friendUsername's Profile\" height ='50' width = '40'
					style = \"padding-right: 6px;\"' />
					</a>";                
              }
				}
			else{
					echo "<a href = ".$friendUsername."><img src='userpictures/profile_pic/$friendProfilePic' 
					title =\"$friendUsername's Profile\" height ='50' width = '40'
					style = \"padding-right: 6px;\"' />
					</a>";
				}
			
			}
		}
	else{
		echo 'Has no friends yet';
		}
    	echo '</div>';
      
      ?>
     
     </div>
  
  </div>
 <!-- of LeftSlider-->
  <div class="bodyPostWrapper">
    <div class="postForm">
        <div class="post-insert"> 
        <form method= "POST" action ="<?php echo $username; ?>" enctype ="multipart/form-data" id="post-insert-text">
                    <input type="file" name="uploadimg" id="uploadimg"  placeholder="Upload Image of Advertisement.." multiple="multiple" /><br />
                    <div class="post-insert-container" >
                        <textarea id="post" name="post" class="post-insert-text" placeholder="Say Something here for your pals to see, you can also add a picture"></textarea>
                    </div>
                    <div class="post-button-wrapper">
                            <input class="submitMainPost" type="submit" id="send" name="send" value="Post"  style="background: #6989CC; width: 110px;" /> 
                    </div>             
        </form>
 </div>   
</div><br /> <br />
    
    <div class ="profilePosts">
   		
         
         
         
         <?php 
	$post_id = '';
	  $getposts = '';
      $getPosts1 = "SELECT * FROM posts WHERE user_posted_to ='$username' or posted_by ='$username' ";
      $queryPost = mysql_query($getPosts1);
      $countPost = mysql_num_rows($queryPost);
    
      if($countFriends ==0 && ($username != $user)){
         echo 'You cannot see anything on user time line, send him a friend Request';
      }
      elseif($username == $user && $countPost == 0){
         echo 'Welcome '.$user.'! You have nothing on your timeline, Make your first post!';
      }
       else{
		foreach($friendArray25 as $key => $value){
			$i++;
	$getposts = mysql_query("SELECT * FROM posts WHERE user_posted_to='$username'  OR posted_by ='$username' ORDER BY id DESC ") or die(mysql_error());
		}
        
	while($rows = mysql_fetch_assoc($getposts)){
				$id = $rows['id'];
				$post_id = $rows['id'];
				$body = $rows['post_body'];
				$date_added = $rows['posted_on'];
				$added_by = $rows['posted_by'];
				$user_posted_to = $rows['user_posted_to'];
				$uploadImage = $rows['posted_picture'];
				$get_user_info = mysql_query("SELECT * FROM users WHERE username ='$added_by' ");
				$get_info = mysql_fetch_assoc($get_user_info);
				$profilepic_info= $get_info['profile_pic'];
				/*Get the picture from its folder*/
				$posted_image =  "userpictures/picture_post/".$uploadImage;
				
			    if($profilepic_info==""){
                		       if($countCheckMale != 0 && $countCheckMale != -1){
                				    $profile_pic_info = "img/male_default_pic.jpg";
                                    }
                                else{
                                    $profile_pic_info = "img/female_default_pic.jpg";
                                }
					 }
				else{
						$profilepic_info = "userpictures/profile_pic/".$profilepic_info;
					}
                    
 
 				echo"
				<p />
				<div class= 'newsFeedPostOnProfile'>
				
					<div style='float: left; padding-left: 4px; padding-top: 4px; padding-right: 7px;'><a href='http://localhost/UConnect/$username'><img src ='$profilepic_info' height='50' width ='40' /></a> </div>"; 
					echo '<span  class = "menu" style="float:right;">
						  <ul><li><img src="img/downBar.png" width="20" height="20" alt="down" />
								<ul class="dropMainDelete">';
								if($user==$username || $user ==$added_by){
									
									echo   '<li>Edit</li>
                                    
											<li id="delPost">Delete</li>';
								}
								echo '
									
								</ul>
							</li>
						</ul>
					</span>';
			
				echo ($user==$added_by)?"<div class= 'posted_by' ><a href='$user'>$firstname $lastname </a>         <span class ='settingTimePost$post_id'>".time_elapsed_string($date_added)."</span></div> <br />" :
				"<div class= 'posted_by' ><a href='$added_by'>$added_by</a> posted on your profile <span class ='settingTimePost$post_id'>".time_elapsed_string($date_added)."</span>  </div> <br />";
	 
				
				echo ($uploadImage == "")?"<div style= 'word-wrap: break-word;overflow: hidden; line-height:1.8em;
					 font-size:15px; margin-left: 1%;'>$body <br /><p /><br /><br /></div>":
				"<div style= 'word-wrap: break-word;overflow: hidden; line-height:1.8em;
					 font-size:15px; margin-left: 6%;'>$body <br /><br />
				 <a class='fancybox' rel='group' href='$posted_image' title=''><img src='$posted_image' width='400' height='500' alt=''></a>
					 <br /><p /><br /><br /></div>";
                     
               echo '</div>'; 
             					
			?>
            
     
  
             <script type="text/javascript">
             
             	$(setInterval(function(){
			     $('.settingTimePost<?php echo $post_id;?>').load('count/timePassForMainPost.php?post_id='+<?php echo $post_id;?>);
	            },10000));
          

             </script>           
         <?php
				
			} //end of main while 
            
   }
  	
?>
                
 <script type="text/javascript">
	$(document).ready(function(){
		$(".menu  li").hover(function(){
			$(this).children(":hidden").slideDown();
		},function(){
			$(this).parent().find("ul").slideUp();
		
		});
			
	});
 
</script>       

         
         
         
         
         
         
         
         
         
         
         
         
    </div>
  </div><!--End of bodyPostWrapper-->
<div class="rightSider">
    <div id="userPersonaldetail">
    <table>
    <th><h2 style="color: #00BFFF;  font-size: 17px;">My personnal info</h2></th>
   
    
    
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
		echo '<tr class="infoUser"><td>Date of Birth:</td>'.' <td  class="info1">N/A</td></tr>';
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
        
	 }
	?>
    </table>

    
    
    
    </div>
  </div> <!--End of rightSider class-->


<!--Section to handle individual chat-->
<script type="text/javascript">
	<?php  
		$sql = mysql_query("SELECT * FROM pvt_im ORDER BY id DESC LIMIT 1");
		@$fetch = mysql_fetch_array($sql);
	?>
	    var lastid = <?php echo $fetch['id']; ?>
	
	
	
</script>

<!--Script for the private chat-->
<script type="text/javascript">
	$(document).ready(function(e) {
		var timer = setInterval(get,1000);
		$("#affi").animate({"scrollTop":$('#affi')[0].scrollHeight},0);
		$("#scrolls").click(function(){
			$("#affi").animate({"scrollTop" :$('#affi')[0].scrollHeight},0);
			$(this).hide();
			});
		$('#affi').scroll(function(){
			var height = $(this).height(); //300
			var all = $(this)[0].scrollHeight; //964
			var top = $(this).scrollTop(); //654
			var get = all - height;
			var divide = all/6;
			//$('#goula').html(all - height);
			
			if(top <= get - divide){
				$('#affi').removeClass('bottom').addClass('top');
				}
			else{
				$('#affi').addClass('bottom').removeClass('top');
				}
			});

        $("#chat").keydown(function(e){
			//clearInterval(timer );
			var chat = $(this).val();
			if(e.keyCode==13 && !chat==""){
				$.post("individualChats/ajaxChat.php?un=<?php echo $username; ?>",{chat:chat},function(){
					$("#chat").val("");
					setInterval(get,1000);
					$("#affi").animate({"scrollTop" :$('#affi')[0].scrollHeight},0);
					});
				}
			});
			
		function get(){
			$.post("individualChats/ajaxChat.php?un=<?php echo $username; ?>",{lastid:lastid},function(data){
				$('#affi').append(data.msg);
				
				var classes = $("#affi").attr("Class");
				if(classes == "top"){
					 $("#scrolls").slideDown(1000).show();	
					 }else{
					$("#affi").animate({"scrollTop" :$('#affi')[0].scrollHeight},0);	
				}	
				lastid = data.lastid;
				},'json')	

            }
    });
	 
</script>
  

<?php  if($user == $username){  echo '';} else {?>
<div class="msg_box" style="right:4px;" >

	<div class="msg_head"><?php echo 'Private message with '.$username; ?></div>
        <div class="msg_wrap">
        	<div style="display:none; cursor:pointer;" id="scrolls">
                <img src="img/sent_icon.jpg" height="40" width="40" />
                	You have new message,click to see it
            </div>
                
                    <div id="affi">
                	<?php 
        			$sql = mysql_query("SELECT * FROM pvt_im WHERE user_from = '$user' AND user_to= '$username' 
                             OR user_from = '$username' AND user_to= '$user' 
	                        ORDER BY date_send ASC");
        			
        			while(@$get = mysql_fetch_array($sql)){
        			 $hoursAndMinutes = date('g:ia',$get['date_send']);
		              $user_from = $get['user_from'];
       				echo ($user == $user_from) ?'<div class="msg_a"><p><strong><font color="#66CDAA">'. $get['user_from'].'</font></strong>: <em>-'.$hoursAndMinutes.':</em> '.$get['IM_body'].'</p></div>':
		                  '<div class="msg_b"><p><strong><font color="#00FF7F">'. $get['user_from'].'</font></strong>: <em>:'.$hoursAndMinutes.':</em>-'.$get['IM_body'].'</p></div>';
        				
        			
			         	}
                    
		          ?></div>
                
                <div class="msg_footer" style="resize: none;"><textarea class="msg_input" rows="4" id="chat" ></textarea></div>
        </div>
</div>

<?php
}
?>




</div>

<?php 
	function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
?>