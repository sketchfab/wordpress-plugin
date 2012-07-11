(function() {
	tinymce.create('tinymce.plugins.SketchfabEmbedPlugin', {
	  init : function(ed, url) {
      ed.addButton('sketchfabEmbed', {
      	title: 'sketchfabEmbed.sketchfab',
      	image: url+'/sketchfab-mce.png',
      	onclick: function() {
      		// TODO ckeck for sanitizing input
      		// 			create a better designed prompt
          ed.windowManager.open ({
            title: 'Embed a sketchfab model', 
            file: url + '/prompt.htm',
            objId: 'id',
            width: 320,
            height: 170,
            inline: 1
          }, {
            plugin_url : url,
          });
      		
          /*var objId = prompt("Sketchfab model", "Enter the id of the url of the Sketchfab model");
      		if( objId )
      			ed.execCommand('mceInsertContent', false, '[sketchfab id="'+objId+'"]');
      	*/}
      });
    },
    createControl: function(n, cm) {
    	return null;
    },
    getInfo: function() {
    	return {
    		longname: 'Sketchfab viewer shortcode',
    		author: 'Sketchfab',
    		authorurl: 'http://sketchfab.com',
    		infourl: 'http://sketchfab.com',
    		version: '0.1'
    	};
    }
  });
  tinymce.PluginManager.add('sketchfabEmbed', tinymce.plugins.SketchfabEmbedPlugin);
 })();