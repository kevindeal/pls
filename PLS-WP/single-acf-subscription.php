<?php
/**
 * Template Name: Subscription Template
 */

 get_header();
 wp_head();
  ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <main id="main" class="site-main" role="main">
     <?php
     while ( have_posts() ) : the_post();
         ?>
         <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
             
         <?php /*
            <header class="entry-header">
                 <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
             </header><!-- .entry-header -->
            */ ?>
 
             <div class="entry-content">
                 <?php // the_content(); ?>
                 <!-- Add any additional template markup here -->
                    <?php get_template_part('post-templates/subscription-info'); ?>

                </div><!-- .entry-content -->
         </article><!-- #post-<?php the_ID(); ?> -->
         <?php
     endwhile; // End of the loop.
     ?>
 </main><!-- #main -->
 
    <?php
        get_footer();
        wp_footer();
    ?> <!-- Essential for WordPress scripts and styles -->
 </body>