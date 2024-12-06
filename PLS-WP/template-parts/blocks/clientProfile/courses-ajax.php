<?php 
$subgroup = get_post(256);

$args = array(
    'post_type' => 'acf-subscription',
    'meta_query' => array(
        array(
            'key' => 'client_group',
            'value' => $subgroup->ID,
            'compare' => '=',
        ),
    ),
);

$query = new WP_Query($args);
$subscription_posts = array();

forEach($query->posts as $post) {
    $fields = get_fields($post->ID);
    $subscription_posts[] = array("post" => $post, "fields" => $fields);

}
?>

<div class="w-full h-full">


    <div class="rounded-lg border-2 border-borderGray bg-white w-full  p-4">

    <div class="inline-flex w-full justify-between">
        <div class="w-auto">
            <p class="font-bold">Subscriptions</p>
        </div>
        <div class="w-auto">
            <button class="bg-badgeLightBlue text-black p-2 rounded-lg mt-2" id="create-subscription-button">Add Subscriptions</button>
        </div>
    </div>


        <div id="subscriptions-table"></div>
    </div>
</div>

<script>
    const subscriptions = <?php echo json_encode($subscription_posts); ?>;
    console.log('subscriptions: ', subscriptions);

    const dataArray = [];
    for (var i of subscriptions) {
        dataArray.push([
            i.post.ID,
            i.fields.subscription_start_date,
            i.fields.subscription_end_date,
            i.fields.course.post_title,
            '',
            i.fields.enrolled_group,
            i.fields.seats_taken,
            i.fields.seats,
        ]);
    }

    console.log('dataArray: ', dataArray)
    new gridjs.Grid({
        columns: [
            {'name': 'Subscription',
            'columns': [
                {'name': 'ID',
                    formatter: (cell) => gridjs.html(`<a href='/subscription/${cell}' id='single-sub'>${cell}</button>`)
                },
                {'name': 'Start'},
                {'name': 'End'},
            ],
            },
            {'name': 'Course',
            'columns': [
                {'name': 'Course Name'},
                {'name': 'Total Lessons'},
                {'name': 'Enrolled Groups'},
                {'name': 'Seats Taken'},
                {'name': 'Seats Available'},
            ],
            },
        ],
        data: dataArray,
        sort: true,
        search: true,
        pagination: dataArray.length > 10 ? true : false,
        container: '#subscriptions-table',
        
    }).render(document.getElementById("subscriptions-table"));
</script>

<script>
jQuery(document).ready(function($) {
    // Trigger AJAX call on some event, e.g., click
    $('#coursesButton').click(function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'courses_and_lessons_tp',
                // any other data you want to send to the server
            },
            success: function(response) {
                $('#injectionDiv').html(response); // Insert the response in the DOM
            }
        });
    });
});
</script>