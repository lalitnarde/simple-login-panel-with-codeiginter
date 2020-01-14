<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/bootstrap/4.0.0/css/bootstrap.min.css">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >

        <link href="<?php echo base_url('assets'); ?>/app/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets'); ?>/app/css/login.css" rel="stylesheet" type="text/css"/>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="<?php echo base_url('assets'); ?>/bootstrap/4.0.0/js/bootstrap.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('assets'); ?>/app/js/jquery.loading.block.js" type="text/javascript"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <?php if (isset($_SESSION['login_user'])) { ?>
            <nav class="navbar navbar-expand-md navbar-light bg-light border-bottom fixed-top">
                <a class="navbar-brand" href="#">Your Logo</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu 1</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="#">Menuitem 1</a>
                                <a class="dropdown-item" href="#">Menuitem 2</a>
                            </div>
                        </li>

                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown ml-2">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user">&nbsp;</i><?php echo (isset($_SESSION['user_profile']) ? $_SESSION['user_profile']['first_name'] : 'User') ?>&nbsp;</a>
                            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="<?php echo base_url('profile'); ?>">Profile</a>
                                <!--<a class="dropdown-item" href="#">Preferences</a>-->
                                <a class="dropdown-item" href="<?php echo base_url('do-logout'); ?>">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12 alert alert-danger text-center d-none" id="very_generic_msg"></div>
                    </div>

                <?php }
                ?>
                <!--<div class="container-fluid">-->

                <!--</div>-->
