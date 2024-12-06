
<?php 
    // Template for displaying a single event item in the support ticket thread
    $item = $args['response'];
    $response_fields = isset($item -> fields['response_fields']) ? $item -> fields['response_fields'] : null;
    $response_text = isset($response_fields['response_text']) ? $response_fields['response_text'] : null;
    $username = isset($item -> fields['user']) ? $item -> fields['user']['display_name'] : null;
    $nice_date = isset($item->post_date) ? date('F j, Y H:i:s', strtotime($item->post_date)) : null;
?>

<script>
    var item = <?php echo json_encode($item -> fields['response_fields']); ?>;
    console.log('response: ', item);
</script>

    <div class="w-full  m-auto h-full border-borderGrey border-2 rounded-xl py-3 px-4">
        <p class="text-base text-blueAgencyBorder font-bold italic ">
            <?php echo $username; ?> @ <?php echo $nice_date ?>
        </p>
        <hr class="border-[1px] border-borderGray my-2" />
        <p class="text-base text-textNeutral">

            Response: <?php echo $response_text; ?>
            
            <?php 
                // echo '<pre>';
                // echo var_dump($response_fields); 
                // echo '</pre>'
            ?>
        </p>
    </div>