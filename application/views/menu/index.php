<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/paging.js"></script>

<!-- BEGIN PAGE CONTENT-->
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
                                <button class="btn btn-block btn-primary" onclick="javascript:add_data('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');"><i class="fa fa-fw fa-plus"></i> Tambah</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-block btn-danger" onclick="javascript:delete_data('<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>');"><i class="fa fa-fw fa-minus"></i> Hapus</button>
                            </div>
                        </div>
                        <div id="" class="" style="float:right;">
                            <label>Search: <input type="text" field="menu_name" id="search_desc" name="search_desc" onkeyup="javascript:searchdata('menu_list', '<?= base_url() ?>', '<?php echo $this->router->fetch_class(); ?>', this);" class="m-wrap small"></label>
                        </div>
                    </div>
                    <!--<div class="col-md-12 list_table">-->
                        <table class="table table-hover table-bordered list_table" id="menu_list">
                            <thead>
                                <tr>
                                    <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#" /></th>
                                    <th>Nama Menu</th>
                                    <th>Menu Parent</th>
                                    <th>Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($dataList) {
                                    $i = 0;
                                    foreach ($dataList as $index => $value) {
                                        $parentName = '';
                                        foreach ($dataList as $keyParent => $valueParent) {
                                            if($value['menu_parent'] == $valueParent['id']){
                                                $parentName = $valueParent['menu_name'];
                                            }
                                        }
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" class="delcheck" value="<?php echo $value['id']; ?>" /></td>
                                            <td><a href="#" onclick="javascript:add_menu('<?= base_url() ?>', '<?= $value['id'] ?>');"><?php echo $value['menu_name']; ?></a></td>
                                            <td><?=$parentName?></td>                                        
                                            <td><?= ($value['menu_active'] == 'Y') ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Not Active</span>' ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            <input type="hidden" id="totalRow" name="totalRow" value="<?= $i ?>"/>
                            </tbody>
                        </table>
                    <!--</div>-->
                    <div class="box-footer clearfix">
                        <div style="width:20%;margin:0 auto;">
                            <table class="footer-table">
                                <tbody>
                                    <tr>
                                        <td><button onclick="updatelist('menu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'first');" class="btn-first" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('menu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'prev');" class="btn-prev" type="button">&nbsp;</button></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><span class="ytb-text">Page</span></td>
                                        <td><input type="text" onkeyup="updatelist('menu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'page', this.value);" size="3" value="<?php echo ($pnumber) ? $pnumber : 1; ?>" class="pnumber"></td>
                                        <td><span class="ytb-text" id="totaldata_view">of <?php echo ceil($totaldata / 10) ?></span></td>
                                        <td><span class="ytb-sep"></span></td>
                                        <td><button onclick="updatelist('menu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'next');" class="btn-next" type="button">&nbsp;</button></td>
                                        <td><button onclick="updatelist('menu_list', '<?php echo base_url(); ?>', '<?php echo $this->router->fetch_class(); ?>', 'last');" class="btn-last" type="button">&nbsp;</button></td>
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