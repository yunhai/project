/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	// Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('vsIndent');

	tinymce.create('tinymce.plugins.VsIndentPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceVsIndent');
		
			ed.addCommand('mceVsIndent', function() {
				var indvalue=15;
				var cunode=tinymce.activeEditor.selection.getNode();
//				alert(cunode.nodeName);
				if(cunode.nodeName=='BODY'){
					$(tinymce.activeEditor.selection.getEnd()).attr("vsindented",'1');
					var c=null;
					do{
						if(c==null){
							c=$(tinymce.activeEditor.selection.getStart());
						}else{
							c=c.next();
						}
						var ind=parseInt(c.css('text-indent'));
						c.css('text-indent',parseInt(ind+indvalue)+'px');
						
					}while(c.attr("vsindented")!=1&&c!=null);
					if(c!=null){
						c.removeAttr("vsindented");
					}
				}else{
					if(cunode.nodeName=='P'){
						var ind=parseInt($(cunode).css('text-indent'));
							$(cunode).css('text-indent',parseInt(ind+indvalue)+'px');
						
					}else{
						var t=$(cunode);
//						alert(t.get(0).nodeName);
						while(t.parent().get(0).nodeName!='BODY'){
//							alert(t.parent().get(0).nodeName);
							t=t.parent();
							
						}
						var ind=parseInt($(t).css('text-indent'));
//						alert(ind);
						$(t).css('text-indent',parseInt(ind+indvalue)+'px');
					}
					
				}
			});
			ed.addCommand('mceVsOutdent', function() {
				var indvalue=15;
				var cunode=tinymce.activeEditor.selection.getNode();
				//alert(cunode.nodeName);
				if(cunode.nodeName=='BODY'){
					$(tinymce.activeEditor.selection.getEnd()).attr("vsindented",'1');
					var c=null;
					do{
						if(c==null){
							c=$(tinymce.activeEditor.selection.getStart());
						}else{
							c=c.next();
						}
						var ind=parseInt(c.css('text-indent'));
						c.css('text-indent',parseInt(ind-indvalue)+'px');
						
					}while(c.attr("vsindented")!=1&&c!=null);
					if(c!=null){
						c.removeAttr("vsindented");
					}
				}else{
					if(cunode.nodeName=='P'){
						var ind=parseInt($(cunode).css('text-indent'));
							$(cunode).css('text-indent',parseInt(ind-indvalue)+'px');
						
					}else{
						var t=$(cunode);
//						alert(t.get(0).nodeName);
						while(t.parent().get(0).nodeName!='BODY'){
//							alert(t.parent().get(0).nodeName);
							t=t.parent();
							
						}
						var ind=parseInt($(t).css('text-indent'));
//						alert(ind);
						$(t).css('text-indent',parseInt(ind-indvalue)+'px');
					}
					
				}
			});
			ed.addCommand('mceVsResetIndent', function() {
				var cunode=tinymce.activeEditor.selection.getNode();
				//alert(cunode.nodeName);
				if(cunode.nodeName=='BODY'){
					$(tinymce.activeEditor.selection.getEnd()).attr("vsindented",'1');
					var c=null;
					do{
						if(c==null){
							c=$(tinymce.activeEditor.selection.getStart());
						}else{
							c=c.next();
						}
						var ind=parseInt(c.css('text-indent'));
						c.css('text-indent','0px');
						
					}while(c.attr("vsindented")!=1&&c!=null);
					if(c!=null){
						c.removeAttr("vsindented");
					}
				}else{
					if(cunode.nodeName=='P'){
							$(cunode).css('text-indent','0px');
						
					}else{
						var t=$(cunode);
//						alert(t.get(0).nodeName);
						while(t.parent().get(0).nodeName!='BODY'){
//							alert(t.parent().get(0).nodeName);
							t=t.parent();
							
						}
//						alert(ind);
						$(t).css('text-indent','0px');
					}
					
				}
			});
			// Register vsIndent button
			ed.addButton('vsindent', {
				title : 'vsIndent.desc',
				cmd : 'mceVsIndent',
				image : url + '/img/vsindent.gif'
			});
			ed.addButton('vsoutdent', {
				title : 'vsIndent.desc',
				cmd : 'mceVsOutdent',
				image : url + '/img/vsoutdent.gif'
			});
			ed.addButton('vsresetindent', {
				title : 'vsIndent.desc',
				cmd : 'mceVsResetIndent',
				image : url + '/img/vsresetindent.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('vsIndent', n.nodeName == 'IMG');
			});
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'VsIndent plugin',
				author : 'Some author',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/vsIndent',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('vsindent', tinymce.plugins.VsIndentPlugin);
})();