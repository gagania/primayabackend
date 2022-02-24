<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?=$title?> | PERURI</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?=$themes?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
    <link href="<?=$themes?>/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=$themes?>/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link href="<?=$themes?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=$themes?>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?=$themes?>/dist/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="<?=$themes?>/dist/css/additional.css" rel="stylesheet" type="text/css" />
    <link href="<?=$themes?>/dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?=base_url()?>assets/themes/plugins/datepicker/datepicker3.css">
    <script src="<?=$themes?>/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <script src="<?=$themes?>/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=$themes?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=$themes?>/plugins/jQueryUI/jquery-ui.js"></script>
  </head>
  <body class="skin-red layout-top-nav">
    <div class="wrapper">
      <header class="main-header">
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?=base_url()?>" class="navbar-brand" style="width: 200px;">
                  <img src="<?=base_url()?>images/peruri_logo.png" style="width:67%"/>
              </a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav"> 
                  <!-- Messages: style can be found in dropdown.less-->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="<?=$themes?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image" />
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?=$this->session->userdata('user_name')?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="<?=$themes?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                        <p>
                          <?=$this->session->userdata('user_name')?>
                          <!-- <small>Member since Nov. 2017</small> -->
                        </p>
                      </li> 
                      <li class="user-footer">
                        <div class="pull-left">
                          <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                        </div>
                        <div class="pull-right">
                          <a href="<?=base_url()?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>

        <nav class="navbar navbar-static-top"  style="background-color: #222D32; z-index: 0">
          <div class="container" style="width: 1200px">
             <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                    <li class="active"><a href="<?=base_url()?>"> Dashboard</a></li>                
                <?php echo $menus; ?>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div>

        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
        <div class="container">
            <?php $this->load->view($content);?>
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <strong>Copyright &copy; 2020 <a href="#">PERURI</a>.</strong> All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <?php if ($this->session->flashdata('info_message')) { ?>
    <div class="modal modal-success fade" id="modal-success">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Success</h4>
                  </div>
                  <div class="modal-body">
                    <p><?=$this->session->flashdata('info_message')?></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal"><?php echo lang('close');?></button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
    <?php } ?>
    <script type="text/javascript">
        $(document).ready(function () {
    <?php if ($this->session->flashdata('info_message')) { ?>
            $("#modal-success").modal('show');

    <?php } ?>
        });
    </script>
    
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=$themes?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="<?=$themes?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="<?=$themes?>/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?=$themes?>/dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=$themes?>/plugins/select2/select2.full.min.js"></script>
    <script src="<?=$themes?>/plugins/datepicker/bootstrap-datepicker.js"></script>
    
    <script src="<?=$themes?>/dist/js/demo.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
  </body>
</html>
