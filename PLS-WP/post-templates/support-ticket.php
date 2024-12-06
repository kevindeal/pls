<?php
/**
 * Template Name: Support Ticket Parent Template
 * Template Post Type: support-ticket
 */
?>

<?php 
    // acf_form_head(); // Place this before your get_header() function
    get_header();

    $responses = get_support_ticket_responses( get_the_ID() );
    $parent_fields = get_fields( get_the_ID() );
    $parent_ticket_id = get_the_ID();
    $created_by = get_post_field( 'post_author', $parent_ticket_id );
    $created_by_user = get_user_by( 'ID', $created_by );
    $created_at = get_the_date('F j, Y H:i:s', $parent_ticket_id);
    $nice_date = isset($created_at) ? date('F j, Y H:i:s', strtotime($created_at)) : null;

    $ticket_status = isset($parent_fields['ticket_status']) ? $parent_fields['ticket_status'] : null;
    $assigned_to = isset($parent_fields['assigned_to']) ? $parent_fields['assigned_to']['display_name'] : null;
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var responses = <?php echo json_encode($responses); ?>;
    console.log('responses: ', responses);
    var parent_fields = <?php echo json_encode($parent_fields); ?>;
    console.log('parent_fields: ', parent_fields);
</script>

<script>
    function toggleModal() {
        var modal = document.getElementById("modal");
        modal.remove();
    }
</script>
<div class="flex bg-bgGray  p-10 ">
    <!-- Left-Side Navigation Bar -->


    <!-- Main Content Area -->
    <div class="w-full m-10 h-full bg-white border-borderGray border-2 rounded-xl py-3 px-4 space-y-4">
        <h1 class="text-3xl font-bold text-textNeutral">
            <?php echo $parent_fields['title']; ?>
        </h1>
        <p id="submitted-by" class="text-base font-bold italic text-textNeutral ">
            <?php echo $parent_fields['support_user']["display_name"]; ?> @ <?php echo $nice_date; ?>
        </p>
        <div id="ticket-status-info" class="w-full inline-flex">
            <?php if (isset($assigned_to)) : ?>
                <div class="w-1/2">
                    <p class="text-base italic text-textNeutral">
                        Assigned To: <?php echo $assigned_to ?>
                    </p>
                </div>
            <?php endif; ?>
            <?php if (isset($parent_fields['ticket_status'])) : ?>
                <div class="w-1/2">
                    <p class="text-base italic text-textNeutral">
                        Ticket Status: <?php echo $parent_fields['ticket_status']['label']; ?>
                    </p>
                </div>
            <?php endif; ?>
            <div class="w-1/2">
                <p class="text-base italic text-textNeutral">
                    Severity: <?php echo $parent_fields['severity']; ?>
                </p>
            </div>
        </div>
        <hr class="border-[1px] border-borderGray my-2" />
        <p class="text-base text-textNeutral">
            <?php echo $parent_fields['request_text']; ?>
        </p>

        
        <hr class="border-[1px] border-borderGray my-2" />

        <?php 
            while ( have_posts() ) : the_post();
        ?>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        <?php
            endwhile; // End of the loop.
        ?>    

        <?php 
            foreach( $responses as $response ) {
                if( isset($response -> fields['response_type']) 
                    && $response -> fields['response_type'] == 'event') {
                        // echo var_dump($response);
                    get_template_part('post-templates/support-ticket/event-item', null, array('event' => $response -> fields['event_fields']));
                } else {
                    get_template_part('post-templates/support-ticket/response-item', null, array('response' => $response));
                }
            }
        ?>

<script>
    jQuery(document).ready(function($) {
        $('#addReplyButton').click(function(){
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                method: 'POST', // Set the request method to POST
                data: {
                    'action': 'add_reply_modal',
                    'ticket_id': <?php echo $parent_ticket_id; ?>,
                    // additional data here
                },
                success:function(data) {
                    // This is where you can inject the HTML data into your page
                    // console.log('data: ', data);
                    $('#some-container').html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            }); 
        });

        $('#addEventButton').click(function(){
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                method: 'POST', // Set the request method to POST
                data: {
                    'action': 'add_event_modal',
                    'ticket_id': <?php echo $parent_ticket_id; ?>,
                    // additional data here
                },
                success:function(data) {
                    // This is where you can inject the HTML data into your page
                    // console.log('data: ', data);
                    $('#some-container').html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            }); 
        });
    });
</script>




        <div class="w-full inline-flex m-auto justify-center space-x-4 p-2">
            <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center" id="addReplyButton">
                <span>Add Reply</span>
            </button>

            <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center" id="addEventButton">
                <span>Add Event</span>
            </button>
        </div>
    
    </div>
</div>

<div id="some-container"></div>
