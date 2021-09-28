<?php

include_once('../sql/script_accessorio_formula.php');

//Quando modifico o duplico una formula ho bisogno di estrarre 
//dalla tabella accessorio_formula, singolarmente, 
//le quantità degli accessori da manipolare 
$ScatolaPerLotto = 0;
$Operatore = 0;
$EtichettaLotto = 0;
$EtichettaChimica = 0;
$SacchettoPolietilene = 0;

$sqlScatolaPerLotto = findAccessorioInFormulaByCodice($CodiceFormula, "scatLot");

while ($rowScatola = mysql_fetch_array($sqlScatolaPerLotto)) {
    $ScatolaPerLotto = $rowScatola['quantita'];
}

$sqlOperatore = findAccessorioInFormulaByCodice($CodiceFormula, "OPER");

while ($rowOperatore = mysql_fetch_array($sqlOperatore)) {
    $Operatore = $rowOperatore['quantita'];
}

$sqlEticLotto = findAccessorioInFormulaByCodice($CodiceFormula, "eticLot");

while ($rowEticLotto = mysql_fetch_array($sqlEticLotto)) {
    $EtichettaLotto = $rowEticLotto['quantita'];
}

$sqlEticCh = findAccessorioInFormulaByCodice($CodiceFormula, "eticCh");

while ($rowEticCh = mysql_fetch_array($sqlEticCh)) {
    $EtichettaChimica = $rowEticCh['quantita'];
}

$sqlSacch = findAccessorioInFormulaByCodice($CodiceFormula, "sacCh");

while ($rowSacch = mysql_fetch_array($sqlSacch)) {
    $SacchettoPolietilene = $rowSacch['quantita'];
}
?>