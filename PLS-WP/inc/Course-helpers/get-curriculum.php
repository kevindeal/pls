
<?php
  function get_curriculum($courseID) {
    $course = get_post($courseID);
    $course_curriculum = get_field('curriculum', $courseID);
    $course_settings = get_field('course_settings', $courseID);

    $lessons = [];
    $quizzes = [];
    $lesson_cats = [];

    if (have_rows('curriculum', $courseID)) {
      while (have_rows('curriculum', $courseID)) {
        the_row();

        if (get_row_layout() == 'lesson') {
          $lesson_post_object = get_sub_field('lesson');

          if ($lesson_post_object) {
            $lesson_post_id = is_numeric($lesson_post_object) ? $lesson_post_object : $lesson_post_object->ID;
            $lesson_data = [];
            $lesson_title = get_the_title($lesson_post_object);
            $lesson_cat = get_the_terms($lesson_post_object, 'course-category');
            
            $lessons[$lesson_post_id] = $lesson_post_object;
            $lesson_cats[$lesson_post_id] = $lesson_cat;
          }
        } elseif (get_row_layout() == 'quiz') {
          $quiz_post_object = get_sub_field('quiz');

          if ($quiz_post_object) {
            $quiz_post_id = is_numeric($quiz_post_object) ? $quiz_post_object : $quiz_post_object->ID;
            $quiz_title = get_the_title($quiz_post_object);
          }

          $quizzes[$quiz_post_id] = $quiz_post_object;
        }
      }
    }

    return [
      'lessons' => $lessons,
      'quizzes' => $quizzes,
      'lesson_categories' => $lesson_cats,
    ];

  }
?>