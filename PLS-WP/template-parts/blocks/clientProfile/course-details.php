<?php 
  $post_id = get_the_ID();
  // Get the 'course_description_' field value
  $course_description = get_field('course_discription_', $post_id);
  
?>

<div class="w-full m-10 bg-white border-borderGray border-2 rounded-xl py-3 px-4">
<?php
  if ($course_description) {
    // Add a class to the existing <p> tag
    $course_description_with_class = str_replace('<p>', '<p class="course-description">', $course_description);

    // Output the modified course description
    echo $course_description_with_class;
  } else {
    echo '<p>No course description found for this post.</p>';
  }
?>
</div>