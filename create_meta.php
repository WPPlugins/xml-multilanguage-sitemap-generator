<?php 
class Rational_Meta_Box {
    private $fields = array(
        array(
            'id' => 'url-immagini',
            'label' => 'Scrivi l\'url delle immagini separate da una virgola',
            'type' => 'textarea',
        ),
    );

    /**
     * Class construct method. Adds actions to their respective WordPress hooks.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_post' ) );
    }

    /**
     * Hooks into WordPress' add_meta_boxes function.
     * Goes through screens (post types) and adds the meta box.
     */
    public function add_meta_boxes() {
        $screens = get_option( 'post_type_to_include' );
        if($screens){
            $screens = array_keys($screens);
            foreach ( $screens as $screen ) {
                add_meta_box(
                    'url-immagini',
                    __( 'Configuratore immagini per XML SITEMAP GENERATOR', 'rational-metabox' ),
                    array( $this, 'add_meta_box_callback' ),
                    $screen,
                    'advanced',
                    'default'
                );
            }
        }
    }

    /**
     * Generates the HTML for the meta box
     * 
     * @param object $post WordPress post object
     */
    public function add_meta_box_callback( $post ) {
        wp_nonce_field( 'configuratore_immagini_per_xml_sitemap_generator_data', 'configuratore_immagini_per_xml_sitemap_generator_nonce' );
        echo 'Inserisci la lista delle immagini inserite nel post corrente. Inserisci l\'url dell\'immagine, puoi trovarlo cliccando con il tasto destro sull\'immagine e cliccando <em>copia l\'indirizzo dell\'immagine</em>.

Le url delle immagini devono essere divise l\'una dall\'altra da una <em>virgola</em>';
        $this->generate_fields( $post );
    }

    /**
     * Generates the field's HTML for the meta box.
     */
    public function generate_fields( $post ) {
        $output = '';
        foreach ( $this->fields as $field ) {
            $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
            $db_value = get_post_meta( $post->ID, 'configuratore_immagini_per_xml_sitemap_generator_' . $field['id'], true );
            switch ( $field['type'] ) {
                case 'textarea':
                    $input = sprintf(
                        '<textarea class="large-text" id="%s" name="%s" rows="5">%s</textarea>',
                        $field['id'],
                        $field['id'],
                        $db_value
                    );
                    break;
                default:
                    $input = sprintf(
                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                        $field['type'] !== 'color' ? 'class="regular-text"' : '',
                        $field['id'],
                        $field['id'],
                        $field['type'],
                        $db_value
                    );
            }
            $output .= $this->row_format( $label, $input );
        }
        echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
        if($db_value){
            $immagini_sitemap_check = explode(',',$db_value);
            foreach ($immagini_sitemap_check as $immagine_sitemap_check) {
                $immagine_sitemap_check = str_replace(' ', '', $immagine_sitemap_check);
                $immagine_esiste = attachment_url_to_postid($immagine_sitemap_check);
                if(! $immagine_esiste){
                    echo "<div class='fail' style='padding: 7px; background: #FF9494;'>";
                    echo "L'URL <b>".$immagine_sitemap_check."</b> non è stato trovato.";
                    echo "</br>";
                    echo "</div>";
                }
            }
        }
    }

    /**
     * Generates the HTML for table rows.
     */
    public function row_format( $label, $input ) {
        return sprintf(
            '<tr><th scope="row">%s</th><td>%s</td></tr>',
            $label,
            $input
        );
    }
    /**
     * Hooks into WordPress' save_post function
     */
    public function save_post( $post_id ) {
        if ( ! isset( $_POST['configuratore_immagini_per_xml_sitemap_generator_nonce'] ) )
            return $post_id;

        $nonce = $_POST['configuratore_immagini_per_xml_sitemap_generator_nonce'];
        if ( !wp_verify_nonce( $nonce, 'configuratore_immagini_per_xml_sitemap_generator_data' ) )
            return $post_id;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;

        foreach ( $this->fields as $field ) {
            if ( isset( $_POST[ $field['id'] ] ) ) {
                switch ( $field['type'] ) {
                    case 'email':
                        $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
                        break;
                    case 'text':
                        $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
                        break;
                }
                update_post_meta( $post_id, 'configuratore_immagini_per_xml_sitemap_generator_' . $field['id'], $_POST[ $field['id'] ] );
            } else if ( $field['type'] === 'checkbox' ) {
                update_post_meta( $post_id, 'configuratore_immagini_per_xml_sitemap_generator_' . $field['id'], '0' );
            }
        }
    }
}
new Rational_Meta_Box; 

?>