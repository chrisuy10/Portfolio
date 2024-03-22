<?Php

function product_variations_shortcode($atts) {
    // Parse attributes
    $atts = shortcode_atts(array(
        'product_id' => '',
    ), $atts);

    // Check if a product ID is provided
    if (empty($atts['product_id'])) {
        return 'Please provide a product ID';
    }

    // Get product variations
    $product = wc_get_product($atts['product_id']);
    $variations = $product->get_available_variations();

    $output = '<div class="multiselect">
        <div class="selectBox">
            <select id="options-select">
                <option value="">Choose an option / Not Required</option>
            </select>
            <div class="overSelect"></div>
        </div>
        <div id="checkboxes">';

    foreach ($variations as $variation) {
        $variation_id = $variation['variation_id'];
        $variation_title = implode(', ', $variation['attributes']);

        $output .= '<label for="' . $variation_id . '">
            <input type="checkbox" class="checkbox-variation" id="' . $variation_id . '" />' . $variation_title . '
            <input disabled type="text" class="quantity-input inlineRight" value="" placeholder="Qty" />
        </label>';
    }

    $output .= '</div></div>';

    return $output;
}
add_shortcode('product_variations', 'product_variations_shortcode');
// to call in block editor [product_variations product_id="YOUR_PRODUCT_ID"]