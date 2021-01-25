<!--
var normText = "Ganglion WebMaster";

function StatusMsg(msgStr) {
  status=msgStr;
  document.returnValue = true;
}
function FnormText() {
	status=normText;
	document.returnValue = true;
}
function entryDelete(msg){
	if (confirm(msg))
	{
		document.entrydelete.submit();
		return true;
	}
	else
	{
		return false;
	}
}
function pdfDelete(msg){
	if (confirm(msg))
	{
		document.pdfdelete.submit();
		return true;
	}
	else
	{
		return false;
	}
}	
function audiofileDelete(msg){
	if (confirm(msg))
	{
		document.audiofiledelete.submit();
		return true;
	}
	else
	{
		return false;
	}
}	
function popUp(){
	closeAll();
	MM_showHideLayers();
}

function closeAll(){
	MM_showHideLayers('changeThema0','','hide');
	MM_showHideLayers('changeThema1','','hide');
	MM_showHideLayers('changeThema2','','hide');
	MM_showHideLayers('changeThema3','','hide');
	MM_showHideLayers('changeThema4','','hide');
	MM_showHideLayers('changeThema5','','hide');
	MM_showHideLayers('changeThema6','','hide');
	MM_showHideLayers('changeThema7','','hide');
	MM_showHideLayers('changeThema8','','hide');
	MM_showHideLayers('changeThema9','','hide');
	MM_showHideLayers('newthema','','hide');
	Status =  normText;
}
//javascript: s=""; for (i in document) s+=i+":"+document[i]+"\n";alert(s);
//javascript: s=""; for (i in parent.frames.admin.document.forms) s+=i+":"+parent.frames.admin.document.forms[i]+"\n";alert(s);



function MM_findObj(n, d) { //v3.0
var p,i,x;if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document); return x;
}

function MM_showHideLayers() { //v3.0
var i,p,v,obj,args=MM_showHideLayers.arguments;
for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
obj.visibility=v; }
}

defaultStatus =  normText;

function popSendNewsletter(id_news){
	var popupPosX = Math.round(screen.availWidth*0.33);
	var popupPosY = Math.round(screen.availHeight*0.33);
	var popupUrl = "sendNewsletter.php?id_news="+id_news;
	popupProperties = 'height=150,width=300,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,left='+popupPosX+',top='+popupPosY+',screenx='+popupPosX+',screeny='+popupPosY+',titlebar=no';
	apopup = window.open(popupUrl,'newsletter',popupProperties);
	apopup.window.name = "newsletter";
	apopup.focus();
}

function print_lecture(){
	var popupPosX = Math.round(screen.availWidth*0.1);
	var popupPosY = Math.round(screen.availHeight*0.1);
	var popupUrl = "printVortraege.php";
	popupProperties = 'height=600,width=800,toolbar=yes,location=yes,scrollbars=yes,resizable=yes,directories=no,status=no,left='+popupPosX+',top='+popupPosY+',screenx='+popupPosX+',screeny='+popupPosY+',titlebar=no';
	apopup = window.open(popupUrl,'printVortraege',popupProperties);
	apopup.window.name = "printVortraege";
	apopup.focus();	
	
}

//-->
