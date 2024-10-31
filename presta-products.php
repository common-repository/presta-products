<?php
/**
 * Plugin Name:         Presta Products
 * Plugin URI:          https://www.guillaume-bouaud.fr/produit/presta-products-for-wordpress  
 * Description:         Affichage des produits Prestashop sur le site internet généré par Wordpress.
 * Version:             1.1.27
 * Requires at least:   5.2
 * Requires PHP:        7.2
 * Author Name:         Guillaume BOUAUD (gbouaud@gmail.com)  
 * Author:              Guillaume BOUAUD  
 * Author URI:          https://www.guillaume-bouaud.fr 
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:         /languages  
 * Text Domain:         presta-products 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PrestaProducts 
{
    // Variables
    private $is_freemium;
    
    // Constructeur
    public function __construct()
    {
        // Traductions
        function ppgbo_plugin_init() {
            load_plugin_textdomain( 'presta-products', false, 'presta-products/languages' );
        }
        add_action('init', 'ppgbo_plugin_init');
		add_action( 'admin_enqueue_scripts', array( $this, 'ppgbo_enqueue' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'ppgbo_admin_enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ppgbo_styleAndScript' ) );
        
        // Première configuration
        add_option( 'ppgbo_obfuscation', 0 );
        add_option( 'ppgbo_price_display', 1 );
        add_option( 'ppgbo_oldprice_display', 1 );
        add_option( 'ppgbo_description_display', 0 );
        add_option( 'ppgbo_description_short_display', 1 );
        add_option( 'ppgbo_image_display', 1 );
        add_option( 'ppgbo_image_display_hover', 0 );
        add_option( 'ppgbo_name_display', 1 );
        add_option( 'ppgbo_balise_title', 'h4' );
        add_option( 'ppgbo_counter_line', 3 );
        add_option( 'ppgbo_css_custom', '' );
        add_option( 'ppgbo_hide_inactive', 0 );
        add_option( 'ppgbo_hide_available', 0 );
        add_option( 'ppgbo_on_sale', 0 );
        add_option( 'ppgbo_description_short_size', 90 );
        add_option( 'ppgbo_description_size', 150 );
        add_option( 'ppgbo_template_product', 1 );
        add_option( 'ppgbo_message', '' );
        add_option( 'ppgbo_new_tab', 1 );
        // GBO - 1.1.4
        add_option( 'ppgbo_hide_visibility', 0 );
        add_option( 'ppgbo_counter_freemium', 0 );
        add_option( 'ppgbo_use_cache', 0 );
        // GBO - 1.1.5
        add_option( 'ppgbo_image_format', 'medium' );
        // GBO - 1.1.6
        add_option( 'ppgbo_btn_goto_product', 0 );
        // GBO - 1.1.11
        add_option( 'ppgbo_navigation_carrousel', 'arrows' );
        add_option( 'ppgbo_arrows_carrousel', 1 );
        add_option( 'ppgbo_dots_carrousel', 1 );
        // GBO - 1.1.15
        add_option( 'ppgbo_hide_stock', 0 );
        // PREMIUM Options
        add_option( 'ppgbo_prestashop_webservice', '' );
        add_option( 'ppgbo_prestashop_url', '' );
        add_option( 'ppgbo_premium_key', '' );
        add_option( 'ppgbo_premium_userId', '' );
        
        // Création de la table MYQSL
        $this->ppgbo_install_mysql();
        
        // Ajoute un lien dans le menu
        add_action( 'admin_menu', [ $this, 'ppgbo_plugin_menu'] ); 
        
        // Ajoute les shortcodes
        add_action('init', 'shortcodes_init');
        
        // Sur la partie administrive du Back Office, gestion de la clé
        if ( is_admin() ) {
            $this->is_freemium = ($this->freemium(get_option( 'ppgbo_premium_key' ))) ? 1 : 0;
            $counterFreemium = get_option( 'ppgbo_counter_freemium' );
            
            // Si la clé est OK
            if ($this->is_freemium) {
                update_option( 'ppgbo_counter_freemium', 0);
            }
            // Securité si la clé n'est pas OK et 5 connexions échouées
            else if (!$this->is_freemium && $counterFreemium >= 5) {
                update_option( 'ppgbo_oldprice_display', '' );   
                update_option( 'ppgbo_description_display', '' ); 
                update_option( 'ppgbo_image_display_hover', '' ); 
                update_option( 'ppgbo_balise_title', '' );   
                update_option( 'ppgbo_counter_line', '' ); 
                update_option( 'ppgbo_hide_available', 0 );
                update_option( 'ppgbo_hide_visibility', 0 );
                update_option( 'ppgbo_hide_stock', 0 );
                update_option( 'ppgbo_on_sale', '' );   
                update_option( 'ppgbo_description_short_size', '' );   
                update_option( 'ppgbo_description_size', '' ); 
                update_option( 'ppgbo_template_product', '' ); 
                update_option( 'ppgbo_navigation_carrousel', '' ); 
                update_option( 'ppgbo_arrows_carrousel', '' ); 
                update_option( 'ppgbo_dots_carrousel', '' ); 
                update_option( 'ppgbo_new_tab', '1' ); 
                update_option( 'ppgbo_use_cache', 0);
            }
            // Si on est à moins de 5 connexions échouées vers le serveur
            else {
                $this->is_freemium = 1;
                update_option( 'ppgbo_counter_freemium', (intval($counterFreemium) + 1));
            }
        }
        
        // Fonction de récupération des produits depuis le site prestashop
        function ppgbo_get_products_from_prestashop($atts) {
            $prestashop_url     = get_option( 'ppgbo_prestashop_url' );
            $webservice_key     = get_option( 'ppgbo_prestashop_webservice' );
            $hide_inactive      = get_option( 'ppgbo_hide_inactive' );
            $hide_available     = get_option( 'ppgbo_hide_available' );
            $hide_visibility    = get_option( 'ppgbo_hide_visibility' );
            $hide_stock         = get_option( 'ppgbo_hide_stock' );
                
            // Limitation du nombre de produits
            $limit = (isset($atts['counter'])) ? $atts['counter'] : 5;
            
            // Initialisation du tableau des produits
            $products = array();
    
	        // GBO - 1.1.21
			// Gestion Bestsellers
            if (isset($atts['bestsellers'])) {
                // Nombre de jours en arrière
                $days   = (isset($atts['bestsellers']) && intval($atts['bestsellers'])) ? $atts['bestsellers'] : 10;
                $today  = date('Y-m-d');
                $back   = date('Y-m-d', time() - ($days * 24 * 60 * 60));
                
                // Appel HTTP API
                $link       = $prestashop_url . '/api/orders/?filter[date_add]=[' . $back . ',' . $today . ']&display=full&date=1&ws_key=' . $webservice_key . '&output_format=JSON';
                $response   = wp_remote_get( $link );
                $body       = wp_remote_retrieve_body( $response );
                $http_code  = wp_remote_retrieve_response_code( $response );
                
                if ($http_code == '200') {
                    // Produit (format JSON > Array)
                    $result     = json_decode($body);
                    $_products  = array();

                    // Parcours des lignes
                    foreach ($result->orders as $element) {
                        foreach ($element->associations->order_rows as $row) {
                            $_products[$row->product_id] = intval($_products[$row->product_id]) + 1;
                        }
                    }
                    
                    // Fonctions de traitement du tableau
                    arsort($_products);
                    //$_products = array_keys($_products);
					
					// Si un 2ème paramètre en plus de bestsellers
					if (isset($atts['product'])) {
						if (array_key_exists($atts['product'], $_products)) {
                			$url[] = $prestashop_url . '/api/products/' . $atts['product'] . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
						}
					}
					else if (isset($atts['products'])) {
                		$ids = explode(',', $atts['products']);
                
                		foreach ($ids as $id) {
							if (array_key_exists($id, $_products)) {
                				$url[] = $prestashop_url . '/api/products/' . $id . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
							}
						}
					}
					else if (isset($atts['category'])) {
		                // Appel HTTP API
		                $link       = $prestashop_url . '/api/products/?filter[id_category_default]=[' . $atts['category'] . ']&ws_key=' . $webservice_key . '&output_format=JSON';
		                $response   = wp_remote_get( $link );
		                $body       = wp_remote_retrieve_body( $response );
		                $http_code  = wp_remote_retrieve_response_code( $response );
            
		                if ($http_code == '200') {
		                    // Produit (format JSON > Array)
		                    $result = json_decode($body);

		                    foreach ($result->products as $element) {
								if (array_key_exists($element->id, $_products)) {
									$url[] = $prestashop_url . '/api/products/' . $element->id . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
								}
		                    }
		                }
					}
					else if (isset($atts['categories'])) {
		                $ids = explode(',', $atts['categories']);
                
		                foreach ($ids as $id) {
		                    // Appel HTTP API
		                    $link       = $prestashop_url . '/api/products/?filter[id_category_default]=[' . $id . ']&ws_key=' . $webservice_key . '&output_format=JSON';
		                    $response   = wp_remote_get( $link );
		                    $body       = wp_remote_retrieve_body( $response );
		                    $http_code  = wp_remote_retrieve_response_code( $response );
                
		                    if ($http_code == '200') {
		                        // Produit (format JSON > Array)
		                        $result = json_decode($body);
    
		                        foreach ($result->products as $element) {
									if (array_key_exists($element->id, $_products)) {
		                            	$url[] = $prestashop_url . '/api/products/' . $element->id . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
									}
		                        }
		                    }
		                }
					}
                    else {
                    	// Fonctions de traitement du tableau
                   	 	array_splice($_products, $limit);

                   		// Récupération produit
                    	foreach ($_products as $element) {
                        	$url[] = $prestashop_url . '/api/products/' . $element . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
                    	}
					}

                	// Fonctions de traitement du tableau
               	 	array_splice($url, $limit);
                }
            }
            // 1 produit
            else if (isset($atts['product'])) {
                $url[] = $prestashop_url . '/api/products/' . $atts['product'] . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
            }
            // Plusieurs produits
            else if (isset($atts['products'])) {
                $ids = explode(',', $atts['products']);
                
                foreach ($ids as $id) {
                    $url[] = $prestashop_url . '/api/products/' . $id . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
                }
            }
            // Catégorie
            else if (isset($atts['category'])) {
                // Appel HTTP API
                $link       = $prestashop_url . '/api/products/?filter[id_category_default]=[' . $atts['category'] . ']&limit=' . $limit . '&ws_key=' . $webservice_key . '&output_format=JSON';
                $response   = wp_remote_get( $link );
                $body       = wp_remote_retrieve_body( $response );
                $http_code  = wp_remote_retrieve_response_code( $response );
            
                if ($http_code == '200') {
                    // Produit (format JSON > Array)
                    $result = json_decode($body);

                    foreach ($result->products as $element) {
                        $url[] = $prestashop_url . '/api/products/' . $element->id . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
                    }
                }
            }
            // Plusieurs catégories
            else if (isset($atts['categories'])) {
                $ids = explode(',', $atts['categories']);
                
                foreach ($ids as $id) {
                    // Appel HTTP API
                    $link       = $prestashop_url . '/api/products/?filter[id_category_default]=[' . $id . ']&limit=' . $limit . '&ws_key=' . $webservice_key . '&output_format=JSON';
                    $response   = wp_remote_get( $link );
                    $body       = wp_remote_retrieve_body( $response );
                    $http_code  = wp_remote_retrieve_response_code( $response );
                
                    if ($http_code == '200') {
                        // Produit (format JSON > Array)
                        $result = json_decode($body);
    
                        foreach ($result->products as $element) {
                            $url[] = $prestashop_url . '/api/products/' . $element->id . '?price[my_price][use_tax]=1&price[old_price][only_reduction]=1&ws_key=' . $webservice_key . '&output_format=JSON';
                        }
                    }
                }
            }
			
			// V1.1.19 - BEGIN - Ajout de la gestion WPML
			// WPML : Récupération des langues de Prestashop. Nécessite le Webservice "languages"
			$wpml_languages = apply_filters( 'wpml_active_languages', null );
			if (isset($wpml_languages) && !is_null($wpml_languages) && !empty($wpml_languages)) {
				foreach($wpml_languages as $languages) {
                    if ($languages['active']) { 
                        $langue_actuel 	= $languages['language_code'];//default_locale']; 
                        break; 
                    }
                }
				$link           = $prestashop_url . '/api/languages/?display=[id,iso_code]&ws_key=' . $webservice_key . '&output_format=JSON';
				$response       = wp_remote_get( $link );
				$body           = wp_remote_retrieve_body( $response );
				$http_code      = wp_remote_retrieve_response_code( $response );
				
				if ($http_code == '200') {
					$prest_languages = json_decode($body);
				}
			}
			// V1.1.19 - END
            
			// Polylang : Récupération des langues de Prestashop. Nécessite le Webservice "languages"
			if (function_exists('pll_current_language')) {
				$langue_actuel  = pll_current_language('slug');
				$link           = $prestashop_url . '/api/languages/?display=[id,iso_code]&ws_key=' . $webservice_key . '&output_format=JSON';
				$response       = wp_remote_get( $link );
				$body           = wp_remote_retrieve_body( $response );
				$http_code      = wp_remote_retrieve_response_code( $response );
				
				if ($http_code == '200') {
					$prest_languages = json_decode($body);
				}
			}
			
			// Si l'utilisateur force la langue
			if (isset($atts['language'])) {
			    $langue_actuel 	= $atts['language'];
				$link           = $prestashop_url . '/api/languages/?display=[id,iso_code]&ws_key=' . $webservice_key . '&output_format=JSON';
				$response       = wp_remote_get( $link );
				$body           = wp_remote_retrieve_body( $response );
				$http_code      = wp_remote_retrieve_response_code( $response );
				
				if ($http_code == '200') {
					$prest_languages = json_decode($body);
				}
			}
            
            // Récupération des produits
            foreach ($url as $link) {
                // Appel HTTP API
                $response   = wp_remote_get( $link );
                $body       = wp_remote_retrieve_body( $response );
                $http_code  = wp_remote_retrieve_response_code( $response );
            
                if ($http_code == '200') {
                    // Produit (format JSON > Array)
                    $product = json_decode($body);
                    
                    // Si le produit est trouvé, on l'ajoute au tableau des produits
                    if (isset($product->product)) {
                        // Si on veut cacher des produits
                        if (isset($product->product->active) && $product->product->active == 0 && $hide_inactive) {
                            continue;
                        }
                        else if (isset($product->product->available_for_order) && $product->product->available_for_order == 0 && $hide_available) {
                            continue;
                        }
                        else if (isset($product->product->visibility) && $product->product->visibility == 'none' && $hide_visibility) {
                            continue;
                        }
                        else if (isset($product->product->quantity) && $product->product->quantity <= 0 && $hide_stock) {
                            continue;
                        }
                        
                        // Génération de l'URL produit
                        $url_rewrite            = $prestashop_url . '/index.php?controller=product&id_product=' . $product->product->id;
                        $url_rewrite_element    = wp_remote_head($url_rewrite);
                        
                        // Récupération de la redirection par les méthodes WP
						if (is_array($url_rewrite_element) && isset($url_rewrite_element['headers']) && isset($url_rewrite_element['headers']['location'])) {
						    $product->url_rewrite = $url_rewrite_element['headers']['location'];
						}
						
						// Récupération de la redirection par les fonctions PHP (si la précédente n'a pas marché)
						if (empty($product->url_rewrite) || !isset($product->url_rewrite)) {
						    $get_headers = get_headers($url_rewrite, 1);
						    
						    if (isset($get_headers['Location'])) {
							    $product->url_rewrite = $get_headers['Location'];
						    }
						}
						
						// Si les fonctions WP et PHP ne fonctionnent pas, on essaie le curl
						if (empty($product->url_rewrite) || !isset($product->url_rewrite)) {
					        // Initialisation du curl
					        $ch = curl_init();
					        
					        // Paramètres du curl
                            curl_setopt($ch, CURLOPT_URL, $url_rewrite);
                            curl_setopt($ch, CURLOPT_HEADER, true);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            
                            // Exécution du curl
                            $a = curl_exec($ch);
                            $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                            
                            // Récupération de l'url
                            $product->url_rewrite = $url;
						}
						
						// Gestion de la langue par défaut
						$id_lang = 1;
												
						// Gestion de la langue avec Polylang OU WPML
						if (isset($prest_languages) and !empty($prest_languages) and is_array($prest_languages->languages) and count($prest_languages->languages) > 0) {
							foreach($prest_languages->languages as $key => $prest_language) {
								if ($prest_language->iso_code == $langue_actuel) {									
							        $id_lang = (int) $prest_language->id; 
							        break;
							    } 
							}
						}
						
						if (is_array($product->product->name) && count($product->product->name) > 0) {
							foreach ($product->product->name as $key => $name) { 
							    if ($name->id == $id_lang) { 
							        $keyToSave = $key; 
							        break;
							    } 
							}
							
							$product->product->name                 = $product->product->name[$keyToSave]->value;
							$product->product->description          = $product->product->description[$keyToSave]->value;
							$product->product->description_short    = $product->product->description_short[$keyToSave]->value;
							// V1.1.19 - BEGIN - Gestion du lien produit dans la langue également
							$product->product->link_rewrite         = (isset($product->product->link_rewrite) && !empty($keyToSave) && isset($product->product->link_rewrite[$keyToSave])) ? $product->product->link_rewrite[$keyToSave]->value : '';
							$product->product->url_rewrite          = (isset($product->product->url_rewrite) && !empty($keyToSave) && isset($product->product->url_rewrite[$keyToSave])) ? $product->product->url_rewrite[$keyToSave]->value : '';
							// V1.1.19 - END
						}
						
                        // URL par défaut (si aucune redirection n'est trouvée)
						if (empty($product->url_rewrite) || !isset($product->url_rewrite) || isset($atts['language'])) { // !empty($product->product->link_rewrite)
						    if (is_array($product->product->link_rewrite) && count($product->product->link_rewrite) > 0) {
						        $link_rewrite = $product->product->link_rewrite[0]->value;
						    }
						    else {
						        $link_rewrite = $product->product->link_rewrite;
						    }
						    
							$product->url_rewrite = $prestashop_url . '/' . (($atts['language']) ? $atts['language'] . '/' : '') . $product->product->id . ((isset($product->product->id_default_combination) && !empty($product->product->id_default_combination)) ? '-' . $product->product->id_default_combination : '' ) . '-' . $link_rewrite .'.html';
						}
						
                        $products[] = $product;
                    }
                }
            }
            
            return $products;
        }
        
        // Fonction qui récupère les produits depuis le cache (base de donnée wordpress)
        function ppgbo_get_products_from_cache($atts) {
            global $wpdb;
    
            $products   = array();
            $myTable    = $wpdb->prefix.'ppgbo_cache';
            $sql        = $wpdb->prepare("SELECT * FROM $myTable WHERE shortcode = '%s'", $atts); 
            $elements   = $wpdb->get_results($sql);
            
            foreach ($elements as $element) {
                $products = json_decode($element->datas);
            }
            
            return $products;
        }
    
        // RAZ du cache
        function ppgbo_raz_cache() {
            global $wpdb;
            
            // Réinit la base
            $myTable    = $wpdb->prefix.'ppgbo_cache';
            $sql        = $wpdb->prepare("TRUNCATE TABLE %i", $myTable); 
            $wpdb->query($sql) or wp_die(__( 'Problème de réinitialisation du cache.', 'presta-products' ));
            
            echo __( 'Données supprimées.', 'presta-products' );
                    
            // On arrête l'ajax
            wp_die();
        }
        
        add_action( 'wp_ajax_raz', 'ppgbo_raz_cache' );
    
        // MAJ du cache
        function ppgbo_maj_cache() {
            global $wpdb;
            
            // Réinit la base
            $myTable    = $wpdb->prefix.'ppgbo_cache';
            $sql        = $wpdb->prepare("TRUNCATE TABLE %i", $myTable); 
            $wpdb->query($sql);
            
            // Récupération des articles et pages
            $posts = get_posts(array('posts_per_page' => -1, 'post_status' => array('publish', 'draft', 'pending')));
	        $pages = get_pages(array('post_status' => array('publish', 'draft', 'pending')));
	        
	        // V1.1.27 : ajout
	        // Chemin du fichier functions.php du thème en cours
            $functions_file = get_template_directory() . '/functions.php';
            
	        // V1.1.27 : ajout
            // Lire le contenu du fichier functions.php
            $functions_content[] = (object) array('post_content' => file_get_contents($functions_file));
            
	        // V1.1.27 : ajout de $functions_content
            // Parcours pour obtenir les shortcodes
            foreach (array_merge($posts, $pages, $functions_content) as $post) {
                // Si le shortcode est trouvé
                if (preg_match_all('/^(.*)(\[ppgbo[a-zA-Z0-9=",\s]+\])(.*)$/misU', $post->post_content, $matched)) {
                    // Parcours des données
                    foreach ($matched[2] as $match) {
                        // Initialisation
                        $params     = array();
                        $products   = array();
                        $datas      = "";
                        
                        // Récupération des paramètres
                        $attributes = explode(' ', $match);
                        unset($attributes[0]);
                        
                        // Parcours des données
                        foreach ($attributes as $attribute) {
                            $param              = explode('=', $attribute);
                            $params[$param[0]]  = preg_replace('/]/', '', preg_replace('/"/', '', $param[1]));
                        }
            
						// Vérification qu'il n'est pas déjà présent en base
                        $myTable    = $wpdb->prefix.'ppgbo_cache';
                        $sql0       = $wpdb->prepare("SELECT id FROM $myTable WHERE shortcode = '%s'", json_encode($params));
           			 	$elements   = $wpdb->get_results($sql0);
						
						// Si non présent, on ajoute
            			if (count($elements) == 0) {
                        	// Récupération des produits
                        	$datas = ppgbo_get_products_from_prestashop($params);
                        
                        	foreach ($datas as $data) {
                        		$products[] = array('url' => $data->url_rewrite, 'name' => $data->product->name);
                        	}
                        
                        	// Requête SQL d'ajout
                            $myTable    = $wpdb->prefix.'ppgbo_cache';
                            $sql1       = $wpdb->prepare("INSERT IGNORE INTO $myTable (shortcode, datas, products) VALUES ('%s', '%s', '%s')", json_encode($params), json_encode($datas), json_encode($products));
                    	    $result     = $wpdb->query($sql1);
                           
                            // Si problème d'enregistrement (false = problem, 0 peut être le nombre de lignes créées (ignore into))
                            if ($result === false) {
                               wp_die(__( 'Problème d\'enregistrement de la donnée.', 'presta-products' ));
                            }
						}
                    }
                }
            }
            
            echo __( 'Données enregistrées en cache.', 'presta-products' );
                    
            // On arrête l'ajax
            wp_die();
        }
        
        add_action( 'wp_ajax_maj', 'ppgbo_maj_cache' );
	
	    // Fonctions de tri
    	function orderIdAsc($a, $b){
            return $a->product->id > $b->product->id;
        }
    	function orderIdDesc($a, $b){
            return $a->product->id < $b->product->id;
        }
    	function orderPriceAsc($a, $b){
            return $a->product->price > $b->product->price;
        }
    	function orderPriceDesc($a, $b){
            return $a->product->price < $b->product->price;
        }
    	function orderDateAsc($a, $b){
            return $a->product->date_add > $b->product->date_add;
        }
    	function orderDateDesc($a, $b){
            return $a->product->date_add < $b->product->date_add;
        }
    	function orderStockAsc($a, $b){
            return $a->product->quantity > $b->product->quantity;
        }
    	function orderStockDesc($a, $b){
            return $a->product->quantity < $b->product->quantity;
        }

        // Fonction de changement des shortcodes
        function shortcodes_init()
        {
            add_shortcode( 'ppgbo', 'display_product_function' );
            
            function display_product_function($atts, $content = null, $tags = '') 
            {
                // Si pas un des champs obligatoire, on passe
                if (!isset($atts['product']) && !isset($atts['products']) && !isset($atts['category']) && !isset($atts['categories']) && !isset($atts['bestsellers'])) 
                {
                    return "";    
                }
                
                // Limitation du nombre de produits
                $limit = (isset($atts['counter'])) ? $atts['counter'] : 5;
        
                // Récupération des options
                $prestashop_url             = get_option( 'ppgbo_prestashop_url' );
                $webservice_key             = get_option( 'ppgbo_prestashop_webservice' );
                $display_image              = get_option( 'ppgbo_image_display' );
                $display_image_hover        = get_option( 'ppgbo_image_display_hover' );
                $display_name               = get_option( 'ppgbo_name_display' );
                $display_description        = get_option( 'ppgbo_description_display' );
                $display_short_description  = get_option( 'ppgbo_description_short_display' );
                $display_price              = get_option( 'ppgbo_price_display' );
                $display_oldprice           = get_option( 'ppgbo_oldprice_display' );
                $obfuscation                = get_option( 'ppgbo_obfuscation' );
                $new_tab                    = get_option( 'ppgbo_new_tab' );
                $hide_inactive              = get_option( 'ppgbo_hide_inactive' );
                $hide_available             = get_option( 'ppgbo_hide_available' );
                $hide_visibility            = get_option( 'ppgbo_hide_visibility' );
                $hide_stock                 = get_option( 'ppgbo_hide_stock' );
                $balise_title               = strtolower(get_option( 'ppgbo_balise_title' ));
                $counter_line               = strtolower(get_option( 'ppgbo_counter_line' ));
                $css_custom                 = get_option( 'ppgbo_css_custom' );
                $on_sale                    = get_option( 'ppgbo_on_sale' );
                $image_format               = get_option( 'ppgbo_image_format' );
                $description_short_size     = get_option( 'ppgbo_description_short_size' );
                $description_size           = get_option( 'ppgbo_description_size' );
                $template_product           = get_option( 'ppgbo_template_product' );
                $use_cache                  = get_option( 'ppgbo_use_cache' );
                $btn_goto_product           = get_option( 'ppgbo_btn_goto_product' );
                $navigation_carrousel       = get_option( 'ppgbo_navigation_carrousel' );
                $arrows_carrousel           = get_option( 'ppgbo_arrows_carrousel' );
                $dots_carrousel             = get_option( 'ppgbo_dots_carrousel' );

                // Obfuscation forcée
                $obfuscation = (isset($atts['obfuscation']) && in_array($atts['obfuscation'], array(0,1))) ? $atts['obfuscation'] : $obfuscation;
                
                // Valeurs par défaut
                if (empty($balise_title) || !in_array($balise_title, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div'))) {
                    $balise_title = 'h4';
                }
                if (empty($counter_line) || !intval($counter_line) || !in_array($counter_line, array(1,2,3,4,6))) {
                    $counter_line = 3;
                }
                if (empty($description_short_size) || !intval($description_short_size)) {
                    $description_short_size = 90;
                }
                if (empty($description_size) || !intval($description_size)) {
                    $description_size = 150;
                }
                if (empty($template_product) || !intval($template_product) || !in_array($template_product, array(1,2,3))) {
                    $template_product = 1;
                }
                if (empty($image_format) || !in_array($image_format, array('small', 'medium', 'large', 'home', 'cart'))) {
                    $image_format = 'medium';
                }
                if (empty($navigation_carrousel) || !in_array($navigation_carrousel, array('arrows', 'dots', 'both'))) {
                    $navigation_carrousel = 'arrows';
                }
                if (empty($arrows_carrousel)) {
                    $arrows_carrousel = 1;
                }
                if (empty($dots_carrousel)) {
                    $dots_carrousel = 1;
                }
                    
                // Si les données prestashop ne sont pas renseignées, on passe
                if (empty($prestashop_url) || empty($webservice_key)) 
                {
                    return "";    
                }
                
                // Tableau des produits
                $products = array();
                
                // Si on utilise la gestion du cache
                if ($use_cache) {
                    $products = ppgbo_get_products_from_cache(json_encode($atts));
                }
                // Sinon on récupère depuis le prestashop
                else {
                    $products = ppgbo_get_products_from_prestashop($atts);
                }
                
                // Si pas de produits, on passe
                if (empty($products)) {
                    return "";
                }
                
                // Gestion du tri (ID, PRICE, DATE, STOCK, RANDOM)
                if (isset($atts['sort']) && !empty($atts['sort'])) {
                    switch (strtoupper($atts['sort'])) {
                        case 'RANDOM':
                            shuffle($products);
                            break;
                        case 'ID,DESC':
                            usort($products, orderIdDesc);
                            break;
                        case 'PRICE':
                        case 'PRICE,ASC':
                            usort($products, orderPriceAsc);
                            break;
                        case 'PRICE,DESC':
                            usort($products, orderPriceDesc);
                            break;
                        case 'DATE':
                        case 'DATE,ASC':
                            usort($products, orderDateAsc);
                            break;
                        case 'DATE,DESC':
                            usort($products, orderDateDesc);
                            break;
                        case 'STOCK':
                        case 'STOCK,ASC':
                            usort($products, orderStockAsc);
                            break;
                        case 'STOCK,DESC':
                            usort($products, orderStockDesc);
                            break;
                        case 'ID':
                        case 'ID,ASC':
                        default:
                            usort($products, orderIdAsc);
                            break;
                    }
                }
                
                // Mise en cache pour obtenir le template produit
                ob_start();
                $template = 'product-' . $template_product;
                
                if (isset($atts['mode']) && $atts['mode'] == 'carrousel') {
                    $template   = 'carrousel';
                    $arrow      = array(
                        1 => array(
                            'left' => 'arrow-left-circle.svg',
                            'right' => 'arrow-right-circle.svg',
                        ),
                        2 => array(
                            'left' => 'arrow-left-square.svg',
                            'right' => 'arrow-right-square.svg',
                        ),
                        3 => array(
                            'left' => 'arrow-left.svg',
                            'right' => 'arrow-right.svg',
                        ),
                        4 => array(
                            'left' => 'caret-left.svg',
                            'right' => 'caret-right.svg',
                        ),
                    );
                    $dot = array(
                        1 => 'circle-fill.svg',
                        2 => 'circle.svg',    
                    );
                    $svg_left               = plugins_url( 'assets/images/' . $arrow[$arrows_carrousel]['left'], __FILE__ );
                    $svg_right              = plugins_url( 'assets/images/' . $arrow[$arrows_carrousel]['right'], __FILE__ );
                    $dots_svg               = plugins_url( 'assets/images/' . $dot[$dots_carrousel], __FILE__ );
                    $dots_svg_active        = plugins_url( 'assets/images/' . $dot[3 - intval($dots_carrousel)], __FILE__ );
                    $autoplay               = (isset($atts['autoplay'])) ? ((is_numeric($atts['autoplay']) && $atts['autoplay'] > 2000) ? $atts['autoplay'] : 5000) : 0;
                    $counter_line_carrousel = (isset($atts['number'])) ? $atts['number'] : 0;
                    $width                  = (isset($atts['width'])) ? $atts['width'] : '';
                    
                    if (empty($counter_line_carrousel) || !intval($counter_line_carrousel) || !in_array($counter_line_carrousel, array(1,2,3,4,6))) {
                        $counter_line_carrousel = 0;
                    }
                }
                
                include('includes/product/' . $template . '.php');
                $contents = ob_get_contents();
                ob_end_clean();
                
                // Retourne le résultat
                return $contents;
            }
        }
		
        // Ajout de la fonction pour afficher le sous menu
        function presta_product_g_highlight_submenu($parent_file){
            global $submenu_file;
            
            if (isset($_GET['page']) && isset($_GET['tab'])) {
                $submenu_file = sanitize_text_field($_GET['page']) . '&tab=' . sanitize_text_field($_GET['tab']);
            }

            return $parent_file;
        }
        add_filter('parent_file', 'presta_product_g_highlight_submenu');
    
    }
    
    // Ajoute le menu en question
    public function ppgbo_plugin_menu()
    {
        add_menu_page(
	        __('Presta Products for WordPress', 'presta-products'), // Page title
	        __('Presta Products for WordPress', 'presta-products'), // Menu title
	        'manage_options',  // Capability
	        'presta-products', // Slug
	        [ &$this, 'load_ppgbo_plugin_page'], // Callback page function
	        'dashicons-products' // Icon
	    );
	    
	    // Sous menus
        add_submenu_page(
            'presta-products', 
            __( 'Options générales', 'presta-products' ), 
            __( 'Options générales', 'presta-products' ), 
            'manage_options', 
            'presta-products&tab=options',
			'options_page'
        );
        add_submenu_page(
            'presta-products', 
            __( 'Fonctionnalités', 'presta-products' ), 
            __( 'Fonctionnalités', 'presta-products' ), 
            'manage_options', 
            'presta-products&tab=features',
			'features_page'
        );
        add_submenu_page(
            'presta-products', 
            __( 'Documentation', 'presta-products' ), 
            __( 'Documentation', 'presta-products' ), 
            'manage_options', 
            'presta-products&tab=examples',
			'examples_page'
        );
        
        if ($this->is_freemium) {
            add_submenu_page(
                'presta-products', 
                __( 'Cache', 'presta-products' ), 
                __( 'Cache', 'presta-products' ), 
                'manage_options', 
                'presta-products&tab=cache',
				'cache_page'
            );
            add_submenu_page(
                'presta-products', 
                __( 'Utilisé sur', 'presta-products' ), 
                __( 'Utilisé sur', 'presta-products' ), 
                'manage_options', 
                'presta-products&tab=used',
				'used_page'
            );
        }
    }
    
    // Récupération de la clé
    private function freemium($key) {
        require_once('includes/config.php');
        
        // URL de récupération de la clé
        $link       = base64_decode($prefix) . base64_decode($licence) . $key . '?consumer_key=' . base64_decode($consumer) . '&consumer_secret=' . base64_decode($secret);

        // HTTP API
        $response   = wp_remote_get( $link );
        $body       = wp_remote_retrieve_body( $response );
        //$http_code  = wp_remote_retrieve_response_code( $response );
        
        //if ($http_code == '200') {
            // Produit (format JSON > Array)
            $result     = json_decode($body);
            
            // Si on est OK
            if (isset($result) && !empty($result) && isset($result->success) && isset($result->data) && isset($result->data->productId) && isset($result->data->status) && isset($result->data->userId) && $result->data->productId == base64_decode($product) && in_array($result->data->status, array(2,3)) && $result->data->userId == $userId) {
                return true;
            }
        //}
        
        // Sinon
        return false;
    }
    
    // Page d'administration du module
    public function load_ppgbo_plugin_page() 
    { 
        // Sécurité : si on est sur le back office
        if ( is_admin() ) {
            // Formulaire des options
            if (isset($_POST['type']) && $_POST['type'] == 'options') {
                $webservice_key = sanitize_text_field($_POST['webservice_key']);
                $url            = sanitize_text_field($_POST['url']);
                $premium        = sanitize_text_field($_POST['premium']);
                $userId         = sanitize_text_field($_POST['premium_user_id']);
                
                // Vérification URL (suppression du slash à la fin)
                if (substr($url, -1) == '/') {
                    $url = substr($url, 0, -1);
                }
                
                // Ajout de l'option clé webservice (si elle n'existe pas)
                if (add_option( 'ppgbo_prestashop_webservice', $webservice_key ) === false) {
                    // Sinon mise à jour de l'option
                    update_option( 'ppgbo_prestashop_webservice', $webservice_key );
                }
                
                // Ajout de l'option URL (si elle n'existe pas)
                if (add_option( 'ppgbo_prestashop_url', $url ) === false) {
                    // Sinon mise à jour de l'option
                    update_option( 'ppgbo_prestashop_url', $url ); 
                }
                
                // Ajout de l'option PREMIUM (si elle n'existe pas)
                if (add_option( 'ppgbo_premium_key', $premium ) === false) {
                    // Sinon mise à jour de l'option
                    update_option( 'ppgbo_premium_key', $premium );   
                }
                
                // Ajout de l'option PREMIUM (si elle n'existe pas)
                if (add_option( 'ppgbo_premium_userId', $userId ) === false) {
                    // Sinon mise à jour de l'option
                    update_option( 'ppgbo_premium_userId', $userId ); 
                }   
                    
                // Gestion du message d'information
                update_option( 'ppgbo_message', __('Configuration enregistrée.', 'presta-products') );
            }
            // Formulaire des fonctionnalités
            else if (isset($_POST['type']) && $_POST['type'] == 'features') {
                $obfuscation                = (isset($_POST['obfuscation'])) ? 1 : 0;
                $new_tab                    = (isset($_POST['new_tab'])) ? 1 : 0;
                $name_display               = (isset($_POST['name_display'])) ? 1 : 0;
                $image_display              = (isset($_POST['image_display'])) ? 1 : 0;
                $image_display_hover        = (isset($_POST['image_display_hover'])) ? 1 : 0;
                $price_display              = (isset($_POST['price_display'])) ? 1 : 0;
                $oldprice_display           = (isset($_POST['oldprice_display'])) ? 1 : 0;
                $description_display        = (isset($_POST['description_display'])) ? 1 : 0;
                $description_short_display  = (isset($_POST['description_short_display'])) ? 1 : 0;
                $hide_inactive              = (isset($_POST['hide_inactive'])) ? 1 : 0;
                $hide_available             = (isset($_POST['hide_available'])) ? 1 : 0;
                $hide_visibility            = (isset($_POST['hide_visibility'])) ? 1 : 0;
                $hide_stock                 = (isset($_POST['hide_stock'])) ? 1 : 0;
                $on_sale                    = (isset($_POST['on_sale'])) ? 1 : 0;
                $btn_goto_product           = (isset($_POST['btn_goto_product'])) ? 1 : 0;              
                $image_format               = (isset($_POST['image_format'])) ? sanitize_text_field($_POST['image_format']) : '';
                $description_short_size     = (isset($_POST['description_short_size'])) ? sanitize_text_field($_POST['description_short_size']) : '';
                $description_size           = (isset($_POST['description_size'])) ? sanitize_text_field($_POST['description_size']) : '';
                $balise_title               = (isset($_POST['balise_title'])) ? sanitize_text_field($_POST['balise_title']) : '';
                $counter_line               = (isset($_POST['counter_line'])) ? sanitize_text_field($_POST['counter_line']) : '';
                $css_custom                 = (isset($_POST['css_custom'])) ? sanitize_text_field($_POST['css_custom']) : '';
                $template_product           = (isset($_POST['template_product'])) ? sanitize_text_field($_POST['template_product']) : '';
                $navigation_carrousel       = (isset($_POST['navigation_carrousel'])) ? sanitize_text_field($_POST['navigation_carrousel']) : '';
                $arrows_carrousel           = (isset($_POST['arrows_carrousel'])) ? sanitize_text_field($_POST['arrows_carrousel']) : '';
                $dots_carrousel             = (isset($_POST['dots_carrousel'])) ? sanitize_text_field($_POST['dots_carrousel']) : '';
    
                // Modification des options
                update_option( 'ppgbo_obfuscation', $obfuscation );   
                update_option( 'ppgbo_new_tab', $new_tab );   
                update_option( 'ppgbo_price_display', $price_display );  
                update_option( 'ppgbo_oldprice_display', $oldprice_display );   
                update_option( 'ppgbo_description_display', $description_display ); 
                update_option( 'ppgbo_description_short_display', $description_short_display );   
                update_option( 'ppgbo_image_display', $image_display ); 
                update_option( 'ppgbo_image_display_hover', $image_display_hover );   
                update_option( 'ppgbo_name_display', $name_display );   
                update_option( 'ppgbo_balise_title', $balise_title );   
                update_option( 'ppgbo_counter_line', $counter_line ); 
                update_option( 'ppgbo_css_custom', $css_custom );  
                update_option( 'ppgbo_hide_inactive', $hide_inactive ); 
                update_option( 'ppgbo_hide_available', $hide_available );
                update_option( 'ppgbo_hide_visibility', $hide_visibility );
                update_option( 'ppgbo_hide_stock', $hide_stock );
                update_option( 'ppgbo_on_sale', $on_sale );   
                update_option( 'ppgbo_image_format', $image_format ); 
                update_option( 'ppgbo_description_short_size', $description_short_size );   
                update_option( 'ppgbo_description_size', $description_size );   
                update_option( 'ppgbo_template_product', $template_product );  
                update_option( 'ppgbo_btn_goto_product', $btn_goto_product );  
                update_option( 'ppgbo_navigation_carrousel', $navigation_carrousel );
                update_option( 'ppgbo_arrows_carrousel', $arrows_carrousel );
                update_option( 'ppgbo_dots_carrousel', $dots_carrousel );
    
                // Gestion du message d'information
                update_option( 'ppgbo_message', __('Options enregistrées.', 'presta-products') );
            }
            // Formulaire du cache
            else if (isset($_POST['type']) && $_POST['type'] == 'cache') {
                $use_cache                  = (isset($_POST['use_cache'])) ? 1 : 0;
    
                // Modification des options
                update_option( 'ppgbo_use_cache', $use_cache );   
    
                // Gestion du message d'information
                update_option( 'ppgbo_message', __('Gestion du cache enregistrée.', 'presta-products') );
            }
            
            // Récupération des données
            $key                        = get_option( 'ppgbo_prestashop_webservice' );
            $premium                    = get_option( 'ppgbo_premium_key' );
            $userId                     = get_option( 'ppgbo_premium_userId' );
            $url                        = get_option( 'ppgbo_prestashop_url' );
            $obfuscation                = get_option( 'ppgbo_obfuscation' );
            $new_tab                    = get_option( 'ppgbo_new_tab' );
            $name_display               = get_option( 'ppgbo_name_display' );
            $image_format               = get_option( 'ppgbo_image_format' );
            $image_display              = get_option( 'ppgbo_image_display' );
            $image_display_hover        = get_option( 'ppgbo_image_display_hover' );
            $price_display              = get_option( 'ppgbo_price_display' );
            $oldprice_display           = get_option( 'ppgbo_oldprice_display' );
            $description_display        = get_option( 'ppgbo_description_display' );
            $description_short_display  = get_option( 'ppgbo_description_short_display' );
            $balise_title               = get_option( 'ppgbo_balise_title' );
            $counter_line               = get_option( 'ppgbo_counter_line' );
            $css_custom                 = get_option( 'ppgbo_css_custom' );
            $hide_inactive              = get_option( 'ppgbo_hide_inactive' );
            $hide_available             = get_option( 'ppgbo_hide_available' );
            $hide_visibility            = get_option( 'ppgbo_hide_visibility' );
            $hide_stock                 = get_option( 'ppgbo_hide_stock' );
            $on_sale                    = get_option( 'ppgbo_on_sale' );
            $use_cache                  = get_option( 'ppgbo_use_cache' );
            $description_short_size     = get_option( 'ppgbo_description_short_size' );
            $description_size           = get_option( 'ppgbo_description_size' );
            $template_product           = get_option( 'ppgbo_template_product' );
            $btn_goto_product           = get_option( 'ppgbo_btn_goto_product' );
            $navigation_carrousel       = get_option( 'ppgbo_navigation_carrousel' );
            $arrows_carrousel           = get_option( 'ppgbo_arrows_carrousel' );
            $dots_carrousel             = get_option( 'ppgbo_dots_carrousel' );
            $counter_freemium           = 5 - (get_option( 'ppgbo_counter_freemium' ));
            $freemium                   = $this->is_freemium;
            $page                       = (isset($_GET['tab']) && in_array($_GET['tab'], array('options', 'features', 'examples', 'used', 'cache'))) ? sanitize_text_field($_GET['tab']) : ((isset($_GET['tab']) && !in_array($_GET['tab'], array('options', 'features', 'examples', 'used', 'cache'))) ? '404' : 'options');
            $list                       = $this->ppgbo_getListing();
            $caches                     = $this->ppgbo_get_cache();
            $product_template_1         = plugins_url( 'assets/images/product-template-1.png', __FILE__ );
            $product_template_2         = plugins_url( 'assets/images/product-template-2.png', __FILE__ );
            $product_template_3         = plugins_url( 'assets/images/product-template-3.png', __FILE__ );
            $arrows_carrousel_left_1    = plugins_url( 'assets/images/arrow-left-circle.svg', __FILE__ );
            $arrows_carrousel_right_1   = plugins_url( 'assets/images/arrow-right-circle.svg', __FILE__ );
            $arrows_carrousel_left_2    = plugins_url( 'assets/images/arrow-left-square.svg', __FILE__ );
            $arrows_carrousel_right_2   = plugins_url( 'assets/images/arrow-right-square.svg', __FILE__ );
            $arrows_carrousel_left_3    = plugins_url( 'assets/images/arrow-left.svg', __FILE__ );
            $arrows_carrousel_right_3   = plugins_url( 'assets/images/arrow-right.svg', __FILE__ );
            $arrows_carrousel_left_4    = plugins_url( 'assets/images/caret-left.svg', __FILE__ );
            $arrows_carrousel_right_4   = plugins_url( 'assets/images/caret-right.svg', __FILE__ );
            $dots_carrousel_1           = plugins_url( 'assets/images/circle-fill.svg', __FILE__ );
            $dots_carrousel_2           = plugins_url( 'assets/images/circle.svg', __FILE__ );
            $script_cron                = plugin_dir_path( __FILE__ ) . plugin_dir_path( 'scripts/cron/crontab-presta-products.php' ) . 'crontab-presta-products.php';
            
            // Gestion du message d'information
            $message                    = get_option( 'ppgbo_message' );
            update_option( 'ppgbo_message', '' );
            
            // Affichage templates
            include 'includes/admin-header.php';
            include 'includes/tabs/form-options.php';
            include 'includes/tabs/form-features.php';
            include 'includes/tabs/examples.php';
            
            if ($this->is_freemium) { 
                include 'includes/tabs/cache.php';
                include 'includes/tabs/used.php';
            }
            
            include 'includes/tabs/404.php';
            
            include 'includes/admin-footer.php';
        }
    }
    
    // Récupération des posts et pages utilisant le shortcode
    public function ppgbo_getListing() {
		$elements = array();
        $posts = get_posts(array('posts_per_page' => -1, 'post_status' => array('publish', 'draft', 'pending')));
        $pages = get_pages(array('post_status' => array('publish', 'draft', 'pending')));
        
        foreach (array_merge($posts, $pages) as $post) {
            if (preg_match_all('/^(.*)(\[ppgbo[a-zA-Z0-9=",\s]+\])(.*)$/misU', $post->post_content, $matched)) {
                foreach ($matched[2] as $match) {
                    $elements[] = array(
                        'id'    => $post->ID,
                        'name'  => $post->post_title,
                        'slug'  => $post->guid,
                        'type'  => $post->post_type,
                        'ppgbo' => $match,
                    );
                }
            }
        }
        
        return $elements;
    } 
    
    // Appel aux fichiers assets
    public function ppgbo_enqueue() {       
        if (!isset($_GET['page']) || $_GET['page'] != 'presta-products') {
            return;
        }
        
        // JS Bootstrap
        wp_register_script('ppgbo_bootstrap', plugins_url( 'assets/javascript/bootstrap-5.1.3.bundle.min.js', __FILE__ ), false, true);
        wp_enqueue_script('ppgbo_bootstrap');
        
        // JS FileSaver
        wp_register_script('ppgbo_filesaver', plugins_url( 'assets/javascript/TableExport.min.js', __FILE__ ), false, true);
        wp_register_script('ppgbo_filesaver', plugins_url( 'assets/javascript/FileSaver.js', __FILE__ ), false, true);
        wp_enqueue_script('ppgbo_filesaver');
    
        // CSS Bootstrap
        wp_register_style('ppgbo_bootstrap', plugins_url( 'assets/css/bootstrap-5.1.3.min.css', __FILE__ ));
        wp_enqueue_style('ppgbo_bootstrap');
    }
    
    // Appel aux fichiers assets
    public function ppgbo_admin_enqueue() {      
        if (!isset($_GET['page']) || $_GET['page'] != 'presta-products') {
            return;
        }
        
        // JS Admin
        wp_register_script('ppgbo_admin', plugins_url( 'assets/javascript/ppgbo-admin.js', __FILE__ ), false, true, true);
        wp_localize_script('ppgbo_admin', 'ppgbo_ajax', array('url' => admin_url('admin-ajax.php')));
        wp_enqueue_script('ppgbo_admin');
    }
    
    // Appel aux fichiers assets
    public function ppgbo_styleAndScript() {       
        // CSS custom
        wp_register_style('ppgbo_custom', plugins_url( 'assets/css/ppgbo-custom.css', __FILE__ ));
        
        $css_custom = get_option( 'ppgbo_css_custom' );
        
        if ($css_custom !== false) {
            wp_add_inline_style('ppgbo_custom', $css_custom);
        }
        
        wp_enqueue_style('ppgbo_custom');
        
        // JS custom
        wp_register_script('ppgbo_custom', plugins_url( 'assets/javascript/ppgbo-custom.js', __FILE__ ), false, true);
        wp_enqueue_script('ppgbo_custom');
    }
    
    // Installation de la partie MySQL
    public function ppgbo_install_mysql() {
        // 1.1.16 : modification du type de DATAS de 'text' vers 'longtext'
        global $wpdb;
        $charset_collate = '';
        
       	if ( !empty($wpdb->charset) ) $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if ( !empty($wpdb->collate) ) $charset_collate .= " COLLATE $wpdb->collate";

        // Création de la table
        $simple_sql = "CREATE TABLE {$wpdb->prefix}ppgbo_cache (
                 id bigint(20) unsigned NOT NULL auto_increment,
				 shortcode varchar(500) NOT NULL default '',
                 datas longtext NOT NULL default '',
                 products text NOT NULL default '',
                 PRIMARY KEY  (id)
                ) {$charset_collate};";
        //$wpdb->query( $simple_sql );
        
        // Vérifie si des modifications
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($simple_sql);
            
        // Check if tables not exist yet
        if (!$this->ppgbo_check_table_exists('ppgbo_cache')) { 
            // Index unique
            $simple_sql = "CREATE UNIQUE INDEX shortcode_index ON {$wpdb->prefix}ppgbo_cache ( shortcode );";
            $wpdb->query( $simple_sql );
        }
    }
    
    public function ppgbo_get_cache() {
        global $wpdb;

        $datas      = array();
        $myTable    = $wpdb->prefix.'ppgbo_cache';
        $sql        = $wpdb->prepare("SELECT * FROM %i", $myTable);        
        $elements   = $wpdb->get_results($sql);
        
        foreach ($elements as $element) {
            $products   = array();
            $shortcode  = "";
            
            $shortcode  = '[ppgbo';
            
            foreach (json_decode($element->shortcode) as $key => $value) {
                $shortcode .= ' ' . $key . '="' . $value . '"';
            }
            
            $shortcode .= ']';
            
            $element->products = (!empty(json_decode($element->products))) ? json_decode($element->products) : __( 'Aucun produit concerné.', 'presta-products' );
            $element->shortcode = $shortcode;
            
            $datas[] = $element;
        }
        
        return $datas;
    }
    
    // Vérification si la table existe
    public function ppgbo_check_table_exists( $tablename ) {
        global $wpdb;

	    if (((!empty($wpdb->prefix)) && (strpos($tablename, $wpdb->prefix) === false))) {
		    $tablename = $wpdb->prefix . $tablename;
	    }

        $sql_check_table    = $wpdb->prepare("SHOW TABLES LIKE %s" , $tablename );
        $res                = $wpdb->get_results( $sql_check_table );
        
        return count($res);
    }
}

// Appel de la classe
new PrestaProducts();