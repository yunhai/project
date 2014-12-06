/*

CUSTOM FORM ELEMENTS

Created by Ryan Fait
www.ryanfait.com

The only things you may need to change in this file are the following
variables: checkboxHeight, radioHeight and selectWidth (lines 24, 25, 26)

The numbers you set for checkboxHeight and radioHeight should be one quarter
of the total height of the image want to use for checkboxes and radio
buttons. Both images should contain the four stages of both inputs stacked
on top of each other in this order: unchecked, unchecked-clicked, checked,
checked-clicked.

You may need to adjust your images a bit if there is a slight vertical
movement during the different stages of the button activation.

The value of selectWidth should be the width of your select list image.

Visit http://ryanfait.com/ for more information.

*/

var checkboxHeight = "25";
var radioHeight = "25";
var selectWidth = "190";


/* No need to change anything after this */


//document.write('<style type="text/css">input[type=radio],input[type=checkbox] { display: none; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');
document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');
var Custom = {
	init: function() {
		var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
		$("input").each(function(){
			if((this.type == "checkbox" || this.type == "radio" && !$(this).hasClass("mudimCS") ) && !$(this).hasClass("loaded")) {
				span = document.createElement("span");
				div = document.createElement("span");
				span.className = this.type;
				$(span).attr('acaica',this.className);
				this.className += " loaded";
				if(this.checked == true) {
					if(this.type == "checkbox") {
						position = "0 -" + (checkboxHeight*2) + "px";
						span.style.backgroundPosition = position;
						span.onclick=this.onclick	;
					} else {
						position = "0 -" + (radioHeight*2) + "px";
						span.style.backgroundPosition = position;
					}
				}
				$(this).css('visibility','hidden');
				$(span).css('padding','3px 10px');
				var curent=$(this).clone();
				$(div).css('clear','both');
				$(div).css('cursor','pointer');
////				$(span).html('check');
				$(div).html(curent);
				$(span).html("&nbsp;");
				$(span).insertBefore(curent);
				$(this).replaceWith($(div));
				$(span).click(this.onclick)
				$(this).onchange = Custom.clear;
				if(!this.getAttribute("disabled")) {
					span.onmousedown = Custom.spanpushed;
					span.onmouseup = Custom.spancheck;
					this.onmousedown = Custom.inputpushed;
					this.onmouseup = Custom.inputcheck;
				} else {
					span.className = span.className += " disabled";
				}
			}
		});
		document.onmouseup = Custom.clear;
	},
	inputpushed: function() {
		element = this.previousSibling;
		if(this.checked == true && this.type == "checkbox") {
			element.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(this.checked == true && this.type == "radio") {
			element.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(this.checked != true && this.type == "checkbox") {
			element.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			element.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	inputcheck: function() {
		element = this.previousSibling;
		if(this.checked == true && this.type == "checkbox") {
			element.style.backgroundPosition = "0 0";
		} else {
			element.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
		}
	},
	spanpushed: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(element.checked == true && element.type == "radio") {
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(element.checked != true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	spancheck: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 0";
			element.checked = false;
		} else {
			if(element.type == "checkbox") {
				this.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else {
				this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
				group = this.nextSibling.name;
				inputs = document.getElementsByTagName("input");
				for(a = 0; a < inputs.length; a++) {
					if(inputs[a].name == group && inputs[a] != this.nextSibling) {
						inputs[a].previousSibling.style.backgroundPosition = "0 0";
					}
				}
			}
			element.checked = true;
		}
	},
	clear: function() {
		inputs = document.getElementsByTagName("input");
		for(var b = 0; b < inputs.length; b++) {
			if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else if(inputs[b].type == "checkbox" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			} else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
			} else if(inputs[b].type == "radio" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			}
		}
	},
	choose: function() {
		option = this.getElementsByTagName("option");
		for(d = 0; d < option.length; d++) {
			if(option[d].selected == true) {
				document.getElementById("select" + this.name).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
			}
		}
	}
}
$(document).ready(function(){
	Custom.init();
});
