  <!-- Admin Navbar Template Partial -->
  <!-- Author: Hugh Huffstutler -->
  <!-- Created: 11/03/2023 -->
  
<?php 
  // wp_nav_menu( array( 'theme_location' => 'sidebar-menu', 'container_class' => 'my_sidebar_menu_class' ) );
?>

<?php
  $current_page = $_SERVER['REQUEST_URI'];
?>

<nav style="background-color: rgb(37,37,40);" class="p-4 h-full h-100 pt-4">
  <ul class="py-1">
    <li class="py-1">      
      <a href="/admin-dashboard-home" class="<?php echo ($current_page === '/admin-dashboard-home/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-200">
        <span class="material-symbols-outlined px-2">home</span>
        Home
      </a>
    </li>
    
    <hr class="h-1 bg-dividerGray"></hr>
    
    <li class="py-1">      
    <a href="/admin-groups/" class="inline-flex items-center px-4 py-4 rounded w-full text-left text-white font-bold  hover:bg-black hover:text-hoverLightBlue transition-colors duration-200">
        <span class="material-symbols-outlined px-2">local_police</span>
         Agencies
</a>
    </li>
  
    <li class="py-1">      
      <a href="/admin-people" class="<?php echo ($current_page === '/admin-people/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex items-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-200">
        <span class="material-symbols-outlined px-2">group</span>         
        People
      </a>
    </li>

    <hr class="h-1 bg-dividerGray"></hr>
      
    <li class="py-1">      
      <button class="inline-flex items-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-200">
        <span class="material-symbols-outlined px-2">school</span>
        Courses
      </button>
    </li>
      
    <li class="py-1">      
      <button class="inline-flex inline-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-200">
        <span class="material-symbols-outlined px-2">assignment</span>
        Lessons
      </button>
    </li>
          
    <li class="py-1">      
      <a href="/admin-reports" class="<?php echo ($current_page === '/admin-reports/') ? 'bg-badgeLightBlue' : ''; ?> inline-flex inline-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-200">
        <span class="material-symbols-outlined px-2">description</span>
          Reports
      </a>
    </li>

    <hr class="h-1 bg-dividerGray"></hr>
          
    <li class="py-1">      
      <button class="inline-flex inline-center px-4 py-4 rounded w-full text-left text-white font-bold hover:bg-black hover:text-hoverLightBlue transition-colors duration-200">
        <span class="material-symbols-outlined px-2">chat</span>  
        Messages / Tickets
      </button>
    </li>

  </ul>
</nav>