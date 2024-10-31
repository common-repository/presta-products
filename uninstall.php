<?php
    // if uninstall.php is not called by WordPress, die
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        die;
    }
     
    delete_option( 'ppgbo_obfuscation' );
    delete_option( 'ppgbo_price_display' );
    delete_option( 'ppgbo_oldprice_display' );
    delete_option( 'ppgbo_description_display' );
    delete_option( 'ppgbo_description_short_display' );
    delete_option( 'ppgbo_image_display' );
    delete_option( 'ppgbo_name_display' );
    delete_option( 'ppgbo_balise_title' );
    delete_option( 'ppgbo_counter_line' );
    delete_option( 'ppgbo_css_custom' );
    delete_option( 'ppgbo_hide_inactive' );
    delete_option( 'ppgbo_hide_available' );
    delete_option( 'ppgbo_on_sale' );
    delete_option( 'ppgbo_description_short_size' );
    delete_option( 'ppgbo_description_size' );
    delete_option( 'ppgbo_template_product' );
    delete_option( 'ppgbo_message' );
    delete_option( 'ppgbo_new_tab' );
    delete_option( 'ppgbo_prestashop_webservice' );
    delete_option( 'ppgbo_prestashop_url' );
    delete_option( 'ppgbo_premium_key' );
    delete_option( 'ppgbo_premium_userId' );

    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}ppgbo_cache" );