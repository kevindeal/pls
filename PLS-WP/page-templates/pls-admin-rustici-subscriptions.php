<?php 
    // Template Name: Rustici - Subscriptions

    ?>

<?php get_header();
    wp_head(); ?>

    <?php 
        $output = get_all_subscriptions_from_rustici();
    ?>

    <div id="content" class="w-full h-full mr-4 bg-[#EFEFF1]">

        <div id="exampleHeader-container" class="w-full mr-4 inline-flex">
            <div id="exampleHeader-content" class="w-full">
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
                            Rustici - Subscriptions
                        </p>
                    </div>

                </div>

                <div id="headerTabGroup" class="w-full bg-white inline-flex "></div>
            </div>

        </div>

        <div id="content" class="w-full pr-4 pl-0 gap-2">
            <div class="w-full p-4 bg-white rounded-lg border-[1px] border-borderGray gap-2">
            Create New Subscription
            <div id="queryOptions" class="w-full inline-flex justify-start align-middle gap-4 my-2">

                <div class="w-1/4">
                    <label class="text-sm" for="startDate">Topic</label>
                    <select id="subscription_topic" class="mb-2 w-full border-[1px] border-borderGray rounded-md p-2">
                        <option value="RegistrationChanged">RegistrationChanged</option> CourseLaunched
                        <option value="CourseImport">CourseImport</option>
                        <option value="CourseLaunched">CourseLaunched</option> 
                        <option value="NotificationFailed">NotificationFailed</option> 
                    </select>
                    <br />
                    <label class="text-sm" for="startDate">Subtopics</label>

                    <select id="subtopics" class="w-full border-[1px] border-borderGray rounded-md p-2">
                        
                    </select>

                </div>
                <div class="w-1/3">
                    <label class="text-sm" for="endDate">Endpoint URL</label>
                    <input id="subscription_url" class="w-full border-[1px] border-borderGray rounded-md p-2" />
                </div>
                <div class="w-1/4">
                    <label class="text-sm" for="endDate">Ignore Before Date (Optional)</label>
                    <input id="ignoreBeforeDate" type="date" class="w-full border-[1px] border-borderGray rounded-md p-2" />
                </div>
                <div class="h-full justify-items-center align-middle w-1/3">
                    Run Query

                    <button id="search" class="w-full border-[1px] border-borderGray text-textNeutral hover:bg-badgeLightBlue transition-all duration-200 p-2 rounded-md">
                        Create Subscription 

                    </button>
                </div>

            </div>
</div>

            <div id="registrationTableContainer" class="w-full">
                <div id="registrationTable"></div>
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
        var subscriptions = <?php echo json_encode($output['subscriptions']); ?>;
        console.log('subscriptions: ', subscriptions);
        // Create GridJS table

        const dataArray = [];
        subscriptions.forEach(subscription => {
            dataArray.push([
                subscription.id,
                subscription.definition.url,
                subscription.lastUpdate ? new Date(subscription.lastUpdate).toLocaleString() : '',
                subscription.definition.topic,
                subscription.lastExceptionDate ? new Date(subscription.lastExceptionDate).toLocaleString() : '',

            ]);
        });
        const myGrid = new gridjs.Grid({
            columns: [
                'Id',
                'URL', 
                'Last Updated', 
                'Topic',
                'Last Exception',
            ],
            data: dataArray,
            sort: true,
            search: true,
            pagination: dataArray.length > 10 ? true : false,
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

        $("#subscription_topic").change(function() {
            var topic = $("#subscription_topic").val();
            console.log('topic: ', topic);
            if(topic === "RegistrationChanged") {
                $("#subtopics").html(`
                    <option value="ScoreChanged">ScoreChanged</option>
                    <option value="CompletionChanged">CompletionChanged</option>
                    <option value="SuccessChanged">SuccessChanged</option>
                    <option value="ObjectiveChanged">ObjectiveChanged</option>
                    <option value="InteractionChanged">InteractionChanged</option>
                    <option value="Exit">Exit</option>
                    <option value="RunTimeActivityCompletionChanged">RunTimeActivityCompletionChanged</option>
                    <option value="RunTimeActivitySuccessChanged">RunTimeActivitySuccessChanged</option>
                `);
            } else if(topic === "CourseLaunched") {
                $("#subtopics").html(`
                    <option value="">-None-</option>
                `);
            } else if(topic === "CourseImport") {
                $("#subtopics").html(`
                    <option value="">Success</option>
                    <option value="Failure">Failure</option>
                `);
            } else if(topic === "NotificationFailed") {
                $("#subtopics").html(`
                    <option value="InitialAttempt">InitialAttempt</option>
                    <option value="FinalAttempt">FinalAttempt</option>
                `);
            }
        });
        $('#search').click(function() {
            // var queryOptions = $('#queryOptions').val();
            // alert('Search button clicked')
            $('#search').addClass('animate-bounce');

            var subscription_topic = $('#subscription_topic').val();
            var subtopics = $('#subtopics').val();
            var subscription_url = $('#subscription_url').val();
            var ignoreBeforeDate = $('#ignoreBeforeDate').val();
            ignoreBeforeDate = ignoreBeforeDate ? new Date(ignoreBeforeDate).toISOString() : null;
            
            console.log('subscription_topic: ', subscription_topic);
            console.log('subtopics: ', subtopics);
            console.log('subscription_url: ', subscription_url);
            console.log('ignoreBeforeDate: ', ignoreBeforeDate);

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'create_rustici_subscription_ajax',
                    // queryOptions: queryOptions,
                    subscription_topic: subscription_topic,
                    subtopics: subtopics,
                    subscription_url: subscription_url,
                    ignoreBeforeDate: ignoreBeforeDate,
                },
                success: function(response) {
                    console.log('Response: ', response);
                    // $('#registrationTable').html(response.data.html);
                    setTimeout(() => {
                        window.location.reload();
                    }, 200);

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
    