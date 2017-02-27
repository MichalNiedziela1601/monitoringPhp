<?php
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

?>