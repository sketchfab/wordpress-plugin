(function() {
	tinymce.create('tinymce.plugins.SketchfabEmbedPlugin', {
	  init : function(ed, url) {
      ed.addButton('sketchfabEmbed', {
      	title: 'sketchfabEmbed.sketchfab',
      	image: url+'/sketchfab-mce.png',
      	onclick: function() {
          ed.windowManager.open ({
            title: 'Embed a sketchfab model', 
            file: url + '/prompt.htm',
            width: 345,
            height: 190,
            inline: 1
          }, {
            plugin_url : url
          });
      	}
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
    		version: '0.4'
    	};
    }
  });
  tinymce.PluginManager.add('sketchfabEmbed', tinymce.plugins.SketchfabEmbedPlugin);
 })();
