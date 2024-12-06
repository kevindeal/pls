<?php 
    // Template Name: Rustici Registrations

    ?>

<?php get_header();
    wp_head(); ?>

    <?php 
        $output = get_all_registrations_from_rustici();
    ?>
<div id="main-container" class="inline-flex w-full h-full min-h-screen bg-[#EFEFF1]">

    <div id="content" class="w-full mr-4 h-full  bg-[#EFEFF1]">

        <div id="exampleHeader-container" class="w-full inline-flex">
            <div id="exampleHeader-content" class="w-full space-y-4">
                <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                                
                </div>

                <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                    <div id="headerTitle-icon" class="w-auto">
                        <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 38px">
                            album
                        </span>
                    </div>
                    <div id="headerTitle-TextGroup">
                        <p class="text-3xl font-bold">
                            Rustici - Registration Records
                        </p>
                    </div>

                </div>

                <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                
     
                </div>
            </div>

        </div>

        <div id="content" class="w-full pr-4 pl-0 gap-2">
            <div id="queryOptions" class="w-full inline-flex justify-start align-middle gap-4 my-2">
                <div class="w-1/3">
                    <label for="startDate">Start Date</label>
                    <input type="date" id="startDate" class="w-full border-[1px] border-borderGray rounded-md p-2" />
                </div>
                <div class="w-1/3">
                    <label for="endDate">End Date</label>
                    <input type="date" id="endDate" class="w-full border-[1px] border-borderGray rounded-md p-2" />
                </div>
                <div class="h-full justify-items-center align-middle w-1/3">
                    Run Query

                    <button id="search" class="w-full border-[1px] border-borderGray text-textNeutral hover:bg-badgeLightBlue transition-all duration-200 p-2 rounded-md">
                        Search 

                    </button>
                </div>

            </div>

            <div id="registrationTableContainer" class="w-full">
                <div id="registrationTable"></div>
            </div>
        </div>
    </div>
</div>

<?php get_footer();
    wp_footer(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var datePicker = document.getElementById('endDate');
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        datePicker.setAttribute('max', today);
    });

    $(document).ready(function() {
        var registrations = <?php echo json_encode($output); ?>;
        console.log('registrations: ', registrations.registrations);
        // Create GridJS table

        const dataArray = [];
        registrations.registrations.forEach(registration => {
            dataArray.push([
                registration.id,
                registration.createdDate ? new Date(registration.createdDate).toLocaleDateString() : '',
                registration.course.id,
                registration.course.title,
                registration.lastAccessDate ? new Date(registration.lastAccessDate).toLocaleDateString() : '',
                registration.learner.id
            ]);
        });
        const myGrid = new gridjs.Grid({
            columns: [
                'Id', 
                'Created', 
                'Course Id',
                'Course Title',
                'Last Access', 
                'Learner Id'
            ],
            data: dataArray,
            sort: true,
            search: true,
            pagination: true,
            style: {
                td: {
                border: '1px solid #ccc'
                },
                table: {
                    'font-size': '10px', 'wrap-word': 'true', 'overflow-wrap': 'break-word'
                }
            }
        })
        
        myGrid.render(document.getElementById('registrationTable'));

        function updateGridTable(newData) {

            const dataArray = [];
            newData.forEach(registration => {
                dataArray.push([
                    registration.id,
                    registration.createdDate ? new Date(registration.createdDate).toLocaleDateString() : '',
                    registration.course.id,
                    registration.course.title,
                    registration.lastAccessDate ? new Date(registration.lastAccessDate).toLocaleDateString() : '',
                    registration.learner.id
                ]);
            });
            myGrid.updateConfig({
                data: dataArray
            }).forceRender();
        }

        $('#search').click(function() {
            // var queryOptions = $('#queryOptions').val();
            // alert('Search button clicked')
            $('#search').addClass('animate-bounce');

            var startDate = $('#startDate').val();
            startDate = startDate ? new Date(startDate).toISOString() : null;
            var endDate = $('#endDate').val();
            endDate = endDate ? new Date(endDate).toISOString() : null;
            console.log('queryOptions: ', queryOptions);
            console.log('startDate: ', startDate);
            console.log('endDate: ', endDate);
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'get_rustici_registrations_ajax',
                    // queryOptions: queryOptions,
                    startDate: startDate,
                    endDate: endDate,
                },
                success: function(response) {
                    console.log('Response: ', response);
                    // $('#registrationTable').html(response.data.html);
                    updateGridTable(response?.data?.registrations);
                    $('#search').removeClass('animate-bounce');

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
    