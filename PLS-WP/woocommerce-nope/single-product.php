<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

    <?php
        /**
         * woocommerce_before_main_content hook
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         */
        do_action( 'woocommerce_before_main_content' );
    ?>

    <div class="custom-single-product-layout">
        <div class="product-description">
            <?php
                while ( have_posts() ) {
                    the_post();
                    wc_get_template_part( 'content', 'single-product' );
                }
            ?>
        </div>
        
        <div class="product-price-summary">
            <?php
                /**
                 * Custom action to display price and add to cart form.
                 * You need to hook your custom functions here.
                 */
                do_action( 'woocommerce_custom_single_product_price_summary' );
            ?>
        </div>
    </div>

    <div class="related-products">
		dslfkadflkajsdflkj
        <?php
            /**
             * woocommerce_after_single_product_summary hook
             *
             * @hooked woocommerce_output_related_products - 20
             */
            do_action( 'woocommerce_after_single_product_summary' );
        ?>
    </div>

    <?php
        /**
         * woocommerce_after_main_content hook
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action( 'woocommerce_after_main_content' );
    ?>

<?php get_footer( 'shop' ); ?>
