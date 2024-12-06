<?php 
    /* Template Name: Certificate Creator */
    get_header();
    wp_head();

    $args = array(
        'post_type'      => 'certificate-type'
    );
    $query = new WP_Query($args);

    $templates = $query->have_posts() ? $query->posts : null;

    // echo var_dump($templates)
    // Loop through posts and output content as above
    
?>
    <div class="w-full  gap-4 justify-center p-1 bg-white font-bold inline-flex">
        
        <p>Certificate Type Template: </p>

        <select id="templateSelector">
            <option id="null" value=""> - Select a template - </option>
            <?php foreach($templates as $template) {
                ?> <option value="<?php echo $template->ID ?>"><?php echo $template->post_title ?></option> <?php
            } ?>
        </select>
    </div>
<div class="w-full min-h-screen h-full p-2">

    <div class="w-full inline-flex" id="currentCert">
    <div class="w-1/4 p-4 ">
        <select id="templateSelector" >
            <option id="null" value=""> - Select a template - </option>
            <?php foreach($templates as $template) {
                ?> <option value="<?php echo $template->ID ?>"><?php echo $template->post_title ?></option> <?php
            } ?>
            
        </select>
        <button>
            <img src="https://pls-dev1-testing.local/wp-content/uploads/2024/02/award-of-excellence.jpg" alt="PLS Logo" class="w-full" />
        </button>
    </div>
        <div class="w-auto">
        <h1 class="text-4xl font-bold">Certificate Creator</h1>
        
        <div id="preview" class="w-full">
            
        </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('input', function(event) {
        if (event.target.classList.contains('input-class-name')) {
            var dataTarget = event.target.getAttribute('data-target');
            // alert(dataTarget);
            console.log("Data Target:", dataTarget);
            console.log(this)
            document.getElementById(dataTarget).innerText = event.target.value;

            // Additional logic based on dataTarget
        }
    });
    document.body.addEventListener('input', function(event) {
        if (event.target.classList.contains('number-input')) {
            // Assuming `event.target` is your input element
            var currentValue = parseInt(event.target.value, 10); // Get the current value as a number

            // Retrieve the previous value; if it doesn't exist, default to the current value
            var previousValue = parseInt(event.target.dataset.prevValue || currentValue, 10);

            // Compare current and previous values to determine direction
            if (currentValue > previousValue) {
                console.log('Increasing');
            } else if (currentValue < previousValue) {
                console.log('Decreasing');
            }

            // Update the previous value stored on the element for the next event
            event.target.dataset.prevValue = currentValue;

            // Your existing logic to adjust `top` or other properties
            var dataTarget = event.target.getAttribute('data-target');
            var element = document.getElementById(dataTarget); // Get the target element
            var style = window.getComputedStyle(element);

            var movingAttr = event.target.getAttribute('id') === 'top_cords' ? parseInt(style.getPropertyValue("top"), 10) : parseInt(style.getPropertyValue("left"), 10);; // Parse the "top" value as an integer

            if (!isNaN(movingAttr)) {
                // Adjust the top value based on whether it's increasing or decreasing
                // For demonstration, simply increasing by 1; adjust as necessary
                event.target.getAttribute('id') === 'top_cords' ? element.style.top = (movingAttr + (currentValue > previousValue ? -1 : +1)) + "px" : element.style.left = (movingAttr + (currentValue > previousValue ? -1 : +1)) + "px";
                // element.style.top = (top + (currentValue > previousValue ? -1 : +1)) + "px";
            } else {
                console.log("The 'top' value is not a number. It might be 'auto' or not set at all.");
                element.style.top = "1px"; // Default action or handle differently
            }
        }
    });

});
    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('personNameArea').innerText = this.value;
    });
</script>
<script>

    document.getElementById('name').addEventListener('input', function() {
        document.getElementById('personNameArea').innerText = this.value;
    });
    document.getElementById('date').addEventListener('input', function() {
        document.getElementById('dateArea').innerText = this.value;
    });
    document.getElementById('signature').addEventListener('input', function() {
        document.getElementById('signatureArea').innerText = this.value;
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    $("#templateSelector").on('change', function () {
        var certTemplateID = $('#templateSelector').val();
        if (certTemplateID == '') {
            // $('#error-message').text('Invite code is required');
            return;
        }
        // alert(certTemplateID);

        // $('#submit-arrow').hide();
        // $('#submit-spinner').show();
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>', // This is the URL to the WordPress admin-ajax.php file
            method: 'POST',
            data: { 
                action: 'certificate_template_editor_ajax_tp',
                certTemplateID: certTemplateID
            },
            success: function(response) {
                // Handle the response from the server
                console.log(response);
                $("#currentCert").html(response)
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.error(' Error: ', error);
            }
        });
    });
</script>

