<?php
/**
 *	Canvas HTML structure.
 *
 *	Available variables:
 *      $options        The options JSON as a string. This should be passed to the plugin call.
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php _e('CardZ Social Stream Canvas', 'cardz-social-stream'); ?></title>
    
	<script src="<?php echo admin_url('load-scripts.php?c=0&load%5B%5D=jquery-core,jquery-migrate,utils'); ?>"></script>
    <script src="<?php echo SS_PURL; ?>/content/js/cardz.social.js"></script>
    
    <style>
        body
        {
            margin: 0;
            padding: 0;
        }
        
        .cardz-social-slideshow
        {
            display: none;
        }
        
        <?php echo SS_Data()->get_option('ss-css-data', ''); ?>
    </style>
    
    <script>
        var social_instance = null;
        
        var default_options = <?php echo $options; ?>;
        
        default_options = jQuery.extend(default_options,
        {
            grid:
            {
                width: 280,
                gutter: 10,
                cols: 8
            },
            feedData:
			[
				{
					network:		'facebook',
					id:				'360250160730505',
					created:		+new Date(),
					author_link:	'javascript: void(0);',
					author_picture:	'https://graph.facebook.com/360250160730505/picture',
					author_name:	'Agapa Studio',
					message:		'This is a test feed, it is only for design preview.',
					description:	'',
					link:			'javascript: void(0);',
					attachment:		'<?php echo SS_PURL; ?>/content/images/demo-01.jpg'
				},
                {
					network:		'google',
					id:				'360250160730505',
					created:		+new Date(),
					author_link:	'javascript: void(0);',
					author_picture:	'https://graph.facebook.com/360250160730505/picture',
					author_name:	'Agapa Studio',
					message:		'This is a test feed, it is only for design preview.',
					description:	'',
					link:			'javascript: void(0);',
					attachment:		'<?php echo SS_PURL; ?>/content/images/demo-02.jpg'
				},
                {
					network:		'youtube',
					id:				'360250160730505',
					created:		+new Date(),
					author_link:	'javascript: void(0);',
					author_picture:	'https://graph.facebook.com/360250160730505/picture',
					author_name:	'Agapa Studio',
					message:		'This is a test feed, it is only for design preview.',
					description:	'',
					link:			'javascript: void(0);',
					attachment:		'<?php echo SS_PURL; ?>/content/images/demo-03.jpg'
				},
                {
					network:		'dribbble',
					id:				'360250160730505',
					created:		+new Date(),
					author_link:	'javascript: void(0);',
					author_picture:	'https://graph.facebook.com/360250160730505/picture',
					author_name:	'Agapa Studio',
					message:		'This is a test feed, it is only for design preview.',
					description:	'',
					link:			'javascript: void(0);',
					attachment:		'<?php echo SS_PURL; ?>/content/images/demo-04.jpg'
				}
			]
        });
        
		jQuery(function($)
		{
			social_instance = $('.cardz-social').cardZSocial(default_options);
		});
	</script>
</head>
<body>
    <div class="cardz-social"></div>
</body>
</html>