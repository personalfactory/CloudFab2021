<?php

/**
 * Prende come argomento il mese in numero e lo restituisce in lettere
 * @param type $numMese
 * @param type $arrayFiltroMese (array contenente i nomi dei mesi)
 * @return type
 */
function trasformaMeseInLettere($numMese,$arrayFiltroMese){
    
     switch ($numMese) {
        case "01":
            $mese = $arrayFiltroMese[0];
            break;
        case "02":
            $mese = $arrayFiltroMese[1];
            break;
        case "03":
            $mese = $arrayFiltroMese[2];
            break;
        case "04":
            $mese = $arrayFiltroMese[3];
            break;
        case "05":
            $mese = $arrayFiltroMese[4];
            break;
        case "06":
            $mese = $arrayFiltroMese[5];
            break;
        case "07":
            $mese = $arrayFiltroMese[6];
            break;
        case "08":
            $mese = $arrayFiltroMese[7];
            break;
        case "09":
            $mese = $arrayFiltroMese[8];
            break;
        case "10":
            $mese = $arrayFiltroMese[9];
            break;
        case "11":
            $mese = $arrayFiltroMese[10];
            break;
        case "12":
            $mese = $arrayFiltroMese[11];
            break;

        default:
            break;
    }
    
    return $mese;
    
}

/**
 * Visualizza un form per l'inserimento di una data
 * @param type $nomeVarGiorno
 * @param type $nomeVarMese
 * @param type $nomeVarAnno
 * @param type $arrayFiltroMese
 */
function formSceltaData($nomeVarGiorno,$nomeVarMese,$nomeVarAnno,$arrayFiltroMese) {
    ?>  
    <input type="text" name="<?php echo $nomeVarGiorno ?>" id="<?php echo $nomeVarGiorno ?>" size="2px"/>
    <select name="<?php echo $nomeVarMese ?>" id="<?php echo $nomeVarMese ?>" >
        <option value="01"><?php echo $arrayFiltroMese[0] ?></option>
        <option value="02"><?php echo $arrayFiltroMese[1] ?></option>
        <option value="03"><?php echo $arrayFiltroMese[2] ?></option>
        <option value="04"><?php echo $arrayFiltroMese[3] ?></option>
        <option value="05"><?php echo $arrayFiltroMese[4] ?></option>
        <option value="06"><?php echo $arrayFiltroMese[5] ?></option>
        <option value="07"><?php echo $arrayFiltroMese[6] ?></option>
        <option value="08"><?php echo $arrayFiltroMese[7] ?></option>
        <option value="09"><?php echo $arrayFiltroMese[8] ?></option>
        <option value="10"><?php echo $arrayFiltroMese[9] ?></option>
        <option value="11"><?php echo $arrayFiltroMese[10] ?></option>
        <option value="12"><?php echo $arrayFiltroMese[11] ?></option>
    </select>
    <input type="text" name="<?php echo $nomeVarAnno ?>" id="<?php echo $nomeVarAnno ?>" size="4px"/>
<?php
}

/**
 * Visualizza un form per la modifica una data
 * @param type $nomeVarGiorno: nome dell'input text
 * @param type $nomeVarMese: nome dell'input text
 * @param type $nomeVarAnno: nome dell'input text
 * @param type $arrayFiltroMese: nomi dei mesi nella lingua scelta
 * @param type $valGiorno: valore del giorno letto dal db
 * @param type $numMese: numero del mese letto dal db
 * @param type $valMese: nome del mese
 * @param type $valAnno: anno letto dal db
 */
 
