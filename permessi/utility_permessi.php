<?php

/**
 * Il metodo valuta i permessi dell'utente e restituisce una chiamata alle funzioni js 
 * definite nel file /permessi/utility_permessi.php
 * per la disabilitazione dei link
 * @param type $funzioni
 * @return string
 */
function gestisciPermessiUtenteOnLoad($funzioni, $objPermessiVis) {

    $actionOnLoad = "";
    $arrayAction = array();
    //VERIFICA DEI PERMESSI
    for ($i = 0; $i < count($funzioni); $i++) {
        $arrayAction[$i] = "";
        if (!verificaPermessoFunzione($objPermessiVis, $funzioni[$i])) {
            $arrayAction[$i] = "disabilitaAction" . $funzioni[$i] . "();";
        }
    }
    //COSTRUZIONE DELLA STRINGA actionOnLoad da passare nel tag body
    for ($k = 0; $k < count($arrayAction); $k++) {
        $actionOnLoad = $actionOnLoad . $arrayAction[$k];
    }

    return $actionOnLoad;
}

/**
 * Nuovo metodo di verifica dei permessi sulle funzionalità
 * dato l'utente loggato ed una funzionalità restituisce true se 
 * l'utente ha accesso alla funzionalità data (almeno per un'azienda)
 * altrimenti restituisca false
 * @param type $objPermVis
 * @param type $funzione
 * @return type
 */
function verificaPermessoFunzione($objPermVis, $funzione) {
    return $objPermVis->functionIsAllowed($funzione);
//    return 1;
}

function getStrUtAzVisib($objctPermVis, $nomeTabella) {
    return $objctPermVis->getMySqlStringUtentiAziende($nomeTabella);
}

function getAziendeScrivibili($objctPermVis, $nomeTabella) {
    //Restituisce le aziende su cui si ha il permesso >=2
    return $objctPermVis->getAziendeScrivModifPerTabella($nomeTabella);
}

function getNomeAziendaById($objUtility, $idAzienda) {

    return $objUtility->getNomeAzienda($idAzienda);
}

function getVisibilitaPerTabella($objctPermVis, $nomeTabella) {
    return $objctPermVis->getMySqlStringUtentiAziende($nomeTabella);
}

/**
 * Restituisce gli utenti proprietari visibili per una data tabella dall'utente loggato
 * @param type $objctPermVis
 * @param type $nomeTabella
 * @return type
 */
function getUtentiPropVisib($objctPermVis, $nomeTabella) {
    return $objctPermVis->getMysqlStringUtentiProprietariPerTabella($nomeTabella);
}

/**
 * Restituisce le aziende visibili per una data tabella tabella dall'utente loggato
 * @param type $objctPermVis
 * @param type $nomeTabella
 * @return type
 */
function getAziendeVisib($objctPermVis, $nomeTabella) {
    return $objctPermVis->getMysqlStringAziendePerTabella($nomeTabella);
}

//############# VERIFICA PERMESSO VISUALIZZAZIONE ##########################

/**
 * Verifica se nell'oggetto dato contenente i permessi di visualizzazione 
 * dell'utente corrente è presente il permesso di visualizzazione le tabelle contenute
 * nell'array se non si ha il permesso su tutte le tabelle viene effettuato un redirect  
 * @param type $objPermVis
 * @param type $arrayTabelle
 */
function verificaPermessoVisArrayTab($objPermVis, $arrayTabelle) {
    $permessoVis = 1;
    for ($i = 0; $i < count($arrayTabelle); $i++) {
        if (!$objPermVis->tableIsViewable($arrayTabelle[$i])) {
            echo "<div id='msgLog'>Non si possiede il permesso di visualizzare : " . $arrayTabelle[$i] . "</div>";

            $permessoVis = 0;
        } else {
            echo "<div id='msgLog'>" . $arrayTabelle[$i] . " VISUALIZZABILE</div>";
        }
    }
    return $permessoVis;
}

//############# VERIFICA PERMESSO SCRITTURA GENERICO ##########################
/**
 * Verifica se nell'oggetto dato contenente i permessi 
 * dell'utente corrente è presente il permesso di editare (INSERT - UPDATE - DELETE) 
 * tutte le tabelle il cui nome è contenute nell'array.
 * Se non si hanno i permessi sufficienti vengono disabilitati tutti link
 * @param type $objPermVis
 * @param type $arrayTabelle
 */
