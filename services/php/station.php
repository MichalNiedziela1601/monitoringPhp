<?php
/**
 * Created by PhpStorm.
 * User: sunday
 * Date: 2/5/17
 * Time: 9:43 PM
 */
include 'config.php';

$action = $_GET['action'];

function obsadzona_nieobsadzona($nazwa_punktu,$typ)
{
    $connect = connect();

    if ($typ==1)
        $query=mysqli_query($connect,"SELECT `wizu`.id_ppwr from `wizu`,`sppwr`,`sppwr2` where `wizu`.id_ppwr=`sppwr`.miejsce_zamocowania AND `sppwr`.identyfikator=`sppwr2`.id_sppwr AND `sppwr2`.potwierdzenieObsadzenia=1;");
    else
        $query=mysqli_query($connect,"SELECT `wizu`.id_ppwr from `wizu`,`spoa`,`spoa2` where `wizu`.id_ppwr=`spoa`.miejsce_zamocowania AND `spoa`.identyfikator=`spoa2`.id_spoa AND `spoa2`.potwierdzenieObsadzenia=1;");
    $obsadzenie=0;
    while ($search_idppwr=mysqli_fetch_array($query))
    {
        $nazwa_idppwr=$search_idppwr['id_ppwr'];
        if($nazwa_punktu==$nazwa_idppwr)
            $obsadzenie=1;
    }
    return $obsadzenie;
}

if($action === 'getStations'){
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
    for ($i=0; $i < count($wizu); $i++){
        $wizu[$i]['obsadzona'] = obsadzona_nieobsadzona($wizu[$i]['id_ppwr'], $wizu[$i]['typ']);
    }

    $json = json_encode($wizu);
    print $json;
} elseif ($action === 'checkObsadzona'){
   /* $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $nazwa_punktu = $request->nazwa_punktu;
    $typ = $request->typ;
    function obsadzona_nieobsadzona($nazwa_punktu,$typ)
    {
        $connect = connect();

        if ($typ==1)
            $query=mysqli_query($connect,"SELECT `wizu`.id_ppwr from `wizu`,`sppwr`,`sppwr2` where `wizu`.id_ppwr=`sppwr`.miejsce_zamocowania AND `sppwr`.identyfikator=`sppwr2`.id_sppwr AND `sppwr2`.potwierdzenieObsadzenia=1;");
        else
            $query=mysqli_query($connect,"SELECT `wizu`.id_ppwr from `wizu`,`spoa`,`spoa2` where `wizu`.id_ppwr=`spoa`.miejsce_zamocowania AND `spoa`.identyfikator=`spoa2`.id_spoa AND `spoa2`.potwierdzenieObsadzenia=1;");
        $obsadzenie=0;
        while ($search_idppwr=mysqli_fetch_array($query))
        {
            $nazwa_idppwr=$search_idppwr['id_ppwr'];
            if($nazwa_punktu==$nazwa_idppwr)
                $obsadzenie=1;
        }
        return $obsadzenie;
    }

    print obsadzona_nieobsadzona($nazwa_punktu,$typ);*/
}




exit;

?>