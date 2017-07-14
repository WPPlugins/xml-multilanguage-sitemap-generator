<?php
add_action( 'admin_menu', 'XMLGEN_add_admin_menu' );
add_action( 'admin_init', 'XMLGEN_settings_init' );




function XMLGEN_add_admin_menu(  ) { 

    add_menu_page( 'xml multilanguage sitemap generator', 'XML Sitemap', 'manage_options', 'xml_multilanguage_sitemap_generator', 'XMLGEN_options_page', plugins_url("xml-multilanguage-sitemap-generator/img/icon-32x32.png") );

}


function XMLGEN_settings_init(  ) { 

    register_setting( 'pluginPage', 'sitemap_name');

    register_setting( 'pluginPage', 'id_excluded' );

    register_setting( 'pluginPage', 'post_type_to_include' );

    register_setting( 'pluginPage', 'priority_value' );

    register_setting( 'pluginPage', 'priority_single_value' );

    register_setting( 'pluginPage', 'changefreq_value' );

    register_setting( 'pluginPage', 'changefreq_single_value' );

    register_setting( 'pluginPage', 'multi_sitemap' );

    add_settings_section(
        'XMLGEN_pluginPage_donate_section', 
        __( '', 'xml-multilanguage-sitemap-generator' ), 
        'XMLGEN_settings_donate', 
        'pluginPage'
    );

    add_settings_section(
        'XMLGEN_pluginPage_section', 
        __( '', 'xml-multilanguage-sitemap-generator' ), 
        'XMLGEN_settings_section_callback', 
        'pluginPage'
    );

    add_settings_field( 
        'XMLGEN_multiple_sitemap', 
        __( 'Create a different sitemap for each post type. ', 'xml-multilanguage-sitemap-generator' ), 
        'XMLGEN_multiple_single_sitemap',
        'pluginPage',
        'XMLGEN_pluginPage_section' 
    );

    add_settings_field( 
        'XMLGEN_text_field_0', 
        __( 'Insert the name of the sitemap. Use a unique name. Default name: xml_mg_sitemap. ', 'xml-multilanguage-sitemap-generator' ), 
        'XMLGEN_text_field_0_render', 
        'pluginPage', 
        'XMLGEN_pluginPage_section' 
    );

    add_settings_field( 
        'XMLGEN_checkbox_field_1', 
        __( 'Check the post type you WANT to set in your sitemap.', 'xml-multilanguage-sitemap-generator' ), 
        'XMLGEN_checkbox_field_1_render', 
        'pluginPage', 
        'XMLGEN_pluginPage_section' 
    );

    add_settings_field( 
        'XMLGEN_text_field_2', 
        __( "Check the posts you DON'T WANT to set in your sitemap.", 'xml-multilanguage-sitemap-generator' ), 
        'XMLGEN_text_field_2_render', 
        'pluginPage', 
        'XMLGEN_pluginPage_section' 
    );


}

function XMLGEN_text_field_0_render() { 

    $sitemap_name = get_option('sitemap_name'); 

    $is_multiple = get_option('multi_sitemap');

    if($sitemap_name){ ?>

        <input type='text' name='sitemap_name' value="<?php echo $sitemap_name; ?>">  <?php

        if($is_multiple){

            $sitemap_name_url = get_site_url().'/'.$sitemap_name.'-index.xml';

        } else {

            $sitemap_name_url = get_site_url().'/'.$sitemap_name.'.xml';

        }

    } else { ?>

        <input type='text' name='sitemap_name' value="xml_mg_sitemap"> <?php

        if($is_multiple){

            $sitemap_name_url = get_site_url().'/xml_mg_sitemap-index.xml';

        } else {

            $sitemap_name_url = get_site_url().'/xml_mg_sitemap.xml';

        }

    }

    _e('Click here for <a target="_blank" href="'.$sitemap_name_url.'">see your sitemap.</a> <--- This is the link to send to <b>Google</b> <a href="https://support.google.com/webmasters/answer/183668?hl=it#addsitemap" target="_blank">for index your site.</a>','xml-multilanguage-sitemap-generator');

}

function XMLGEN_multiple_single_sitemap( ){

    $multiple_sitemap = get_option( 'multi_sitemap' ); 

    if($multiple_sitemap){ ?>

        <input type='checkbox' name='multi_sitemap' <?php if(isset($multiple_sitemap)){checked( $multiple_sitemap, 1 );} ?> value='1'><?php

    } else { ?>

        <input type='checkbox' name='multi_sitemap' value='1'></br> <?php

    }

}

