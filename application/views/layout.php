<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?> | Test Primaya Hospital</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.4 -->
        <link href="<?= $themes ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?= $themes ?>/dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= $themes ?>/plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link href="<?= $themes ?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $themes ?>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= $themes ?>/dist/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?= $themes ?>/dist/css/additional.css" rel="stylesheet" type="text/css" />
        <link href="<?= $themes ?>/dist/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?= base_url() ?>assets/themes/plugins/datepicker/datepicker3.css">
        <script src="<?= $themes ?>/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
        <script src="<?= $themes ?>/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="<?= $themes ?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="<?= $themes ?>/plugins/jQueryUI/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?= $themes ?>/plugins/iCheck/all.css">
        <script src="<?= $themes ?>/plugins/iCheck/icheck.min.js"></script>
    </head>
    <body class="skin-blue sidebar-mini sidebar-mini-expand-feature">
        <div class="wrapper">
            <header class="main-header">
                <?php include_once('header.php'); ?>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header"></li>
                        <?php echo $menus; ?>
                    </ul>
                </section>
            </aside>
            <div class="content-wrapper">
                <?php $this->load->view($content); ?>
            </div>
            <footer class="main-footer">
                <div class="container">
                    <strong>Copyright &copy; 2022 <a href="#">Test Primaya Hospital</a>.</strong> All rights reserved.
                </div>     
            </footer>
        </div>
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
                            <p><?= $this->session->flashdata('info_message') ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <?php } ?>
        <input type="hidden" id="new_user" name="new_user" value="<?=$this->session->userdata('is_new')?>"/>
        <div id="new_user_modal" class="modal fade" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                    </div>
                    <form action="?" id="add_group_form" method="post" enctype="multipart/form-data">				
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Password</label>
                                        <input type="password" id="user_pass_change" name="user_pass_change" value="" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Retype Password</label>
                                        <input type="password" id="user_pass_change_retype" name="user_pass_change_retype" value="" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="button" onclick="javascript:savenewpass('<?=base_url()?>');" class="btn blue">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                <?php if ($this->session->flashdata('info_message')) { ?>
                    $("#modal-success").modal('show');
                <?php } ?>
                if($('#new_user').val() === '1'){ 
                    $('#new_user_modal').modal('show');
                }
            });
            
        </script>

        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?= $themes ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="<?= $themes ?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="<?= $themes ?>/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?= $themes ?>/dist/js/app.min.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?= $themes ?>/plugins/select2/select2.full.min.js"></script>
        <script src="<?= $themes ?>/plugins/datepicker/bootstrap-datepicker.js"></script>

        <script src="<?= $themes ?>/dist/js/demo.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
    </body>
</html>