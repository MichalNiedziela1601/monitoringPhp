<?php
//zmienna okreslajaca ID przekroju - z tym parametrem tzreba wywo³ywac skrypt







include 'config.php';
//***poczatek 2008.10.16
//wyœwietlanie delty pomiaru $tmp_delta_p = 1 albo delty godzinnej $tmp_delta_h = 1
$tmp_delta_p = 1;
$tmp_delta_h = 0;

//wyœwietlanie lini delt $tmp_delty_wys_l = 1;
$tmp_delty_wys_l = 1;
//wyœwietlanie slupkow delt $tmp_delty_wys_s = 1;
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




$prze = $_GET['prze'];


if(isset($_GET['skala']))
{
$skala = $_GET['skala'];
}

$punkty = "";

//include("{$prze}.php");
//include 'config.php';
//require 'funk.php';

$connect = connect();
$result = mysqli_query($connect,"SELECT * FROM `wizu` WHERE `id_ppwr`='{$prze}' LIMIT 0 , 1");

while($wiersz= mysqli_fetch_array ($result)){

if(!isset($skala))
{
$skala = $wiersz['skala'];
}
$npm = $wiersz['npm'];
$parm_prze_x = $wiersz['par_prze_x'];

$szerokosc = $skala*$wiersz['szer'];
$wysokosc = $skala*$wiersz['wys'];
$punkty = $wiersz['punkty'];

}
//$tab_pun = explode(",", $punkty);
//$il_pun = count($tab_pun);
//for($i=0; $i<$il_pun; $i++)
//(
//$punkty_przekroju_1[] = $tab_pun[$i];
//)
$punkty_przekroju_1 = explode(",", $punkty);


$nazwa = get_miejsce($prze);

//h w cm
//$wysokosc_rzeki = 527;

//pobieranie poziomów alarmowych i ostrzegawczych
$stan_ost =0;
$stan_ala =0;

$result = mysqli_query($connect,"SELECT * FROM `ppwr` WHERE `id_ppwr`='{$prze}' LIMIT 0 , 1");
while($wiersz= mysqli_fetch_array ($result)){
$stan_ost = $wiersz['p_ostrzegawczy'];
$stan_ala = $wiersz['p_alarmowy'];
}


//aktualny poziom wody
$wysokosc_rzeki = 0;
$d_0 = get_data_add_h(0);
$d_1 = get_data_add_h(-24);
$data_pom = "";

$result = mysqli_query($connect,"SELECT * FROM `pomiarypoziomow` WHERE `id_ppwr`='{$prze}' AND `czas` BETWEEN '{$d_1}' AND '{$d_0}' order by `czas` DESC  LIMIT 0 , 1");

while($wiersz= mysqli_fetch_array ($result)){
$wysokosc_rzeki = $wiersz['wartosc'];
$data_pom = $wiersz['czas'];
}

//delta w cm
$p0 = 0;
$p_1 = 0;

//czas
$t0 = "";
$t_1 = "";


$result = mysqli_query($connect,"SELECT * FROM `pomiarypoziomow` WHERE `id_ppwr`='{$prze}' AND `czas` BETWEEN '{$d_1}' AND '{$d_0}' order by `czas` DESC  LIMIT 0 , 1");
while($wiersz= mysqli_fetch_array ($result)){
$p0 = $wiersz['wartosc'];
$t0 = $wiersz['czas'];
$t0 = get_data($t0);
}

$result = mysqli_query($connect,"SELECT * FROM `pomiarypoziomow` WHERE `id_ppwr`='{$prze}' AND `czas` BETWEEN '{$d_1}' AND '{$d_0}' order by `czas` DESC  LIMIT 1 , 1");
while($wiersz= mysqli_fetch_array ($result)){
$p_1 = $wiersz['wartosc'];
$t_1 = $wiersz['czas'];
$t_1 = get_data($t_1);
}


$delta_czas = $t0 - $t_1;

$delta_czas = 3600/$delta_czas;

$delta_a = $p0 - $p_1;

//***poczatek 2008.10.16
//by³o $delta_a = $delta_a*$delta_czas;
if(($tmp_delta_p == 1) AND ($tmp_delta_h == 0))
{
$delta_a = $delta_a;
}
if(($tmp_delta_p == 0) AND ($tmp_delta_h == 1))
{
$delta_a = $delta_a*$delta_czas;
}
//***koniec 2008.10.16

$wys = $skala*($wysokosc_rzeki/10);

$minimum_wody = 0;

for($i=0; $i<count($punkty_przekroju_1); $i++)
{
//$punkty_przekroju[$i] = $punkty_przekroju[$i]*$skala;
$k = $i;
if($k%2)
{

if(($punkty_przekroju_1[$i]>$minimum_wody)&&($punkty_przekroju_1[$i]<150))
{
$minimum_wody = $punkty_przekroju_1[$i];
}

}
}

$minimum_wody = ($wysokosc - ($minimum_wody*$skala)) + 5;

if($wys<$minimum_wody)
{
$wys = $minimum_wody;
}

if($skala==1)
{
$margines = $szerokosc*0.09;
}
if($skala>1)
{
$margines = 30;
}



$przesuniecie_x = $szerokosc*$parm_prze_x;


$punkty_tla = array(
            0,  0,
            $szerokosc,  0,
            $szerokosc,  $wysokosc,
            0,$wysokosc
            );
			
