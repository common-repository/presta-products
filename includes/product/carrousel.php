<div class="row ppgbo_row ppgbo_carrousel ppgbo_product_1" <?php echo (($width) ? 'style="width: ' . $width . ';"' : '') ?>>
    <?php
        $count = count($products);
        
        // Vérification mobile ou tablette
        $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
        $isTab = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet")); 
        
        if (in_array($navigation_carrousel, array('arrows', 'both'))) {
    ?>
    
    <a href="javascript:;" class="carrousel-prev"><img src="<?php echo esc_url($svg_left); ?>" width="50" alt="<?php echo __('Précédent', 'presta-products'); ?>" /></a>
    <a href="javascript:;" class="carrousel-next"><img src="<?php echo esc_url($svg_right); ?>" width="50" alt="<?php echo __('Suivant', 'presta-products'); ?>" /></a>
    
    <?php
        }
    ?>
    
    <div class="carrousel col-<?php echo (($count == 1 || $counter_line == 1 || $counter_line_carrousel == 1 || $isMob || $isTab) ? '12' : (($count == 2 || $counter_line == 2 || $counter_line_carrousel == 2) ? '6' : (($counter_line == 3 || $counter_line_carrousel == 3) ? '4' : (($counter_line == 4 || $counter_line_carrousel == 4) ? '3' : '2')))) ?><?php echo (($autoplay > 0) ? ' autoplay autoplay-' . $autoplay : ''); ?>">
		<ul style="width:<?php echo $count * 100; ?>%;">
		    <?php
		        foreach ($products as $key => $product) {
		            echo '<li><div class="product">';
		            
		            // Lien
                    if ($obfuscation) {
                        echo '<span class="ppgbo_qcd carrousel-link" data-tab="' . (($new_tab) ? '_blank' : '_self') . '" data-qcd="' . base64_encode($product->url_rewrite) .'">' . esc_html($product->product->name ) . '</span>';
                    }
                    else {
                        echo '<a class="product_link carrousel-link" ' . (($new_tab) ? 'target="_blank"' : '') . ' href="' . esc_url( $product->url_rewrite ) . '">' . esc_html( $product->product->name ) . '</a>';
                    }
                    
                    if ($on_sale && $product->product->on_sale == 1) {
                        echo '<span class="product_onsale">' . __( 'Promotion !', 'presta-products' ) . '</span>';
                    }
                
                    // Image
                    if ($display_image) {
                        echo '<img class="product_image" src="' . esc_attr( $prestashop_url ) . '/' . esc_attr( $product->product->id_default_image ) . '-' . esc_attr( $image_format ) . '_default/1.jpg" ';
                        
                        if (count($product->product->associations->images) > 1 && $display_image_hover) {
                            echo ' data-hover="' . esc_attr( $prestashop_url ) . '/' . esc_attr( $product->product->associations->images[1]->id ) . '-' . esc_attr( $image_format ) . '_default/1.jpg" data-src="' . esc_attr( $prestashop_url ) . '/' . esc_attr( $product->product->id_default_image ) . '-' . esc_attr( $image_format ) . '_default/1.jpg" ';
                        }
                        
                        echo ' alt="' . esc_attr( $product->product->name ) . '" width="250" height="250" />';
                    }
                    
                    // Nom
                    if ($display_name) {
                        echo '<' . esc_attr( $balise_title ) . ' class="product_name">' . esc_html( $product->product->name ) . '</' . esc_attr( $balise_title ) . '>';
                    }
                    
                    // Récapitulatif
                    if ($display_short_description) {
                        echo '<div class="product_description_short">' . esc_html( substr(substr(strip_tags($product->product->description_short), 0, $description_short_size), 0, strrpos(substr(strip_tags($product->product->description_short), 0, $description_short_size), " ")) ) . ' [...]</div>';
                    }
                    
                    // Description
                    if ($display_description) {
                        echo '<div class="product_description">' . esc_html( substr(substr(strip_tags($product->product->description), 0, $description_size), 0, strrpos(substr(strip_tags($product->product->description), 0, $description_size), " ")) ) . ' [...]</div>';
                    }
                    
                    // Prix
                    if ($display_price) {
                        echo '<span class="product_price">';
                        
                        if ($display_oldprice && intval($product->product->old_price) != 0) {
                            echo '<span class="product_oldprice">' . esc_html( number_format(($product->product->old_price + $product->product->my_price), 2) ) . '€</span>';
                        }
                        
                        echo esc_html( number_format($product->product->my_price, 2) ) . '€</span>';
                    }
                    
                    // Bouton
                    if ($btn_goto_product) {
                        echo '<div class="btn btn-default">' . __( 'Voir le produit', 'presta-products' ) . '</div>';
                    }
                    
		            echo '</div></li>';
		        }
		    ?>
		</ul>
	</div>
	
	<?php
        if (in_array($navigation_carrousel, array('dots', 'both'))) {
            echo '<div class="dots_navigation">';
            
            $total = $count / intval(($count == 1 || $counter_line == 1 || $counter_line_carrousel == 1 || $isMob || $isTab) ? '1' : (($count == 2 || $counter_line == 2 || $counter_line_carrousel == 2) ? '2' : (($counter_line == 3 || $counter_line_carrousel == 3) ? '3' : (($counter_line == 4 || $counter_line_carrousel == 4) ? '4' : '2'))));
            
            for ($i = 0; $i < $total; $i++) {
                echo '<a href="javascript:;" class="dots ' . (($i == 0) ? 'dots-active ' : '') . 'dots_' . $i . '"><img src="' . (($i == 0) ? esc_url($dots_svg_active) : esc_url($dots_svg)) . '" width="10" alt="' . __( 'Point', 'presta-products' ) . '" /></a>';
            }
            
            echo '</div>';
        }
    ?>
</div>

<div class="clear"></div>