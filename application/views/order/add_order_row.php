<span>
    <button type="button" class="btn green" onclick="javascript:add_product_order('<?= base_url() ?>', '<?= $this->router->class ?>', 'order_list');">Add Item <i class="icon-plus"></i></button>
</span>

<table class="table table-striped table-bordered table-hover" id="order_list">
    <thead>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th style="width:10%">Amount</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($itemsData)) {
            echo ($itemsData);
        }
        ?>
    </tbody>
</table>