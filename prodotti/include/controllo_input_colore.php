<?php

//Verifico che i parametri siano stati settati e che non siano vuoti

$messaggio = '';

if (!isset($NomeProdotto) || trim($NomeProdotto) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErroreNome . '<br />';
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

 if (!isset($_POST['SerieEs']) AND ! isset($_POST['SerieNu'])) {

    $errore = true;
    //TODO: messaggio di errore serie colore
    $messaggio = $messaggio . ' ' . $msgErrSerieColore . '<br />';
    
}
$CodiceProdotto=$_SESSION['CodiceProdotto'];
//Verifico il num di caratteri del codice prodotto
if (strlen($CodiceProdotto) != 5) { 
    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrLunghezzaCodProd . '<br />';
}

//##########################################################################
//############ CARICA PRODOTTO VERIFICA ESISTENZA ##########################
//##########################################################################
if ($Pagina == "carica_colore_new" || $Pagina == "carica_colore_new2") {
    
    $result=  findProdottoByCodiceNome($CodiceProdotto,$NomeProdotto);
 
    if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste già nel db
        //TODO: messaggio di errore esistenza prodotto
        $errore = true;
        $messaggio = $messaggio . ' ' . $msgEsisteCodiceNome . '<br />';
    }
    
}
//##########################################################################
//############ MODIFICA PRODOTTO VERIFICA ESISTENZA ########################
//##########################################################################

if ($Pagina == "modifica_colore_new" || $Pagina == "modifica_colore_new2") {
    
    $result=findProdottoDiversoDaId($IdProdotto,$CodiceProdotto,$NomeProdotto);

    if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste nel db
        $errore = true;
        $messaggio = $messaggio . ' ' . $msgEsisteCodiceNome . '<br />';
    }

    
   
}//End if($Pagina=="modifica_colore_new")
			
			
				
					
