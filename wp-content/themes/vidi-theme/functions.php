<?php



// added Carbon Fields



require get_stylesheet_directory() . '/inc/carbon-fields/carbon-fields-plugin.php';



add_action('carbon_fields_register_fields', 'crb_register_custom_fields');

function crb_register_custom_fields(){

    require_once __DIR__.'/inc/post-meta.php';

	require_once __DIR__.'/inc/theme-options.php';

}





add_action ('wp_enqueue_scripts', 'vidi_scripts');

function vidi_scripts(){

    wp_deregister_script('jquery');

    wp_enqueue_script ('jquery', get_stylesheet_directory_uri() . '/libs/jquery.min.js', array(), null, true);

    wp_enqueue_script ('spin_scripts', get_stylesheet_directory_uri() . '/libs/jquery.spincrement.min.js', array('jquery'), null, true);

    wp_enqueue_script ('slick_scripts', get_stylesheet_directory_uri() . '/libs/slick.min.js', array('jquery'), null, true);

    wp_enqueue_script ('fancy_scripts', get_stylesheet_directory_uri() . '/libs/jquery.fancybox.min.js', array('jquery'), null, true);



    //wp_enqueue_script ('main_scripts', get_stylesheet_directory_uri() . '/js/main.min.js', array('jquery'), null, true);
    wp_enqueue_script ('main_scripts', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), null, true);

    wp_enqueue_style ('slick_styles', get_stylesheet_directory_uri() . '/libs/slick.css', array(), time());

    wp_enqueue_style ('fancy_styles', get_stylesheet_directory_uri() . '/libs/jquery.fancybox.min.css', array(), time());

    wp_enqueue_style ('wp_styles', get_stylesheet_directory_uri() . '/css/wp-styles.css', array(), time());

    wp_enqueue_style ('main_styles', get_stylesheet_directory_uri() . '/css/style.min.css', array(), time());

   

    };



add_action( 'admin_enqueue_scripts', function(){

        wp_enqueue_style( 'my_wp_admin', get_template_directory_uri() .'/css/wp-admin.css' );

      }, 99 );



add_action ('after_setup_theme', 'gut_styles');



function gut_styles(){

	add_theme_support('editor-styles');

	add_editor_style('css/style-gutenberg.css');

}

register_nav_menus(array(

        'head_menu' => 'Главное меню',

        'foot_menu' => 'Меню в футере'

));



add_theme_support('post-thumbnails');

add_filter( 'nav_menu_css_class', 'change_menu_item_css_classes', 10, 4 );



function change_menu_item_css_classes( $classes, $item, $args, $depth ) {

	if ( 'head_menu' === $args->theme_location ) {

		$classes = [ 'menu__item' ];

	} 

    

    if ('foot_menu' === $args->theme_location){

        $classes = ['footer__menu-item'];

    }



	return $classes;

}



add_filter( 'nav_menu_link_attributes', 'my_nav_link_filter', 10, 4 );

function my_nav_link_filter( $atts, $item, $args){


   if( $args->theme_location == ('head_menu') ){

     $atts['class'] = 'menu__link';

   }



   if( $args->theme_location == ('foot_menu') ){

    $atts['class'] = 'footer__menu-link';

  }

  return $atts;

}





function my_customize_register( $wp_customize ) {

    $wp_customize->add_setting('header_logo', array(

        'default' => '',
		'height' => '48',
		'width' => '118',
        'sanitize_callback' => 'absint',

    ));



    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_logo', array(

        'section' => 'title_tagline',
        'label' => 'Логотип Header'

    )));

    $wp_customize->add_setting('footer_logo', array(

        'default' => '',

        'sanitize_callback' => 'absint',

    ));



    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'footer_logo', array(

        'section' => 'title_tagline',

        'label' => 'Логотип Footer'

    )));



}

add_action( 'customize_register', 'my_customize_register' );



add_filter( 'excerpt_length', function(){

	return 5;

} );

add_filter( 'excerpt_more', function( $more ) {

	return '...';

} );







