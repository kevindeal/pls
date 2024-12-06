<?php 
    $current_user = wp_get_current_user()
?>

<script>
    console.log('current_user: ', <?php echo json_encode($current_user); ?>);
</script>

<div id="settings-main" class="w-full rounded-lg border-[1px] border-borderGray bg-white p-4">
    <div class="w-full inline-flex justify-between">
        <h1 class="text-xl font-bold">Display Name</h1>
        <button class="border-[1px] border-borderGray hover:bg-hoverLightBlue transition-all duration-200 text-textNeutral hover:text-blueAgencyForeground rounded-md p-2 inline-flex gap-2">
            <span class="material-symbols-outlined">
                edit
            </span>
            Edit
        </button>
    </div>
    <div class="grid grid-cols-2 gap-2 w-full mb-4">          
            <div>
                <label for="user-first-name" class="text-sm">First Name</label>
                <input type="text" id="display-name" class="w-full border-[1px] border-borderGray rounded-md p-2" value="<?php echo $current_user->first_name ?>">
            </div>
            <div>
                <label for="user-last-name" class="text-sm">Last Name</label>
                <input type="text" id="display-name" class="w-full border-[1px] border-borderGray rounded-md p-2" value="<?php echo $current_user->last_name; ?>">
            </div>
    </div>
    <h1 class="text-xl font-bold">Contact Information</h1>    
    <div class="grid grid-cols-2 gap-2 w-full">          
        <div>
            <label for="user-email-address" class="text-sm">Email Address</label>
            <input type="text" id="user-email-address" class="w-full border-[1px] border-borderGray rounded-md p-2" value="<?php echo $current_user->user_email; ?>">
        </div>
        <div>
            <label for="user-phone-number" class="text-sm">Contact Phone</label>
            <input type="text" id="user-phone-number" class="w-full border-[1px] border-borderGray rounded-md p-2" value="<?php echo $current_user->phone_number; ?>">
        </div>
    </div>
</div>

