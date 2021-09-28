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
    include('../sql/script_prodotto.php');
    include('../sql/script_anagrafe_prodotto.php');
    //################### RICHIESTA DI CONFERMA DISABILITAZIONE ##############

    if (!isSet($_GET['Conferma'])) {

        $Tabella = $_GET['Tabella'];
        $IdProdotto = $_GET['IdProdotto'];
        $RefBack = $_GET['RefBack'];

        $sqlUtProp = findProdottoById($IdProdotto);
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
        $arrayTabelleCoinvolte = array("prodotto", );
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
                        <th class="cella3"><?php echo $msgConfermaDisabilitazione ?></th>
                    </tr>
                    <tr>
                        <td class="cella6">
                            <a href="javascript:history.back();"><img src="/CloudFab/images/icone/no.png" class="images2" title="<?php echo $titleNo ?>"/></a>  
                            <a id="Conferma" href="disabilita_prodotto.php?Conferma=SI&Tabella=<?php echo $Tabella ?>&IdProdotto=<?php echo $IdProdotto ?>&RefBack=<?php echo $RefBack ?>">
                                <img src="/CloudFab/images/icone/si.png" class="images2" title="<?php echo $titleSi ?>"/></a>
                        </td>
                    </tr>
                </table>
           
            <?php
            //################### DISABILITAZIONE ##################################
        } else {?>
 <div id="mainContainer">
     <?php
            $Tabella = $_GET['Tabella'];
            $IdProdotto = $_GET['IdProdotto'];
            $RefBack = $_GET['RefBack'];

            //Disabilito il prodotto nella tabella anagrafe_prodotto 
//        $sql = mysql_query("UPDATE " . $Tabella . " SET abilitato=0 WHERE id_prodotto=" . $IdProdotto)
//                or die("ERRORE 2 : UPDATE serverdb." . $Tabella . "" . mysql_error());
            $disabilita = true;
            begin();
            $disabilita = modificaAbilitatoAnProd($IdProdotto, $valDisabilitato);
            if (!$disabilita) {

                rollback();
                echo "</br>" . $msgTransazioneFallita;
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
            }?>
        </div>
        </div>
    </body>
</html>
