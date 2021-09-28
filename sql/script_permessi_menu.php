<?php

////////////////////////////////////////////////////////////////////////////////
////////////////////AREA GESTIONE VISUALIZZAZIONE MENU//////////////////////////
////////////////////////////////////////////////////////////////////////////////



//Metodo che recupera solo l'elenco dei moduli e delle voci generali ordinati in modo da averli
//sempre aggiornati da qui per eventuali modifiche di aggiunte di voci o moduli
function selectElencoGeneraleModuliVoci()
{
    mysql_query("USE dbutente".mysql_error());

    //Query che restituisce moduli e voci in ordine per moduli e per ordine di voce
    //quindi l'output avrà i moduli ordinati e per modulo uguale le voci nell'ordine corretto
    $elencoGenModuliVoci = "SELECT m.id_modulo, m.modulo, m.var_lingua_modulo, v.id_voce, v.voce, v.link_voce, v.var_lingua_voce
                                         FROM  modulo m, voce v
                                         WHERE v.id_modulo=m.id_modulo
                                         ORDER BY m.id_modulo, v.ordine";

    $sql = mysql_query($elencoGenModuliVoci)or die("ERROR IN script_permessi_menu.php - FUNCTION selectElencoGeneraleModuliVoci - ".$elencoGenModuliVoci." - ". mysql_error());

    return $sql;

}

//Metodo che recupera solo l'elenco delle sottovoci
//sempre aggiornati da qui per eventuali modifiche di aggiunte di voci o moduli
function selectElencoGeneraleSottovoci()
{
    mysql_query("USE dbutente".mysql_error());


    $elencoSottovoci = "SELECT m.id_modulo, m.modulo,m.var_lingua_modulo, v.id_voce, v.voce, v.link_voce, v.var_lingua_voce, sv.id_sotto_voce, sv.sotto_voce, sv.link_sotto_voce, sv.var_lingua_sotto_voce
                        FROM  modulo m, voce v, sotto_voce sv
                        WHERE v.id_modulo=m.id_modulo AND
                              sv.id_voce=v.id_voce
                        ORDER BY m.id_modulo, v.ordine, sv.ordine";

    $sql = mysql_query($elencoSottovoci)or die("ERROR IN script_permessi_menu.php - FUNCTION selectElencoGeneraleSottovoci - ".$elencoSottovoci." - ". mysql_error());

    return $sql;

}





//Metodo che recupera l'elenco ordinato delle voci e il modulo corrispondente che l'untente può visualizzare
//Restituisce nell'ordine dei moduli le voci ordinate anch'esse per come andranno visualizzate
function selectElencoModuloVoce($idUtente)
{
    mysql_query("USE dbutente".mysql_error());

    //Query che restituisce moduli e voci in ordine per moduli e per ordine di voce
    //quindi l'output avrà i moduli ordinati e per modulo uguale le voci nell'ordine corretto
    $elencoModuloVoceUtente = "SELECT m.id_modulo, m.modulo, m.var_lingua_modulo, v.id_voce, v.voce, v.link_voce, v.var_lingua_voce
                               FROM permesso_voce pv, modulo m, voce v
                               WHERE pv.id_voce=v.id_voce AND
                                     v.id_modulo=m.id_modulo AND
                                     pv.id_utente='".$idUtente."'
                               ORDER BY m.id_modulo, v.ordine";

    $sql = mysql_query($elencoModuloVoceUtente)or die("ERROR IN script_permessi_menu.php - FUNCTION selectElencoModuloVoce - ".$elencoModuloVoceUtente." - ". mysql_error());

    return $sql;
}


//Metodo che recupera le sottovoci visibili per l'utente inserito
//Recupera anche l'id ed il nome della voce in modo da poterlo collegare al posto esatto
//restituirà anche il link e tutto ordinato secondo la voce e secondo la sotovoce
function selectElencoSottoVoce($idUtente)
{
    mysql_query("USE dbutente".mysql_error());

    //Attenzione: le voci risultanti da questa query sono quelle corrispondenti alla sottovoce
    //            ma non necessariamente avranno i diritti di visualizzazione quindi le voci vanno
    //            solamente visualizzate e non devono mandare a nessun link

    //Query che restituisce modulo e voce e sottovoce in ordine per moduli e per voce e per sottovoce
    //quindi l'output avrà sostanzialmente un modulo
    $elencoSottovoci = "SELECT m.id_modulo, m.modulo, m.var_lingua_modulo, v.id_voce, v.voce, v.link_voce, v.var_lingua_voce, sv.id_sotto_voce, sv.sotto_voce, sv.link_sotto_voce, sv.var_lingua_sotto_voce
                        FROM sotto_voce sv, permesso_sotto_voce psv, voce v, modulo m
                        WHERE psv.id_sotto_voce=sv.id_sotto_voce AND
                              sv.id_voce=v.id_voce AND
                              v.id_modulo=m.id_modulo AND
                              psv.id_utente='".$idUtente."'
                        ORDER BY m.id_modulo, v.ordine, sv.ordine";



    $sql = mysql_query($elencoSottovoci)or die("ERROR IN script_permessi_menu.php - FUNCTION selectElencoSottoVoce - ".$elencoSottovoci." - ". mysql_error());




    return $sql;
}


?>

