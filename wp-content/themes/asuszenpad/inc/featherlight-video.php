<?php
	// include_once dirname( _FILE_ ) . "/../../../wp-load.php";	
require_once( "../../../../wp-config.php" );

	$pid = $_GET['id'];

	query_posts( array( 
		'p'	=> $pid,
		'post_type'	=> array( 'post' )
	) );

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	wp_reset_query();
?>