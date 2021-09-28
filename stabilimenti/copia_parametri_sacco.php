
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>        
        <div id="mainContainer">
            <?php
            include('../include/menu.php');

$IdCategoria = $_POST['IdCategoria'];
$NumSacchetti = $_POST['NumSacchetti'];
$SaccoOrigine = $_POST['SaccoOrigine'];
$SaccoDestinazione = $_POST['SaccoDestinazione'];
//echo "Id cat : " . $IdCategoria ;
//echo "<br />Num sacchetti : " . $NumSacchetti;
//echo "<br />Sacco origine : " . $SaccoOrigine ;
//echo "<br />sacco destinazione : " . $SaccoDestinazione;

include('../Connessioni/storico.php');
include('../Connessioni/serverdb.php');
include('../sql/script.php');
include('../sql/script_valore_par_sacchetto.php');

$erroreResult = false;
$updataValoreSacco = true;
$storicizzoValore = true;

begin();

//Select id_num_sac
$sqlSaccoOrigine = selectValoriSaccoBySoluzioneCat($IdCategoria, $NumSacchetti, $SaccoOrigine);
while ($row = mysql_fetch_array($sqlSaccoOrigine)) {

    //Storicizzo sacco destinazione prima di modificarlo   
    $storicizzoValore = storicizzaValoreParSac($row['id_val_par_sac']);



    //Update sacco destinazione
    $updataValoreSacco = updateServerdbValoriSacco($IdCategoria, $NumSacchetti, $row['id_par_sac'], $SaccoDestinazione, $row['valore_variabile']);
    if (!$updataValoreSacco OR ! $storicizzoValore)
        $erroreResult = true;
}

if ($erroreResult) {

    rollback();

    echo $msgTransazioneFallita . "! " . $msgErrContattareAdmin . ' <a href="/CloudFab/stabilimenti/manage_val_par_sacco.php?IdCategoria=' . $IdCategoria . '&NumSacchetti=' . $NumSacchetti . '">' . $msgOk . '</a><br/>';
    echo "</br>erroreResult : " . $erroreResult;
} else {

    commit();
    mysql_close();
    
    echo "<br />Sono stati copiati i valori dei parametri del sacco " . $SaccoOrigine ." nel sacco ".$SaccoDestinazione."<br /><br />";
    
    echo $msgModificaCompletata . ' <a href="/CloudFab/stabilimenti/manage_val_par_sacco.php?IdCategoria=' . $IdCategoria . '&NumSacchetti=' . $NumSacchetti . '">' . $msgOk . '</a><br/>';
}
?>

            </div>
    </body></html>