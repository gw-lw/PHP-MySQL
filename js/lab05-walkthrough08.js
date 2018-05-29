window.onload = function(){
	var divToGet = document.getElementById("div1");
	alert(divToGet.innerHTML);
	divToGet.innerHTML = "Hello";
	divToGet.style.backgroundColor = "#AA0000";
}