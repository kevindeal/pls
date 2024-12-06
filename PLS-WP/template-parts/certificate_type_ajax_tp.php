<?php

    $nonce = wp_create_nonce('compose_pdf_ajax_nonce');
    $certTemplateID = $args['certTemplateID'];

    $cert_template_fields = get_fields($certTemplateID);
    // echo var_dump($cert_template_fields)

    $cert_template_media = $cert_template_fields['certificate_media']->guid;
    // echo var_dump($cert_template_media);

?>

<div class="w-full inline-flex" id="content">
    <div class="w-1/4 p-4 ">

        <?php 
            foreach($cert_template_fields["certificate_fields"] as $input_fields_row) {
                $title = $input_fields_row['title'];
                $slug_title = strtolower(str_replace(' ', '-', $input_fields_row['title']));

                $top_cords = $input_fields_row['x-cords'];
                $left_cords = $input_fields_row['y-cords'];

                ?> <div class="w-full mb-4">
                    <?php // echo var_dump($input_fields_row) ?>
                        <label class="font-bold" for="course"><?php echo $input_fields_row['title'] ?> (<?php echo $input_fields_row['x-cords'] ?>,<?php echo $input_fields_row['y-cords'] ?>)</label>
                        <input type="text" id="<?php echo $slug_title ?>-input" data-target="<?php echo $slug_title . 'NameArea' ?>" class="input-class-name w-full border-[1px] border-borderGray rounded-md p-2" />
                        <div class="inline-flex my-2 gap-2">
                            <input id="top_cords" data-target="<?php echo $slug_title . '-overlay' ?>" type="number" class="number-input w-1/2 p-1" id="top-cords" value="<?php echo $top_cords ?>"/>
                            <input id="left_cords" data-target="<?php echo $slug_title . '-overlay' ?>" type="number" class="number-input w-1/2 p-1" id="left-cords" value="<?php echo $input_fields_row['y-cords'] ?>" />
                        </div>
                    </div>
                    <?php
            }
            ?>

            <button class="hidden w-full mb-4 rounded-full transition-all duration-200  p-2 border-[1px] border-borderGray hover:bg-badgeLightBlue hover:text-blueAgencyForeground">
                Add Field 
            </button>
            <button id="export" class="w-full mb-4 rounded-full transition-all duration-200 p-2 border-[1px] border-borderGray hover:bg-badgeLightBlue hover:text-blueAgencyForeground">
                Export Example Certificate 
            </button>
            <button class="w-full mb-4 rounded-full transition-all duration-200 p-2 border-[1px] border-borderGray hover:bg-badgeLightBlue hover:text-blueAgencyForeground">
                Save Certificate Template Settings
            </button>
    </div>
    <div class="w-full">
        <div id="options" class="inline-flex p-2 w-full gap-2">
        
        <div id="preview" class="w-full overflow-scroll">
            <div id="certificate" style="position: absolute;" class="w-full h-full" style=" size: A4 landscape; " >    
            
                <img id="cert-img" src="<?php echo str_replace('https', 'http', $cert_template_media) ?>" class="object-none" />

                <?php 
                    foreach($cert_template_fields['certificate_fields'] as $input_field_row) {
                        $topVal = $input_field_row['x-cords'];
                        $slug_title = strtolower(str_replace(' ', '-', $input_field_row['title']));

                        $leftVal = $input_field_row['y-cords'];
                        ?>
                        <div id="<?php echo $slug_title ?>-overlay" style="position: absolute; top: <?php echo $topVal ?>px; left: <?php echo $leftVal ?>px;" class="bg-yellow bg-opacity-20">
                            <p id="<?php echo $slug_title ?>NameArea" class="text-lg ml-1 w-[360px] text-center">dsfsdfasdf</p>
                        </div>
                        <?php 
                    }
                ?>
                <div id="name-overlay" style="position: absolute; top: 525px; left: 580px;">
                    <p id="signatureArea" class="text-lg w-[360px] text-center"></p>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<img id="cert-img"></img>

<script>
    jQuery(document).ready(function($) {
        $("#export").click(function() {
            var htmlContent = $('#preview').html();
            // console.log(htmlContent);
            var textArray = <?php echo json_encode($cert_template_fields['certificate_fields']) ?>;
            for (var i = 0; i < textArray.length; i++) {
                var slug_title = textArray[i]['title'].toLowerCase().replace(' ', '-');

                textArray[i].value = $("#"+slug_title+"-input").val();
                textArray[i]['x-cords'] = $("#"+slug_title+"-overlay").css("top").replace("px", "");
                textArray[i]['y-cords'] = $("#"+slug_title+"-overlay").css("left").replace("px", "");

                textArray[i].width = $("#"+slug_title+"NameArea").width();
            }
            console.log(textArray);
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: "compose_pdf_ajax",
                    // html: encodeURIComponent(htmlContent),
                    background: "<?php echo $cert_template_media ?>",
                    textArray: textArray,
                    nonce: "<?php echo $nonce ?>"
                },
            success: function(response) {
                if(response.success) {
                    console.log(response);
                    // Replace the image with the new certificate
                    document.getElementById('cert-img').src = response.data.image;
                    
                    // Convert base64 to blob and trigger download
                    var link = document.createElement('a');
                    link.href = 'data:application/pdf;base64,' + response.data.pdf;
                    link.download = 'download.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    alert("Error generating PDF");
                }
            }
            });
        });
    });
</script>