function formModificaSceltaData($nomeVarGiorno,$nomeVarMese,$nomeVarAnno,$arrayFiltroMese,$valGiorno,$numMese,$valMese,$valAnno) {
    ?>  
    <input type="text" name="<?php echo $nomeVarGiorno ?>" id="<?php echo $nomeVarGiorno ?>" value="<?php echo $valGiorno ?>" size="2px"/>
    <select name="<?php echo $nomeVarMese ?>" id="<?php echo $nomeVarMese ?>" >
        <option value="<?php echo $numMese?>"><?php echo $valMese ?></option>
        <option value="01"><?php echo $arrayFiltroMese[0] ?></option>
        <option value="02"><?php echo $arrayFiltroMese[1] ?></option>
        <option value="03"><?php echo $arrayFiltroMese[2] ?></option>
        <option value="04"><?php echo $arrayFiltroMese[3] ?></option>
        <option value="05"><?php echo $arrayFiltroMese[4] ?></option>
        <option value="06"><?php echo $arrayFiltroMese[5] ?></option>
        <option value="07"><?php echo $arrayFiltroMese[6] ?></option>
        <option value="08"><?php echo $arrayFiltroMese[7] ?></option>
        <option value="09"><?php echo $arrayFiltroMese[8] ?></option>
        <option value="10"><?php echo $arrayFiltroMese[9] ?></option>
        <option value="11"><?php echo $arrayFiltroMese[10] ?></option>
        <option value="12"><?php echo $arrayFiltroMese[11] ?></option>
    </select>
    <input type="text" name="<?php echo $nomeVarAnno ?>" id="<?php echo $nomeVarAnno ?>" value="<?php echo $valAnno ?>" size="4px"/>
<?php
}

/**
 * Calcola la data corrente e la formatta per inserirla nel db: AAAA MM GG hh mm ss
 * Funziona anche se il campo di destinazione è date anzicchè timestamp 
 * @return string
 */
//function dataCorrenteInserimento() {
//    $now = getdate();
//    $anno = $now["year"];
//    $mese = $now["mon"];
//    if ($mese < 10) {
//        $mese = "0" . $mese;
//    }
//    $giorno = $now["mday"];
//    if ($giorno < 10) {
//        $giorno = "0" . $giorno;
//    }
//    $ora = $now["hours"];
//    $minuti = $now["minutes"];
//    $secondi = $now["seconds"];
//
////  '2011-04-29 00:00:00'
//    $datacorr = $anno . "-" . $mese . "-" . $giorno . " " . $ora . ":" . $minuti . ":" . $secondi;
//    return $datacorr;
//}


/**
 * Calcola la data corrente e la formatta per inserirla nel db: AAAA-MM-GG hh:mm:ss
 * Funziona anche se il campo di destinazione è date anzicchè timestamp 
 * @return string
 */
function dataCorrenteInserimento() {
    $now = getdate();
    $anno = $now["year"];
    $mese = $now["mon"];
    if ($mese < 10) {
        $mese = "0" . $mese;
    }
    $giorno = $now["mday"];
    if ($giorno < 10) {
        $giorno = "0" . $giorno;
    }
    $ora = $now["hours"];
    if ($ora < 10) {
        $ora = "0" . $ora;
    }
    $minuti = $now["minutes"];
    if ($minuti < 10) {
        $minuti = "0" . $minuti;
    }
    $secondi = $now["seconds"];
    if ($secondi < 10) {
        $secondi = "0" . $secondi;
    }
//  '2011-04-29 00:00:00'
    $datacorr = $anno . "-" . $mese . "-" . $giorno . " " . $ora . ":" . $minuti . ":" . $secondi;
    return $datacorr;
}


/**
 * Calcola la data corrente e la formatta per inserirla nel nome di un file: AAAAMMGG_hh:mm:ss
 * Funziona anche se il campo di destinazione è date anzicchè timestamp 
 * @return string
 */
function dataCorrenteFile() {
    $now = getdate();
    $anno = $now["year"];
    $mese = $now["mon"];
    if ($mese < 10) {
        $mese = "0" . $mese;
    }
    $giorno = $now["mday"];
    if ($giorno < 10) {
        $giorno = "0" . $giorno;
    }
    $ora = $now["hours"];
    if ($ora < 10) {
        $ora = "0" . $ora;
    }
    $minuti = $now["minutes"];
    if ($minuti < 10) {
        $minuti = "0" . $minuti;
    }
    $secondi = $now["seconds"];
    if ($secondi < 10) {
        $secondi = "0" . $secondi;
    }

//    $datacorr = $anno ."-".$mese."-".$giorno . "_" . $ora . ":" . $minuti . ":" . $secondi;
    $datacorr = $anno.$mese.$giorno .$ora . $minuti . $secondi;
    return $datacorr;
}





