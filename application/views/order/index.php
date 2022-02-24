<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<link rel="stylesheet" href="<?= $themes ?>/plugins/datatables/dataTables.bootstrap.css">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <form id="order_report_form" method="post" action="<?= base_url().$this->router->fetch_class() ?>/export_csv" enctype="multipart/form-data">
                        <div class="col-md-12" style="padding:10px;">
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label class="control-label col-lg-2" style="padding-top:9px;">Table Number</label>
                                    <div class="col-md-5">
                                        <input type="text" id="order_table" name="order_table" class="form-control" value="" />
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="control-label col-lg-5" style="padding-top:9px;">Order Number</label>
                                    <div class="col-md-7">
                                        <input type="text" id="user_nmbr" name="user_nmbr" class="form-control" value="" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-5" style="padding-top:20px">
                                <div class="btn-group">
                                    <button type="button" onclick="javascript:process_order('<?= base_url() ?>', '<?= $this->router->fetch_class() ?>', 'order_report_form', 'order_list');" class="btn btn-primary">Proses<i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-hover" id="order_list">
                        <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                                <th>Order Number</th>
                                <th>Table Number</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th style="width:5%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if ($dataList) {
                                foreach ($dataList as $index => $value) {
                                    ?>
                                    <tr class="odd" role="row">
                                        <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                        <td><?php echo $value['order_nmbr']; ?></td>
                                        <td>
                                            <?php echo $value['order_table']; ?>
                                        </td>
                                        <td><?php echo $value['order_status']; ?></td>
                                        <td style="text-align: center">
                                            <div class="col-md-12">
                                                <div class="col-md-12" style="margin-bottom: 5px;">
                                                    <div class="save_buttons text-center">
                                                        <button class="btn btn-primary" type="button" style="width:87px" onclick="javascript:add_data('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>', '<?= $value['id'] ?>');">Detail</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="detail_order" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Detail Order</h5>
            </div>
            <form action="?" id="add_group_form" method="post">				
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-lg-4">No. Registration</label>
                                <div class="col-md-5">
                                    <span id="reg_nmbr"></span>
                                    <!--<input type="text" id="group_name" name="group_name" placeholder="" class="form-control">-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-lg-4">Name</label>
                                <div class="col-md-5">
                                    <span id="order_user_name"></span>
                                    <!--<input type="text" id="group_name" name="group_name" placeholder="" class="form-control">-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-lg-4">Category</label>
                                <div class="col-md-5">
                                    <span id="order_ctgr_name"></span>
                                    <!--<input type="text" id="group_name" name="group_name" placeholder="" class="form-control">-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-lg-4">Product</label>
                                <div class="col-md-5">
                                    <span id="order_prdc_name"></span>
                                    <!--<input type="text" id="group_name" name="group_name" placeholder="" class="form-control">-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-lg-4">Location</label>
                                <div class="col-md-5">
                                    <span id="order_lctn_name"></span>
                                    <!--<input type="text" id="group_name" name="group_name" placeholder="" class="form-control">-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-lg-4">Schedule</label>
                                <div class="col-md-5">
                                    <span id="schd_date"></span>
                                    <!--<input type="text" id="group_name" name="group_name" placeholder="" class="form-control">-->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= $themes ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $themes ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#order_list').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false
        });
    });
</script>