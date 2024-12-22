<?php
/**
 * Template Name: Single Content
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="override-white">
	<?php
		$value = get_post_meta( get_the_ID(), '_filter_type_value', true );
		$bg_image = get_post_meta( get_the_ID(), '_bg_image_value', true );
		$img_default = zenpad_get_option( 'img_default' );
		$post_type_groups = zenpad_get_option( 'post_type_group' );

		if ( $post_type_groups ) {
			foreach ( $post_type_groups as $post_type_group ) {
				if ( $post_type_group['title'] == $value ) {
					$img_banner = $post_type_group['img_banner'];
				}
			}
		}

		$background = '';
		if ( $bg_image ) {
			$background = $bg_image;
		} elseif ( $img_banner ) {
			$background = $img_banner;
		} else {
			$background = $img_default;
		}
	?>
	<section id="top-banner">
		<div class="container-fluid">
			<div class="row">
				<div class="bg-img">
					<div class="bg-color">
						<div class="container">
							<a href="<?php echo home_url(); ?>" class="back-home">
								<p>
								&lt;&nbsp;&nbsp;
									<?php
										$back = zenpad_get_option('back_label');
										if ( $back ) {
											echo $back;
										} else {
											echo 'BACK';
										}
									?>
								</p>
							</a>
						</div>
						<div class="caption">
							<span>
								<hr/>
								<?php
									$cats = wp_get_post_categories( get_the_ID(), array( 'fields' => 'names' ) );
									if ( $cats ) {
										foreach ( $cats as $cat ) {
											if ( $cat == "All" ) {
												echo $cat = '';
											} else {
												echo $cat;
											}
										}
									}
								?>
								<hr/>
							</span>
							<h2><?php the_title(); ?></h2>
							<ul>
								<li>
									<a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo urlencode(get_the_permalink()) ?>&amp;via=ASUS" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
										<img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png"/>
									</a>
								</li>
								<li>
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink()) ?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
										<img src="<?php echo get_template_directory_uri(); ?>/images/fb.png"/>
									</a>
								</li>
								<li>
									<a href="mailto:?subject=<?php echo get_the_title(); ?>&amp;body=<?php echo urlencode(get_the_permalink()) ?>">
										<img src="<?php echo get_template_directory_uri(); ?>/images/mail.png"/>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<style type="text/css">
					.bg-img {
						position: relative;
						background: url(<?php echo $background; ?>) center center no-repeat;
						background-size: cover;
					}
				</style>
			</div>
		</div>
	</section>
	<section id="content">
		<?php
			if ( @vc_is_as_theme() ) {
				the_content( bootstrapBasicMoreLinkText() );
			} else { ?>
			<div class="container content-white">
				<div class="col-md-8 col-sm-8">
					<header class="entry-header">
						<div class="entry-content">
							<?php the_content( bootstrapBasicMoreLinkText() ); ?>
							<div class="clearfix"></div>
						</div>
					</header>
				</div>
				<div class="col-md-4 col-sm-4 pull-right">
					<aside class="article-info single-article">
						<p>
							<b><?php  
								if ( zenpad_get_option('authored_by_label_single') ) {
	                            echo zenpad_get_option('authored_by_label_single');
	                          } else {
	                            echo 'Authored By';
	                          }  
                          ?> </b>
							<?php
								$author = get_post_meta( get_the_ID(), '_custom_author_value', true );
								if ( $author ) {
									echo $author;
								} else {
									the_author();
								}
							?>
						</p>
						<p>
							<b><?php  
								if ( zenpad_get_option('tags_label_single') ) {
	                            echo zenpad_get_option('tags_label_single');
	                          } else {
	                            echo 'Tags';
	                          }  
                          ?> </b>
							<?php
								$tags = wp_get_post_tags(get_the_ID());
								if ( $tags ) {
									foreach ( $tags as $tag ) {
										echo "#".$tag->name."<br/>";
									}
								}
							?>
						</p>
						<p>
							
							<?php
								$categories = wp_get_post_categories(get_the_ID());
								if ( $categories ) {
									?>
									<b><?php  
								if ( zenpad_get_option('category_label_single') ) {
	                            echo zenpad_get_option('category_label_single');
	                          } else {
	                            echo 'Category';
	                          }  
                          ?> </b>
									<?php 
									foreach ( $categories as $category ) {
											$cat=get_category($category);
											if ($cat->name!="All"){
												echo $cat->name."<br/>";	
											}
									}
								}
							?>
						</p>
						<?php
							$ids = get_post_meta( $post->ID, '_related_product_value', true );

							if ( $ids ) { ?>

							<p class="feat-prod">
								<b><?php  
								if ( zenpad_get_option('featured_products_label_single') ) {
	                            echo zenpad_get_option('featured_products_label_single');
	                          } else {
	                            echo 'Featured Products';
	                          }  
                          ?> </b>
							</p>
							<div class="rel-prod">

								<?php
									$args = array(
										'post__in' => $ids,
										'post_type' => 'product',
										'posts_per_page' => -1
									);

									$rel_query = new WP_Query( $args );

									if ( $rel_query->have_posts() ) {
										while ( $rel_query->have_posts() ) {
											$rel_query->the_post(); ?>
											<div class="cont-prod-container clearfix">
												<div class="cont-prod">
													<table>
														<tbody>
															<tr>
																<td>
																	<?php if ( has_post_thumbnail() ) {
																		the_post_thumbnail("related-product", array('class' => "img-responsive" ));
																		// $img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
																		// $img_url = img_resize( $img_url, 194, 280 );
																	}
																	$url = get_post_meta( get_the_ID(), 'detailproduct_url', true ); ?>
																	<!-- <img src="<?php// echo $img_url ?>" class="img-responsive" /> -->
																</td>
																<td>
																	<a href="<?php echo $url; ?>">
																		<?php the_title(); ?>
																	</a>
																</td>
															</tr>
														</tbody>
													</table>														
												</div>
											</div>
										<?php }
									}
									wp_reset_query();
								?>
							</div>
						<?php } ?>
					</aside>
				</div>
			</div>
		<?php
			}
		?>

		<?php

		    // global $post;
		    $tags = wp_get_post_tags(get_the_ID());

		    if ($tags) {
			    $tag_ids = array();
			    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			    $args=array(
	    	    'post_type' => 'post',

			    'tag__in' => $tag_ids,
			    'post__not_in' => array($post->ID),
			    'posts_per_page'=>4, // Number of related posts to display.
			    'caller_get_posts'=>1
			    );
			}

			// $args = array(
			// 	'post__not_in' => array( get_the_ID() ),
			// 	'posts_per_page' => 9,
			// 	'ignore_sticky_posts' => 1,
			// 	'meta_value' => $value
			// );
			$related_query = new WP_Query( $args );
		?>
		<?php if($related_query->have_posts()) {?>
		<div class="container-fluid">
			<?php
				$related_query->the_post();
			?>
			<div class="row">
				<div class="col-md-12 noPad content-tosca">
					<?php
						$value = get_post_meta( get_the_ID(), '_filter_type_value', true );
						$bg_image = get_post_meta( get_the_ID(), '_bg_image_value', true );

						foreach ( $post_type_groups as $post_type_group ) {
							if ( $title = $post_type_group['title'] == $value ) {
								$ptg_img = $post_type_group['img_banner'];
							}
						}

						$banner = '';
						if ( ( $bg_image ) ) {
							$banner = $bg_image;
						} elseif ( ( $ptg_img ) ) {
							$banner = $ptg_img;
						} else {
							$banner = $img_default;
						}
					?>
					<div class="bg-related">
						<a href="<?php the_permalink(); ?>">
							<div class="caption">
								<span><?php  
								if ( zenpad_get_option('next_related_label_single') ) {
	                            echo zenpad_get_option('next_related_label_single');
	                          } else {
	                            echo 'Next Related Article';
	                          }  
                          ?> </span>
								<h2><?php the_title(); ?></h2>
							</div>
							<style type="text/css">
								.bg-related {
									position: relative;
									background: url(<?php echo $banner; ?>) center center no-repeat;
									background-size: cover;
								}
								.bg-related a:hover {
									text-decoration: none;
								}
							</style>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php } 
		if($related_query->have_posts()) {
		?>
		<div class="container content-related">
			<h3>
			<?php  
				if ( zenpad_get_option('other_related_label_single') ) {
                echo zenpad_get_option('other_related_label_single');
              } else {
                echo 'Other Related Article';
              }  
                          ?> </h3>
			<div class="row">
				<?php
					if ( $related_query->have_posts() ) {
						while ( $related_query->have_posts() ) {
							$related_query->the_post();
				?>
				<a href="<?php the_permalink(); ?>" class="col-md-3 col-sm-3 col-sm-6 col-xs-6 noPad grid-list news-text">
					<div class="caption">
						<div class="date"><?php the_time('d M Y'); ?></div>
						<h2><?php echo wp_trim_words( get_the_title(), 10, ' ...' ); ?></h2>
					</div>
					<?php
						if ( has_post_thumbnail() ) {
							$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
						} else {
							$img_url = $img_default;
						}
						$img_url = img_resize( $img_url, 293, 293 );
					?>
					<img src="<?php echo $img_url; ?>" />
				</a>
				<?php
						}
					}
				}
				?>
			</div>
		</div>
		<?php wp_reset_query(); ?>
	</section>
	<?php get_footer(); ?>
	</div>
</article><!-- #post-## -->
