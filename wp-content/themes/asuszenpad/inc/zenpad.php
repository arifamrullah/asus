<?php
/* Custom Post Type
-------------------*/
add_action( 'init', 'product_posttype' );
function product_posttype() {
	$labels = array(
		'name'                => _x( 'Products', 'asuszenpad' ),
		'singular_name'       => _x( 'Product', 'asuszenpad' ),
		'menu_name'           => __( 'Products', 'asuszenpad' ),
		'parent_item_colon'   => __( 'Parent Product', 'asuszenpad' ),
		'all_items'           => __( 'All Products', 'asuszenpad' ),
		'view_item'           => __( 'View Product', 'asuszenpad' ),
		'add_new_item'        => __( 'Add New Product', 'asuszenpad' ),
		'add_new'             => __( 'Add New', 'asuszenpad' ),
		'edit_item'           => __( 'Edit Product', 'asuszenpad' ),
		'update_item'         => __( 'Update Product', 'asuszenpad' ),
		'search_items'        => __( 'Search Product', 'asuszenpad' ),
		'not_found'           => __( 'Not Found', 'asuszenpad' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'asuszenpad' ),
	);

	$args = array(
		'label'               => __( 'Products', 'asuszenpad' ),
		'description'         => __( 'Asus ZenPad Products', 'asuszenpad' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-cart',
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
  register_post_type( 'product', $args );
}

add_action( 'init', 'selector_posttype' );
function selector_posttype() {
	$labels = array(
		'name'                => _x( 'Product Selector', 'asuszenpad' ),
		'singular_name'       => _x( 'Product Selector', 'asuszenpad' ),
		'menu_name'           => __( 'Product Selector', 'asuszenpad' ),
		'parent_item_colon'   => __( 'Parent Product Selector', 'asuszenpad' ),
		'all_items'           => __( 'All Product Selector', 'asuszenpad' ),
		'view_item'           => __( 'View Product Selector', 'asuszenpad' ),
		'add_new_item'        => __( 'Add New Product Selector', 'asuszenpad' ),
		'add_new'             => __( 'Add New', 'asuszenpad' ),
		'edit_item'           => __( 'Edit Product Selector', 'asuszenpad' ),
		'update_item'         => __( 'Update Product Selector', 'asuszenpad' ),
		'search_items'        => __( 'Search Product Selector', 'asuszenpad' ),
		'not_found'           => __( 'Not Found', 'asuszenpad' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'asuszenpad' ),
	);

	$args = array(
		'label'               => __( 'Product Selector', 'asuszenpad' ),
		'description'         => __( 'Asus ZenPad Product Selector', 'asuszenpad' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-feedback',
		'menu_position'       => 6,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
  register_post_type( 'product-selector', $args );
}

add_action( 'init', 'locator_posttype' );
function locator_posttype() {
	$labels = array(
		'name'                => _x( 'Locations', 'asuszenpad' ),
		'singular_name'       => _x( 'Location', 'asuszenpad' ),
		'menu_name'           => __( 'Store Locator', 'asuszenpad' ),
		'parent_item_colon'   => __( 'Parent Location', 'asuszenpad' ),
		'all_items'           => __( 'All Locations', 'asuszenpad' ),
		'view_item'           => __( 'View Location', 'asuszenpad' ),
		'add_new_item'        => __( 'Add New Location', 'asuszenpad' ),
		'add_new'             => __( 'Add New', 'asuszenpad' ),
		'edit_item'           => __( 'Edit Location', 'asuszenpad' ),
		'update_item'         => __( 'Update Location', 'asuszenpad' ),
		'search_items'        => __( 'Search Location', 'asuszenpad' ),
		'not_found'           => __( 'Not Found', 'asuszenpad' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'asuszenpad' ),
	);

	$args = array(
		'label'               => __( 'Locations', 'asuszenpad' ),
		'description'         => __( 'Asus ZenPad Store Locations', 'asuszenpad' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-store',
		'menu_position'       => 7,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
  register_post_type( 'store-locator', $args );
}

add_action( 'init', 'socialfeed_posttype' );
function socialfeed_posttype() {
	$labels = array(
		'name'                => _x( 'Social Feeds', 'asuszenpad' ),
		'singular_name'       => _x( 'Social Feed', 'asuszenpad' ),
		'menu_name'           => __( 'Social Feed', 'asuszenpad' ),
		'parent_item_colon'   => __( 'Parent Location', 'asuszenpad' ),
		'all_items'           => __( 'All Feed', 'asuszenpad' ),
		'view_item'           => __( 'View Feed', 'asuszenpad' ),
		'add_new_item'        => __( 'Add New Feed', 'asuszenpad' ),
		'add_new'             => __( 'Add New', 'asuszenpad' ),
		'edit_item'           => __( 'Edit Feed', 'asuszenpad' ),
		'update_item'         => __( 'Update Feed', 'asuszenpad' ),
		'search_items'        => __( 'Search Feed', 'asuszenpad' ),
		'not_found'           => __( 'Not Found', 'asuszenpad' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'asuszenpad' ),
	);

	$args = array(
		'label'               => __( 'Feeds', 'asuszenpad' ),
		'description'         => __( 'Asus ZenPad Social Feeds', 'asuszenpad' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-share',
		'menu_position'       => 8,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
  register_post_type( 'social-feed', $args );
}

/* Custom Title Placeholder
---------------------------*/
function product_name_placeholder( $title ){
	$screen = get_current_screen();
	if  ( 'product' == $screen->post_type ) {
		$title = 'Enter Product Name';
	}
	return $title;
}
add_filter( 'enter_title_here', 'product_name_placeholder' );

function store_name_placeholder( $title ){
     $screen = get_current_screen();
     if  ( 'store-locator' == $screen->post_type ) {
          $title = 'Enter Store Name';
     }
     return $title;
}
add_filter( 'enter_title_here', 'store_name_placeholder' );

/* Post Type Columns
--------------------*/
add_filter( 'manage_product_posts_columns', 'product_cpt_columns' );
function product_cpt_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Product Name' ),
		'product_list' => __( 'Product List' ),
		'short_description' => __( 'Short Description' ),
		'featured_image' => __( 'Featured Image' ),
		'date' => __( 'Date' )
	);
	return $columns;
}

add_filter( 'manage_store-locator_posts_columns', 'locator_cpt_columns' );
function locator_cpt_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Store Name' ),
		'map_address' => __( 'Address' ),
		'status' => __( 'Status' ),
		'date' => __( 'Date' )
	);
	return $columns;
}

add_filter( 'manage_social-feed_posts_columns', 'social_feed_cpt_columns' );
function social_feed_cpt_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'description' => __( 'Description' ),
		'featured_image' => __( 'Featured Image' ),
		'date' => __( 'Date' )
	);
	return $columns;
}

/* Post Type Custom Column
--------------------------*/
add_action( 'manage_product_posts_custom_column' , 'custom_product_column', 10, 2 );
function custom_product_column( $column, $post_id ) {
	switch( $column ) {
		case 'product_list' :
			$pl = get_post_meta( $post_id, 'detailproduct_list', true );
			if ( $pl ) {
				echo "Showed";
			} else {
				echo "-";
			}
			break;
		case 'short_description' :
			$sd = get_post_meta( $post_id, 'detailshort_description', true );
			if ( $sd ) {
				echo wp_trim_words( $sd, 10, ' ...' );
			} else {
				echo "-";
			}
			break;
		case 'featured_image' :
			$img_id = get_post_thumbnail_id( $post_id );
			$img = wp_get_attachment_url( $img_id );
			if ( $img ) {
				echo '<img src="'.$img.'" style="width:auto;max-height:50px;" />';
			} else {
				echo 'No Image';
			}
			break;
		default :
			break;
	}
}

add_action( 'manage_store-locator_posts_custom_column' , 'custom_locator_column', 10, 2 );
function custom_locator_column( $column, $post_id ) {
	switch( $column ) {
		case 'map_address' :
			$sd = get_post_meta( $post_id, 'locatormap_address', true );
			echo $sd;
			break;
		case 'status' :
			$sn = get_post_meta( $post_id, 'locatorstatus', true );
			echo $sn;
			break;
		default :
			break;
	}
}

add_action( 'manage_social-feed_posts_custom_column' , 'custom_social_feed_column', 10, 2 );
function custom_social_feed_column( $column, $post_id ) {
	switch( $column ) {
		case 'description' :
			$args = array(
				'p' => $post_id,
				'post_type'	=> 'social-feed'
			);
			$query = new WP_Query($args);
			$query->the_post();
			$desc = $query->post->post_content;
			if ( $desc ) {
				echo wp_trim_words( $desc, 10, ' ...' );
			} else {
				echo "-";
			}
			break;
		case 'featured_image' :
			$img_id = get_post_thumbnail_id( $post_id );
			$img = wp_get_attachment_url( $img_id );
			if ( $img ) {
				echo '<img src="'.$img.'" style="width:auto;max-height:100px;" />';
			} else {
				echo 'No Image';
			}
			break;
		default :
			break;
	}
}

add_action ( 'edit_category_form_fields', 'extra_category_fields' );
function extra_category_fields( $tag ) {
    $t_id = $tag->term_id;
    $cat_meta = get_option( "category_$t_id");
?>

<tr class="form-field">
	<th scope="row" valign="top">
		<label for="icon"><?php _e('Icon'); ?></label>
	</th>
	<td>
		<?php echo $cat_meta['icon'] ? '<img src="'.$cat_meta['icon'].'" />' : ''; ?>
		<input type="text" name="Cat_meta[icon]" id="icon" value="<?php echo $cat_meta['icon'] ? $cat_meta['icon'] : ''; ?>" />
		<input type="button" class="button" id="upload-button-icon" value="Upload/Add image" />
		<input type="button" class="button" id="remove-button-icon" value="Remove image" />
	</td>
</tr>
<tr class="form-field">
	<th scope="row" valign="top">
		<label for="icon_hover"><?php _e('Icon Hover'); ?></label>
	</th>
	<td>
		<?php echo $cat_meta['icon_hover'] ? '<img src="'.$cat_meta['icon_hover'].'" />' : ''; ?>
		<input type="text" name="Cat_meta[icon_hover]" id="icon-hover" value="<?php echo $cat_meta['icon_hover'] ? $cat_meta['icon_hover'] : ''; ?>" />
		<input type="button" class="button" id="upload-button-icon-hover" value="Upload/Add image" />
		<input type="button" class="button" id="remove-button-icon-hover" value="Remove image" />
	</td>
</tr>

<script type="text/javascript">
jQuery(document).ready(function($){

  var mediaUploader;

  $('#upload-button-icon').click(function(e) {
    e.preventDefault();
    if (mediaUploader) {
		  mediaUploader.open();
		  return;
    }

    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });

    mediaUploader.on('select', function() {
      attachment = mediaUploader.state().get('selection').first().toJSON();
      $('#icon').val(attachment.url);
    });

    mediaUploader.open();
  });

  $('#remove-button-icon').click(function() {
  	$('#icon').val('');
  })

  var mediaUploader2;

  $('#upload-button-icon-hover').click(function(e) {
    e.preventDefault();
    if (mediaUploader2) {
		  mediaUploader2.open();
		  return;
    }

    mediaUploader2 = wp.media.frames.file_frame = wp.media({
      title: 'Choose Image',
      button: {
      text: 'Choose Image'
    }, multiple: false });

    mediaUploader2.on('select', function() {
      attachment = mediaUploader2.state().get('selection').first().toJSON();
      $('#icon-hover').val(attachment.url);
    });

    mediaUploader2.open();
  });

  $('#remove-button-icon-hover').click(function() {
  	$('#icon-hover').val('');
  })

});
</script>
<?php
}

