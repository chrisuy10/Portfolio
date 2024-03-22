<?
//hide shop and product page, only book a bin page for customer ordering
function disable_woocommerce_pages() {
    if (is_shop() || is_product() || is_product_category() || is_product_tag()) {
        wp_redirect(home_url('/ooops-page-not-found/'), 301);
        exit;
    }
}
add_action('template_redirect', 'disable_woocommerce_pages');