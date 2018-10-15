$(document).ready(function(){
		
	var form = $("#customRegistrationForm");
	var fname =$(".firstname");
	var fnameInfo =$("#fnameInfo");	
	var lname =$(".lastname");
	var lnameInfo =$("#lnameInfo");	
	var country =$(".country");
	var countryInfo =$("#countryInfo");
	var state =$(".state");
	var stateInfo =$("#stateInfo");
 	var phone =$(".phone");
	var phoneInfo =$("#phoneInfo");   
	var bio =$(".bio");
	var bioInfo =$("#bioInfo");       
    	
	//variable to hold states - take true or false
	var state =false;


 //CALL THE VARIOUS FUNCTION WHEN THE KEY IS RELEASED
   fname.keyup(validateFirstName);
   lname.keyup(validateLastName);
   $phone.keyup(validatePhoneNumber);

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

//CHECK IF EMAIL IS OKAY
	function validatePhoneNumber(){
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
			
$("#sendDatatoRegisterUser").click(function(){
			var all = $("#customRegistrationForm").serialize();
			
			if((validateFirstName() && validateLastName() && validateUsername() && validateEmail() && validatePass1() && validatePass2()) == true){
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
								
								//window.location.href='ActivateAccount.php';
						}
						
						else{
								alert("You have errors");
						}
					}
	
				
				});
				
			}else{
				alert("Please fill all the form data");
			
			
			}
			return false;
	});


	
});