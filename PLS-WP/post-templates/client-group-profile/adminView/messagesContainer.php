

<?php 
    
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $user_messages = get_posts(array(
        'post_type' => 'support-ticket',
        'meta_query' => array(
            array(
                'key' => 'support_user', // Replace 'support_user' with the actual ACF user field name
                'value' => get_current_user_id(),
                'compare' => '='
            )
        )
    ));

    foreach ($user_messages as &$message) {
        $message->fields = get_fields($message->ID);
    }
    unset($message); // Unset the reference to the last item to avoid potential conflicts

?>


<script>
    var user_messages = <?php echo json_encode($user_messages); ?>;
    console.log('user_messages: ', user_messages);
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $('#create-ticket-button').click(function(){
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    'action': 'create_support_ticket_modal',
                },
                success:function(data) {
                    // This is where you can inject the HTML data into your page
                    $('#some-container').html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            }); 
        });
    });
</script>

<div id="messages-container" class="w-auto bg-white p-4 rounded-xl border-[1px] border-borderGray">

    <div id="details-container" class="w-full ">
        <div id="details-header" class="w-full my-2 flex justify-between items-center">
            <button id="create-ticket-button" class="border-[1px] transition-all duration-150 border-borderGray hover:bg-badgeLightBlue hover:text-badgeDarkBlue inline-flex space-x-1 w-auto p-2 bg-white rounded-lg">
                <span class="material-symbols-outlined mr-2">
                        confirmation_number
                </span>
                Create New Support Ticket
            </button>
        </div>

        <div id="details-body" class="w-full">
           
            <div class="w-full">
                <p class="mt-4 text-xl font-bold text-textNeutral">Your Tickets</p>
                <div id="ticket-table"></div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        const dataArray = [];
                        var user_messages = <?php echo json_encode($user_messages); ?>;
                        for (let i = 0; i < user_messages.length; i++) {
                            const element = user_messages[i];
                            const data = [];
                            data.push(element.fields.title);
                            data.push(element.post_date);
                            data.push(element.fields.ticket_status.label);
                            data.push('<a href="' + element.guid + '">View</a> | <a href="' + element.guid + '">Mark Resolved</a>');
                            dataArray.push(data);
                        }
                        
                        new gridjs.Grid({
                            sort: true,
                            search: dataArray.length > 1 ? true : false,
                            pagination: dataArray.length > 9 ? true : false,
                            columns: [
                                
                                "Topic",
                                "Created",
                                { 
                                    name: 'Status',
                                    formatter: (cell) => gridjs.html(`
                                        <div class="flex justify-center items-center">
                                            <div class="w-3 h-3 rounded-full ${cell == 'Open' ? 'bg-green' : 'bg-yellow'}"></div>
                                            <p class="ml-2">${cell}</p>
                                        </div>`)
                                },
                                { 
                                    name: 'Options',
                                    formatter: (cell) => gridjs.html(`${cell}`)
                                },
                                
                            ],
                            data: dataArray, 
                            
                        }).render(document.getElementById("ticket-table"));
                    });
                </script>
            </div>
        </div>
    </div>
              
        <script>
                function toggleModal(target) {
                    var modal = document.getElementById("modal");
                    modal.remove();
                }
            </script>
<div id="some-container"></div>