<?php
include('header_inc/connect/connect.php');
 
 $post_id = @$_GET['post_id'];
 $username = @$_GET['un'];
 $user = @$_GET['u'];
 $getposts1 = mysql_query("SELECT * FROM posts WHERE  id ='$post_id'") or die(mysql_error());
 
    $rows1 = mysql_fetch_assoc($getposts1);
    $date_added = $rows1['posted_on'];
    $added_by = $rows1['posted_by'];
	$user_posted_to = $rows1['user_posted_to'];
	$uploadImage = $rows1['posted_picture'];
	$body = $rows1['post_body'];
	$get_user_info = mysql_query("SELECT * FROM users WHERE username ='$added_by' ");
	$get_info = mysql_fetch_assoc($get_user_info);
    $username = $get_info['username'];
    $profilepic_info= $get_info['profile_pic'];
				/*Get the picture from its folder*/
	$posted_image =  "userpictures/picture_post/".$uploadImage;
				
      if($profilepic_info==""){
		  $profilepic_info = "./img/default_pic.png";
			 }
	 else{
		  $profilepic_info = "./userpictures/profile_pic/".$profilepic_info;
		}
 
 
 
 
 				echo"
				<p />
				<div class= 'newsFeedPostOnProfile'>
				
					<div style='float: left; padding-left: 4px; padding-top: 4px; padding-right: 7px;'><a href='http://localhost/UConnect/$username'><img src ='$profilepic_info' height='50' width ='40' /></a> </div>"; 
					echo '<span  class = "menu" style="float:right;">
						  <ul><li><img src="img/downBar.png" width="20" height="20" alt="down" />
								<ul class="dropMainDelete">
									<li>Hide</li>';
								if($user==$username || $user ==$added_by){
									
									echo   '<li>Edit</li>
											<li id="delPost">Delete</li>';
								}
								echo '
									<li>Share</li>
								</ul>
							</li>
						</ul>
					</span>';
			
				echo ($user==$added_by)?"<div class= 'posted_by' ><a href='$user'>$firstname $lastname </a></div> <br />" :
				"<div class= 'posted_by' ><a href='$added_by'>$added_by</a> posted on your profile  </div> <br />";
	 
				
				echo ($uploadImage == "")?"<div style= 'word-wrap: break-word;overflow: hidden; line-height:1.8em;
					 font-size:15px; margin-left: 1%;'>$body <br /><p /><br /><br /></div>":
				"<div style= 'word-wrap: break-word;overflow: hidden; line-height:1.8em;
					 font-size:15px; margin-left: 6%;'>$body <br /><br />
				 <a class='fancybox' rel='group' href='$posted_image' title=''><img src='$posted_image' width='400' height='500' alt=''></a>
					 <br /><p /><br /><br /></div>";
                     
               echo '</div>';
				
 
 
?>


<style>
 .menu:hover{
	 cursor:pointer;
	 }
  .dropMainDelete{
	  display:none;
	  position: absolute;
	  color:#2A1FFF;
	  }
.dropMainDelete li{
	  float:none;
	  margin-right: 5px;
	  }
.dropMainDelete li:hover{
		color:#FFFFFF;
		display:list-item;
		text-decoration:underline;
		}
</style>
             
 <script type="text/javascript">
	$(document).ready(function(){
		$(".menu  li").hover(function(){
			$(this).children(":hidden").slideDown();
		},function(){
			$(this).parent().find("ul").slideUp();
		
		});
			
	});
</script> 