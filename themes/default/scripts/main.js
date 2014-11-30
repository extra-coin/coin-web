konami = new Konami();

var top = screen.height;
var left = screen.width;
var topStep = screen.height * 0.01829;
var leftStep = screen.width * 0.01829;
var animStep = 0;
var currentImage = 1;
var dir = 1;
	
konami.code = function() {
	var code = document.getElementById("code");
	code.style.display = "inline-block";
	
	code.style.top = top + "px";
	code.style.left = left + "px";
	

	var audioElement = document.createElement('audio');
	audioElement.setAttribute('src', 'duck.ogg');
	audioElement.play();

	move();
}

function move()
{
	var code = document.getElementById("code");
	top = top - topStep;
	left = left - leftStep;
	code.style.top = Math.round(top) + "px";
	code.style.left = Math.round(left) + "px";
	var tim = setTimeout("move()", 41);
	animStep = animStep + 41;
	if (animStep > 200) {
		animStep = 0;
		currentImage = currentImage + dir;
		if (currentImage == 4) {
			currentImage = 2;
			dir = -1;
		}
		else if (currentImage == 0) {
			currentImage = 2;
			dir = 1;
		}
		code.style.backgroundImage = "url({{ theme_url }}/img/duck" + currentImage + ".png)";
	}
	if (0 > top && 0 > left) {
		clearTimeout(tim);
		code.style.display = "none";
		top = screen.height;
		left = screen.width;
	}
}

konami.load();

// forms
function onTypeAdhesionChange()	{

	var index = document.forms["myPayPal"]["os0"].selectedIndex;
	if (index == 3) { // show pro
		document.getElementById('adminDiv').style.display = "block";
	}
	else { // hide pro
		document.getElementById('adminDiv').style.display = "none";
	}
	if (index == 2) { // bien pro
		document.getElementById('bienDiv').style.display = "block";
	}
	else { // bien pro
		document.getElementById('bienDiv').style.display = "none";
	}
}

function isTheFieldEmpty(fieldName) {
	var x = document.forms["myPayPal"][fieldName].value;
	if (x==null || x=="") { 
		return true;
	}
	return false;
}

function validateForm() {
	var formIsNotValid = false;
	
	if (isTheFieldEmpty("os1") || // nom
		isTheFieldEmpty("os2") || // prénom
		isTheFieldEmpty("os3"))  {// email
		formIsNotValid = true;
	}
		
	var index = document.forms["myPayPal"]["os0"].selectedIndex;
	if (index == 3) {
		if (isTheFieldEmpty("os5") || // raison
			isTheFieldEmpty("address1") || // addr1
			isTheFieldEmpty("address2") || // addr2
			isTheFieldEmpty("zip") || // code postal
			isTheFieldEmpty("city"))  {// ville
			formIsNotValid = true;
		}
	}
	
	if (formIsNotValid) {
		alert("Veuillez indiquer toutes les informations demandées. Merci.");
		return false;
	}
	return true;
}
