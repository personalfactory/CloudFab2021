<?php

/* $Pagina=$_POST['Pagina'];
  if($Pagina=="1"){
  $Redirect = "carica_formula.php";
  }else if($Pagina=="2"){
  $Redirect = "modifica_formula.php";
  } */

mysql_query("BEGIN");
//###################################################################
//################### MATERIE PRIME DI PRODUZIONE CHIMICA ###########
//###################################################################

//Aggiunge le materie prime presenti su gazie nella tab materia_prima
$sqlMaterie = mysql_query("SELECT 
                                    codice, 
                                    descri
                            FROM  
                                    gazie.gaz_001artico 
                            WHERE 
                                    catmer = 2 
                            AND 											
                                    descri IS NOT NULL 
                            AND 
                                    codice NOT IN 
                                        (SELECT cod_mat FROM serverdb.materia_prima) ")
        or die("ERRORE SELECT FROM gaz_001artico 1: " . mysql_error());

while ($rowMaterie = mysql_fetch_array($sqlMaterie)) {

    $insertMatPrima = mysql_query("INSERT INTO serverdb.materia_prima 
                                            (cod_mat,
                                            descri_mat)
                                            VALUES ( 
                                            '" . $rowMaterie['codice'] . "',
                                            '" . $rowMaterie['descri'] . "' )")
            or die("ERRORE INSERT INTO materia_prima : " . mysql_error());
}

//Aggiorna le descrizioni delle materie prime nella tabella materia_prima di serverdb 
//a partire da gazie
$sqlMaterieUp = mysql_query("SELECT 
                                codice, 
                                descri,
                                preacq
                        FROM  
                                gazie.gaz_001artico 
                        WHERE 
                                catmer = 2 
                        AND 											
                                descri IS NOT NULL")
        or die("ERRORE SELECT FROM gaz_001artico 2: " . mysql_error());

while ($rowMaterieUp = mysql_fetch_array($sqlMaterieUp)) {

    $updateMatPrima = mysql_query("UPDATE serverdb.materia_prima 																		                              SET 	
                        descri_mat='" . $rowMaterieUp['descri'] . "'
                    WHERE 
                        cod_mat='" . $rowMaterieUp['codice'] . "'")
            or die("ERRORE UPDATE serverdb.materia_prima : " . mysql_error());
}

//################################################################################
//###################### MATERIE PRIME DI LABORATORIO ############################
//################################################################################

//Aggiorna i campi prezzo e descri_materia della tabella lab_materie_prime  di serverdb 
//a partire da gazie , ma solo le materie prime gia presenti in tabella senza aggiungerne altre, 
//quest'ultime vengono caricate manualmente dall'utente laboratorio
$sqlMaterieLab = mysql_query("SELECT 
                                        codice, 
                                        descri,
                                        preacq,
                                        unimis
                                FROM  
                                        gazie.gaz_001artico 
                                WHERE 
                                        catmer = 2 
                                AND 											
                                        descri IS NOT NULL")
        or die("ERRORE SELECT FROM gaz_001artico 3 : " . mysql_error());

while ($rowMaterieLab = mysql_fetch_array($sqlMaterieLab)) {
    //Calcolo il prezzo in grammi da inserire nella tabelle delle materie prime di laboratorio
    $PrezzoGrammi = 0;

    if ($rowMaterieLab['unimis'] == "q") {
        $PrezzoGrammi = $rowMaterieLab['preacq'] / 100000;
    }
    if ($rowMaterieLab['unimis'] == "kg") {
        $PrezzoGrammi = $rowMaterieLab['preacq'] / 1000;
    }


    $updateLabMatPrima = mysql_query("UPDATE serverdb.lab_materie_prime 																		                              SET 	
                                        descri_materia='" . $rowMaterieLab['descri'] . "',
                                        prezzo='" . $rowMaterieLab['preacq'] . "',
                                        unita_misura='" . $rowMaterieLab['unimis'] . "',
                                        prezzo_grammo='" . $PrezzoGrammi . "'
                                    WHERE 
                                        cod_mat='" . $rowMaterieLab['codice'] . "'")
            or die("ERRORE UPDATE serverdb.lab_materie_prime : " . mysql_error());
}
mysql_query("COMMIT");
//header('Location:'.$Redirect);
?>