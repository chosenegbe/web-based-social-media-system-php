$(document).ready(function(){
		
	var form = $("#customRegistrationForm");
	var fname =$("#fname");
	var fnameInfo =$("#fnameInfo");	
	var lname =$("#lname");
	var lnameInfo =$("#lnameInfo");	
	var username =$("#Uname");
	var usernameInfo =$("#usernameInfo");	
	var email =$("#email");
	var emailInfo =$("#emailInfo");
	var pass1 =$("#pass1");
	var pass1Info =$("#pass1Info");
	var pass2 =$("#pass2");
	var pass2Info =$("#pass2Info");
	var country =$("#country");

	
	//variable to hold states - take true or false
	var state =false;


 //CALL THE VARIOUS FUNCTION WHEN THE KEY IS RELEASED
   fname.keyup(validateFirstName);
   lname.keyup(validateLastName);
   username.keyup(validateUsername);
   email.keyup(validateEmail);
   pass1.keyup(validatePass1);
   pass2.keyup(validatePass2);

//VALIDATE FIRST NAME
  function validateFirstName(){
	if(fname.val().length < 2){
						fname.removeClass("valid");
						fnameInfo.removeClass("valid");
						fname.addClass("error");
						fnameInfo.addClass("error");
						fnameInfo.text("First name must be at least 2 characters");
						state = false;
		}
		else{
						fname.removeClass("error");
						fnameInfo.removeClass("error");
						fname.addClass("valid");
						fnameInfo.addClass("valid");
						fnameInfo.text("OK!");
						state = true;		
		}
		return state;
	  
	  }

//VALIDATE LAST NAME	
	function validateLastName(){
	if(lname.val().length < 2){
						lname.removeClass("valid");
						lnameInfo.removeClass("valid");
						lname.addClass("error");
						lnameInfo.addClass("error");
						lnameInfo.text("Last name must be at least 2 characters");
						state = false;
		}
		else{
						lname.removeClass("error");
						lnameInfo.removeClass("error");
						lname.addClass("valid");
						lnameInfo.addClass("valid");
						lnameInfo.text("OK!");
						state = true;		
		}
		return state;
	  
	  }


//VALIDATE USERNAME (THIS MUST ALSO CHECK IF USER ALREADY EXIST AND THE USERNAME MUST BE 5 CHARACTERS AT LEAST AND SHOULDN'T START WITH A NUMBER)
	function validateUsername(){
		if(username.val().length <5 ){
			username.removeClass("valid");
			usernameInfo.removeClass("valid");
			username.addClass("error");
			usernameInfo.addClass("error");
			usernameInfo.text("Username must be at least 5 characters long");
			state = false;
		}
		else if(username.val().length >15 ){
			username.removeClass("valid");
			usernameInfo.removeClass("valid");
			username.addClass("error");
			usernameInfo.addClass("error");
			usernameInfo.text("Username must be lesser than 15 characters");
			state = false;			
			}
		else{
			if(username.val().length >= 5){
				var unames = username.val();
				$.post("ValidateRegistration/validationPhpScript/validateRegistration.php",{usernames:unames},function(data){
					if(data==1){
						username.removeClass("valid");
						usernameInfo.removeClass("valid");
						username.addClass("error");
						usernameInfo.addClass("error");
						usernameInfo.text("Username already taken");
						state = false;
					}
				else{
						username.removeClass("error");
						usernameInfo.removeClass("error");
						username.addClass("valid");
						usernameInfo.addClass("valid");
						usernameInfo.text("Username OK!");
						state = true;
					}
				});
			}
			
		}
		return state;
	}
	
//CHECK IF EMAIL IS OKAY
	function validateEmail(){
		var a = email.val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		
		if(filter.test(a)){
			$.post("ValidateRegistration/validationPhpScript/validateRegistration.php",{emails:a},function(data){
				if(data == 1){
						email.removeClass("valid");
						emailInfo.removeClass("valid");
						email.addClass("error");
						emailInfo.addClass("error");
						emailInfo.text("This email already exist");
						state = false;
				}else{
						email.removeClass("error");
						emailInfo.removeClass("error");
						email.addClass("valid");
						emailInfo.addClass("valid");
						emailInfo.text("Email validated");
						//validateEmail2();
						state = true;
				}
			});
		}
		else{
						email.removeClass("valid");
						emailInfo.removeClass("valid");
						email.addClass("error");
						emailInfo.addClass("error");
						emailInfo.text("Please type a valid email");
						state = false;
		}
	
		return state;
	}
// CHECK IF PASSWPRD 1 IS OKAY
	function validatePass1(){
		if(pass1.val().length < 5){
						pass1.removeClass("valid");
						pass1Info.removeClass("valid");
						pass1.addClass("error");
						pass1Info.addClass("error");
						pass1Info.text("Password must have at least 5 characters");
						state = false;
		}
		else{
						pass1.removeClass("error");
						pass1Info.removeClass("error");
						pass1.addClass("valid");
						pass1Info.addClass("valid");
						pass1Info.text("OK!");
						validatePass2();
						state = true;		
		}
		return state;
	}
//CHECK IF PASSWORD2 IS OKAY AND MATCHES PASSWORD2
	function validatePass2(){
		if(pass1.val()!= pass2.val()){
						pass2.removeClass("valid");
						pass2Info.removeClass("valid");
						pass2.addClass("error");
						pass2Info.addClass("error");
						pass2Info.text("Password don`t match");
						state = false;		
		}
		else{
						pass2.removeClass("error");
						pass2Info.removeClass("error");
						pass2.addClass("valid");
						pass2Info.addClass("valid");
						pass2Info.text("OK!");
						state = true;		
		
		}
		return state;
	}
			
$("#sendDatatoRegisterUser").click(function(){
			var all = $("#customRegistrationForm").serialize();
			
			if(((validateFirstName() && validateLastName() && validateUsername() && validateEmail() && validatePass1() && validatePass2()) == true) ){

                $.ajax({
					type: "POST",
					url: "ValidateRegistration/insertDataIntoDb/insertUserIntoDb.php",
					data: all,
					success: function(data){
						if(data==1){
								alert("Success! You have registered");
								fname.val("");
								lname.val("");
								username.val("");
								email.val("");
								pass1.val("");
								pass2.val("");
								
                                
								fname.removeClass('valid');
								lname.removeClass('valid');
								username.removeClass('valid');
								email.removeClass('valid');
								pass1.removeClass('valid');
								pass2.removeClass('valid');
                                
								
								
								fnameInfo.text("");
								lnameInfo.text("");
								usernameInfo.text("");								
								emailInfo.text("");
								pass1Info.text("");								
								pass2Info.text("");
                                sexInfo.text("");
								
								//window.location.href='ActivateAccount.php';
						}
						
						else{
								alert("You have errors");
						}
					
	
				
				});
				
			}else{
				alert("Please fill all the form data");
			
			}
			}
			return false;
	});


	
});