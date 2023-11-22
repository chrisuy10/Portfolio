<?
//august 2023 - hide price and addtocart button on certain products
add_action('wp_head', 'hide_price_add_to_cart_for_specific_products');

function hide_price_add_to_cart_for_specific_products() {
    $product_ids_to_hide = array(4548, 4569, 4582, 4547); // Add your product IDs here
    
    $current_product_id = get_the_ID();
    
    if (is_product() && in_array($current_product_id, $product_ids_to_hide)) {
        echo '<style>.single_add_to_cart_button, .product-discount, .pick-up-options { display: none; }</style>';
    }
}

<?php 
add_action('woocommerce_cart_calculate_fees', 'action_woocommerce_cart_calculate_fees', 10, 1);
function action_woocommerce_cart_calculate_fees($cart) {
    if (!current_user_can('administrator')) {
        return;
    }

    // Discount percentage
    $percentage = discount_basedon_points();

    $subtotal = $cart->subtotal;
    $tax_total = $cart->get_subtotal_tax();
    $total_before_tax = $subtotal - $tax_total;

    // Calculate discount before taxes
    $discount = $total_before_tax * ($percentage / 100);

    // Round the discount to two decimal places
    $discount = round($discount, 2);

    // Apply discount on the total before tax
    $cart->add_fee(sprintf(__('%s%% OFF', 'woocommerce'), $percentage), -$discount);
}


add_action('wp_ajax_discount_basedon_points', 'discount_basedon_points');
add_action('wp_ajax_nopriv_discount_basedon_points', 'discount_basedon_points');
function discount_basedon_points() {
    // Ensure the data has been sent and received properly
    if (
        isset($_POST['appliedDiscount']) &&
        isset($_POST['cartSubtotal']) &&
        isset($_POST['updatedSubtotal'])
    ) {
        $applied_discount = $_POST['appliedDiscount'];
        $cart_subtotal = $_POST['cartSubtotal'];
        $updated_subtotal = $_POST['updatedSubtotal'];

        // Determine the discount percentage based on the appliedDiscount value
        $new_discount = 0;

        if ($applied_discount === '3') {
            $new_discount = 3;
        } elseif ($applied_discount === '6') {
            $new_discount = 6;
        } elseif ($applied_discount === '9') {
            $new_discount = 9;
        } elseif ($applied_discount === '12') {
            $new_discount = 12;
        }
        
        // Perform other operations here based on your requirements

        // Return the determined discount percentage
        wp_send_json($new_discount . '%');
    } else {
        // Handle error if the data is not complete
        wp_send_json_error('Incomplete data received');
    }
    return $new_discount;
}



