document.addEventListener('DOMContentLoaded', function () {
    var seatsInput = document.getElementById('number_of_seats');
    var productIdInput = document.querySelector('input[name="add-to-cart"]');

    seatsInput.addEventListener('change', function() {
        var numberOfSeats = this.value;
        var productId = productIdInput.value;

        // Set up our HTTP request
        var xhr = new XMLHttpRequest();

        // Setup our listener to process completed requests
        xhr.onreadystatechange = function () {
            // Only run if the request is complete
            if (xhr.readyState !== 4) return;

            // Process our return data
            if (xhr.status >= 200 && xhr.status < 300) {
                // This will run when the request is successful
                var response = JSON.parse(xhr.responseText);
                if(response.success) {
                    document.querySelector('.price').innerHTML = response.data.price_html;
                }
            } else {
                // This will run when it's not successful
                console.error('The request failed!');
            }
        };

        // Create and send a GET request
        xhr.open('POST', myAjax.ajaxurl);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('action=calculate_dynamic_price&nonce=' + myAjax.nonce + '&product_id=' + productId + '&seats=' + numberOfSeats);
    });
});
