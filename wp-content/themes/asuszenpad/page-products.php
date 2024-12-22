<?php
/**
 *	Template Name: Products
 *	The template for displaying List Products.
 */
get_header();
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
              if ( zenpad_get_option('small_text_product') ) {
                echo zenpad_get_option('small_text_product');
                } else {
                echo 'Find the right';
                } 
              ?>

              <?php
                query_posts(array(
                  'post_type'    => array( 'page' )
                ));

                if ( has_post_thumbnail() ) {
                  $background = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                }

                wp_reset_query();
              ?>
              <hr/>
            </span>
            <h2><?php
              if ( zenpad_get_option('large_text_product') ) {
                echo zenpad_get_option('large_text_product');
                } else {
                echo 'ZENPAD FOR YOU';
                } 
              ?></h2>
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
<div id="section-selector">
  <div class="container">
      <form class="customize-box" action="<?php echo home_url(); ?>/product-results" method="GET">
          <?php function getallcats( $tree1 ) { ?>
            <?php $trees2 = get_terms( 'product-categories', array( 'parent' => $tree1->term_id, 'hide_empty' => 0 ) ); ?>
              <?php if ( !empty( $trees2 ) ) : ?>
                <?php foreach ( $trees2 as $tree2_k => $tree2 ) : ?>
                  <div class="cb-group clearfix">
                    <?php $imgurl = '' ?>
                    <?php if ( function_exists( 'z_taxonomy_image_url' ) ) $imgurl = z_taxonomy_image_url( $tree2->term_id ); ?>
                    <?php if ( !empty( $imgurl ) ) : ?>
                      <div class="col-md-3 col-sm-3 cb_img"><img src="<?php echo $imgurl ?>" /></div>
                    <?php else : ?>
                      <div class="col-md-3 col-sm-3 cb_img"><img src="" /></div>
                    <?php endif; ?>
                    <div class="col-md-9 col-sm-9">
                      <p>
                         <?php echo $tree2->name; ?>
                      </p>
                      <?php $trees3 = get_terms( 'product-categories', array( 'parent' => $tree2->term_id, 'hide_empty' => 0 ) ); ?>
                      <?php if ( !empty( $trees3 ) ) : ?>
                        <?php foreach ( $trees3 as $tree3_k => $tree3 ) : ?>
                        <div class="col-md-4 col-sm-4">
                          <div class="cb-radio">
                              <input type="radio" id="id-<?php echo $tree3->slug ?>" name="<?php echo $tree2->slug ?>" value="<?php echo $tree3->slug ?>"/>
                              <label for="id-<?php echo $tree3->slug ?>"><span></span><?php echo $tree3->name ?></label>
                          </div>
                        </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach ?>
              <?php endif ?>
          <?php } ?>
          <?php $trees1 = get_terms( 'product-categories', array( 'parent' => 0, 'hide_empty' => 0 ) );
            if ( !empty( $trees1 ) ) {
              foreach ( $trees1 as $tree1_k => $tree1 ) : ?>
                <?php if ( $tree1_k > 0 ) : ?>
                  <a href="javascript:void(0)" class="more-opt" data-id="more-opt<?php echo $tree1_k?>">
                    <span>+</span>
                    <?php
                    if ( zenpad_get_option('narrow_it_product') ) {
                      echo zenpad_get_option('narrow_it_product');
                      } else {
                      echo 'Narrow it down more';
                      } 
                    ?>
                  <span>+</span>
                  </a>
                  <a href="javascript:void(0)" class="less-opt" data-id="more-opt<?php echo $tree1_k?>">
                    <span>-</span>
                    <?php
                    if ( zenpad_get_option('less_options_product') ) {
                      echo zenpad_get_option('less_options_product');
                      } else {
                      echo 'Less Options';
                      } 
                    ?>
                    <span>-</span>
                  </a>
                  <div class="box-white more-opt-box clearfix" id="more-opt<?php echo $tree1_k?>">
                    <?php getallcats( $tree1 ) ?>
                  </div>
                <?php else : ?>
                  <div class="box-white clearfix">
                    <?php getallcats( $tree1 ) ?>
                  </div>
                <?php endif ?>
              <?php endforeach;
            }
          ?>
          <input type="submit" class="btn btn-grey btn-grey-lg" value="<?php
        if ( zenpad_get_option('view_my_zenpad_product') ) {
          echo zenpad_get_option('view_my_zenpad_product');
          } else {
          echo 'View My ZenPad';
          } 
        ?>
"/>
      </form>
  </div>
</div>
<script type="text/javascript">
	//CAROUSEL SOCIAL
  $(document).ready(function(){
  $('.bxslider').bxSlider({
  minSlides: 3,
  maxSlides: 6,
  slideWidth: 200,
  slideMargin: 12
  });

  $('#openSearch').click(function(){
      $('.search-box').toggle()
      $('.compare-box').hide()
  })

   $('#openCompare').click(function(){
      $('.compare-box').toggle()
      $('.search-box').hide()
  })

     $('.more-opt').click(function(){
      $('.more-opt-box').slideDown(100)
      $(this).hide()
      $('.less-opt').css("display","block");
  })

       $('.less-opt').click(function(){
      $('.more-opt-box').slideUp(100)
      $(this).hide()
      $('.more-opt').css("display","block");
  })

  });
</script>

<?php get_footer() ?>
