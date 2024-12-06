<?php 
    $registration_id = $args['registration_id'];
    $apiResponse = get_registration_information_from_rustici($registration_id);
    $runtimeInteractions = $apiResponse['activityDetails']['runtime']['runtimeInteractions'];
?>

<div id="registration-info" class="w-auto p-1 space-x-1 mb-4 ">
    <div id="runtimeInteractions"></div>
</div>

<script>

        console.log('runtimeInteractions: ', <?php echo json_encode($runtimeInteractions); ?>);
        console.log('apiResponse: ', <?php echo json_encode($apiResponse); ?>);
        document.addEventListener('DOMContentLoaded', function () {

        const dataArray = [];
        for (var i of <?php echo json_encode($runtimeInteractions); ?>) {
            dataArray.push([
                i.result,
                i.learnerResponse ? i.learnerResponse : "N/A",
                i.type,
                i.description,
                i.correctResponses[0],
                new Date(i.timestamp).toLocaleString(),
                i.id
            ]);
        }
            
            new gridjs.Grid({
                sort: true,
                search: true,
                pagination: true,
                columns: [
                    {
                        name: "Result",
                        formatter: 
                            (cell) => 
                            cell === "correct" ? 
                                gridjs.html(
                                `<span class="text-[#008000] w-full items-center material-symbols-outlined">check_circle</span>`) 
                                : gridjs.html(
                                    `<span class="text-[#FF0000] w-full items-center  material-symbols-outlined">cancel</span>`) 
                    },   
                    "Response",             
                    "Type",
                    "Description",
                    "Correct Response",
                    "Time",
                    {
                        "name": "Registration ID",
                        "hidden": true,
                    }
                    
                ],
                data: dataArray,
                
            }).render(document.getElementById("runtimeInteractions"));
        });
    </script>
<div id="registration-info"></div>