function verificaPermessoScrit2($objPermVis, $arrayTabelle) {

    $permessoScrittura = 0;
    $tabScrivibili = 0;
    echo "</br>  ";
    for ($i = 0; $i < count($arrayTabelle); $i++) {
        $nomeTabDaControllare = $arrayTabelle[$i];

        for ($j = 0; $j < count($objPermVis->getArrayTabelleProprietari()); $j++) {

            $arrayTabProp = $objPermVis->getArrayTabelleProprietari();

            $nomeTabCorrente = $arrayTabProp[$j]->getNomeTabella();
//echo "tabella proprietari nei permessi : ". $nomeTabCorrente. " -- tabella da controllare : ". $nomeTabDaControllare."</br>";
            //NOTA: il controllo se la tabella sia scrivibile o meno viene 
            //fatto solo se sulla tabella si ha già un permesso di visualizzazione 
            if ($nomeTabDaControllare == $nomeTabCorrente) {
                if ($arrayTabProp[$j]->tableIsWritable()) {
                    echo "<div id='msgLog'>" . $nomeTabDaControllare . "   SCRIVIBILE</div>";
                    $tabScrivibili = $tabScrivibili + 1;
                } else {
                    echo "<div id='msgLog'>" . $nomeTabDaControllare . " NON SCRIVIBILE</div>";
                }
            }
        }
        //Aggiunto il controllo perchè se non ha il permesso su nessuna 
        //tabella dell'array non funziona
        if ($tabScrivibili == count($arrayTabelle))
            $permessoScrittura = 1;
    }

    return $permessoScrittura;
}

function verificaPermScrittura2($objPermVis, $arrayTabelle) {

    $actionOnLoad = "";
    $tabScrivibili = 0;
    echo "</br>  ";
    for ($i = 0; $i < count($arrayTabelle); $i++) {
        $nomeTabDaControllare = $arrayTabelle[$i];

        for ($j = 0; $j < count($objPermVis->getArrayTabelleProprietari()); $j++) {

            $arrayTabProp = $objPermVis->getArrayTabelleProprietari();

            $nomeTabCorrente = $arrayTabProp[$j]->getNomeTabella();
//echo "tabella proprietari nei permessi : ". $nomeTabCorrente. " -- tabella da controllare : ". $nomeTabDaControllare."</br>";
            //NOTA: il controllo se la tabella sia scrivibile o meno viene 
            //fatto solo se sulla tabella si ha già un permesso di visualizzazione 
            if ($nomeTabDaControllare == $nomeTabCorrente) {
                if ($arrayTabProp[$j]->tableIsWritable()) {
                    echo "<div id='msgLog'>" . $nomeTabDaControllare . "   SCRIVIBILE</div>";
                    $tabScrivibili = $tabScrivibili + 1;
                } else {
                    echo "<div id='msgLog'>" . $nomeTabDaControllare . " NON SCRIVIBILE</div>";
                }
            }
        }
        //Aggiunto il controllo perchè se non ha il permesso su nessuna 
        //tabella dell'array non funziona
        if ($tabScrivibili != count($arrayTabelle))
            $actionOnLoad = "disabilitaOperazioni()";
    }

    return $actionOnLoad;
}

//############# VERIFICA PERMESSO MODIFICA DATI DI ALTRI UTENTI ################

/**
 * Verifica se nell'oggetto dato contenente i permessi 
 * dell'utente corrente è presente il permesso di modificare (UPDATE - DELETE), in tutte
 * tabelle il cui nome è contenute nell'array, i dati di un altro utente proprietario
 * Se non si hanno i permessi sufficienti vengono disabilitati i link
 * @param type $objPermVis
 * @param type $arrayTabelle
 */
