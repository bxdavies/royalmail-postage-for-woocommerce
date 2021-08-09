<?php
$large_letter_volume = get_option('RoyalMailLargeLetterVolume'); 
$small_parcel_volume  =  get_option('RoyalMailSmallParcelVolume'); 
$medium_parcel_volume = get_option('RoyalMailMediumParcelVolume'); 

// First Class
$calculate_first_class_postage = function() use ($large_letter_volume, $small_parcel_volume, $medium_parcel_volume)
{

    $cost = 0;
    $total_cart_volume = 0;

    foreach ( WC()->cart->get_cart() as $item_id => $item ) {

        $product = $item['data'];

        $quantity = $item['quantity'];
        $length = $product->get_length();
        $width = $product->get_width();
        $height = $product->get_height();

        for ($i = 1; $i <= $quantity; $i++) 
        {
            $total_cart_volume =  $total_cart_volume + ($length * $width * $height);
        } 
    }

    $TotalCartWeight = WC()->cart->cart_contents_weight;

    // Large Letter
    if ($TotalCartWeight <= 0.750 && $total_cart_volume <  $large_letter_volume)
    {
        if($TotalCartWeight <= 0.100)
        {
            $cost = 1.29;
        }
        elseif($TotalCartWeight <= 0.250)
        {
            $cost = 1.83;
        }
        elseif($TotalCartWeight <= 0.500)
        {
            $cost = 2.39;
        }
        elseif($TotalCartWeight <= 0.750)
        {
            $cost = 3.30;
        }
        return array(
            'label' => 'Royal Mail First Class - Large Letter',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }

    // Small Parcel
    else if($TotalCartWeight < 2 && $total_cart_volume <   $small_parcel_volume)
    {
        if($TotalCartWeight <= 1)
        {
            $cost = 3.85;
        }
        elseif($TotalCartWeight <= 2)
        {
            $cost = 5.57;
        }
        return array(
            'label' => 'Royal Mail First Class - Small Parcel',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }

    // Medium Parcel
    else if($TotalCartWeight < 20 && $total_cart_volume <   $medium_parcel_volume)
    {   
        if ($TotalCartWeight <= 1)
        {
                $cost = 6.00;
        }
        elseif ($TotalCartWeight <= 2)
        {          
                $cost = 9.02;
        }
        elseif ($TotalCartWeight <= 5)
        {
                $cost = 15.85;
        }
        elseif ($TotalCartWeight <= 10)
        {
                $cost = 21.90;
        }
        elseif ($TotalCartWeight <= 20)
        {
            
                $cost = 33.40;
        }
        return array(
            'label' => 'Royal Mail First Class - Medium Parcel',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }

    // Can't fit in one parcel so going to use multiple parcels
    else
    {
        $NumberOfParcels = 0;
        if ($total_cart_volume > $medium_parcel_volume)
        {
            $NumberOfParcels = $NumberOfParcels + ceil($total_cart_volume / $medium_parcel_volume);
        }
          
        
        if ($TotalCartWeight > 20)
        {
            $NumberOfParcels = $NumberOfParcels + ceil($TotalCartWeight / 20);
        }
        
        for ($i = 1; $i <= $NumberOfParcels; $i++) 
        {
            if($TotalCartWeight > 20)
            {
                $cost = $cost + 33.40;
                $TotalCartWeight - 20;
            }
            else {
                if ($TotalCartWeight <= 1)
                {
                        $cost = $cost + 6.00;
                }
                elseif ($TotalCartWeight <= 2)
                {          
                        $cost = $cost + 9.02;
                }
                elseif ($TotalCartWeight <= 5)
                {
                        $cost = $cost +15.85;
                }
                elseif ($TotalCartWeight <= 10)
                {
                        $cost = $cost + 21.90;
                }
                elseif ($TotalCartWeight <= 20)
                {
                        $cost = $cost + 33.40;
                }
            }
        } 
            
        return array(
            'label' => 'Royal Mail First Class -' . $NumberOfParcels . 'x Medium Parcels',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }
};


/**
 * Calculate Shipping Cost for Second Class Postage
 * 
 * @return array with cost
 */
$calculate_second_class_postage = function() use ($large_letter_volume, $small_parcel_volume, $medium_parcel_volume)
{
    $cost = 0;
    $total_cart_volume = 0;

    foreach ( WC()->cart->get_cart() as $item_id => $item) {

        $product = $item['data'];

        $quantity = $item['quantity'];
        $length = $product->get_length();
        $width = $product->get_width();
        $height = $product->get_height();

        for ($i = 1; $i <= $quantity; $i++) 
        {
            $total_cart_volume =  $total_cart_volume + ($length * $width * $height);
        } 
    }

    $TotalCartWeight = WC()->cart->cart_contents_weight;

    // Large Letter
    if ($TotalCartWeight <= 0.750 && $total_cart_volume <  $large_letter_volume)
    {
        if($TotalCartWeight <= 0.100)
        {
            $cost = 0.96;
        }
        elseif($TotalCartWeight <= 0.250)
        {
            $cost = 1.53;
        }
        elseif($TotalCartWeight <= 0.500)
        {
            $cost = 1.99;
        }
        elseif($TotalCartWeight <= 0.750)
        {
            $cost = 2.70;
        }
        return array(
            'label' => 'Royal Mail Second Class - Large Letter',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }

    // Small Parcel
    else if($TotalCartWeight < 2 && $total_cart_volume <   $small_parcel_volume)
    {
        if($TotalCartWeight <= 1)
        {
            $cost = 3.20;
        }
        elseif($TotalCartWeight <= 2)
        {
            $cost = 3.20;
        }
        return array(
            'label' => 'Royal Mail Second Class - Small Parcel',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }

    // Medium Parcel
    else if($TotalCartWeight < 20 && $total_cart_volume <   $medium_parcel_volume)
    {   
        if ($TotalCartWeight <= 1)
        {
                $cost = 5.30;
        }
        elseif ($TotalCartWeight <= 2)
        {          
                $cost = 5.30;
        }
        elseif ($TotalCartWeight <= 5)
        {
                $cost = 8.99;
        }
        elseif ($TotalCartWeight <= 10)
        {
                $cost = 20.25;
        }
        elseif ($TotalCartWeight <= 20)
        {
                $cost = 28.55;
        }
        return array(
            'label' => 'Royal Mail Second Class - Medium Parcel',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }

    // Can't fit in one parcel so going to use multiple parcels
    else
    {
        $NumberOfParcels = 0;
        if ($total_cart_volume > $medium_parcel_volume)
        {
            $NumberOfParcels = $NumberOfParcels + ceil($total_cart_volume / $medium_parcel_volume);
        }
          
        
        if ($TotalCartWeight > 20)
        {
            $NumberOfParcels = $NumberOfParcels + ceil($TotalCartWeight / 20);
        }
        
        for ($i = 1; $i <= $NumberOfParcels; $i++) 
        {
            if($TotalCartWeight > 20)
            {
                $cost = $cost + 28.55;
                $TotalCartWeight - 20;
            }
            else {
                if ($TotalCartWeight <= 1)
                {
                        $cost = $cost + 5.30;
                }
                elseif ($TotalCartWeight <= 2)
                {          
                        $cost = $cost + 8.99;
                }
                elseif ($TotalCartWeight <= 5)
                {
                        $cost = $cost + 20.25;
                }
                elseif ($TotalCartWeight <= 10)
                {
                        $cost = $cost + 20.25;
                }
                elseif ($TotalCartWeight <= 20)
                {
                        $cost = $cost + 28.55;
                }
            }
        } 
            
        return array(
            'label' => 'Royal Mail Second Class -' . $NumberOfParcels . 'x Medium Parcels',
            'cost' => $cost,
            'calc_tax' => 'per_item'
        );
    }
};