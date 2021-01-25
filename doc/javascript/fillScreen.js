<!--

function fillScreen(){

	window.moveTo(0,0);
	var APP = navigator.appName;
	var PFM = navigator.platform;
	var NVR = navigator.appVersion;

	var OS = (PFM.indexOf("Mac")>-1 ? "MAC" : (PFM.indexOf("Win")>-1 ? "WIN" : "LIN"));
	var NAV = (APP.indexOf("Explorer")>-1 ? "MSE" : (APP.indexOf("Netscape")>-1 ? "NSC" : "XXX"));
	var VER;
	var index;
	//alert("Plattform = "+PFM+"\nJSPlattform = "+OS+"\nApplication = "+APP+"\nJSApplication = "+NAV);

	var subtractWidth = 0;
	var subtractHeight = 0;
	switch (NAV){
		case "MSE":
			index = NVR.indexOf("MSIE");
			VER = NVR.substring(index+5, index+6);
			switch (OS){
				case "MAC":
					switch (VER){
						case "4": subtractWidth = 5;
							subtractHeight = 25;
							break;
						case "5": subtractWidth = 0;
							subtractHeight = 20;
							break;
					}
					break;
				case "WIN":
					switch (VER){
						case "4": subtractWidth = 4;
							subtractHeight = 20;
							break;
						case "5": subtractWidth = 0;
							subtractHeight = 0;
							break;
					}
					break;
				default:
					subtractWidth = 0;
					subtractHeight = 0;
			}
			break;
		case "NSC":
			VER = NVR.substring(0, 1);
			switch (OS){
				case "MAC":
					switch (VER){
						case "4": subtractWidth = 28;
							subtractHeight = 155;
							break;
						case "5": subtractWidth = 10;
							subtractHeight = 25;
							break;
					}
					break;
				case "WIN":
					switch (VER){
						case "4": subtractWidth = 12;
							subtractHeight = 158;
							break;
						case "5": subtractWidth = 0;
							subtractHeight = 0;
							break;
					}
					break;
				default:
					subtractWidth = 20;
					subtractHeight = 20;
			}
		break;
		default:
			subtractWidth = 0;
			subtractHeight = 0;
	}



	window.resizeTo((screen.availWidth-subtractWidth), (screen.availHeight-subtractHeight));
	
}
fillScreen();

// -->
