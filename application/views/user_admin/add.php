
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <form id="user_admin_form" class="form-horizontal" method="post" action="<?= base_url() ?>user_admin/save">
                        <?php  $readonly = 'readonly="readonly"';
                        $groupCodes = explode(",",$this->session->userdata('user_group')); 
                            if ($this->session->userdata('user_group') && (in_array('00',$groupCodes))) {
                               $readonly = ''; 
                         } ?>
                        <div class="form-group">
                            <label class="control-label col-lg-2">User Name</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_id" name="user_id" <?=$readonly?> value="<?php echo isset($dataRow[0]->user_id) ? $dataRow[0]->user_id : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Nama</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_name" name="user_name" value="<?php echo isset($dataRow[0]->user_name) ? $dataRow[0]->user_name : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-lg-2">Nama Asli</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_real_name" name="user_real_name" value="<?php echo isset($dataRow[0]->user_real_name) ? $dataRow[0]->user_real_name : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-lg-2">Password</label>
                            <div class="col-lg-10">
                                <input type="password" id="user_pass" name="user_pass" value="" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Retype Password</label>
                            <div class="col-lg-10">
                                <input type="password" id="user_pass_retype" name="user_pass_retype" value="" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Group</label>
                            <div class="col-lg-10">
                                <?php
                                if ($groupData) {
                                    if (isset($dataRow[0]->user_group)) {
                                        $dataRow[0]->user_group = explode(',', $dataRow[0]->user_group);
                                    }
                                    ?>

                                    <?php
                                    foreach ($groupData as $value) {
                                        if ($this->session->userdata('user_group') && (!in_array('00',$groupCodes))) {
                                            if ($value['group_code'] == '00') {
                                                continue;
                                            }
                                        }
                                        $checked = '';
                                        if (isset($dataRow[0]->user_group)) {
                                            if (in_array($value['group_code'], $dataRow[0]->user_group)) {
                                                $checked = 'checked';
                                            }
                                        }
                                        ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="user_group[]" name="user_group[]" <?= $checked ?> value="<?php echo $value['group_code']; ?>">
                                        <?php echo $value['group_name']; ?>
                                            </label>
                                        </div>
                                        <?php }
                                    ?>

<?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">User e-Mail</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_email" name="user_email" <?=$readonly?> value="<?php echo isset($dataRow[0]->user_email) ? $dataRow[0]->user_email : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Aktif</label>
                            <div class="col-lg-10">
                                <?php $checked = '';
                                if (isset($dataRow[0]->user_status)) {
                                    if ($dataRow[0]->user_status == 'Y') {
                                        $checked = 'checked';
                                    }
                                }
                                ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="user_status" name="user_status" <?= $checked ?> value="Y">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                        <input type="hidden" id="id" name="id" value="<?php echo isset($dataRow[0]->id) ? $dataRow[0]->id : '' ?>"/>
                            <button class="btn btn-primary" type="button" onclick="javascript:check_pass('user_admin_form')">Save <i class="icon-arrow-right14 position-right"></i></button>
                            <button class="btn btn-primary" type="submit" id="btncancel" name="btncancel" value="Cancel">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
