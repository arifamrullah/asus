<?php
/**
 * Template Name: Content Article
 */
?>
<section id="content-filter">
  <div class="filter-box">
    <div class="container-fluid">
      <form class="row">
        <div class="filter-search">
          <div class="container">
            <?php
              $src = zenpad_get_option('search_label');
              if ( ! $src ) {
                $src = 'What are you looking for today?';
              }
            ?>
            <input type="text" placeholder="<?php echo $src; ?>" />
            <a href="javascript:void(0)" class="close-filter">
              <img src="<?php echo get_template_directory_uri(); ?>/images/close-icon.png"/>
            </a>
          </div>
        </div>
        <div class="filter-opt clearfix">
          <div class="container">
            <div id="filters" class="col-md-8 col-sm-8 button-group">
              <h3>
                <?php
                  if ( zenpad_get_option( 'ftype_label' ) ) {
                    echo zenpad_get_option( 'ftype_label' );
                  } else {
                    echo "Filter Type";
                  }
                ?>
              </h3>
              <a href="javascript:void(0)" data-filter="*" class="active">All</a>
              <?php
                $filter_group = zenpad_get_option('filter_group');
                $count = count( $filter_group );
                if ( $count > 0 ) {
                  foreach ( $filter_group as $ftg ) {
                    echo "<a href = 'javascript:void(0)' data-filter='".$ftg['hashtag']."'>".$ftg['hashtag']."</a></li>\n";
                  }
                }
              ?>
            </div>
            <div id="sorts" class="col-md-4 col-sm-4 button-group">
              <h3>
                <?php
                  if ( zenpad_get_option( 'sort_label' ) ) {
                    echo zenpad_get_option( 'sort_label' );
                  } else {
                    echo "Sort by";
                  }
                ?>
              </h3>
              <a href="javascript:void(0)" class="recent active" data-sort="recent">
                <?php
                  if ( zenpad_get_option('recent_label') ) {
                    echo zenpad_get_option('recent_label');
                  } else {
                    echo 'Most Recent';
                  }
                ?>
              </a>
              <a href="javascript:void(0)" class="popular" data-sort="popular">
                <?php
                  if ( zenpad_get_option('popular_label') ) {
                    echo zenpad_get_option('popular_label');
                  } else {
                    echo 'Most Popular';
                  }
                ?>
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="result-container"></div>
  <div class="grid-content">
    <div class="container">
      <div class="row" id="main">
        <div class="grid-sizer"></div>
        <div class="col-md-12 text-center loader" style="display:none">
          <img src="<?php echo get_template_directory_uri() ?>/images/bx_loader.gif" alt="loader" style="min-height: auto;margin: 0 auto;float: none;margin:10% 45%;" />
        </div>

        <?php
          $count = count(
            query_posts(
              array(
                'posts_per_page' => -1,
                'post_status' => array( 'publish' ),
                'post_type' => array( 'post' )
              )
            )
          );

          while ( have_posts() ) : the_post();
            $grids = get_post_meta( get_the_ID(), '_grid_type_value', true );
            // echo get_the_title()."<br>".$grids."<br>";
            if ( $grids == 2 ) {
              $num = 6;
              $total_num += $num;
              $gridCount += count( $grids );
            } elseif ( $grids == 4 ) {
              $num = 12;
              $total_num += $num;
              $gridCount += count( $grids );
            } else {
              $num = 3;
              $total_num += $num;
              $gridCount += count( $grids );
            }

            // echo $num."-";
            // echo $total_num."-";
            if ( $total_num <= 36 ) {
              // echo $total_num."-";
              $num_posts = $gridCount;
              // echo $num_posts."-";
            }

          endwhile;
          wp_reset_query();

          // die();

          // $count_sticky = count( get_option( 'sticky_posts' ) );
          $numPosts = ( isset( $_GET['numPosts'] ) ) ? $_GET['numPosts'] : $num_posts;
          $page = ( isset( $_GET['pageNumber'] ) ) ? $_GET['pageNumber'] : 0;
          $total_pages = ceil( $count / $numPosts );
        ?>

        <script type="text/javascript">var total_pages = "<?php echo $total_pages; ?>";</script>

        <?php
          $args = array(
            'posts_per_page' => $numPosts/* - $count_sticky*/,
            'paged'          => $page,
            'post_status' => array( 'publish' ),
            'post_type'      => array( 'post' )
          );

          $query = new WP_Query( $args );

          if ( $query->have_posts() ) {
            session_start();
            unset( $_SESSION['mans_id'] );
            $manso_id = array();
            while ( $query->have_posts() ) {
              $query->the_post();
              $ptgArray = get_post_meta( $post->ID, '_filter_type_value', true );
              $ptgGrid = get_post_meta( $post->ID, '_grid_type_value', true );
              $exURL = get_post_meta( $post->ID, '_ex_url_value', true );
              if ( $ptgGrid == 2 ) {
                $ptgString = 'col-md-6';
              } elseif ( $ptgGrid == 4 ) {
                $ptgString = 'col-md-12';
              } else {
                $ptgString = 'col-md-3';
              }

              $href = get_the_permalink();
              $df = '';
              $blank = '';
              if ( $ptgArray == 'Video Post' ) {
                $href = get_template_directory_uri().'/inc/featherlight-video.php?id='.get_the_ID();
                $df = 'data-featherlight';
              } elseif ( $ptgArray == 'External Post' ) {
                if ( $exURL ) {
                  $href = $exURL;
                } else {
                  $href = get_the_permalink();
                }
                $blank = 'target = "_blank"';
              }

            ?>
            <a href="<?php echo $href; ?>" <?php echo $blank; ?> class="<?php echo $ptgString; ?> noPad grid-list news-img box" <?php echo $df; ?> >
              <div class="caption">
                <h2><?php echo wp_trim_words( get_the_title(), 10, ' ...' ); ?></h2>
              </div>
              <div class="thumb">
                <?php
                  if ( has_post_thumbnail() ) {
                    $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                  } else {
                    $url = zenpad_get_option( 'img_default' );
                  }

                  if ( $ptgGrid == 2 ) {
                    $url = img_resize( $url, 293*2, 293 );
                  } elseif ( $ptgGrid == 4 ) {
                    $url = img_resize( $url, 293*4, 293 );
                  } else {
                    $url = img_resize( $url, 293, 293 );
                  }

                  $manso_id[] = get_the_ID();

                  if ( $ptgArray == 'Video Post' ) { ?>
                    <span class="play-btn"><img src="<?php echo get_template_directory_uri(); ?>/images/play-button.png"></span> <?php
                  } ?>

                <img src="<?php echo $url; ?>" />
              </div>
            </a>
            <?php
          }
          $_SESSION['mans_id'] = $manso_id;
        }
        // wp_reset_query();
        ?>
      </div>
      <div class="clearfix"></div>
      <a class="load btn-greyBorder">
        <?php
          if ( zenpad_get_option('load_label') ) {
            echo zenpad_get_option('load_label');
          } else {
            echo 'Load More';
          }
        ?>
      </a>
      <p class="end btn-greyBorder">
        - <?php
          if ( zenpad_get_option('end_of_articles_home') ) {
                            echo zenpad_get_option('end_of_articles_home');
                          } else {
                            echo 'End of Articles';
                          }
                           ?> -
      </p>
    </div>
  </div>
  <div class="grid-social">
		<div class="container">
			<div class="row">
				<div class="pull-left">
					<div class="title-head clearfix">
						<h2 class="pull-left">
              <?php
                if ( zenpad_get_option('social_label') ) {
                  echo zenpad_get_option('social_label');
                } else {
                  echo 'Social Media';
                }
              ?>
             |</h2>
						<p class="pull-left">
              <?php
                if ( zenpad_get_option('social_desc_label') ) {
                  echo zenpad_get_option('social_desc_label');
                } else {
                  echo 'What everyone is saying about us ';
                }
              ?>
              <span>
              <?php
                if ( zenpad_get_option('social_hash_label') ) {
                  echo zenpad_get_option('social_hash_label');
                } else {
                  echo '#OnYourTerms';
                }
              ?>
              </span>
            </p>
					</div>
				</div>
				<div class="pull-right">
					<ul class="social-filter clearfix">
						<li>
							<a class="instagram" data-social="instagram">Instagram</a>
						</li>
						<li>
							<a class="twitter" data-social="twitter">Twitter</a>
						</li>
						<li>
							<a class="fb" data-social="facebook">Facebook</a>
						</li>
						<li class="active">
							<a class="all" data-social="all">All</a>
						</li>
					</ul>
				</div>
        <div class="clear"></div>
				<div class="row">
					<?php
						$args = array(
              'post_type' => array( 'social-feed' ),
              'posts_per_page' => -1
            );
						$the_query = new WP_Query( $args );
					?>
					<div class="carousel slide" id="carousel-social">
						<ul class="bxslider" data-featherlight-gallery data-featherlight-filter="li">
							<?php
							if ( $the_query->have_posts() ) {
								while ( $the_query->have_posts() ) {
									$the_query->the_post();
									$terms = get_the_terms( $the_query->ID, 'social-feed-categories' );

									$background = "";
									$class_li = "li-noimage";
									if ( has_post_thumbnail() ) {
										$image_id = get_post_thumbnail_id();
										$image_url = wp_get_attachment_image_src( $image_id, array( 432, 432 ), true );
										$background = "background-image: url(".$image_url[0].");";
										$class_li = "li-slide";
									}

                  $link = get_post_meta( $post->ID, '_url_value', true );
                  if ( empty( $link ) ) {
                    $link = 'javascript:void(0)';
                  }

							?>
							<li href="<?php echo get_template_directory_uri(); ?>/inc/featherlight-social.php?id=<?php echo get_the_ID(); ?>" class="<?php echo $class_li; ?>" style="<?php echo $background; ?>">
								<div class="social-item">
                  <div class="social-entry">
                    <?php the_content(); ?>
                  </div>
                  <a href="<?php echo $link; ?>" target="_blank" class="social-external-link"></a>
                </div>
								<?php
  								if ( $terms[0]->slug == 'facebook' ) {
  									$class = "social-fb";
  								} elseif ( $terms[0]->slug == 'twitter' ) {
  									$class = "social-twitter";
  								} elseif ( $terms[0]->slug == 'instagram' ) {
  									$class = "social-insta";
  								}
								?>
                <span class="<?php echo $class; ?>"></span>
							</li>
							<?php
								}
							}
							wp_reset_query();
							?>
						</ul>
						<nav>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
