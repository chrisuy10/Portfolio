<?php 
// downloadd json data or specific order number, by this way https://rbiaustralia.com.au/?order_json=32777
// Custom endpoint to retrieve order JSON data
add_action('init', 'custom_endpoint_for_order_json');
function custom_endpoint_for_order_json() {
    // Check if the request matches the custom endpoint structure
    if (isset($_GET['order_json']) && is_numeric($_GET['order_json'])) {
        $order_id = intval($_GET['order_json']);
        display_order_json_data($order_id);
    }
}
/*
// Function to retrieve and output order JSON data
function display_order_json_data($order_id) {
    // Get the order data based on the $order_id
    $order = wc_get_order($order_id);

    // Check if the order exists
    if ($order) {
        // Get the order data in an array
        $order_data = $order->get_data();

        // Convert order data to JSON format
        $json_data = json_encode($order_data, JSON_PRETTY_PRINT);

        // Set headers for file download or display in a new tab
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="order_' . $order_id . '.json"'); // For download
        // header('Content-Disposition: inline'); // For displaying in a new tab

        // Output JSON data
        echo $json_data;
        exit; // Stop further execution
    } else {
        echo 'Order not found.';
    }
}
*/
function display_order_json_data($order_id) {
    $order = wc_get_order($order_id);

    if ($order) {
        $order_data = $order->get_data();

        // Fetch fee lines and append additional details to each fee line
        $fee_lines = $order->get_fees();

        $order_data['fee_lines'] = array();
        foreach ($fee_lines as $fee_item_id => $fee_item) {
            $fee_line_data = $fee_item->get_data();
            // Append more details as needed

            $order_data['fee_lines'][] = $fee_line_data;
        }

        $json_data = json_encode($order_data, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="order_' . $order_id . '.json"');

        echo $json_data;
        exit;
    } else {
        echo 'Order not found.';
    }
}
