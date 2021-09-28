<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function disabilitaAction92() {
            //PERMESSO VISTA DETTAGLIO LOTTO
            location.href = '../permessi/avviso_permessi_visualizzazione.php'
        }
    </script>
    <?php
    
    if ($DEBUG)
        ini_set('display_errors', 1);
    
    //############## GESTIONE UTENTI ###########################################
    $elencoFunzioni = array("91","92");
  //91 vedere dettaglio chimica    
//92 vedere dettaglio lotto
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    if ($DEBUG) {
        echo "</br>actionOnLoad :" . $actionOnLoad;
    }
    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">

        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_lotto.php');
            include('../sql/script_chimica.php');

            $CodiceLotto = $_GET['Lotto'];
            $DescriLotto='';
            $DataLotto='';
            $NumeroBolla='';
            $DataBolla='';
            
            begin();
            $sqlLotto = findLottoByCodLotto($CodiceLotto);
            $sqlChimica = findKitChimiciByCodLotto($CodiceLotto);
            commit();

            while ($rowLotto = mysql_fetch_array($sqlLotto)) {
                $DescriLotto = $rowLotto['descri_lotto'];
                $DataLotto = $rowLotto['dt_lotto'];
                $NumeroBolla = $rowLotto['num_bolla'];
                $DataBolla = $rowLotto['dt_bolla'];
                $Parent = $rowLotto['parent'];
            }
            ?>

            <div id="container" style="width:800px; margin:15px auto;">
                <form id="DettaglioBolla" name="DettaglioBolla">
                    <table width="800px">
                        <th class="cella3" colspan="7"><?php echo $titoloPaginaDettaglioLotto ?></th>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodLotto; ?></td>
                            <td class="cella1"><?php echo $CodiceLotto; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione; ?></td>
                            <td class="cella1"><?php echo $DescriLotto; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtProd; ?></td>
                            <td class="cella1"><?php echo $DataLotto; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNumDoc; ?> </td>
                            <td class="cella1"><?php echo $NumeroBolla; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroDataDoc; ?></td>
                            <td class="cella1"><?php echo $DataBolla; ?></td>
                        </tr>

                    </table>
                    <table width="800px">   
                        <th class="cella3" colspan="7" style="width:600px;"><?php echo $filtroKitAssALotto ?></th>
                        <tr>
                            <td class="cella2"><?php echo $filtroKitChim; ?></td>
                            <td class="cella2"><?php echo $filtroProdotto; ?></td>
                            <td class="cella2"><?php echo $filtroNome; ?></td>
                            <td class="cella2"><?php echo $filtroDtProd; ?></td>

                        </tr>
                        <?php
                        while ($rowChimica = mysql_fetch_array($sqlChimica)) {
                            $CodiceChimica = $rowChimica['cod_chimica'];
                            $CodiceProdotto = $rowChimica['cod_prodotto'];
                            $Formula = $rowChimica['descri_formula'];
                            $Data = $rowChimica['dt_abilitato'];
                            ?>
                            <tr>
                                <td class="cella1"><a name="91" href="dettaglio_chimica.php?Chimica=<?php echo $CodiceChimica; ?>"><?php echo $CodiceChimica; ?></a></td>
                                <td class="cella1"><?php echo $CodiceProdotto; ?></td>
                                <td class="cella1"><?php echo $Formula; ?></td>
                                <td class="cella1"><?php echo $Data; ?></td>

                            </tr>
                            <?php
                        }//End While chimica
                        ?>
                        <tr>
                        <td class="cella2" colspan="4">
                            <input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="javascript:history.back()"/></td>
                        </tr>
                    </table>
                </form>
            </div>
           <div id="msgLog"><?php if ($DEBUG) echo "</br>ActionOnLoad : " . $actionOnLoad; ?></div>
        </div><!--mainContainer-->
    </body>
</html>
