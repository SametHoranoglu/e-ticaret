<?php include "header.php";


?>

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                       
                        <div class="row m-t-25">

    <!-- Kullanıcı Sayısı -->
     <div class="col-sm-6 col-lg-2">
        <div class="overview-item overview-item--c1">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-account-o"></i>
                    </div>
                    <div class="text">
                        <h2>
                        <?php
                        $sorgu = $dbs->prepare("SELECT COUNT(*) FROM kullanici");
                        $sorgu->execute();
                        echo $sorgu->fetchColumn();
                        ?>
                        </h2>
                        <span>Kullanıcı Sayısı</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Satın Alınan Ürünler -->
     <div class="col-sm-6 col-lg-2">
        <div class="overview-item overview-item--c2">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                    <div class="text">
                        <h2>
                        <?php
                        $sorgu = $dbs->prepare("SELECT COUNT(*) FROM satinal");
                        $sorgu->execute();
                        echo $sorgu->fetchColumn();
                        ?>
                        </h2>
                        <span>Satın Alınan Ürünler</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toplam Ürün -->
     <div class="col-sm-6 col-lg-2">
        <div class="overview-item overview-item--c3">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-chart"></i>
                    </div>
                    <div class="text">
                        <h2>
                        <?php
                        $sorgu = $dbs->prepare("SELECT COUNT(*) FROM urunler");
                        $sorgu->execute();
                        echo $sorgu->fetchColumn();
                        ?>
                        </h2>
                        <span>Toplam Ürünler</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toplam Kazanç -->
     <div class="col-sm-6 col-lg-2">
        <div class="overview-item overview-item--c4">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi">₺</i>
                    </div>
                    <div class="text">
                        <h2>
                        <?php
                        $sorgu = $dbs->prepare("SELECT SUM(urun_fiyat) FROM satinal");
                        $sorgu->execute();
                        echo $sorgu->fetchColumn() ?? 0;
                        ?> ₺
                        </h2>
                        <span>Toplam Kazanç</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔥 TOPLAM BAĞIŞ -->
     <div class="col-sm-6 col-lg-2">
        <div class="overview-item overview-item--c5" style="background:pink">
            <div class="overview__inner">
                <div class="overview-box clearfix">
                    <div class="icon">
                        <i class="zmdi zmdi-favorite"></i>
                    </div>
                    <div class="text">
                        <h2>
                        <?php
                        $sorgu = $dbs->prepare("SELECT SUM(bagis_tutari) FROM satinal");
                        $sorgu->execute();
                        $toplamBagis = $sorgu->fetchColumn();
                        echo ($toplamBagis > 0) ? $toplamBagis : 0;
                        ?> ₺
                        </h2>
                        <span>Toplam Bağış</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>                
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">En son  satın alınan 7 ürün</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Ürün Adı</th>
                                                <th>Alım Tarihi</th>
                                                <th class="text-right">Satış fiyatı</th>
                                        </thead>
                                        <tbody>
                                            <?php
$sorgu = $vt->selectjoin("
SELECT * FROM satinal AS al
JOIN urunler  AS urun ON al.urun_id=urun.id order by tarih desc LIMIT 7
");
if($sorgu != null) foreach( $sorgu as $satir ) { 
                                             ?>
                                            <tr>
                                                 <td><?php echo $satir["baslik"];  ?></td>
                                                <td><?php echo $satir["tarih"];  ?></td>
                                                <td class="text-right"><?php echo $satir["fiyat"];  ?> TL</td>
                                            </tr>
                                        <?php } ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                        
                   
<?php include "footer.php";
?>