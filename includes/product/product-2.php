<div class="row ppgbo_row ppgbo_product_2">
    <?php
        $count = count($products);
        
        foreach ($products as $key => $product) {
    ?>

    <div class="product col-<?php echo (($count == 1 || $counter_line == 1) ? '12' : (($count == 2 || $counter_line == 2) ? '6' : (($counter_line == 3) ? '4' : (($counter_line == 4) ? '3' : '2')))) ?>">
        <?php
            // Lien
            if ($obfuscation) {
                echo '<span class="ppgbo_qcd" data-tab="' . (($new_tab) ? '_blank' : '_self') . '" data-qcd="' . base64_encode($product->url_rewrite) .'">' . esc_html( $product->product->name ) . '</span>';
            }
            else {
                echo '<a class="product_link" ' . (($new_tab) ? 'target="_blank"' : '') . ' href="' . esc_attr( $product->url_rewrite ) . '">' . esc_html( $product->product->name ) . '</a>';
            }
            
            if ($on_sale && $product->product->on_sale == 1) {
                echo '<span class="product_onsale">' . __( 'Promotion !', 'presta-products' ) . '</span>';
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
            
            // Bouton
            if ($btn_goto_product) {
                echo '<div class="btn btn-default">' . __( 'Voir le produit', 'presta-products' ) . '</div>';
            }
        
            // Image
            if ($display_image) {
                echo '<img class="product_image" src="' . esc_attr( $prestashop_url ) . '/' . esc_attr( $product->product->id_default_image ) . '-' . esc_attr( $image_format ) . '_default/1.jpg" ';
                
                if (count($product->product->associations->images) > 1 && $display_image_hover) {
                    echo ' data-hover="' . esc_attr( $prestashop_url ) . '/' . esc_attr( $product->product->associations->images[1]->id ) . '-' . esc_attr( $image_format ) . '_default/1.jpg" data-src="' . esc_attr( $prestashop_url ) . '/' . esc_attr( $product->product->id_default_image ) . '-' . esc_attr( $image_format ) . '_default/1.jpg" ';
                }
                
                echo ' alt="' . esc_html( $product->product->name ) . '" width="250" height="250" />';
            }
            
            // Prix
            if ($display_price) {
                echo '<span class="product_price">';
                
                if ($display_oldprice && intval($product->product->old_price) != 0) {
                    echo '<span class="product_oldprice">' . esc_html( number_format(($product->product->old_price + $product->product->my_price), 2) ) . '€</span>';
                }
                
                echo esc_html( number_format($product->product->my_price, 2) ) . '€</span>';
            }
        ?>
    </div>
    
    <?php
            // Nombre de produits max par lignes
            if ($count > 0 && ($key+1)%$counter_line == 0 && $key > 1) {
                echo '<div class="clear"></div>';
            }
        }
    ?>
</div>
<div class="clear"></div>