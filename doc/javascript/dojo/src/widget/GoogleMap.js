dojo.provide("dojo.widget.GoogleMap");
dojo.provide("dojo.widget.GoogleMap.Controls");
dojo.require("dojo.widget.*");
dojo.widget.tags.addParseTreeHandler("dojo:googlemap");

dojo.widget.GoogleMap=function(){
	//	summary
	//	base class for the Google Map widget
	dojo.widget.Widget.call(this);
	this.widgetType="GoogleMap";
	this.isContainer=false;
}
dojo.inherits(dojo.widget.GoogleMap, dojo.widget.Widget);

dojo.widget.GoogleMap.Controls={
	LargeMap:"largemap",
	SmallMap:"smallmap",
	SmallZoom:"smallzoom",
	Scale:"scale",
	MapType:"maptype",
	Overview:"overview",
	get:function(s){
		for(var p in this){
			if(typeof(this[p])=="string"
				&& this[p]==s
			){
				return p;
			}
		}
		return null;
	}
};

dojo.requireAfterIf("html", "dojo.widget.html.GoogleMap");
