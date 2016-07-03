<?php
/**
 * wpplug_demo functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpplug_demo
 */

if ( ! function_exists( 'wpmarko_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wpmarko_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wpplug_demo, use a find and replace
	 * to change 'wpmarko' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wpmarko', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size(150,150);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wpmarko' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wpmarko_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'wpmarko_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpmarko_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wpmarko_content_width', 640 );
}
add_action( 'after_setup_theme', 'wpmarko_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpmarko_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wpmarko' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wpmarko' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpmarko_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wpmarko_scripts() {

    if(!is_admin()) {

        /**
         * BOOTSTRAP 3.3.6
         */
      // SCRIPTS
       wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap/js/bootstrap.min.js', array('jquery'), '3.3.6', true);

       // STYLES
       wp_enqueue_style('bootstrap', get_template_directory_uri() . '/js/bootstrap/css/bootstrap.min.css', array(), false);

    }


	wp_enqueue_style( 'wpmarko-style', get_stylesheet_uri() );

    // CUSTOM STYLE
    wp_enqueue_style('site_style', get_template_directory_uri() . '/site_style.css', array(), false);

    wp_enqueue_script( 'wpmarko-navigation', get_template_directory() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'wpmarko-skip-link-focus-fix', get_template_directory() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wpmarko_scripts' );


/**
 * Breadcrumbs
 * @since 2.0.0
 * @author Rachel Baker
 * @link https://github.com/rachelbaker/bootstrapwp-Twitter-Bootstrap-for-WordPress/blob/master/functions.php
 * Adds breadcrumbs and hooks them into tha_content_top if enabled.
 * Based on Rachel Baker's Twitter Bootstrap for WordPress theme
 */
if ( !function_exists( 'ap_core_breadcrumbs' ) ) {
    $options = get_option( 'ap_core_theme_options' );

    function ap_core_breadcrumbs() {
        global $post, $paged;

        // this sets up some breadcrumbs for posts & pages that support Twitter Bootstrap styles
        echo '<ul xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumb">';

        if ( !is_home() || !is_front_page() || !is_paged() ) {

            echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . esc_url( get_home_url() ) . '">' . __( 'Home', 'museum-core' ) . '</a></span></li>';

            if ( is_category() ) {
                $category = get_the_category();
                if ($category) {
                    foreach($category as $category) {
                        echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></span></li>';
                    }
                }
                echo '<li class="active"><span typeof="v:Breadcrumb">' . sprintf( __( 'Posts filed under <q>%s</q>', 'museum-core' ), single_cat_title( '', false ) ) . '</span></li>';
            } elseif ( is_day() ) {
                echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a></span></li>';
                echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '">' . get_the_time('F') . '</a></span></li>';
                echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_time('d') . '</span></li>';
            } elseif ( is_month() ) {
                echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a></span></li>';
                echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_time('F') . '</span></li>';
            } elseif ( is_year() ) {
                echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_time('Y') . '</span></li>';
            } elseif ( is_single() && !is_attachment() ) {
                if ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object( get_post_type() );
                    $slug = $post_type->rewrite;
                    echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . home_url() . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></span></li>';
                    echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_title() . '</span></li>';
                } else {
                    $category = get_the_category();
                    if ($category) {
                        foreach($category as $category) {
                            echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></span></li>';
                        }
                    }
                    echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_title() . '</span></li>';
                }
            } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                $post_type = get_post_type_object( get_post_type() );
                echo '<li class="active"><span typeof="v:Breadcrumb">' . $post_type->labels->singular_name . '</span></li>';
            } elseif ( is_attachment() ) {
                $parent = get_post( $post->post_parent );
                $category = get_the_category( $parent->ID );
                if ( $category ) {
                    foreach($category as $category) {
                        echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></span></li>';
                    }
                }
                echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_title() . '</span></li>';
            } elseif ( is_page() && !$post->post_parent ) {
                echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_title() . '</span></li>';
            } elseif ( is_page() && $post->post_parent ) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ( $parent_id ) {
                    $page = get_post($parent_id);
                    $breadcrumbs[] = '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . get_permalink($page->ID) . '">' . get_the_title( $page->ID ) . '</a></span></li>';
                }
                $breadcrumbs = array_reverse( $breadcrumbs );
                foreach ( $breadcrumbs as $crumb ) {
                    echo $crumb;
                }
                echo '<li class="active"><span typeof="v:Breadcrumb">' . get_the_title() . '</span></li>';
            } elseif ( is_search() ) {
                echo '<li class="active"><span typeof="v:Breadcrumb">' . sprintf( __( 'Search results for <q>%s</q>', 'museum-core' ), esc_attr( get_search_query() ) ) . '</span></li>';
            } elseif ( is_tag() ) {
                echo '<li class="active"><span typeof="v:Breadcrumb">' . sprintf( __( 'Posts tagged <q>%s</q>', 'museum-core' ), single_tag_title( '', false ) ) . '</span></li>';
            } elseif ( is_author() ) {
                global $author;
                echo '<li class="active"><span typeof="v:Breadcrumb">' . sprintf( __( 'All posts by %s', 'museum-core' ), get_the_author_meta('display_name',$author) ) . '</span></li>';
            } elseif ( is_404() ) {
                echo '<li class="active"><span typeof="v:Breadcrumb">' . __( 'Error 404', 'museum-core' ) . '</span></li>';
            }
        }
        if ( is_paged() ) {
            $front_page_ID = get_option( 'page_for_posts' );
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
                echo '&nbsp;<span class="active paged">(' . sprintf( __( 'Page %s', 'museum-core' ), esc_attr( $paged ) ) . ')</li>';
            } else {
                echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . esc_url( get_home_url() ) . '">' . __( 'Home', 'museum-core' ) . '</a></span></li>';
                echo '<li><span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="' . esc_url( get_home_url() ) . '/?p=' . $front_page_ID . '">' . __( 'Blog', 'museum-core' ) . '</a></span></li>';
                echo '<li class="active paged">' . sprintf( __( 'Page %s', 'museum-core' ), esc_attr( $paged ) ) . '</li>';
            }
        }

        echo '</ul>';

    }

    if ( isset( $options['breadcrumbs'] )  && ( true == $options['breadcrumbs'] ) ) :

        add_action( 'tha_content_top', 'ap_core_breadcrumbs' );

    endif;
}


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load THA Theme Hooks
 */
require get_template_directory() . '/inc/tha-theme-hooks.php';

/**
 * Load Mobile Detect
 */
require get_template_directory() . '/inc/Mobile_Detect.php';
