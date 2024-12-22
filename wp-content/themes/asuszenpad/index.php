<?php get_header();?>

<section>
	<div class="container">
		<br /><br /><br /><br />
		<div class="col-md-12">

		<?php if ( have_posts() ) {
			while ( have_posts() ) {
			the_post();  ?>
			<h2><?php the_title() ?></h2>
			<?php the_content() ?>
		<?php } } ?>
		</div>
		<div class="clear"></div>

		<br /><br /><br />
	</div>
</section>

<?php get_footer(); ?> 
