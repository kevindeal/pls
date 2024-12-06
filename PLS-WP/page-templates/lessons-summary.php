<?php
/*
Template Name: Lessons Archive
*/
?>
<?php get_header(); ?>
<section class="bg-blueAgencyBorder py-20">
<h1 class="text-center py-10 text-3xl font-bold text-white"><?php the_title(); ?></h1>
  <!-- // Your custom loop to display LearnPress lessons goes here -->
  <?php
  $args = array(
    'post_type'      => 'acf-lesson', // LearnPress lesson post type
    'posts_per_page' => -1,
    'orderby'        => 'date',       // Order by post date
      'order'          => 'DESC',       // Display in descending order (most recent first)           // Display all lessons
  );
  
  ?>
   

  <?php
  $query = new WP_Query($args);
  
  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post(); 
      // Output your lesson content here
      
      get_template_part('template-parts/blocks/lesson-summary-block', get_post_format());

      

    endwhile;
    wp_reset_postdata();
  else :
    echo 'No lessons found';
  endif;
  ?>
</section>
<?php
get_footer();
?>