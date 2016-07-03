<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wpplug_demo
 */

/***
$mobile_detect = new Mobile_Detect();
$ismobile = $mobile_detect->isMobile();
if($ismobile) {
    get_header('mobile');
}
else {
    get_header();
}
 * */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif;

             tha_content_while_before();

			 // PAGING
             $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			 // ORDER
			 $default_order = 'DESC';
			 $order_query_param = (get_query_var('order')) ? get_query_var('order') : $default_order;
			 $order_query_param = $order_query_param == 'DESC' || $order_query_param == 'ASC' ? $order_query_param : $default_order;

             $args = array('post_type' => 'post',
                           'post_status' => 'publish',
                           'paged' => $paged,
	                       'posts_per_page' => 2,
                           'orderby' => 'post_date',
                           'order' => $order_query_param);

            $my_query = new WP_Query($args);




			/* Start the Loop */
		//	while ( have_posts() ) : the_post();

            if($my_query->have_posts()) : while ($my_query->have_posts() ) : $my_query->the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );


			endwhile;
            endif;

            tha_content_while_after();

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
