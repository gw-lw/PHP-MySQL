window.onload = function(){
	var mainForm = document.getElementById("mainForm");
	mainForm.onsubmit = function(e){
		var requiredInputs = document.querySelectorAll(".required");
		for (var i=0; i < requiredInputs.length; i++){
		requiredInputs[i].onfocus = function(){
		this.style.backgroundColor = "#EEEE00";
		}
		}
		var requiredInputs = document.querySelectorAll(".required");
		for (var i=0; i < requiredInputs.length; i++){
			if(isBlank(requiredInputs[i]) ){ 
				e.preventDefault(); 
				makeRed(requiredInputs[i]);
			}
		}
		var email = document.getElementById("email");
			if(! isValidEmail(email.value)){ 
				e.preventDefault(); 
				makeRed(email);
			}
			
	}
}
function isBlank(inputField){ if (inputField.value==""){ return true;
}
return false;
}
function isValidEmail(email){
	var dotPos = email.lastIndexOf(".");//get the position of the last dot.
	var atPos = email.lastIndexOf("@");//get the position of the @
	if ( dotPos + 2 >= email.length ){	//error, the TLD is less than 2	characters.
	return false;
	}
	if ( atPos + 2 > dotPos ){	//error, the 2nd level domain is less than 2 characters.
	return false;
	}
	if( atPos < 1){	//error, the username is less than 1 character. (or no	@)
	return false;
	}
	return true;
}
function makeRed(inputDiv){ 
	inputDiv.style.backgroundColor="#AA0000"; 
	inputDiv.parentNode.style.backgroundColor="#AA0000"; 
	inputDiv.parentNode.style.color="#FFFFFF";
}
function makeClean(inputDiv){ 
	inputDiv.style.backgroundColor="#FFFFFF"; 
	inputDiv.parentNode.style.backgroundColor="#FFFFFF"; 
	inputDiv.parentNode.style.color="#000000";
}
