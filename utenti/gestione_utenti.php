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
    include('../Connessioni/serverdb.php');
        
        $_SESSION['IdUtenteTab'] = "";
        $_SESSION['Gruppo'] = "";
        $_SESSION['Tipo'] = "";
        $_SESSION['Cognome'] = "";
        $_SESSION['Nome'] = "";
        $_SESSION['Username'] = "";
        $_SESSION['Accessi'] = "";
        $_SESSION['UltimoAccesso'] = "";
        $_SESSION['Abilitato'] = "";
        $_SESSION['DtAbilitato'] = "";
	
         if (isset($_POST['IdUtenteTab'])) {
            $_SESSION['IdUtenteTab'] = trim($_POST['IdUtenteTab']);
        }
        if (isset($_POST['Gruppo'])) {
            $_SESSION['Gruppo'] = trim($_POST['Gruppo']);
        }
        if (isset($_POST['Tipo'])) {
            $_SESSION['Tipo'] = trim($_POST['Tipo']);
        }
        if (isset($_POST['Cognome'])) {
            $_SESSION['Cognome'] = trim($_POST['Cognome']);
        }
        if (isset($_POST['Nome'])) {
            $_SESSION['Nome'] = trim($_POST['Nome']);
        }
        if (isset($_POST['Username'])) {
            $_SESSION['Username'] = trim($_POST['Username']);
        }
        if (isset($_POST['Accessi'])) {
            $_SESSION['Accessi'] = trim($_POST['Accessi']);
        }
        if (isset($_POST['UltimoAccesso'])) {
            $_SESSION['UltimoAccesso'] = trim($_POST['UltimoAccesso']);
        }
        if (isset($_POST['Abilitato'])) {
            $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
        }
        if (isset($_POST['DtAbilitato'])) {
            $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
        }
        //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
        $_SESSION['Filtro'] = "id_utente";
        if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
            $_SESSION['Filtro'] = trim($_POST['Filtro']);
        }

//########################################################################
        
    $sql = findUtentiByFiltri($_SESSION['IdUtenteTab'],$_SESSION['Cognome'],$_SESSION['Nome'],$_SESSION['Gruppo'],$_SESSION['Tipo'],$_SESSION['Username'],$_SESSION['Abilitato'],$_SESSION['DtAbilitato'],$_SESSION['Accessi'],$_SESSION['UltimoAccesso'],$_SESSION['Filtro']);

    
    include('./moduli/visualizza_utenti.php');?>

</div>

</body>
</html>
