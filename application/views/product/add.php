
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <form id="user_admin_form" class="form-horizontal" method="post" action="<?= base_url() ?>product/save" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-lg-2">Name</label>
                            <div class="col-lg-10">
                                <input type="text" id="prdc_name" name="prdc_name" value="<?php echo isset($dataRow[0]['prdc_name']) ? $dataRow[0]['prdc_name'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Category</label>
                            <div class="col-lg-10">
                                <select id="prdc_ctgr_id" name="prdc_ctgr_id" class="form-control">
                                    <option value="">--</option>
                                    <?php if (sizeof($category) >0) {
                                        $selected = '';
                                        foreach($category as $index => $value) {
                                            if (isset($dataRow[0]['prdc_ctgr_id'])) {
                                                if ($dataRow[0]['prdc_ctgr_id'] == $value['id']) {
                                                    $selected = 'selected="selected"';
                                                } else {
                                                    $selected = '';
                                                }
                                            }
?>
                                            <option value="<?=$value['id']?>" <?=$selected?>><?=$value['ctgr_name']?></option>
                                    <?php }
                                    }
?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Price</label>
                            <div class="col-lg-10">
                                <input type="text" id="prdc_price" name="prdc_price" value="<?php echo isset($dataRow[0]['prdc_price']) ? $dataRow[0]['prdc_price'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="text-center">
                        <input type="hidden" id="id" name="id" value="<?php echo isset($dataRow[0]['id']) ? $dataRow[0]['id'] : '' ?>"/>
                            <button class="btn btn-primary" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                            <button class="btn btn-primary" type="submit" id="btncancel" name="btncancel" value="Cancel">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?=$themes?>/plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$themes?>/plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
<script type="text/javascript">
    $(document).ready(function () {
    });
     
</script>