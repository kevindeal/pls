<?php ?>

<div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 mb-4">
        <div id="exampleHeader-content" class="w-full space-y-4">
        <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <a href="/shop" class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>Store</p>                
                </a>             
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4 mb-4">
                <div id="headerTitle-icon" class="w-auto">

                    
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        
                        <?php
                            if (is_checkout()) {
                                echo 'shopping_cart_checkout';
                            } else if (is_cart()) {
                                echo 'shopping_cart';
                            }
                        ?>
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

                <div class="hidden rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                    <p class=" text-badgeDarkBlue">
                        Badge
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>