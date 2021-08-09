<?php
/*
Plugin Name: Royal Mail Postage for WooCommerce
Plugin URI: https://github.com/bxdavies/royalmail-postage-for-woocommerce
Description: Adds and Calculates Postage based on Royal Mail
Version: 1.1.0
Author: BXDavies
Author URI: https://github.com/bxdavies
*/

/*
*  Check if WooCommerce is active
*/
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    
    // Creates a settings page for Royal Mail Postage
    include plugin_dir_path(__FILE__). 'includes/settings.php';
    
    /**
     * Initializes the Plugin 
     *
     * @return void
     */

    add_action('woocommerce_shipping_init', 'initRoyalMailPostage');

    function initRoyalMailPostage()
    {

        /**
         * Class for First Class Postage
         */
        class FirstClassPostage extends WC_Shipping_Method
        {

            /**
             * Initialize First Class Postage properties
             *
             * @return void
             */
            public function __construct( $instance_id = 0 )
            {
                $this->id               = 'first_class_postage';
                $this->method_title     = __('Royal Mail First Class');
                $this->title            = __("Royal Mail First Class");
                $this->instance_id      = absint($instance_id);

                $this->supports  = array(
                    'shipping-zones'
                );
            }

            /**
             * Calculate Shipping Cost for First Class Postage
             */
            public function calculate_shipping( $package = array() )
            {
                // Get function used to calculate First Class Postage
                include plugin_dir_path(__FILE__). 'includes/calculate-postage.php';

                // Get result of function and add extra cost
                $postage_cost = $calculate_first_class_postage() + get_option('RoyalMailExtraCost');

                // Register the rate
                $this->add_rate($postage_cost);
            }
        }

        /**
         * Class for Second Class Postage
         */
        class SecondClassPostage extends WC_Shipping_Method
        {

            /**
             * Initialize Second Class Postage properties
             *
             * @return void
             */
            public function __construct($instance_id = 0)
            {
                $this->id               = 'second_class_postage';
                $this->method_title     = __('Royal Mail Second Class');
                $this->title            = __("Royal Mail Second Class");
                $this->instance_id      = absint($instance_id);

                $this->supports  = array( //Does this need to be an array?
                    'shipping-zones'
                );
            }
            
            /**
             * Calculate Shipping Cost for Second Class Postage
             */
            public function calculate_shipping( $package = array() ) // Can we remove $package?
            {
                // Get function used to calculate Second Class Postage
                include plugin_dir_path(__FILE__). 'includes/calculate-postage.php';

                // Get result of function and add extra cost
                $postage_cost = $calculate_second_class_postage() + get_option('RoyalMailExtraCost');

                // Register the rate
                $this->add_rate($postage_cost);
            }
        }
    }

    /**
     *  Add the Shipping different shipping options to WooCommerce
     *
     *  @return $methods
     */

    add_filter('woocommerce_shipping_methods', 'addRoyalMailPostage');

    function addRoyalMailPostage( $methods )
    {
        $methods['RM_FirstClass'] = 'FirstClassPostage';
        $methods['RM_SecondClass'] = 'SecondClassPostage';
        return $methods;
    }
}
