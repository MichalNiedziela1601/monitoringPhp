<?php
date_default_timezone_set('Europe/Warsaw');
$prze = $_GET['prze'];

if(!isset($_GET['dzien']))
{
//bycmoz eprzeniesc
$miesiac=date("m");
$dzien=date("d");
$rok=date("Y");
$godzina=date("H");
$minuta=date("i");

$czas_aktu = mktime();
}

if(isset($_GET['dzien']))
{
//bycmoz eprzeniesc
$miesiac=$_GET['miesiac'];
$dzien=$_GET['dzien'];
$rok=$_GET['rok'];
$godzina=$_GET['godzina'];
$minuta=$_GET['minuta'];

$czas_aktu = mktime($godzina,$minuta,00,$miesiac,$dzien,$rok);
}


include 'config.php';


$tmp_delta_p = 1;
$tmp_delta_h = 0;

//wy�wietlanie lini delt $tmp_delty_wys_l = 1;
$tmp_delty_wys_l = 1;
//wy�wietlanie slupkow delt $tmp_delty_wys_s = 1;
$tmp_delty_wys_s = 0;

//max wartosc delt na wykresach 1 dla 100 mm ; 2 dla 200
$tmp_delty_wys_max_wykresu = 2;
//**koniec 2008.10.16

function get_data($data)
{
    $data_y = substr($data, 0, 4);
    $data_m = substr($data, 5, 2);
    $data_d = substr($data, 8, 2);

    $data_h = substr($data, 11, 2);
    $data_mi = substr($data, 14, 2);
    $data_s = substr($data, 17, 2);

    //echo "{$data}-{$data_h},{$data_m},{$data_s}<br>";

    $data_mktime = mktime($data_h,$data_mi,$data_s,$data_m,$data_d,$data_y);
    return $data_mktime;
}

function get_data_db($data_time)
{
    $data = date ("Y-m-d H:i:s", $data_time);
    return $data;
}

function get_data_tab($data_time)
{
    $data = date ("H:i-d.m", $data_time);
    return $data;
}

function get_data_add_h($add_h)
{

    $y = date("Y", mktime());
    $m = date("m", mktime());
    $d = date("d", mktime());
    $h = date("H", mktime());
    $i = date("i", mktime());
    $s = date("s", mktime());

    $data=mktime($h+$add_h,$i,$s,$m,$d,$y);

    $data = date("Y-m-d H:i:s", $data);
    return $data;
}

function get_data_db_add_h($mkt, $add_h) {
    $y = date("Y", $mkt);
    $m = date("m", $mkt);
    $d = date("d", $mkt);
    $h = date("H", $mkt);
    $i = date("i", $mkt);
    $s = date("s", $mkt);

    $data=mktime($h+$add_h,$i,$s,$m,$d,$y);

    $data = date("Y-m-d H:i:s", $data);
    return $data;
}



function get_data_add_h_22($mkt)
{

    $y = date("Y", $mkt);
    $m = date("m", $mkt);
    $d = date("d", $mkt);
    $h = date("H", $mkt);
    $i = date("i", $mkt);
    $s = date("s", $mkt);

    $data=mktime($h-22,$i,$s,$m,$d,$y);

    $data = date("Y-m-d H:i:s", $data);
    return $data;
}

function get_data_add_h2($mkt)
{

    $y = date("Y", $mkt);
    $m = date("m", $mkt);
    $d = date("d", $mkt);
    $h = date("H", $mkt);
    $i = date("i", $mkt);
    $s = date("s", $mkt);

    $data=mktime($h+2,$i,$s,$m,$d,$y);

    $data = date("Y-m-d H:i:s", $data);
    return $data;
}

function get_data_km_add_h($add_h)
{

    $y = date("Y", mktime());
    $m = date("m", mktime());
    $d = date("d", mktime());
    $h = date("H", mktime());
    $i = date("i", mktime());
    $s = date("s", mktime());

    $data=mktime($h+$add_h,$i,$s,$m,$d,$y);

    //$data = date("Y-m-d H:i:s", $data);
    return $data;
}

