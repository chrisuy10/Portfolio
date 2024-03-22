<?php 
// adding custom text on order email notification, before order details table, 
//woocommerce_email_order_details
add_action('woocommerce_email_before_order_table', 'add_custom_content_after_order_details', 20, 4);

function add_custom_content_after_order_details($order, $sent_to_admin, $plain_text, $email) {
    // Check if the email is for order processing
    if ($email->id === 'customer_processing_order') {
        echo '<p><b>Please note that online exclusive items may take up to 2 weeks for your order to be processed and shipped.</b></p>';
    }
}



