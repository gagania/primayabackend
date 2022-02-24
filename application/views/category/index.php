<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
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
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_category"><i class="fa fa-fw fa-plus"></i> Tambah</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-block btn-danger" onclick="javascript:delete_data('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');"><i class="fa fa-fw fa-minus"></i> Hapus</button>
                            </div>
                        </div>
                        <div id="" class="" style="float:right;">
                            <label>Search: <input type="text" field="ctgr_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('category_list', '<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>', this);" class="m-wrap small"></label>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="category_list">
                        <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($dataList) {
                                $i = 0;
                                foreach ($dataList as $index => $value) {?>
                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                        <td><a href="#add_category" class="edit-category" data-toggle="modal" data-id="<?= $value['id'] ?>" data-ctgr_name="<?= $value['ctgr_name'] ?>"><?php echo $value['ctgr_name']; ?></a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        <input type="hidden" id="totalRow" name="totalRow" value="<?= $i ?>"/>
                        </tbody>
                    </table>
                    <div class="box-footer clearfix">
                        <div style="width:20%;margin:0 auto;">
                            <table class="footer-table">
                                <tbody>
                                    <tr>
                                        <td><button onclick="updatelist('category_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'first');" class="btn-first" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('category_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'prev');" class="btn-prev" type="button">&nbsp;</button></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><span class="ytb-text">Page</span></td>
                                        <td><input type="text" onkeyup="updatelist('category_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'page', this.value);" size="3" value="<?php echo ($pnumber) ? $pnumber : 1; ?>" class="pnumber"></td>
                                        <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata / 10) ?></span></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><button onclick="updatelist('category_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'next');" class="btn-next" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('category_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'last');" class="btn-last" type="button">&nbsp;</button></td>
                                        <td>
                                            <input type="hidden" id="limit" name="limit" value="0"/>
                                            <input type="hidden" id="totaldata" name="totaldata" value="<?php echo $totaldata; ?>"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="add_category" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Add Category</h5>
            </div>
            <form action="<?= base_url() ?>category/save" id="add_category_form" method="post">				
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Nama</label>
                                <input type="text" id="ctgr_name" name="ctgr_name" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id" name="id" placeholder="">
                </div>
                <div class="modal-footer">
                    
                    <button type="button" data-dismiss="modal" class="btn">Close</button>
                    <button type="submit" id="submit" class="btn blue">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.edit-category').click(function () {
        var table_id = $(this).data('id');
        var ctgr_name = $(this).data('ctgr_name');
        $(".modal-body #id").val(table_id);
        $(".modal-body #ctgr_name").val(ctgr_name);
    });
</script>