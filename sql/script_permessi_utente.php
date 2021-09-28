<?php

/**
 * @author marilisa
 * Seleziona le informazioni di un utente dalla tabella dbutente
 * @param type $idUtente
 * @return type
 */
function findAziendaByUtente($idUtente){
    
     $stringSql="SELECT a.id_azienda, a.nome FROM dbutente.utente u JOIN dbutente.azienda a
                ON u.id_azienda=a.id_azienda
                WHERE id_utente= ".$idUtente;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_permessi_utente.php - FUNCTION findAziendaByUtente - ".$stringSql." - ". mysql_error());
    return $sql;
    
}

/**
 * @author marilisa
 * Seleziona le informazioni di un'azienda
 * @param type $idAzienda
 * @return type
 */
function findAziendaById($idAzienda){
    
     $stringSql="SELECT * FROM dbutente.azienda 
                WHERE id_azienda= ".$idAzienda;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_permessi_utente.php - FUNCTION findAziendaById - ".$stringSql." - ". mysql_error());
    return $sql;
    
}

/**
 * @author marilisa
 * Seleziona le informazioni relative alle aziende presenti nella stringa data
 * contenente a sua volta l'elenco delle aziende visibili dall'utente corrente
 * @param type $idAzienda
 * @param type $stringAziende
 * @return type
 */
function findAziendeVisDiverseDa($idAzienda,$stringAziende){
    
   $stringSql="SELECT DISTINCT * FROM dbutente.azienda 
                WHERE id_azienda IN ".$stringAziende."
                    AND id_azienda<>".$idAzienda;
    $sql = mysql_query($stringSql) 
            or die("ERROR IN script_permessi_utente.php - FUNCTION findAziendeVisDiverseDa - ".$stringSql." - ". mysql_error());
    return $sql;
}

/**
 * Metodo che recupera per un utente l'elenco delle tabelle su cui può scrivere
 * (permesso di tipo 2)
 * @param type $idUtente
 * @return type
 */
