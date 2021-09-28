<?php

//Verifico che i parametri siano stati settati e che non siano vuoti

$messaggio = '';
if (!isset($CodiceProdotto) || trim($CodiceProdotto) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
}
if (!isset($NomeProdotto) || trim($NomeProdotto) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErroreNome . '<br />';
}

if (!isset($LimiteColore) || trim($LimiteColore) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrLimiteColore . '<br />';
}
if (!isset($FattoreDivisore) || trim($FattoreDivisore) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrFattoreDiv . '<br />';
}
if (!isset($Fascia) || trim($Fascia) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrFascia . '<br />';
}
if (!isset($PostMazzetta) || trim($PostMazzetta) == "" || trim($PostMazzetta) == "0") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrMazzetta . '<br />';
}

if (isset($PostMazzetta) && $PostMazzetta != "") {
    list($Mazzetta, $NomeMazzetta) = explode(';', $PostMazzetta);
}

//Verifica tipo di dati
if (!is_numeric($LimiteColore)) {

    $errore = true;
    $messaggio = $messaggio . ' ' . $filtroLimColore . ' ' . $msgErrQtaNumerica . '<br />';
}
if (!is_numeric($FattoreDivisore)) {

    $errore = true;
    $messaggio = $messaggio . ' ' . $filtroFattoreDivisore . ' ' . $msgErrQtaNumerica . '<br />';
}
if (!is_numeric($Fascia)) {

    $errore = true;
    $messaggio = $messaggio . ' ' . $filtroFascia . ' ' . $msgErrQtaNumerica . '<br />';
}


//IMPOSTO I VALORI DI DEFAULT PER I PRODOTTI NON COLORATI
$LimiteColore = $DefaultLimiteColore;
$FattoreDivisore = $DefaultFattoreDivisore;
$Fascia = $DefaultFascia;


if (!isset($TipoRiferimento) || trim($TipoRiferimento) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrTipoRif . '<br />';
}
if (!isset($Geografico) || trim($Geografico) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $filtroGeografico . ' ' . $msgNonValido . '<br />';
}
if (!isset($Gruppo) || trim($Gruppo) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $filtroGruppoAcquisto . ' ' . $msgNonValido . '<br />';
}
if (!isset($LivelloGruppo) || trim($LivelloGruppo) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrLivGruppo . '<br />';
}
if (!isset($_POST['Categoria']) || trim($_POST['Categoria']) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrCategoria . '<br />';
    $_POST['Categoria'] = "1;Errore";
}

//Verifico il num di caratteri del codice prodotto
if (strlen($CodiceProdotto) != 5) {
    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrLunghezzaCodProd . '<br />';
}

//##########################################################################
//############ CARICA PRODOTTO VERIFICA ESISTENZA ##########################
//##########################################################################

if ($Pagina == "carica_prodotto" || $Pagina == "carica_prodotto2" || $Pagina == "duplica_prodotto2") {
    
    $result=  findProdottoByCodiceNome($CodiceProdotto,$NomeProdotto);
 
    if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste già nel db
        $errore = true;
        $messaggio = $messaggio . ' ' . $msgEsisteCodiceNome . '<br />';
    }
    
    
     if (!isset($IdProdottoPadre) || trim($IdProdottoPadre) == "") {

        $errore = true;
        $messaggio = $messaggio .' '. $filtroProdPadre .' '.$msgNonValido.'<br />';
    }
}//End if($Pagina=="carica_prodotto")
//##########################################################################
//############ MODIFICA PRODOTTO VERIFICA ESISTENZA ########################
//##########################################################################

if ($Pagina == "modifica_prodotto" || $Pagina == "modifica_prodotto2") {
    
    $result=findProdottoDiversoDaId($IdProdotto,$CodiceProdotto,$NomeProdotto);
//    $query = "SELECT * FROM serverdb.prodotto
//                    WHERE
//                      cod_prodotto = '" . $CodiceProdotto . "'
//                    AND
//                      id_prodotto<>" . $IdProdotto;
//
//    $result = mysql_query($query) or die("ERRORE 2 SELECT FROM serverdb.prodotto : " . mysql_error());

    if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste nel db
        $errore = true;
        $messaggio = $messaggio . ' ' . $msgEsisteCodiceNome . '<br />';
    }

    if (!isset($CodProdottoPadre) || trim($CodProdottoPadre) == "") {

        $errore = true;
        $messaggio = $messaggio.' '. $filtroProdPadre .' '.$msgNonValido.'<br />';
    }

    //Recupero l'id del codice prodotto padre
    $sqlIdProdPadre = findProdottoByCodice($CodProdottoPadre);
//            mysql_query("SELECT id_prodotto FROM serverdb.prodotto WHERE cod_prodotto='" . $CodProdottoPadre . "'")
//            or die("Errore 3 : FROM serverdb.prodotto " . mysql_error());

    while ($rowProdPadre = mysql_fetch_array($sqlIdProdPadre)) {
        $IdProdottoPadre = $rowProdPadre['id_prodotto'];
    }

    if (mysql_num_rows($sqlIdProdPadre) == 0) {
        $errore = true;
        $messaggio = $messaggio .' '. $filtroProdPadre .' '.$msgNonValido.'<br />';
    }
}//End if($Pagina=="modifica_prodotto")
			
			
				
					
