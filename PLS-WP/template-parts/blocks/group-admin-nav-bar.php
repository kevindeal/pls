  <!-- Admin Navbar Template Partial -->
  <!-- Author: Hugh Huffstutler -->
  <!-- Created: 11/03/2023 -->
  
  <?php 
  // wp_nav_menu( array( 'theme_location' => 'sidebar-menu', 'container_class' => 'my_sidebar_menu_class' ) );

?>

<?php 
    $current_user = wp_get_current_user();
    $args = array(
        'post_type' => 'subgroup', // Replace with your custom post type
        'posts_per_page' => -1, // Adjust as needed
    );
    
    $subgroups_query = new WP_Query($args);
    $subgroups = $subgroups_query->get_posts();
    $client_group = null;

    /*
    foreach($subgroups as $subgroup) {
        $client_group_admins = get_field('client_group_admin', $subgroup->ID);
        foreach($client_group_admins as $client_group_admin) {
            if ($client_group_admin['ID'] == $current_user->ID) {
                $subgroups[] = $subgroup;
                $client_group = get_fields($subgroup->ID);
            }
        }
    }
    */

    ?>
    <script>
        const subgroups = <?php echo json_encode($subgroups); ?>;
        console.log(subgroups);
    </script>

<?php
  $current_page = $_SERVER['REQUEST_URI'];

?>

<nav class=" bg-blueAgencyForeground h-full sticky top-0 left-0">

<div class="inline-flex w-full justify-evenly items-center p-2">
    <div class="w-1/4 p-1 rounded-lg shadow-lg">
        <img class=" w-14 h-12 my-4" src="/wp-content/uploads/2024/01/pls-shapes.png" alt="Agency Logo">
    </div>
    <div w="w-full items-center">
        <p class=" ml-2 text-sm font-semibold text-white "><?php echo $current_user->display_name ?></p>

        <p class=" ml-2 text-sm font-semibold text-white "><?php echo isset($client_group['agency_name']) ? $client_group['agency_name'] : "" ?></p>
    </div>
</div>
  <ul >
        
    <li class="p-2">      
        <a href="/subgroup/springfield-police-dept/" class="<?php echo (strpos($current_page, 'subgroup') !== false) ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left text-white font-bold  hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">local_police</span>
            Agency Groups
        </a>
    </li>
  
    <li class="p-2">      
      <a href="/subgroup/springfield-police-dept/#people" class="<?php echo ($current_page === '/admin-people/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
        <span class="material-symbols-outlined px-2">group</span>         
        People
      </a>
    </li>

      
    <li class="p-2">      
      <button class="inline-flex items-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
        <span class="material-symbols-outlined px-2">school</span>
        Courses + Lessons
      </button>
    </li>
          
    <li class="p-2">      
      <a class="<?php echo ($current_page === '/admin-reports/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex inline-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
        <span class="material-symbols-outlined px-2">description</span>
          Reports
      </a>
    </li>

    <li class="p-2">      
      <a href="/shop" class="inline-flex inline-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
        <span class="material-symbols-outlined px-2">shopping_cart</span>
          Store
      </a>
    </li>

  </ul>
</nav>