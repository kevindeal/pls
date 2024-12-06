<?php 
    $product_id = get_query_var('product_id', false);
    $single_lesson_post_id = get_fields($product_id);
    $thing = get_fields($product_id);

    $course_id = $thing['acf_product_course']->ID;
    
    $course_fields = get_fields($course_id);
    $product_type = get_field('field_657b2e7a46bf2', $product_id);

    $product = wc_get_product($product_id);
    
    if ($product_type == "standard_course_package") {
        // echo "standard_course_package";
        $thing = get_fields($product_id);
        echo '<pre>';
        // echo var_dump($course_fields);
        echo '</pre>';
        $product_course = get_field('field_656f978dab460', $product_id);
        // $curriculum = get_field('field_656f97a0ab461', $product_course);
        $curriculum = $course_fields['curriculum'];

        $total_credit_hours = 0;
        foreach($curriculum as $key => $item) {
            $fields =  get_fields($item['lesson']->ID);
            $curriculum[$key]['fields'] = $fields; // Modify the original array directly

            $credit_hours = $fields['lesson_credit_details']['credit_hours'];
            $total_credit_hours += intval($credit_hours);
        }


        // Get the product thumbnail source
        $thumbnail_src = get_the_post_thumbnail_url($product_id);
        // echo "Product Thumbnail Source: " . $thumbnail_src;
    }
?>

<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<br />
    <?php
        $terms = get_post_taxonomies( $course_id, 'states-accepted');

        // Dispaly the taxonomies, if there one or more.
        // var_dump($terms);

        $taxonomy = 'states-approved'; // Your custom taxonomy slug

        $terms = wp_get_post_terms($course_id, $taxonomy, array("fields" => "names")); // Fetching term names
        $accepted = wp_get_post_terms($course_id, 'states-accepted', array("fields" => "names")); // Fetching term names
        
        if (!is_wp_error($terms) && !empty($terms)) {
            // echo 'States Accepted: ' . implode(', ', $terms);
            $states_accepted = $terms; // Displaying terms as a comma-separated list
        } else {
            // echo 'No states accepted listed for this post.';
        } 

        $aa_group = get_fields($course_fields['accreditation-approvals'][0]->ID);

        ?>
    <br />
<div class="w-1/2">
<h2 class="text-xl font-bold mb-1">Course Description</h2>
    <p >
    <?php 
        $acf_content = get_fields($course_id);
        echo $acf_content['course_discription_'];
        // echo $thing['acf_product_course']->post_content; 
    ?>
    </p>
    <div class="grid grid-cols-2 gap-4 w-auto mt-2 p-2 mb-4 ">

        <li>Course Accreditation Number: </li>
        <li>Price per User: </li>
        <li>Other: </li>

</div>
</div>

<div id="accreditation-approvals" class="w-full mt-1">
    <h2 class="text-xl font-bold">Accreditation Approvals</h2>
    <div id="accreditation-approvals-table"></div>
</div>

<div id="lessons" class="w-full mt-4">
    <h2 class="text-xl font-bold">Course Lessons</h2>
    <div id="lessonsTable"></div>
</div>
<script>

    console.log('course_fields: ', <?php echo json_encode($course_fields); ?>);
    console.log('thing: ', <?php echo json_encode($thing); ?>);
    console.log('curriculum: ', <?php echo json_encode($curriculum); ?>);
    console.log('states_accepted: ', <?php echo json_encode($states_accepted); ?>);
    console.log('accepted: ', <?php echo json_encode($accepted); ?>); 
        document.addEventListener('DOMContentLoaded', function () {
            var statesAccepted = <?php echo json_encode($states_accepted); ?>.map((state) => state.toUpperCase());
            var approved = <?php echo json_encode($accepted); ?>.map((state) => state.toUpperCase());
            var accreditationApprovals = <?php echo json_encode($course_fields['accreditation-approvals']); ?>;

            var AA_group = <?php echo json_encode($aa_group); ?>;
            console.log('AA_group: ', AA_group);

            const mergedArray = [...new Set(statesAccepted.concat(approved))];
            const dataArray = [];
            mergedArray.map((state) => {
                dataArray.push([
                    state ? state : null,
                    statesAccepted.includes(state) ? "True" : "False",
                    approved.includes(state) ? "True" : "False",
                    AA_group['state'].toUpperCase() == state.toUpperCase() ? AA_group['agency_details']['name'] : "",
                    <?php echo $total_credit_hours; ?>,
                ]);
            });
            
            
            new gridjs.Grid({
                sort: true,
                search: true,
                pagination: true,
                columns: [
                    "State",
                    {
                        'name': 'Accepted', 
                        formatter: (cell) => gridjs.html(`
                                        <div class="flex justify-center w-full items-center ${cell == 'True' ? 'text-blueAgencyBorder' : 'text-yellow'}">
                                            <span class="material-symbols-outlined">${cell == 'True' ? 'check_circle' : ''}</span>
                                        </div>
                                        `)                    
                    },
                    {
                        'name': 'Approved', 
                        formatter: (cell) => gridjs.html(`
                                        <div class="flex justify-center w-full items-center ${cell == 'True' ? 'text-blueAgencyBorder' : 'text-yellow'}">
                                            <span class="material-symbols-outlined">${cell == 'True' ? 'check_circle' : ''}</span>
                                        </div>
                                        `)                    
                    },
                    "Accreditation Agencies",
                    "Total Credit Hours",
                    "Credit Hour Types",
                ],
                data: dataArray, 
                pagination: dataArray.length > 10 ? true : false,
                search: dataArray.length > 10 ? true : false,
            }).render(document.getElementById("accreditation-approvals-table"));
        });
    </script>

<script>

    console.log('course_fields: ', <?php echo json_encode($course_fields); ?>);
    console.log('thing: ', <?php echo json_encode($thing); ?>);
    console.log('curriculum: ', <?php echo json_encode($curriculum); ?>);
    console.log('states_accepted: ', <?php echo json_encode($states_accepted); ?>);
    console.log('accepted: ', <?php echo json_encode($accepted); ?>); 

        document.addEventListener('DOMContentLoaded', function () {
            var curriculum = <?php echo json_encode($curriculum); ?>;


            console.log('curriculum2: ', curriculum);
            var dataArray = [];
            curriculum.map((lesson) => {
                dataArray.push([
                    lesson['lesson']['post_title'],
                    lesson['lesson_description'],
                    lesson['lesson_category'],
                    lesson['fields']['lesson_credit_details']['credit_hours'],
                ]);
            });        
            
            new gridjs.Grid({
                sort: true,
                search: true,
                pagination: true,
                columns: [
                    "Title",
                    "Description",
                    "Category",
                    "Credit Hours",
                ],
                data: dataArray, 
                pagination: dataArray.length > 10 ? true : false,
                search: dataArray.length > 10 ? true : false,
            }).render(document.getElementById("lessonsTable"));
        });
    </script>