/**
 * Calcola la data corrente e la formatta per visualizzarla nelle pagine: GG-MM-AAAA
 * @return string
 */
function dataCorrenteVisualizza() {
    $now = getdate();
    $anno = $now["year"];
    $mese = $now["mon"];
    if ($mese < 10) {
        $mese = "0" . $mese;
    }
    //Trasformo il mese in caratteri
    switch ($mese) {
        case "01":
            $mese = "Gen";
            break;
        case "02":
            $mese = "Feb";
            break;
        case "03":
            $mese = "Mar";
            break;
        case "04":
            $mese = "Apr";
            break;
        case "05":
            $mese = "Mag";
            break;
        case "06":
            $mese = "Giu";
            break;
        case "07":
            $mese = "Lug";
            break;
        case "08":
            $mese = "Ago";
            break;
        case "09":
            $mese = "Set";
            break;
        case "10":
            $mese = "Ott";
            break;
        case "11":
            $mese = "Nov";
            break;
        case "12":
            $mese = "Dic";
            break;

        default:
            break;
    }
    $giorno = $now["mday"];
    if ($giorno < 10) {
        $giorno = "0" . $giorno;
    }
    $ora = $now["hours"];
    if ($ora < 10) {
        $ora = "0" . $ora;
    }
    $minuti = $now["minutes"];
    if ($minuti < 10) {
        $minuti = "0" . $minuti;
    }
    $secondi = $now["seconds"];
    if ($secondi < 10) {
        $secondi = "0" . $secondi;
    }

    $datacorr = $giorno . " " . $mese . " " . $anno . " " . $ora . ":" . $minuti . ":" . $secondi;
    return $datacorr;
}


/**
 * Formatto la data (Dal formato yyyy-MM-dd hh:mm:ss) 
 * per visualizzarla nelle pagine: GG-MM-AAAA
 * @param type $Dt
 * @return string
 */
function dataEstraiVisualizza($Dt) {
    $Data = "";
    $giorno = "";
    $mese = "";
    $giono_num = "";
    $mese_num = "";
    $anno = "";
    $ora = "";

    if (strlen($Dt) == 10) {

        $giorno_num = substr($Dt, 8);
        $mese_num = substr($Dt, 5, -3);
        $anno = substr($Dt, 0, -6);
    } else {

        $giorno_num = substr($Dt, 8, -9);
        $mese_num = substr($Dt, 5, -12);
        $anno = substr($Dt, 0, -15);
        $ora = substr($Dt, 11);
    }

    if (substr($giorno_num, 0, 1) == "0") {
        $giorno = substr($giorno_num, 1, 2);
    } else {
        $giorno = $giorno_num;
    }

//Trasformo il mese in caratteri
    switch ($mese_num) {
        case "01":
            $mese = "Gen";
            break;
        case "02":
            $mese = "Feb";
            break;
        case "03":
            $mese = "Mar";
            break;
        case "04":
            $mese = "Apr";
            break;
        case "05":
            $mese = "Mag";
            break;
        case "06":
            $mese = "Giu";
            break;
        case "07":
            $mese = "Lug";
            break;
        case "08":
            $mese = "Ago";
            break;
        case "09":
            $mese = "Set";
            break;
        case "10":
            $mese = "Ott";
            break;
        case "11":
            $mese = "Nov";
            break;
        case "12":
            $mese = "Dic";
            break;

        default:
            break;
    }

    $Data = $giorno . " " . $mese . " " . $anno . "  " . $ora;
    return $Data;
}


/**
 * Formatto la data (prese dal db) per inserirla nuovamente: GG-MM-AAAA
 * @param type $Dt
 * @return string
 */
function dataInserimento($Dt) {

    $Data = substr($Dt, 8) . "-" . substr($Dt, 5, -3) . "-" . substr($Dt, 0, -6);
    return $Data;
}

