<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>
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
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal_access"> <i class="fa fa-fw fa-plus"></i> Tambah</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-block btn-danger"  onclick="javascript:delete_data('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');"> <i class="fa fa-fw fa-minus"></i> Hapus</button> 
                            </div>                        
                        </div>
                        <div id="" class="" style="float:right;">
                            <label>Search: <input type="text" field="ctgr_name" id="search_desc" name="search_desc" onkeyup="javascript:searchAccess('access_list', '<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>', this,'','edit_access');" class="m-wrap small"></label>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="access_list">
                        <thead>
                            <tr>
                                <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                                <th>Category</th>
                                <th>User Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($dataList) {
                                $i = 0;
                                foreach ($dataList as $index => $value) {?>
                                    <tr class="odd" role="row">
                                        <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                        <td><a href="#modal_access"  class="edit_access" data-toggle="modal" data-id='<?=$value['id']?>'><?php echo $value['ctgr_name']; ?></a></td>
                                        <td><?php echo $value['user_name']; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="box-footer clearfix">
                        <div style="width:20%;margin:0 auto;">
                            <table class="footer-table">
                                <tbody>
                                    <tr>
                                        <td><button onclick="updatelist('access_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'first');" class="btn-first" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('access_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'prev');" class="btn-prev" type="button">&nbsp;</button></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><span class="ytb-text">Page</span></td>
                                        <td><input type="text" onkeyup="updatelist('access_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'page', this.value);" size="3" value="<?php echo ($pnumber) ? $pnumber : 1; ?>" class="pnumber"></td>
                                        <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata / 10) ?></span></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><button onclick="updatelist('access_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'next');" class="btn-next" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('access_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'last');" class="btn-last" type="button">&nbsp;</button></td>
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
</section>
<div id="modal_access" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title"></h5>
            </div>

            <form action="<?= base_url() ?>access/save" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Key Name</label>
                                <input type="text" id="key_name" name="key_name" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Category</label>
                                <select class="form-control select2" field="ctgr_id" id="ctgr_id" name="ctgr_id" onchange="javascript:get_account('<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', this.value,'')" style="width:100%">
                                    <?php foreach ($categoryData as $indexCtgr => $valueCtgr) { ?>
                                        <option value="<?= $indexCtgr ?>"><?= $valueCtgr ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Domain</label>
                                <input type="text" id="domain" name="domain" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>IP</label>
                                <input type="text" id="ip" name="ip" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Port</label>
                                <input type="text" id="port" name="port" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>User Name</label>
                                <input type="text" id="user_name" name="user_name" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5">
                                <label>Password</label>
                                <input type="password" id="pass" name="pass" placeholder="" class="form-control">
                                <input type="hidden" id="id" name="id" placeholder="" class="form-control">
                            </div>
                            <div class="col-sm-2" style="width:35px;padding-left:0;padding-right:0;top:25px;text-align:center">
                                <a href="#" onclick="javascript:show_password();"><img src="<?=$themes?>/dist/img/show_hide_password.png" style="width:100%;"/></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Notes</label>
                                <input type="text" id="desc" name="desc" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#modal_access').on('show.bs.modal', function (e) {
        var table_id = '';
        if ($(e.relatedTarget).data('id')) {
            table_id = $(e.relatedTarget).data('id');
        }
        
        if (table_id !== '') {
            $(".modal-title").html('Change Access');
        } else {
            $(".modal-title").html('Add Access');
        }
    });
    
    $("#modal_access").on('hidden.bs.modal', function (e) {
        $(this).find("input,textarea").val('');
    });
    
    $('.edit_access').click(function () {
        $.ajax({
            url : '<?=base_url()?>'+'<?=$this->router->fetch_class()?>'+"/get_data",
            type: "POST",
            dataType:'json',
            data : {
                    id:$(this).data('id')
                },
            success: function(data)
            {
                if (data['header'].length) {
                    $.each(data['header'][0], function( key, value ) {
                        if ($(".modal-body #"+key+"").length) {
                            $(".modal-body #"+key+"").val(value);
                        }
                    });
                    $(".modal-body #select2-ctgr_id-container").html(data['header'][0]['ctrg_id']);
                }
            }
        });
    });
</script>