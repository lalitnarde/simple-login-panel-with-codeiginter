
<div class="col-md-10 d-flex justify-content-center">
    <div class = "col-md-12 box-shadow rounded p-4 m-2 bg-light">
        <h4>Update Password</h4>
        <br>
        <form id="udpatePasswordForm" method="post">
            <div class="form-group row">
                <label for="inputCurrentPassword" class="col-sm-4 col-form-label">Current password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="inputCurrentPassword" id="inputCurrentPasswordId" placeholder="Current password" autofocus="true">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputNewPassword" class="col-sm-4 col-form-label">New password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="inputNewPassword" id="inputNewPasswordId" placeholder="New password">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputConfirmPassword" class="col-sm-4 col-form-label">Confirm new password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="inputConfirmPassword" id="inputConfirmPasswordId" placeholder="Confirm new password">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-8 offset-sm-4">
                    <button type="submit" class="btn btn-primary" id="udpatePassword">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $('#udpatePassword').click(function (e) {
        e.preventDefault();
        $.loadingBlockShow({imgPath: base_url + 'assets/loader.gif', text: 'Please wait. Updating password...'});
        $('.generic-msg, .input-error-msg').remove();
        $.ajax({
            url: base_url + 'profile/do-update-password',
            type: 'POST',
            data: $('#udpatePasswordForm').serialize(),
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (!response.status) {
                    $.each(response.errors, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-danger text-center generic-msg">' + value + '</div>').insertBefore('#udpatePasswordForm');
                        } else {
                            $('<div class="input-error-msg">' + value + '</div>').insertAfter('#' + key + 'Id');
                        }
                    });
                } else {
                    $.each(response.success, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-success text-center generic-msg ">' + value + '</div>').insertBefore('#udpatePasswordForm');
                        }
                        $(':input').val('');
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