<?php
/**
 * The theme footer
 */
		if ( zenpad_get_option( 'additional_footer_check' ) ) {
			if ( zenpad_get_option( 'additional_footer_text' ) ) {
				echo zenpad_get_option( 'additional_footer_text' );
			}
		}

		if ( ! zenpad_get_option( 'asusapikey' ) ) { ?>
			<footer>
					<div class="container">
							<div class="row">
									<div class="col-md-3 col-sm-3 col-xs-6">
											<h4>Want More?</h4>
											<ul class="footer-links">
													<li>
															<a href="">
															Product Guide
															</a>
													</li>
													<li>
															<a href="">ROG
															</a>
													</li>
													<li>
															<a href="">SonicMaster
															</a>
													</li>
													<li>
															<a href="">ZENBOOK
															</a>
													</li>
													<li>
															<a href="">Asus Design Center</a>
													</li>
											</ul>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6">
											<h4>Who We Are</h4>
											<ul class="footer-links">
													<li>
															<a href="">Awards
															</a>
													</li>
													<li>
															<a href="">News
															</a>
													</li>
													<li>
															<a href="">About ASUS
															</a>
													</li>
													<li>
															<a href="">Investor Relations
															</a>
													</li>
													<li>
															<a href="">Legal information
															</a>
													</li>
													<li>
															<a href="">Employment
															</a>
													</li>
													<li>
															<a href="">About CSR
															</a>
													</li>
													<li>
															<a href="">Press Room
															</a>
													</li>
											</ul>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6">
											<h4>Need Help?</h4>
											<ul class="footer-links">
													<li>
															<a href="">Contact Us
															</a>
													</li>
													<li>
															<a href="">Product Registration
															</a>
													</li>
													<li>
															<a href="">Service Center
															</a>
													</li>
													<li>
															<a href="">Driver Download
															</a>
													</li>
													<li>
															<a href="">Repair Status Inquiry
															</a>
													</li>
													<li>
															<a href="">Warranty Status Inquiry
															</a>
													</li>
													<li>
															<a href="">Monday to Friday from 9:00 to 18:00
															</a>
													</li>
											</ul>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-6">
											<h4>Community</h4>
											<ul class="follow">
													<li>
															<a href=""><img src="<?php echo get_template_directory_uri(); ?>/images/youtube-ico.png" /></a>
													</li>
													<li>
															<a href=""><img src="<?php echo get_template_directory_uri(); ?>/images/fb-ico.png" /></a>
													</li>
											</ul>
									</div>
							</div>
							<div class="row copyright">
									<div class="pull-left"><img src="<?php echo get_template_directory_uri(); ?>/images/globe-ico.png" /> Singapore / English</div>
									<div class="pull-right">
											<a href="">Terms of Use Notice</a>
											<a href="">Privacy Policy</a> <?php echo zenpad_get_option('footer'); ?>
									</div>
							</div>
					</div>
			</footer>
		<?php } ?>
		<!--wordpress footer-->
		<?php wp_footer(); ?>
	</body>
</html>