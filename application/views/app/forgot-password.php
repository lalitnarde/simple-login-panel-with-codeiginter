
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
        <form class="form-signin" id="passwordResetRequestForm">
            <p>Please enter your registered Email Id here. We will send a password reset link.</p>
            <span id="reauth-email" class="reauth-email"></span>
            <input type="email" id="inputEmailId" name="inputEmail" value="" class="form-control" placeholder="Email address" autofocus>

            <button class="btn btn-lg btn-primary btn-block btn-signin" id="submit" type="submit">Request password reset</button>
        </form><!-- /form -->
        <a href="<?php echo base_url() ?>" class="forgot-password">
            Got back to Sign In.
        </a>
    </div><!-- /card-container -->
</div><!-- /container -->


<script>
    $('#submit').click(function (e) {
        e.preventDefault();
        $.loadingBlockShow({imgPath: base_url + 'assets/loader.gif', text: 'Requesting password reset...'});
        $('.generic-msg, .input-error-msg').remove();
        $.ajax({
            url: base_url + 'request-password-reset',
            type: 'POST',
            data: $('#passwordResetRequestForm').serialize(),
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (!response.status) {
                    $.each(response.errors, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-danger text-center generic-msg">' + value + '</div>').insertBefore('#passwordResetRequestForm');
                        } else {
                            $('<div class="input-error-msg">' + value + '</div>').insertAfter('#' + key + 'Id');
                        }
                    });
                } else {
                    console.log('success');
                    $.each(response.success, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-success text-center generic-msg">' + value + '</div>').insertBefore('#passwordResetRequestForm');
                            $('#passwordResetRequestForm').remove();
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

</body>

