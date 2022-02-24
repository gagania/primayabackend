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
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_group"><i class="fa fa-fw fa-plus"></i> Tambah</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-block btn-danger" onclick="javascript:delete_data('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');"><i class="fa fa-fw fa-minus"></i> Hapus</button>
                            </div>
                        </div>
                        <div id="" class="" style="float:right;">
                            <label>Search: <input type="text" field="group_code,group_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('group_list', '<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>', this);" class="m-wrap small"></label>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="group_list">
                        <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                                <th>Kode Group</th>
                                <th>Nama Group</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($dataList) {
                                $i = 0;
                                $groupCodes = explode(",",$this->session->userdata('user_group'));
                                foreach ($dataList as $index => $value) {
                                    if ($this->session->userdata('user_group') && (!in_array('00',$groupCodes))) {
                                        if ($value['group_code'] == '00') {
                                           continue;
                                       }
                                    }
                                    ?>
                                    <tr class="odd gradeX">
                                        <td><input type="checkbox" class="delcheck" value="<?php echo $value['group_code']; ?>" /></td>
                                        <td><a href="#add_group" class="edit-group" data-toggle="modal" data-group_code="<?= $value['group_code'] ?>" data-group_name="<?= $value['group_name'] ?>"><?php echo $value['group_code']; ?></a></td>
                                        <td><?= $value['group_name'] ?></td>
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
                                        <td><button onclick="updatelist('group_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'first');" class="btn-first" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('group_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'prev');" class="btn-prev" type="button">&nbsp;</button></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><span class="ytb-text">Page</span></td>
                                        <td><input type="text" onkeyup="updatelist('group_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'page', this.value);" size="3" value="<?php echo ($pnumber) ? $pnumber : 1; ?>" class="pnumber"></td>
                                        <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata / 10) ?></span></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><button onclick="updatelist('group_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'next');" class="btn-next" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('group_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'last');" class="btn-last" type="button">&nbsp;</button></td>
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
<div id="add_group" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Tambah Grup</h5>
            </div>
            <form action="<?= base_url() ?>group/save" id="add_group_form" method="post">				
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Nama Group</label>
                                <input type="text" id="group_name" name="group_name" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Kode Group</label>
                                <input type="text" id="group_code" name="group_code" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Tipe Grup</label>
                                <select id="group_type" name="group_type" tabindex="1" class="form-control">
                                    <?php
                                    $selected = '';
                                    foreach ($groupType as $index => $value) {
                                        ?>
                                        <option value="<?= $index ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
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
    $('.edit-group').click(function () {
        var table_id = $(this).data('group_code');
        var group_name = $(this).data('group_name');
        $(".modal-body #group_code").val(table_id);
        $(".modal-body #group_name").val(group_name);
    });
</script>