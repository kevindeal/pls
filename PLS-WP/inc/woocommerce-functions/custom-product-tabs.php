<?php 
//Add a new custom product tab
add_filter( 'woocommerce_product_tabs', 'ql_new_custom_product_tab' );

function ql_new_custom_product_tab( $tabs ) {
    //To add multiple tabs, update the label for each new tab inside the $tabs['xyz'] array, e.g., custom_tab2, my_new_tab, etc.
    $tabs['lessons'] = array(
        'title' => __( 'Lessons', 'woocommerce' ), //change "Custom Product tab" to any text you want
        'priority' => 50,
        'callback' => 'ql_custom_product_tab_content'
    );

    return $tabs;
}

// Add content to a custom product tab
function ql_custom_product_tab_content() {

    // The custom tab content
    //You can add any php code here and it will be shown in your newly created custom tab
    echo '<h1>Course Lessons</h1>';
    echo '<hr />';
    echo '<h2>Custom Product Tab Content</h2>';
    echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean facilisis in dui eget rutrum. Morbi quis sodales felis.</p>';
    echo '<img src="http://hypernova/wp-content/uploads/2021/10/logo-1.jpg" width="300" height="400" align="center">';
}