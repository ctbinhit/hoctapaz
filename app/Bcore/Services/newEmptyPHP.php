<?php
$d->reset();
$sql = "select ten$lang as ten,tenkhongdau,id from #_product_danhmuc where type='duan' and noibat=1 and hienthi=1 order by stt,id asc limit 0,2";
$d->query($sql);
$duan_dm = $d->result_array();


$d->reset();
$sql_duan = "select ten$lang as ten,tenkhongdau,id,photo,gia,ngaytao,mota$lang as mota from #_product where hienthi=1 and id_danhmuc='" . $duan_dm[0]['id'] . "' and noibat=1 order by stt,id desc limit 0,4";
$d->query($sql_duan);
$duan_f = $d->result_array();

$d->reset();
$sql_duan2 = "select ten$lang as ten,tenkhongdau,id,photo,gia,ngaytao,mota$lang as mota from #_product where hienthi=1 and id_danhmuc='" . $duan_dm[0]['id'] . "' and noibat=1 order by stt,id desc";
$d->query($sql_duan2);
$duan_f2 = $d->result_array();

$d->reset();
$sql_video = "select id,ten$lang as ten,link from #_video where hienthi=1 order by stt,id desc";
$d->query($sql_video);
$video = $d->result_array();
?>
<div class="tieude_giua"><div><?= $duan_dm[0]['ten'] ?></div><span></span></div>
<div class="wap_item">
    <div class="slick_duan2">
        <div class="da_left">
            <div class="slick_dua1">
                <?php foreach ($duan_f2 as $v) { ?>
                    <div class="bx_sl">
                        <div class="da_img zoom_hinh hover_sang1"><a href="du-an/<?= $v['tenkhongdau'] ?>-<?= $v['id'] ?>.html" title="<?= $v['ten'] ?>">
                                <img src="thumb/600x470/1/<?php
                                if ($v['photo'] != NULL)
                                    echo _upload_sanpham_l . $v['photo'];
                                else
                                    echo 'images/noimage.png';
                                ?>" alt="<?= $v['ten'] ?>" /></a>
                        </div>
                        <div class="info_da clearfix">
                            <div class="ngaytao_da">
                                <p class="date-d"><?= date("d", $v['ngaytao']) ?></p>
                                <p class="date-m">Tháng <?= date("m", $v['ngaytao']) ?></p>
                                <p class="date-y"><?= date("y", $v['ngaytao']) ?></p>
                            </div>
                            <h3 class="da_name"><a href="du-an/<?= $v['tenkhongdau'] ?>-<?= $v['id'] ?>.html" title="<?= $v['ten'] ?>" ><?= $v['ten'] ?></a></h3>
                            <?= catchuoi($v['mota'], 200) ?>
                            <div class="da_gia">
                                <span>$ <?php
                                    if ($v['gia'] > 0)
                                        echo number_format($v['gia'], 0, ',', '.') . '  vnđ';
                                    else
                                        echo _lienhe;
                                    ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="da_right clearfix">
            <?php for ($j = 0, $count_duan_f = count($duan_f); $j < $count_duan_f; $j++) { ?>
                <div class="item_da">
                    <div class="da_img zoom_hinh hover_sang1"><a href="du-an/<?= $duan_f[$j]['tenkhongdau'] ?>-<?= $duan_f[$j]['id'] ?>.html" title="<?= $duan_f[$j]['ten'] ?>">
                            <img src="thumb/300x200/1/<?php
                            if ($duan_f[$j]['photo'] != NULL)
                                echo _upload_sanpham_l . $duan_f[$j]['photo'];
                            else
                                echo 'images/noimage.png';
                            ?>" alt="<?= $duan_f[$j]['ten'] ?>" /></a>
                    </div>
                    <div class="info_da clearfix">
                        <div class="ngaytao_da">
                            <p class="date-d"><?= date("d", $duan_f[$j]['ngaytao']) ?></p>
                            <p class="date-m">Tháng <?= date("m", $duan_f[$j]['ngaytao']) ?></p>
                            <p class="date-y"><?= date("y", $duan_f[$j]['ngaytao']) ?></p>
                        </div>
                        <h3 class="da_name"><a href="du-an/<?= $duan_f[$j]['tenkhongdau'] ?>-<?= $duan_f[$j]['id'] ?>.html" title="<?= $duan_f[$j]['ten'] ?>" ><?= $duan_f[$j]['ten'] ?></a></h3>
                        <?= catchuoi($duan_f[$j]['mota'], 100) ?>
                        <div class="da_gia">
                            <span>$ <?php
                                if ($duan_f[$j]['gia'] > 0)
                                    echo number_format($duan_f[$j]['gia'], 0, ',', '.') . '  vnđ';
                                else
                                    echo _lienhe;
                                ?></span>
                        </div>
                    </div>
                </div><!---END .item-->
            <?php } ?>
        </div>
    </div>

</div><!---END .wap_item-->

<?php
$d->reset();
$sql_duan = "select ten$lang as ten,tenkhongdau,id,photo,gia,ngaytao,mota$lang as mota from #_product where hienthi=1 and id_danhmuc='" . $duan_dm[1]['id'] . "' and noibat=1 order by stt,id desc ";
$d->query($sql_duan);
$duan_s = $d->result_array();
?>
<div class="tieude_giua"><div><?= $duan_dm[1]['ten'] ?></div><span></span></div>
<div class="wap_item">
    <div class="slick_duan1">
        <?php for ($j = 0, $count_duan_s = count($duan_s); $j < $count_duan_s; $j++) { ?>
            <div class="item_do1">
                <div class="pad_Z"><?= $j ?>
                    <p class="do_img zoom_hinh hover_sang1">
                        <a href="du-an/<?= $duan_s[$j]['tenkhongdau'] ?>-<?= $duan_s[$j]['id'] ?>.html" title="<?= $duan_s[$j]['ten'] ?>">
                            <img src="thumb/375x205/1/<?php
                            if ($duan_s[$j]['photo'] != NULL)
                                echo _upload_sanpham_l . $duan_s[$j]['photo'];
                            else
                                echo 'images/noimage.png';
                            ?>" alt="<?= $duan_s[$j]['ten'] ?>" />
                        </a>
                    </p>
                    <h3 class="do_name"><a href="du-an/<?= $duan_s[$j]['tenkhongdau'] ?>-<?= $duan_s[$j]['id'] ?>.html" title="<?= $duan_s[$j]['ten'] ?>" ><?= $duan_s[$j]['ten'] ?></a></h3>
                    <?= catchuoi($duan_s[$j]['mota'], 200) ?>
                    <div style="clear:both;"></div>
                </div><!---END .item-->
            </div>
        <?php } ?>
    </div>
</div><!---END .wap_item-->

<?php
$d->reset();
$sql_tinnb = "select ten$lang as ten,tenkhongdau,id,photo,ngaytao,mota$lang as mota from #_news where type='tintuc' and noibat=1 and hienthi=1  order by stt,id desc";
$d->query($sql_tinnb);
$tinnb = $d->result_array();
?>

<div class="box_tin">
    <div class="tieude_giua"><div>Tin tức nổi bật</div><span></span></div>
    <div class="tt_slick">
        <?php for ($i = 0, $count_tinnb = count($tinnb); $i < $count_tinnb; $i++) { ?>
            <div>
                <div class="item_tin">
                    <div class="da_img zoom_hinh hover_sang1"><a href="tin-tuc/<?= $tinnb[$i]['tenkhongdau'] ?>-<?= $tinnb[$i]['id'] ?>.html" title="<?= $tinnb[$i]['ten'] ?>">
                            <img src="thumb/370x225/1/<?php
                            if ($tinnb[$i]['photo'] != NULL)
                                echo _upload_tintuc_l . $tinnb[$i]['photo'];
                            else
                                echo 'images/noimage.png';
                            ?>" alt="<?= $tinnb[$i]['ten'] ?>" /></a>
                    </div>
                    <div class="info_da clearfix">
                        <div class="ngaytao_da">
                            <p class="date-d"><?= date("d", $tinnb[$i]['ngaytao']) ?></p>
                            <p class="date-m">Tháng <?= date("m", $tinnb[$i]['ngaytao']) ?></p>
                            <p class="date-y"><?= date("y", $tinnb[$i]['ngaytao']) ?></p>
                        </div>
                        <h3 class="da_name"><a href="tin-tuc/<?= $tinnb[$i]['tenkhongdau'] ?>-<?= $tinnb[$i]['id'] ?>.html" title="<?= $tinnb[$i]['ten'] ?>" ><?= $tinnb[$i]['ten'] ?></a></h3>
                            <?= catchuoi($tinnb[$i]['mota'], 100) ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

