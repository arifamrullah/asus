(function ()
{
	tinymce.create('tinymce.plugins.speedo_social_stream',
	{
		init: function (ed, url)
		{
			ed.addButton('speedo_social_stream',
			{
				title: 'Add a CardZ stream shortcode',
				image: url + '/icons/button.png',
				onclick: function ()
				{
                    ed.windowManager.open(
                    {
                        title: 'Add a CardZ stream shortcode',
                        body:
                        [
                            {
                                type: 'textbox',
                                name: 'use',
                                label: 'Stream slug or stream ID'
                            }
                        ],
                        onsubmit: function (ev)
                        {
                            ed.selection.setContent('[cardz use="' + ev.data.use +'" /]');
                        }
                    });
				}
			});
		},
		createControl: function(n, cm)
		{
			return null;
		}
	});

	tinymce.PluginManager.add('speedo_social_stream', tinymce.plugins.speedo_social_stream);

})();