jQuery(document).ready(function($) {
    $('#myButton').click(function(){
        $.ajax({
            url: my_ajax_object.ajax_url,
            data: {
                'action': 'my_ajax_action',
                // additional data here
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