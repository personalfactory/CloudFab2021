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
            include('../sql/script_valore_allarme.php');
            include('../sql/script_ciclo_processo.php');

            $_SESSION['IdMacchina']=0;
              if (isset($_GET['IdMacchina']) && isset($_GET['DescriStab'])) {
                $_SESSION['IdMacchina'] = $_GET['IdMacchina'];
                $_SESSION['DescriStab'] = $_GET['DescriStab'];
                $_SESSION['Filtro'] = $_GET['Filtro'];
            }
            
            $_SESSION['IdAllarme'] = "";
            $_SESSION['Nome'] = "";
            $_SESSION['Descrizione'] = "";
            $_SESSION['IdCiclo'] = "";
            $_SESSION['Valore'] = "";
            $_SESSION['Abilitato'] = "";
            $_SESSION['DtAbilitato'] = "";

            if (isSet($_POST['IdAllarme'])) {
                $_SESSION['IdAllarme'] = trim($_POST['IdAllarme']);
            }
            if (isSet($_POST['Nome'])) {
                $_SESSION['Nome'] = trim($_POST['Nome']);
            }
            if (isSet($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isSet($_POST['IdCiclo'])) {
                $_SESSION['IdCiclo'] = trim($_POST['IdCiclo']);
            }
            if (isSet($_POST['Valore'])) {
                $_SESSION['Valore'] = trim($_POST['Valore']);
            }
            if (isSet($_POST['Abilitato'])) {
                $_SESSION['Abilitato'] = trim($_POST['Abilitato']);
            }
            if (isSet($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #######################
            $_SESSION['Filtro'] = "v.id_allarme";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            //#######################################################################

            $sql =selectValoreAllarmeByFiltri($_SESSION['IdMacchina'],$_SESSION['IdAllarme'],$_SESSION['Nome'], $_SESSION['Descrizione'], $_SESSION['Valore'],$_SESSION['IdCiclo'],$_SESSION['Abilitato'], $_SESSION['DtAbilitato'],$_SESSION['Filtro']);


            $trovati = mysql_num_rows($sql);

            include('./moduli/visualizza_valore_allarme.php');
            ?> 

        </div>

    </body>
</html>
