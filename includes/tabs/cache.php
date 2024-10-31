<div class="content mt-4 clr ppgbo-cache <?php echo (($page != 'cache') ? 'hide' : ''); ?>" <?php echo (($page != 'cache') ? 'style="display:none;"' : ''); ?>>
        
    <hr class="mt-4">
    <h3 class="mt-3"><?php echo __( 'Gestion en cache', 'presta-products'); ?></h3>
    <hr>
    
    <div class="alert alert-info">
        <span class="dashicons dashicons-info-outline"></span>
        <?php echo __( 'Le système de cache va enregistrer les données de l\'API PrestaShop en local dans le WordPress.', 'presta-products' ); ?><br>
        <?php echo __( 'Vous acceptez donc que les données Produits de votre boutique PrestaShop soient stockées en local (base de données) dans le WordPress actuel.', 'presta-products' ); ?>
    </div>
    
    <form class="form-basic" method="post" action="#">
        <input type="hidden" name="type" value="cache" />
        
        <?php
            if ($message) {
                echo ' <div class="toast-container position-absolute top-0 end-0 p-3"><div class="toast" id="toast3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                          <div class="toast-header bg-primary text-white"><strong class="me-auto">' . __( 'Enregistrement', 'presta-products' ) . '</strong>
                          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="' . __( 'Fermeture', 'presta-products' ) . '"></button>
                          </div><div class="toast-body">' . $message . '</div></div></div>';
            }
        ?>
        
        <div class="row mt-4">   
            <label for="use_cache" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Utiliser le cache ?', 'presta-products'); ?><br>
                    <i class="small"><?php echo __( 'Par défaut: Non.', 'presta-products'); ?></i>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input type="checkbox" class="form-control" id="use_cache" name="use_cache" <?php echo (($use_cache == 1) ? 'checked="checked"' : ''); ?> <?php echo (($freemium == 0) ? 'disabled' : ''); ?> />    <br>
                    <i class="small"><?php echo __( 'Option disponible avec la version payante.', 'presta-products'); ?></i>                 
            </div>
        </div>

        <div class="row mt-4"> 
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><?php echo __( 'Enregistrer', 'presta-products'); ?></button>
            </div>
        </div>  
    </form>
    
    <div class="mt-4 mb-0 alert alert-primary">
        <?php echo __( 'Vous pouvez ajouter une ligne dans votre crontab si vous souhaitez que la tâche soit exécutée automatiquement. Voici un exemple :', 'presta-products' ); ?><br>
        <?php echo sprintf(__( '12 1 * * * /usr/local/bin/php %s > /dev/null 2>&1', 'presta-products' ), $script_cron); ?>
    </div>
    <i class="small"><?php echo __( 'Vous pouvez trouver un tutoriel de la création d\'une tâche cron sur votre serveur en suivant <a href="https://www.guillaume-bouaud.fr/blog/wordpress/ajouter-une-routine-dans-la-crontab" target="_blank">ce lien</a>.', 'presta-products' ); ?></i>
    
    <div class="mt-4 mb-0 alert alert-warning">
        <span class="dashicons dashicons-warning"></span>
        <?php echo __( 'Le rafraichissement du cache est obligatoire à chaque nouveau changement de shortcode dans les pages et articles (ajout, modification, suppression).', 'presta-products' ); ?>
    </div>
    
    <?php
        if ($use_cache) {
    ?>
    
        <hr class="mt-4">
        <h3 class="mt-3"><?php echo __( 'Actions', 'presta-products'); ?></h3>
        <hr>
        
        <div class="row mt-4">   
            <div class="col-sm-2 offset-sm-3">
                <button type="button" class="btn btn-primary btn-lg" id="majCache"><?php echo __( 'Mettre à jour le cache', 'presta-products' ); ?></button>              
            </div>
            <div class="col-sm-2 offset-sm-2">
                <button type="button" class="btn btn-danger btn-lg" id="razCache"><?php echo __( 'Supprimer le cache', 'presta-products' ); ?></button>              
            </div>
        </div>
    
        <hr class="mt-4">
        <h3 class="mt-3"><?php echo __( 'Données mises en cache', 'presta-products'); ?></h3>
        <hr>
        
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?php echo __( 'Shortcode', 'presta-products' ); ?></th>
                    <th><?php echo __( 'Produits affichés', 'presta-products' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!empty($caches)) {
                        foreach ($caches as $element) {
                            echo '<tr>';
                            echo '<td>' . esc_html($element->shortcode) . '</td>';
                            echo '<td>';
                            
                            if (is_array($element->products)) {
                                foreach ($element->products as $key => $product) {
                                    if ($key > 0) {
                                        echo ', ';
                                    }
                                    
                                    echo '<a href="' . esc_url($product->url) . '" target="_blank">' . esc_html($product->name) . '</a>';
                                }
                            }
                            else {
                                echo esc_html($element->products);
                            }
                            
                            echo '</td>';
                            echo '</tr>';
                        }
                    }
                    else {
                        echo '<tr><td colspan="2">' . __( 'Pas de données en cache !', 'presta-products' ) . '</td></tr>';
                    }
                ?>
            </tbody>
        </table>
    
    <?php
        }
        else if (!empty($caches)) {
    ?>
    
        <hr class="mt-4">
        <h3 class="mt-3"><?php echo __( 'Actions', 'presta-products'); ?></h3>
        <hr>
        
        <div class="row mt-4">   
            <div class="col-sm-2 offset-sm-5">
                <button type="button" class="btn btn-danger btn-lg" id="razCache"><?php echo __( 'Supprimer le cache', 'presta-products' ); ?></button>              
            </div>
        </div>
    
    <?php
        }
    ?>
        
</div>