function verificaPermessoModifica3($objPermVis, $arrayTabelle, $utenteProp) {
    $permessoModifica = 1;

    for ($i = 0; $i < count($arrayTabelle); $i++) {
        if (!$objPermVis->tableIsEditable($arrayTabelle[$i], $utenteProp)) {
            echo "<div id='msgLog'>" . $arrayTabelle[$i] . "  NON EDITABILE PER UTENTE : " . $utenteProp . "</div>";
            $permessoModifica = 0;
        } else {
            echo "<div id='msgLog'>" . $arrayTabelle[$i] . " EDITABILE PER UTENTE: " . $utenteProp . "</div>";
        }
    }
    return $permessoModifica;
}

/**
 * Verifica se l'utente ha il permesso di modificare il dato nelle tabelle il cui nome 
 * è contenute nell'array
 * Controlla che l'utente loggato abbia o meno il permesso 3 
 * sull' utente proprietario e l'azienda proprietaria del dato
 * Restituisce il nome della funzione javascript da richiamare onLoad
 * per disabilitare i link relativi al salvataggio delle modifiche 
 * nel caso in cui l'utente non abbia il permesso di modificare
 * @param type $objPermVis
 * @param type $arrayTabelle
 * @param type $utenteProp
 * @param type $idAzienda
 * @return string
 */
function verificaPermModifica3($objPermVis, $arrayTabelle, $utenteProp, $idAzienda) {
    $actionOnLoad = "";

    for ($i = 0; $i < count($arrayTabelle); $i++) {
        if (!$objPermVis->tableIsEditable($arrayTabelle[$i], $utenteProp, $idAzienda)) {
            echo "<div id='msgLog'></br>" . $arrayTabelle[$i] . "  NON EDITABILE PER UTENTE : " . $utenteProp . " AZIENDA : " . $idAzienda . "</div>";
            $actionOnLoad = "disabilitaOperazioni()";
        } else {
            echo "<div id='msgLog'></br>" . $arrayTabelle[$i] . " EDITABILE PER UTENTE: " . $utenteProp . " AZIENDA : " . $idAzienda . "</div>";
        }
    }
    return $actionOnLoad;
}
?>

