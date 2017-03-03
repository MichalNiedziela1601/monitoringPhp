<?php
//ini_set('display_errors','1');
date_default_timezone_set('Europe/Warsaw');
//zmienna okreslajaca ID przekroju - z tym parametrem tzreba wywo�ywac skrypt

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

//include("{$prze}.php");
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

//pobieranie poziom�w alarmowych i ostrzegawczych
$stan_ost =0;
$stan_ala =0;

$result = mysqli_query($connect,"SELECT * FROM `ppoa` WHERE `id_ppoa`='{$prze}' LIMIT 0 , 1");
while($wiersz=mysqli_fetch_array ($result)){
$stan_ost = $wiersz['p_ostrzegawczy'];
$stan_ala = $wiersz['p_alarmowy'];
}

//pobierz pomiary z ostatniuch 22h - rysuj linie 

$d_0 = get_data_db($czas_aktu);
$d_1 = get_data_db_add_h($czas_aktu,-2);

//$pomiary_h_t[];

$result = mysqli_query($connect,"SELECT * FROM `pomiaryopadow` WHERE `id_ppoa`='{$prze}' AND `czas` BETWEEN '{$d_1}' AND '{$d_0}' order by `czas` DESC");
while($wiersz=mysqli_fetch_array ($result)){
$pomiary_h_t[] = $wiersz['wartosc'];
$maxopad=($wiersz['wartosc']>$maxopad?$wiersz['wartosc']:$maxopad);
$data_pom = $wiersz['czas'];
$pomiary_h_t[] = get_data($data_pom);
$pomiary_h_t[]=$wiersz['przedzial'];
}

/*
$rysuj=0;
$il_tab_pun = count($pomiary_h_t);
for($i=0; $i<$il_tab_pun; $i = $i+3) {
	$nat=($pomiary_h_t[$i+2]>0?60.0*$pomiary_h_t[$i]/$pomiary_h_t[$i+2]:0.5);
	if ($nat>$stan_ost) {
		$rysuj=1;
		break;
	}
}
*/
$rysuj=1;

