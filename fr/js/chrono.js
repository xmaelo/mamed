
var startTime = 0
var start = 0
var end = 0
var diff = 0


function chrono(){
	//alert(s_heure)
	end = new Date()
	diff = end - start
	diff = new Date(diff)
	var msec = diff.getMilliseconds()
	var sec = diff.getSeconds()
	var min = diff.getMinutes()
	var hr = diff.getHours()-1
	var seconde_patient = 59
	var minute_patient = $("#minute_patient").val()
	//alert(minute_patient)
	var heure_patient = $("#heure_patient").val()
	heure_patient -= hr
	minute_patient -= min
	seconde_patient -= sec 
	//alert(sec)
	if(heure_patient == 0 && minute_patient == 0 && seconde_patient == -1){
		alert('temps epuisé')
		document.getElementById("chronotime").innerHTML = "0:00:00"
		start = new Date()
		chronoStop();
	}
	if (minute_patient < 10){
		minute_patient = "0" + minute_patient
	}
	if (seconde_patient < 10){
		seconde_patient = "0" + seconde_patient
	}
	if(msec < 10){
		msec = "00" +msec
	}
	else if(msec < 100){
		msec = "0" +msec
	}


	document.getElementById("chronotime").innerHTML = heure_patient + ":" + minute_patient + ":" + seconde_patient
	timerID = setTimeout("chrono()", 10)
}

function chronoStart(){
	document.chronoForm.startstop.value = "stop!"
	document.chronoForm.startstop.onclick = chronoStop
	document.chronoForm.reset.onclick = chronoReset
	clearTimeout(timerID)
	start = new Date()
	chrono()
	

}
function chronoContinue(){
	document.chronoForm.startstop.value = "stop!"
	document.chronoForm.startstop.onclick = chronoStop
	document.chronoForm.reset.onclick = chronoReset
	start = new Date()-diff
	start = new Date(start)
	chrono()
}

function chronoReset(){
	document.getElementById("chronotime").innerHTML = "0:00:00:000"
	start = new Date()
}

function chronoStopReset(){
	document.getElementById("chronotime").innerHTML = "0:00:00:000"
	document.chronoForm.startstop.onclick = chronoStart
}
function chronoStop(){
	document.chronoForm.startstop.value = "start!"
	document.chronoForm.startstop.onclick = chronoContinue
	document.chronoForm.reset.onclick = chronoStopReset
	clearTimeout(timerID)
}

function chrono_old(){
	end = new Date()
	diff = end - start
	diff = new Date(diff)
	var msec = diff.getMilliseconds()
	var sec = diff.getSeconds()
	var min = diff.getMinutes()
	var hr = diff.getHours()-1
	if (s_min < 10){
		s_min = "0" + min
	}
	if (s_sec < 10){
		s_sec = "0" + sec
	}
	if(msec < 10){
		msec = "00" +msec
	}
	else if(msec < 100){
		msec = "0" +msec
	}
	document.getElementById("chronotime").innerHTML = hr + ":" + min + ":" + sec + ":" + msec
	timerID = setTimeout("chrono()", 10)
}