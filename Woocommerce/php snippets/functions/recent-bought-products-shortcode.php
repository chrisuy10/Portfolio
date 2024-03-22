<?php 
//[recent_purchased_products] use this
//creating a section block of recently bought products via shortcode, to use in different pages
function recent_purchased_products_shortcode($atts) {
    $args = shortcode_atts(array(
        'limit' => 4,
        'columns' => 4
    ), $atts);

    
    $query_args = array(
        'posts_per_page' => $args['limit'],
        'orderby' => 'date',
        'order' => 'DESC',
        'status' => 'completed', // Retrieve only completed orders
    );

    $recent_orders = wc_get_orders($query_args);


    if ($recent_orders) {
        ob_start();
        echo '<style>
            .recent-product {
                width: 25%;
                display: inline-block;
                vertical-align:top;
                margin: 0;
                padding: 10px;
                box-sizing: border-box;
            }
            .product-title a {
                font-size: 18px;
            }
            .product-title,
            .product-price,
            .purchase-info,
            .purchase-date {
                font-size: 16px;
            }
            @media screen and (max-width: 768px) {
                .recent-product {
                    width: 50%;
                    padding: 10px;
                    box-sizing: border-box;
                }
                .product-title a {
                    font-size: 16px;
                }
                .product-title,
                .product-price,
                .purchase-info,
                .purchase-date {
                    font-size: 14px;
                }
            }
        </style>';

        echo '<ul class="recent-purchased-products" style="list-style: none; margin: 0; padding: 0;">';

        $product_count = 0; // Initialize a count for displayed products

        foreach ($recent_orders as $order) {
            //added this code when encounter fatal error 12-6-23
            if (is_a($order, 'WC_Order_Refund')) {
                $order_id = $order->get_parent_id();
                if ($order_id) {
                    $order = wc_get_order($order_id);
                }
            }

            $order_items = $order->get_items();
            
            $billing_first_name = $order->get_billing_first_name();
            //$billing_last_name_full = $order->get_billing_last_name();
            $billing_last_name = substr($order->get_billing_last_name(), 0, 1);

            foreach ($order_items as $item) {
                if ($product_count >= $args['limit']) {
                    // Limit the number of displayed products
                    break;
                }

                $product = $item->get_product();
                

                echo '<li class="recent-product" >';
                echo '<a href="' . get_permalink($product->get_id()) . '"><div class="product-image">' . $product->get_image() . '</div></a>';
                echo '<div class="product-details">';
                echo '<h2 class="product-title"><a href="' . get_permalink($product->get_id()) . '" class="woocommerce-loop-product__title" >' . $product->get_name() . '</a></h2>';
                echo '<span class="product-price">' . $product->get_price_html() . '</span>';
                echo '<br><span class="purchase-info">Purchased by: ' . $billing_first_name . '.' . $billing_last_name . '</span>';
                echo '<br><span class="purchase-date">Purchased Date: ' . $order->get_date_created()->date('M. d, Y') . '</span>';
                echo '</div>';
                echo '</li>';

                $product_count++;
            }

            if ($product_count >= $args['limit']) {
                // If the limit is reached, exit the loop
                break;
            }
        }
        echo '</ul>';
        wp_reset_postdata();
        return ob_get_clean();
    } else {
        return 'No recent orders found.';
    }
}

add_shortcode('recent_purchased_products', 'recent_purchased_products_shortcode');





