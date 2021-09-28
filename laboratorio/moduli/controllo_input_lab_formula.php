<?php
if (!isset($_POST['CodiceFormula']) || trim($_POST['CodiceFormula']) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrCodice . '<br />';
}
if (!isset($_POST['Normativa']) || trim($_POST['Normativa']) == "") {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrSelectNormativa . '<br />';
}
if (!isset($_POST['scegli_target']) OR $_POST['scegli_target'] == "") {
    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrProdOb . '<br />';
}
if (
        (!isset($_POST['NomeProdObEs']) OR $_POST['NomeProdObEs'] == "") AND
        (!isset($_POST['NomeProdObNuovo']) OR $_POST['NomeProdObNuovo'] == "")) {

    $errore = true;
    $messaggio = $messaggio . ' ' . $msgErrProdOb . '<br />';
}

?>
