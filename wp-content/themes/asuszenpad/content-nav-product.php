<?php
/**
 * Template Name: Content Nav Product
 */
global $firstload;
?>
<section id="menu-top">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 noPad">
        <a href="<?php echo esc_url( home_url('/products') ); ?>" class="white-button">
          <?php
            if ( zenpad_get_option('selector_label') ) {
              echo zenpad_get_option('selector_label');
            } else {
              echo 'Find the right ASUS ZenPad for you';
            }
          ?>
        </a>
      </div>
      <div class="col-md-6 noPad <?php echo ( $firstload == 'y' ) ? 'blueactive' : ''; ?>">
        <a id="menuCarousel" data-toggle="collapse" href="#asusTop" class="black-button <?php echo ( $firstload == 'y' ) ? 'active' : ''; ?>" aria-expanded="false" aria-controls="asusTop">
          <?php
            if ( zenpad_get_option('list_label') ) {
              echo zenpad_get_option('list_label');
            } else {
              echo 'Featured ASUS ZenPad products';
            }
          ?>
          <span class="plus-icon"></span>
        </a>
      </div>
      <div class="collapse <?php echo ( $firstload == 'y' ) ? 'in' : ''; ?>" id="asusTop">
        <div class="menu-content <?php echo ( $firstload == 'y' ) ? 'bordered' : ''; ?>">
          <div class="container">
            <div id="topItems" class="top-slide">
              <?php
                query_posts( array(
                  'post_type'   => array( 'product' ),
                  'meta_query'  => array(
                    array(
                      'key'   => 'detailproduct_list',
                      'value' => 'yes'
                    )
                  ),
                  'orderby'     => 'menu_order',
                  'order'=>'ASC'
                ) );

                if ( have_posts() ) {
                  while ( have_posts() ) {
              ?>
              <div class="slide-item">
                <?php
                  the_post();
                  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                ?>
                <table class="img-list">
                  <tr>
                    <td>
                      <img class="img-responsive" src="<?php echo $url; ?>" />
                    </td>
                  </tr>
                </table>
                <div class="item-detail">
                  <a href=""><?php the_title(); ?></a>
                  <span>
                    <?php
                      $desc = get_post_meta( $post->ID, 'detailshort_description', true );
                      echo wp_trim_words( $desc, 20 );
                    ?>
                  </span>
                  <?php
                    $details = get_post_meta( $post->ID, 'detailproduct_url', true );
                    if ( $details ) { ?>
                      <a href="<?php echo $details; ?>" class="btn btn-default"><?php 
                          if ( zenpad_get_option('product_details_label') ) {
                            echo zenpad_get_option('product_details_label');
                          } else {
                            echo 'Product Details';
                          }  
                          ?>
                        </a> <?php
                    }
                  ?>
                  <?php
                    $buyurl = get_post_meta( $post->ID, 'detailbuy_url', true );
                    if ( $buyurl ) { ?>
                      <a href="<?php echo $buyurl; ?>" class="btn btn-blue-outline">
                        <?php 
                          if ( zenpad_get_option('buy_now_label') ) {
                            echo zenpad_get_option('buy_now_label');
                          } else {
                            echo 'Buy Now';
                          }  
                          ?>

                      </a> <?php
                    }
                  ?>
                </div>
              </div>
              <?php
                  }
                }
                
                wp_reset_query();
              ?>
            </div>
            <div class="discover">
              <a href="http://www.asus.com/tablets/">
                <button>
                  <?php 
                          if ( zenpad_get_option('view_compare_tablets') ) {
                      echo zenpad_get_option('view_compare_tablets');
                    } else {
                      echo 'View and Compare All Tablets';
                    } 
                    ?>
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
