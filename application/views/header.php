<!-- Logo -->
<a href="<?= base_url() ?>" class="logo">
    <img src="" style="width:67%"/>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning total_notif"></span>
                </a>
                <ul class="dropdown-menu" style="width:auto;">
                    <li>
                        <ul class="menu detail_notify"></ul>
                    </li>
                    <!--<li class="footer"><a href="#">View all</a></li>-->
                </ul>
            </li>
            <?php
            $userImage = '';
            if($this->session->userdata('user_image') != '') {
                $userImage = base_url().$this->session->userdata('user_image');
            } else {
                $userImage =  $themes.'/dist/img/user-employee2.jpg';
            }?>
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?=$userImage?>" class="user-image" alt="" />
                    <span class="hidden-xs"><?= $this->session->userdata('user_name') ?> </span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="<?=$userImage?>" class="img-circle" alt="" />
                        <p>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="<?= base_url() ?>profile" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="<?= base_url() ?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
