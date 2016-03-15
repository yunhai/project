function sendMessage(username)
{

if(document.getElementById('status').value==0) {
	document.getElementById('content').innerHTML +="<div class='comments'>Bạn không thể chat được nữa vì người đang chat với bạn đã thoát ra.</div>";
	return;
}

var xmlobj=GetXmlHttpObject();
if (xmlobj==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var word = document.getElementById('word').value;
var id=document.getElementById('ID').value;
var url="ajax.php?act=LiveHelp&CODE=SendMessage&word="+word+"&ID="+id;

xmlobj.onreadystatechange= function () {

	if (xmlobj.readyState==4)
	{
		document.getElementById('content').innerHTML +="<div class='comments'><div class='customertag'>"+username+":</div>&nbsp;"+document.getElementById('word').value+"</div>";
		document.getElementById('word').value = "";
		document.getElementById('content').scrollTop = document.getElementById('content').scrollHeight;
	}
}

xmlobj.open("GET",url,true);
xmlobj.send(null);
}

function getMessage()
{ 
var chatobj=GetXmlHttpObject();

if (chatobj==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }
var ctime=document.getElementById('ctime').value;
var id=document.getElementById('ID').value;
var url="ajax.php?act=LiveHelp&CODE=GetResponse&ctime="+ctime+"&ID="+id;

chatobj.onreadystatechange= function () {
	/*if (xmlobj.readyState==1)
	{
		document.getElementById(id).innerHTML="<img src='style_images/1/loader.gif' width='186' height='42' alt='Đang tải dữ liệu'/>";
	}*/
	if (chatobj.readyState==4)
	{
		data = chatobj.responseXML.documentElement;
		
		if(data.getElementsByTagName('New')[0].firstChild.nodeValue=='1') {
			username = data.getElementsByTagName('Username')[0].firstChild.nodeValue;
			message = data.getElementsByTagName('Message')[0].firstChild.nodeValue;
			document.getElementById('content').innerHTML +="<div class='comments'><div class='admintag'>"+username+":</div> "+message+"</div>";
			document.getElementById('ctime').value=data.getElementsByTagName('MTime')[0].firstChild.nodeValue;
		}
		
		if(data.getElementsByTagName('Online')[0].firstChild.nodeValue=='1') {
			document.getElementById('ustatus').innerHTML ="<img src='style_images/1/chat/online.gif' />";
			if(document.getElementById('status').value=='0') {
				document.getElementById('content').innerHTML +="<div class='comments'><div class='signin'>"+username+" đang trực tuyến.</div></div>";
				document.getElementById('status').value = 1;
			}
		}
		else {
			document.getElementById('ustatus').innerHTML ="<img src='style_images/1/chat/offline.gif' />";
			
			if(document.getElementById('status').value=='1') {
				document.getElementById('content').innerHTML +="<div class='comments'><div class='signout'>Người đang chat với bạn đã thoát ra.</div></div>";
				document.getElementById('status').value = 0;
			}
		}
		document.getElementById('content').scrollTop = document.getElementById('content').scrollHeight;
	}
}

chatobj.open("GET",url,true);
chatobj.send(null);
}

function getChatUser()
{ 
var chatobj=GetXmlHttpObject();

if (chatobj==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  }

var url="ajax.php?act=LiveHelp&CODE=GetChatUser";

chatobj.onreadystatechange= function () {
/*	if (chatobj.readyState==1)
	{
		document.getElementById('Clock').innerHTML="<img src='style_images/1/loader.gif' width='186' height='42' alt='Đang tải dữ liệu'/>";
	}*/
	if (chatobj.readyState==4)
	{
		data = chatobj.responseXML.documentElement;
		if(data.getElementsByTagName('Found')[0].firstChild.nodeValue=='1') {
			userid= data.getElementsByTagName('UserID')[0].firstChild.nodeValue;
			PopUp('index.php?act=LiveHelp&CODE=ShowWindows&ID='+userid+'&Chatting=1','_blank','354px','450px','0','1','1','1');
		}
		
	}
}

chatobj.open("GET",url,true);
chatobj.send(null);
}