<?php
/**
 * Template Name: Create New User Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package swps
 */
?>

<?php
    wp_head();
?>
    <div class="flex w-full bg-bgGray h-screen ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-3xl font-bold text-center">Create New User</h1>
                </div>
            </div>

            <div id="stuff" class="m-auto items-center place-items-center justify-center flex">
                <form action="v2/createUser" method="POST">
                    <div>
                        <label for="first_name" class="font-bold">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="rounded-md p-2 border-[1px] border-blueAgencyBorder" required>
                    </div>

                    <label for="last_name" class="font-bold">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" class="rounded-md p-2 border-[1px] border-blueAgencyBorder" required>

                    <div>
                        <label for="state">State:</label>
                        <select class="rounded-md p-2 border-[1px] border-blueAgencyBorder" id="state" name="state" required>
                            <option value="">Select State</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>

                    <button type="submit">Submit</button>
                </form>
            </div>
                
</div>

