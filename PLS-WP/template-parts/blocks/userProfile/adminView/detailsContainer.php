<?php ?>

<?php
    echo '<pre>';
    // echo var_dump($args);
    echo '</pre>';
?>

<div class="w-full ">
    <div class="w-full h-auto bg-white border-borderGray border-2 rounded-xl py-3 px-4">
        <div class="w-full grid grid-cols-2 space-y-2">
            <div id="gridbox-element" class="w-1/2">
                <h2 class="text-base" >Username</h2>
                    <p class="text-xl">
                       <?php
                        if (isset($args['user_meta']['nickname'][0])) {
                            echo $args['user_meta']['nickname'][0];
                        } else {
                            echo "Nickname not set";
                        }
                        ?>
                    </p>
                </div>
                <div id="gridbox-element" class="w-1/2">
                    <h2 class="text-base" > Location</h2>
                    <p class="text-xl">
                        Rockford
                    </p>
                </div>
                <div id="gridbox-element" class="w-1/2">
                    <h2 class="text-base" >User Signup</h2>
                    <p class="text-xl">
                        poo
                    </p>
                </div>
                <div id="gridbox-element" class="w-1/2">
                    <h2 class="text-base" >Thing</h2>
                    <p class="text-xl">
                        poo
                    </p>
                </div>
                    <div id="gridbox-element" class="w-1/2">
                        <h2 class="text-base" >PLS ID</h2>
                        <p class="text-xl">
                            doo
                        </p>
                    </div>
                </div>
            </div>
        </div>
