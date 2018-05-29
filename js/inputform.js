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
			else{}
		}

			
	}
}
function isBlank(inputField){ if (inputField.value==""){ return true;
}
return false;
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
