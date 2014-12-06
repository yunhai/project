//baseUrl
//imgurl

function tip(obj,code){
		window.open(baseUrl+"helpers/viewhelp/"+code+"&iframe=1&ajax=1", "VSHelper", "width=550,height=400,toolbar=no,location=no,directories=no,status=no,menubar=no, scrollbars=yes,resizable=yes,copyhistory=no");
}
$(document).keydown(function(event){
	if(event.ctrlKey&&event.keyCode==32){
		var open_link = window.open('','_blank');
		open_link.location=baseUrl+"langs";
		//window.open(baseUrl+"languages", "VSLanguage", "target=_blank");
	}
});