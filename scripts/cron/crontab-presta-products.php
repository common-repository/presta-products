<?php

class CrontabPrestaProducts 
{
    // Constructeur
    public function __construct()
    {
        /* Disable WP theme for this file (optional) */
        define('WP_USE_THEMES', false);
        
        /** Sets up the WordPress Environment. */
        require __DIR__ . '/../../../../../wp-load.php';
        
        global $wpdb;
        
        echo __( 'Traitement de mise à jour du cache.', 'presta-products' ) . PHP_EOL;
        echo sprintf(__( '[%s] Début du traitement.', 'presta-products' ), date('d/m/Y H:i:s')) . PHP_EOL;
                
        // Réinit la base
        $sql = $wpdb->prepare("TRUNCATE TABLE {$wpdb->prefix}ppgbo_cache") or die('error');
        $wpdb->query($sql);
        
        // Récupération des articles et pages
        $posts = get_posts(array('posts_per_page' => -1));
        $pages = get_pages();
        
        // Parcours pour obtenir les shortcodes
        foreach (array_merge($posts, $pages) as $post) {
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
                    
                    // Récupération des produits
                    $datas = $this->ppgbo_get_products_from_prestashop_cron($params); 
                    
                    foreach ($datas as $data) {
                        $products[] = array('url' => $data->url_rewrite, 'name' => $data->product->name);
                    }
                    
                    // Requête SQL d'ajout
                    $sql = $wpdb->prepare("INSERT IGNORE INTO {$wpdb->prefix}ppgbo_cache (shortcode, datas, products) VALUES ('%s', '%s', '%s')", json_encode($params), json_encode($datas), json_encode($products));
                    $wpdb->query($sql) or wp_die(__( 'Problème d\'enregistrement de la donnée.', 'presta-products' ));
                }
            }
        }
        
        echo sprintf(__( '[%s] Fin du traitement.', 'presta-products' ), date('d/m/Y H:i:s')) . PHP_EOL;
    }
    
    // Fonction de récupération des produits depuis le site prestashop
    function ppgbo_get_products_from_prestashop_cron($atts) {
        $prestashop_url     = get_option( 'ppgbo_prestashop_url' );
        $webservice_key     = get_option( 'ppgbo_prestashop_webservice' );
        $hide_inactive      = get_option( 'ppgbo_hide_inactive' );
        $hide_available     = get_option( 'ppgbo_hide_available' );
        $hide_visibility    = get_option( 'ppgbo_hide_visibility' );
            
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
}

// Appel de la classe
new CrontabPrestaProducts();