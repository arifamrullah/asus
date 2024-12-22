<?php
/**
 *	Template Name: Product Results
 *	The template for displaying Product Results.
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
              Find the right
              <?php
                query_posts(array(
                  'post_type' => array( 'page' )
                ));

                if ( has_post_thumbnail() ) {
                  $background = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
                }

                wp_reset_query();
              ?>
              <hr/>
            </span>
            <h2>ZENPAD FOR YOU</h2>
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
      <?php echo the_content(); ?>
      <form class="customize-box cb-question" action="<?php echo home_url(); ?>/product-results" method="GET">
          <div class="box-white clearfix">
              <div class="cb-head-panel clearfix">
                  <h4 class="pull-left">
                  <?php
                  if ( zenpad_get_option('your_preferences_product_results') ) {
                    echo zenpad_get_option('your_preferences_product_results');
                    } else {
                    echo 'Your Preferences';
                    } 
                  ?>
                </h4>
              </div>
              <?php function getallcats($tree1){ ?>
                <?php $trees2 = get_terms( 'product-categories', array( 'parent' => $tree1->term_id, 'hide_empty' => 0 )); ?>
                <?php if(!empty($trees2)): ?>
                  <?php foreach($trees2 as $tree2_k => $tree2): ?>
                    <div class="cb-group clearfix">
                      <div class="col-md-12">
                        <?php $trees3 = get_terms( 'product-categories', array( 'parent' => $tree2->term_id,'hide_empty' => 0 )); ?>
                        <?php if(!empty($trees3)): ?>
                          <?php foreach($trees3 as $tree3_k => $tree3): ?>
                            <?php $selected = ''; if($_GET[$tree2->slug] == $tree3->slug){
                                $selected = 'checked';
                              }?>
                          <div class="col-md-4 col-sm-4">
                            <div class="cb-radio">
                                <input type="radio" id="id-<?php echo $tree3->slug ?>" name="<?php echo $tree2->slug ?>" <?php echo $selected ?> value="<?php echo $tree3->slug ?>"/>
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
                <?php $trees1 = get_terms( 'product-categories', array( 'parent' => 0,'hide_empty' => 0 ));
                  if ( !empty( $trees1 ) ) {
                    foreach ( $trees1 as $tree1_k => $tree1 ) : ?>
                      <?php if ( $tree1_k > 0 ) : ?>
                        <a href="javascript:void(0)" class="more-opt" data-id="more-opt<?php echo $tree1_k?>">
                          <span>+</span>
                          <?php
                          if ( zenpad_get_option('view_all_product') ) {
                            echo zenpad_get_option('view_all_product');
                            } else {
                            echo 'View All';
                            } 
                          ?>
                          <span>+</span>
                        </a>
                        <div class="more-opt-box clearfix" id="more-opt<?php echo $tree1_k?>">
                          <?php getallcats($tree1) ?>
                        </div>
                        <input type="submit" class="btn btn-grey btn-grey-lg" value="<?php
if ( zenpad_get_option('specify_again_product') ) {
  echo zenpad_get_option('specify_again_product');
  } else {
  echo 'Specify Again';
  } 
?>
" style="display:none;" />
                        <a href="javascript:void(0)" class="less-opt" data-id="more-opt<?php echo $tree1_k?>">
                          <span>-</span>View Less<span>-</span>
                        </a>
                      <?php else : ?>
                        <div class="box-white clearfix">
                          <?php getallcats($tree1) ?>
                        </div>
                      <?php endif ?>
                    <?php endforeach;
                  }
                ?>
          </div>
      </form>
      <div class="customize-result">
          <div class="box-white clearfix">
              <div class="cb-head-panel clearfix">
                  <h4 class="pull-left">
                    <?php
                    if ( zenpad_get_option('you_might_like_results') ) {
                      echo zenpad_get_option('you_might_like_results');
                      } else {
                      echo 'You Might Like';
                      } 
                    ?>
                  </h4>
                  <div class="pull-right cb-toolbar">
                      <span><?php
                          if ( zenpad_get_option('share_results') ) {
                            echo zenpad_get_option('share_results');
                            } else {
                            echo 'Share';
                            } 
                        ?> </span>
                      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(full_url($_SERVER)) ?>" onclick="window.open(this.href,this.target,width=300,height=300); return false;"><img src="<?php echo get_template_directory_uri(); ?>/images/fb-ico-sm.png"/></a>
                      <a href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo urlencode(full_url($_SERVER)) ?>&amp;via=ASUS" class="poplink"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter-icon-sm.png"/></a>
                      <a href="mailto:?subject=<?php echo get_the_title(); ?>&amp;body=<?php echo urlencode(full_url($_SERVER)) ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/mail-icon-sm.png"/></a>
                      <script type="text/javascript">
                        $(document).ready(function(){
                          $('.poplink').on('click',function(){
                            newwindow=window.open($(this).attr('href'),'','height=300,width=700');
                            if (window.focus) {newwindow.focus()}
                            return false;
                          });
                        });
                      </script>
                  </div>
              </div>
              <div class="col-md-12 clearfix">
		<?php
    if(!empty($_GET)){
      $GET= array_values($_GET);
      $get_chunk = array_chunk($GET, 3);

      /* Primary */
      $args = array(
          'post_type' => 'product-selector',
          'posts_per_page' => -1
      );
      $query = new WP_Query($args);

      while ( $query->have_posts() ) : $query->the_post();
        $quest = unserialize(get_post_meta(get_the_ID(),'_quest',true));
        if($quest==array_values($get_chunk[0])){
          $selector_id= get_the_ID();
          break;
        }
      endwhile;

      /* Optional */
      if($get_chunk[1]){
        foreach ($get_chunk[1] as $key => $value) {
          $idObj= get_term_by('slug',$value,'product-categories');
          $optional_selected[$key] = $idObj->term_id;
        }
      }

      $args_product = array(
  		   'post_type'=>'product',
         'post_status' => array( 'publish' ),
         'posts_per_page' => -1
  	  );

      /* Query Product */
      $query = new WP_Query($args_product);
      $opt_primary_id = array();
      $opt_optional_id = array();
      while ( $query->have_posts() ) : $query->the_post();

        $ps = get_post_meta(get_the_ID(),'detailproduct_selector',true);
        if( is_array($ps) &&  in_array($selector_id, $ps) ){
          $opt_primary_id[]= get_the_ID();
        }

        if($optional_selected){
            $ops =  get_post_meta( get_the_ID(), 'detail_product_selector_optional', true );
            foreach ($optional_selected as $key => $op) {
              if( is_array($ops) && in_array($op, $ops) ){
                $opt_optional_id[$op][]= get_the_ID();
              }
            }
        }
  	    endwhile;
      }
      wp_reset_query();

      /* Checked Optional */
      $result_id = $opt_primary_id;
      if($opt_optional_id){
        foreach ($opt_optional_id as $key => $value) {
          if(!empty($result_id)){
            $result_id = array_intersect($result_id, $value);
          }else{
            $result_id = array_intersect($opt_primary_id, $value);
          }
        }
      }

      $result_query = new WP_Query( array(
                                  'post_type'       => 'product',
                                  'post__in'        => $result_id,
                                  'posts_per_page'  => -1
                                ));
              while ( $result_query->have_posts() ) : $result_query->the_post();
              $exclude = get_post_meta(get_the_ID(),'detailproduct_result',true);
              if( $exclude != 'yes' ) {
                ?>
                <div class="col-md-4 col-sm-4 cb-result">
                  <?php
                  if ( has_post_thumbnail() ) {
                    $image_id = get_post_thumbnail_id();
                    $image_url = wp_get_attachment_image_src($image_id,'full', true);
                    $img = $image_url[0];
                  }
                  ?>
                      <img src="<?php echo $img; ?>"/><br />
                  <?php
                    global $detail;
                    $detail->the_meta();
                  ?>
                        <a href="<?php $detail->the_value('product_url')?>" class="title"><?php the_title(); ?>
                        </a>
                        <span><?php $detail->the_value('short_description'); ?></span>
                        <a href="<?php $detail->the_value('buy_url'); ?>" class="btn btn-info">
                        <?php
                          if ( zenpad_get_option('buy_now_label') ) {
                            echo zenpad_get_option('buy_now_label');
                            } else {
                            echo 'Buy Now';
                            } 
                        ?>
                          </a>
                        <ul>
                            <li>
                                <b>Operating System</b>
                                <?php $detail->the_value('os'); ?>
                            </li>
                            <li><b>Display</b>
                                <?php $detail->the_value('screen_size'); ?>
                            </li>
                            <li><b>CPU</b>
                                <?php $detail->the_value('performance'); ?>
                            </li>
                            <li><b>Memory</b>
                                <?php $detail->the_value('ram'); ?>
                            </li>
                            <li><b>Storage</b>
                                <?php $detail->the_value('storage'); ?><br /><br />
                                <?php
                                if ( zenpad_get_option('end_of_articles_home') ) {
                                  echo zenpad_get_option('end_of_articles_home');
                                  } else {
                                  echo '5GB of ASUS WebStorage space for life; with an additional 11GB for the 1st year';
                                  } 
                                ?>
                            </li>
                            <li><b>Battery</b>
                                <?php $detail->the_value('battery'); ?>
                            </li>
                        </ul>
                    </div>
                <?php
              }
              endwhile;
              ?>

            </div>
        </div>

      </div>
      <!-- </form> -->
  </div>
</div>
<script type="text/javascript">

  $(document).ready(function(){

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
      $('.btn').css('display','');
  })

       $('.less-opt').click(function(){
      $('.more-opt-box').slideUp(100)
      $(this).hide()
      $('.more-opt').css("display","block");
      $('.btn').css('display','none');
  })

  $('.cb-radio label span').click(function(e){
    e.preventDefault();
    var name = $(this).parents('.cb-radio').find('input').attr('name');
    jQuery('input[name='+name+']:checked').prop('checked',false);
  })

  });
</script>

<?php get_footer()?>