add_action ( 'edited_category', 'save_extra_category_fileds' );
function save_extra_category_fileds( $term_id ) {
  if ( isset( $_POST['Cat_meta'] ) ) {
    $t_id = $term_id;
    $cat_meta = get_option( "category_$t_id" );
    $cat_keys = array_keys( $_POST['Cat_meta'] );
    foreach ( $cat_keys as $key ) {
      if ( isset( $_POST['Cat_meta'][$key] ) ) {
        $cat_meta[$key] = $_POST['Cat_meta'][$key];
      }
  	}
    update_option( "category_$t_id", $cat_meta );
  }
}

add_action( 'init', 'asuszenpad_posttype' );
function asuszenpad_posttype() {
  register_taxonomy(
      'product-categories',
      'product',
      array(
          'labels' => array(
              'name' => 'Categories',
              'add_new_item' => 'Add New',
              'new_item_name' => "New Categories"
          ),
          'show_ui' => true,
          'show_tagcloud' => false,
          'hierarchical' => true,
          'query_var' => true,
          'rewrite' => array( 'slug' => 'product-categories', 'with_front' => false )
      )
  );
  register_taxonomy(
      'social-feed-categories',
      'social-feed',
      array(
          'labels' => array(
              'name' => 'Categories',
              'add_new_item' => 'Add New',
              'new_item_name' => "New Categories"
          ),
          'show_ui' => true,
          'show_tagcloud' => false,
          'hierarchical' => true,
          'query_var' => true,
          'rewrite' => array( 'slug' => 'social-feed-categories', 'with_front' => false )
      )
  );
}

/* Background image for top banner
----------------------------------*/
function bg_image_meta_box() {
	add_meta_box( 'bg_image', __( 'Background Image', 'asuszenpad' ), 'bg_image_meta_box_callback', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'bg_image_meta_box' );

function bg_image_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_bg_image_value', true );

	echo ( ( $value ) ? '<img style="max-width:100%;" src="'.$value.'" />' : "" );
	echo '<input type="text" name="bg_image" id="bg-img" value="'.( ( $value ) ? $value : "" ).'" style="width:100%;" />';
	echo '<input type="button" class="button" id="upload-button-bg-img" value="Upload/Add image" />';
	echo '&nbsp';
	echo '<input type="button" class="button" id="remove-button-bg-img" value="Remove image" />'; ?>

	<script type="text/javascript">
		jQuery(document).ready(function($){

		  var mediaUploaderBg;

		  $('#upload-button-bg-img').click(function(e) {
		    e.preventDefault();
		    if (mediaUploaderBg) {
				  mediaUploaderBg.open();
				  return;
		    }

		    mediaUploaderBg = wp.media.frames.file_frame = wp.media({
		      title: 'Choose Image',
		      button: {
		      text: 'Choose Image'
		    }, multiple: false });

		    mediaUploaderBg.on('select', function() {
		      attachment = mediaUploaderBg.state().get('selection').first().toJSON();
		      $('#bg-img').val(attachment.url);
		    });

		    mediaUploaderBg.open();
		  });

		  $('#remove-button-bg-img').click(function() {
		  	$('#bg-img').val('');
		  });

		});
	</script>

	<?php
}

