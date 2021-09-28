<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>

    <?php
    include('../Connessioni/serverdb.php');
    include('../sql/script.php');
    include('../sql/script_aggiornamento.php');

    //################### RICHIESTA DI CONFERMA ELIMINAZIONE ##############
    if (!isSet($_GET['Conferma'])) {

        
        $IdRecord = $_GET['IdRecord'];
        $RefBack = $_GET['RefBack'];
        $NomeFile=$_GET['NomeFile'];


        //######################################################################
        //#################### GESTIONE UTENTI #################################
        //######################################################################            
        //Si recupera il proprietario del prodotto e si verifica se l'utente 
        //corrente ha il permesso di editare  i dati di quell'utente proprietario 
        //nelle tabella
        //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
        //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
        $actionOnLoad = "";
//        $arrayTabelleCoinvolte = array($Tabella);
//        if ($IdUtenteProp != $_SESSION['id_utente']) {
//            //Se il proprietario del dato è un utente diverso dall'utente 
//            //corrente si verifica il permesso 3
//            echo "</br>Eseguita verifica permesso di tipo 3";
////            $permessoModifica = verificaPermessoModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp);
//            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
//        }
        //######################################################################
        
        ?>
        <body onLoad="<?php echo $actionOnLoad ?>">
            <div id="mainContainer">
                <div id="container" style="width:80%; margin:50px auto;">
    <?php include('../include/menu.php'); ?>
                <table class="table3" >
                    <tr>
                        <th class="cella3" style="font-size: 20px"><?php echo "Eliminare il file ".$NomeFile." ?" ?></th>
                    </tr>
                    <tr>
                        <td class="cella6">
                            <a href="javascript:history.back();">
                                <img src="/CloudFab/images/icone/no.png" class="images2" /></a>  
                            <a href="elimina_file_tabella.php?Conferma=SI&IdRecord=<?php echo $IdRecord ?>&RefBack=<?php echo $RefBack ?>&NomeFile=<?php echo $NomeFile ?>">
                                <img src="/CloudFab/images/icone/si.png" class="images2" /></a>
                        </td>
                    </tr>
                    <tr><td class="cella6"><?php echo $msgInfoEliminaFileTab?> </td></tr>
                </table>
                </div> 

    <?php
    //################### ELIMINAZIONE ##################################
} else {

    
    $IdRecord = $_GET['IdRecord'];
    $RefBack = $_GET['RefBack'];
    $NomeFile = $_GET['NomeFile'];

    $delete = true;

    //Attenzione verificare ke se l'id è un intero la query non dia errore
    begin();

    $delete = deleteAggiornamentoById($IdRecord);

    if (!$delete) {

        rollback();
        echo "</br>" . $msgTransazioneFallita;
    } else {

        commit();
        ?>

                    <script type="text/javascript">
                        location.href = "<?php echo $RefBack ?>";
                    </script>

    <?php }
} ?>

        </div>
    </body>
</html>