if ($rysuj==1) {
	$naglowek = "Opad, ostatnie 2h, lokalizacja - {$nazwa}";

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
				1000,  180,
				920,180
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

	/*
	// rysuj t�o prognozy
	imagefilledpolygon($image, $punkty_tla_prognozy, 4, $prognoza);

	// rysuj t�o napisu prognoza
	imagefilledpolygon($image, $punkty_tla_prognozy2, 4, $prognoza2);


	//napis prognoza
	ImageString($image,3,930,10,"Prognoza",$czerwony);
	*/


	//rysuj osie
	imageline($image,40,$wys_w_h,40,0,$czarny);


	imageline($image,0,180,$szer_w_h,180,$czarny);

	$d_i=$czas_aktu-7200;
	//podzia�ki na lini czasu
	for($i=1; $i<24; $i++)
	{
	$d_i+=300;


	$txt_d = date("H:i",$d_i);
	//$txt_npm = $i+$npm;

	//$txt = "{$txt_h}/{$txt_npm}";
	imageline($image,40+($i*40),$wys_w_h-15,40+($i*40),$wys_w_h-25,$czarny);
	ImageString($image,2,27+($i*40),$wys_w_h-12,$txt_d,$black);
	}
	
if ($maxopad<1)
	$skala_y=144;
else if ($maxopad>80)
	$skala_y=1.8;
else
	$skala_y=($wys_w_h-20)/(1.25*$maxopad);

$podz_max=170/$skala_y;
if ($maxopad<=1) {
	$podz_krok=0.1;
} else if ($maxopad<=2) {
	$podz_krok=0.2;
} else if ($maxopad<=5) {
	$podz_krok=0.5;
} else if ($maxopad<=10) {
	$podz_krok=1;
} else if ($maxopad<=20)  {
	$podz_krok=2;
} else if ($maxopad<=50) {
	$podz_krok=5;
} else {
	$podz_krok=10;
}

//podzia�ki na lini wysokosci
for($i=$podz_krok; $i<=$podz_max; $i+=$podz_krok)
{
$txt_h = " ".$i."mm";

//$txt = "{$txt_h}/{$txt_npm}";
imageline($image,38,$wys_w_h-20-($i*$skala_y),42,$wys_w_h-20-($i*$skala_y),$czarny);
ImageString($image,2,0,$wys_w_h-28-($i*$skala_y),$txt_h,$czarny);
}

	/*
	//stan ostrzegawcxzyt i stan alarmowy
	imageline($image,40,$wys_w_h-20-(($stan_ost*200)/100),$szer_w_h,$wys_w_h-20-(($stan_ost*200)/100),$pomarancz);
	imageline($image,40,$wys_w_h-20-(($stan_ala*200)/100),$szer_w_h,$wys_w_h-20-(($stan_ala*200)/100),$czerwony);
	*/

	//dodac do tablicy prognozy - albo i nie
	$il_tab_pun = count($pomiary_h_t);
	for($i=0; $i<$il_tab_pun; $i = $i+3)
	{
	//if(($pomiary_h_t[$i]>0)&&($pomiary_h_t[$i+1]>0))
	$rys_h_1 = $pomiary_h_t[$i];
	$rys_t_1 = $pomiary_h_t[$i+1];
	$rys_t_1 = $czas_aktu-$rys_t_1;

	$rys_h_2 = $rys_h_1;
	$rys_t_2 = $rys_t_1 + ($pomiary_h_t[$i+2]>0?$pomiary_h_t[$i+2]*60:30);

	imageline($image,1000-(($rys_t_1/300)*40),$wys_w_h-20-($rys_h_1*$skala_y),1000-(($rys_t_2/300)*40),$wys_w_h-20-($rys_h_2*$skala_y),$czarny);
	if ($i+3<$il_tab_pun) {
		$rys_h_3=$pomiary_h_t[$i+3];
		$rys_t_3=$rys_t_2; //$czas_aktu-$pomiary_h_t[$i+4];
	} else {
		$rys_h_3=0;
		$rys_t_3=$rys_t_2;
	}
	imageline($image,1000-(($rys_t_2/300)*40),$wys_w_h-20-($rys_h_2*$skala_y),1000-(($rys_t_3/300)*40),$wys_w_h-20-($rys_h_3*$skala_y),$szary);
	}

	/*

	//pobierz prognozy na najbli�sze 2h 

	$dp_0 = get_data_db($czas_aktu);
	$dp_1 = get_data_add_h2($czas_aktu);

	//$pomiary_h_t[];

	$result = mysqli_query($connect,"SELECT * FROM `pomiarypoziomowprognozy` WHERE `id_ppwr`='{$prze}' AND `czas` BETWEEN '{$dp_0}' AND '{$dp_1}' order by `czas` ASC");
	while($wiersz=mysqli_fetch_array ($result)){
	$pomiaryp_h_t[] = $wiersz['wartosc'];
	$datap_pom = $wiersz['czas'];
	$pomiaryp_h_t[] = get_data($datap_pom);
	}


	if (($pomiaryp_h_t[0]>0) &&($pomiaryp_h_t[1]>0))
	{

	 $rysp_h_1 = $pomiaryp_h_t[0];

	 $rysp_t_1 = $pomiaryp_h_t[1];

	 $rysp_t_1 = $czas_aktu-$rysp_t_1;

	 $rysp_h_2 = $pomiary_h_t[0];

	 $rysp_t_2 = $pomiary_h_t[1];

	 $rysp_t_2 = $czas_aktu-$rysp_t_2;

	 imageline($image,920-(($rysp_t_1/3600)*40),$wys_w_h-20-(($rysp_h_1*12)/100),920-(($rysp_t_2/3600)*40),$wys_w_h-20-(($rysp_h_2*12)/100),$czarny);
	}

	*/


	/*
	//$czas_aktu = mktime();
	$czas_pocz = get_data_km_add_h2($czas_aktu);

	//dodac do tablicy prognozy - albo i nie
	$il_tab_punp = count($pomiaryp_h_t);
	for($i=0; $i<$il_tab_punp; $i = $i+2)
	{
	if(($pomiaryp_h_t[$i]>0)&&($pomiaryp_h_t[$i+1]>0)&&($pomiaryp_h_t[$i+2]>0)&&($pomiaryp_h_t[$i+3]>0))
	{
	$rysp_h_1 = $pomiaryp_h_t[$i];
	$rysp_t_1 = $pomiaryp_h_t[$i+1];
	$rysp_t_1 = $czas_pocz-$rysp_t_1;

	$rysp_h_2 = $pomiaryp_h_t[$i+2];
	$rysp_t_2 = $pomiaryp_h_t[$i+3];
	$rysp_t_2 = $czas_pocz-$rysp_t_2;

	imageline($image,1000-(($rysp_t_1/3600)*40),$wys_w_h-20-(($rysp_h_1*12)/100),1000-(($rysp_t_2/3600)*40),$wys_w_h-20-(($rysp_h_2*12)/100),$czarny);
	}
	}

	*/
	// flush image
//	header('Content-type: image/png');
//	imagepng($image,null,9);
//	imagedestroy($image);
	$fileName = 'wykres_o2h.png';
	imagepng($image, $fileName);
	imagedestroy($image);
	$base64Image = base64_encode(file_get_contents($fileName));
	echo $base64Image;
	unlink($fileName);
	exit;
} else {
	// create image
	$image = imagecreatetruecolor(1,1);
	// flush image
	header('Content-type: image/png');
	imagepng($image,null,9);
	imagedestroy($image);
}
?> 