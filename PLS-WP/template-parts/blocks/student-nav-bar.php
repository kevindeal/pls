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
 
    $args = array(
        'post_type' => 'subgroup', // Replace with your custom post type
        'posts_per_page' => -1, // Adjust as needed
        'meta_query' => array(
            array(
                'key' => 'agency_members',
                'value' => $current_user->ID,
                'compare' => 'LIKE'
            )
        )
    );
    $try = new WP_Query($args);
    $client_group_posts = $try->get_posts();
    $client_group = get_fields($client_group_posts[0]);

    ?>
    <script>
        const subgroups = <?php echo json_encode($subgroups); ?>;
        console.log('subgroups', subgroups);
    </script>

<?php
  $current_page = $_SERVER['REQUEST_URI'];

?>

<nav class=" bg-white h-full sticky top-0 left-0">

<div class="inline-flex w-full justify-evenly items-center p-2">
    <div class="w-1/3 p-1 rounded-lg shadow-lg items-center">
        <img class=" w-14 aspect-square m-auto" src="/wp-content/uploads/2024/01/pls-shapes-dark.png" alt="Agency Logo">
    </div>
    <div w="w-full items-center">
        <p class=" ml-2 text-sm font-semibold  text-badgeDarkBlue "><?php echo $current_user->display_name ?></p>

        <p class=" ml-2 text-sm font-semibold  text-badgeDarkBlue "><?php echo isset($client_group['agency_name']) ? $client_group['agency_name'] : ""; ?></p>
    </div>
</div>
  <ul >
    <li class="p-2">      
      <a href="/student-dashboard/" class="<?php echo ($current_page === '/student-dashboard/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left text-badgeDarkBlue font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
        <span class="material-symbols-outlined px-2">school</span>
        My Lessons
      </a>
    </li>
        
    <li class="p-2">      
        <a href="/student-certificates/" class="<?php echo ($current_page === '/student-certificates/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left  text-badgeDarkBlue font-bold  hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
            <span class="material-symbols-outlined px-2">star</span>
            My Certificates
        </a>
    </li>
  
    <li class="p-2">      
      <a href="/student-support/" class="<?php echo ($current_page === '/student-support/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left  text-badgeDarkBlue font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
        <span class="material-symbols-outlined px-2">support_agent</span>         
        Support
      </a>
    </li>

      
    <li class="p-2">      
      <a href="/student-settings/" class="<?php echo ($current_page === '/student-settings/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left  text-badgeDarkBlue font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-300">
        <span class="material-symbols-outlined px-2">settings</span>
          Settings
      </a>
    </li>


  </ul>
</nav>