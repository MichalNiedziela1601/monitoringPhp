<?php
date_default_timezone_set('Europe/Warsaw');
//zmienna okreslajaca ID przekroju - z tym parametrem tzreba wywoływac skrypt

$prze = $_GET['prze'];

//include("{$prze}.php");
include 'config.php';
$connect = connect();
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


$nazwa = get_miejsce($prze);

//pobieranie poziomów alarmowych i ostrzegawczych
$stan_ost =0;
$stan_ala =0;

$result = mysqli_query($connect,"SELECT * FROM `ppoa` WHERE `id_ppoa`='{$prze}' LIMIT 0 , 1");
while($wiersz=mysqli_fetch_array ($result)){
$stan_ost = $wiersz['p_ostrzegawczy'];
$stan_ala = $wiersz['p_alarmowy'];
}

$nazwa = get_miejsce($prze);

//aktualny poziom opadu
$opad = 0;
$d_0 = get_data_add_h(0);
$d_1 = get_data_add_h(-24);
$data_pom = "";

$result = mysqli_query($connect,"SELECT * FROM `pomiaryopadow` WHERE `id_ppoa`='{$prze}' AND `czas` BETWEEN '{$d_1}' AND '{$d_0}' order by `czas` DESC  LIMIT 0 , 1");
while($wiersz=mysqli_fetch_array ($result)){
$wysokosc_opadu = $wiersz['wartosc'];
$data_pom = $wiersz['czas'];
$przedzial=$wiersz['przedzial'];
}

$opad=60.0*($wysokosc_opadu/$przedzial);

$szerokosc=200;
$wysokosc=300;

$punkty_tla = array(
            0,  0,
            $szerokosc,0,
            $szerokosc,  $wysokosc,
            0,$wysokosc
            );

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

// rysuj tło
imagefilledpolygon($image, $punkty_tla, 4, $bialy);

//rysuj linie - obramoiwanie
imageline($image,0,0,$szerokosc,0,$czarny);
imageline($image,$szerokosc-1,0,$szerokosc-1,$wysokosc,$czarny);
imageline($image,$szerokosc,$wysokosc-1,0,$wysokosc-1,$czarny);
imageline($image,0,$wysokosc,0,0,$czarny);

// rysuj wskaznik
imageline($image,85,90,135,90,$czarny);
imageline($image,85,290,135,290,$czarny);
imageline($image,85,90,85,290,$czarny);
imageline($image,135,90,135,290,$czarny);

if ($opad>0) {
$wys_slupka=290-($opad*2.5<1?1:$opad*2.5);
$wys_slupka=($wys_slupka<90?90:$wys_slupka);
imagefilledrectangle($image,86,$wys_slupka,134,289,$niebieski);
}

// rysuj skale
for ($i=0;$i<90;$i+=10) {
if ($i<80) {
imageline($image,85,290-$i*2.5,135,290-$i*2.5,$szary);
}
ImageString($image,2,50,282-$i*2.5,"{$i} mm",$czarny);
}

//stan ostrzegawcxzyt i stan alarmowy
imageline($image,86,290-$stan_ost*2.5,134,290-$stan_ost*2.5,$pomarancz);
imageline($image,86,290-$stan_ala*2.5,134,290-$stan_ala*2.5,$czerwony);

//nazwa punktu
ImageString ($image,6,10,10,$nazwa,$black);

//opad
$o = "Int. opadu = {$opad}mm/h";
ImageString ($image,6,10,25,$o,$black);
ImageString ($image,6,10,40,"{$data_pom}",$black);

// flush image
//header('Content-type: image/png');
//imagepng($image,null,9);
//imagedestroy($image);

$fileName = 'opad_int.png';
imagepng($image, $fileName);
imagedestroy($image);
$base64Image = base64_encode(file_get_contents($fileName));
echo $base64Image;
unlink($fileName);
?> 