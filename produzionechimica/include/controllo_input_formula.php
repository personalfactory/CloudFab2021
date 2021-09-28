<?php

//Verifico che i parametri siano stati settati e che non siano vuoti

$messaggio = '';
if (!isset($CodiceFormula) || trim($CodiceFormula) == "") {

    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroCodice . ' ' . $msgNonValido . ' <br />';
}
if (is_numeric($CodiceFormula)) {

    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroCodice . ' ' . $msgNonValido . ' <br />';
}
if (!isset($DescriFormula) || trim($DescriFormula) == "") {

    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroDescrizione . ' ' . $msgNonValido . ' <br />';
}
if (!isset($NumeroKitSacchetti) || trim($NumeroKitSacchetti) == "") {

    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroNumKitPerLotto . ' ' . $msgNonValido . ' <br />';
}
if (!isset($NumeroLotti) || trim($NumeroLotti) == "") {

    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroNumLotti . ' ' . $msgNonValido . ' <br />';
}
//Verifica tipo di dati
if (!is_numeric($NumeroKitSacchetti)) {

    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroNumKitPerLotto . ' ' . $msgNumerico . ' <br />';
    //' - Campo  Numero di Sacchetti deve essere un numero!<br />';
}
if (!is_numeric($NumeroLotti)) {

    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroNumLotti . ' ' . $msgNumerico . ' <br />';
}

//Verifico il num di caratteri del codice prodotto
if (strlen($CodiceFormula) != 6) {
    $errore = true;
    $messaggio = $messaggio . ' - ' . $filtroCodice . ' ' . $msgErrLunghezzaCod . ' <br />';
}


if ($Pagina == "modifica_formula" || $Pagina == "modifica_formula2") {
    $sqlFor = findDescriFormlaDiversaDaCodice($CodiceFormula, $DescriFormula);


    if (mysql_num_rows($sqlFor) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste gia nel db
        $errore = true;
        $messaggio = $messaggio . ' - ' . $msgEsisteCodiceNome . '<br />';
    }
}

//############# Verifica esistenza caricamento formula ##############################
if ($Pagina == "carica_formula" || $Pagina == "carica_formula2" || $Pagina == "duplica_formula2") {

    $sqlForm = findAnFormulaByCodiceNome($CodiceFormula, $DescriFormula);

    if (mysql_num_rows($sqlForm) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste gia nel db
        $errore = true;
        $messaggio = $messaggio . ' - ' . $msgEsisteCodiceNome . '<br />';
    }
}//End if($Pagina=="carica_formula")
		
		
		
		
			
			
				
					