function selectTabellePerUtenteProprietario($idUtente)
{

    mysql_query("USE dbutente".mysql_error());

    
    //Prendo i casi in cui i due id_utenti sono uguali ed il permesso è uguale a scrittura=2
    $tabelleUtentePropr="SELECT DISTINCT t.id_tabella, t.nome
                         FROM   permesso p, tabella t
                         WHERE  p.id_tabella = t.id_tabella AND
                                p.id_utente=p.id_utente_prop AND
                                p.id_utente_prop='".$idUtente."' AND
                                p.permesso=2";

    //Seleziono i nomi delle tabelle in cui ha permesso di scrittura l'utente $idUtente
    $sql = mysql_query($tabelleUtentePropr) or die("ERROR IN script_permessi_utente.php - FUNCTION selectTabellePerUtenteProprietario - ".$tabelleUtentePropr." - ". mysql_error());


    return $sql;
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////





/**
 * Metodo che recupera per ogni tabella l'elenco degli utenti che possono scriverci,
 * quindi l'elenco dei proprietari per tabella
 * @param type $idTabella
 * @return type
 */
function selectUtentiProprietariPerTabella($idTabella)
{

    mysql_query("USE dbutente".mysql_error());

    
    //Prendo i casi in cui ho scrittura=2 quindi nelle righe in cui ho utenti proprietari
    //ATTENZIONE: la query va bene nel caso in cui si va con l'idea che per esserci permesso=2
    //            allora si ha una scrittura e di conseguenza si ha id_utente = id_utente_prop
    //
    $utentiProprTabella="SELECT DISTINCT u.id_utente, u.nome
                         FROM   permesso p, utente u
                         WHERE  p.id_utente = u.id_utente AND
				p.id_tabella='".$idTabella."' AND
                                p.permesso=2 ";

   $sql = mysql_query($utentiProprTabella)or die("ERROR IN script_permessi_utente.php - FUNCTION selectUtentiProprietariPerTabella - ".$utentiProprTabella." - ". mysql_error());




    return $sql;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/**
 * Metodo che recupera per l'utente loggato l'elenco delle tabelle che può visualizzare
 * @param type $idUtente
 * @return type
 */
function selectTabelleVisibiliUtente($idUtente)
{

    mysql_query("USE dbutente;".mysql_error());

   $tabVisibiliUt="SELECT DISTINCT t.id_tabella, t.nome
                    FROM   dbutente.permesso p, dbutente.utente u, dbutente.tabella t
                    WHERE  p.id_tabella = t.id_tabella AND
			   p.id_utente='".$idUtente."' AND
                           p.permesso>=1  ";


    $sql = mysql_query($tabVisibiliUt)or die("ERROR IN script_permessi_utente.php - FUNCTION selectTabelleVisibiliUtente - ".$tabVisibiliUt." - ". mysql_error());



    return $sql;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * Metodo che recupera per l'utente e per una delle sue tabelle visibili 
 * l'elenco degli utenti che di quella tabella potrà vedere
 * @param type $idUtente
 * @param type $idTabella
 * @return type
 */
function selectUtentiVisibiliTabella($idUtente, $idTabella)
{
    mysql_query("USE dbutente".mysql_error());
 
     $utentiVisibiliTab="SELECT  DISTINCT u.id_utente, u.nome, u.cognome, u.username, p.permesso,p.visibilita
                         FROM    permesso p, utente u
                         WHERE   p.id_utente_prop=u.id_utente AND
                                 p.id_utente='".$idUtente."' AND
                                 p.id_tabella='".$idTabella."' AND
                                 p.permesso>=1";
   //#############@@ MODIFICA MARI 14-11-2014 ##################################
//    echo $utentiVisibiliTab="(SELECT  DISTINCT u.id_utente, u.nome, u.cognome, u.username, p.permesso
//                         FROM    permesso p, utente u
//                         WHERE   p.id_utente_prop=u.id_utente AND
//                                 p.id_utente=".$idUtente." AND
//                                 p.id_tabella=".$idTabella." AND
//                                 p.permesso>=1) 
//                         UNION 
//                                 (SELECT  DISTINCT u.id_utente, u.nome, u.cognome, u.username, p.permesso
//                         FROM    permesso p, utente u
//                         WHERE   p.id_utente=u.id_utente AND
//                                 p.id_utente=".$idUtente." AND
//                                 p.id_tabella=".$idTabella." AND
//                                 p.permesso>=1)";
//##############################################################################
     $sql = mysql_query($utentiVisibiliTab)
             or die("ERROR IN script_permessi_utente.php - FUNCTION selectUtentiVisibiliTabella - ".$utentiVisibiliTab." - ". mysql_error());



    return $sql;
}



/**
 * Metodo che recupera per un utente la tabella visibili e di quale azienda sia quella tabella'
 * es: input: francesco.digaudio
 * formula  Personal Factory
 * formula Mapei
 * bolla   Kerakol

 * Inserendo il vincolo per utente ciò verrà visualizzato solo per l'utente corrente
 * quindi le tabelle e aziende corrispondenti dell'utente corrente
 * @param type $idUtente
 * @return type
 */
function selectTabellaAziende($idUtente)
{
    mysql_query("USE dbutente".mysql_error());

    
//    $utenteTabAzienda= "SELECT  DISTINCT t.id_tabella, t.nome, a.id_azienda, a.nome
//                         FROM   permesso p, utente u, tabella t, azienda a
//                         WHERE  p.id_tabella = t.id_tabella AND
//                                p.id_azienda = a.id_azienda AND
//			        p.id_utente='".$idUtente."' AND
//                                p.permesso>=1" ;
    

    $sql = mysql_query($utenteTabAzienda)or die("ERROR IN script_permessi_utente.php - FUNCTION selectTabellaAzienda - ".$utenteTabAzienda." - ". mysql_error());

    return $sql;
}


//metodo che recupera per un utente e per una tabella a quale azienda appartenga
//es: input: salvatore.nardi formula
//  Personal Factory
//  Mapei

//Inserendo il vincolo per utente  e per tabella ciò verrà visualizzato solo per l'utente corrente
// e per la tabella corrente quindi le aziende corrispondenti dell'utente e tabela corrente
function selectUtenteTabellaAziende($idUtente, $idTabella)
{
    mysql_query("USE dbutente".mysql_error());

    
    $utenteUtTabAzienda= " SELECT  DISTINCT a.id_azienda, a.nome
                           FROM    permesso p, utente u, tabella t, azienda a
                           WHERE   p.id_azienda = a.id_azienda AND
                                   p.id_tabella='".$idTabella."' AND
			           p.id_utente='".$idUtente."' AND
                                   p.permesso>=1";

    $sql = mysql_query($utenteUtTabAzienda)or die("ERROR IN script_permessi_utente.php - FUNCTION selectTabellaAzienda - ".$utenteUtTabAzienda." - ". mysql_error());

    return $sql;
}


//Metodo che recupera l'elenco generale delle aziende che l'untente può visualizzare
//ma non per ogni tabella ma in tutte le tabelle
//es: input: francesco.tassone
// Mapei
// Personal Factory
//
//Vincolando per id_utente visualizzero solo le aziende visibili all'utente corrente
/*function selectUtenteAziende($idUtente)
{
    mysql_query("USE dbutente".mysql_error());


    $utenteAzienda= "SELECT  DISTINCT a.id_azienda, a.nome
                        FROM   tabella t,  azienda a, permesso_scrittura ps, utente u, permesso_visualizzazione pv
                        WHERE  ps.id_azienda=a.id_azienda AND
                               ps.id_tabella=t.id_tabella AND
                               pv.id_perm_scri=ps.id_perm_scri AND
                               pv.id_utente=u.id_utente AND
                               u.id_utente='".$idUtente."'
                               ORDER BY u.id_utente";

    $sql = mysql_query($utenteAzienda)or die("ERROR IN script_permessi_utente.php - FUNCTION selectUtenteAziende - ".$utenteAzienda." - ". mysql_error());

    return $sql;
}
*/
//Medoto che recupera le aziende di cui un utente può visualizzare idati
//Recupero i dati relativi all'utente corrente
/*function selectAziendeUtente($idUtente)
{

    mysql_query("USE dbutente".mysql_error());

    $aziendeUt="SELECT distinct u.id_utente, u.nome, a.id_azienda,a.nome
                        FROM   utente u, azienda a, permesso pe, proprietario pr, tab_azienda ta
                        WHERE  pe.id_utente=u.id_utente AND
                               pe.id_proprietario=pr.id_proprietario AND
                               pr.id_tab_azienda=ta.id_tab_azienda AND
                               ta.id_azienda = a.id_azienda AND
                               u.id_utente=".$idUtente."
                       ORDER BY u.id_utente";

    /*
     *
     * new
     * SELECT distinct u.id_utente, u.nome, a.id_azienda,a.nome
                        FROM   utente u, azienda a, permesso_visualizzazione pv, permesso_scrittura ps
                        WHERE  pv.id_utente=u.id_utente AND
                               pv.id_perm_scri=ps.id_perm_scri AND
                               ps.id_azienda=a.id_azienda AND
                               u.id_utente=".$idUtente."
                       ORDER BY u.id_utente
     */
/*
    $sql = mysql_query($aziendeUt)or die("ERROR IN script_permessi_utente.php - FUNCTION selectAziendeUtente - ".$aziendeUt." - ". mysql_error());


    return $sql;
}
*/


function selectElencoPermessiModifica($idUtente, $idTabella)
{
    //DESCRIZIONE VARIABILI:
    // $idUtente //utente loggato che ha il permesso di modifica
    // $idTabella //tabella interessata al permesso di modifica
    //              Ovviamente affinche un utente x possa modificare i dati di una tabella t
    //              su cui ha scritto un utente y, deve essere necessaria l'esistenza di una riga
    //              che indica che l'utente y ha il permesso di scrittura sulla tabella t.

    //La query recupera l'elenco degli utenti proprietari che l'utente loggato
    //per la tabella corrente può modificare, se non ce ne sono ritorna un insieme vuoto

     $permessoModificaTabUt= "SELECT DISTINCT u.id_utente, u.nome, u.cognome, u.username, p.visibilita
                             FROM permesso p, utente u
                             WHERE p.id_utente_prop=u.id_utente AND
                                    p.id_utente='".$idUtente."' AND
                                    p.id_tabella='".$idTabella."' AND
                                    p.permesso=3";



    $sql = mysql_query($permessoModificaTabUt)or die("ERROR IN script_permessi_utente.php - FUNCTION selectElencoPermessiModifica - ".$permessoModificaTabUt." - ". mysql_error());

    return $sql;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////funzioni di utilità//////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//Metodo che recupera l'azienda di appartenenza dell'utente il cui id è passato come input della funzione
function selectAziendaUtente($idUtente)
{
    mysql_query("USE dbutente;".mysql_error());

    $aziendaUtente="SELECT a.id_azienda, a.nome
                        FROM   azienda a, utente u
                        WHERE u.id_azienda=a.id_azienda AND
                              u.id_utente=".$idUtente."";

    $sql = mysql_query($aziendaUtente)or die("ERROR IN script_permessi_utente.php - FUNCTION selectAziendaUtente - ".$aziendaUtente." - ". mysql_error());


    return $sql;
}

//Metodo che recupera le aziende su cui scrive un utente proprietario in una tabella
//Preso l'id della tabella e dell'utente in input restituisce un elenco di aziende
function selectAziendeUtenteProprietario($idUtenteProp, $idTabella)
{
    mysql_query("USE dbutente;".mysql_error());

    $aziendeUtenteProp="SELECT DISTINCT a.id_azienda, a.nome
                        FROM   azienda a,  permesso p
                        WHERE  p.id_azienda = a.id_azienda AND
                               p.id_utente_prop = ".$idUtenteProp." AND
                               p.id_tabella = ".$idTabella." AND
                               p.permesso =2";

    $sql = mysql_query($aziendeUtenteProp)or die("ERROR IN script_permessi_utente.php - FUNCTION selectAziendeUtenteProprietario - ".$aziendeUtenteProp." - ". mysql_error());


    return $sql;
}

//Metodo che recupera le aziende visibili dall'utente loggato per l'utente prop visibile
//Preso l'id della tabella e dell'utente in input restituisce un elenco di aziende
function selectAziendeVisibiliUtLoggato($idUtenteLoggato, $idUtentePropVisib, $idTabella)
{
    mysql_query("USE dbutente;".mysql_error());

    $aziendeUtenteProp="SELECT DISTINCT a.id_azienda, a.nome
                        FROM   azienda a,  permesso p
                        WHERE  p.id_azienda = a.id_azienda AND
                               p.id_utente = ".$idUtenteLoggato." AND
                               p.id_utente_prop = ".$idUtentePropVisib." AND
                               p.id_tabella = ".$idTabella." AND
                               p.permesso >=1";

    $sql = mysql_query($aziendeUtenteProp)or die("ERROR IN script_permessi_utente.php - FUNCTION selectAziendeUtenteProprietario - ".$aziendeUtenteProp." - ". mysql_error());


    return $sql;
}

//Metodo di utilità interno allo script che recupera l'elenco generale degli utenti proprietari
/*function selectElencoUtentiProprietari()
{

    mysql_query("USE dbutente;".mysql_error());

    $elencoUtentiProp="SELECT DISTINCT u.id_utente, u.nome
                        FROM   utente u, permesso p
                        WHERE  p.id_utente=u.id_utente AND
								       p.id_utente=p.id_utente_prop AND
								       p.permesso=2";

    $sql = mysql_query($elencoUtentiProp)or die("ERROR IN script_permessi_utente.php - FUNCTION selectElencoUtentiProprietari - ".$elencoUtentiProp." - ". mysql_error());


    return $sql;
}*/

//Metodo di utilità interno allo script che recupera i dati riferiti all'id dell'utente inserito
function selectDatiUtente($idUtente)
{
    mysql_query("USE dbutente;".mysql_error());

    $datiUtente="SELECT id_utente, nome, cognome, username,visibilita
                        FROM   utente
                        WHERE id_utente = ".$idUtente;

    $sql = mysql_query($datiUtente)or die("ERROR IN script_permessi_utente.php - FUNCTION selectDatiUtente - ".$datiUtente." - ". mysql_error());


    return $sql;
}


//Metodo di utilità interno allo script che recupera l'elenco generale delle tabelle
function selectElencoTabelle()
{
    mysql_query("USE dbutente".mysql_error());

    $elencoTabelle="SELECT id_tabella, nome
                        FROM   tabella";

    $sql = mysql_query($elencoTabelle)or die("ERROR IN script_permessi_utente.php - FUNCTION selectElencoTabelle - ".$elencoTabelle." - ". mysql_error());


    return $sql;
}


//Metodo di utilità interno allo script che recupera l'elenco generale delle aziende
function selectElencoAziende()
{
    mysql_query("USE dbutente".mysql_error());

    $elencoAziende="SELECT id_azienda, nome
                        FROM   azienda";

    $sql = mysql_query($elencoAziende)or die("ERROR IN script_permessi_utente.php - FUNCTION selectElencoAziende - ".$elencoAziende." - ". mysql_error());


    return $sql;
}

//Metodo di utilità interno allo script che recupera l'elenco generale degli utenti
function selectElencoUtenti()
{

    mysql_query("USE dbutente;".mysql_error());

    $elencoUtenti="SELECT id_utente, nome, cognome,id_azienda, username,visibilita
                        FROM   utente";

    $sql = mysql_query($elencoUtenti)or die("ERROR IN script_permessi_utente.php - FUNCTION selectElencoUtenti - ".$elencoUtenti." - ". mysql_error());


    return $sql;
}





function selectFunzioniUtLoggato($idUtenteLog)
{
    mysql_query("USE dbutente;".mysql_error());

         $funzioniUt="SELECT DISTINCT f.id_funzione, f.funzione
                      FROM permesso_funzione pf, funzione f
                      WHERE pf.id_funzione = f.id_funzione AND
							 id_utente =".$idUtenteLog;

    $sql = mysql_query($funzioniUt)or die("ERROR IN script_permessi_utente.php - FUNCTION selectFunzioniUtLoggato - ".$funzioniUt." - ". mysql_error());


    return $sql;
}



function  selectAziendeFunzioniUtLoggato($idUtenteLog, $idFunzione)
{
    mysql_query("USE dbutente;".mysql_error());

    $azFunzioniUt="SELECT DISTINCT a.id_azienda, a.nome
                   FROM azienda a, permesso_funzione pf
                   WHERE pf.id_azienda = a.id_azienda AND
                         pf.id_utente = ".$idUtenteLog." AND
                         pf.id_funzione = ".$idFunzione;

    $sql = mysql_query($azFunzioniUt)or die("ERROR IN script_permessi_utente.php - FUNCTION selectAziendeFunzioniUtLoggato - ".$azFunzioniUt." - ". mysql_error());


    return $sql;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








?>

