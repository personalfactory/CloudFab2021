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

$updateValoreIniziale = true;

include('../include/gestione_date.php');
include('../Connessioni/serverdb.php');
include('../sql/script_valore_par_sing_mac.php');

mysql_query("BEGIN");

$updateValIniziale =  updateValoreInizialeSm(dataCorrenteInserimento(),$_SESSION['IdMacchina']); 
       

if (!$updateValIniziale) {

    mysql_query("ROLLBACK");
    echo "ATTENZIONE TRANSAZIONE NON RIUSCITA! CONTATTARE L' AMMINISTRATORE!";
} else {

    mysql_query("COMMIT");
    mysql_close();
    ?>
    <script type="text/javascript">
        location.href="modifica_valore_par_mac.php?IdMacchina=<?php echo $_SESSION['IdMacchina']; ?>"
    </script>                   

<?php }
?>
</div>
</body>
</html>