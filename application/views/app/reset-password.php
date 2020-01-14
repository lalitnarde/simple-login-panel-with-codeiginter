
<div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"></p>
         <?php if (isset($_GET['msg'])) { ?>
            <div class="alert alert-warning text-center generic-msg">
                <?php
                echo ucfirst(implode(' ', explode('-', $_GET['msg'])));
                ?>
            </div>
        <?php } ?>
        <form class="form-signin" id="resetPasswordForm">
            <span id="reauth-email" class="reauth-email"></span>
            <p>Reset password for user<br/><b><?php echo $email; ?></b></p>
            <input type="hidden" name='inputEmail' id="inputEmailId" value='<?php echo $email; ?>' />
            <input type="hidden" name='inputKey' id="inputKeyId" value='<?php echo $password_reset_code; ?>' />
            <input type="password" id="inputPasswordId" name="inputPassword" class="form-control" placeholder="New password" autofocus>
            <input type="password" id="inputConfirmPasswordId" name="inputConfirmPassword" value="" class="form-control" placeholder="Confirm password">
            <!--            <div id="remember" class="checkbox">
                            <label>
                                <input type="checkbox" value="remember-me"> Remember me
                            </label>
                        </div>-->
            <button class="btn btn-lg btn-primary btn-block btn-signin" id="reset" type="submit">Reset password</button>
        </form><!-- /form -->
    </div><!-- /card-container -->
</div><!-- /container -->


<script>
    $('#reset').click(function (e) {
        e.preventDefault();
        $.loadingBlockShow({imgPath: base_url + 'assets/loader.gif', text: 'Please wait while we log you in...'});
        $('.generic-msg, .input-error-msg').remove();
        $.ajax({
            url: base_url + 'do-reset-password',
            type: 'POST',
            data: $('#resetPasswordForm').serialize(),
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (!response.status) {
                    $.each(response.errors, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-danger text-center generic-msg">' + value + '</div>').insertBefore('#resetPasswordForm');
                        } else {
                            $('<div class="input-error-msg">' + value + '</div>').insertAfter('#' + key + 'Id');
                        }
                    });
                    $.loadingBlockHide();
                } else {
                    $.loadingBlockHide();
                    $.loadingBlockShow({imgPath: base_url + 'assets/loader.gif', text: 'Password changed successfully. Please login using your new password...'});
                    location.href = response.redirect_url;
                }

            },
            error: function (response) {
                console.log(response);
                $.loadingBlockHide();
                //                console.log(JSON.stringify(response));
            }
        });
    });
</script>

</body>

