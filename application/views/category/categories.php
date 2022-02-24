<span>
    <button type="button" class="btn green" onclick="javascript:add_category('<?= base_url() ?>', '<?= $this->router->class ?>', 'category_add');">Add <i class="icon-plus"></i></button>
</span>

<table class="table table-striped table-bordered table-hover" id="category_add">
    <thead>
        <tr>
            <th>Nama</th>
            <th>No. Documen</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($categoryData)) {
            echo ($categoryData);
        }
        ?>

    </tbody>
</table>