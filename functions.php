<?php if(!defined('ABSPATH')){ exit; }

require_once dirname(__FILE__).'/includes/tgmpa/class-tgm-plugin-activation.php';

/**
 * rbf_cssStylesheets()
 * Enqueue theme CSS stylesheets
 */
function rbf_cssStylesheets()
{
    $v = "1.0.0";
    $styles = [
        'css_normalize' => '/assets/css/normalize.css',
        'css_fontawesome' => '/assets/css/all.min.css',
        'css_animate' => '/assets/css/animate.css',
        'css_aos' => '/assets/css/aos',
        'css_bootstrap' => '/assets/css/bootstrap.min.css',
        'css_datatables' => '/assets/css/datatables.min.css',
        'css_slick' => '/assets/css/slick.css',
        'css_slicktheme' => '/assets/css/slick-theme.css',
        'css_wicked' => '/assets/css/wickedcss.min.css',
        'css_content' => '/assets/css/content.css',
        'css_fonts' => '/assets/css/fonts.css',
        'css_style' => '/assets/css/style.css',
    ];
    foreach($styles as $id => $file){
        wp_enqueue_style($id, get_template_directory_uri().$file, [], $v);
    }
}
add_action('wp_enqueue_scripts', 'rbf_cssStylesheets');

/**
 * rbf_jsScripts()
 * Enqueue theme JavaScript files
 */
function rbf_jsScripts()
{
    if(!is_admin()){
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', get_template_directory_uri().'/assets/js/jquery-3.5.0.min.js', [], '3.5.0', false);
    }

    $v = "1.0.0";
    $scripts = [
        'js_popper' => '/assets/js/popper.min.js',
        'js_bootstrap' => '/assets/js/bootstrap.min.js',
        'js_aos' => '/assets/js/aos.js',
        'js_datatables' => '/assets/js/datatables.min.js',
        'js_feather' => '/assets/js/feather.min.js',
        'js_html2canvas' => '/assets/js/html2canvas.min.js',
        'js_lettering' => '/assets/js/jquery.lettering.js',
        'js_parallax' => '/assets/js/parallax.min.js',
        'js_slick' => '/assets/js/slick.min.js',
        'js_typed' => '/assets/js/typed.min.js',
        'js_script' => '/assets/js/script.js',
    ];
    foreach($scripts as $id => $file){
        wp_enqueue_script($id, get_template_directory_uri().$file, [], $v, true);
    }
}
add_action('wp_enqueue_scripts', 'rbf_jsScripts');

/**
 * rbf_themeSetup()
 * General settings for theme
 */
function rbf_themeSetup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5');
    add_theme_support('automatic-feed-links');

    add_image_size("medium-big", 800);
    add_image_size('small-icon', 32, 32);
}
add_action('after_setup_theme', 'rbf_themeSetup');

/**
 * rbf_registerMenus()
 * Register theme menus
 */
function rbf_registerMenus()
{
    register_nav_menus(array(
        'primary' => 'Menu Principal',
        'secondary' => 'Menu Secundário'
    ));
}
add_action('after_setup_theme', 'rbf_registerMenus');

/**
 * rbf_requirePlugins()
 * Initialize TGMPA and require plugins
 */
function rbf_requirePlugins()
{
    $plugins = array(
        array(
            'name' => 'Advanced Custom Fields Pro',
            'slug' => 'advanced-custom-fields-pro',
            'source' => get_template_directory_uri().'/includes/tgmpa/plugins/advanced-custom-fields-pro.zip',
            'required' => true,
        ),
        array(
            'name' => 'Advanced Custom Fields: Font Awesome Field',
            'slug' => 'advanced-custom-fields-font-awesome',
            'required' => true,
        ),
        array(
            'name' => 'Classic Editor',
            'slug' => 'classic-editor',
            'required' => true,
        ),
        /* array(
            'name' => 'Theme Plugin',
            'slug' => 'base-plugin',
            'source' => get_template_directory_uri().'/includes/tgmpa/plugins/base-plugin.zip',
            'required' => true,
        ), */
        array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'required' => true,
        ),
        array(
            'name' => 'Breadcrumb NavXT',
            'slug' => 'breadcrumb-navxt',
            'required' => false,
        ),
        array(
            'name' => 'Re-add Text Underline and Justify',
            'slug' => 're-add-underline-justify',
            'required' => false,
        ),
        array(
            'name' => 'Yoast SEO',
            'slug' => 'wordpress-seo',
            'required' => false,
        ),
    );

    $config = array(
        'id' => 'rbftheme-tgmpa',
        'menu' => 'rbftheme-install-plugins',
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'rbfTheme_requirePlugins');

/**
 * rbf_excerptEnd($more)
 * Set default excerpt ending characters
 * @param string ending
 * @return string
 */
function rbf_excerptEnding($more)
{
    $ending = '...';
    if(function_exists('get_field')){
        $ending = get_field('excerpt_ending', 'option') ? get_field('excerpt_ending', 'option') : $ending;
    }
    return $ending;
}
add_filter('excerpt_more', 'rbf_excerptEnding');

/**
 * rbf_excerptLength($length)
 * @param int length
 * @return int
 */
function rbf_excerptLength($length)
{
    $length = 30;
    if(function_exists('get_field')){
        $length = get_field('excerpt_length', 'option') ? get_field('excerpt_length', 'option') : $length;
    }
    return $length;
}
add_filter('excerpt_length', 'rbf_excerptLength');

/**
 * get_menu_items(@menu_location)
 * Return specified menu's content
 * @param string menu
 * @return array
 */
function get_menu_items($menu_location = ''){
    return wp_get_nav_menu_items(get_nav_menu_locations()[$menu_location]);
}