function XMLGEN_checkbox_field_1_render(  ) { 

    $options_pt = get_option( 'post_type_to_include' );

    $priority = get_option( 'priority_value' );

    $changefreq = get_option( 'changefreq_value' );

    $post_types = get_post_types();

    $remove_post_types = array('revision','nav_menu_item','custom_css','customize_changeset','acf-field-group','acf-field','wpcf7_contact_form','attachment','polylang_mo');

    foreach ($remove_post_types as $remove_post_type) {

        if (($key = array_search($remove_post_type, $post_types)) !== false) {

            unset($post_types[$key]);

        }

    }

    ?>

    <?php if($options_pt){ ?>

        <div class="table-responsive-vertical shadow-z-1">
            <table id="table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th><?php _e('Visible in sitemap','xml-multilanguage-sitemap-generator'); ?></th>
                        <th><?php _e('Post type name','xml-multilanguage-sitemap-generator'); ?></th>
                        <th><?php _e('General Priority','xml-multilanguage-sitemap-generator'); ?></th>
                        <th><?php _e('General Changefreq','xml-multilanguage-sitemap-generator'); ?></th>
                    </tr>
                </thead>
                <tbody> <?php

                foreach ($post_types as $post_type) { ?>

                    <tr>
                        <td data-title="Visible in sitemap"><input type='checkbox' name='post_type_to_include[<?php echo $post_type; ?>]' <?php if(isset($options_pt[$post_type])){checked( $options_pt[$post_type], 1 );} ?> value='1'></td>
                        <td data-title="Post type name"><?php echo $post_type; ?></td>
                        <td data-title="General Priority"><input type='number' step="0.1" min="0" max="1" name='priority_value[<?php echo $post_type; ?>]' value="<?php echo $priority[$post_type]; ?>"></td>
                        <td data-title="General Changefreq"><input class="autocomplete" type="text" name="changefreq_value[<?php echo $post_type ?>]" value="<?php echo $changefreq[$post_type]; ?>"></td>
                    </tr>

                <?php }

                ?>

                </tbody>

            </table>   

        </div>

        <input type="submit" name="submit" class="button button-primary" value="<?php _e('Create the Sitemap','xml-multilanguage-sitemap-generator'); ?>">
        <?php

        

    } else { ?>

    	 <div class="table-responsive-vertical shadow-z-1 what">
            <table id="table" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th><?php _e('Visible in sitemap','xml-multilanguage-sitemap-generator'); ?></th>
                        <th><?php _e('Post type name','xml-multilanguage-sitemap-generator'); ?></th>
                        <th><?php _e('General Priority','xml-multilanguage-sitemap-generator'); ?></th>
                        <th><?php _e('General Changefreq','xml-multilanguage-sitemap-generator'); ?></th>
                    </tr>
                </thead>
                <tbody> <?php

		        foreach ($post_types as $post_type) { ?>

		            <tr>
                        <td data-title="Visible in sitemap"><input type='checkbox' name='post_type_to_include[<?php echo $post_type; ?>]' value='1'></td>
                        <td data-title="Post type name"><?php echo $post_type; ?></td>
                        <td data-title="General Priority"><input type='number' step="0.1" min="0" max="1" name='priority_value[<?php echo $post_type; ?>]' value="<?php echo $priority[$post_type]; ?>"></td>
                        <td data-title="General Changefreq"><input class="autocomplete" type="text" name="changefreq_value[<?php echo $post_type ?>]" value="<?php echo $changefreq[$post_type]; ?>"></td>
                    </tr>
		        <?php
		    		} 
		        ?>
        		</tbody>

            </table>   

        </div>

        <input type="submit" name="submit" class="button button-primary" value="<?php _e('Create the Sitemap','xml-multilanguage-sitemap-generator'); ?>">

        <?php

    }

}