function get_data_km_add_h2($mkt)
{

    $y = date("Y", $mkt);
    $m = date("m", $mkt);
    $d = date("d", $mkt);
    $h = date("H", $mkt);
    $i = date("i", $mkt);
    $s = date("s", $mkt);

    $data=mktime($h+2,$i,$s,$m,$d,$y);

    //$data = date("Y-m-d H:i:s", $data);
    return $data;
}




function get_miejsce($prze)
{
    $nazwa = "";
    $connect = connect();
    $result = mysqli_query($connect,("SELECT * FROM `wizu` WHERE `id_ppwr`='{$prze}' LIMIT 0 , 1"));
    while($wiersz= mysqli_fetch_array ($result)){
        $nazwa = $wiersz['miejsce'];
    }
    return $nazwa;
}


function get_data_db_2($data)
{
    $data = substr($data, 0, 8);
    $data_y = substr($data, 0, 4);
    $data_m = substr($data, 4, 2);
    $data_d = substr($data, 6, 2);
    $data = "{$data_y}-{$data_m}-{$data_d}";
    return $data;
}

function pozostalo_dni($data_wyk)
{
    //$czas_z_bazy = "20070310000000";

    $d_d = substr($data_wyk, 6, 2);
    $d_m = substr($data_wyk, 4, 2);
    $d_y = substr($data_wyk, 0, 4);

    $czas_1ty = time();

    $z4 = mktime(0, 0, 0, $d_m, $d_d, $d_y);
    $z4 = $z4 - $czas_1ty;
    $dz = 86400;
    $poz_dni = $z4/$dz;
    $tab_1 = explode(".", $poz_dni);
    $poz_dni = $tab_1[0];

    return $poz_dni;
}


function get_data_zle($id_zlecenie)
{
    $connect = connect();
    $kolor = "";
    $zapytanie2 = "select * from `s_zamowienia` WHERE `id_zamowienie`=\"$id_zlecenie\" ";
    $wykonaj2 = mysqli_query($connect, ($zapytanie2));
    while($wiersz2= mysqli_fetch_array ($wykonaj2))
    {
        $data_zam = $wiersz2['data_wyk'];
    }

    $data_zam = get_data($data_zam);

    return $data_zam;
}





$connect = connect();




$result = mysqli_query($connect,"SELECT * FROM `wizu` WHERE `id_ppwr`='{$prze}' LIMIT 0 , 1");
while($wiersz=mysqli_fetch_array ($result)){
$npm = $wiersz['npm'];
}


$nazwa = get_miejsce($prze);


$naglowek = "Wykres delt (przyrost�w) stanu wody, lokalizacja -  {$nazwa}";

$wys_w_h = 200;
$szer_w_h = 1000;


$punkty_tla = array(
            0,  0,
            $szer_w_h,  0,
            $szer_w_h,  $wys_w_h,
            0,$wys_w_h
            );



$punkty_tla_prognozy = array(
            920, 0,
            1000,  0,
            1000,  200,
            920,200
            );
			
$punkty_tla_prognozy2 = array(
            920, 0,
            1000,  0,
            1000,  30,
            920,30
            );
						
// create image
$image = imagecreatetruecolor($szer_w_h, $wys_w_h);

// some colors
$bialy   = imagecolorallocate($image, 255, 255, 255);
$szary = imagecolorallocate($image, 182, 182, 160);
$czarny = imagecolorallocate($image, 0, 0, 0);
$niebieski = imagecolorallocate($image, 0, 0, 250);
$prognoza = imagecolorallocate($image, 0, 255, 252);
$prognoza2 = imagecolorallocate($image, 197, 248, 247);
$ciemnoszary = imagecolorallocate($image, 150, 150, 150);
$czerwony = imagecolorallocate($image, 255, 0, 0);
$pomarancz = imagecolorallocate($image, 255, 155, 15);

// rysuj t�o
imagefilledpolygon($image, $punkty_tla, 4, $bialy);

//nag��wek
ImageString($image,6,75,10,$naglowek,$czarny);

// rysuj t�o prognozy
imagefilledpolygon($image, $punkty_tla_prognozy, 4, $prognoza);

// rysuj t�o napisu prognoza
imagefilledpolygon($image, $punkty_tla_prognozy2, 4, $prognoza2);

//napis prognoza
ImageString($image,3,930,10,"Prognoza",$czerwony);


//rysuj osie
imageline($image,40,$wys_w_h,40,0,$czarny);