function bg_image_save( $post_id ) {
	if ( !empty( $_POST['bg_image'] ) ) {
		$data = sanitize_text_field( $_POST['bg_image'] );
	}
	update_post_meta( $post_id, '_bg_image_value', $data );
}
add_action( 'save_post', 'bg_image_save' );

/* Post type for posts
----------------------*/
function filter_type_meta_box() {
	add_meta_box( 'filter_type', __( 'Post Type', 'asuszenpad' ), 'filter_type_meta_box_callback', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'filter_type_meta_box' );

function filter_type_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_filter_type_value', true );

	echo '<select name="filter_type" style="width:100%;">';
	echo '<option value=""></option>';
	$post_type_group = zenpad_get_option('post_type_group');
	foreach ($post_type_group as $ptg) {
		echo '<option value="'.$ptg['title'].'" '.( ( $ptg['title'] == $value ) ? "selected":"").'>'.$ptg['title'].'</option>';
	}
	echo '</select>';
}

function filter_type_save( $post_id ) {
	if ( !empty( $_POST['filter_type'] ) ) {
		$data = sanitize_text_field( $_POST['filter_type'] );
	}
	update_post_meta( $post_id, '_filter_type_value', $data );
}
add_action( 'save_post', 'filter_type_save' );

/* External URL for "External Post" Post Type
---------------------------------------------*/
function ex_url_meta_box() {
	add_meta_box( 'ex_url', __( 'External URL', 'asuszenpad' ), 'ex_url_meta_box_callback', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'ex_url_meta_box' );

function ex_url_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_ex_url_value', true );
	echo '<input type="text" name="ex_url" value="'.( ( $value ) ? $value : '' ).'" style="width:100%;" />';
}

function ex_url_save( $post_id ) {
	if ( !empty( $_POST['ex_url'] ) ) {
		$data = sanitize_text_field( $_POST['ex_url'] );
	}
	update_post_meta( $post_id, '_ex_url_value', $data );
}
add_action( 'save_post', 'ex_url_save' );

/* Related product for posts
----------------------------*/
function related_product_meta_box() {
	add_meta_box( 'related_product', __( 'Featured Products on Side-Bar', 'asuszenpad' ), 'related_product_meta_box_callback', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'related_product_meta_box' );

function related_product_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_related_product_value', true );

	if ( empty( $value ) ) {
		$value = array();
	}

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'orderby' => 'title',
		// 'order' => 'asc'
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$checked = "";
			if ( in_array( get_the_ID(), $value ) ) {
				$checked = 'checked="checked"';
			}
			echo '<div style="width:30%;display:inline-block">';
			echo '<input type="checkbox" name="related_product[]" value="'.get_the_ID().'" '.$checked.'/>';
			echo get_the_title();
			echo '</div>';
		}
	}
}

function related_product_save( $post_id ) {
	if ( !empty( $_POST['related_product'] ) ) {
		foreach ( $_POST['related_product'] as $rel ) {
			$data[] = sanitize_text_field( $rel );
		}
	}
	update_post_meta( $post_id, '_related_product_value', $data );
}
add_action( 'save_post', 'related_product_save' );

/* Post Filter for Posts
------------------------*/
function post_filter_meta_box() {
	add_meta_box( 'post_filter', __( 'Product Tag', 'asuszenpad' ), 'post_filter_meta_box_callback', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'post_filter_meta_box' );

function post_filter_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_post_filter_value', true );

	if ( empty( $value ) ) {
		$value = array();
	}

	$post_filters = zenpad_get_option( 'filter_group' );
	foreach ( $post_filters as $post_filter ) {
		$checked = "";
		if ( in_array( $post_filter['hashtag'], $value ) ) {
			$checked = 'checked="checked"';
		}
		echo '<div style="width:30%;display:inline-block">';
		echo '<input type="checkbox" name="post_filter[]" value="' . $post_filter['hashtag'] . '" '.$checked.'/>';
		echo $post_filter['hashtag'];
		echo '</div>';
	}
}

function post_filter_save( $post_id ) {
	if ( !empty( $_POST['post_filter'] ) ) {
		foreach ( $_POST['post_filter'] as $pf ) {
			$data[] = sanitize_text_field( $pf );
		}
	}
	update_post_meta( $post_id, '_post_filter_value', $data );
}
add_action( 'save_post', 'post_filter_save' );

/* Grid type (col-md-3 and col-md-6)
------------------------------------*/
function grid_type_meta_box() {
	add_meta_box( 'grid_type', __( 'Grid Type', 'asuszenpad' ), 'grid_type_meta_box_callback', 'post', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'grid_type_meta_box' );

function grid_type_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_grid_type_value', true );

	echo '<select name="grid_type" style="width:100%;">';
	echo '<option value="1" '.($value == 1 ? 'selected' : '').'>1 Grid</option>';
	echo '<option value="2" '.($value == 2 ? 'selected' : '').'>2 Grids</option>';
	echo '<option value="4" '.($value == 4 ? 'selected' : '').'>4 Grids</option>';
	echo '</select>';
}

function grid_type_save( $post_id ) {
	if ( !empty( $_POST['grid_type'] ) ) {
		$data = sanitize_text_field( $_POST['grid_type'] );
	}
	update_post_meta( $post_id, '_grid_type_value', $data );
}
add_action( 'save_post', 'grid_type_save' );

/* Custom author name
---------------------*/
add_filter( 'the_author', 'custom_author_name' );
add_filter( 'get_the_author_display_name', 'custom_author_name' );
function custom_author_name( $name ) {
  global $post;
  $author = get_post_meta( $post->ID, '_custom_author_value', true );
  if ( $author )
    $name = $author;
  return $name;
}

function custom_author_meta_box() {
	add_meta_box( 'custom_author', __( 'Author', 'asuszenpad' ), 'custom_author_meta_box_callback', 'post', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'custom_author_meta_box' );

function custom_author_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_custom_author_value', true );
	$author_id = $post->post_author;
	echo '<input type="text" name="custom_author" value="'.( ( $value ) ? $value : get_the_author_meta( 'user_nicename', $author_id ) ).'" style="width:100%" />';
}

function custom_author_save( $post_id ) {
	if ( !empty( $_POST['custom_author'] ) ) {
		$data = sanitize_text_field( $_POST['custom_author'] );
	}
	update_post_meta( $post_id, '_custom_author_value', $data );
}
add_action( 'save_post', 'custom_author_save' );

