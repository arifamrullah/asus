<?php
/**
 * Template Name: Home
 */

	get_header();
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
?>

<?php get_template_part( 'content', 'nav-product' ); ?>

<section id="top-slider">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 noPad">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<?php
						global $post;
						$rev_sc = get_post_meta( $post->ID, '_rev_sc_value', true );
						if ( ( $rev_sc ) && ( is_plugin_active( 'revslider/revslider.php' ) ) ) {
							echo do_shortcode( $rev_sc );
						} else {
							$passions = zenpad_get_option('repeat_group');
							if ( $passions ) { ?>
								<div class="carousel-inner">
									<?php
										foreach ($passions as $key => $passion) { ?>			
											<div class="item <?php echo $key==0 ? 'active' : ''; ?>">
												<img src="<?php echo $passion['hero_img']; ?>" />
											</div>
										<?php }
									?>
								</div>
							<?php }
						}
						$categories = get_categories();
						if ( ! empty( $categories ) ) {
							$nav = "";
							foreach ( $categories as $key => $cat ) {
								$cat_id = $cat->term_id;
								$cat_data = get_option("category_$cat_id");
								$nav .='
									<li data-passion="'.$cat->slug.'" class="'.( ( $key==0 ) ? "active" : "" ).'">
										<a href="javascript:void(0)"><span class="icon-passion'.$key.'">
											<style type="text/css">
												.icon-passion'.$key.' {background: url('.$cat_data['icon'].') center center no-repeat;}
												.active .icon-passion'.$key.', li a:hover .icon-passion'.$key.' {background: url('.$cat_data['icon_hover'].') center center no-repeat;}
											</style>
											</span>'.$cat->name.'
										</a>
									</li>
								';
							}
						}
					?>
				 	<div class="container">
					 	<ul class="nav nav-pills">
					 		<?php echo $nav; ?>
						</ul>
						<a href="javascript:void(0)" class="filter-button">
							<?php 
                if ( zenpad_get_option('filter_label') ) {
                  echo zenpad_get_option('filter_label');
                } else {
                  echo 'more filter options';
                }
              ?>
							<i class="glyphicon glyphicon-triangle-bottom"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="filter-mobile">
      <h3>filter articles</h3>
      <?php
				if ( ! empty( $categories ) ) {
					$navmob = "";
					foreach ( $categories as $key => $cat ) {
						$cat_id = $cat->term_id;
						$cat_data = get_option("category_$cat_id");
						$navmob .='
							<li data-passion="'.$cat->slug.'" class="'.( ( $key==0 ) ? "choosen active" : "" ).'">
								<a href="javascript:void(0)"><span class="mob-icon-passion'.$key.'">
									<style type="text/css">
										@media(max-width:767px) {
											.mob-icon-passion'.$key.' {
												display: block;
												margin: 0 auto;
												height: 48px;
												background-size: 100% auto;
												background:  url('.$cat_data['icon'].') center center no-repeat;
											}
											.choosen.active .mob-icon-passion'.$key.',
											li a:hover .mob-icon-passion'.$key.' {
												background: url('.$cat_data['icon_hover'].') center center no-repeat;
											}
											li a:hover .mob-icon-passion'.$key.' + p {
												color: #00a8ff;
											}
										}
									</style>
									</span>
									<p>'.$cat->name.'</p>
								</a>
							</li>
						';
					}					
				}
		 	?>
      <ul class="filter-choose">
      	<?php echo $navmob; ?>
      </ul>
      <a href="javascript:void(0)" class="filter-btn">
      	<?php 
          if ( zenpad_get_option('filter_label') ) {
            echo zenpad_get_option('filter_label');
          } else {
            echo 'more filter options';
          }
        ?>
      	<i class="glyphicon glyphicon-triangle-bottom"></i>
    	</a>
    </div>
	</div>
</section>

<?php get_template_part('content', 'article');?>

<?php get_footer(); ?>