imageline($image,0,100,$szer_w_h,100,$czarny);


//podzia�ki na lini czasu
for($i=1; $i<24; $i++)
{
$d_i=mktime($godzina-22+$i,$minuta,0,$miesiac,$dzien,$rok);


$txt_d = date("H:i",$d_i);
//$txt_npm = $i+$npm;

//$txt = "{$txt_h}/{$txt_npm}";
imageline($image,40+($i*40),($wys_w_h/2)+5,40+($i*40),($wys_w_h/2)-5,$czarny);
ImageString($image,2,27+($i*40),($wys_w_h/2)+12,$txt_d,$szary);
}


//podzia�ki na lini czasu
//for($i=1; $i<24; $i++)
//{
//bycmoz eprzeniesc
//$miesiac=date("m");
//$dzien=date("d");
//$rok=date("Y");
//$godzina=date("H");
//$minuta=date("i");

//$d_i=mktime($godzina-22+$i,$minuta,0,$miesiac,$dzien,$rok);


//$txt_d = date("H:i",$d_i);
//$txt_npm = $i+$npm;

//$txt = "{$txt_h}/{$txt_npm}";
//imageline($image,40+($i*40),($wys_w_h/2)+5,40+($i*40),($wys_w_h/2)-5,$czarny);
//ImageString($image,2,27+($i*40),($wys_w_h/2)+12,$txt_d,$szary);
//}




//pobierz pomiary z ostatniuch 22h + wylicz delty- rysuj linie delt

$d_0 = get_data_db($czas_aktu);
$d_1 = get_data_add_h_22($czas_aktu);

//$pomiary_h_t[];

$result = mysqli_query($connect,"SELECT * FROM `pomiarypoziomow` WHERE `id_ppwr`='{$prze}' AND `czas` BETWEEN '{$d_1}' AND '{$d_0}' order by `czas` DESC");
while($wiersz=mysqli_fetch_array ($result)){
$pomiary_h_t[] = $wiersz['wartosc'];
$data_pom = $wiersz['czas'];
$pomiary_h_t[] = get_data($data_pom);
}



//dodac do tablicy prognozy - albo i nie
$il_tab_pun = count($pomiary_h_t);

//zmienan zawierajaca max wartosc bezwzgl�dn� delta
//$max_delta = 0;


//tworzenie tablicy delt
for($i=0; $i<$il_tab_pun; $i = $i+2)
{
if($pomiary_h_t[$i+2]>0)
{
$delta = $pomiary_h_t[$i] - $pomiary_h_t[$i+2];

//pobieranie maxymalnej wartosci bezwzglednej delta
//if($delta > $max_delta)
//{
//$max_delta = $delta;
//}

//if($delta < 0)
//{
//$delta_tmp = -$delta;

//if($delta_tmp > $max_delta)
//{
//$max_delta = $delta_tmp;
//}
//}

$delta_t = $pomiary_h_t[$i+1];

$delta_t_tmp = $pomiary_h_t[$i+1] - $pomiary_h_t[$i+3];

//ilosc godzin = 0.25 dla 15min
$ilosc_godzin = $delta_t_tmp/3600;

//***poczatek 1 2008.10.16
//bylo $delta = $delta/$ilosc_godzin;
if(($tmp_delta_p == 1) AND ($tmp_delta_h == 0))
{
$delta = $delta;
}
if(($tmp_delta_p == 0) AND ($tmp_delta_h == 1))
{
$delta = $delta/$ilosc_godzin;
}
//***koniec 1 2008.10.16

$pomiary_d[] = $delta;
$pomiary_d[] = $delta_t;
}
}

$il_tab_pro = count($pomiary_d);

//sprawdzanei jaka jest maxymalna wartosc bezwzgledna delta i dobieranie skali/zakresu wykresu
//skala zalezy od max delty - i jest r�wna 0.1 wartosci delty jaka max obrazuje wykres dla $skala_delt1=10 na wykresie widac 100 a dla $skala_delt1=1 na wykresie widac 10

//if($max_delta < 10)
//{
//$skala_delt1 = 1;
//}

//if(($max_delta > 10)&&($max_delta <= 30))
//{
//$skala_delt1 = 3;
//}


