<?php
/**
 * Template Name: Support Ticket Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */
?>
<?php 
    acf_form_head(); // Place this before your get_header() function
    get_header() 
?>

<script>
    function toggleDrawer() {
        const el = document.getElementById('drawer-content');
        if (el.style.display === "none") {
            el.style.display = "block";
        } else {
            el.style.display = "none";
        }
    }
</script>

<div class="flex bg-bgGray  p-10 ">
    <!-- Left-Side Navigation Bar -->

    <?php
        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';

        switch ($action) {
            case 'new':
                get_template_part('page-templates/support-tickets/add-new-ticket');
                break;
            case 'billing':
                // Display billing-related tickets
                break;
            default:
                // Display general information or handle unknown category
                break;
        }
    ?>
<div id="uh">
    menu area
</div>
<div class="flex hidden">
    <input type="checkbox" id="drawer-toggle" class="relative sr-only peer" checked>
    <label for="drawer-toggle" class="absolute top-0 left-0 inline-block p-4 transition-all duration-500 bg-indigo-500 rounded-lg peer-checked:rotate-180 peer-checked:left-64">
        <div class="w-6 h-1 mb-3 -rotate-45 bg-white rounded-lg"></div>
        <div class="w-6 h-1 rotate-45 bg-white rounded-lg"></div>
    </label>
    <div id="drawer-content" class="fixed top-0 right-1 z-20 w-64 h-full transition-all duration-500  bg-white shadow-lg peer-checked:translate-x-0">
        <div class="px-6 py-4">
            <h2 class="text-lg font-semibold">Drawer</h2>
            <p class="text-gray-500">This is a drawer.</p>
        </div>
    </div>
</div>

    <!-- Main Content Area -->
    
