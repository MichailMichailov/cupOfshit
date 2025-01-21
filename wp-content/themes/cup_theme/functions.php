<?php
/**
 * cup_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cup_theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cup_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on cup_theme, use a find and replace
		* to change 'cup_theme' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'cup_theme', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'cup_theme' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'cup_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'cup_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cup_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cup_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'cup_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cup_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'cup_theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'cup_theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'cup_theme_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function cup_theme_scripts() {
    // Подключение основного файла стилей
    wp_enqueue_style( 'cup_theme-style', get_stylesheet_uri(), array(), _S_VERSION );

    // Подключение стилей из вашего тематического каталога
    wp_enqueue_style( 'cup_theme-custom-style', get_template_directory_uri() . '/style.css', array('cup_theme-style'), _S_VERSION );

    // Подключение скрипта ajax.js
    wp_enqueue_script( 'cup_theme-ajax', get_template_directory_uri() . '/js/ajax.js', array('jquery'), _S_VERSION, true );

    // Подключение скрипта my_script.js
    wp_enqueue_script( 'cup_theme-script', get_template_directory_uri() . '/js/script.js', array('jquery'), _S_VERSION, true );

    wp_enqueue_script( 'xlsx', 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js', array(), null, true );
}
add_action( 'wp_enqueue_scripts', 'cup_theme_scripts' );



function restrict_site_access() {
    if (!is_user_logged_in()) {
        auth_redirect();
    }
}
add_action('template_redirect', 'restrict_site_access');


require get_template_directory() . '/my_php/tab_1.php';
require get_template_directory() . '/my_php/tab_2.php';
require get_template_directory() . '/my_php/tab_3.php';
require get_template_directory() . '/my_php/tab_4.php';
require get_template_directory() . '/my_php/tab_5.php';
require get_template_directory() . '/my_php/tab_7_glass.php';
require get_template_directory() . '/my_php/tab_7_insert.php';
require get_template_directory() . '/my_php/tab_7_stick.php';
require get_template_directory() . '/my_php/tab_7_master.php';
require get_template_directory() . '/my_php/tab_7_list.php';

// Функция для перенаправления пользователя на главную страницу после успешного входа
function custom_login_redirect( $redirect_to, $request, $user ) {
    // Проверяем, является ли пользователь администратором
    if ( isset( $user->roles ) && is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) {
        // Если пользователь администратор, оставляем редирект на административную панель
        return $redirect_to;
    } else {
        // Если пользователь не администратор, перенаправляем на главную страницу сайта
        return home_url();
    }
}
add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 );

// // Скрываем меню плагинов из административной панели
// function hide_plugins_menu() {
//     remove_menu_page( 'plugins.php' );
// }
// add_action( 'admin_menu', 'hide_plugins_menu' );

// // Перенаправляем страницу плагинов на главную страницу административной панели
// function redirect_plugins_page() {
//     global $pagenow;
//     if ( $pagenow == 'plugins.php' ) {
//         wp_redirect( admin_url() );
//         exit();
//     }
// }
// add_action( 'admin_init', 'redirect_plugins_page' );

// // Скрываем меню "Пользователи" из административной панели
// function hide_users_menu() {
//     remove_menu_page( 'users.php' );
// }
// add_action( 'admin_menu', 'hide_users_menu' );

// // Перенаправляем страницу пользователей на главную страницу административной панели
// function redirect_users_page() {
//     global $pagenow;
//     if ( $pagenow == 'users.php' ) {
//         wp_redirect( admin_url() );
//         exit();
//     }
// }
// add_action( 'admin_init', 'redirect_users_page' );

// // Скрываем меню "Настройки" из административной панели
// function hide_settings_menu() {
//     remove_menu_page( 'options-general.php' );
// }
// add_action( 'admin_menu', 'hide_settings_menu' );

// // Перенаправляем страницу настроек на главную страницу административной панели
// function redirect_settings_page() {
//     global $pagenow;
//     if ( $pagenow == 'options-general.php' ) {
//         wp_redirect( admin_url() );
//         exit();
//     }
// }
// add_action( 'admin_init', 'redirect_settings_page' );