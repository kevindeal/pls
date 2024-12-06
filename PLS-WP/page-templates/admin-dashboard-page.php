<?php
/**
 * Template Name: Admin Dashboard Page
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */

 $headline = get_field('headline_text');
 $subHeadline = get_field('sub-headline_text');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Other links and scripts -->
        <title>
            <?php echo esc_html($headline); ?>
        </title>
        <?php wp_head(); ?> <!-- This is important for WordPress to load additional styles and scripts -->
    </head>
    <body <?php body_class(); ?>>
    <div class="flex bg-bgGray h-screen ">
        <div class="w-1/12 min-w-max">
            <?php get_template_part('template-parts/blocks/admin-nav-bar'); ?>
        </div>
        <div class="flex-grow">

        <div id="contentHeader" class="flex items-center bg-white w-full p-2 h-24 space-x-2">
            <div id="headerIcon" class="w-12 h-12 bg-black rounded">
                <!-- Icon content goes here -->
            </div>
            <div id="headerTitleGroup">
                <h1 class="font-bold text-xl">
                    <?php echo esc_html($headline); ?>
                </h1>
                <h2>
                    <?php echo esc_html($subHeadline); ?>
                </h2>
            </div>
        </div>

        
        <div id="content" class="w-100 h-full p-2">
        
        <div id="widget-row" class="hidden inline-flex w-full space-x-2 inline-center">
            <div id="example widget" class="w-full h-full bg-white rounded p-2">
                <h1>Example Widget</h1>
                <p>Widget content goes here</p>
            </div>
            <div id="example widget" class="w-full h-full bg-white rounded p-2">
                <h1>Example Widget</h1>
                <p>Widget content goes here</p>
            </div>
        </div>

        <div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Output the content of the current post/page.
            the_content();

            // If comments are open or there is at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        // End the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

    </div>
    </body>
</html>
