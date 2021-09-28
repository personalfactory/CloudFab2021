<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">

        function disabilitaOperazioni() {

            location.href = '../permessi/avviso_permessi_visualizzazione.php'

        }

    </script>      
    <?php
    if ($DEBUG)
        ini_set(display_errors, "1");
    include('../Connessioni/serverdb.php');
    include('../include/precisione.php');
    include('../sql/script.php');
    include('../sql/script_ordine_elenco.php');
    include('../sql/script_ordine_sing_mac.php');

    //################### RICHIESTA DI CONFERMA DISABILITAZIONE ##############

    if (!isSet($_GET['Conferma'])) {

        $Tabella = $_GET['Tabella'];
        $idOrdine = $_GET['idOrdine'];
        $idOrdineSm = $_GET['idOrdineSm'];
        $RefBack = $_GET['RefBack'];
        $stato = $_GET['stato'];

        $sqlUtProp = findOrdineById($idOrdine);
        while ($row = mysql_fetch_array($sqlUtProp)) {

            $IdUtenteProp = $row['id_utente'];
            $IdAzienda = $row['id_azienda'];
        }
        //######################################################################
        //#################### GESTIONE UTENTI #################################
        //######################################################################            
        //Si recupera il proprietario del prodotto e si verifica se l'utente 
        //corrente ha il permesso di editare  i dati di quell'utente proprietario 
        //nelle tabelle prodotto
        //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
        //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
        $actionOnLoad = "";
        $arrayTabelleCoinvolte = array("ordine");
        if ($IdUtenteProp != $_SESSION['id_utente']) {
            //Se il proprietario del dato è un utente diverso dall'utente 
            //corrente si verifica il permesso 3
            echo "</br>Eseguita verifica permesso di tipo 3";
//            $permessoModifica = verificaPermessoModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp);
            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
        }

        //######################################################################
        ?>
        <body onLoad="<?php echo $actionOnLoad ?>">
            <div id="mainContainer">

                <?php include('../include/menu.php'); ?>

                <table class="table3">
                    <tr>
                        <th class="cella3"><?php echo $msgConfermaCambioStatoOrdine ?></th>
                    </tr>
                    <tr>
                        <td class="cella6">
                            <a href="javascript:history.back();"><img src="/CloudFab/images/icone/no.png" class="images2" title="<?php echo $titleNo ?>"/></a>  
                            <a id="Conferma" href="salta_ordine_sm.php?Conferma=SI&Tabella=<?php echo $Tabella ?>&idOrdine=<?php echo $idOrdine ?>&idOrdineSm=<?php echo $idOrdineSm ?>&RefBack=<?php echo $RefBack ?>&stato=<?php echo $stato ?>">
                                <img src="/CloudFab/images/icone/si.png" class="images2" title="<?php echo $titleSi ?>"/></a>
                        </td>
                    </tr>
                </table>

                <?php
                //################### DISABILITAZIONE ##################################
            } else {
                ?>
                <div id="mainContainer">
                    <?php
                    $Tabella = $_GET['Tabella'];
                    $idOrdine = $_GET['idOrdine'];
                    $idOrdineSm = $_GET['idOrdineSm'];
                    $RefBack = $_GET['RefBack'];
                    $stato = $_GET['stato'];
                    
                    if($stato==$valStatoInsOrdineOri){
                    
                       $newStato=$valStatoSaltaOrdineOri; //-1
                       $newDescriStato=$valDescriStatoSaltaOrdineOri;//SKIPPED
                    
                        
                    } else if($stato==$valStatoSaltaOrdineOri){
                        
                        $newStato=$valStatoInsOrdineOri;  //0
                        $newDescriStato=$valDescriStatoInsOrdineOri; //TO PRODUCE"
                    }
                    
                   



                    $cambiaStato = true;
                    begin();
                    $cambiaStato = modificaStatoOrdineSm($idOrdineSm, $newStato,$newDescriStato);

                    if (!$cambiaStato) {

                        rollback();
                        echo "</br>" . $msgTransazioneFallita ;
                    } else {

                        commit();
                        ?>
                        <script type="text/javascript">
                location.href = "<?php echo $RefBack ?>";
                        </script>

                        <?php
                    }
                }
                ?>

                <div id="msgLog">
                    <?php
                    if ($DEBUG) {
                        echo "</br>ActionOnLoad : " . $actionOnLoad;
                        echo "</br>Id utente prop del dato: " . $IdUtenteProp;
                        echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
                    }
                    ?>
                </div>
            </div>
    </body>
</html>