function XMLGEN_text_field_2_render(  ) { 

    $post_types_chosen = get_option('post_type_to_include');

    $options_id = get_option( 'id_excluded' );

    $priority = get_option('priority_value');

    $priority_single_value = get_option('priority_single_value');

    $changefreq = get_option('changefreq_value');

    $changefreq_single_value = get_option('changefreq_single_value');

    if($post_types_chosen){

        foreach ($post_types_chosen as $post_type_chosen => $value) {

            $args = array(

                'post_type' => $post_type_chosen,
                'posts_per_page' => -1,

            );

            // The Query
            $query = new WP_Query( $args );

            // The Loop
            if ( $query->have_posts() ) {

                echo '<h3 style="text-transform:capitalize;">'.$post_type_chosen.'</h3>'; ?>

                <div class="table-responsive-vertical shadow-z-1">
                    <table id="table" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th><?php _e('Not visible','xml-multilanguage-sitemap-generator'); ?></th>
                                <th><?php _e('ID','xml-multilanguage-sitemap-generator'); ?></th>
                                <th><?php _e('Title','xml-multilanguage-sitemap-generator'); ?></th>
                                <th><?php _e('Priority','xml-multilanguage-sitemap-generator'); ?></th>
                                <th><?php _e('Changefreq','xml-multilanguage-sitemap-generator'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                <?php

                while ( $query->have_posts() ) {

                    $query->the_post(); 

                    $id = get_the_ID();

                    $title = get_the_title();

                    $permalink = get_permalink();

                    ?>

                    <?php if($options_id){ ?>

                        <tr>
                            <td data-title="Not visible"><input type='checkbox' name='id_excluded[<?php echo $id; ?>]' <?php if(isset($options_id[$id])){ checked( $options_id[$id], 1 ); } ?> value='1'></td>
                            <td data-title="ID"><?php echo $id; ?></td>
                            <td data-title="Title"><a target="_blank" href="<?php echo $permalink; ?>"><?php echo $title; ?></a></td>

                            <?php if($priority_single_value[$id]){ ?>
                                <td data-title="Priority"><input type='number' step="0.1" min="0" max="1" name='priority_single_value[<?php echo $id; ?>]' value="<?php echo $priority_single_value[$id]; ?>"></td>

                            <?php } else { ?>

                                <td data-title="Priority"><input type='number' step="0.1" min="0" max="1" name='priority_single_value[<?php echo $id; ?>]' placeholder="<?php echo $priority[get_post_type()]; ?>"></td>

                            <?php } ?>
                            <?php if($changefreq_single_value[$id]){ ?>

                                <td data-title="Changefreq"><input class="autocomplete" type='text' name='changefreq_single_value[<?php echo $id; ?>]' value="<?php echo $changefreq_single_value[$id]; ?>"></td>

                            <?php } else { ?>

                                <td data-title="Changefreq"><input class="autocomplete" type='text' name='changefreq_single_value[<?php echo $id; ?>]' placeholder="<?php echo $changefreq[get_post_type()]; ?>"></td>
                            <?php } ?>
                        </tr>

                    <?php } else { ?>

                        <tr>
                            <td data-title="Not visible"><input type='checkbox' name='id_excluded[<?php echo $id; ?>]' value='1'></td>
                            <td data-title="ID"><?php echo $id; ?></td>
                            <td data-title="Title"><a target="_blank" href="<?php echo $permalink; ?>"><?php echo $title; ?></a></td>

                            <?php if($priority_single_value[$id]){ ?>
                                <td data-title="Priority"><input type='number' step="0.1" min="0" max="1" name='priority_single_value[<?php echo $id; ?>]' value="<?php echo $priority_single_value[$id]; ?>"></td>

                            <?php } else { ?>

                                <td data-title="Priority"><input type='number' step="0.1" min="0" max="1" name='priority_single_value[<?php echo $id; ?>]' placeholder="<?php echo $priority[get_post_type()]; ?>"></td>

                            <?php } ?>
                            <?php if($changefreq_single_value[$id]){ ?>

                                <td data-title="Changefreq"><input class="autocomplete" type='text' name='changefreq_single_value[<?php echo $id; ?>]' value="<?php echo $changefreq_single_value[$id]; ?>"></td>

                            <?php } else { ?>

                                <td data-title="Changefreq"><input class="autocomplete" type='text' name='changefreq_single_value[<?php echo $id; ?>]' placeholder="<?php echo $changefreq[get_post_type()]; ?>"></td>
                            <?php } ?>
                        </tr>
                
                <?php 

                    }

                } ?>

                        </tbody>

                    </table>

                </div>

                <input type="submit" name="submit" class="button button-primary" value="<?php _e('Create the Sitemap','xml-multilanguage-sitemap-generator'); ?>">

                <?php
            }

            // Restore original Post Data
            wp_reset_postdata();

            }


    }


}

function XMLGEN_settings_donate( ){

    ?>
    <div style="margin: 9px 15px 4px 0; padding: 5px 30px; text-align: center; float: left; clear:left; border: solid 3px #cccccc; width: 600px;">
        <p>
        <?php _e('Helps me to improve the plugin, add new functions and improve the support!<br> Feel free to donate how much you want or leave a review! <br>','xml-multilanguage-sitemap-generator'); ?>
        <a target="_blank" href="http://paypal.me/gianemi2"><img id="donate-button" style="margin: 0px auto; width: 150px;" src="<?php echo plugins_url('img/paypal-donate.png', __FILE__) ?>" alt="Donate"></a>
        <br>
        <a target="_blank" href="https://wordpress.org/plugins/xml-multilanguage-sitemap-generator/"><?php _e('Documentation','xml-multilanguage-sitemap-generator'); ?></a>
         - <a href="mailto:info@marcogiannini.net"><?php _e('Contact me','xml-multilanguage-sitemap-generator'); ?></a>
         - <a href="https://wordpress.org/support/plugin/xml-multilanguage-sitemap-generator"><?php _e('Supports topic','xml-multilanguage-sitemap-generator'); ?></a>
        </p>
    </div>
    <div style="clear:both;"></div>
    <?php

}


function XMLGEN_settings_section_callback(  ) { 

    echo __( '<h4>Welcome to the configuration panel of <b>XML MULTILANGUAGE SITEMAP GENERATOR</b>.</h4> <br> For more information see <a href="https://wordpress.org/plugins/xml-multilanguage-sitemap-generator/" target="_blank">the wordpress plugin directory page.</a>
        <br><br> If you need support <a href="https://wordpress.org/support/plugin/xml-multilanguage-sitemap-generator" target="_blank">check the support page of the plugin!</a>
        <br><br> If you want to suggest me something new, <a href="mailto:info@marcogiannini.net">send me a mail</a>', 'xml-multilanguage-sitemap-generator' );

}


function XMLGEN_options_page(  ) { 

    ?>
    <form action='options.php' method='post'>

        <h2><?php _e('XML Multilanguage Sitemap Generator','xml-multilanguage-sitemap-generator') ?></h2>
        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        
        ?>

    </form>
<?php
}

?>