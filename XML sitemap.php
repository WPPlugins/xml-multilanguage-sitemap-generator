<?php
/*
Plugin Name: XML Multilanguage Sitemap Generator
Plugin URI:  https://wordpress.org/plugins/xml-multilanguage-sitemap-generator
Description: Create a wonderful sitemap in the root of the website with all the alternative languages too, if available.
Version:     1.4.7
Author:      Marco Giannini
Author URI:  http://marcogiannini.net
Text Domain: xml-multilanguage-sitemap-generator
Domain Path: /languages
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/ 

function languages_xml() {
 $plugin_dir = basename(dirname(__FILE__)).'/languages';
 load_plugin_textdomain( 'xml-multilanguage-sitemap-generator', false, $plugin_dir );
}
add_action('plugins_loaded', 'languages_xml');

include('option.php');

include('create_meta.php');

include('assets/include_assets.php');

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$multi_sitemap = get_option('multi_sitemap');

if( !function_exists('is_plugin_active') ) {
        
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    
}

if($multi_sitemap){

    include('inc/multi.php');

    add_action('save_post','giannini_generateSitemap_multi');

    add_action( 'delete_post', 'giannini_generateSitemap_multi');

    add_action('admin_head-toplevel_page_xml_multilanguage_sitemap_generator','giannini_generateSitemap_multi');

} else {

    include('inc/single.php');
    
    add_action('save_post','giannini_generateSitemap');

    add_action( 'delete_post', 'giannini_generateSitemap');

    add_action('admin_head-toplevel_page_xml_multilanguage_sitemap_generator','giannini_generateSitemap');

}