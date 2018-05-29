window.onload = function(){
	var divList = document.querySelectorAll(".movingDiv");
	for (var i=0;i<divList.length;i++){ divList[i].style.backgroundColor="#AA0000"; divList[i].style.color="#FFFFFF";
	divList[i].onclick = function(){
		this.style.backgroundColor="#00AA00";
		}
	divList[i].onclick = function(){
		if (this.style.backgroundColor=="rgb(170, 0, 0)"){
		this.style.backgroundColor="rgb(0, 170, 0)";
		}
		else{
		this.style.backgroundColor="rgb(170, 0, 0)";
		}
		}
	divList[i].onmouseover = function(){
		this.style.color = "#555555";
		}
	divList[i].onmouseout = function(){
		this.style.color = "#FFFFFF";
		}
	}
}