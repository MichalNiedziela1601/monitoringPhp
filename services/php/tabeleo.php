<?php

require_once 'funk.php';
require_once 'config.php';
$prze = $_GET['prze'];
$connect = connect();
if(!isset($_GET['dzien'])) {
    $czas_aktu = mktime();

}else {
    $miesiac=$_GET['miesiac'];
    $dzien=$_GET['dzien'];
    $rok=$_GET['rok'];
    $godzina=$_GET['godzina'];
    $minuta=$_GET['minuta'];

    $czas_aktu = mktime($godzina,$minuta,00,$miesiac,$dzien,$rok);
}
$d_0t = get_data_db($czas_aktu);
$d_0t = get_data_db($czas_aktu);
$d_1t = get_data_add_h_22($czas_aktu);

//$pomiary_h_t[];

//$p0 = 0;
//$p1 = 0;
//$t0 = 0;
//$t1 = 0;
//
////echo "<table width=\"300px\" border=\"1px\"><tr><td width=\"120px\">Data pomiaru<br />(gg.mm-dd.mm)</td><td width=\"60px\">Opad [mm]</td><td>Intensywność opadu [mm/h]</td></tr>";
//
//$k = 0;
$table = array();
$result = mysqli_query($connect,"SELECT * FROM `ppoa` WHERE id_ppoa='{$prze}'");
$wiersz=mysqli_fetch_array($result);
$p_ostr=$wiersz['p_ostrzegawczy'];
$p_alar=$wiersz['p_alarmowy'];
$table['p_ostr'] = $p_ostr;
$table['p_alar'] = $p_alar;

$wyniki = array();
$inc = 0;
$result = mysqli_query($connect,"SELECT * FROM `pomiaryopadow` WHERE `id_ppoa`='{$prze}' AND `czas` <= '{$d_0t}'  order by `czas` DESC LIMIT 10");
while($wiersz=mysqli_fetch_array ($result)) {
    $wyniki[$inc]['wartosc'] = $wiersz['wartosc'];
    $wyniki[$inc]['czas'] = get_data($wiersz['czas']) * 1000;
    $wyniki[$inc]['przedzial'] = $wiersz['przedzial'];
    $inc++;
}

$table['wyniki'] = $wyniki;
echo json_encode($table);
exit;
//$data_pom_d = get_data_tab($data_pom);
//
////echo $data_pom_d;
//
//$pomiary_t[$k][0] = $pomiar_h;
//$pomiary_t[$k][1] = $data_pom_d;
//$pomiary_t[$k][2] = $data_pom;
//$pomiary_t[$k][3] = $wiersz['przedzial'];
//$k++;
//}
///*
//for($i=0;$i<10;$i++)
//{
//$l = $i+1;
//
////***poczatek 2008.10.16
////bylo $dt = ($pomiary_t[$i][2] - $pomiary_t[$l][2])/3600;
////bylo $dp = $pomiary_t[$i][0] - $pomiary_t[$l][0];
////bylo $d = $dp/$dt;
////bylo $pomiary_t[$i][3] = $d;
//if(($tmp_delta_p == 0) AND ($tmp_delta_h == 1))
//{
//$dt = ($pomiary_t[$i][2] - $pomiary_t[$l][2])/3600;
//$dp = $pomiary_t[$i][0] - $pomiary_t[$l][0];
//$d = $dp/$dt;
//$pomiary_t[$i][3] = $d;
//}
//
//if(($tmp_delta_p == 1) AND ($tmp_delta_h == 0))
//{
////$dt = ($pomiary_t[$i][2] - $pomiary_t[$l][2])/3600;
//$dp = $pomiary_t[$i][0] - $pomiary_t[$l][0];
////$d = $dp/$dt;
//$d = $dp;
//$pomiary_t[$i][3] = $d;
//}
////***koniec 2008.10.16
//}
//*/
//for($i=0;$i<9;$i++)
//{
//$nat=60.0*$pomiary_t[$i][0]/($pomiary_t[$i][3]<1?0.5:$pomiary_t[$i][3]);
////$opis=$nat." O:".$p_ostr." A:".$p_alar;
//
//if ($nat>=$p_alar) {
//	$style=" style='background: #f00; color: #000; font-weight: bold;'";
//	$opis="Przekroczony stan alarmowy";
//} else if ($nat>=$p_ostr) {
//	$style=" style='background: #fa0; color: #000;'";
//	$opis="Przekroczony stan ostrzegawczy";
//} else {
//	$style="";
//	$opis="";
//}
//echo "<tr".$style." title=\"".$opis."\">";
//echo "<td><center>".$pomiary_t[$i][1]."</center></td><td><center>".$pomiary_t[$i][0]."</center></td><td><center>".$nat."</center></td></tr>";
//
//}
//
//echo "</table>";
?>