/* Product categories for product selector
------------------------------------------*/
function product_cat_meta_box() {
	add_meta_box( 'product_cat', __( 'Categories', 'asuszenpad' ), 'product_cat_meta_box_callback', 'product-selector', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'product_cat_meta_box' );

function get_allcats( $tree1 ) {
	global $post;
	$ptgs = get_post_meta ( $post->ID, '_quest', true);
	$quest = unserialize($ptgs);
	if ( empty( $quest ) ) {
		$quest = array();
	}
	$trees2 = get_terms( 'product-categories', array( 'parent' => $tree1->term_id, 'hide_empty' => 0 ));
	if ( !empty( $trees2 ) ):
		foreach( $trees2 as $tree2_k => $tree2 ): ?>
			<h2>
				<?php echo $tree2->name; ?>
			</h2>
      <?php $trees3 = get_terms( 'product-categories', array( 'parent' => $tree2->term_id, 'hide_empty' => 0 ));
      	if( !empty( $trees3 ) ):
      		foreach( $trees3 as $tree3_k => $tree3 ): ?>
      			<?php
      				$checked = "";
      				if ( in_array( $tree3->slug, $quest ) ) {
      					$checked = 'checked="checked"';
      				}
      			?>
						<input type="radio" id="id-<?php echo $tree3->slug ?>" <?php echo $checked ?> name="quest[<?php echo $tree2->slug ?>]" value="<?php echo $tree3->slug ?>"/>
            <label for="id-<?php echo $tree3->slug ?>"><span></span><?php echo $tree3->name ?></label><br />
          <?php endforeach;
        endif;
    endforeach;
  endif;
}

function product_cat_meta_box_callback( $post ) {
	wp_nonce_field( 'product_cat_save', 'product_cat_nonce' );

	$value = get_post_meta( $post->ID, '_product_cat_value', true );

	$trees1 = get_terms( 'product-categories', array( 'parent' => 0, 'hide_empty' => 0 ) );
	if ( !empty( $trees1 ) ) {
		foreach ( $trees1 as $tree1 ) {
			get_allcats( $tree1 );
		}
	}
}

function product_cat_save( $post_id ) {
	if ( !empty( $_POST['quest'] ) ) {
		foreach( $_POST['quest'] as $q ) {
			$data[] = sanitize_text_field( $q );
		}
		update_post_meta( $post_id, '_quest', serialize( $data ) );
	}
}
add_action( 'save_post', 'product_cat_save' );

/* Social Media URL
-------------------*/
function url_meta_box() {
	add_meta_box( 'url', __( 'URL', 'asuszenpad' ), 'url_meta_box_callback', 'social-feed', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'url_meta_box' );

function url_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_url_value', true );
	echo '<input type="text" name="url" value="'.( ( $value ) ? $value : '' ).'" style="width:100%" />';
}

function url_save( $post_id ) {
	if ( !empty( $_POST['url'] ) ) {
		$data = sanitize_text_field( $_POST['url'] );
	}
	update_post_meta( $post_id, '_url_value', $data );
}
add_action( 'save_post', 'url_save' );

/* Social Media Username
------------------------*/
function username() {
	add_meta_box( 'username', __( 'Username', 'asuszenpad' ), 'username_callback', 'social-feed', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'username' );

function username_callback( $post ) {
	$value = get_post_meta( $post->ID, '_username_value', true );
	echo '<input type="text" name="username" value="'.( ( $value ) ? $value : '' ).'" style="width:100%" />';
}

function username_save( $post_id ) {
	if ( !empty( $_POST['username'] ) ) {
		$data = sanitize_text_field( $_POST['username'] );
	}
	update_post_meta( $post_id, '_username_value', $data );
}
add_action( 'save_post', 'username_save' );

/* Social Media Userphoto
-------------------------*/
function userphoto() {
	add_meta_box( 'userphoto', __( 'User Picture', 'asuszenpad' ), 'userphoto_callback', 'social-feed', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'userphoto' );

function userphoto_callback( $post ) {
	$value = get_post_meta( $post->ID, '_userphoto_value', true );
	echo '<input type="text" name="userphoto" value="'.( ( $value ) ? $value : '' ).'" style="width:100%" />';
}

function userphoto_save( $post_id ) {
	if ( !empty( $_POST['userphoto'] ) ) {
		$data = sanitize_text_field( $_POST['userphoto'] );
	}
	update_post_meta( $post_id, '_userphoto_value', $data );
}
add_action( 'save_post', 'userphoto_save' );

/* Revolution Slider Shortcode
------------------------------*/
function rev_shortcode() {
	global $post;
	$slug = basename( get_permalink( $post->ID ) );
	if ( $slug == 'zenpad' ) {
		add_meta_box( 'rev_sc', __( 'Revolution Slider Shortcode', 'asuszenpad' ), 'rev_shortcode_callback', 'page', 'side', 'high' );
	}
}
add_action( 'add_meta_boxes', 'rev_shortcode' );

function rev_shortcode_callback( $post ) {
	$value = get_post_meta( $post->ID, '_rev_sc_value', true );
	echo '<input type="text" name="rev_sc" value="'.( ( $value ) ? str_replace( "\"", '\'', $value ) : '' ).'" style="width:100%" />';
	echo '<p class="howto">Place the shortcode from Revolution Slider</p>';
}

function rev_sc_save( $post_id ) {
	if ( !empty( $_POST['rev_sc'] ) ) {
		$data = sanitize_text_field( $_POST['rev_sc'] );
	}
	update_post_meta( $post_id, '_rev_sc_value', $data );
}
add_action( 'save_post', 'rev_sc_save' );

/* Zenpad Settings
------------------*/
class Zenpad_Admin {

	public $key = 'zenpad-settings';
	protected $general_metabox = array();
	// protected $passion_metabox = array();
	protected $product_metabox = array();
	protected $post_type_metabox = array();
	protected $filter_metabox = array();
	protected $label_metabox = array();
	protected $title = '';
	protected $options_page = '';

	public function __construct() {
		$this->title = __( 'Zenpad Settings', 'settings' );
		$this->general = array(
			array(
				'name'			=> __( 'Asus Appkey', 'asusapi' ),
				'id'			=> 'asusapikey',
				'description'	=> __( 'To initialize api which may include the ASUS Web Member bar, Top Menu and Footer.', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Country Code', 'cmb' ),
				'id'			=> 'country_code',
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Facebook URL', 'facebook' ),
				'id'			=> 'facebook',
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Twitter URL', 'twitter' ),
				'id'			=> 'twitter',
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Instagram URL', 'instagram' ),
				'id'			=> 'instagram',
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Youtube URL', 'youtube' ),
				'id'			=> 'youtube',
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Email', 'email' ),
				'id'			=> 'email',
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Footer', 'cmb' ),
				'id'			=> 'footer',
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Default Image for Asus ZenPad', 'cmb' ),
				'id'			=> 'img_default',
				'type'			=> 'file',
			),
			array(
				'name'			=> __( 'Enable Additional Footer Text', 'cmb' ),
				'id'			=> 'additional_footer_check',
				'type'			=> 'checkbox',
			),
			array(
				'name'			=> __( 'Additional Text for Footer', 'cmb' ),
				'id'			=> 'additional_footer_text',
				'type'			=> 'wysiwyg',
			),
		);
		$this->custom_css = array(
			array(
				'name' => 'Custom CSS',
				'id'   => 'custom_css',
				'type' => 'textarea_code',
			)
		);
		$this->custom_js = array(
			array(
				'name' => 'Custom JS',
				'id'   => 'custom_js',
				'type' => 'textarea_code',
			)
		);
		// $this->passion = array(
		// 	array(
		// 		'id'          => 'repeat_group',
		// 		'type'        => 'group',
		// 		// 'description' => __( 'Generates reusable form entries', 'cmb' ),
		// 		'options'     => array(
		// 			'group_title'   => __( 'Passion Point {#}', 'cmb' ),
		// 			'add_button'    => __( 'Add Another Passion Point', 'cmb' ),
		// 			'remove_button' => __( 'Remove Passion Point', 'cmb' ),
		// 			'sortable'      => true, // beta
		// 		),
		// 		'fields'      => array(
		// 			array(
		// 				'name' => 'Hero Image',
		// 				'id'   => 'hero_img',
		// 				'type' => 'file',
		// 				// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		// 			),
		// 		),
		// 	),
		// );
		$this->product = array(
			array(
				'name'			=> __( 'Operating System', 'cmb' ),
				'id'			=> 'os',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Memory', 'cmb' ),
				'id'			=> 'ram',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Storage', 'cmb' ),
				'id'			=> 'storage',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Screen Size', 'cmb' ),
				'id'			=> 'screen-size',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Connectivity', 'cmb' ),
				'id'			=> 'connectivity',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Customization', 'cmb' ),
				'id'			=> 'customization',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Performance', 'cmb' ),
				'id'			=> 'performance',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Content Consumption', 'cmb' ),
				'id'			=> 'content-consumption',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Mobility', 'cmb' ),
				'id'			=> 'mobility',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Battery', 'cmb' ),
				'id'			=> 'battery',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Weight', 'cmb' ),
				'id'			=> 'weight',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Dimensions', 'cmb' ),
				'id'			=> 'dimensions',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> __( 'Colour', 'cmb' ),
				'id'			=> 'colour',
				'description'	=> __( 'Separate values with commas and spaces', 'cmb' ),
				'type'			=> 'text',
			),
		);
		$this->post_type = array(
			array(
				'id'		=> 'post_type_group',
				'type'		=> 'group',
				'option'	=> array(
					'group_title'		=> __( 'Post Type {#}', 'cmb' ),
					'add_button'		=> __( 'Add Another Post Type', 'cmb' ),
					'sortable'			=> true,
				),
				'fields'	=> array(
					array(
						'name'	=> 'Title',
						'id'	=> 'title',
						'type'	=> 'text',
					),
					array(
						'name'	=> 'Description',
						'id'	=> 'description',
						'type'	=> 'text',
					),
					array(
						'name'			=> 'Image Banner',
						'id'			=> 'img_banner',
						'description'	=>	__( 'If image banner is not set, image will set to default image', 'cmb' ),
						'type'			=> 'file',
					),
				),
			),
		);
		$this->filter = array(
			array(
				'id'		=> 'filter_group',
				'type'		=> 'group',
				'option'	=> array(
					'group_title'		=> __( 'Filter {#}', 'cmb' ),
					'add_button'		=> __( 'Add Another Filter', 'cmb' ),
					'sortable'			=> true,
				),
				'fields'	=> array(
					array(
						'name'	=> 'Hashtag',
						'id'	=> 'hashtag',
						'type'	=> 'text',
					),
					array(
						'name'	=> 'Description',
						'id'	=> 'description',
						'type'	=> 'textarea',
					),
					array(
						'name'			=> 'Image Uploader',
						'id'			=> 'img_uploader',
						// 'description'	=>	__( 'If image banner is not set, image will set to default image', 'cmb' ),
						'type'			=> 'file',
					),
				),
			),
		);
		$this->label = array(
			array(
				'name'			=>	'Product Selector Label',
				'id'			=>	'selector_label',
				'description'	=>	__( 'Default Value: Find the right ASUS ZenPad for you', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Product List Label',
				'id'			=>	'list_label',
				'description'	=>	__( 'Default Value: Featured ASUS ZenPad products', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'More Filter Label',
				'id'			=>	'filter_label',
				'description'	=>	__( 'Default Value: More Filter Option', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Search Label',
				'id'			=>	'search_label',
				'description'	=>	__( 'Default Value: What are you looking for today?', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Filter Type Label',
				'id'			=>	'ftype_label',
				'description'	=>	__( 'Default Value: Filter Type', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Sort by Label',
				'id'			=>	'sort_label',
				'description'	=>	__( 'Default Value: Sort by', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Most Recent Label',
				'id'			=>	'recent_label',
				'description'	=>	__( 'Default Value: Most Recent', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Most Popular Label',
				'id'			=>	'popular_label',
				'description'	=>	__( 'Default Value: Most Popular', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Load More Label',
				'id'			=>	'load_label',
				'description'	=>	__( 'Default Value: Load More', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Social Media Title Label',
				'id'			=>	'social_label',
				'description'	=>	__( 'Default Value: Social Media', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Description Label',
				'id'			=>	'social_desc_label',
				'description'	=>	__( 'Default Value: What everyone is saying about us', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Hashtag Label',
				'id'			=>	'social_hash_label',
				'description'	=>	__( 'Default Value: #OnYourTerms', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Back Label',
				'id'			=>	'back_label',
				'description'	=>	__( 'Default Value: Back', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Product Details Label',
				'id'			=>	'product_details_label',
				'description'	=>	__( 'Default Value: Product Details', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Buy Now Label',
				'id'			=>	'buy_now_label',
				'description'	=>	__( 'Default Value: Buy Now', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'View and Compare All Tablets Label',
				'id'			=>	'view_compare_tablets',
				'description'	=>	__( 'Default Value: View and Compare All Tablets', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Authored By Label - Single Page',
				'id'			=>	'authored_by_label_single',
				'description'	=>	__( 'Default Value: Authored By', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Tags Label - Single Page',
				'id'			=>	'tags_label_single',
				'description'	=>	__( 'Default Value: Tags Label', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Category Label - Single Page',
				'id'			=>	'category_label_single',
				'description'	=>	__( 'Default Value: Category', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Featured Products Label - Single Page',
				'id'			=>	'featured_products_label_single',
				'description'	=>	__( 'Default Value: Featured Products', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Next Related Article Label - Single Page',
				'id'			=>	'next_related_label_single',
				'description'	=>	__( 'Default Value: Next Related Article', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Other Related Article Label - Single Page',
				'id'			=>	'other_related_label_single',
				'description'	=>	__( 'Default Value: Other Related Article', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'End of Articles - Home Page',
				'id'			=>	'end_of_articles_home',
				'description'	=>	__( 'Default Value: End of Articles', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Small Text - Product Page',
				'id'			=>	'small_text_product',
				'description'	=>	__( 'Default Value: Find the right', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Large Text - Product Page',
				'id'			=>	'large_text_product',
				'description'	=>	__( 'Default Value: ZENPAD FOR YOU', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Narrow it down more - Product Page',
				'id'			=>	'narrow_it_product',
				'description'	=>	__( 'Default Value: Narrow it down more', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Less Options - Product Page',
				'id'			=>	'less_options_product',
				'description'	=>	__( 'Default Value: Less Options', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'View My Zenpad - Product Page',
				'id'			=>	'view_my_zenpad_product',
				'description'	=>	__( 'Default Value: View My Zenpad', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'View All - Product Page',
				'id'			=>	'view_all_product',
				'description'	=>	__( 'Default Value: View All', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Specify Again - Product Page',
				'id'			=>	'specify_again_product',
				'description'	=>	__( 'Default Value: Specify Again', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'View All - Product Page',
				'id'			=>	'view_all_product',
				'description'	=>	__( 'Default Value: View All', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Your Preferences - Product Results',
				'id'			=>	'your_preferences_product_results',
				'description'	=>	__( 'Default Value: Your Preferences', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'You Might Like - Product Results',
				'id'			=>	'you_might_like_results',
				'description'	=>	__( 'Default Value: You Might Like', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Share Label - Product Results',
				'id'			=>	'share_results',
				'description'	=>	__( 'Default Value: Share', 'cmb' ),
				'type'			=>	'text',
			),
			array(
				'name'			=>	'Webstorage Label - Product Results',
				'id'			=>	'webstorage_results',
				'description'	=>	__( 'Default Value: 5GB of ASUS WebStorage space for life; with an additional 11GB for the 1st year', 'cmb' ),
				'type'			=>	'text',
			),

		);
	}

	public function hooks() {
			add_action( 'admin_init', array( $this, 'init' ) );
			add_action( 'admin_menu', array( $this, 'add_options_page' ) );
	}

	public function init() {
			register_setting( $this->key, $this->key );
	}

	public function add_options_page() {
			$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
	}

	public function admin_page_display() {
			?>
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<div class="wrap cmb_options_page <?php echo $this->key; ?>">
					<h2 class="nav-tab-wrapper">
						<a href="<?php echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=general" class="nav-tab <?php echo ($_GET['tab']=="general" || $_GET['tab']=="" ) ? "nav-tab-active" : "" ?>">General</a>
						<!-- <a href="<?php //echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=passion-points" class="nav-tab <?php// echo ($_GET['tab']=="passion-points") ? "nav-tab-active" : "" ?>">Passion Points</a> -->
						<a href="<?php echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=product" class="nav-tab <?php echo ($_GET['tab']=="product") ? "nav-tab-active" : "" ?>">Product</a>
						<a href="<?php echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=post-type" class="nav-tab <?php echo ($_GET['tab']=="post-type") ? "nav-tab-active" : "" ?>">Post Type</a>
						<a href="<?php echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=filter" class="nav-tab <?php echo ($_GET['tab']=="filter") ? "nav-tab-active" : "" ?>">Filter</a>
						<a href="<?php echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=label" class="nav-tab <?php echo ($_GET['tab']=="label") ? "nav-tab-active" : "" ?>">Label Settings</a>
						<a href="<?php echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=custom-css" class="nav-tab <?php echo ($_GET['tab']=="custom-css") ? "nav-tab-active" : "" ?>">Custom CSS</a>
						<a href="<?php echo admin_url() ?>/admin.php?page=zenpad-settings&amp;tab=custom-js" class="nav-tab <?php echo ($_GET['tab']=="custom-js") ? "nav-tab-active" : "" ?>">Custom JS</a>
					</h2>
					<div class="options-container">
						<?php if ($_GET['tab']=="social-media") { ?>
							<div id="social-media">
								<?php cmb_metabox_form( $this->socmed_metabox(), $this->key ); ?>
							</div>
						<?php //} else if ($_GET['tab']=="passion-points") { ?>
							<!-- <div id="passion-points">
								<?php// cmb_metabox_form( $this->passion_metabox(), $this->key ); ?>
							</div> -->
						<?php } else if ($_GET['tab']=="product") { ?>
							<div id="product">
								<?php cmb_metabox_form( $this->product_metabox(), $this->key ); ?>
							</div>
						<?php } else if ($_GET['tab']=="post-type") { ?>
							<div id="post-type">
								<?php cmb_metabox_form( $this->post_type_metabox(), $this->key ); ?>
							</div>
						<?php } else if ($_GET['tab']=="filter") { ?>
							<div id="filter">
								<?php cmb_metabox_form( $this->filter_metabox(), $this->key ); ?>
							</div>
						<?php } else if ($_GET['tab']=="label") { ?>
							<div id="label">
								<?php cmb_metabox_form( $this->label_metabox(), $this->key ); ?>
							</div>
						<?php } else if ($_GET['tab']=="custom-css") { ?>
							<div id="custom-css">
								<?php cmb_metabox_form( $this->custom_css_metabox(), $this->key ); ?>
							</div>
						<?php } else if ($_GET['tab']=="custom-js") { ?>
							<div id="custom-js">
								<?php cmb_metabox_form( $this->custom_js_metabox(), $this->key ); ?>
							</div>
						<?php } else { ?>
							<div id="general">
								<?php cmb_metabox_form( $this->general_metabox(), $this->key ); ?>
							</div>
						<?php } ?>
					</div>
			</div>
			<?php
	}

	public function general_metabox() {
			return array(
					'id'         => 'general_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->general,
			);
	}

	public function custom_css_metabox() {
			return array(
					'id'         => 'social_css_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->custom_css,
			);
	}

	public function custom_js_metabox() {
			return array(
					'id'         => 'js_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->custom_js,
			);
	}

	public function socmed_metabox() {
			return array(
					'id'         => 'socmed_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->socmed,
			);
	}

	// public function passion_metabox() {
	// 		return array(
	// 				'id'         => 'passion_metabox',
	// 				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
	// 				'show_names' => true,
	// 				'fields'     => $this->passion,
	// 		);
	// }

	public function product_metabox() {
			return array(
					'id'         => 'product_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->product,
			);
	}

	public function post_type_metabox() {
			return array(
					'id'         => 'post_type_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->post_type,
			);
	}

	public function filter_metabox() {
			return array(
					'id'         => 'filter_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->filter,
			);
	}

	public function label_metabox() {
			return array(
					'id'         => 'label_metabox',
					'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
					'show_names' => true,
					'fields'     => $this->label,
			);
	}

	public function get_general( $general ) {

			if ( in_array( $general, array( 'key', 'general', 'title', 'options_page' ), true ) ) {
					return $this->{$general};
			}
			if ( 'general_metabox' === $general ) {
					return $this->general_metabox();
			}

			throw new Exception( 'Invalid property: ' . $general );
	}

	public function get_socmed( $socmed ) {

			if ( in_array( $socmed, array( 'key', 'socmed', 'title', 'options_page' ), true ) ) {
					return $this->{$socmed};
			}
			if ( 'socmed_metabox' === $socmed ) {
					return $this->socmed_metabox();
			}

			throw new Exception( 'Invalid property: ' . $socmed );
	}

	// public function get_passion( $passion ) {

	// 		if ( in_array( $passion, array( 'key', 'passion', 'title', 'options_page' ), true ) ) {
	// 				return $this->{$passion};
	// 		}
	// 		if ( 'passion_metabox' === $passion ) {
	// 				return $this->passion_metabox();
	// 		}

	// 		throw new Exception( 'Invalid property: ' . $passion );
	// }

	public function get_product( $product ) {

			if ( in_array( $product, array( 'key', 'product', 'title', 'options_page' ), true ) ) {
					return $this->{$product};
			}
			if ( 'product_metabox' === $product ) {
					return $this->product_metabox();
			}

			throw new Exception( 'Invalid property: ' . $product );
	}

	public function get_post_type( $post_type ) {

			if ( in_array( $post_type, array( 'key', 'post_type', 'title', 'options_page' ), true ) ) {
					return $this->{$post_type};
			}
			if ( 'post_type_metabox' === $post_type ) {
					return $this->post_type_metabox();
			}

			throw new Exception( 'Invalid property: ' . $post_type );
	}

	public function get_filter( $filter ) {

			if ( in_array( $filter, array( 'key', 'filter', 'title', 'options_page' ), true ) ) {
					return $this->{$filter};
			}
			if ( 'filter_metabox' === $filter ) {
					return $this->filter_metabox();
			}

			throw new Exception( 'Invalid property: ' . $post_type );
	}

	public function get_label( $label ) {

			if ( in_array( $label, array( 'key', 'label', 'title', 'options_page' ), true ) ) {
					return $this->{$label};
			}
			if ( 'label_metabox' === $label ) {
					return $this->label_metabox();
			}

			throw new Exception( 'Invalid property: ' . $label );
	}

}

$Zenpad_Admin = new Zenpad_Admin();
$Zenpad_Admin->hooks();

function zenpad_get_option( $key = '' ) {
    global $Zenpad_Admin;
    return cmb_get_option( $Zenpad_Admin->key, $key );
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
function cmb_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'cmb/init.php';
}

include_once 'wpalchemy/MetaBox.php';
include_once 'wpalchemy/MediaAccess.php';
add_action( 'init', 'metabox_styles' );
function metabox_styles() {
	if ( is_admin() ) {
		wp_enqueue_style( 'wpalchemy-metabox', get_stylesheet_directory_uri() . '/css/meta.css' );
	}
}

/* Metabox Product Detail
-----------------------*/
$wpalchemy_media_access = new WPAlchemy_MediaAccess();

$detail = new WPAlchemy_MetaBox(array
(
  'id' => 'detail',
  'title' => 'Product Detail',
  'types' => array('product'),
  'context' => 'normal',
  'priority' => 'high',
  'template' => TEMPLATEPATH . '/inc/product-detail.php',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'autosave' => false,
	'prefix' => 'detail'
));

/* Metabox Store Locator
----------------------*/
$locator = new WPAlchemy_MetaBox(array
(
  'id' => 'locator',
  'title' => 'Store Locator',
  'types' => array('store-locator'),
  'context' => 'normal',
  'priority' => 'high',
  'template' => TEMPLATEPATH . '/inc/store-locator.php',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'autosave' => false,
	'prefix' => 'locator'
));

/* Facebook Meta
----------------*/
add_action( 'wp_head', 'meta_fb' );
function meta_fb() {
	global $post;
	$meta = "";
	if ( is_single() ) {
		$url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
		$content_post = get_post( $post->ID );
		$content = $content_post->post_content;
		$content = apply_filters( 'the_content', $content );
		$content = strip_tags( $content );

		$meta .= '<meta property="og:url" content="'.get_the_permalink().'">';
		$meta .= '<meta property="og:title" content="'.get_the_title().'">';
		$meta .= '<meta property="og:image" content="'.$url.'">';
		$meta .= '<meta property="og:description" content="'.$content.'">';
	}
	echo $meta;
}

/* Hook Header API
------------------*/
add_action( 'wp_head', 'hook_appkey' );
function hook_appkey() {
	if ( zenpad_get_option( 'country_code' ) ) {
		$lang = zenpad_get_option( 'country_code' );
	} elseif ( function_exists( 'mlp_get_current_blog_language' ) ) {
		$lang = explode( '_', mlp_get_current_blog_language() );
		$lang = $lang[1];
		if ( empty( $lang[1] ) ) {
			$lang = $lang[0];
		}
	} else {
		$lang = '';
	}
	if ( zenpad_get_option( 'asusapikey' ) ) {
		global $blog_id;
		if ( $blog_id != 1 ) {
			$langs = ', lang: "'.strtolower( $lang ).'"';
		}
		$output='
		<style>#menu-top {padding-top: 0px;} .admin-bar{margin-top: 30px;}#page-top.admin-bar.head-asus{padding-top: 0;}#page-top.head-asus .dropdown-product{top: 94px;}#section-selector{margin-top:0;}</style>
		<script type="text/javascript">
			window.ASUSInit = function () {
				asus_api.init({ appkey: "'.zenpad_get_option('asusapikey').'"'.$langs.' });
			};
			(function(d){
				var js, id = "asus-jsapi";
				if (d.getElementById("asus-jsapi")) {return;}
				js = d.createElement("script");
				js.id = id;
				js.async = true;
				js.src = "//www.asus.com/API/js/asus_api.js";
				d.getElementsByTagName("head")[0].appendChild(js);
			}(document));
		</script>
		';
		echo $output;
	}
}

add_filter( 'body_class', 'asus_class' );
function asus_class( $classes ) {
	$classes[] = '';
	if ( zenpad_get_option( 'asusapikey' ) ) {
		$classes[] = 'head-asus';
	}
	return $classes;
}

/* Hook css custom
------------------*/
add_action('wp_head', 'hook_css');
function hook_css() {
	$output = "";
	if ( zenpad_get_option( 'custom_css' ) ) {
      $output .= '<style>'.zenpad_get_option( "custom_css" ).'</style>';
	}
	echo $output;
}

/* Hook js custom
-----------------*/
add_action('wp_footer', 'hook_js');
function hook_js() {
	$output = "";
	if ( zenpad_get_option( 'custom_js' ) ) {
      $output .= '<script type="text/javascript">'.zenpad_get_option("custom_js").'</script>';
	}
	echo $output;
}

/* Resizing Image
-----------------*/
function img_resize( $image, $w, $h ) {
	//TODO STILL NEED TO BE FIX IN MULTISITE
	$image = str_replace( get_site_url(), ABSPATH, $image );
	$image = wp_get_image_editor( $image ); // Return an implementation that extends WP_Image_Editor
	if ( ! is_wp_error( $image ) ) {
	    $name = basename( $image->generate_filename( $w.'x'.$h ) );
	    $folder = 'wp-content/uploads/resize/'.$name;
	    if ( ! file_exists( ABSPATH.$folder ) ) {
	      $image->resize( $w, $h, true );
	      $image->save( ABSPATH.'wp-content/uploads/resize/'.$name );
	    }
	    return get_site_url().'/'.$folder;
	}
}

function url_origin($s, $use_forwarded_host=false) {
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}
function full_url($s, $use_forwarded_host=false) {
    return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}

/* MANSONRY
************/
add_action('wp_ajax_nopriv_loop_handler_mansonry', 'loop_handler_mansonry');
add_action('wp_ajax_loop_handler_mansonry', 'loop_handler_mansonry');

function loop_handler_mansonry() {
	session_start();
	// global $wp_query;
	// wp_reset_query();
	$manso_id = array();

	$numPosts = ( isset( $_POST['numPosts'] ) ) ? $_POST['numPosts'] : 0;
	$page = ( isset( $_POST['pageNumber'] ) ) ? $_POST['pageNumber'] : 0;
	$catName = ( isset( $_POST['category'] ) ) ? $_POST['category'] : 0;
	$loadMore = ( isset( $_POST['load'] ) ) ? 1 : 0;

	query_posts( array(
		'posts_per_page' => -1,
		'post_status' => array( 'publish' ),
		'post_type' => array( 'post' )
	));

	while ( have_posts() ) : the_post();
		$grids = get_post_meta( get_the_ID(), '_grid_type_value', true );
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

		if ( $total_num <= 36 ) {
			$num_posts = $gridCount;
		}
	endwhile;
	wp_reset_query();

	$args = array(
		// 'post__in' => get_option( 'sticky_post' ),
		'posts_per_page' => $numPosts,
		'paged' => $page,
		'post_status' => array( 'publish' ),
		'post_type' => array( 'post' ),
		// 'ignore_sticky_post' => 1
	);

	if ( ( $catName == "all" ) || ( $_POST['selector'] == "*" ) ) {
		$args['posts_per_page'] = $num_posts;
	}

	// Filter by category_name
	if ( ( $catName ) != "all" || ( $catName ) != 0 ) {
		$args['category_name'] = $catName;
		unset($_SESSION['mans_id']);
	}

	// Filter by search input
	if ( ( $_POST['search'] ) != "" ) {
		$args['s'] = $_POST['search'];
		unset( $_SESSION['mans_id'] );
	}

	// Filter selector
	if ( ( $_POST['selector'] ) != "" ) {
		$selector = $_POST['selector'];
		if ( $selector != "*" ) {
			// $selector = str_replace( '*,', '', $selector );
			// $selector = explode( ',', $selector );
			// $count = count( $selector );
			// for ( $i = 0; $i < $count; $i++ ) {
				$meta_query[] = array(
					'key' => '_post_filter_value',
					'value' => $selector,
					'compare' => 'LIKE'
			  );
			// }
			$args['meta_query'] = $meta_query;
		}
		unset( $_SESSION['mans_id'] );
	}

	// Filter recent
	if ( ( $_POST['sort_pop'] ) == "recent" ) {
		$args['orderby'] = 'date';
		$args['order'] = 'asc';
		unset( $_SESSION['mans_id'] );
	}

	// Filter popular
	if ( ( $_POST['sort_pop'] ) == "popular" ) {
		$args['orderby'] = 'comment_count';
		$args['order'] = 'desc';
		unset( $_SESSION['mans_id'] );
	}

	if ( $loadMore > 0 ) {
		$args['post__not_in'] = $_SESSION['mans_id'];
		$args['posts_per_page'] = $numPosts;
	}

	$query = new WP_Query( $args );
	ob_clean();
	$html = "";
	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
		$ptgArray = get_post_meta( get_the_ID(), '_filter_type_value', true );
		$ptgGrid = get_post_meta( get_the_ID(), '_grid_type_value', true );
		$exURL = get_post_meta( get_the_ID(), '_ex_url_value', true );
		$ptgString = 'col-md-3';
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
		if ( $ptgArray == 'Videos' ) {
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

		$html .= '<a href="'.$href.'" '.$blank.' title="'.get_the_title().'" class="'.$ptgString.' noPad grid-list news-img box" '.$df.'>
			<div class="caption">
        <h2>'.wp_trim_words( get_the_title(), 10, ' ...' ).'</h2>
      </div>
			<div class="thumb">';
				if ( has_post_thumbnail() ) {
					$url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
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

				if ( $loadMore == 0 ) {
					$manso_id[] = get_the_ID();
				}

				if ( $ptgArray == 'Videos' ) {
					$html .= '<span class="play-btn"><img src="'.get_template_directory_uri().'/images/play-button.png"></span> ';
				}

				$html .= '<img src="'.$url.'" />
			</div>
		</a>';
	endwhile;
	endif;

	if ( $loadMore == 0  ){
		$_SESSION['mans_id'] = $manso_id;
	}
	wp_reset_query();
	echo $html;
	die();
}

add_action('wp_ajax_nopriv_div_filter_result', 'div_filter_result');
add_action('wp_ajax_div_filter_result', 'div_filter_result');

function div_filter_result() {
	if ( ( $_POST['hashtag'] ) != "" ) {
		$hashtag = $_POST['hashtag'];
	}
	$html = "";
	$post_filters = zenpad_get_option( 'filter_group' );
	foreach ( $post_filters as $post_filter ) {
		if ( $post_filter['hashtag'] == $hashtag ) {
			$html .= '<div class="filter-result container">
		    <div class="result-left">
		    	<div class="img-uploader">
			      <style type="text/css">
			        .img-uploader {
			          background: url('.$post_filter["img_uploader"].') 50% center no-repeat;
			        }
			      </style>
		    	</div>
		    </div>
		    <div class="result-right">
		      <h2>'.$post_filter["hashtag"].'</h2>
		      <p>'.$post_filter["description"].'</p>
		      <div class="more">
		      	<p>Discover more on the '.$post_filter["hashtag"].'</p>
		      	<a href="#main" class="glyphicon glyphicon-menu-down jumper"></a>
		      </div>
		    </div>
		  </div>';
		}
	}
	echo $html;
	die();
}

/* First time load */
global $firstload;
if ( !isset( $_COOKIE['firsttime_load'] ) ){
	setcookie( "firsttime_load", "no", time() + 3600 );
	$firstload = 'y';
} else {
	$firstload = 'n';
}

/* Social Media Filter
----------------------*/
add_action( 'wp_ajax_filter_social_feed', 'filter_social_feed' );
add_action( 'wp_ajax_nopriv_filter_social_feed', 'filter_social_feed' );
function filter_social_feed() {
	ob_clean();
	$filter = ( isset( $_REQUEST['data'] ) ) ? $_REQUEST['data'] : '';
	if ( $filter['type'] == 'facebook' ) {
		$args = array(
			'post_type' => array( 'social-feed' ),
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'social-feed-categories',
					'field' => 'slug',
					'terms' => 'facebook'
				)
			)
		);
	} elseif ( $filter['type'] == 'twitter' ) {
		$args = array(
			'post_type' => array( 'social-feed' ),
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'social-feed-categories',
					'field' => 'slug',
					'terms' => 'twitter'
				)
			)
		);
	} elseif ( $filter['type'] == 'instagram' ) {
		$args = array(
			'post_type' => array( 'social-feed' ),
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'social-feed-categories',
					'field' => 'slug',
					'terms' => 'instagram'
				)
			)
		);
	} elseif ( $filter['type'] == 'all' ) {
		$args = array(
			'post_type' => array( 'social-feed' ),
			'post_status' => 'publish',
			'posts_per_page' => -1
		);
	}

	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		$content = '<ul class="bxslider" data-featherlight-gallery data-featherlight-filter="li">';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$terms = get_the_terms( $the_query->ID, 'social-feed-categories' );
			$background = "";
			$class_li = "li-noimage";
			if ( has_post_thumbnail() ) {
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src( $image_id, array( 432, 432 ), true);
				$background = "background-image: url(".$image_url[0].");";
				$class_li = "li-slide";
			}

			$link = get_post_meta( get_the_ID(), '_url_value', true );
			if ( empty( $link ) ) {
				$link = 'javascript:void(0)';
			}

			$content .= '<li href="'.get_template_directory_uri().'/inc/featherlight-social.php?id='.get_the_ID().'" class="'.$class_li.'" style="'.$background.'">
					<div class="social-item">';
						$content .= '<div class="social-entry">'.get_the_content().'</div>';
					$content .= '<a href="'.$link.'" target="_blank" class="social-external-link"></a>';
				$content .= '</div>';

				if ( $terms[0]->slug == 'facebook' ) {
					$class = "social-fb";
				} elseif ( $terms[0]->slug == 'twitter' ) {
					$class = "social-twitter";
				} elseif ( $terms[0]->slug == 'instagram' ) {
					$class = "social-insta";
				}

				$content .= '<span class="'.$class.'"></span>';
			$content .= '</li>';
		}
		$content .= '</ul><nav></nav>';
	} else {
		$content = "";
	}
	wp_reset_query();
	ob_clean();
	echo $content;
	die();
}

add_image_size( 'related-product', 194, 280 );

add_filter( 'revslider_slider_pack_export', 'revslider_slider_pack_export_custom', 10, 3);

function revslider_slider_pack_export_custom() {
	return true;
}

add_action('admin_head', 'custom_css');
function custom_css() {
	echo '<style type="text/css">
		.inline.hide-if-no-js {
			display: none;
		}
		#custom_css.cmb_textarea_code,
		#custom_js.cmb_textarea_code {
			min-height: 400px;
		}
	</style>';
}

?>
