<?php include("header_inc/header.php");?>
<?php
//User login code

  
  $userlogin = mysql_escape_string(@$_GET['userlogin']);
  $passwordlogin = mysql_escape_string(@$_GET['passwordlogin']);
if(isset($_POST["userlogin"]) && isset($_POST["passwordlogin"])){
	$userlogin = preg_replace('#[^A-Za-z0-9]#i', '' ,$_POST['userlogin']);
	$passwordlogin = preg_replace('#[^A-Za-z0-9]#i', '' ,$_POST['passwordlogin']);
	
    
    //encript the password
	$password_login_md5 = md5($passwordlogin);
	
    	//query database to check for their existence
	$sqlLogin = mysql_query("SELECT * FROM users WHERE username ='$userlogin' AND password = '$password_login_md5' AND closed ='no'");
	
	$countUser = mysql_num_rows($sqlLogin); //count the number of rows returned
	if($countUser == 1){
		while($rows = mysql_fetch_array($sqlLogin)){
			 $userId = $rows["id"];
             $db_name = $rows['username'];
             $db_password = $rows['password'];
			}
        if($userlogin == $db_name){
            if($password_login_md5 == $db_password){
                
			$_SESSION["userlogin"] = $userlogin;
			header("location: myfeed.php");
			exit();
                }
            else{
                echo 'Your password is incorrect';
            }
        }
        else{
            
            echo 'Your username is NOT correct';
        }
		}
	else{
		echo 'The Information is incorrect, enter a valid username and password';
		exit();
		}
	}


?>
  
   <div class="headerBodyWrapper" style="width:100%; height: 100%;">
     
    	
    <!-- jQuery handles to place the header background images -->
	<div id="headerimgs">
		<div id="headerimg1" class="headerimg"></div>
		<div id="headerimg2" class="headerimg"></div>
	</div>
     <div style="width:80%; height: 600px; margin: 0px auto;">
	<table>
    	<tr>
            <td width="20%" valign="top">
            	<div id="nav-outer-signIn" style="background: #FFFAFA; border-radius: 5px;">
            	<h2 style = "font-family:pristina; font-size: 25px;">Already a member, Log In!</h2>
                <form method="POST" id="loginForm">
                	  <input id="userlogin" name="userlogin" type="text" size="25" placeholder="Username"/><br /> 
					  <input id="passwordlogin" name="passwordlogin" type="password" size="25" placeholder="Password"/> <br />        
                      <input id="signIn"  type="submit" value="Login" name="signIn"  /> 	
                
                </form>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                
                <?php
                       $countNumberofUsers = mysql_query("SELECT sex FROM users ");
                       $countgroupBySex = mysql_num_rows($countNumberofUsers);
                       echo "<div style='background: #FFFAFA; font-style: italic; font-size: 15px;'>We`re currently <span id='countMembers'><font size ='15px' color ='#FF69B4'><strong><b>" .$countgroupBySex."</b></strong></font></span> members in UConnect</div>";

                ?>
             <script type="text/javascript">
            
                    $.ajaxSetup({
                    	cache: false
                    	});
                    $(setInterval(function(){
                    		$('#countMembers').load('countMF/countMembers.php');
                    		},1000));
            </script>                
                </div>
                

            </td>
                              <!-- jQuery handles for the text displayed on top of the images -->
            <td width="40%" valign="center">
                            <div id="headertxt">
                                <p class="caption">
                                    <span id="firstline"></span>
                                    <a href="#" id="secondline"></a>
                                </p>
                        
                            </div>
    	    </td>
                
                
            <td width="40%" valign="top">
            <div id="nav-outer-Registration" style="background: #FFFAFA; border-radius: 5px; width: 65%;">
            <h2 style = "font-family:pristina; font-size: 25px;">Register Below</h2>
	<div id="container" >
                    <form id="customRegistrationForm">
                        <div>   
                        		<legend><span id="fnameInfo">Enter First Name</span></legend>                         
                                <input id="fname" name="fname" type="text" size="25" placeholder="First Name"/>
                                
                        </div>
                        <div>   
                        		<legend><span id="lnameInfo">Enter Last Name</span></legend>                       
                                <input id="lname" name="lname" type="text" size="25" placeholder="Last Name"/>
                                
                               
                        </div>
                        <div>    
                        		<legend><span id="usernameInfo">(should not start with number or symbol)</span> </legend>                       
                                <input id="Uname" name="Uname" type="text" size="25"placeholder="Enter your username" />
                                
                        </div>
                        <div> 
                        		<legend><span id="emailInfo">Valid E-mail please, needed to verify account!</span></legend>                          
                                <input id="email" name="email" type="text" size="25" placeholder="Email"/>
                                
                        </div>
                        <div>
                        		<legend><span id="pass1Info">At least 5 characters: letters, numbers and '_'</span></legend>
                                <input id="pass1" name="pass1" type="password" size="25" placeholder="Password"/>
                                
                        </div>
                        <div>
                        		<legend><span id="pass2Info">Confirm password</span></legend>
                                <input id="pass2" name="pass2" type="password" size="25" placeholder="Confirm Password"/>
                                
                        </div>
                        <div>
                                <label for="DOB">Date of Birth</label>   
                                Day<select id="days" name="day"><option></option></select>
                                Month <select id="months" name="month" ><option></option></select>
                                Year<select id="years" name="year"><option></option></select>
                               <span id="DOB"></span>
                        </div>
                        <div style ="font-size: 15px;">
                        		<label>Sex <span id="sexInfo">Choose your gender</span></label>
                                <select id="sex" name="sex" >
                                    <option>Female</option>
                                    <option>Male</option>
                                </select>
                                
                        </div>                  
                        <div>
                            <input id="sendDatatoRegisterUser" name="register" type="button" value="Register to UConnect" />
                             
                        </div>

                    </form>
                </div>
               </div>
            </td>
        </tr>
    </table>
    
    	</div>
                        
        </div>
  <br clear="both" />
<?php
 include("header_inc/footer.php");

?>