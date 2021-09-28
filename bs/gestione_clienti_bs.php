<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');
        ?>
    </head>
    <script language="javascript">

    </script>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //L'elenco delle funzioni relative ad una voce-sottovoce in generale relativo ad una pagina
    //può essere recuperato dalla tabella voce_funzione di dbutente
    $elencoFunzioni = array("131");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_cliente');

    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">
 
        <div id="mainContainer">
            <?php include('../include/menu.php');
           
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_bs_cliente.php');

            $_SESSION['IdCliente'] = "";
            $_SESSION['Nominativo'] = "";
            $_SESSION['Descrizione'] = "";

            $_SESSION['Note'] = "";
            $_SESSION['DtAbilitato'] = "";

            $_SESSION['IdClienteList'] = "";
            $_SESSION['NominativoList'] = "";
            $_SESSION['DescrizioneList'] = "";

            $_SESSION['NoteList'] = "";
            $_SESSION['DtAbilitatoList'] = "";

            if (isset($_POST['IdCliente'])) {
                $_SESSION['IdCliente'] = trim($_POST['IdCliente']);
            }
            if (isset($_POST['IdClienteList']) AND $_POST['IdClienteList'] != "") {
                $_SESSION['IdCliente'] = trim($_POST['NomeProdList']);
            }
            if (isset($_POST['Nominativo'])) {
                $_SESSION['Nominativo'] = trim($_POST['Nominativo']);
            }
            if (isset($_POST['NominativoList']) AND $_POST['NominativoList'] != "") {
                $_SESSION['Nominativo'] = trim($_POST['NominativoList']);
            }
            if (isset($_POST['Descrizione'])) {
                $_SESSION['Descrizione'] = trim($_POST['Descrizione']);
            }
            if (isset($_POST['DescrizioneList']) AND $_POST['DescrizioneList'] != "") {
                $_SESSION['Descrizione'] = trim($_POST['DescrizioneList']);
            }
            if (isset($_POST['Note'])) {
                $_SESSION['Note'] = trim($_POST['Note']);
            }
            if (isset($_POST['NoteList']) AND $_POST['NoteList'] != "") {
                $_SESSION['Note'] = trim($_POST['NoteList']);
            }
            if (isset($_POST['DtAbilitato'])) {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitato']);
            }
            if (isset($_POST['DtAbilitatoList']) AND $_POST['DtAbilitatoList'] != "") {
                $_SESSION['DtAbilitato'] = trim($_POST['DtAbilitatoList']);
            }


            //########### VARIABILE DI ORDINAMENTO DELLA QUERY #################
            $_SESSION['Filtro'] = "nominativo";
            if (isset($_POST['Filtro']) AND $_POST['Filtro'] != "") {
                $_SESSION['Filtro'] = trim($_POST['Filtro']);
            }
            //##################################################################
            begin();
            $sql = findClienteBsByFiltri("id_cliente", $_SESSION['Filtro'], $_SESSION['IdCliente'], $_SESSION['Nominativo'], $_SESSION['Descrizione'], $_SESSION['Note'], $_SESSION['DtAbilitato'], $strUtentiAziende);

            $sqlId = findClienteBsByFiltri("id_cliente", "id_cliente", $_SESSION['IdCliente'], $_SESSION['Nominativo'], $_SESSION['Descrizione'], $_SESSION['Note'], $_SESSION['DtAbilitato'], $strUtentiAziende);
            $sqlNome = findClienteBsByFiltri("nominativo", "nominativo", $_SESSION['IdCliente'], $_SESSION['Nominativo'], $_SESSION['Descrizione'], $_SESSION['Note'], $_SESSION['DtAbilitato'], $strUtentiAziende);
            $sqlDescri = findClienteBsByFiltri("descrizione", "descrizione", $_SESSION['IdCliente'], $_SESSION['Nominativo'], $_SESSION['Descrizione'], $_SESSION['Note'], $_SESSION['DtAbilitato'], $strUtentiAziende);
            $sqlNote = findClienteBsByFiltri("note", "note", $_SESSION['IdCliente'], $_SESSION['Nominativo'], $_SESSION['Descrizione'], $_SESSION['Note'], $_SESSION['DtAbilitato'], $strUtentiAziende);
            $sqlDtAb = findClienteBsByFiltri("dt_abilitato", "dt_abilitato", $_SESSION['IdCliente'], $_SESSION['Nominativo'], $_SESSION['Descrizione'], $_SESSION['Note'], $_SESSION['DtAbilitato'], $strUtentiAziende);
            $trovati = mysql_num_rows($sql);
            commit();
            
            
            include('./moduli/visualizza_clienti_bs.php');
            
            ?> 
            
            <div id="msgLog">
            
                
                <?php
            if ($DEBUG) {

                echo "</br>actionOnLoad :" . $actionOnLoad;
                echo "</br>Tab bs_cliente : Utenti e aziende visibili " . $strUtentiAziende;
            }
            ?>
            </div>
        </div>
    </body>
</html>