<!--#########################################################################-->
<!--#################FUNZIONI JAVASCRIPT ####################################-->
<!--#########################################################################-->
<script language="javascript">
    function disabilitaAction1() {
        //PERMESSO VISTA LISTA PRODOTTI
        location.href = '../permessi/avviso_permessi_visualizzazione.php'

    }
    function disabilitaAction2() {
        //PERMESSO DI VISUALIZZAZIONE DETTAGLIO PRODOTTO NEGATO
        //Disabilita il link alla pagina di modifica
        for (i = 0; i < document.getElementsByName('2').length; i++) {
            document.getElementsByName('2')[i].removeAttribute('href');
        }
    }
    function disabilitaAction3() {
        //PERMESSO DI VISUALIZZAZIONE DETTAGLIO PROD E FORMULA NEGATO            
        //Disabilita la vista del dettaglio prodotto
        for (i = 0; i < document.getElementsByName('3').length; i++) {
            document.getElementsByName('3')[i].removeAttribute('href');
        }
    }
    function disabilitaAction4() {
        //CASO: PERMESSO DI SCRITTURA NEGATO
        //Disabilito la creazione di un nuovo prodotto            
        document.getElementById('4').removeAttribute('href');
    }
    function disabilitaAction5() {
        //PERMESSO VISTA LISTA FAMIGLIE
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction6() {
        //PERMESSO DI CREARE UNA NUOVA FAMIGLIA
        //Disabilito la creazione di una nuova famiglia            
        document.getElementById('6').removeAttribute('href');

    }
    function disabilitaAction7() {
        //PERMESSO VISTA LISTA COMPONENTI 
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction8() {
        //CASO: PERMESSO DI SCRITTURA COMPONENTENEGATO
        //Disabilito la creazione di un nuovo prodotto            
        document.getElementById('8').removeAttribute('href');
    }
    function disabilitaAction9() {
        //PERMESSO VISTA LISTA COLORI BASE
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction10() {
        //PERMESSO SCRITTURA NUOVO COLORE BASE
        document.getElementById('10').removeAttribute('href');
    }

    function disabilitaAction11() {
        //PERMESSO VISTA LISTA COLORI
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction12() {
        //PERMESSO SCRITTURA NUOVO COLORE 
        document.getElementById('12').removeAttribute('href');
    }
    function disabilitaAction13() {
        //PERMESSO VISTA LISTA MAZZETTE COLORATE
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction14() {
        //PERMESSO VISUALIZZARE IL DETTAGLIO MAZZETTA COLORATA
        //Si disabilita la visualizzazione del dettaglio mazzetta
        //Si disabilita la possibilita di definire un colore e associarlo ad una mazzetta
        for (i = 0; i < document.getElementsByName('14').length; i++) {
            document.getElementsByName('14')[i].removeAttribute('href');
        }

    }
    function disabilitaAction15() {
        //PERMESSO EDITARE MAZZETTA COLORATA
        //Si disabilita la creazione di una nuova mazzetta 
        //Si disabilita la possibilita di definire un colore e associarlo ad una mazzetta
        for (i = 0; i < document.getElementsByName('15').length; i++) {
            document.getElementsByName('15')[i].removeAttribute('href');
        }

    }
    function disabilitaAction17() {
        //PERMESSO VISTA LISTA FORMULE COMPOUND
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction18() {
        //PERMESSO SCRITTURA NUOVO COLORE 
        for (i = 0; i < document.getElementsByName('18').length; i++) {
            document.getElementsByName('18')[i].removeAttribute('href');
        }
    }

    function disabilitaAction20() {
        //PERMESSO EDITARE FORMULA
        //Si disabilita la creazione di una nuova formula 
        //Si disabilita la possibilita di eliminare una formula
        for (i = 0; i < document.getElementsByName('20').length; i++) {
            document.getElementsByName('20')[i].removeAttribute('href');
        }
    }

    function disabilitaAction21() {
        //PERMESSO VISTA LISTA ACCESSORI
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }

    function disabilitaAction22() {
        //PERMESSO DI CREARE UN NUOVO ACCESSORIO
        //Disabilito la creazione di uno nuovo accessorio            
        document.getElementById('22').removeAttribute('href');
    }

    function disabilitaAction23() {
        //PERMESSO VISTA LISTA MATERIE PRIME 
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction24() {
        //PERMESSO DI VISUALIZZAZIONE DETTAGLIO MATERIA PRIME
        //Disabilita il link alla pagina di modifica
        for (i = 0; i < document.getElementsByName('24').length; i++) {
            document.getElementsByName('24')[i].removeAttribute('href');
        }
    }
    function disabilitaAction27() {
        //PERMESSO DI CREARE NUOVA MATERIA PRIMA
        //Disabilita il link alla pagina di creazione
        for (i = 0; i < document.getElementsByName('27').length; i++) {
            document.getElementsByName('27')[i].removeAttribute('href');
        }
    }
    function disabilitaAction28() {
        //PERMESSO VISTA LISTA LABORATORIO MATERIE PRIME 
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction29() {
        //PERMESSO DI VISUALIZZAZIONE DETTAGLIO LABORATORIO MATERIA PRIME
        //Disabilita il link alla pagina di modifica lab materia prima
        for (i = 0; i < document.getElementsByName('29').length; i++) {
            document.getElementsByName('29')[i].removeAttribute('href');
        }
    }
    function disabilitaAction30() {
        //PERMESSO VISUALIZZAZIONE CARATTERISTICHE MAT PRIME LAB
        document.getElementById("30").style.display = "none";

    }
    function disabilitaAction31() {
        //PERMESSO VISUALIZZAZIONE ESPERIMENTI LAB
        document.getElementById("31").style.display = "none";

    }
    function disabilitaAction32() {
        //PERMESSO DI CREARE NUOVA MATERIA PRIMA DI LABORATORIO
        //Disabilita il link alla pagina di creazione
        for (i = 0; i < document.getElementsByName('32').length; i++) {
            document.getElementsByName('32')[i].removeAttribute('href');
        }
    }
    function disabilitaAction34() {
        //PERMESSO VISTA LISTA MACCHINE
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction35() {
        //PERMESSO VISUALIZZAZIONE DETTAGLIO MACCHINA 
        //Disabilita il link alla pagina di modifica
        for (i = 0; i < document.getElementsByName('35').length; i++) {
            document.getElementsByName('35')[i].removeAttribute('href');
        }
    }
    function disabilitaAction36() {
        //PERMESSO VISUALIZZAZIONE DETTAGLIO PROCESSI        
        //Disabilita i link ai processi delle macchine
        for (i = 0; i < document.getElementsByName('36').length; i++) {
            document.getElementsByName('36')[i].removeAttribute('href');
        }
    }
    function disabilitaAction37() {
        //PERMESSO VISUALIZZAZIONE DEI VALORI PARAMETRI COMPONENTI
        //Disabilita i link alla visualizzazione dei valori par comp
        for (i = 0; i < document.getElementsByName('37').length; i++) {
            document.getElementsByName('37')[i].removeAttribute('href');
        }
    }
    function disabilitaAction38() {
        //PERMESSO VISUALIZZAZIONE DEI VALORI PARAMETRI SINGOLA MACCHINA
        //Disabilita i link alla visualizzazione dei valori par sing mac
        for (i = 0; i < document.getElementsByName('38').length; i++) {
            document.getElementsByName('38')[i].removeAttribute('href');
        }
    }
    function disabilitaAction39() {
        //PERMESSO VISUALIZZAZIONE DEI VALORI PARAMETRI RIPRISTINO
        //Disabilita i link alla visualizzazione dei valori par ripristino
        for (i = 0; i < document.getElementsByName('39').length; i++) {
            document.getElementsByName('39')[i].removeAttribute('href');
        }
    }
    function disabilitaAction40() {
        //PERMESSO DI SCRITTURA MACCHINA
        //Disabilita la creazione di un nuovo stabilimento            
        document.getElementById('40').removeAttribute('href');
    }
    function disabilitaAction44() {
        //VEDERE LISTA SEGNALAZIONI
        location.href = '../permessi/avviso_permessi_visualizzazione.php';
    }
    //    ############## AGGIORNAMENTO ###################################
    function disabilitaAction57() {
        //INVIO AGGIORNAMENTI VERSO SINGOLA MACCHINA
        location.href = '../permessi/avviso_permessi_visualizzazione.php';
    }
    function disabilitaAction58() {
        //INVIO AGGIORNAMENTI VERSO TUTTI
//        document.getElementById('58').disabled = true;
        document.getElementById('58').style.display = "none"; 
    }
    function disabilitaAction59() {
        //DOWLOAD AGGIORNAMENTI DA TUTTE LE MACCHINE
        location.href = '../permessi/avviso_permessi_visualizzazione.php';
    }
    function disabilitaAction60() {
        //DOWNLOAD BACKUP DA TUTTE LE MACCHINE
        document.getElementById('60').disabled = true;
    }

    function disabilitaAction80() {
        //PERMESSO VISTA LISTA CATEGORIE
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction81() {
        //PERMESSO VEDERE DETTAGLIO CATEGORIA 
        //Disabilita il link alla pagina di modifica
        for (i = 0; i < document.getElementsByName('81').length; i++) {
            document.getElementsByName('81')[i].removeAttribute('href');
        }
    }
    function disabilitaAction82() {
        //PERMESSO SCRITTURA CATEGORIA
        for (i = 0; i < document.getElementsByName('82').length; i++) {
            //document.getElementsByName('82')[i].removeAttribute('href');
            document.getElementsByName('82')[i].style.display = "none";
        }
    }
    function disabilitaAction83() {
        //PERMESSO VEDERE VALORI PARAMETRI PRODOTTO 
        //Disabilita il link alla pagina di visualizzazione dei valori dei parametri prodotto
        for (i = 0; i < document.getElementsByName('83').length; i++) {
            document.getElementsByName('83')[i].removeAttribute('href');
        }
    }
    function disabilitaAction84() {
        //PERMESSO VEDERE VALORI PARAMETRI SACCHETTO
        //Disabilita il link alla pagina di visualizzazione di valori par sacchetto
        for (i = 0; i < document.getElementsByName('84').length; i++) {
            document.getElementsByName('84')[i].removeAttribute('href');
        }
    }
    function disabilitaAction85() {
        //DUPLICARE UNA CATEGORIA
        //Disabilita il link alla pagina di visualizzazione di valori par sacchetto
        for (i = 0; i < document.getElementsByName('85').length; i++) {
            document.getElementsByName('85')[i].removeAttribute('href');
        }
    }
    function disabilitaAction86() {
        //PERMESSO VISTA LISTA FIGURE
        location.href = '../permessi/avviso_permessi_visualizzazione.php'

    }
    function disabilitaAction87() {
        //PERMESSO EDITARE FIGURE
        //Disabilita il link alla pagina di creazione
        document.getElementById('Nuova').removeAttribute('href');
    }

    function disabilitaAction90() {
        //PERMESSO VISTA DETTAGLIO SACCO
//        location.href = '../permessi/avviso_permessi_visualizzazione.php'
        for (i = 0; i < document.getElementsByName('90').length; i++) {
            document.getElementsByName('90')[i].removeAttribute('href');
        }
    }
    function disabilitaAction91() {
        //PERMESSO VISTA DETTAGLIO CHIMICA
        for (i = 0; i < document.getElementsByName('91').length; i++) {
            document.getElementsByName('91')[i].removeAttribute('href');
        }
    }
    
    function disabilitaAction92() {
        //PERMESSO VISTA DETTAGLIO LOTTO
        for (i = 0; i < document.getElementsByName('92').length; i++) {
            document.getElementsByName('92')[i].removeAttribute('href');
        }
    }
    
    function disabilitaAction93() {
        //PERMESSO VISTA DETTAGLIO BOLLA
//        document.getElementById('93').removeAttribute('href');
         for (i = 0; i < document.getElementsByName('93').length; i++) {
            document.getElementsByName('93')[i].removeAttribute('href');
        }
    }
    function disabilitaAction94() {
        //PERMESSO CALCOLO PRODUTTIVITA
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction96() {
        //PERMESSO VISUALIZZAZIONE DEL SESTO LIVELLO DEI GRUPPI
        document.getElementById("96").style.display = "none";

    }
    function disabilitaAction98() {
        //PERMESSO VISUALIZZAZIONE DEI GRUPPI
        document.getElementById("98").style.display = "none";

    }
    function disabilitaAction100() {
        //CASO: PERMESSO DI CREARE UN PRODOTTO FIGLIO
        //Disabilita la creazione di prodotti figli
        for (i = 0; i < document.getElementsByName('100').length; i++) {
            document.getElementsByName('100')[i].removeAttribute('href');
        }
    }
    function disabilitaAction101() {
        //CASO: PERMESSO DI DISABILITARE UN PRODOTTO
        //Disabilita la disabilitazione dei prodotti 
        for (i = 0; i < document.getElementsByName('101').length; i++) {
            document.getElementsByName('101')[i].removeAttribute('href');
        }
    }
    function disabilitaAction102() {
        //VEDERE LISTA ULTIMI PROCESSI
//        location.href = '../permessi/avviso_permessi_visualizzazione.php'
        for (i = 0; i < document.getElementsByName('102').length; i++) {
            document.getElementsByName('102')[i].style.display = "none";
        }
    }
    function disabilitaAction103() {
        //PERMESSO DI VEDERE I CODICI MOVIMENTI
        for (i = 0; i < document.getElementsByName('103').length; i++) {
            document.getElementsByName('103')[i].removeAttribute('href');
            document.getElementsByName('103')[i].style.display = "none"; ///?????
        }
    }


    function disabilitaAction105() {
        //CREARE-ELIMINARE PERSONE
        for (i = 0; i < document.getElementsByName('105').length; i++) {
            
            document.getElementsByName('105')[i].style.display = "none"; ///?????
        }

    }

    function disabilitaAction106() {
        //VEDERE LISTA LAB FORMULE
        location.href = '../permessi/avviso_permessi_visualizzazione.php'

    }
    function disabilitaAction107() {
        //CASO: PERMESSO DI VEDERE IL DETTAGLIO DI UNA FORMULA DI LABORATORIO

        for (i = 0; i < document.getElementsByName('107').length; i++) {
            document.getElementsByName('107')[i].removeAttribute('href');
        }
    }
    function disabilitaAction108() {
        //VEDERE IL DETTAGLIO DEL PRODOTTO TARGET
        for (i = 0; i < document.getElementsByName('108').length; i++) {
            document.getElementsByName('108')[i].removeAttribute('href');
        }
    }
    function disabilitaAction109() {
        //PERMESSO DI EDITARE LA FORMULA
        for (i = 0; i < document.getElementsByName('109').length; i++) {
//            document.getElementsByName('108')[i].removeAttribute('href');
            document.getElementsByName('109')[i].style.display = "none"; ///?????
        }
    }

    function disabilitaAction110() {
        //VEDERE LISTA LAB PARAMETRI
        location.href = '../permessi/avviso_permessi_visualizzazione.php';

    }
    function disabilitaAction111() {
        //EDITARE LAB PARAMETRO
        for (i = 0; i < document.getElementsByName('111').length; i++) {
            document.getElementsByName('111')[i].style.display = "none";
        }
    }
    function disabilitaAction113() {
        //MODIFICARE LAB NORMATIVA
        for (i = 0; i < document.getElementsByName('113').length; i++) {
            document.getElementsByName('113')[i].style.display = "none";
        }
    }
    function disabilitaAction114() {
        //PERMESSO VISTA LISTA PROVE DI LAbORATORIO
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }
    function disabilitaAction115() {
        //VEDERE DETTAGLIO LAB FORMULA + PROVA
        for (i = 0; i < document.getElementsByName('115').length; i++) {
            document.getElementsByName('115')[i].removeAttribute('href');
        }
    }
    function disabilitaAction116() {
        //EDITARE LAB ESPERIMENTO
        for (i = 0; i < document.getElementsByName('116').length; i++) {
            document.getElementsByName('116')[i].style.display = "none";
        }
    }
    function disabilitaAction117() {
        //FARE IL MERGE DEGLI ESPERIMENTI
        for (i = 0; i < document.getElementsByName('117').length; i++) {
            document.getElementsByName('117')[i].style.display = "none";
        }
    }
    function disabilitaAction118() {
        //VEDERE LISTA LAB CARATTERISTICHE
        location.href = '../permessi/avviso_permessi_visualizzazione.php';
    }
    function disabilitaAction119() {
        //EDITARE LAB CARATTERISTICHE
        for (i = 0; i < document.getElementsByName('119').length; i++) {
            document.getElementsByName('119')[i].style.display = "none";
        }
    }
    function disabilitaAction120() {
        //EDITARE LAB CARATTERISTICHE
        for (i = 0; i < document.getElementsByName('120').length; i++) {
            document.getElementsByName('120')[i].style.display = "none";
        }
    }
    function disabilitaAction121() {
        //MODIFICARE LAB CARATTERISTICHE MT
        for (i = 0; i < document.getElementsByName('121').length; i++) {
            document.getElementsByName('121')[i].style.display = "none";
        }
    }
    function disabilitaAction122() {
        //CREARE LAB CARATTERISTICHE MT
        for (i = 0; i < document.getElementsByName('122').length; i++) {
            document.getElementsByName('122')[i].style.display = "none";
        }
    }

    function disabilitaAction123() {
        //CREARE LAB NORMATIVA
        for (i = 0; i < document.getElementsByName('123').length; i++) {
            document.getElementsByName('123')[i].style.display = "none";
        }
    }
    function disabilitaAction125() {
        //MODIFICARE LAB MACCHINA
        for (i = 0; i < document.getElementsByName('125').length; i++) {
            document.getElementsByName('125')[i].style.display = "none";
        }
    }
    function disabilitaAction126() {
        //CREARE - ELIMINARE LAB MACCHINA
        for (i = 0; i < document.getElementsByName('126').length; i++) {
            document.getElementsByName('126')[i].style.display = "none";
        }
    }


    function disabilitaAction127() {
        //PERMESSO VISUALIZZAZIONE DETTAGLIO MISCELA
        for (i = 0; i < document.getElementsByName('127').length; i++) {
            document.getElementsByName('127')[i].removeAttribute('href');
        }
        
    }

    function disabilitaAction128() {
        //PERMESSO VISTA LISTA SIMULAZIONI BS
        location.href = '../permessi/avviso_permessi_visualizzazione.php'
    }

    function disabilitaAction129() {
        //CREARE NUOVE SIMULAZIONI IN BS
        for (i = 0; i < document.getElementsByName('129').length; i++) {
            document.getElementsByName('129')[i].style.display = "none";
        }
    }

    function disabilitaAction130() {
        //MODIFICARE  SIMULAZIONI IN BS
        for (i = 0; i < document.getElementsByName('130').length; i++) {
            document.getElementsByName('130')[i].style.display = "none";
        }
    }

    function disabilitaAction131() {
        //PERMESSO VISUALIZZAZIONE LISTA CLIENTI BS
        location.href = '../permessi/avviso_permessi_visualizzazione.php';

    }

    function disabilitaAction134() {
        //PERMESSO VISUALIZZAZIONE LISTA PRODOTTI BS
        location.href = '../permessi/avviso_permessi_visualizzazione.php';

    }
    function disabilitaAction135() {
        //CREARE ELIMINARE PRODOTTI IN BS
        for (i = 0; i < document.getElementsByName('135').length; i++) {
            document.getElementsByName('135')[i].style.display = "none";
        }
    }
    function disabilitaAction136() {
        //MODIFICARE UN PRODOTTO IN BS
        for (i = 0; i < document.getElementsByName('136').length; i++) {
            document.getElementsByName('136')[i].style.display = "none";
        }
    }
    function disabilitaAction137() {
        //VEDERE CATALOGO IN BS
        for (i = 0; i < document.getElementsByName('137').length; i++) {
            document.getElementsByName('137')[i].style.display = "none";
        }
    }
    function disabilitaAction138() {
        //VEDERE VALORI PAR PRODOTTO DA LISTA PROCESSI
        for (i = 0; i < document.getElementsByName('138').length; i++) {
            document.getElementsByName('138')[i].removeAttribute('href');
        }
    }
    
    function disabilitaAction139() {
        //VEDERE LISTA MOVIMENTI DRYMIX
        for (i = 0; i < document.getElementsByName('139').length; i++) {
            document.getElementsByName('139')[i].style.display = "none";
           //document.getElementsByName('139')[i].removeAttribute('href');
        }
    }

    function disabilitaAction140() {
        //PERMESSO VISUALIZZAZIONE CARTELLA MACCHINA SU SERVER FTP       
        //Disabilita l'accesso al server FTP
        for (i = 0; i < document.getElementsByName('140').length; i++) {
            document.getElementsByName('140')[i].removeAttribute('href');
        }
    }
    
    function disabilitaAction142() {
        //PERMESSO DI CREARE-ELIMINARE UN ORDINE PER ORIGAMI
        
        for (i = 0; i < document.getElementsByName('142').length; i++) {
           document.getElementsByName('142')[i].style.display = "none";
           
        }
       

    }
    
    function disabilitaAction143() {
        //PERMESSO DI CREARE-ELIMINARE UN NUOVO MOVIMENTO PER LE MATERIE PRIME DRYMIX
        
        for (i = 0; i < document.getElementsByName('143').length; i++) {
           document.getElementsByName('143')[i].style.display = "none";
           
        }
       

    }
    
    function disabilitaAction144() {
        //PERMESSO DI VEDERE ELENCO DEGLI ALLARMI
        
        for (i = 0; i < document.getElementsByName('144').length; i++) {
           document.getElementsByName('144')[i].style.display = "none";
           
        }
    }
       
       function disabilitaAction145() {
        //PERMESSO DI ESPORTARE I DATI DEI PROCESSI IN EXCEL
        
        for (i = 0; i < document.getElementsByName('145').length; i++) {
           document.getElementsByName('145')[i].style.display = "none";
           
        }
    }
       function disabilitaAction146() {
        //PERMESSO DI CREARE UN NUOVO MOVIMENTO DI MATERIE PRIME IN PRODUZIONE COMPOUND
        
        for (i = 0; i < document.getElementsByName('146').length; i++) {
           document.getElementsByName('146')[i].style.display = "none";
           
        }
    }

    function disabilitaAction148() {
        //PERMESSO DI EDITARE UN COLORE
        
        for (i = 0; i < document.getElementsByName('148').length; i++) {
           document.getElementsByName('148')[i].style.display = "none";
           
        }
    }
    

</script>

