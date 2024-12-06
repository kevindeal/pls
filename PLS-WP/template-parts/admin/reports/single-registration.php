<?php 
    $data = $args['data'];

    echo '<pre>';
    // echo var_dump($data);
    echo '</pre>';
?>

<div class="w-full p-2 inline-flex space-x-2">
    <button id="basic-registration-info-btn" class="font-bold border-2 border-blueAgencyBorder p-2">Basic Registration Info</button>
    <button id="activity-info-btn" class="font-bold border-2 border-blueAgencyBorder p-2">Activity Information</button>
    <button id="runtime-info-btn" class="font-bold border-2 border-blueAgencyBorder p-2">Runtime Interactions</button>
</div>

<div id="basic-registration-information">
    <p class="font-bold italic">Basic Registration Information</p>
        
    <div  class="grid grid-cols-2 gap-2">
        <p>Registration ID: <?php echo $data['id'] ?></p>
        <p>Created Date: <?php echo $data['createdDate'] ?></p>
        <p>First Access Date: <?php echo $data['firstAccessDate'] ?></p>
        <p>Last Access Date: <?php echo $data['lastAccessDate'] ?></p>
        <p>xapi Registration ID: <?php echo $data['xapiRegistrationId'] ?></p>
        <p>Registration ID: <?php echo $data['id'] ?></p>
        <p>Registration ID: <?php echo $data['id'] ?></p>
    </div>


    <div id="course-info">
        <p class="font-bold italic">Course Information</p>
        <div class="grid grid-cols-2">

            <p>Course ID: <?php echo $data['course']['id'] ?></p>
            <p>Course Title: <?php echo $data['course']['title'] ?></p>
            <p>Version ID: <?php echo $data['course']['version'] ?></p>
        </div>
    </div>

    <div id="learner-info">
        <p class="font-bold italic" >Learner Information</p>
        <div class="grid grid-cols-2 gap-2">

            <p>First Name: <?php echo $data['learner']['firstName'] ?></p>
            <p>Last Name: <?php echo $data['learner']['lastName'] ?></p>
            <p>Learner ID: <?php echo $data['learner']['id'] ?></p>
        </div>
    </div>
</div>


<div id="activity-info">
    <p class="font-bold italic" >Activity Information</p>
    <div class="grid grid-cols-2 gap-2">
        <p>Attempts: <?php echo $data['activityDetails']['attempts'] ?></p>
        <p>Activity Completion: <?php echo $data['activityDetails']['activityCompletion'] ?></p>
        <p>Activity Success: <?php echo $data['activityDetails']['activitySuccess'] ?></p>
        <p>Suspended: <?php echo $data['activityDetails']['suspended'] ? 'True' : 'False' ?></p>
        <p>Time Tracked: <?php echo $data['activityDetails']['timeTracked'] ?></p>
        <p>Score: <?php echo $data['activityDetails']['score'] ?></p>
        <p>Completion Threshold: <?php echo $data['activityDetails']['staticProperties']['completionThreshold'] ?></p>
        <p>Launch Data: <?php echo $data['activityDetails']['staticProperties']['launchData'] ?></p>
        <p>Max Time Allowed: <?php echo $data['activityDetails']['staticProperties']['maxTimeAllowed'] ?></p>
        <p>Scaled Passing Score: <?php echo $data['activityDetails']['staticProperties']['scaledPassingScore'] ?></p>
        <p>Scaled Passing Score Used: <?php echo $data['activityDetails']['staticProperties']['scaledPassingScoreUsed'] ?></p>
        <p>Time Limit Action: <?php echo $data['activityDetails']['staticProperties']['timeLimitAction'] ?></p>

        <p>Completion Status: <?php echo $data['activityDetails']['runtime']['completionStatus'] ?></p>
        <p>Credit: <?php echo $data['activityDetails']['runtime']['credit'] ?></p>
        <p>Entry: <?php echo $data['activityDetails']['runtime']['entry'] ?></p>
        <p>Exit: <?php echo $data['activityDetails']['runtime']['exit'] ?></p>
        <p>Audio Level: <?php echo $data['activityDetails']['runtime']['learnerPreference']['audioLevel'] ?></p>
        <p>Language: <?php echo $data['activityDetails']['runtime']['learnerPreference']['language'] ?></p>
        <p>Delivery Speed: <?php echo $data['activityDetails']['runtime']['learnerPreference']['deliverySpeed'] ?></p>
        <p>Audio Captioning: <?php echo $data['activityDetails']['runtime']['learnerPreference']['audioCaptioning'] ?></p>
        <p>Mode: <?php echo $data['activityDetails']['runtime']['mode'] ?></p>
        <p>Progress Measure: <?php echo $data['activityDetails']['runtime']['progressMeasure'] ?></p>
        <p>Scaled Score: <?php echo $data['activityDetails']['runtime']['scoreScaled'] ?></p>
        <p>Raw Score: <?php echo $data['activityDetails']['runtime']['scoreRaw'] ?></p>
        <p>Minimum Score: <?php echo $data['activityDetails']['runtime']['scoreMin'] ?></p>
        <p>Maximum Score: <?php echo $data['activityDetails']['runtime']['scoreMax'] ?></p>
        <p>Total Time: <?php echo $data['activityDetails']['runtime']['totalTime'] ?></p>
        <p>Time Tracked: <?php echo $data['activityDetails']['runtime']['timeTracked'] ?></p>
        <p>Runtime Success Status: <?php echo $data['activityDetails']['runtime']['runtimeSuccessStatus'] ?></p>
        <p>Suspend Data: <?php echo $data['activityDetails']['runtime']['suspendData'] ?></p>
        <p>Learner Comments: <?php echo var_dump($data['activityDetails']['runtime']['learnerComments']) ?></p>
        <p>LMS Comments: <?php echo var_dump($data['activityDetails']['runtime']['lmsComments']) ?></p>
        <p>Runtime Objectives: <// ?php echo var_dump($data['activityDetails']['runtime']['runtimeObjectives']) ?></p>
    </div>

</div>

<div id="runtime-interactions">
    <p class="font-bold italic" >Runtime Interactions Information</p>
    <div class="grid grid-cols-1 gap-2">
        <p>Runtime Interactions:</p>
        <?php foreach ($data['activityDetails']['runtime']['runtimeInteractions'] as $key => $values) { ?>
            <p><?php echo $key ?>:</p>
            <?php foreach ($values as $value) { ?>
                <p><?php echo $value ?></p>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Hide the elements on page load
        $('#course-info, #learner-info, #activity-info, #runtime-interactions').hide();

        // Show the basic registration information on button click
        $('#basic-registration-info-btn').click(function() {
            $('#course-info, #learner-info, #activity-info, #runtime-interactions').hide();
            $('#basic-registration-information').show();
        });

        $('#activity-info-btn').click(function() {
            $('#course-info, #learner-info, #basic-registration-information, #runtime-interactions').hide();
            $('#activity-info').show();
        });
        $('#runtime-info-btn').click(function() {
            $('#course-info, #learner-info, #basic-registration-information, #activity-info').hide();
            $('#runtime-interactions').show();
        });
    });
</script>