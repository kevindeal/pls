
<?php
    if (is_page('shop')) {
        render_store_notice();
    }
?>
<div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>Homepage</p>                
                </button>  
                <a href="<?php echo wc_get_cart_url(); ?>" class="hover:scale-105 transition-all duration-200 bg-white flex justify-center items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-badgeLightBlue hover:text-badgeDarkBlue text-sm">
                    <span class="material-symbols-outlined">
                        shopping_cart
                    </span>
                    <p class="cart-customlocation" title="<?php _e( 'View your shopping cart' ); ?>">
                        <?php echo sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?> - <?php echo WC()->cart->get_cart_total(); ?>
                    </p>
                </a>
         
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">

                    
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        store                        
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold">
						<?php the_title() ?>
					</p>
                    <?php if(isset($args['subheadline'])) : ?>
                        <h1 class="text-base font-thin"><?php echo $args['subheadline'] ?></h1>
                    <?php endif; ?>
                </div>

                <?php if(isset($args['badge'])) : ?>
                    <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                        <p class=" text-badgeDarkBlue">
                            <?php echo $args['badge'] ?>
                        </p>
                    </div>
                <?php endif; ?>

                
            </div>

            <?php
    wp_nav_menu( array( 
        'theme_location' => 'header-menu', 
        'container_class' => 'custom-menu-class' ) ); 
    ?>
        </div>

    </div>

</div>