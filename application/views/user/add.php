
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <form id="user_admin_form" class="form-horizontal" method="post" action="<?= base_url() ?>user/save">
                        <div class="form-group">
                            <label class="control-label col-lg-2">ID</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_idnt" name="user_idnt" value="<?php echo isset($dataRow[0]['user_idnt']) ? $dataRow[0]['user_idnt'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Nama</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_name" name="user_name" value="<?php echo isset($dataRow[0]['user_name']) ? $dataRow[0]['user_name'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
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
                            <label class="control-label col-lg-2">Birthdate</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_birthdate" name="user_birthdate" value="<?php echo isset($dataRow[0]['user_birthdate']) ? $dataRow[0]['user_birthdate'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Gender</label>
                            <div class="col-lg-10">
                                <select class="form-control" type="text" id="user_gndr" name="user_gndr">
                                    <?php $selected = '';
                                    foreach($gender as $index => $value){
                                        if (isset($dataRow[0]['user_gndr'])) {
                                            if ($index ==$dataRow[0]['user_gndr']) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                        }?>
                                    <option value="<?=$index?>" <?=$selected?>><?=$value?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Telp</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_telp" name="user_telp" value="<?php echo isset($dataRow[0]['user_telp']) ? $dataRow[0]['user_telp'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">height</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_height" name="user_height" value="<?php echo isset($dataRow[0]['user_height']) ? $dataRow[0]['user_height'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Weight</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_weight" name="user_weight" value="<?php echo isset($dataRow[0]['user_weight']) ? $dataRow[0]['user_weight'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Relation</label>
                            <div class="col-lg-10">
                                <input type="text" id="user_rltn" name="user_rltn" value="<?php echo isset($dataRow[0]['user_rltn']) ? $dataRow[0]['user_rltn'] : '' ?>" class="form-control" placeholder="">
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
