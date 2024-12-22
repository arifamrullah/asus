<?php
/**
 * The theme header
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php wp_title('|', true, 'right'); ?></title>
		<meta name="viewport" content="width=device-width">

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic,700,700italic,900,300italic' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,700italic,400italic,300,300italic' rel='stylesheet' type='text/css'>
		<!--wordpress head-->
		<?php wp_head(); ?>
		<?php
		if ( is_admin_bar_showing() ) {
		   echo'
		    <style type="text/css" media="screen">
          html{ margin-top:0!important;}
					#page-top.admin-bar{padding-top: 15px;}
					.admin-bar .navbar{padding-top: 32px;}
		    </style>
		    ';
		}
		?>
	<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top" <?php body_class(); ?>>
  <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NJRLM8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NJRLM8');</script>
<!-- End Google Tag Manager -->
		<!--[if lt IE 8]>
			<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		<?php
		if(!zenpad_get_option('asusapikey')){
			?>
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
					<div class="container">
							<div class="navbar-header page-scroll">
								<div class="mob-login">
                    <ul class="pull-right">
                      <li>
                          <a href="">LOGIN</a>
                      </li>
                      <li class="compare">
                        <a href="javascript:;" id="openCompareMob"><img src="<?php echo get_template_directory_uri(); ?>/images/grid-icon.png"/></a>
                        <div class="compare-box" >
                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                              <li class="active"><a href="#compareid" aria-controls="compareid" role="tab" data-toggle="tab">Recently Viewed </a></li>
                              <li ><a href="#reviewid" aria-controls="reviewid" role="tab" data-toggle="tab">Compare List</a></li>
                          </ul>
                          <!-- Tab panes -->
                          <div class="tab-content">
                              <div role="tabpanel" class="tab-pane clearfix active" id="compareid">
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                                  <div class="box-product">
                                      <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                  </div>
                              </div>
                              <div role="tabpanel" class="tab-pane" id="reviewid">
                              </div>
                            </div>
                        </div>
                      </li>
                      <li class="search">
                          <a href="javascript:;" id="openSearchMob"><img src="<?php echo get_template_directory_uri(); ?>/images/search-icon.png"/></a>
                          <div class="search-box" >
                              <input type="text"/>
                              <button type="submit"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-search.png"/></button>
                          </div>
                      </li>
                    </ul>
                  </div>
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									</button>
									<a class="navbar-brand page-scroll" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
									<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png"/>
									</a>
							</div>
							<div class="mob-menu">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              </div>
              <span class="menu-text">Menu</span>
							<div class="collapse navbar-collapse navbar-ex1-collapse">

									<ul class="pull-right">
											<li>
													<a href="">LOGIN</a>
											</li>
											<li class="compare">
													<a href="javascript:;" id="openCompare"><img src="<?php echo get_template_directory_uri(); ?>/images/grid-icon.png"/></a>
													<div class="compare-box">
														<!-- Nav tabs -->
														<ul class="nav nav-tabs" role="tablist">
															<li class="active">
																<a href="#compareid" aria-controls="compareid" role="tab" data-toggle="tab">Recently Viewed</a>
															</li>
															<li>
																<a href="reviewid" aria-controls="reviewid" role="tab" data-toggle="tab">Compare List</a>
															</li>
														</ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane clearfix active" id="compareid">
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                    <div class="box-product">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" />
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="reviewid"></div>
                            </div>
													</div>
											</li>
											<li class="search">
													<a href="javascript:;" id="openSearch"><img src="<?php echo get_template_directory_uri(); ?>/images/search-icon.png"/></a>
													<div class="search-box">
															<input type="text"/>
															<button type="submit"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-search.png"></button>
													</div>
											</li>
									</ul>

									<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav', 'walker' => new BootstrapBasicMyWalkerNavMenu())); ?>

							</div>
					</div>
			</nav>
			<?php
		}
		?>
	
