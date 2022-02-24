<html>
    <body>
        <?php if (sizeof($reportData) > 0) {?>
            <div style="width:100%;">
                <!--<div style="font-size:10px;width:40%;float:left;">No. Reg</div>-->
                <div style="font-size:16px;text-align:center;margin-bottom: 20px;"><u><?=$reportData[0]['order_reg_nmbr']?></u></div>
            </div>
        <div style="width:100%;margin-left:20px;">
            <div style="width:100%;">
                <div style="font-size:10px;width:50%;float:left;">Nama</div>
                <div style="font-size:10px;">: <?=$reportData[0]['user_name']?></div>
            </div>
            <div style="width:100%;">
                <div style="font-size:10px;width:50%;float:left;">Kategori</div>
                <div style="font-size:10px;">: <?=$reportData[0]['ctgr_name']?></div>
            </div>
            <div style="width:100%;">
                <div style="font-size:10px;width:50%;float:left;">Layanan</div>
                <div style="font-size:10px;">: <?=$reportData[0]['prdc_name']?></div>
            </div>
            <div style="width:100%;">
                <div style="font-size:10px;width:50%;float:left;">Sample Date</div>
                <div style="font-size:10px;">: <?=$sample_date?></div>
            </div>
            <div style="width:100%;">
                <div style="font-size:10px;width:50%;float:left;">Sample Time</div>
                <div style="font-size:10px;">: <?=$sample_time?></div>
            </div>
            </div>
        <?php }
?>
    </body>
</html>