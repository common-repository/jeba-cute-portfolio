(function() {
	tinymce.PluginManager.add('portfolio_jeba_slider_button', function( editor, url ) {
		editor.addButton('portfolio_jeba_slider_button', {
			text: 'Jeba-Portfolio',
			icon: false,
			onclick: function() {
				editor.insertContent('[jeba_portfolio post_type="jeba-pitems" category="" count=""]');
			}
		});
	});
})();