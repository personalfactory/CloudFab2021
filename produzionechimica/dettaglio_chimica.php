<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript">
        //NOTA BENE
        //In realtà nel file /permessi/utility_permessi.php la funzione disabilitaAction91()
        //è già definita ma in maniera diversa se si vuole fare il controllo anche in questa pagina 
        //si deve ridefinire
        function disabilitaAction91() {
            //PERMESSO VISTA DETTAGLIO CHIMICA
            location.href = '../permessi/avviso_permessi_visualizzazione.php'
        }
    </script>
    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //############## GESTIONE UTENTI ###########################################
    $actionOnLoad = "";
    $elencoFunzioni = array("90","91");
    //90 : Vedere dettaglio sacco
    //91 : vedere dettaglio chimica
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_chimica.php');
            include('../sql/script_miscela.php');
            include('../sql/script_sacchetto_chimica.php');
            include('../sql/script_miscela_componente.php');
            include('../sql/script_processo.php');

//Inizializzo le variabili relative al caso miscela zero
            $IdMiscela = 0;
            $DataMiscela = "0";
            $CodiceFormula = "0";
            $Contenitore = "0";
            $PesoReale = 0;

            $CodiceChimica = $_GET['Chimica'];
            $sqlChimica = findKitByCodice($CodiceChimica);
            while ($rowChimica = mysql_fetch_array($sqlChimica)) {
                $CodiceChimica = $rowChimica['cod_chimica'];
                $CodiceProdotto = $rowChimica['cod_prodotto'];
                $Formula = $rowChimica['descri_formula'];
                $CodiceLotto = $rowChimica['cod_lotto'];
                $NumeroBolla = $rowChimica['num_bolla'];
                $DataBolla = $rowChimica['dt_bolla'];
                $Data = $rowChimica['data'];
            }

            if (mysql_num_rows($sqlChimica) > 0) {

                $sqlSacChimica = findMiscelaByCodKit($CodiceChimica);
                while ($rowSacChimica = mysql_fetch_array($sqlSacChimica)) {
                    $IdMiscela = $rowSacChimica['id_miscela'];
                }


                $sqlMiscela = findMiscelaById($IdMiscela);
                while ($rowMiscela = mysql_fetch_array($sqlMiscela)) {
                    $DataMiscela = $rowMiscela['dt_miscela'];
                    $CodiceFormula = $rowMiscela['cod_formula'];
                    $Contenitore = $rowMiscela['cod_contenitore'];
                    $PesoReale = $rowMiscela['peso_reale'];
                }
                ?>

                <div id="container" style="width:800px; margin:15px auto;">
                    <table width="100%">
                        <th class="cella3" colspan="7"><?php echo $titoloPaginaDettaglioKit ?></th>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodKit ?></td>
                            <td class="cella1"><?php echo $CodiceChimica; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFormula ?> </td>
                            <td class="cella1"><?php echo $Formula; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodProdotto ?></td>
                            <td class="cella1"><?php echo $CodiceProdotto; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodLotto ?></td>
                            <td class="cella1"><a href="dettaglio_lotto.php?Lotto=<?php echo $CodiceLotto; ?>"><?php echo $CodiceLotto; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDdt ?></td>
                            <td class="cella1"><a href="dettaglio_bolla.php?NumBolla=<?php echo $NumeroBolla; ?>&DtBolla=<?php echo $DataBolla; ?>"><?php echo $NumeroBolla; ?></a></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtDdt ?></td>
                            <td class="cella1"><?php echo $DataBolla; ?></td>
                        </tr>
                    </table>

                    <table width="100%">
                        <th class="cella3" colspan="7"><?php echo $filtroMiscela ?></th>
                        <tr>
                            <td class="cella2"><?php echo $filtroIdMiscela ?></td>
                            <td class="cella1"><?php echo $IdMiscela; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtMiscela ?> </td>
                            <td class="cella1"><?php echo $DataMiscela; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroContenitore ?></td>
                            <td class="cella1"><?php echo $Contenitore; ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPesoReale ?></td>
                            <td class="cella1"><?php echo $PesoReale . " " . $filtrogBreve ?></td>
                        </tr>
                    </table>
                    <!--<table width="100%">   
                        <tr>
                            <td class="cella3" colspan='2'><?php echo $filtroMaterieCompound ?></td>             
                            <td class="cella3"><?php echo $filtroMovMag ?></td>
                            <td class="cella3"><?php echo $filtroDt ?></td>
                            <td class="cella3"><?php echo $filtroPesoReale ?></td>
                        </tr>
                        <?php
                        $sqlMov = findMatPrimeByIdMiscela($IdMiscela);
                        $pesoTotCalcolato = 0;
                        while ($rowMov = mysql_fetch_array($sqlMov)) {
                            $CodiceMovimento = $rowMov['cod_mov'];
                            $DescriMateria = $rowMov['descri_mat'];
                            list($MateriaPrima, $Movimento, $Data) = explode('.', $CodiceMovimento);
                            $Data = substr($Data, 6) . "-" . substr($Data, 4, -2) . "-" . substr($Data, 0, -4);
                            $PesoRealeMat = $rowMov['peso_reale_mat'];
                            $pesoTotCalcolato = $pesoTotCalcolato + $PesoRealeMat;
                            ?>
                            <tr>
                                <td class="cella1"><?php echo $MateriaPrima ?></td>
                                <td class="cella1"><?php echo $DescriMateria ?></td>
                                <td class="cella1"style="text-align:center"><a href="modifica_gaz_movmag.php?IdMov=<?php echo $Movimento ?>"><?php echo $Movimento; ?></a></td>
                                <td class="cella1"><?php echo $Data; ?></td>    
                                <td class="cella1" style="text-align:right"><?php echo $PesoRealeMat . " " . $filtrogBreve; ?></td>
                            </tr>
                        <?php }//End while chimica ?>
                        <tr>
                            <td class="cella2" colspan="4"> <?php echo $filtroPesoTotaleCalc ?></td>
                            <td class="cella2" > <?php echo $pesoTotCalcolato . " " . $filtrogBreve ?></td>
                        </tr>
                    </table>-->
                    <?php
    $sqlProcessi = findProcessiByCodChimica($CodiceChimica);
    if(mysql_num_rows($sqlProcessi)>0){?>
                    <table width="100%">  
                        <tr>
                            <td class="cella3" colspan='3'><?php echo $titoloPaginaProdOri ?></td>             
                        </tr>
    <?php
    
    while ($rowProc = mysql_fetch_array($sqlProcessi)) {
        ?>
                            <tr>
                                <td class="cella1"><?php echo $rowProc['descri_stab'] ?></td>         
                                <td class="cella1"><a name="90" href="/CloudFab/produzionechimica/dettaglio_sacchetto.php?IdProcesso=<?php echo($rowProc['id_processo']) ?>&IdMacchina=<?php echo $rowProc['id_macchina'] ?>"><?php echo($rowProc['cod_sacco']) ?></a></td>
                                <td class="cella1"><?php echo $rowProc['dt_produzione_mac'] ?></td>
                            </tr>
    <?php } ?>        
                    </table>
    <?php } ?>
                    <table width="100%"> 
                    <tr>
                        <td class="cella2" ><input type="reset" onClick="javascript:history.back();" value="<?php echo $valueButtonIndietro ?>"/></td>
                    </tr>
                </table>

<?php }  else {
                            echo " <br/><br/><div style='color: #FF0000; font-size:20px' >" . $msgInfoCodiceNonTrovato . "";
                            echo "  <a href='javascript:history.back();'>" . $valueButtonIndietro . "</a></div>";
                        }
?>               


            </div>
            <div id="msgLog"><?php if ($DEBUG) echo "</br>ActionOnLoad : " . $actionOnLoad; ?></div>
        </div><!--mainContainer-->

    </body>
</html>
