<?php

include('../Connessioni/serverdb.php');
include('../sql/script.php');
include('../sql/script_macchina.php');
include('../include/funzioni.php');


$sqlMac = findAllMacchine('id_macchina');
while ($row = mysql_fetch_array($sqlMac)) {
    $IdMacchina = $row['id_macchina'];
    $descriMacchina = $row['descri_stab'];


    $sqlGrupGeo = selectMacchina($IdMacchina);
    while ($row = mysql_fetch_array($sqlGrupGeo)) {
        $Geografico = $row['geografico'];
        $Gruppo = $row['gruppo'];
    }
    
    echo "<br /></br>######################################################################";    
    echo "</br>MACCHINA " . $filtroMacchina . ": " . $IdMacchina." ".$descriMacchina;
    echo "</br>Rif geografico : " . $Geografico;
    echo "</br>Gruppo : " . $Gruppo . "</br>";

//##############################################################
//### SELEZIONE DEI PRODOTTI PER GRUPPO E RIFERIMENTO GEO ######
//##############################################################

    $arrayProdPerMac = trovaProdottiAssegnatiAMacchina($IdMacchina);


    if (count($arrayProdPerMac) > 0) {
        echo "<br />n ".count($arrayProdPerMac)." - PRODOTTI ASSEGNATI ALLA MACCHINA : <br />";
    }
    for ($i = 0; $i < count($arrayProdPerMac); $i++) {

        echo $arrayProdPerMac[$i] . " , ";
    }


//##############################################################
//### SELEZIONE DEI COMPONENTI PER GRUPPO E RIFERIMENTO GEO ####
//##############################################################



    $arrayCompPerMac = trovaComponentiAssegnatiAMacchina($IdMacchina);
    if (count($arrayCompPerMac) > 0) {

        echo "<br />n ".count($arrayCompPerMac)." - COMPONENTI ASSEGNATI ALLA MACCHINA :<br />";
    }
    for ($i = 0; $i < count($arrayCompPerMac); $i++) {

        echo $arrayCompPerMac[$i] . " , ";
    }
}