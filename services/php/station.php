<?php
/**
 * Created by PhpStorm.
 * User: sunday
 * Date: 2/5/17
 * Time: 9:43 PM
 */
include 'config.php';


$connect = connect();
$wizu = array();
$sql = "SELECT * FROM wizu ORDER BY lp,typ ASC";
if ($result = mysqli_query($connect, $sql)) {
    $count = mysqli_num_rows($result);

    $cr = 0;
    while ($row = mysqli_fetch_array($result)) {
        $wizu[$cr]['id_ppwr'] = $row['id_ppwr'];
        $wizu[$cr]['skala'] = $row['skala'];
        $wizu[$cr]['npm'] = $row['npm'];
        $wizu[$cr]['par_prze_x'] = $row['par_prze_x'];
        $wizu[$cr]['szer'] = $row['szer'];
        $wizu[$cr]['wys'] = $row['wys'];
        $wizu[$cr]['punkty'] = $row['punkty'];
        $wizu[$cr]['miejsce'] = $row['miejsce'];
        $wizu[$cr]['lp'] = $row['lp'];
        $wizu[$cr]['typ'] = $row['typ'];


        $cr++;
    }
}


$cr = 0;
if ($query = mysqli_query($connect, "SELECT `wizu`.id_ppwr from `wizu`,`sppwr`,`sppwr2` where `wizu`.id_ppwr=`sppwr`.miejsce_zamocowania AND 
`sppwr`.identyfikator=`sppwr2`.id_sppwr AND `sppwr2`.potwierdzenieObsadzenia=1 ORDER BY `wizu`.lp, `wizu`.typ ASC;")
) {
    $count = mysqli_num_rows($query);
    while ($row = mysqli_fetch_array($query)) {
        if ($wizu[$cr]['id_ppwr'] = $row['id_ppwr']) {
            $wizu[$cr]['obsadzona'] = 1;
        }
        $cr++;
    }

}

if ($query = mysqli_query($connect, "SELECT `wizu`.id_ppwr from `wizu`,`spoa`,`spoa2` where `wizu`.id_ppwr=`spoa`.miejsce_zamocowania AND `spoa`.identyfikator=`spoa2`.id_spoa AND `spoa2`.potwierdzenieObsadzenia=1 ORDER BY `wizu`.lp, `wizu`.typ ASC;")) {
    $count = mysqli_num_rows($query);
    $cr++;
    while ($row = mysqli_fetch_array($query)) {
        if ($wizu[$cr]['id_ppwr'] = $row['id_ppwr']) {
            $wizu[$cr]['obsadzona'] = 1;
        }
        $cr++;
    }
}


echo json_encode($wizu);


exit;

?>