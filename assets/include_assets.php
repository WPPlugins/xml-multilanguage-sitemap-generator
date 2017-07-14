<?php 

function load_custom_wp_admin_style($hook) {
        // Load only on ?page=mypluginname
        if($hook != 'toplevel_page_xml_multilanguage_sitemap_generator') {
                return;
        }
        wp_register_style('xml_multilanguage_sitemap_generator_styles', plugins_url ( 'style.css', __FILE__ ));

	    wp_register_script('xml_multilanguage_sitemap_generator_script', plugins_url ( 'main.js', __FILE__ ));

	    wp_register_script('xml_multilanguage_sitemap_generator_script_materialize','https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js');

	    wp_enqueue_script('xml_multilanguage_sitemap_generator_script_materialize');

	    wp_enqueue_script('xml_multilanguage_sitemap_generator_script');

	    wp_enqueue_style('xml_multilanguage_sitemap_generator_styles');

}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );