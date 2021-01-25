dojo.provide("dojo.Firebug");

dojo.firebug = function(){}
dojo.firebug.printfire = function () {
	printfire=function(){}
	printfire.args = arguments;
	var ev = document.createEvent("Events");
	ev.initEvent("printfire", false, true);
	dispatchEvent(ev);
}

if (document.createEvent) {
	dojo.hostenv.println=dojo.firebug.printfire;
}
