
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <form id="user_profile_form" class="form-horizontal" method="post" action="<?= base_url() ?>profile/save" enctype="multipart/form-data">
                <div class="box-body">
                        <div class="form-group">
                            <label class="control-label col-lg-2">Personnel Number</label>
                            <div class="col-lg-10">
                                <label style="padding-top:7px;margin-bottom:0px;font-weight:2 !important"><?php echo isset($dataRow[0]->user_id) ? $dataRow[0]->user_id : '' ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Nama</label>
                            <div class="col-lg-10">
                                <label style="padding-top:7px;margin-bottom:0px;font-weight:2 !important"><?php echo isset($dataRow[0]->user_name) ? $dataRow[0]->user_name : '' ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Departemen</label>
                            <div class="col-lg-10">
                                <label style="padding-top:7px;margin-bottom:0px;font-weight:2 !important"><?php echo isset($dataRow[0]->user_unit_name) ? $dataRow[0]->user_unit_name : '' ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Jabatan</label>
                            <div class="col-lg-10">
                                <label style="padding-top:7px;margin-bottom:0px;font-weight:2 !important"><?php echo isset($dataRow[0]->user_jbtn_name) ? $dataRow[0]->user_jbtn_name : '' ?></label>
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
                            <label class="control-label col-lg-2">Photo</label>
                            <div class="col-lg-10">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="height: 200px;">
                                    <?php if (isset($dataRow[0]->user_image) && $dataRow[0]->user_image != '') { ?>
                                            <img src="<?=base_url().$dataRow[0]->user_image?>" alt="" style="width:100%"/>
                                            <input type="hidden" id="user_image" name="user_image" value="<?=(isset($dataRow[0]->user_image) ? $dataRow[0]->user_image:'')?>"/>
                                        <?php } else { ?>
                                            <img src="<?=base_url()?>assets/themes/dist/images/no_image.gif" style="width:100%"/>
                                    <?php } ?>
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                    </div>
                                    <div class="col-md-12">
                                        <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                            <span class="fileupload-exists">Change</span>
                                            <input type="file" class="default" id="user_image_file" name="user_image_file"/></span>
                                        <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <input type="hidden" id="id" name="id" value="<?php echo isset($dataRow[0]->id) ? $dataRow[0]->id : '' ?>"/>
                                <button class="btn btn-primary" type="button" onclick="javascript:check_pass('user_profile_form')">Save <i class="icon-arrow-right14 position-right"></i></button>
                                <button class="btn btn-primary" type="submit" id="btncancel" name="btncancel" value="Cancel">Cancel</button>
                            </div>
                        </div>
                </div>
                </form>

                
                
            </div>
        </div>
    </div>
</div>
</section>
<script type="text/javascript" src="<?=$themes?>/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$themes?>/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
