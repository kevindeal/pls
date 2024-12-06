<?php

function add_lesson_event_to_learning_record($enrollmentID, $lessonID, $rowData) {
    
    // Get the learning_records array from the enrollment
    $learning_records = get_field('learning_records', $enrollmentID);

    $registration_event = array(
        'event_time' => date('Y-m-d H:i:s'),
        'event_type' => 'function',
        'event_data' => array(
            'course_id' => '',
            'learner_id' => '',
            'registration_id' => '',
        )
    );

    foreach ($learning_records as &$item) {

        // Find the matching lesson in the learning_records array
        if ($item['lesson']->ID == $lessonID) {

            // Append the new event to the lesson_events of the current item
            
            $item['lesson_events'][] = $registration_event;
            // $item['lesson_start_time'] = date('Y-m-d H:i:s');
            $item['current_registration_id'] = $registrationId;

            // Update the learning_records array in the enrollment
            update_field('learning_records', $learning_records, $enrollmentID);

            // Break the loop if you only need to add this to the first matching lesson
            // break;
            return $item;
        }
    }
}