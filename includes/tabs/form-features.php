<div class="content mt-4 clr ppgbo-features <?php echo (($page != 'features') ? 'hide' : ''); ?>" <?php echo (($page != 'features') ? 'style="display:none;"' : ''); ?>>
    <form class="form-basic" method="post" action="#">  
        <input type="hidden" name="type" value="features" />
        
        <?php
            if ($message) {
                echo ' <div class="toast-container position-absolute top-0 end-0 p-3"><div class="toast" id="toast2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                          <div class="toast-header bg-primary text-white"><strong class="me-auto">' . __( 'Enregistrement', 'presta-products' ) . '</strong>
                          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="' . __( 'Fermeture', 'presta-products' ) . '"></button>
                          </div><div class="toast-body">' . $message . '</div></div></div>';
            }
        ?>
        
        <div class="form-title-row">  
            <h3><?php echo __( 'Options diverses', 'presta-products'); ?></h3> 
            <p>
                <?php echo __( 'Ici il faut enregistrer les options souhaitées ou non.', 'presta-products'); ?>
            </p>
        </div>  
        
        <hr class="mt-4">
        <h5 class="mt-3"><?php echo __( 'Affichages', 'presta-products'); ?></h5>
        <hr>
        
        <div class="row mt-4"> 
            <label for="name_display" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Nom du produit :', 'presta-products'); ?></span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="name_display" name="name_display" <?php echo (($name_display == 1) ? 'checked="checked"' : ''); ?> />            
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="image_display" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Image du produit :', 'presta-products'); ?></span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="image_display" name="image_display" <?php echo (($image_display == 1) ? 'checked="checked"' : ''); ?> />            
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="image_display" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Taille de l\'image :', 'presta-products'); ?></span>    
            </label>  
            <div class="col-sm-6">
                <select class="form-control" id="image_format" name="image_format">
                    <option value="small" <?php echo (($image_format == 'small') ? 'selected="selected"' : ''); ?>><?php echo __( 'Petite taille (small_default)', 'presta-products'); ?></option>
                    <option value="medium" <?php echo ((empty($image_format) || ($image_format == 'medium')) ? 'selected="selected"' : ''); ?>><?php echo __( 'Moyenne taille (medium_default)', 'presta-products'); ?></option>
                    <option value="large" <?php echo (($image_format == 'large') ? 'selected="selected"' : ''); ?>><?php echo __( 'Grande taille (large_default)', 'presta-products'); ?></option>
                    <option value="home" <?php echo (($image_format == 'home') ? 'selected="selected"' : ''); ?>><?php echo __( 'Accueil (home_default)', 'presta-products'); ?></option>
                    <option value="cart" <?php echo (($image_format == 'cart') ? 'selected="selected"' : ''); ?>><?php echo __( 'Panier (cart_default)', 'presta-products'); ?></option>
                </select>            
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="image_display_hover" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Hover de l\'image du produit :', 'presta-products'); ?></span><br>
                    <i class="small"><?php echo __( 'Nécessite au minimum une deuxième image sur le produit dans PrestaShop.', 'presta-products'); ?></i>  
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="image_display_hover" name="image_display_hover" <?php echo (($image_display_hover == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> /><br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                                
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="price_display" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Prix du produit :', 'presta-products'); ?></span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="price_display" name="price_display" <?php echo (($price_display == 1) ? 'checked="checked"' : ''); ?> />            
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="oldprice_display" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Prix barré du produit :', 'presta-products'); ?></span><br>
                    <i class="small"><?php echo __( 'Utilise les prix spécifiques du produit dans PrestaShop.', 'presta-products'); ?></i>      
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="oldprice_display" name="oldprice_display" <?php echo (($oldprice_display == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> /><br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                    
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="description_short_display" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Récapitulatif du produit :', 'presta-products'); ?></span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="description_short_display" name="description_short_display" <?php echo (($description_short_display == 1) ? 'checked="checked"' : ''); ?> />            
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="description_display" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Description du produit :', 'presta-products'); ?></span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="description_display" name="description_display" <?php echo (($description_display == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> /><br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                     
            </div>
        </div>    
        
        <div class="row mt-4"> 
            <label for="on_sale" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'En promotion :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Nécessite la coche "Promotions" dans l\'onglet "Prix" de la fiche produit dans PrestaShop.', 'presta-products'); ?></i>  
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="on_sale" name="on_sale" <?php echo (($on_sale == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />    <br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                 
            </div>
        </div>
        
        <div class="row mt-4"> 
            <label for="btn_goto_product" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Affichage d\'un bouton "Voir le produit" :', 'presta-products'); ?><br>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="btn_goto_product" name="btn_goto_product" <?php echo (($btn_goto_product == 1) ? 'checked="checked"' : ''); ?> />    <br>
            </div>
        </div>
        
        <hr class="mt-4">
        <h5 class="mt-3"><?php echo __( 'SEO', 'presta-products'); ?></h5>
        <hr>
        
        <div class="row mt-4"> 
            <label for="obfuscation" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Obfuscation des liens :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Balise span avec encodage (base 64) du lien.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="obfuscation" name="obfuscation" <?php echo (($obfuscation == 1) ? 'checked="checked"' : ''); ?> />            
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="balise_title" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Balisage du titre (nom du produit) :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Options disponibles : h1 à h6, span, div.', 'presta-products'); ?></i><br>
                    <i class="small"><?php echo __( 'Par défaut h4.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="text" class="form-control" id="balise_title" name="balise_title" value="<?php echo esc_attr($balise_title); ?>" <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                   
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="new_tab" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Ouvrir dans un nouvel onglet ?', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Par défaut: Oui.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="new_tab" name="new_tab" <?php echo (($new_tab == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />    <br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                 
            </div>
        </div>
        
        <hr class="mt-4">
        <h5 class="mt-3"><?php echo __( 'Options', 'presta-products'); ?></h5>
        <hr>
        
        <div class="row mt-4"> 
            <label for="counter_line" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Nombre de produits max par ligne :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Options disponibles : 1, 2, 3, 4 ou 6 produits.', 'presta-products'); ?></i><br>
                    <i class="small"><?php echo __( 'Par défaut 3.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="text" class="form-control" id="counter_line" name="counter_line" value="<?php echo esc_attr($counter_line); ?>" <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                   
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="description_short_size" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Taille du récapitulatif :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Uniquement des nombres.', 'presta-products'); ?></i><br>
                    <i class="small"><?php echo __( 'Par défaut : 90 caractères.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="text" class="form-control" id="description_short_size" name="description_short_size" value="<?php echo esc_attr($description_short_size); ?>" <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                   
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="description_size" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Taille de la description :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Uniquement des nombres.', 'presta-products'); ?></i><br>
                    <i class="small"><?php echo __( 'Par défaut : 150 caractères.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="text" class="form-control" id="description_size" name="description_size" value="<?php echo esc_attr($description_size); ?>" <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                    
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="hide_inactive" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Cacher les produits hors ligne :', 'presta-products'); ?>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="hide_inactive" name="hide_inactive" <?php echo (($hide_inactive == 1) ? 'checked="checked"' : ''); ?> />            
            </div>
            <label for="hide_available" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Cacher les produits non disponible à la vente :', 'presta-products'); ?>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="hide_available" name="hide_available" <?php echo (($hide_available == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> /><br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>         
            </div>
            <label for="hide_visibility" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Cacher les produits de visibilité "Nulle Part" :', 'presta-products'); ?>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="hide_visibility" name="hide_visibility" <?php echo (($hide_visibility == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> /><br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>         
            </div>
            <label for="hide_stock" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Cacher les produits sans stock (champ quantité) :', 'presta-products'); ?>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="hide_stock" name="hide_stock" <?php echo (($hide_stock == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> /><br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>         
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="css_custom" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'CSS personnalisé :', 'presta-products'); ?><br>
                    <i class="text-danger small"><?php echo __( 'Attention, c\'est un paramétrage uniquement pour les confirmés.', 'presta-products'); ?></i><br>
                    <i class="text-danger small"><?php echo __( 'Si vous ne connaissez pas le langage CSS, faites appel à votre administrateur.', 'presta-products'); ?></i><br>
                    <div class="alert alert-info mt-2">
                        <i class="small"><?php echo __( 'Vous pouvez utiliser les classes suivantes pour changer le style des éléments :', 'presta-products' ); ?></i><br><br>
                        <i class="small"><?php echo __( '<ul><li>&laquo; .row.ppgbo_row &raquo; pour la ligne des produits</li><li>&laquo; .row.ppgbo_row > .product &raquo; pour le bloc produit</li><li>Exemple: &laquo; .row.ppgbo_row { margin:25px 0 !important;} &raquo; pour ajouter un espace dessus et dessous la ligne des produits</li></ul>', 'presta-products' ); ?></i>
                    </div>
                </span>    
            </label>  
            <div class="col-sm-6">
                <textarea class="form-control" id="css_custom" name="css_custom" rows="12"><?php echo esc_textarea($css_custom); ?></textarea>
                <i class="small"><span class="dashicons dashicons-info-outline"></span>&nbsp;<?php echo __( 'Un conseil : utiliser un éditeur de texte pour le formatage du code CSS puis copier/coller le contenu ici.', 'presta-products'); ?></i>
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="template_product" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Template produit :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Par défaut : Template numéro 1.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-check col-sm-4">
                        <label class="form-check-label" for="template_product1">
                            <img src="<?php echo esc_url($product_template_1); ?>" width="200" alt="Template numéro 1" />
                        </label><br>
                        <input class="form-control" type="radio" name="template_product" id="template_product1" value="1" <?php echo (($template_product == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                    <div class="form-check col-sm-4">
                        <label class="form-check-label" for="template_product2">
                            <img src="<?php echo esc_url($product_template_2); ?>" width="200" alt="Template numéro 2" />
                        </label><br>
                        <input class="form-control" type="radio" name="template_product" id="template_product2" value="2" <?php echo (($template_product == 2) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                    <div class="form-check col-sm-4">
                        <label class="form-check-label" for="template_product3">
                            <img src="<?php echo esc_url($product_template_3); ?>" width="200" alt="Template numéro 3" />
                        </label><br>
                        <input class="form-control" type="radio" name="template_product" id="template_product3" value="3" <?php echo (($template_product == 3) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                </div>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>   
            </div>
        </div> 
        
        <hr class="mt-4">
        <h5 class="mt-3"><?php echo __( 'Mode Carrousel', 'presta-products'); ?></h5>
        <hr>
    
        <div class="row mt-4"> 
            <label for="navigation_carrousel" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Type de navigation :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Par défaut : Flèches.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <select class="form-control" id="navigation_carrousel" name="navigation_carrousel">
                    <option value="arrows" <?php echo ((empty($navigation_carrousel) || ($navigation_carrousel == 'arrows')) ? 'selected="selected"' : ''); ?>><?php echo __( 'Flèches', 'presta-products'); ?></option>
                    <option value="dots" <?php echo (($navigation_carrousel == 'dots') ? 'selected="selected"' : ''); ?>><?php echo __( 'Points', 'presta-products'); ?></option>
                    <option value="both" <?php echo (($navigation_carrousel == 'both') ? 'selected="selected"' : ''); ?>><?php echo __( 'Flèches et points', 'presta-products'); ?></option>
                </select>            
            </div>
        </div>  
        
        <div class="row mt-4"> 
            <label for="arrows_carrousel" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Type de flèches :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Par défaut : Type numéro 1.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-check col-sm-3">
                        <label class="form-check-label" for="arrows_carrousel1">
                            <img src="<?php echo esc_url($arrows_carrousel_left_1); ?>" width="50" alt="<?php echo __( 'Type numéro 1', 'presta-products'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src="<?php echo esc_url($arrows_carrousel_right_1); ?>" width="50" alt="<?php echo __( 'Type numéro 1', 'presta-products'); ?>" />
                        </label><br>
                        <input class="form-control" type="radio" name="arrows_carrousel" id="arrows_carrousel1" value="1" <?php echo (($arrows_carrousel == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                    <div class="form-check col-sm-3">
                        <label class="form-check-label" for="arrows_carrousel2">
                            <img src="<?php echo esc_url($arrows_carrousel_left_2); ?>" width="50" alt="<?php echo __( 'Type numéro 2', 'presta-products'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src="<?php echo esc_url($arrows_carrousel_right_2); ?>" width="50" alt="<?php echo __( 'Type numéro 2', 'presta-products'); ?>" />
                        </label><br>
                        <input class="form-control" type="radio" name="arrows_carrousel" id="arrows_carrousel2" value="2" <?php echo (($arrows_carrousel == 2) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                    <div class="form-check col-sm-3">
                        <label class="form-check-label" for="arrows_carrousel3">
                            <img src="<?php echo esc_url($arrows_carrousel_left_3); ?>" width="50" alt="<?php echo __( 'Type numéro 3', 'presta-products'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src="<?php echo esc_url($arrows_carrousel_right_3); ?>" width="50" alt="<?php echo __( 'Type numéro 3', 'presta-products'); ?>" />
                        </label><br>
                        <input class="form-control" type="radio" name="arrows_carrousel" id="arrows_carrousel3" value="3" <?php echo (($arrows_carrousel == 3) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                    <div class="form-check col-sm-3">
                        <label class="form-check-label" for="arrows_carrousel4">
                            <img src="<?php echo esc_url($arrows_carrousel_left_4); ?>" width="50" alt="<?php echo __( 'Type numéro 4', 'presta-products'); ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src="<?php echo esc_url($arrows_carrousel_right_4); ?>" width="50" alt="<?php echo __( 'Type numéro 4', 'presta-products'); ?>" />
                        </label><br>
                        <input class="form-control" type="radio" name="arrows_carrousel" id="arrows_carrousel4" value="4" <?php echo (($arrows_carrousel == 4) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                </div>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>   
            </div>
        </div> 
        
        <div class="row mt-4"> 
            <label for="dots_carrousel" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Type de points (inactif) :', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Par défaut : Type numéro 1.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <div class="row">
                    <div class="form-check col-sm-3">
                        <label class="form-check-label" for="dots_carrousel1">
                            <img src="<?php echo esc_url($dots_carrousel_1); ?>" width="10" alt="<?php echo __( 'Type numéro 1', 'presta-products'); ?>" />
                        </label><br>
                        <input class="form-control" type="radio" name="dots_carrousel" id="dots_carrousel1" value="1" <?php echo (($dots_carrousel == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                    <div class="form-check col-sm-3">
                        <label class="form-check-label" for="dots_carrousel2">
                            <img src="<?php echo esc_url($dots_carrousel_2); ?>" width="10" alt="<?php echo __( 'Type numéro 2', 'presta-products'); ?>" />
                        </label><br>
                        <input class="form-control" type="radio" name="dots_carrousel" id="dots_carrousel2" value="2" <?php echo (($dots_carrousel == 2) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />
                    </div>
                </div>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>   
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><?php echo __( 'Enregistrer', 'presta-products'); ?></button>
            </div>
        </div>  
    </form>  
</div>