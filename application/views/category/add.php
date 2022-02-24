<script type="text/javascript" src="<?= base_url() ?>assets/application.js"></script>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="post" action="<?= base_url() ?>category/save">
                        <div class="form-group">
                            <label class="control-label col-lg-2">Menu</label>
                            <div class="col-lg-4">
                                <?= $menuList ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2"></label>
                            <div class="col-lg-10"><?php include 'categories.php'; ?> </div>
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