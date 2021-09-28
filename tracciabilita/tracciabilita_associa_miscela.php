<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body onload="document.getElementById('CodLotto').focus()">
        <div id="tracciabilitaContainer" style=" width:700px; margin:50px auto;">
            <script language="javascript">
                function VerificaMiscela() {
                    document.forms["CaricaCompound"].action = "tracciabilita_associa_miscela.php";
                    document.forms["CaricaCompound"].submit();
                }
            </script>            
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_miscela.php');
            include('../sql/script_miscela_contenitore.php');
            include('../sql/script_produzione_miscela.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_formula.php');
            include('../sql/script_lotto.php');

            $errore = false;
            $messaggio = "";

            //##################################################################     
            //####################### SCELTA CONTENITORE ####################### 
            //################################################################## 

            if (!isset($_POST['Contenitore']) || $_POST['Contenitore'] == "") {

//Inizializzo le due variabili di sessione relative        

                $_SESSION['Contenitore'] = "0";
                $_SESSION['IdMiscela'] = 0;
                $_SESSION['DataMiscela'] = "0";
                $_SESSION['CodFormula'] = "0";
                $_SESSION['DescriFormula'] = "0";
                $_SESSION['CodFormulaDescri'] = "0";
                ?>        
               

                    <form class="form" id="CaricaCompound" name="CaricaCompound" method="post" >
                        <table width="700px">
                            <tr>
                                <td class="cella22" colspan="2"><?php echo $filtroAssociaMiscela ?></td>
                            </tr>
                            <tr>
                                <td class="cella111"><?php echo $filtroContenitore ?></td>
                                <td class="cella111">
                                    <select  class="inputTracc" name="Contenitore" id="Contenitore" onchange="VerificaMiscela()" >
                                        <option  value="0" selected=""><?php echo $labelOptionSelectContenitore ?></option>
                                        <?php
                                        //Viene data la possibilità di scelta tra i contenitori impegnati
                                        $sqlContenitore = selectContenitoreByStato("0");
                                        while ($rowContenitore = mysql_fetch_array($sqlContenitore)) {
                                            ?>
                                            <option value="<?php echo($rowContenitore['cod_contenitore']) ?>" size="40"><?php echo("Contenitore " . $rowContenitore['cod_contenitore']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                

                <?php
            } else if (isset($_POST['Contenitore']) AND $_POST['Contenitore'] != "") {
                //INIZIALIZZAZIONE VARIABILI
                $IdMiscela = 0;
                $DataMiscela = "0";
                $CodFormula = "0";
                $DescriFormula = "0";
                $CodFormulaDescri = "0";
                $NumLottiTot = 0;
                $NumCodiciChimicaTot = 0;
                $PesoLotto = 0;

                $Contenitore = $_POST['Contenitore'];

                $sqlMiscela = selectProdMiscelaByContenitore($Contenitore);

                //##########################################################################
                //############ CONTROLLO ESISTENZA MISCELA #################################
                //##########################################################################

                if (mysql_num_rows($sqlMiscela) == 0) {
                    //Se entro nell'if vuol dire che la miscela non esiste
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrMiscelaNotAssCont . ' <br />';
                }

                //Recupero i dati della miscela 
                while ($rowMiscela = mysql_fetch_array($sqlMiscela)) {
                    $IdMiscela = $rowMiscela['id_miscela'];
                    $DataMiscela = $rowMiscela['dt_miscela'];
                    $CodFormula = $rowMiscela['cod_formula'];
                    $DescriFormula = $rowMiscela['descri_formula'];
                    $CodFormulaDescri = $CodFormula . ":" . $DescriFormula;
                }


                //##########################################################################
                //############ RECUPERO IL PESO DELLA MISCELA ##############################
                //##########################################################################

                $sqlPesoMis = findMiscelaById($IdMiscela);

                //Controllo esistenza
                if (mysql_num_rows($sqlPesoMis) == 0) {
                    $errore = true;
                    $messaggio = $messaggio . " ".$msgErrPesoNonTrovato.' <br />';
                }
                while ($rowPesoMis = mysql_fetch_array($sqlPesoMis)) {
                    $pesoRealeMis = $rowPesoMis['peso_reale'];
                }

                if ($errore) {
                    echo $messaggio;
                } else {


                    //######################################################################
                    //Nuovo movimento nella tabella gaz_movmag e associazione della miscela 

                    $DtMovimento = dataCorrenteInserimento();
                    $Operazione = $valOperazioneIn;
                    $Causale = $valCaricoPerLav;
                    $TipoDoc = $valTipDocProMix;
                    $NumDoc = $IdMiscela;
                    $DesDoc = $valDesDocProCompound;
                    $DtDoc = $DataMiscela;
                    $Clfoco = $valClfocoPF;
                    $Artico = "C-" . substr($CodFormula, 1);
                    $DescriArtico = $DescriFormula; //dovrebbe essere presa dalla tab materia_prima
                    $catMer = $valCatMerMatPrime;
                    $Quantita = $pesoRealeMis/1000;
                    $Prezzo = 0;
                    $Fornitore = $valFornitoreLotti;
                    $CodArticoForn = $CodFormula;
                    $valUniMisKg = $valUniMisPz;
                    $DtArrivoMerce = dataCorrenteInserimento();
                    $MerceConforme = $valConforme;
                    $StabilitaConforme = $valConforme;
                    $ProceduraAdottata = $valProceduraAdotCompound;
                    $Operatore = $_SESSION['nominativo_utente']; ///?
                    $RespProduzione = ""; //?
                    $RespQualita = ""; //?
                    $ConsTecnico = ""; //?
                    $Note = ""; //?
                    $destNomeFileDdt = ""; //?
                    $NumOrdine = $valDefaultNumOrdine;
                    $DtOrdine = $valDefaultDtOrdine;
                    
                    //Calcola costo della miscela solo di materie prime
                    $costoMaterie=0;
                    $sqlFormula=findMateriePriFormulaByCod($CodFormula,"m.cod_mat");
                    while ($rowFormula = mysql_fetch_array($sqlFormula)) {
                        $costoMaterie=$costoMaterie+($rowFormula['quantita']*$rowFormula['pre_acq'])/1000;
                    }
                    
                    
                    //Inserisco il nuovo movimento dentro la tabella gaz_movmag
                    $InsertGazieMovMag = inserisciMovimento($DtMovimento, $Operazione, $Causale, $TipoDoc, $NumDoc, $DesDoc, $DtDoc, $Clfoco, $Artico, $DescriArtico, $valCatMerMatPrime, $Quantita, $costoMaterie, $Fornitore, $CodArticoForn, $valUniMisKg, $DtArrivoMerce, $MerceConforme, $StabilitaConforme, $ProceduraAdottata, $Operatore, $RespProduzione, $RespQualita, $ConsTecnico, $Note, $destNomeFileDdt, $NumOrdine, $DtOrdine);


                    //Svuota produzione_miscela
                    $resultDeleteFromProdMiscela = deleteProdMiscelaById($IdMiscela);

                    //Sblocca contenitore
                    $resultSbloccaContenitore = updateContenitore("1", $Contenitore);


//                    //Inserisco il nuovo codice movimento dentro mov_magazzino
//                    $_SESSION['Contenitore'] = $Contenitore;
//                    $_SESSION['IdMiscela'] = $IdMiscela;
//                    $_SESSION['DataMiscela'] = $DataMiscela;
//                    $_SESSION['CodFormula'] = $CodFormula;
//                    $_SESSION['DescriFormula'] = $DescriFormula;
//                    $_SESSION['CodFormulaDescri'] = $CodFormulaDescri;
//                    $_SESSION['PesoLotto'] = $PesoLotto;



                    if (!$InsertGazieMovMag || !$resultDeleteFromProdMiscela || !$resultSbloccaContenitore) {

                        rollback();
                        echo $msgErroreVerificato . " " . $msgErrContactAdmin;
                        echo "</br>erroreResult : " . $erroreResult;
                        echo "</br>resultInsertLottoServerdb : " . $resultInsertLottoServerdb;
                        echo "</br>InsertGazieMovMag : " . $InsertGazieMovMag;
                        echo "</br>resultAggLotto : " . $resultAggLotto;
                    
                        
                    } else {
                        
                        $sqlLastId=findLastIdMov();
                        $row = mysql_fetch_array($sqlLastId);
                        $idMov=$row[0];
                        
                        commit();
                                               
                        echo $filtroNuovoMovInserito." ".$idMov."<br/> ".$filtroStampaCodice;
                        ?>
            <a target="_blanK" href="../produzionechimica/genera_cod_mov.php?IdMov=<?php echo $idMov ?>&CodMat=<?php echo $Artico ?>&DtDoc=<?php echo substr($DtDoc,0,10) ?>&NomeMat=<?php echo $DescriArtico?>">
            <img src="/CloudFab/images/pittogrammi/stampa_G.png" class="icone"  title="<?php echo $titleGeneraCodiceMov ?>"/></a>
            <?php
                    }
                }
            }
            ?>
        </div>
          </body>
</html>

