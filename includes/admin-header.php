<div class="wrap clr">
    <h1><?php echo __( 'Presta Products for WordPress', 'presta-products' ); ?></h1>
    <p>
        <?php echo __( 'Vous êtes sur la page de configuration du module. Ici vous pourrez récupérer vos produits de votre prestashop !', 'presta-products' ); ?>
    </p>
    
    <?php
        if (empty($key) || empty($url)) {
            echo '<div class="alert alert-danger"><span class="dashicons dashicons-warning"></span>&nbsp;' . __( 'Les données prestashop (clé webservice et/ou url) ne sont pas renseignées ! Renseignez-les dans l\'onglet "Options générales".', 'presta-products' ) . '</div>';
        }
    ?>
    
    <h2 class="nav-tab-wrapper">
    	<a href="admin.php?page=presta-products&amp;tab=options" class="nav-tab <?php echo (($page == 'options') ? 'nav-tab-active' : ''); ?>"><?php echo __( 'Options générales', 'presta-products' ); ?></a>
        <a href="admin.php?page=presta-products&amp;tab=features" class="nav-tab <?php echo (($page == 'features') ? 'nav-tab-active' : ''); ?>"><?php echo __( 'Fonctionnalités', 'presta-products' ); ?></a>
        <a href="admin.php?page=presta-products&amp;tab=examples" class="nav-tab <?php echo (($page == 'examples') ? 'nav-tab-active' : ''); ?>"><?php echo __( 'Documentation', 'presta-products' ); ?></a>
        <?php 
            if ($freemium) {
        ?>
            <a href="admin.php?page=presta-products&amp;tab=cache" class="nav-tab <?php echo (($page == 'cache') ? 'nav-tab-active' : ''); ?>"><?php echo __( 'Cache', 'presta-products' ); ?></a>
            <a href="admin.php?page=presta-products&amp;tab=used" class="nav-tab <?php echo (($page == 'used') ? 'nav-tab-active' : ''); ?>"><?php echo __( 'Utilisé sur', 'presta-products' ); ?></a>
        <?php
            }
            else {
        ?>
            <a href="javascript:;" class="nav-tab" title="<?php echo __( 'Uniquement en version PREMIUM.', 'presta-products' ); ?>"><?php echo __( 'Cache (Option PREMIUM)', 'presta-products' ); ?></a>
            <a href="javascript:;" class="nav-tab" title="<?php echo __( 'Uniquement en version PREMIUM.', 'presta-products' ); ?>"><?php echo __( 'Utilisé sur (Option PREMIUM)', 'presta-products' ); ?></a>
        <?php   
            }
        ?>
    </h2>