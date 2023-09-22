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