//if(($max_delta > 30)&&($max_delta <= 50))
//{
//$skala_delt1 = 5;
//}


//if($max_delta >50)
//{
//$skala_delt1 = 10;
//}

$skala_delt1 = 10;


//podzia�ki na lini wysokosci
for($i=1; $i<10; $i++)
{
//***poczatek 2 2008.10.16
//bylo $txt = $i*$skala_delt1;
$txt = $i*$skala_delt1*$tmp_delty_wys_max_wykresu;
//***koniec 2 2008.10.16

$txt_d = " {$txt} cm";
$txt_d_u = "-{$txt} cm";

imageline($image,38,$wys_w_h-($i*10),42,$wys_w_h-($i*10),$czarny);
imageline($image,38,$i*10,42,$i*10,$czarny);
ImageString($image,2,2,$wys_w_h/2-(10*$i)-7,$txt_d,$czarny);
ImageString($image,2,2,$wys_w_h/2+(10*$i)-7,$txt_d_u,$czarny);
}




for($i=0; $i<$il_tab_pro; $i = $i+2)
{
if($pomiary_d[$i+3]>0)
{
//***poczatek 3 2008.10.16
//bylo $rys_h_1 = $pomiary_d[$i];
$rys_h_1 = $pomiary_d[$i]/$tmp_delty_wys_max_wykresu;
//***koniec 3 2008.10.16

$rys_t_1 = $pomiary_d[$i+1];
$rys_t_1 = $czas_aktu-$rys_t_1;

//***poczatek 4 2008.10.16
//bylo $rys_h_2 = $pomiary_d[$i+2];
$rys_h_2 = $pomiary_d[$i+2]/$tmp_delty_wys_max_wykresu;
//***koniec 4 2008.10.16

$rys_t_2 = $pomiary_d[$i+3];
$rys_t_2 = $czas_aktu-$rys_t_2;


$t1 = 920-(($rys_t_1/3600)*40);
$t2 = ($wys_w_h/2)-(($rys_h_1*10)/$skala_delt1);
$t3 = 920-(($rys_t_2/3600)*40);
$t4 = ($wys_w_h/2)-(($rys_h_2*10)/$skala_delt1);

//*****poczatek 5 2008.10.16 
//bylo imageline($image,$t1,$t2,$t3,$t4,$czarny);
$kolor_kolumn_wykresu = $pomarancz;

if($t2 < 0)
{
$kolor_kolumn_wykresu = $czerwony;
}


$punkty_kolumn_wykresu = array(
            $t1, 100,
            $t1,  $t2,
            $t3,  $t2,
            $t3,100
            );
if($tmp_delty_wys_s == 1)
{
imagefilledpolygon($image, $punkty_kolumn_wykresu, 4, $kolor_kolumn_wykresu); 
}


//rysuje wykres delt 
if($tmp_delty_wys_l == 1)
{
 imageline($image,$t1,$t2,$t3,$t4,$czarny);
}
//*****koniec 5 2008.10.16 
}
}

$dp_0 = get_data_db($czas_aktu);
$dp_1 = get_data_add_h2($czas_aktu);

$result = mysqli_query($connect,"SELECT * FROM `pomiarypoziomowprognozy` WHERE `id_ppwr`='{$prze}' AND `czas` BETWEEN '{$dp_0}' AND '{$dp_1}' order by `czas` DESC");
while($wiersz=mysqli_fetch_array ($result)){
$pomiary_h_tp[] = $wiersz['wartosc'];
$data_pomp = $wiersz['czas'];
$pomiary_h_tp[] = get_data($data_pomp);
}

$czas_pocz = get_data_km_add_h2($czas_aktu);

if (($pomiary_h_tp[0]>0) &&($pomiary_h_tp[1]>0))


{
 $rys_h_1=$pomiary_d[0]/$tmp_delty_wys_max_wykresu;
 $rys_h_2=($pomiary_h_tp[0]-$pomiary_h_t[0])/$tmp_delty_wys_max_wykresu;

 $rys_t_1 = $pomiary_d[1];
 $rys_t_1 = $czas_aktu-$rys_t_1;

 $rys_t_2 = $pomiary_h_tp[1];
 $rys_t_2 = $czas_aktu-$rys_t_2;

 $t1 = 920-(($rys_t_1/3600)*40);
 $t2 = ($wys_w_h/2)-(($rys_h_1*10)/$skala_delt1);
 $t3 = 920-(($rys_t_2/3600)*40);
 $t4 = ($wys_w_h/2)-(($rys_h_2*10)/$skala_delt1);


 imageline($image,$t1,$t2,$t3,$t4,$czarny);

}




