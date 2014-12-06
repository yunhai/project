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
	//tinymce.PluginManager.requireLangPack('tgthvideo');
	tinymce.create('tinymce.plugins.TgthvideoPlugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
		ed.onSaveContent.add(function(ed, o) {
//			return;
//			var html=$("<div>"+o.content+"</div>" );
//			html.find("img.vsvideo").each(function(){
//				var ele=$('<iframe class="vsvideo" frameborder="0" allowfullscreen="" ></iframe>');
//				var code="";
//				ele.attr("src","http://www.youtube.com/embed/"+code);
//				ele.attr("width",$(this).attr("width"));
//				ele.attr("height",$(this).attr("height"));
//				ele.attr("style",$(this).attr("style"));
//				ele.attr("videoid",$(this).attr("alt"));
//				$(this).replaceWith(ele);
//			});
//	        o.content = html.html();    
	        //alert( o.content);
	    });
		
		 ed.onBeforeSetContent.add(function(ed, o) {
//			 return;
//	    	  var html=$("<div>"+o.content+"</div>" );
//				html.find("iframe.vsvideo").each(function(){
//					var icon=$("<img class='vsvideo' src='"+url + '/img/tgthvideo_timb.gif'+"'/>");
//					icon.attr("style",$(this).attr("style"));
//					icon.attr("height",$(this).attr("height"));
//					icon.attr("style",$(this).attr("style"));
//					icon.attr("alt",$(this).attr("videoid"));
//					icon.attr("width",$(this).attr("width"));
//					$(this).replaceWith(icon);
//				});
//				o.content=html.html();
	      });
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceTgthvideo', function() {
				ed.windowManager.open({
					file : baseUrl  +'videos/select_video_diagog&iframe=1',
					width : 521 + parseInt(ed.getLang('example.delta_width', 0)),
					height : 432 + parseInt(ed.getLang('example.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});

			// Register example button
			ed.addButton('tgthvideo', {
				title : 'tgthvideo.desc',
				cmd : 'mceTgthvideo',
				image : url + '/img/tgthvideo.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('tgthvideo', n.nodeName == 'IMG');
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
				longname : 'Example plugin',
				author : 'Some author',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('tgthvideo', tinymce.plugins.TgthvideoPlugin);
})();