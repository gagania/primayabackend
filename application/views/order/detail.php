<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                </div>
                <div class="box-body">
                    <form id="user_admin_form" class="form-horizontal" method="post" action="<?= base_url().$this->router->fetch_class() ?>/save">
                        <div class="form-group">
                            <label class="control-label col-lg-2">Table Name</label>
                            <div class="col-lg-10">
                                <input type="text" id="order_table" name="order_table" value="<?php echo isset($dataRow[0]['order_table']) ? $dataRow[0]['order_table'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Order Number</label>
                            <div class="col-lg-10">
                                <input type="text" id="order_nmbr" name="order_nmbr" value="<?php echo isset($dataRow[0]['order_nmbr']) ? $dataRow[0]['order_nmbr'] : '' ?>" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Items</label>
                            <div class="col-md-8">
                               <div class=""><?php include 'add_order_row.php'; ?> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Harga</label>
                            <div class="col-md-6">
                                <input type="text" id="order_cost" name="order_cost" 
                                       value="<?=isset($dataRow)? $dataRow[0]['order_cost']:'0'?>" 
                                       class="form-control" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Ppn (10%)</label>
                            <div class="col-md-6">
                                <input type="text" id="order_ppn" name="order_ppn" 
                                       value="<?=isset($dataRow)? $dataRow[0]['order_ppn']:'0'?>" 
                                       class="form-control" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Total</label>
                            <div class="col-md-6">
                                <input type="text" id="order_total_cost" name="order_total_cost" 
                                       value="<?=isset($dataRow)? $dataRow[0]['order_total_cost']:'0'?>" 
                                       class="form-control" readonly/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Payment</label>
                            <div class="col-md-3">
                                <input type="text" id="order_payment" name="order_payment" 
                                       value="<?=isset($dataRow)? $dataRow[0]['order_payment']:'0'?>" 
                                       class="form-control number"/>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="button" 
                                        id="btnpay" name="btnpay" value=""
                                        onclick="javascript:payment_order();">Pay</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Change</label>
                            <div class="col-md-3">
                                <input type="text" id="order_change" name="order_change" 
                                       value="<?=isset($dataRow)? $dataRow[0]['order_change']:'0'?>" 
                                       class="form-control" readonly/>
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
<script type="text/javascript">
    $(document).ready(function () {
        set_number();
    });
</script>