//tworzenie tablicy delt
/*
for($i=0; $i<$il_tab_punp; $i = $i+2)
{
//if($pomiary_h_tp[$i+2]>0)
//{
$deltap = $pomiary_h_tp[$i] - $pomiary_h_tp[$i+2];

$delta_tp = $pomiary_h_tp[$i+1];

$delta_t_tmpp = $pomiary_h_tp[$i+1] - $pomiary_h_tp[$i+3];

//ilosc godzin = 0.25 dla 15min
$ilosc_godzinp = $delta_t_tmpp/3600;

//*****poczatek 6 2008.10.16 
//bylo $deltap = $deltap/$ilosc_godzinp;
if(($tmp_delta_p == 1) AND ($tmp_delta_h == 0))
{
$deltap = $deltap;
}
if(($tmp_delta_p == 0) AND ($tmp_delta_h == 1))
{
$deltap = $deltap/$ilosc_godzinp;
}
//*****koniec 6 2008.10.16 

$pomiary_dp[] = $deltap;
$pomiary_dp[] = $delta_tp;
//}
}


//$czas_pocz = get_data_km_add_h(+2);


$il_tab_prop = count($pomiary_dp);

for($i=0; $i<$il_tab_prop; $i = $i+2)
{
if($pomiary_dp[$i+3]>0)
{
//*****poczatek 7 2008.10.16 
//bylo $rys_h_1p = $pomiary_dp[$i];
$rys_h_1p = $pomiary_dp[$i]/$tmp_delty_wys_max_wykresu;
//*****koniec 7 2008.10.16 

$rys_t_1p = $pomiary_dp[$i+1];
$rys_t_1p = $czas_pocz-$rys_t_1p;

//*****poczatek 8 2008.10.16 
//bylo $rys_h_2p = $pomiary_dp[$i+2];
$rys_h_2p = $pomiary_dp[$i+2]/$tmp_delty_wys_max_wykresu;
//*****koniec 8 2008.10.16 

$rys_t_2p = $pomiary_dp[$i+3];
$rys_t_2p = $czas_pocz-$rys_t_2p;

$t1p = 1000-(($rys_t_1p/3600)*40);
$t2p = ($wys_w_h/2)-(($rys_h_1p*10)/$skala_delt1);
$t3p = 1000-(($rys_t_2p/3600)*40);
$t4p = ($wys_w_h/2)-(($rys_h_2p*10)/$skala_delt1);

//*****poczatek 9 2008.10.16
//bylo imageline($image,$t1p,$t2p,$t3p,$t4p,$czarny);
$kolor_kolumn_wykresu = $pomarancz;

if($t2p < 0)
{
$kolor_kolumn_wykresu = $czerwony;
}


$punkty_kolumn_wykresup = array(
            $t1p, 100,
            $t1p,  $t2p,
            $t3p,  $t2p,
            $t3p,100
            );
//rysowanie prostokatow - slupkow prognoz			

 if($tmp_delty_wys_s == 1)
 {
  imagefilledpolygon($image, $punkty_kolumn_wykresup, 4, $kolor_kolumn_wykresu); 
 }
 if($tmp_delty_wys_l == 1)
 {
  imageline($image,$t1p,$t2p,$t3p,$t4p,$czarny);
 }
//*****koniec 9 2008.10.16
}
}


*/


//*****poczatek 10 2008.10.16
//powt�rzone wypisanie nag��wka bo dla wykresu s�upkowego s�upki zas�ania�y napis
ImageString($image,6,75,10,$naglowek,$czarny);
//*****koniec 10 2008.10.16

// flush image
//header('Content-type: image/png');
//imagepng($image);
//imagedestroy($image);

$fileName = 'wykres_d.png';
imagepng($image, $fileName);
imagedestroy($image);
$base64Image = base64_encode(file_get_contents($fileName));
echo $base64Image;
unlink($fileName);
exit;
?> 