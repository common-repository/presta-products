<div class="content mt-4 clr ppgbo-options <?php echo (($page != 'options') ? 'hide' : ''); ?>" <?php echo (($page != 'options') ? 'style="display:none;"' : ''); ?>>
    <form class="form-basic" method="post" action="#">  
        <input type="hidden" name="type" value="options" />
        
        <?php
            if ($message) {
                echo ' <div class="toast-container position-absolute top-0 end-0 p-3"><div class="toast" id="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                          <div class="toast-header bg-primary text-white"><strong class="me-auto">' . __( 'Enregistrement', 'presta-products' ) . '</strong>
                          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="' . __( 'Fermeture', 'presta-products' ) . '"></button>
                          </div><div class="toast-body">' . $message . '</div></div></div>';
            }
        ?>
        
        <div class="form-title-row">  
            <h3><?php echo __( 'Données Prestashop', 'presta-products'); ?></h3> 
            <p>
                <?php echo __( 'Ici il faut enregistrer les données de connexion au Prestashop.', 'presta-products'); ?>
            </p>
            <div class="alert alert-info">
                <span class="dashicons dashicons-info-outline"></span>
                <?php echo __( 'Il faut utiliser la clé WEBService, accessible dans le menu "Configurer / Paramètres avancés / Webservice" de Prestashop !', 'presta-products'); ?>
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="webservice_key" class="col-form-label col-sm-4">  
                <span>
                    <?php echo __( 'Clé Webservice :', 'presta-products'); ?>
                </span>    
            </label>  
            <div class="col-sm-6">
                <input id="webservice_key" type="text" name="webservice_key" class="form-control" value="<?php echo esc_attr($key); ?>" />
                    <i class="small"><?php echo __( '2 permissions sont nécessaires : les ressources "products" et "orders" en mode GET uniquement.', 'presta-products' ); ?></i><br>
                    <i class="small"><?php echo __( 'Optionnel : La ressource "languages" en mode GET est nécessaire pour la gestion de la langue (utilisation du module Polylang).', 'presta-products' ); ?></i><br>
                    <i class="small"><?php echo __( 'Vous pouvez trouver <a href="https://www.guillaume-bouaud.fr/blog/prestashop/creation-dune-cle-webservice" target="_blank">un tutoriel</a> pour vous aider à la création de cette fameuse clé WebService si nécessaire.', 'presta-products' ); ?></i>
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="url" class="col-form-label col-sm-4">  
                <span><?php echo __( 'URL du site internet ecommerce Prestashop :', 'presta-products'); ?></span>    
            </label>  
            <div class="col-sm-6">
                <input id="url" type="text" name="url" class="form-control" value="<?php echo esc_attr($url); ?>" />
            </div>
        </div>  
        
        <div class="row mt-4">
            <div class="col-xs-12">
                <div class="alert alert-warning">
                    <span class="dashicons dashicons-warning"></span>
                    <?php echo __( 'Attention, si votre boutique PrestaShop est en mode maintenance, pensez à ajouter l\'IP de votre serveur (où est stocké votre WordPress, même si les 2 CMS sont sur le même serveur) aux IP de maintenance autorisées pour la connexion.', 'presta-products' ); ?>
                </div>
            </div>
        </div>
        
        <hr class="mt-4">
        <h5 class="mt-3"><?php echo __( 'Version PREMIUM', 'presta-products'); ?></h5>
        <hr>
        <?php
            if (empty($premium) || empty($userId) || !$freemium) {
        ?>
            <div class="alert alert-warning">
                <span class="dashicons dashicons-warning"></span>
                <?php echo __( 'Attention, les 2 champs sont nécessaires pour activer l\'option PREMIUM :', 'presta-products'); ?><br><br>
                <?php echo __( '- la clé est indiquée sur votre récapitulatif de commande.', 'presta-products'); ?><br>
                <?php echo __( '- l\'ID Utilisateur correspond à votre ID sur la page "Mon Compte / Détails du compte", dernier champ tout en bas.', 'presta-products'); ?><br><br>
                <?php echo __( 'Si ce message s\'affiche toujours après avoir renseigné les 2 champs, c\'est que votre clé n\'est pas valide !', 'presta-products'); ?><br>
                <?php echo __( 'Vous pouvez en prendre une sur <a href="https://www.guillaume-bouaud.fr/produit/licence-premium-presta-products-for-wordpress" target="_blank">le site du développeur</a> ou le contacter s\'il y a un problème avec votre clé.', 'presta-products'); ?>
            </div>
        <?php
            }
        ?>
    
        <div class="row mt-4"> 
            <label for="premium" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Clé de la version PREMIUM :', 'presta-products'); ?></span>
            </label>  
            <div class="col-sm-6">
                <input id="premium" type="text" name="premium" class="form-control" value="<?php echo esc_attr($premium); ?>" />
                    <i class="small"><?php echo __( 'Vous pouvez acheter une licence directement sur <a href="https://www.guillaume-bouaud.fr/produit/licence-premium-presta-products-for-wordpress" target="_blank">le site du développeur</a>.', 'presta-products' ); ?></i><br>
                    <i class="small"><?php echo __( 'Vous la retrouverez sur la page "Mon Compte" (Clés de licence) ou dans le mail de validation de commande.', 'presta-products' ); ?></i>
            </div>
        </div>  
    
        <div class="row mt-4"> 
            <label for="premium_user_id" class="col-form-label col-sm-4">  
                <span><?php echo __( 'ID de l\'utilisateur sur le site du module :', 'presta-products'); ?></span>
            </label>  
            <div class="col-sm-6">
                <input id="premium_user_id" type="text" name="premium_user_id" class="form-control" value="<?php echo esc_attr($userId); ?>" />
                    <i class="small"><?php echo __( 'Vous trouverez l\'information sur <a href="https://www.guillaume-bouaud.fr/mon-compte/edit-account" target="_blank">la page "Mon Compte / Détails du compte"</a> sur le site du développeur.', 'presta-products' ); ?></i>
            </div>
        </div> 
        
        <?php
            if (!empty($premium) && $counter_freemium < 5) {
        ?>
        
        <div class="row mt-4"> 
            <label for="counter_freemium" class="col-form-label col-sm-4">  
                <span><?php echo __( 'Tentatives de connexion sécurisée au serveur (validation de la clé) restantes :', 'presta-products'); ?></span>
            </label>  
            <div class="col-sm-6">
                <input id="counter_freemium" type="text" name="counter_freemium" class="form-control" readonly value="<?php echo esc_attr($counter_freemium); ?>" />
                <div class="alert alert-danger mt-2">
                    <div class="row">
                        <div class="align-self-center col-sm-1">
                            <span class="dashicons dashicons-warning"></span>
                        </div>
                        <div class="col-sm-11">
                            <i class="small"><?php echo __( 'La demande d\'accès au serveur (validation de la clé) n\'a pas pu aboutir, merci de réitérer dans quelques instants.', 'presta-products' ); ?></i><br>
                            <i class="small"><?php echo __( 'Attention, si ce message persiste et que le compteur tombe à 0, les champs de l\'option PREMIUM seront réinitialisés.', 'presta-products' ); ?></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        
        <?php
            }
        ?>
    
        <div class="row mt-4"> 
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><?php echo __( 'Enregistrer', 'presta-products'); ?></button>
            </div>
        </div>  
    </form>  
</div>