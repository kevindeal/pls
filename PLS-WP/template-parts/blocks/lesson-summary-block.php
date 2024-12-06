
  <?php
  // echo var_dump($args);
  $details = $args['details'];
  $lessons = $details['lessons'];
  
  ?>

<?php
  foreach($lessons as $lesson):
    $categories = get_the_terms($lesson->ID, 'course-category');
    
?>
<div class="m-10">
  <article class="w-full bg-white border-borderGray border-2 rounded-xl p-4" id="post-<?php echo $lesson->ID; ?>" <?php post_class(); ?>>
  
    <header class="entry-header">
        <h2 class="entry-title text-xl font-bold text-blueAgencyForeground"><?php echo $lesson->post_title; ?></h2>
    </header>
    <div class="flex justify-between text-xs mb-4">
      <!-- addcat -->
      <?php
        if ($categories && !is_wp_error($categories)) {
          // Output the categories
          echo '<p>';

          $category_count = count($categories);
          $i = 1;
          //  style to show link 
          foreach ($categories as $category) {
              echo '<a href="' . get_term_link($category) . '">' . 
              esc_html($category->name) . '</a>';

              // Add "|" if it's not the last category
              if ($i < $category_count) {
                  echo ' | ';
              }

              $i++;
          }

          echo '</p>';
      } else {
          echo '<p>No categories found.</p>';
      }
      ?>
      <div class="lesson-date"><?php echo get_the_date('',$lesson->ID); ?></div>
    </div>
    <div class="entry-content">
      <?php
         // Retrieve 'lesson summary' directly from post meta
         $lesson_summary = get_post_meta($lesson->ID, 'lesson_summary', true);

         // Check if 'lesson summary' exists and is not empty
         if (!empty($lesson_summary)) {
             echo '<div class="lesson-summary">' . wpautop(esc_html($lesson_summary)) . '</div>';
         } else {
             echo get_the_content(null, false, $lesson->ID);
         }
         ?>
    </div> 
  </article>
</div>
<?php endforeach;
?>
