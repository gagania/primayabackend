<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<link rel="stylesheet" href="<?=$themes?>/plugins/datatables/dataTables.bootstrap.css">
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
                    </div>
                    <table class="table table-hover table-bordered" id="group_akses_list">
                        <thead>
                            <tr>
                                <th>Group Code</th>
                                <th>Group Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $groupCodes = explode(",",$this->session->userdata('user_group'));
                        if ($dataList) {
                            foreach ($dataList as $index => $value) {
                                if ($this->session->userdata('user_group') && (!in_array('00',$groupCodes))) {
                                    if ($value['group_code'] == '00') {
                                       continue;
                                   }
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td><a href="#" onclick="javascript:auth_edit('<?=base_url()?>','<?=trim($value['group_code'])?>');"><?php echo $value['group_code']; ?></a></td>
                                    <td><?php echo $value['group_name']; ?></td>
                                </tr>
                                <?php
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
<script src="<?=$themes?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$themes?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#group_akses_list').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
          });
    });              
    
</script>