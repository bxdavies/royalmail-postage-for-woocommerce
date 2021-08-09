<?php

add_filter( 'woocommerce_get_sections_shipping', 'wcslider_add_section' );
function wcslider_add_section( $sections ) {
    
    $sections['royalmailsettings'] = __( 'Royal Mail Settings', 'text-domain' );

    return $sections;
}

add_filter( 'woocommerce_get_settings_shipping', 'wcslider_all_settings', 10, 2 );
function wcslider_all_settings( $settings, $current_section ) {

    /**
     * Check the current section is what we want
     **/
    if ( $current_section == 'royalmailsettings' ) {
        $settings_slider = array();

        // Add Title to the Settings
        $settings_slider[] = array( 
            'name' => __( 'Royal Mail Settings', 'text-domain' ), 
            'type' => 'title', 'desc' => __( 'The following options are used to configure Royal Mail Postage for WooCommerce', 'text-domain' ), 
            'id' => 'royalmailsettings' 
        );
        
        // Get dimension_unit
        $dimension_unit     = get_option('woocommerce_dimension_unit');
        $currency_symbol    = get_option('woocommerce_currency_symbol');

        // Add Large Letter Volume
        $settings_slider[] = array(
            'name'              => __( "Large Letter Volume: ({$dimension_unit})", "text-domain" ),
            'desc_tip'          => __( 'Volume of a Large Letter', 'text-domain' ),
            'id'                => 'RoyalMailLargeLetterVolume',
            'default_value'     => 2206.25,
            'type'              => 'number',
            'css'               => 'min-width:300px;',
            'desc'              => __( 'Volume of Large Letter', 'text-domain' ),
        );

        // Add Small Parcel Volume
        $settings_slider[] = array(
        'name'                  => __( "Small Parcel Volume: ({$dimension_unit})", "text-domain" ),
        'desc_tip'              => __( 'Volume of Small Parcel', 'text-domain' ),
        'id'                    => 'RoyalMailSmallParcelVolume',
        'type'                  => 'number',
        'default_value'         => 25200,
        'css'                   => 'min-width:300px;',
        'desc'                  => __( 'Volume of Small Parcel', 'text-domain' ),
        );

        // Add Small Parcel Volume
        $settings_slider[] = array(
            'name'              => __( "Medium Parcel Volume: ({$dimension_unit})", 'text-domain' ),
            'desc_tip'          => __( 'Volume of Medium Parcel', 'text-domain' ),
            'id'                => 'RoyalMailMediumParcelVolume',
            'type'              => 'number',
            'default_value'     => 129076,
            'css'               => 'min-width:300px;',
            'desc'              => __( 'Volume of Medium Parcel', 'text-domain' ),
        );

        // Add Extra Cost
        $settings_slider[] = array(
            'name'              => __( "Extra Cost: ({$currency_symbol})", 'text-domain' ),
            'desc_tip'          => __( 'This will automatically add the set cost ontop of the postage cost, meaning you can make money from postage.', 'text-domain' ),
            'id'                => 'RoyalMailExtraCost',
            'type'              => 'number',
            'default_value'     => 0,
            'css'               => 'min-width:300px;',
            'desc'              => __( 'A fixed cost ontop of the postage cost', 'text-domain' ),
        );

        $settings_slider[] = array( 'type' => 'sectionend', 'id' => 'royalmailsettings' );
        return $settings_slider;
    
    /**
     * If not, return the standard settings
     **/
    } else {
        return $settings;
    }
}