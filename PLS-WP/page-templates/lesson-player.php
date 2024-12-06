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

        <div class="w-screen bg-white h-screen">
            
            <div class="main-content w-screen h-screen">
                <!-- Your main content goes here -->
                
                    
                <div id="playerBox" class="w-screen h-screen">
                    <?php
                        $launchLink = $_GET['launchLink']; // Get the value of the "launchLink" parameter from the URL
                        $iframeSrc = 'https://pls-dev.engine.scorm.com' . $launchLink; // Concatenate the base URL with the launchLink parameter
                    ?>

                    <iframe class="w-screen h-screen" frameborder="0" src="<?php echo $iframeSrc; ?>">
                        This feature requires inline frames. You have iframes disabled or your browser does not support them.
                    </iframe>
                </div>
            </div>
        </div>
        <?php
            // get_footer();
        ?> <!-- This is important for WordPress to load additional styles and scripts -->
    </body>

