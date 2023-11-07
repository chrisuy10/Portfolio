<?php
//OCT2023 chris - show hidden products on specific pages
function show_product() {
    // Define an array of product IDs
    $product_ids = array(28828, 29978, 29997, 30013, 30028);
    
    $page_slug = 'rhinos-uniforms-testing'; // Replace with your common page slug

    if (is_page($page_slug)) {
        $visibility = 'visible';
    } else {
        $visibility = 'hidden';
    }

    // Loop through the product IDs
    foreach ($product_ids as $product_id) {
        // Get an instance of the product variation
        $child_product = wc_get_product($product_id);

        // Change the product visibility
        $child_product->set_catalog_visibility($visibility);

        // Save and sync the product visibility
        $child_product->save();
    }
}

add_action('wp', 'show_product');



function enqueue_custom_ajax_script() {
    // Enqueue the jQuery library as a dependency if it's not already loaded
    wp_enqueue_script('jquery');

    // Pass the admin-ajax.php URL to the script
    wp_localize_script('jquery', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

    // Ensure the script is only loaded on the specific page where you need it
    if (is_page('rhinos-uniforms-testing')) {
        // Add your JavaScript code directly within the script tags
        wp_add_inline_script('jquery', '
            // Your JavaScript code here
        ');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_ajax_script');


// Define an AJAX action to add products to the cart
add_action('wp_ajax_add_to_cart', 'add_to_cart_callback');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart_callback'); // For non-logged-in users

function add_to_cart_callback() {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the products data from the AJAX request
        $products = $_POST['products'];

        // Initialize WooCommerce session (if not already done)
        if (!WC()->cart) {
            WC()->cart = new WC_Cart();
        }

        foreach ($products as $product) {
            // Check if the product data is valid
            if (isset($product['product_id'], $product['quantity'], $product['variation_id'])) {
                $product_id = intval($product['product_id']);
                $quantity = intval($product['quantity']);
                $variation_id = intval($product['variation_id']);

                // Add the product to the cart
                WC()->cart->add_to_cart($product_id, $quantity, $variation_id);
            }
        }

        // Return a response (success, error, etc.) if needed
        wp_send_json_success(); // For a successful response
        // Or wp_send_json_error(); for an error response
    }
    wp_die(); // This is required to terminate the AJAX response
}


