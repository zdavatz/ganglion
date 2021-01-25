dojo.provide("dojo.collections.List");
dojo.require("dojo.collections.Collections");

dojo.collections.List = function(dictionary){
	dojo.deprecated("dojo.collections.List", "Use dojo.collections.Dictionary instead.", "0.3");
	return new dojo.collections.Dictionary(dictionary);
}
