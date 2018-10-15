<?php 
include("header_inc/header.php"); 
 if($user){
		
    }
else{
			die("You must be logged in to view this page");
	}


ob_start(); 


?>
<style>
body{
    	background-color: #FFFAFA  ;
}

</style>
<?php 
    $firstname = "";
    $username = "";
    $profile_pic = "";
    $lastname= "";
    //GET THE USER INFORMATION FROM DATABASE
    		$user_info = mysql_query("SELECT username, First_name, Last_name FROM users WHERE username = '$user'");
    				
    		$get = mysql_fetch_assoc($user_info);
    		$username = $get['username'];
    		$firstname = $get['First_name'];
    		$lastname = $get['Last_name'];
		
?>


<?php  			
		//Check whether the user has upload a profile pic or not
		$check_pic = mysql_query("SELECT profile_pic FROM users WHERE username ='$username'");
		$get_pic_row = mysql_fetch_assoc($check_pic);
		$profile_pic_db = $get_pic_row['profile_pic'];
		if($profile_pic_db == ""){
				$profile_pic = "img/default_pic.png";
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
     <div><?php echo $user. "`s profile";?></div>
     <div class="userReflections">Say something captivating about yourself</div>
  	
     <div class="userFriendList"><h4><?php echo $user. "`s Friends"?></h4>
 <?php
	$friendArray = "";
	$friendArray50 =""; //slice the array in 12 parts
	$countFriends = "";
	$addAsFriend = "";
	
	//querying the user database
	$selectFriendQuery = mysql_query("SELECT friend_array FROM users WHERE username ='$user'");
	$friendRow = mysql_fetch_assoc($selectFriendQuery);
	$friendArray = $friendRow['friend_array'];
	
	
	$i = '';
	if($friendArray != ""){
		$friendArray = explode(",",$friendArray);
		$countFriends = count($friendArray);
		$friendArray50 = array_slice($friendArray,0,50);
		
	$i = 0;
	}

?>

<?php 
	echo '<div id = "profileFriends" style="height:auto;">';
	
	if($countFriends !=0){
		foreach($friendArray50 as $key => $value){
			$i++;
			
			$getFriendQuery = mysql_query("SELECT * FROM users WHERE username= '$value' LIMIT 1");
			$getFriendRow = mysql_fetch_assoc($getFriendQuery);
			$getFirstName = $getFriendRow['First_name'];
			$getLastName = $getFriendRow['Last_name'];
			$friendUsername = $getFriendRow['username'];
			$friendProfilePic = $getFriendRow['profile_pic'];
			
			if($friendProfilePic == ""){
					echo "<a href = ".$friendUsername."><img src='img/default_pic.png' 
					title =\"$getFirstName $getLastName's Profile\" height ='50' width = '40'
					style = \"padding-right: 6px;\"' />
					</a>";
				}
			else{
					echo "<a href = ".$friendUsername."><img src='userpictures/profile_pic/$friendProfilePic' 
					title =\"$getFirstName $getLastName's Profile\" height ='50' width = '40'
					style = \"padding-right: 6px;\"'/>
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
     </div><!--End of LeftSlider-->
     
  <div class="bodyPostWrapper">
    <div class="postForm">
        <div class="post-insert"> 
        <form method= "POST" action ="<?php echo $username; ?>" enctype ="multipart/form-data" id="post-insert-text">
                    <input type="file" name="uploadimg" id="uploadimg"  placeholder="Upload Image of Advertisement.." multiple="multiple"><br />
                    <div class="post-insert-container" >
                        <textarea id="post" name="post" class="post-insert-text" placeholder="Say Something here for your pals to see, you can also add a picture"></textarea>
                    </div>
          <div class="post-button-wrapper">
                <input type="submit" id="send" name="send" value="Post"  style="background: #6989CC; width: 60px;" /> 
         </div>               
        </form>
 </div>   
</div><br /> <br />
    
<div class ="profilePosts">
   		
         
         
         
	<?php 
	$post_id = '';
    $getPosts1 = "SELECT * FROM posts WHERE user_posted_to ='$username' or posted_by ='$username' ";
      $queryPost = mysql_query($getPosts1);
      $countPost = mysql_num_rows($queryPost);
      
      if($countFriends ==0 && ($username != $user)){
         echo 'You cannot see anything on user time line, send him a friend Request';
      }
      elseif($username == $user && $countPost == 0){
         echo 'You have nothing on your timeline, Make your first post!';
      }
       else{
		foreach($friendArray50 as $key => $value){
			$i++;
	$getposts = mysql_query("SELECT * FROM posts WHERE posted_by='$user' OR  posted_by ='$value' OR user_posted_to ='$user' ORDER BY id DESC ") or die(mysql_error());
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
					  $profilepic_info = "./img/default_pic.png";
					 }
				else{
						$profilepic_info = "./userpictures/profile_pic/".$profilepic_info;
					}
					?>
      
                <?php
              echo"
                <div class= 'newsFeedPostOnProfile'>
				
					<div style='float: left;'><a href='http://localhost/UConnect/$username'><img src ='$profilepic_info' height='50' width ='40' /></a> </div>"; 
				
				echo ($user==$added_by)?"<div class= 'posted_by' ><a href='$user'>$firstname $lastname </a></div> <br />" :
				"<div class= 'posted_by' ><a href='$added_by'>$added_by</a> posted on your profile</a></div> <br />";
	 
				
				echo ($uploadImage == "")?"<div style= 'word-wrap: break-word;overflow: hidden; line-height:1.8em;
					 font-size:15px;'>$body <br /><p /><br /><br /></div>":
				"<div style= 'word-wrap: break-word;overflow: hidden; line-height:1.8em;
					 font-size:15px;'>$body <br /><br />
				     <img src='$posted_image' width='400' height='500' alt=''>
					 <br /><p /><br /><br /></div>";				
             echo '</div>';
				
			} //end of main while 
            }
  	
?>
        
    </div>
  </div><!--End of bodyPostWrapper-->
  <div class="rightSider"></div>


</div>

<!-- Add jQuery library -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="source/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="source/jquery.fancybox.pack.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>