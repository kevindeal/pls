<?php
/**
 * Template Name: Lesson Player Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Other links and scripts -->
        <title>
            <?php echo the_title() ?>
        </title>
        <?php
            wp_head(); 
        ?> <!-- This is important for WordPress to load additional styles and scripts -->
    </head>

    <body <?php body_class(); ?>>
    <div class="flex bg-bgGray h-screen ">
        hello!
    </div>
    </body>
</html>