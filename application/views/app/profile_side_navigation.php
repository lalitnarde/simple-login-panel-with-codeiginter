<div class="col-md-2 sidebar-menu">
    <div class = "col-md-12 p-4 m-2 bg-light d-flex justify-content-center">
        <nav class="navbar navbar-light navbar-expand-sm px-0 flex-row flex-nowrap">
            <div class="navbar-collapse" id="navbarWEX">
                <div class="nav flex-sm-column flex-row">
                    <?php
                    $link = $_SERVER['PHP_SELF'];
                    $link_array = explode('/', $link);
                    $page = end($link_array);
                    ?>
                    <a class="nav-item btn btn-outline-light text-dark <?php echo (($page == 'profile') ? 'active' : '') ?> mb-2" href="<?php echo base_url('profile'); ?>">User Profile</a>
                    <a href="<?php echo base_url('profile/update-password'); ?>" class="nav-item btn btn-outline-light text-dark <?php echo (($page == 'update-password') ? 'active' : '') ?> mb-2">Update Password</a>
                    <a href="<?php echo base_url('profile/login-history'); ?>" class="nav-item btn btn-outline-light text-dark <?php echo (($page == 'login-history') ? 'active' : '') ?> mb-2 disabled">View Login History</a>
                </div>
            </div>
        </nav>
    </div>
</div>

