
<div class="col-md-10 d-flex justify-content-center">
    <div class = "col-md-12 box-shadow rounded p-4 m-2 bg-light">
        <h4>User Profile</h4>
        <br>
        <form id="udpateProfileForm" method="post">
            <div class="form-group row">
                <label for="inputFirstName" class="col-sm-4 col-form-label">First name</label>
                <div class="col-sm-8">
                    <input type="text" value='<?php echo (isset($user_profile['first_name']) ? $user_profile['first_name'] : '') ?>' class="form-control" name="inputFirstName" id="inputFirstNameId" placeholder="First name" autofocus="true">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputLastName" class="col-sm-4 col-form-label">Last name</label>
                <div class="col-sm-8">
                    <input type="text"  value='<?php echo (isset($user_profile['last_name']) ? $user_profile['last_name'] : '') ?>' class="form-control" name="inputLastName" id="inputLastNameId" placeholder="Last name">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputMobile" class="col-sm-4 col-form-label">Mobile number</label>
                <div class="col-sm-8">
                    <input type="text"  value='<?php echo (isset($user_profile['mobile_number']) ? $user_profile['mobile_number'] : '') ?>' class="form-control" name="inputMobile" id="inputMobileId" placeholder="Mobile number">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputAlternateNumber" class="col-sm-4 col-form-label">Alternate number</label>
                <div class="col-sm-8">
                    <input type="text"  value='<?php echo (isset($user_profile['alternate_number']) ? $user_profile['alternate_number'] : '') ?>' class="form-control" name="inputAlternateNumber" id="inputAlternateNumberId" placeholder="Alternate number">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputCity" class="col-sm-4 col-form-label">City</label>
                <div class="col-sm-8">
                    <input type="text"  value='<?php echo (isset($user_profile['city']) ? $user_profile['city'] : '') ?>' class="form-control" name="inputCity" id="inputCityId" placeholder="City">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" class="btn btn-primary" id="save">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $('#save').click(function (e) {
        e.preventDefault();
        $.loadingBlockShow({imgPath: base_url + 'assets/loader.gif', text: 'Updating user profile...'});
        $('.generic-msg, .input-error-msg').remove();
        $.ajax({
            url: base_url + 'update-own-profile',
            type: 'POST',
            data: $('#udpateProfileForm').serialize(),
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (!response.status) {
                    $.each(response.errors, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-danger text-center generic-msg">' + value + '</div>').insertBefore('#udpateProfileForm');
                        } else {
                            $('<div class="input-error-msg">' + value + '</div>').insertAfter('#' + key + 'Id');
                        }
                    });
                } else {
                    $.each(response.success, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-success text-center generic-msg ">' + value + '</div>').insertBefore('#udpateProfileForm');
                        }
                    });
                }
                $.loadingBlockHide();

            },
            error: function (response) {
                console.log(response);
                $.loadingBlockHide();
                //                console.log(JSON.stringify(response));
            }
        });
    });
</script>