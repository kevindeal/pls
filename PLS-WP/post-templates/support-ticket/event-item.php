
<?php 
    // Template for displaying a single event item in the support ticket thread
    $event = $args['event'];
    $event_type = isset($event['event_type']) ? $event['event_type'] : null;
    $event_message = isset($event['event_message']) ? $event['event_message'] : null;
    $username = isset($event['user']) ? $event['user']['display_name'] : null;

?>

<script>
    var event = <?php echo json_encode($args); ?>;
    console.log('event: ', event);
</script>

<?php 
    if($event['event_type'] == 'pending') {
        ?>
        <div class="w-3/5 m-auto h-full border-yellow bg-yellow bg-opacity-20 border-2 rounded-xl py-3 px-4">

            <div class="inline-flex place-items-center w-full">
                <div id="event-icon" class="w-2/10 mr-2 inline-flex place-items-center">
                    <span class="material-symbols-outlined">
                        pending_actions
                    </span>
                </div>
                <div id="event-text" class="w-8/10 inline-flex place-items-center">
                    <p class="text-base font-bold text-textNeutral inline-flex place-items-center">
                        Marked <?php echo ucfirst($event['event_type']); ?>
                        <br />
                        <?php if(strlen($event['event_message']) > 0) : ?>
                            <br />
                            Event Message: <?php echo $event['event_message']; ?>
                        <?php endif; ?>
                    </p>
                </div>    
            </div>
            
        </div>
        <?php
    } else if($event['event_type'] == 'paused') {
        ?>
        <div class="w-3/5 m-auto h-full bg-badgeLightBlue border-blueAgencyBorder border-2 rounded-xl py-3 px-4">
        <p class="text-base font-bold  text-textNeutral">
                Event Status: <?php echo $event['event_type']; ?>
            </p>
        <p class="text-base text-textNeutral">
            Event Submitted By: ljkj
        </p>
        <p class="text-base text-textNeutral">
            Event Message: <?php echo $event['event_message']; ?>
        </p>
        </div>
    <?php 
        } else if($event['event_type'] == 'closed') {
            ?>
            <div class="w-3/5 m-auto h-full border-badgeLightBlue bg-badgeLightBlue bg-opacity-20 border-2 rounded-xl py-3 px-4">

                <div class="inline-flex place-items-center w-full">
                    <div id="event-icon" class="w-2/10 mr-2 inline-flex place-items-center">
                        <span class="material-symbols-outlined">
                            check_circle
                        </span>
                    </div>
                    <div id="event-text" class="w-8/10 inline-flex place-items-center">
                        <p class="text-base font-bold text-textNeutral inline-flex place-items-center">
                            Marked <?php echo ucfirst($event['event_type']); ?>
                            <br />
                            Event Message: <?php echo $event['event_message']; ?>
                        </p>
                    </div>    
                </div>

            </div>
        <?php 
            } else {
                ?>
                <div class="w-3/5 m-auto h-full border-blueAgencyBorder bg-beige bg-opacity-20 border-2 rounded-xl py-3 px-4">
    
                    <div class="inline-flex place-items-center w-full">
                        <div id="event-icon" class="w-2/10 mr-2 inline-flex place-items-center">
                            <span class="material-symbols-outlined">
                                event
                            </span>
                        </div>
                        <div id="event-text" class="w-8/10 inline-flex place-items-center">
                            <p class="text-base font-bold text-textNeutral inline-flex place-items-center">
                                
                                <br />
                                Event Message: <?php echo $event['event_message']; ?>
                            </p>
                        </div>    
                    </div>
    
                </div>
        <?php
        }
        ?>
    