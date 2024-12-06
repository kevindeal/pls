<?php 
    // $certTemplateID = $args['certTemplateID'];

?>

<div class="w-3/4" id="content">
        <h1 class="text-4xl font-bold">Certificate Creator</h1>
        <div id="options" class="inline-flex p-2 w-full gap-2">
            <div class="w-1/4">
                <label class="text-sm" for="course">Course</label>
                <input type="text" id="course" class="w-full border-[1px] border-borderGray rounded-md p-2" />
            </div>
            <div class="w-1/4">
                <label class="text-sm" for="date">Date</label>
                <input type="date" id="date" class="w-full border-[1px] border-borderGray rounded-md p-2" />
            </div>
            <div class="w-1/4">
                <label class="text-sm" for="name">Name</label>
                <input type="text" id="name" class="w-full border-[1px] border-borderGray rounded-md p-2" />
            </div>
            <div class="w-1/4">
                <label class="text-sm" for="signature">Signature</label>
                <select id="signature" class="w-full border-[1px] border-borderGray rounded-md p-2">
                    <option value="Police Legal Sciences">Police Legal Sciences</option>
                    <option value="Boss Hogg">Boss Hog</option>
                    <option value="Spiderman">Spiderman</option>
                </select>
            </div>

        </div>
        <div id="preview" class="w-full">
            <h2 class="text-2xl font-bold">Preview</h2>
            <div id="certificate" style="position: relative;" class="w-full">         
                <img src="https://pls-dev1-testing.local/wp-content/uploads/2024/02/award-of-excellence.jpg" alt="PLS Logo" class="w-full" />
                <div id="course-overlay" style="position: absolute; top: 295px; left: 350px;">
                    <p id="courseNameArea" class="text-lg ml-1 w-[360px] text-center"></p>
                </div>
                <div id="name-overlay" style="position: absolute; top: 445px; left: 360px;">
                    <p id="personNameArea" class="text-lg w-[360px] text-center"></p>
                </div>
                <div id="name-overlay" style="position: absolute; top: 525px; left: 130px;">
                    <p id="dateArea" class="text-lg w-[360px] text-center"></p>
                </div>
                <div id="name-overlay" style="position: absolute; top: 525px; left: 580px;">
                    <p id="signatureArea" class="text-lg w-[360px] text-center"></p>
                </div>
            </div>
        </div>
        </div>
    </div>