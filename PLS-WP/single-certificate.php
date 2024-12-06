<?php
/**
 * Template Name: Certificate Template
 * Post Type: certificate
 */

 get_header(); ?>

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
                 <?php the_content(); ?>
                 <!-- Add any additional template markup here -->
                    <?php get_template_part('post-templates/certificate'); ?>

                </div><!-- .entry-content -->
         </article><!-- #post-<?php the_ID(); ?> -->
         <?php
     endwhile; // End of the loop.
     ?>
 </main><!-- #main -->
 
 <?php get_footer(); ?>
 