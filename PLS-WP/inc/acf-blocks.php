<?php

//add_action('init', 'sundaysky_custom_blocks');

  if (function_exists('acf_register_block_type')) {
    add_action('acf/init', 'register_acf_block_types');

    
    function register_acf_block_types() {
      acf_register_block_type ( 
        array(
          'name' => 'gallery-container',
          'title' => 'Paginated Image Gallery',
          'description' => 'A block for displaying 3-6 images within a paged image gallery.',
          'render_template' => 'template-parts/blocks/gallery.php',
          'icon' => '',
          'keywords' => array('images', 'gallery', 'paginate', 'page'),
        )
      );
      acf_register_block_type ( 
        array(
          'name' => 'allAgencyTable-container',
          'title' => 'All Agency Table',
          'description' => 'A block for all agencies.',
          'render_template' => 'template-parts/blocks/myBlock.php',
          'icon' => '',
          'keywords' => array("tables", "agency"),
        )
      );
      acf_register_block_type ( 
        array(
          'name' => 'agencyDetail-container',
          'title' => 'Single Agency Detail',
          'description' => 'A block for all agencies.',
          'render_template' => 'template-parts/blocks/admin-client-group-detail.php',
          'icon' => '',
          'keywords' => array("detail", "agency", "client", "group"),
        )
      );
      acf_register_block_type ( 
        array(
          'name' => 'example-elements',
          'title' => 'Project Example Elements',
          'description' => 'Example Elements',
          'render_template' => 'template-parts/blocks/example-elements.php',
          'icon' => '',
          'keywords' => array("elements", "example"),
        )
      );
      acf_register_block_type ( 
        array(
          'name' => 'clientProfile-container',
          'title' => 'Project clientprofile Elements',
          'description' => 'clientProfile Elements',
          'render_template' => 'template-parts/blocks/clientProfile/main.php',
          'icon' => '',
          'keywords' => array("client", "example"),
        )
      );
    }
  } 
?>
