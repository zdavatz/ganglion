<!--


/*
Debugging:
	$IE4 = 1	$IE3 =  	$NS4 =  	$NS3 =  	$X11 =  	$HAVE_STYLE = 1*/

var loaded = 0;
var gotlayers = 0;
var lastbutton='top';


NS4 = (document.layers) ? 1 : 0;
IE4 = (document.all) ? 1 : 0;
ver4 = (NS4 || IE4) ? 1 : 0;

function moveLayers() {
	if (gotlayers) {
		if (NS4) {
			screenWidth = window.innerWidth;
			document.layers['newthema'].left = 205;
			document.layers['newthema'].top = 20;
			document.layers['qrefKick'].left = 205;
			document.layers['qrefKick'].top = 20;
			document.layers['searchKick'].left = 205;
			document.layers['searchKick'].top = 20;
		} else {
			screenWidth = document.body.clientWidth + 18;
			document.all['newthema'].style.pixelLeft = 205;
			document.all['newthema'].style.pixelTop = 20;
			document.all['qrefKick'].style.pixelLeft = 205;
			document.all['qrefKick'].style.pixelTop = 20;
			document.all['searchKick'].style.pixelLeft = screenWidth-350;
			document.all['searchKick'].style.pixelTop = 36;
		}
	}
}

function popUp(menuName,on) {
	if (gotlayers) {
		if (on) {
			moveLayers();
			if (NS4) {
				document.layers[menuName].visibility = "show";
			} else {
				document.all[menuName].style.visibility = "visible";
			}
		} else {
			if (NS4) {
				document.layers[menuName].visibility = "hide";
			} else {
				document.all[menuName].style.visibility = "hidden";
			}
		}
	}
}



function change(Name,No) {
	if (document.images && (loaded == 1) && (document[Name])) {
		document[Name].src = eval("b_" + Name + No + ".src");
	}
	if (No == 1) {
		if (gotlayers) {
			popUp('newthema',false);
			popUp('qrefKick',false);
			popUp('searchKick',false);
		}
		if (Name != 'mirr') {
			change('mirr',0);
		}
		if (Name != 'qref') {
			change('qref',0);
		}
		if (Name != 'sear') {
			change('sear',0);
		}
		lastbutton = Name;
	}
}

function changebullet(Name,No) {
	if (document.images && (loaded == 1)) {
		document[Name].src = eval("b_bullet" + No + ".src");
	}
}

function hide() {
	if (document.images && (loaded == 1)) {
		change(lastbutton,0);
	}
}
// -->