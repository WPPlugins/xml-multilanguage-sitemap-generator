<?php 

function giannini_generateSitemap_multi(){

    //Prendo le informazioni impostate nelle opzioni del plugin.
    //Prendo gli ID delle pagine da non mostrare nella sitemap.

    // ensure is_plugin_active() exists (not on frontend)

    $sitemap_name = get_option('sitemap_name');

    if($sitemap_name){

        $sitemap_name = $sitemap_name.'-index.xml';

    } else {

        $sitemap_name = 'xml_mg_sitemap-index.xml';

    }

    $idToExclude = get_option('id_excluded');

    if($idToExclude){

        $idToExclude = array_keys($idToExclude);

    }

    $poststypetoinclude = get_option('post_type_to_include');

    if($poststypetoinclude){

        $poststypetoinclude = array_keys($poststypetoinclude);

    } else {

        $poststypetoinclude = array('page'); 

    }

    $priority_value = get_option('priority_value');

    $priority_single_value = get_option('priority_single_value');

    $changefreq_value = get_option('changefreq_value');

    $changefreq_single_value = get_option('changefreq_single_value');

    foreach ($poststypetoinclude as $post_type) {
        
        $doc = new DOMDocument( );

        if(file_exists($sitemap_name)){

            $doc->load($sitemap_name);

        }

        $ele = $doc->createElement( 'Root' );

        $objDom = new DOMDocument('1.0');

        $objDom->encoding = 'UTF-8';

        $objDom->formatOutput = true;

        $objDom->preserveWhiteSpace = false;

        $root = $objDom->createElement("urlset");

        $objDom->appendChild($root);

        $root_attr = $objDom->createAttribute("xmlns");

        $another_root_attr = $objDom->createAttribute('xmlns:xhtml');

        $another_root_attr_img = $objDom->createAttribute('xmlns:image');

        $root->appendChild($root_attr);

        $root->appendChild($another_root_attr);

        $root->appendChild($another_root_attr_img);

        $root_attr_text = $objDom->createTextNode("http://www.sitemaps.org/schemas/sitemap/0.9");

        $another_root_attr_text = $objDom->createTextNode("http://www.w3.org/1999/xhtml");

        $another_root_attr_text_img = $objDom->createTextNode("http://www.google.com/schemas/sitemap-image/1.1");

        $root_attr->appendChild($root_attr_text);

        $another_root_attr->appendChild($another_root_attr_text);

        $another_root_attr_img->appendChild($another_root_attr_text_img);

        //*********Fine della creazione della sitemap***********//

        //Controllo se è attivo WPML o POLYLANG. 
        //Grazie a post__not_in riesco ad escludere gli ID scelti nelle opzioni dall'utente.
        //Se è attivo WPML cambio la lingua globale nella lingua di Default del sito per impostare la variabile $query

        if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {

            global $sitepress;

            $current_language = $sitepress->get_current_language();

            $default_language = $sitepress->get_default_language();

            $sitepress->switch_lang($default_language);

            $query = new WP_Query( array( 'post_type' => $post_type, 'post__not_in' => $idToExclude, 'posts_per_page' => -1) );

        } 

        elseif ( is_plugin_active( 'polylang/polylang.php' ) ){

            $default_polylang_lang = pll_default_language();

            $query = new WP_Query( array( 'post_type' => $post_type, 'post__not_in' => $idToExclude, 'lang' => $default_polylang_lang, 'posts_per_page' => -1 ) );

        }

        else {

            $query = new WP_Query (array( 'post_type' => $post_type, 'post__not_in' => $idToExclude, 'posts_per_page' => -1 ) );

        }

        //Comincio la query di tutti i post inseriti.

        if($poststypetoinclude){

            while($query->have_posts()) {

                $query->the_post();

                //prendo l'ID del post corrente e il permalink.

                $postid = get_the_ID();

                $loc_ar = get_permalink();

                $langs = '';

                //Imposto dei valori al momento di DEFAULT.

                $lastmod_ar = date('Y-m-d');

                if(!empty($changefreq_single_value[$postid])){

                    $changefreq_ar = $changefreq_single_value[$postid];

                } elseif (!empty($changefreq_value[get_post_type()])){

                    $changefreq_ar = $changefreq_value[get_post_type()];

                } else {

                    $changefreq_ar = 'weekly';

                }

                if(!empty($priority_single_value[$postid])){

                    $priority_ar = $priority_single_value[$postid];

                } elseif (!empty($priority_value[get_post_type()])){

                    $priority_ar = $priority_value[get_post_type()];

                } else {

                    $priority_ar = 0.5;

                }

                //Creo le informazioni della sitemap quali: URL - LOC - LASTMOD - CHANGEFREQ - PRIORITY da compilare successivamente con le informazione che riesco a ricavare tramite il loop

                $url = $objDom->createElement("url");

                $root->appendChild($url);

                $loc = $objDom->createElement("loc");

                $lastmod = $objDom->createElement("lastmod");

                $changefreq = $objDom->createElement("changefreq");

                $priority = $objDom->createElement("priority");

                $url->appendChild($loc);

                $immagini_sitemap = get_post_meta($postid,'configuratore_immagini_per_xml_sitemap_generator_url-immagini');

                if($immagini_sitemap){

                    $immagini_sitemap = $immagini_sitemap[0];

                    $immagini_sitemap = explode(',', $immagini_sitemap);

                    foreach ($immagini_sitemap as $immagine_sitemap) {

                        $immagine_sitemap_url = str_replace(' ', '', $immagine_sitemap);

                        $immagine_sitemap_id = attachment_url_to_postid($immagine_sitemap_url);

                        if($immagine_sitemap_id){

                            $title_img = get_post($immagine_sitemap_id)->post_excerpt;

                            $img_xml = $objDom->createElement('image:image');

                            $url->appendChild($img_xml);

                            $img_url = $objDom->createElement('image:loc',$immagine_sitemap_url);

                            $img_xml->appendChild($img_url);

                            if($title_img){

                                $img_title = $objDom->createElement('image:title',$title_img);

                                $img_xml->appendChild($img_title);

                            }                       

                        }            

                    }

                }

                //Controllo quale plugin multilingua è attivo

                //MO INIZIANO I CAZZI

                //START WPML

                if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {

                    //Prendo tutte le lingue esistenti nel sito grazie a 'skip_missing=0'

                    $languages = icl_get_languages('skip_missing=0');

                    //Se trovo una lingua alternativa inizio la festa!

                    if(1 < count($languages)){

                        foreach($languages as $l){  

                            //Se la lingua del post oggetto della query è quella di default, imposto il suo permalink nel campo LOC della sitemap

                            if($l['language_code'] == $default_language){

                                $icl_object_id = icl_object_id($postid, 'page', false, $l['language_code']);

                                $permalink = get_permalink($icl_object_id);

                                $href = apply_filters( 'wpml_permalink', $permalink, $default_language );

                                $url_text = $objDom->createTextNode($href);

                                $loc->appendChild($url_text);

                                //Altrimenti costruisco un array con come chiave l'id del post oggetto tradotto e come valore il codice della lingua del post. Ad esempio $langs[325] => en,

                            } else {

                                $icl_object_id = icl_object_id($postid, 'page', false, $l['language_code']);

                                if(!$l['active'] && !is_null($icl_object_id)){  

                                    //Salvo in un array il LANGUAGE CODE. Esempio EN, IT, ES eccetera.

                                    $langs[$icl_object_id] = $l['language_code'];

                                }

                            }

                        } 

                        //Controllo se $langs è un array. nel caso non lo fosse vuol dire che il post corrente non ha alcuna traduzione e quindi posso cercare il prossimo post

                        if(is_array($langs)){ 

                            foreach ($langs as $id => $lang) {

                                $sitepress->switch_lang($lang);

                                //Creo le basi della lingua alternativa nella sitemap

                                $node = $objDom->createElement('xhtml:link');

                                //Con get_permalink() non posso prendere l'url del post tradotto ma qualunque ID gli dia lui mi darà sempre l'url della lingua corrente al momento della stampa della sitemap.

                                $permalink = get_permalink($id);

                                //Grazie ad apply_filters wpml permalink posso prendere il permalink tradotto nella lingua corrente. 

                                $href = apply_filters( 'wpml_permalink', $permalink, $lang );

                                //Inserisco i valori appena ricavati all'interno delle informazioni per la lingua alternativa

                                $node->setAttribute('rel', 'alternate');

                                $node->setAttribute('hreflang', $lang);

                                $node->setAttribute('href', $href);

                                $loc->parentNode->appendChild($node);

                                $default = $sitepress->get_default_language();

                                $sitepress->switch_lang($default);

                            };

                        };

                    } else {

                        $permalink_default = get_permalink();

                        $url_text = $objDom->createTextNode($permalink_default);

                        $loc->appendChild($url_text);

                    }

                    $sitepress->switch_lang($current_language);

                }

                //FINALMENTE FESTA FINITA 

                //STOP WPML

                //******************

                //START POLYLANG

                //Controllo se polylang è attivo

                elseif( is_plugin_active( 'polylang/polylang.php' ) ){

                    $current_page_id = get_the_ID();

                    //PLL_THE_LANGUAGES mi stampa un array con molte informazioni utili riguardo all'ID consegnato. 
                    //Mi permette di stampare tutti gli id delle traduzioni del post corrente.
                
                    $langs = pll_the_languages(array('post_id'=>$current_page_id,'hide_if_empty' => 1,'echo'=>0,'raw'=>1));

                    foreach($langs as $lang){

                        //Se il post non ha traduzioni, skippo questo passaggio.

                        if($lang['no_translation'] != 1){

                            //Se nell'array classes dell'array $lang c'è il valore lang-item-first vuol dire che le informazioni dell'array corrente sono quelle della lingua di default impostata su Polylang
                            //Nel caso fosse la lingua principale imposto la url all'interno di LOC 

                            if(in_array('lang-item-first',$lang['classes'])){

                                $lang_url = $lang['url'];

                                $url_text = $objDom->createTextNode($lang_url);

                                $loc->appendChild($url_text);

                            } else {

                                //In caso contrario prendo le varie voci che mi servono e le inserisco all'interno delle informazioni per la lingua alternativa

                                $lang_code = $lang['slug'];

                                $href = $lang['url'];

                                $node = $objDom->createElement('xhtml:link');

                                $node->setAttribute('rel', 'alternate');

                                $node->setAttribute('hreflang', $lang_code);

                                $node->setAttribute('href', $href);

                                $loc->parentNode->appendChild($node);

                            };

                        };

                    };

                }

                else{

                    $current_page_url = get_the_permalink();

                    $url_text = $objDom->createTextNode($current_page_url);

                    $loc->appendChild($url_text);

                };

                //Inserisco i valori nei vari field creati precendemente chiudendo quindi la sitemap.

                $url->appendChild($lastmod);

                $lastmod_text = $objDom->createTextNode($lastmod_ar);

                $lastmod->appendChild($lastmod_text);

                $url->appendChild($changefreq);

                $changefreq_text = $objDom->createTextNode($changefreq_ar);

                $changefreq->appendChild($changefreq_text);

                $url->appendChild($priority);

                $priority_text = $objDom->createTextNode($priority_ar);

                $priority->appendChild($priority_text);

                //Resetto l'array creato prima delle lingue

                $langs = array();

            };

        }

        $sitemap_post_type = $_SERVER['DOCUMENT_ROOT'].'/'.$post_type.'.xml';

        $sitemap_domain_url = get_site_url().'/'.$post_type.'.xml';

        $sitemap_array[] = $sitemap_domain_url;

        $objDom->save($sitemap_post_type);

    }

    //Salvo la sitemap

    //Creo la sitemap completa

    $ele = $doc->createElement( 'Root' );

    $objDom = new DOMDocument('1.0');

    $objDom->encoding = 'UTF-8';

    $objDom->formatOutput = true;

    $objDom->preserveWhiteSpace = false;

    $root = $objDom->createElement("sitemapindex");

    $objDom->appendChild($root);

    $root_attr = $objDom->createAttribute("xmlns");

    $root->appendChild($root_attr);

    $root_attr_text = $objDom->createTextNode("http://www.sitemaps.org/schemas/sitemap/0.9");

    $root_attr->appendChild($root_attr_text);

    foreach ($sitemap_array as $the_sitemap_url) {
        
        $url = $objDom->createElement("sitemap");

        $root->appendChild($url);

        $loc = $objDom->createElement("loc");

        $url->appendChild($loc);

        $url_text = $objDom->createTextNode($the_sitemap_url);

        $loc->appendChild($url_text);

        $lastmod = $objDom->createElement("lastmod");

        $url->appendChild($lastmod);

        $lastmod_text = $objDom->createTextNode($lastmod_ar);

        $lastmod->appendChild($lastmod_text);

    }

    $objDom->save($_SERVER['DOCUMENT_ROOT'] . '/'.$sitemap_name);

    wp_reset_query();

    if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {

        $sitepress->switch_lang($current_language);

    }

}