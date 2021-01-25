dojo.provide("dojo.widget.YahooMap");
dojo.provide("dojo.widget.YahooMap.Controls");
dojo.require("dojo.widget.*");
dojo.widget.tags.addParseTreeHandler("dojo:yahoomap");

dojo.widget.YahooMap=function(){
	//	summary
	//	base class for the Yahoo Map widget
	dojo.widget.Widget.call(this);
	this.widgetType="YahooMap";
	this.isContainer=false;
}
dojo.inherits(dojo.widget.YahooMap, dojo.widget.Widget);

dojo.widget.YahooMap.Controls={
	MapType:"maptype",
	Pan:"pan",
	ZoomLong:"zoomlong",
	ZoomShort:"zoomshort"
};
dojo.requireAfterIf("html", "dojo.widget.html.YahooMap");
