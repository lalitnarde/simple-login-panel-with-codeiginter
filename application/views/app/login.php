
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
        <form class="form-signin" id="loginForm">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="email" id="inputEmailId" name="inputEmail" value="abc@xyz.com" class="form-control" placeholder="Email address" autofocus>
            <input type="password" id="inputPasswordId" name="inputPassword" value="123456" class="form-control" placeholder="Password">
            <button class="btn btn-lg btn-primary btn-block btn-signin" id="login" type="submit">Sign in</button>
        </form><!-- /form -->
        <a href="<?php echo base_url('forgot-password') ?>" class="forgot-password">
            Forgot the password?
        </a>
    </div><!-- /card-container -->
</div><!-- /container -->


<script>
    $('#login').click(function (e) {
        e.preventDefault();
        $.loadingBlockShow({imgPath: base_url + 'assets/loader.gif', text: 'Please wait while we log you in...'});
        $('.generic-msg, .input-error-msg').remove();
        $.ajax({
            url: base_url + 'do-login',
            type: 'POST',
            data: $('#loginForm').serialize(),
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if (!response.status) {
                    $.each(response.errors, function (key, value) {
                        if (key == 'generic') {
                            $('<div class="alert alert-danger text-center generic-msg">' + value + '</div>').insertBefore('#loginForm');
                        } else {
                            $('<div class="input-error-msg">' + value + '</div>').insertAfter('#' + key + 'Id');
                        }
                    });
                    $.loadingBlockHide();
                } else {
                    $.loadingBlockShow({imgPath: base_url + 'assets/loader.gif', text: 'Login successful. Redirecting you to dashboard...'});
                    location.href = response.redirect_url;
                    console.log('success');
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

