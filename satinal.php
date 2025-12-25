<?php 
$basarili = 0;

$title2="Satın Al - I Rock The 80s";
include "header.php";
if(!isset($_SESSION["kullaniciadi"])){ header("Location:index");}

if(!isset($_COOKIE['urun'])){ header("Location:panel");}
?>

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Ürünleri Satınal</h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            
            <div class="cart_inner">
<?php 
                                if(isset($_SESSION["kullaniciadi"])){
                                
                        
                            ?>
                <div class="row">
                
                <div class="col-lg-12">
                    <div class="login_form_inner" style=" padding-top: 0px; ">
                        <div class="text-center" style="background: #424242; padding-top: 10px;">
                      <a class="primary-btn" href="panel">Kullanıcı Panelim</a>  
                    <a class="primary-btn" href="sepet">Sepetteki Ürünlerim</a>
                    <a class="primary-btn" href="satinalinan">Satın alınan ürünler</a>
                    <a class="primary-btn" href="cikis">Çıkış yap</a>
                    </div>
                     </div>
            </div> </div>
  <?php  }?><br>

  <?php

$say=0;
$kid=$_SESSION["ixdim"];
$vt = new Veritabanim();
if ( isset($_COOKIE['urun']) ){
            foreach ( $_COOKIE['urun'] as $urun => $val ){

               @$yaz.=" id='".$urun."' OR ";
            }
        } 
        @$yaz= substr($yaz, 0, -3);  
 $sorgu = $vt->select("urunler","where  $yaz");
 $sayi=1;
if($sorgu != null) foreach( $sorgu as $satir ) { 
    @$yazdir=$satir["id"];
$sayi++;
    $say+=$satir["fiyat"]; 
    $sayimass=$satir["fiyat"]; 

    
if(isset($_POST['satinal'])){
    $bagis = 0;
if(isset($_POST['bagis_tutari']) && is_numeric($_POST['bagis_tutari'])){
    $bagis = floatval($_POST['bagis_tutari']);
}
$toplam_tutar = $say + $bagis;
   
    @$satinal=$_POST['satinal'];
    if(empty($_POST['ads']) or empty($_POST['kart'])  or empty($_POST['sta']) or empty($_POST['sty']) or empty($_POST['cvv'])){
 echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" >Kredi kartı bilgileri boş geçilemez ve kart bilgilerini doğru girmeniz gerekiyor.</div>';
 $basarili=0;}else{

$vt = new Veritabanim();

$sonuc = $vt->ekle("satinal",array(
    "kim_id"        => $kid,
    "urun_id"       => $yazdir,
    "urun_fiyat"    => $sayimass,
    "bagis_tutari"  => $bagis,
    "toplam_tutar"  => $toplam_tutar,
    "durum"         => "Onay Bekliyor"
));

setcookie('urun['.$yazdir.']', $yazdir, time() - 86400);
if($sonuc){
     $basarili=1;
}else{
    $basarili=0;
echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" >güncellenirken hata oluştu.</div>';

}
      
   }
}else{
    $basarili=0;
}
}

if($basarili==0){
?>

   <div class="row">
  <div class="col-lg-6">
    <h3>Kart bilgilerinizi giriniz</h3>
  <form class="row login_form" action="" method="post"  >
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control"  name="ads" placeholder="Kredi kartındaki ad soyad" >
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="number" class="form-control"  name="kart" placeholder="Kredi kartı numarası">
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control"  name="sta" maxlength="2" placeholder="son kullanma tarihi ay">
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" class="form-control"  name="sty" maxlength="4" placeholder="son kullanma tarihi yıl">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control"  name="cvv" maxlength="4" placeholder=" kart arkasında bulunan cvv">
                            </div>
                           <div class="col-md-12 from-group">
                             <div class="col-md-12 form-group">
                                <label>
                                    <input type="checkbox" style="height:10px"
                                        onclick="document.getElementById('bagis_alani').style.display=this.checked?'block':'none'">
                                    Bağış yapmak istiyorum
                                </label>
                            </div>

                            <div class="col-md-12 form-group" id="bagis_alani" style="display:none;">
                                <input type="number"
    class="form-control"
    name="bagis_tutari"
    min="0"
    placeholder="Bağış tutarı (TL)"
    oninput="bagisHesapla(this.value)">

                            </div>
                           </div>

                            <div class="col-md-12 form-group">
<h6>
    Ürün Tutarı: <?php echo $say; ?> TL<br>
    Bağış: <span id="bagis_goster">0</span> TL<br>
    <strong>Toplam: <span id="toplam_goster"><?php echo $say; ?></span> TL</strong>
</h6>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit"  name="satinal" class="primary-btn">Satın Al</button>                                
                            </div>
                        </form></div>
                        <div class="col-lg-6">
<img src="img/kredi-karti-harcamalari.png"></div>


                    </div> <?php }else{ ?>


   <div class="row">
  <div class="col-lg-6">
    <h3 class="text-center">Ödemeniz gerçekleştirilmiştir.</h3>
</div>
                        <div class="col-lg-6">
<img src="img/kredi-karti-harcamalari.png"></div>


                    </div> 

                         <?php } ?>
                
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <?php include "footer.php";
?> 
<script>
function bagisHesapla(deger){
    let urunToplam = <?php echo $say; ?>;
    let bagis = parseFloat(deger);

    if(isNaN(bagis)){
        bagis = 0;
    }

    document.getElementById("bagis_goster").innerText = bagis;
    document.getElementById("toplam_goster").innerText = urunToplam + bagis;
}
</script>
