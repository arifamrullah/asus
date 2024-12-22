<?php
/**
 *	Preview HTML structure.
 *
 *	Available variables:
 *      $options        The options JSON as a string. This should be passed to the plugin call.
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php _e('CardZ Social Stream Preview', 'cardz-social'); ?></title>
    
	<script src="<?php echo admin_url('load-scripts.php?c=0&load%5B%5D=jquery-core,jquery-migrate,utils'); ?>"></script>
    <script src="<?php echo SS_PURL; ?>/content/js/cardz.social.js"></script>
    
    <style>
        body
        {
            margin: 0;
            padding: 0;
        }
        
        <?php echo SS_Data()->get_option('ss-css-data', ''); ?>
    </style>
    
    <script>
        var social_instance = null;
        
        var default_options = <?php echo $options; ?>;
        
		jQuery(function($)
		{
            // setTimeout(function ()
            // {
			    social_instance = $('.cardz-social').cardZSocial(default_options);
            // }, 1000);
		});
	</script>
</head>
<body>
    <div class="cardz-social"></div>
</body>
</html>