<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<!--<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>-->
<link rel="stylesheet" href="<?=$themes?>/plugins/datatables/dataTables.bootstrap.css">
<link href="<?=$themes?>/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12" style="padding:10px;">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button type="button" class="btn btn-block btn-primary" onclick="javascript:add_data('<?= base_url() ?>','<?php echo $this->router->fetch_class();?>','');"> <i class="fa fa-fw fa-plus"></i> Tambah</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-block btn-danger"  onclick="javascript:delete_data('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');"> <i class="fa fa-fw fa-minus"></i> Hapus</button> 
                            </div>                        
                        </div>
                    </div>
                    <table class="table table-hover" id="product_list">
                        <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if ($dataList) {
                                foreach ($dataList as $index => $value) {?>
                                    <tr class="odd" role="row">
                                        <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                        <td><?php echo $value['prdc_name']; ?></td>
                                        <td><?php echo $value['ctgr_name']; ?></td>
                                        <td><?php echo $value['prdc_price']; ?></td>
                                        <td style="text-align: center">
                                            <div class="col-md-12">
                                                <div class="col-md-12" style="margin-bottom: 5px;">
                                                    <button class="btn btn-primary" type="button" style="width:87px" onclick="javascript:add_data('<?= base_url() ?>','<?php echo $this->router->fetch_class();?>', '<?= $value['id'] ?>');">View</button>
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
</section>
<script src="<?=$themes?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$themes?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#product_list').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
          });
    });              
</script>