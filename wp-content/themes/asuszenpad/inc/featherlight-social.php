<?php
	// include_once dirname( _FILE_ ) . "/../../../wp-load.php";	
require_once( "../../../../wp-config.php" );

	$pid = $_GET['id'];

	query_posts( array( 
		'p'	=> $pid,
		'post_type'	=> array( 'social-feed' )
	) );

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			$terms = get_the_terms( get_the_ID(), 'social-feed-categories' );
			$link = get_post_meta( get_the_ID(), '_url_value', true );
			$username = get_post_meta( get_the_ID(), '_username_value', true );
			$userphoto = get_post_meta( get_the_ID(), '_userphoto_value', true );
			if ( empty( $link ) ) {
				$link = 'javascript:void(0)';
			} ?>
			<div id="social-lightbox" class="clearfix">
					<?php
						if ( has_post_thumbnail() ) {
							$img_id = get_post_thumbnail_id();
							$img_url = wp_get_attachment_image_src( $img_id, array( 432, 432 ), true );
							$bg = "background-image: url(".$img_url[0].");";
						}
					?>
				<div class="social-lightbox-left" style="<?php echo $bg; ?>"></div>
				<div class="social-lightbox-right">
					<div class="social-lightbox-user clearfix">
						<?php
							if ( $userphoto ) {
								echo '<img src='.$userphoto.' />';
							}
							if ( $username ) {
								echo '<p>'.$username.'</p>';
							}
						?>
					</div>
					<div class="social-lightbox-content">
						<?php the_content(); ?>
					</div>
					<div class="social-lightbox-category">
						<div class="clearfix pull-left">
							<?php
								if ( $terms[0]->slug == 'facebook' ) {
									echo '<a class="social-lightbox-fb" href="'.$link.'" target="_blank">View on '.$terms[0]->name.'</a>';
								} elseif ( $terms[0]->slug == 'twitter' ) {
									echo '<a class="social-lightbox-twitter" href="'.$link.'" target="_blank">View on '.$terms[0]->name.'</a>';
								} elseif ( $terms[0]->slug == 'instagram' ) {
									echo '<a class="social-lightbox-insta" href="'.$link.'" target="_blank">View on '.$terms[0]->name.'</a>';
								}
							?>
						</div>
						<ul class="clearfix pull-right socmed-modals">
							<li>
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( $link ); ?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="soc-facebook">
									<i class="fa fa-facebook"></i>
								</a>
							</li>
							<li>
								<a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo urlencode( $link ); ?>&amp;via=ASUS" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" class="soc-twitter">
									<i class="fa fa-twitter"></i>
								</a>
							</li>
							<li>
								<a href="https://plus.google.com/share?url=<?php echo urlencode( $link ); ?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="soc-google">
									<i class="fa fa-google-plus"></i>
								</a>
							</li>
							<li>
								<a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode( $link ); ?>&amp;media=<?php echo $img_url[0]; ?>&amp;description=<?php echo urlencode( strip_tags( get_the_content() ) ); ?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="soc-pinterest">
									<i class="fa fa-pinterest"></i>
								</a>
							</li>
							<li>
								<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode( $link ); ?>&amp;title=<?php echo get_the_title(); ?>&amp;summary=<?php echo urlencode( strip_tags( get_the_content() ) ); ?>&amp;source=" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="soc-linkedin">
									<i class="fa fa-linkedin"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<?php }
	}
	wp_reset_query();
?>