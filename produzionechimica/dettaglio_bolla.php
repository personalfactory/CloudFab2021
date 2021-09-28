<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        function disabilitaAction93() {
            //PERMESSO VISTA DETTAGLIO BOLLA
            location.href = '../permessi/avviso_permessi_visualizzazione.php'
        }
    </script>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //############## GESTIONE UTENTI ###########################################
    $elencoFunzioni = array("93");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);


    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../include/precisione.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_chimica.php');
            ?>
            <div id="container" style="width:70%; margin:15px auto;">
                <form id="DettaglioBolla" name="DettaglioBolla">
                    <?php
                    $arrayProd = array();
                    $j = 0;

                    $NumBolla = $_GET['NumBolla'];
                    $DtBolla = $_GET['DtBolla'];
                    begin();
                    $sqlBolla = findMovLottoAssociati($NumBolla, $DtBolla, 'cod_lotto');

                    if (mysql_num_rows($sqlBolla) > 0) {

                        while ($rowBolla = mysql_fetch_array($sqlBolla)) {

                            $DescriBolla = $rowBolla['des_doc'];
                            $CodiceStabilimento = $rowBolla['clfoco'];
                            $DescriStab = $rowBolla['descri_stab'];
                            $Articolo = $rowBolla['artico'];
                            $DescriArticolo = $rowBolla['descri_artico'];
                            $Quantita = $rowBolla['quanti'];
                            $UniMis = $rowBolla['uni_mis'];
                            $Note = $rowBolla['note'];
                            $DocLink = $rowBolla['doc_link'];
                            $DocLinkCompleto = "";
                            if ($DocLink != "")
                                $DocLinkCompleto = $DocLink . $estFileDdt;
                            $NumOrdine = $rowBolla['num_ordine'];
                            $DtOrdine = $rowBolla['dt_ordine'];
                            $DtAbilitato = $rowBolla['dt_abilitato'];

                            $arrayProd['codice'][$j] = $Articolo;
                            $arrayProd['descri'][$j] = $DescriArticolo;
                            $arrayProd['quantita'][$j] = $Quantita;
                            $j++;
                        }
                        commit();
                        ?>

                        <table width="100%">
                            <th class="cella3" colspan="2"><?php echo $titoloPaginaDettaglioBolla ?></th>
                            <tr>
                                <td class="cella2" width="300px"><?php echo $filtroMovimento; ?> </td>
                                <td class="cella1"><?php echo $DescriBolla; ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNumDoc; ?></td>
                                <td class="cella1"><?php echo $NumBolla; ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroDataDoc; ?> </td>
                                <td class="cella1"><?php echo $DtBolla; ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroStabilimento; ?> </td>
                                <td class="cella1"><?php echo $DescriStab; ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroCodice; ?></td>
                                <td class="cella1"><?php echo $CodiceStabilimento; ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDocLink ?> </td>
                                <td class="cella1" colspan="2"><a target="_blank" href="<?php echo $sourceDdtDownloadDir . $DocLink . $estFileDdt ?>"><?php echo $DocLinkCompleto ?></a></td>
                            </tr>
                        </table>

<?php }
$sqlProd = findMovLottoAssociati($NumBolla, $DtBolla, 'artico');
?>
                    <table width="100%">
                        <tr>
                            <td class="cella3"><?php echo $filtroCodProdotto ?></td>
                            <td class="cella3"><?php echo $filtroProdotto ?></td> 
                            <td class="cella3"><?php echo $filtroNumLotti ?></td>
                            <td class="cella3"><?php echo $filtroNumKitInLotto ?></td>
                            <td class="cella3"><?php echo $filtroNumKit ?></td>
                        </tr>
<?php

while ($rowProd = mysql_fetch_array($sqlProd)) {
    $numKitInLotto = 0; 
    $numKit=0;
    //###############Conto i codici dei kit associati al lotto #################
    $CodiceLotto="";
    
    if (mysql_num_rows($sqlBolla) > 0)
    mysql_data_seek($sqlBolla, 0);
    $sqlLotto=findMovByDdtArtico($NumBolla, $DtBolla,$rowProd['artico']);
    while ($rowLotto = mysql_fetch_array($sqlLotto)) {
         $CodiceLotto = $rowLotto['cod_lotto'];
    }
    
    $sqlTotKit = findKitChimiciByCodLotto($CodiceLotto);
    $numKitInLotto= mysql_num_rows($sqlTotKit);    
    //##########################################################################
   
    ?>
                            <tr>
                                <td class="cella1" ><?php echo $rowProd['artico'] ?></td>       
                                <td class="cella1"><?php echo $rowProd['descri_artico'] ?></td>      
                                <td class="cella1" style="text-align: center"><?php echo $rowProd['quanti'] . ' ' . $UniMis ?></td>
                                <td class="cella1" style="text-align: center"><?php echo $numKitInLotto . ' ' . $UniMis ?></td>
                                <td class="cella1" style="text-align: center"><?php echo $numKitInLotto*$rowProd['quanti'] . ' ' . $UniMis ?></td>
                            </tr>
<?php } ?>
                    </table>
                    
                    
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="4"><?php echo $filtroDettCodiciScatole ?></td> 
                        </tr>
<?php
if (mysql_num_rows($sqlBolla) > 0)
    mysql_data_seek($sqlBolla, 0);

while ($rowBolla = mysql_fetch_array($sqlBolla)) {

    $Articolo = $rowBolla['artico'];
    $DescriArticolo = $rowBolla['descri_artico'];
    $QuantitaTot = $rowBolla['quanti'];
    $Quantita = 1;
    $UniMis = $rowBolla['uni_mis'];
    $CodiceLotto = $rowBolla['cod_lotto'];
        
        
    
    
    
    ?>
                            <tr>
                                <td class="cella1"><?php echo $Articolo; ?></td>       
                                <td class="cella1"><?php echo $DescriArticolo; ?></td>      
                                <td class="cella1"><?php echo $Quantita . ' ' . $UniMis ?></td>
                                <td class="cella1"><a href="dettaglio_lotto.php?Lotto=<?php echo $CodiceLotto ?>"><?php echo $CodiceLotto; ?></a></td>
                            </tr>
<?php }
?>
                        <tr>
                            <td class="cella2" colspan="4">
                                <input type="reset" onClick="javascript:history.back();" value="<?php echo $valueButtonIndietro ?>"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="msgLog"><?php if ($DEBUG) echo "</br>ActionOnLoad : " . $actionOnLoad; ?></div>
        </div><!--mainContainer-->
    </body>
</html>