function true_breadcrumbs(){

	$page_num = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

 

	$separator = ' / ';


	if( is_front_page() ){

 

		if( $page_num > 1 ) {

			echo '<a href="' . site_url() . '">Main page</a>' . $separator . $page_num . '-я страница';

		} else {

			echo 'Main page';

		}

 

	} else { 

 

		echo '<a href="' . site_url() . '">Main page</a>' . $separator;

 

 

		if( is_single() ){ 
 

			the_category( ', ' ); echo $separator; the_title();

 

		} elseif ( is_page() ){ 

 

			the_title();

 

		} elseif ( is_category() ) {

 

			single_cat_title();

 

		} elseif( is_tag() ) {

 

			single_tag_title();

 

		} elseif ( is_day() ) { 

 

			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $separator;

			echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a>' . $separator;

			echo get_the_time('d');

 

		} elseif ( is_month() ) { 

 

			echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $separator;

			echo get_the_time('F');

 

		} elseif ( is_year() ) { 

 

			echo get_the_time( 'Y' );

 

		} elseif ( is_author() ) { 

 

			global $author;

			$userdata = get_userdata( $author );

			echo 'Опубликовал(а) ' . $userdata->display_name;

 

		} elseif ( is_404() ) { 

 

			echo 'Ошибка 404';

 

		}

 

		if ( $page_num > 1 ) { 

			echo ' (' . $page_num . 'page)';

		}

 

	}

 

}



function custom_pagination() {

    global $wp_query;

	$max = $wp_query->max_num_pages;  

    $pages = paginate_links( array(

   

    'type' => 'array',

    'prev_next' => TRUE,

    'prev_text' => '<svg width="41" height="8" viewBox="0 0 41 8" fill="none" xmlns="http://www.w3.org/2000/svg">

    //         <path d="M0.646446 3.64644C0.451183 3.84171 0.451183 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.73079 4.34027 7.73079 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82842L1.70711 4L4.53553 1.17157C4.7308 0.976308 4.7308 0.659725 4.53553 0.464463C4.34027 0.269201 4.02369 0.269201 3.82843 0.464463L0.646446 3.64644ZM41 3.5L1 3.5L1 4.5L41 4.5L41 3.5Z" fill="#18223D"/>

    //         </svg>',

    'next_text' => '<svg width="41" height="8" viewBox="0 0 41 8" fill="none" xmlns="http://www.w3.org/2000/svg">

    //         <path d="M40.3536 3.64644C40.5488 3.84171 40.5488 4.15829 40.3536 4.35355L37.1716 7.53553C36.9763 7.73079 36.6597 7.73079 36.4645 7.53553C36.2692 7.34027 36.2692 7.02369 36.4645 6.82842L39.2929 4L36.4645 1.17157C36.2692 0.976308 36.2692 0.659725 36.4645 0.464463C36.6597 0.269201 36.9763 0.269201 37.1716 0.464463L40.3536 3.64644ZM-4.37114e-08 3.5L40 3.5L40 4.5L4.37114e-08 4.5L-4.37114e-08 3.5Z" fill="#18223D"/>

    //         </svg>',

    ) );

	

    if( is_array( $pages ) ) {

    $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');

    echo '<ul class="pagination__list"';

    foreach ( $pages as $page ) {

    echo '<li class="pagination__item">' . $page . '</li>';

    }

    echo '</ul>';

    }

    }



function disable_visual_editor($can)

{

    global $post;

    $page_template = get_post_meta($post->ID, '_wp_page_template', true);

    if ($page_template == 'front-page.php') {

        return false;

    }

    return $can;

}

add_filter('user_can_richedit', 'disable_visual_editor');





add_action('admin_head', 'custom_colors');

function custom_colors() {

	echo '<style type="text/css">

	#wphead{background:#069;}

	</style>';

}





add_action( 'init', 'register_post_types' );



function register_post_types(){



	register_post_type( 'portfolio', [

		'label'  => '',

		'labels' => [

			'name'               => 'Portfolio',

			'singular_name'      => 'Проект', 

			'add_new'            => 'Добавить проект', 
			'add_new_item'       => 'Добавить проект', 
			'edit_item'          => 'Редактирование проекта', 
			'new_item'           => 'Новый',

			'view_item'          => 'Смотреть проект', 
			'search_items'       => 'Искать проект', 
			'not_found'          => 'Не найдено', 

			'not_found_in_trash' => 'Не найдено в корзине', 
			'parent_item_colon'  => '', 
			'menu_name'          => 'Portfolio', 
		],

		'description'            => '',

		'public'                 => true,

		'show_in_menu'           => null,

		'show_in_rest'        => true, 

		'rest_base'           => null, 

		'menu_position'       => null,

		'menu_icon'           => 'dashicons-format-video',

		'hierarchical'        => false,

		'supports'            => [ 'title', 'editor', 'thumbnail' ], 
		'taxonomies'          => [],

		'has_archive'         => true,

		'rewrite'             => true,

		'query_var'           => true,

	] );



}

add_action( 'login_head', 'my_custom_login_logo' );
function my_custom_login_logo(){

	echo '
	<style type="text/css">
	h1 a {  background-image:url('.get_bloginfo('template_directory').'/images/logo.svg) !important;
	  }
	.login h1 a{background-size:contain !important; width:150px !important; height: 90px !important; margin: 10px auto;}
	</style>
	';
}

?>