function OraAttuale() {
    $hours = date("H", time());
    $mins = date("i", time());
    $secs = date("s", time());
    $Ora = $hours . ":" . $mins . ":" . $secs;
    return $Ora;
}

//Cronometro
function avviaCronometro() {

    //$mtime = time();
    //$mtime = explode(' ', $mtime);
    //$mtime = $mtime[1] + $mtime[0];
    $starttime = time();
}

function fermaCronometro($starttime) {

    //$mtime = time();
    //$mtime = explode(" ", $mtime);
    //$mtime = $mtime[1] + $mtime[0];
    $endtime = time();
    $totaltime = ($endtime - $starttime);
    //echo 'Inizio ' .$starttime. ' seconds.';
    //echo 'Fine ' .$endtime. ' seconds.';
    //echo 'L\'esperimento � durato ' .$totaltime. ' seconds.';
}



/**
 * Restituisce la differenza fra due date in secondi
 * @param type $dt1
 * @param type $dt2
 * @return type
 */
function data_diff($dt1, $dt2) {
    $y1 = substr($dt1, 0, 4);
    $m1 = substr($dt1, 5, 2);
    $d1 = substr($dt1, 8, 2);
    $h1 = substr($dt1, 11, 2);
    $i1 = substr($dt1, 14, 2);
    $s1 = substr($dt1, 17, 2);

    $y2 = substr($dt2, 0, 4);
    $m2 = substr($dt2, 5, 2);
    $d2 = substr($dt2, 8, 2);
    $h2 = substr($dt2, 11, 2);
    $i2 = substr($dt2, 14, 2);
    $s2 = substr($dt2, 17, 2);

    $r1 = date('U', mktime($h1, $i1, $s1, $m1, $d1, $y1));
    $r2 = date('U', mktime($h2, $i2, $s2, $m2, $d2, $y2));

    return ($r2 - $r1);
}

/**
 * Prende come argomento una data del tipo yyyy-mm-dd 
 * e la formatta hhhhmmdd eliminando i trattini
 * @param type $data
 * @return string
 */
function eliminaTrattini($data){
    $dt="";
    $dt=substr($data, 0, -6).substr($data, 5, -3).substr($data, 8, 2);
    return $dt;
}


/**
 * Prende come argomento una data del tipo yyyymmdd
 * e la formatta yyyy-mm-dd  eliminando i trattini
 * @param type $data
 * @return string
 */
function inserisciTrattini($data){
    $dt="";
    $dt=substr($data, 0, -4)."-".substr($data, 4, -2)."-".substr($data, 6, 2);
    return $dt;
}

function timestampToString($data){
    $dt="";
    $y1 = substr($data, 0, 4);
    $m1 = substr($data, 5, 2);
    $d1 = substr($data, 8, 2);
    $h1 = substr($data, 11, 2);
    $i1 = substr($data, 14, 2);
    $s1 = substr($data, 17, 2);
    $dt=$y1.$m1.$d1.$h1.$i1.$s1;
    return $dt;
}




/**
 * Calcola la data corrente e la formatta per inserirla nel nome di un file: AAAA-MM-GG_hh:mm:ss
 * Funziona anche se il campo di destinazione è date anzicchè timestamp 
 * @return string
 */
function dataCorrenteFileExcel() {
    $now = getdate();
    $anno = $now["year"];
    $mese = $now["mon"];
    
    if ($mese < 10) {
        $mese = "0" . $mese;
    }
    $giorno = $now["mday"];
    if ($giorno < 10) {
        $giorno = "0" . $giorno;
    }
    $ora = $now["hours"];
    if ($ora < 10) {
        $ora = "0" . $ora;
    }
    $minuti = $now["minutes"];
    if ($minuti < 10) {
        $minuti = "0" . $minuti;
    }
    $secondi = $now["seconds"];
    if ($secondi < 10) {
        $secondi = "0" . $secondi;
    }

    $datacorr = $anno ."-".$mese."-".$giorno . "_" . $ora . ":" . $minuti . ":" . $secondi;
    //$datacorr = $anno."-".$mese."-".$giorno ."_".$ora .":". $minuti.":".$secondi;
    return $datacorr;
}



?>