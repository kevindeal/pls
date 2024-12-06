<?php 
    $product_id = get_query_var('product_id', false);
    $single_lesson_post_id = get_fields($product_id);
    $product_type = get_field('field_657b2e7a46bf2', $product_id);

    $product = wc_get_product($product_id);
    
    if ($product_type == "standard_course_package") {
        echo "standard_course_package";
        $product_course = get_field('field_656f978dab460', $product_id);
        $curriculum = get_field('field_656f97a0ab461', $product_course);
        
    }
?>

<br />
    <?php
        $terms = get_the_terms( $single_lesson_post_id, array( 'states-accepted') );

        // Dispaly the taxonomies, if there one or more.
        echo var_dump($single_lesson_post_id);
    ?>
    <br />
<link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />

<div class="grid grid-cols-2 gap-4 w-full mt-2 mb-4">
        sdsdf
        <li><dfsdul>Total Credit Hours: </ul></li>
       
        <li>Credit Hour Types: </li>
        <li>Course Accreditation Number: </li>
        <li>Accreditation Agencies: </li>
        <li>States where approved: </li>
        <li>States where accepted: </li>
        <li>Price per User: </li>
        <li>Other: </li>

</div>
<div id="myTable"></div>
<script>
        document.addEventListener('DOMContentLoaded', function () {
            // const users = <?php echo json_encode($nice_people); ?>;

            
            const dataArray = ["Lorem",
                    "Ipsum",
                    "Dolor",
                    "Sit",
                    "Amet"];
            
            
            new gridjs.Grid({
                sort: true,
                search: true,
                pagination: true,
                columns: [
                    "States where approved",
                    "States where accepted:",
                    "Accreditation Agencies",
                    "Total Credit Hours:",
                    "Credit Hour Types",
                ],
                data: dataArray, 
            }).render(document.getElementById("myTable"));
        });
    </script>
<?php
      echo '<pre>';
      echo var_dump($curriculum);
      echo '</pre>';