$punkty_marg_l = array(
            0,  0,
            $margines,  0,
            $margines,  $wysokosc,
            0,$wysokosc
            );
			
$punkty_marg_p = array(
            $szerokosc-$margines,  0,
			$szerokosc,  0,
			$szerokosc,  $wysokosc,
			$szerokosc-$margines, $wysokosc
            );
			
$punkty_wody = array(
            0,  0,
            $szerokosc,  0,
            $szerokosc,  $wysokosc - $wys,
            0, $wysokosc - $wys
            );



			
//skalowanie i przesuniecie tablicy
$punkty_przekroju = $punkty_przekroju_1;

for($i=0; $i<count($punkty_przekroju); $i++)
{
$punkty_przekroju[$i] = $punkty_przekroju[$i]*$skala;
$k = $i + 1;
if($k%2)
{
$punkty_przekroju[$i] = $punkty_przekroju[$i] + $przesuniecie_x;
}
}
$ilosc_poligonow = count($punkty_przekroju)/2;
			
// create image
$image = imagecreatetruecolor($szerokosc, $wysokosc);

// some colors
$bialy   = imagecolorallocate($image, 255, 255, 255);
$szary = imagecolorallocate($image, 182, 182, 160);
$czarny = imagecolorallocate($image, 0, 0, 0);
$niebieski = imagecolorallocate($image, 0, 0, 250);
$ciemnoszary = imagecolorallocate($image, 150, 150, 150);
$czerwony = imagecolorallocate($image, 255, 0, 0);
$pomarancz = imagecolorallocate($image, 255, 155, 15);

// rysuj t³o
imagefilledpolygon($image, $punkty_tla, 4, $niebieski);

//rysuj wode
imagefilledpolygon($image, $punkty_wody, 4, $bialy);


// rysuj przekruj
imagefilledpolygon($image, $punkty_przekroju, $ilosc_poligonow, $szary);

//rysuj linie - kontrast przekroju
for($i=0; $i<(count($punkty_przekroju)-6); $i=$i+2)
{
imageline($image,$punkty_przekroju[$i],$punkty_przekroju[$i+1],$punkty_przekroju[$i+2],$punkty_przekroju[$i+3],$czarny);
}

//rysuj marginesy
imagefilledpolygon($image, $punkty_marg_l, 4, $bialy);
imagefilledpolygon($image, $punkty_marg_p, 4, $bialy);


//rysuj linie - obramoiwanie
imageline($image,0,0,$szerokosc,0,$czarny);
imageline($image,$szerokosc-1,0,$szerokosc-1,$wysokosc,$czarny);
imageline($image,$szerokosc,$wysokosc-1,0,$wysokosc-1,$czarny);
imageline($image,0,$wysokosc,0,0,$czarny);

imageline($image,$margines,0,$margines,$wysokosc,$czarny);
imageline($image,$szerokosc-$margines,0,$szerokosc-$margines,$wysokosc,$czarny);

//linie pomocnicze - wysokosci i liczbowa wysokosc

$czcionka = 1;
if($skala>1)
{
$czcionka = 6;
}
for($i=0; $i<$wysokosc/$skala; $i=$i+10)
{
$k = $i*$skala;
//imageline($image,$margines,$wysokosc-$k,$szerokosc-$margines,$wysokosc-$k,$ciemnoszary);
imageline($image,$margines-5,$wysokosc-$k,$margines,$wysokosc-$k,$ciemnoszary);
imageline($image,$szerokosc-$margines,$wysokosc-$k,$szerokosc-$margines+5,$wysokosc-$k,$ciemnoszary);
if($i==0)
{
$txt = 0;
$txt2 = $npm;
}
if($i>0)
{
$txt = $i/10;
$txt2 = $npm+($i/10);
}
$prze_skali = $skala*4;
ImageString ($image,$czcionka,$margines/4,$wysokosc-$k-$prze_skali,$txt,$czarny);
ImageString ($image,$czcionka,$szerokosc-(0.9*$margines),$wysokosc-$k-$prze_skali,$txt2,$czarny);
}

//jednostka [m]
ImageString ($image,$czcionka,$margines/8,0,"[m]",$czarny);
ImageString ($image,$czcionka,$szerokosc-(0.9*$margines),0,"[m]",$czarny);


//stan ostrzegawcxzyt i stan alarmowy
imageline($image,$margines,$wysokosc-(($stan_ost/10)*$skala),$szerokosc-$margines,$wysokosc-(($stan_ost/10)*$skala),$pomarancz);
imageline($image,$margines,$wysokosc-(($stan_ala/10)*$skala),$szerokosc-$margines,$wysokosc-(($stan_ala/10)*$skala),$czerwony);

//nazwa punktu
ImageString ($image,$czcionka,$margines*1.2,$margines*(1/4),$nazwa,$czarny);

//wysokosc i delta
$h = "h = {$wysokosc_rzeki}cm, d = {$delta_a}cm";
ImageString ($image,$czcionka,$margines*1.2,$margines*(3/4),$h,$czarny);

//npm
$hnpm = ($npm*100)+$wysokosc_rzeki;
$hnpm = "npm = {$hnpm}cm";
$hnpmd = "{$data_pom}";
ImageString ($image,$czcionka,$margines*1.2,$margines*(5/4),$hnpm,$czarny);
ImageString ($image,$czcionka,$margines*1.2,$margines*(7/4),$hnpmd,$czarny);


// flush image
header('Content-type: image/png');
return imagepng($image);
imagedestroy($image);

?>