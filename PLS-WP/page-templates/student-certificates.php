<?php 
    /*
    * Template Name: Student Certificates Page
    */
    get_header();
    wp_head();
?>

<?php 
    $args = array(
        'post_type'      => 'certificate',
        'meta_key' => 'user',
        'meta_value' => get_current_user_id(),
        'meta_compare' => '=',
    );
    $query = new WP_Query($args);

    $certificates = $query->have_posts() ? $query->posts : null;
    // echo var_dump($certificates);
?>
<div id="main-container" class="inline-flex w-full h-screen bg-[#EFEFF1]">

    <!-- Left-side Nav Bar -->
    <div id="left-sidebar" class="w-1/5 h-screen sticky top-0 ">
        <?php get_template_part('template-parts/blocks/student-nav-bar'); ?>
    </div>


    <div id="content" class="w-4/5 h-full  bg-[#EFEFF1]">

        <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
            <div id="exampleHeader-content" class="w-full space-y-4">
                <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                                
                </div>

                <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                    <div id="headerTitle-icon" class="w-auto">
                        <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                            approval
                        </span>
                    </div>
                    <div id="headerTitle-TextGroup">
                        <p class="text-3xl font-bold">
                            My Certificates
                        </p>
                    </div>

                </div>

                <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                <button onClick="tabChange(event, 'details-container')" id="detailsButton" class="tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                        <span class="material-symbols-outlined">
                            recommend
                        </span>
                        <p>Approved Certifications</p>    
                    </button>
                    <button onClick="tabChange(event, '')" id="peopleButton" class="inactive tabLinks inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                        <span class="material-symbols-outlined">
                            format_align_justify
                        </span>
                        <p>Pending Certifications</p>    
                    </button>    
     
                </div>
            </div>

        </div>
    
        <div id="content-container" class="w-full p-6">
            <div id="approved-certificates-div" class="w-full bg-white p-4 rounded-lg border-[1px] border-borderGray">
                Certs
                <div id="cert-table" class="w-full"></div>
                <button id="addCert" class="w-full mb-4 rounded-full transition-all duration-200  p-2 border-[1px] border-borderGray hover:bg-badgeLightBlue hover:text-blueAgencyForeground">
                    Add Certificate
                </button>
                <img id="cert-area" src="" class="w-full" />
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Create gridjs table
        const myGrid = new gridjs.Grid({
            columns: [
                'Certificate ID', 
                {
                    'name': 'Title', 
                    formatter: (cell) => gridjs.html(`${cell}`)
                },
                'Award Date'
            ],
            data: [
                <?php if ($certificates) : ?>
                    <?php foreach ($certificates as $certificate) : ?>
                        [
                            '<?php echo get_field('certificate_id', $certificate->ID); ?>', 
                            '<a href="<?php echo $certificate->guid ?>"><?php echo $certificate->post_title; ?></a>', 
                            '<?php echo $certificate->post_date; ?>'
                        ],
                    <?php endforeach; ?>
                <?php endif; ?>
            ],
            sort: true,
            search: true,
            pagination: false,
            container: '#cert-table'
        });
        myGrid.render(document.getElementById('cert-table'));
    });

    $("#addCert").click(function() {
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php') ?>',
            type: "POST",
            data: {
                action: 'make_certification_for_student_ajax'
            },
            success: function(response) {
                console.log(response.data);
                if (response.data.base64PNG) {
                    
                    window.open(response.data.base64PNG, '_blank');
                    window.focus();
                    window.location.reload();
                    // $("#cert-area").attr("src", response.data.base64PNG);
                }
            }
        });
    });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<?php wp_footer(); ?>