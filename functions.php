<?php if(!defined('ABSPATH')){ exit; }

require_once dirname(__FILE__).'/includes/tgmpa/class-tgm-plugin-activation.php';

/**
 * rbf_cssStylesheets()
 * Enqueue theme CSS stylesheets
 */
function rbf_cssStylesheets()
{
    $styles = [
        'css_normalize' => ['/assets/css/normalize.css', '8.0.1'],
        'css_fontawesome' => ['/assets/css/all.min.css', '5.13.0'],
        'css_animate' => ['/assets/css/animate.css', '3.7.2'],
        'css_aos' => ['/assets/css/aos.css', '2.3.4'],
        'css_bootstrap' => ['/assets/css/bootstrap.min.css', '4.5.0'],
        'css_datatables' => ['/assets/css/datatables.min.css', '1.10.20'],
        'css_hamburgers' => ['/assets/css/hamburgers.min.css', '1.1.3'],
        'css_slick' => ['/assets/css/slick.css', '1.8.1'],
        'css_slicktheme' => ['/assets/css/slick-theme.css', '1.8.1'],
        'css_wicked' => ['/assets/css/wickedcss.min.css', '1.0.0'],
        'css_content' => ['/assets/css/content.css', '1.0.0'],
        'css_fonts' => ['/assets/css/fonts.css', '1.0.0'],
        'css_style' => ['/assets/css/style.css', '1.0.0'],
    ];
    foreach($styles as $id => $data){
        wp_enqueue_style($id, get_template_directory_uri().$data[0], [], $data[1]);
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
        wp_enqueue_script('jquery', get_template_directory_uri().'/assets/js/jquery-3.5.1.min.js', [], '3.5.1', false);
    }

    $scripts = [
        'js_popper' => ['/assets/js/popper.min.js', '1.16.0'],
        'js_bootstrap' => ['/assets/js/bootstrap.min.js', '4.5.0'],
        'js_aos' => ['/assets/js/aos.js', '2.3.4'],
        'js_datatables' => ['/assets/js/datatables.min.js', '1.10.20'],
        'js_feather' => ['/assets/js/feather.min.js', '4.24.1'],
        'js_html2canvas' => ['/assets/js/html2canvas.min.js', '1.0.0'],
        'js_lettering' => ['/assets/js/jquery.lettering.js', '0.7.0'],
        'js_parallax' => ['/assets/js/parallax.min.js', '1.5.0'],
        'js_slick' => ['/assets/js/slick.min.js', '1.8.1'],
        'js_typed' => ['/assets/js/typed.min.js', '2.0.11'],
        'js_script' => ['/assets/js/script.js', '1.0.0'],
    ];
    foreach($scripts as $id => $data){
        wp_enqueue_script($id, get_template_directory_uri().$data[0], [], $data[1], true);
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
            'name' => 'Classic Editor',
            'slug' => 'classic-editor',
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
add_action('tgmpa_register', 'rbf_requirePlugins');

/**
 * rbf_registerNavWalker()
 * Registers Bootstrap nav menu walker for Wordpress
 */
function rbf_registerNavWalker()
{
    require_once(dirname(__FILE__).'/includes/class-wp-bootstrap-navwalker.php');
}
add_action('after_setup_theme', 'rbf_registerNavWalker');

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
