dojo.provide("dojo.widget.html.GoogleMap");
dojo.require("dojo.event.*");
dojo.require("dojo.html");
dojo.require("dojo.math");
dojo.require("dojo.widget.HtmlWidget");
dojo.require("dojo.widget.GoogleMap");

dojo.widget.html.GoogleMap=function(){
	dojo.widget.HtmlWidget.call(this);
	dojo.widget.GoogleMap.call(this);

	var gm=dojo.widget.GoogleMap;

	this.map=null;
	this.data=[];
	this.datasrc="";
	this.controls=[gm.Controls.LargeMap,gm.Controls.Scale,gm.Controls.MapType];
};
dojo.inherits(dojo.widget.html.GoogleMap, dojo.widget.HtmlWidget);

dojo.lang.extend(dojo.widget.html.GoogleMap, {
	templatePath:null,
	templateCssPath:null,

	setControls:function(){
		var c=dojo.widget.GoogleMap.Controls;
		for(var i=0; i<this.controls.length; i++){
			var type=this.controls[i];
			switch(type){
				case c.LargeMap:{
					this.map.addControl(new GLargeMapControl());
					break;
				}
				case c.SmallMap:{
					this.map.addControl(new GSmallMapControl());
					break;
				}
				case c.SmallZoom:{
					this.map.addControl(new GSmallZoomControl());
					break;
				}
				case c.Scale:{
					this.map.addControl(new GScaleControl());
					break;
				}
				case c.MapType:{
					this.map.addControl(new GMapTypeControl());
					break;
				}
				case c.Overview:{
					this.map.addControl(new GOverviewMapControl());
					break;
				}
				default:{
					break;
				}
			}
		}
	},
	
	findCenter:function(bounds){
		var clat=(bounds.getNorthEast().lat()+bounds.getSouthWest().lat())/2;
		var clng=(bounds.getNorthEast().lng()+bounds.getSouthWest().lng())/2;
		return (new GLatLng(clat,clng));
	},

	createPinpoint:function(pt,overlay){
		var m=new GMarker(pt);
		if(overlay){
			GEvent.addListener(m,"click",function(){
				m.openInfoWindowHtml("<div>"+overlay+"</div>");
			});
		}
		return m;
	},

	parse:function(table){
		this.data=[];

		//	get the column indices
		var h=table.getElementsByTagName("thead")[0];
		if(!h){
			return;
		}

		var a=[];
		var cols=h.getElementsByTagName("td");
		if(cols.length==0){
			cols=h.getElementsByTagName("th");
		}
		for(var i=0; i<cols.length; i++){
			a.push(cols[i].innerHTML.toLowerCase());
		}
		
		//	parse the data
		var b=table.getElementsByTagName("tbody")[0];
		if(!b){
			return;
		}
		for(var i=0; i<b.childNodes.length; i++){
			if(!(b.childNodes[i].nodeName&&b.childNodes[i].nodeName.toLowerCase()=="tr")){
				continue;
			}
			var cells=b.childNodes[i].getElementsByTagName("td");
			var o={};
			for(var j=0; j<a.length; j++){
				var col=a[j];
				if(col=="lat"||col=="long"){
					o[col]=parseFloat(cells[j].innerHTML);					
				}else{
					o[col]=cells[j].innerHTML;
				}
			}
			this.data.push(o);
		}
	},
	render:function(){
		var bounds=new GLatLngBounds();
		var d=this.data;
		var pts=[];
		for(var i=0; i<d.length; i++){
			bounds.extend(new GLatLng(d[i].lat,d[i].long));
		}

		this.map.setCenter(this.findCenter(bounds), this.map.getBoundsZoomLevel(bounds));

		for(var i=0; i<this.data.length; i++){
			var p=new GLatLng(this.data[i].lat,this.data[i].long);
			var d=this.data[i].description||null;
			var m=this.createPinpoint(p,d);
			this.map.addOverlay(m);
		}
	},
	

	initialize:function(args, frag){
		if(!GMap2){
			dojo.raise("dojo.widget.GoogleMap: The Google Map script must be included (with a proper API key) in order to use this widget.");
		}
		if(this.datasrc){
			this.parse(dojo.byId(this.datasrc));
		}
		else if(this.domNode.getElementsByTagName("table")[0]){
			this.parse(this.domNode.getElementsByTagName("table")[0]);
		}
	},
	postCreate:function(){
		//	clean the domNode before creating the map.
		while(this.domNode.childNodes.length>0){
			this.domNode.removeChild(this.domNode.childNodes[0]);
		}
		this.map=new GMap2(this.domNode);
		this.render();
		this.setControls();
	}
});
