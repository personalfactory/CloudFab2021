<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>

    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);

//############## GESTIONE UTENTI ###########################################
    $elencoFunzioni = array("91", "92", "93", "3", "127");

    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');


    //##########################################################################
    ?>    
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_processo.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_formula.php');
            include('../sql/script_chimica.php');
            include('../sql/script_miscela.php');
            include('../sql/script_miscela_componente.php');
            include('../sql/script_componente.php');
            include('../sql/script_figura.php');
            include('../sql/script_componente_controllo.php');
            include('../sql/script_ciclo.php');
            include('../sql/script_movimento_sing_mac.php');



            $CodiceSacco = "";
            $CodiceStabilimento = "";
            $DataProduzione = "";
            $CodiceChimica = "";
            $CodiceProdotto = "";
            $CodiceFormula = "";
            $DescriFormula = "";
            $DataFormula = "";
            $CodiceColore = "";
            $CodiceComponentiPeso = "";
            $CodIngressoComp = "";
            $CodCompIn = "";
            $CodOperatore = "0";
            $NominativoOper = "";
            $TipoProcesso = "";
            $Cliente = "";
            $IdMiscela = "";
            $DataMiscela = "";
            $PesoRealeMiscela = "";
            $Contenitore = "";
            $CodiceLotto = "";
            $DescriLotto = "";
            $DataLotto = "";
            $DataLottoChimica = "";
            $NumeroBolla = "";
            $DataBolla = "";
            $PesoRealeSacco = "0";
            $DescriComp = "";
            $QtaComp = "0";
            $DataAbilitatoFormula = "";

            //############# STRINGA UTENTI-AZIENDE VISIBILI ####################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');

            //####################### PROCESSO #################################           
            //Si effettua una ricerca del codice sacco solo fra i processi delle macchine visibili all'utente
//            $sqlProcesso = findProcessoByCodSaccoVis($CodiceSacco, $strUtentiAziende);

            if (isSet($_GET['IdProcesso']) AND isSet($_GET['IdMacchina'])) {
                $IdProcesso = $_GET['IdProcesso'];
                $IdMacchina = $_GET['IdMacchina'];

                $sqlProcesso = findProcessoByIdProcMacVis($IdProcesso, $IdMacchina, $strUtentiAziende);
            } else if (isSet($_GET['Sacco'])) {

                $CodiceSacco = $_GET['Sacco'];
                $sqlProcesso = findProcessoByCodSaccoVis($CodiceSacco, $strUtentiAziende);
            }


            if (mysql_num_rows($sqlProcesso) > 0) {

                while ($rowProc = mysql_fetch_array($sqlProcesso)) {

                    $IdProcesso = $rowProc['id_processo'];
                    $IdMacchina = $rowProc['id_macchina'];
                    $CodiceStabilimento = $rowProc['cod_stab'];
                    $DescriStabilimento = $rowProc['descri_stab'];
                    $DataProduzione = $rowProc['dt_produzione_mac'];
                    $CodiceChimica = $rowProc['cod_chimica'];
                    $CodiceProdotto = $rowProc['cod_prodotto'];
                    $CodiceFormula = "K" . substr($CodiceChimica, 1, 5);
                    $CodiceColore = $rowProc['cod_colore'];
                    $CodiceComponentiPeso = $rowProc['cod_comp_peso'];
                    $CodCompIn = $rowProc['cod_comp_in'];
                    $CodOperatore = $rowProc['cod_operatore'];
                    $TipoProcesso = $rowProc['tipo_processo'];
                    $Cliente = $rowProc['cliente'];
                    $PesoRealeSacco = $rowProc['peso_reale_sacco'];
                    $CodiceSacco = $rowProc['cod_sacco'];
                    //TEST }
                    //####################### PRODOTTO #################################

                    $sqlProdotto = findProdottoByCodice($CodiceProdotto);
                    while ($rowProdotto = mysql_fetch_array($sqlProdotto)) {
                        $IdProdotto = $rowProdotto['id_prodotto'];
                        $NomeProdotto = $rowProdotto['nome_prodotto'];
                    }
                    //####################### FORMULA ##################################

                    $sqlFormula = findAnFormulaByCodice($CodiceFormula);
                    while ($rowFormula = mysql_fetch_array($sqlFormula)) {

                        $DescriFormula = $rowFormula['descri_formula'];
                        $DataFormula = $rowFormula['dt_formula'];
                        $DataAbilitatoFormula = $rowFormula['dt_abilitato'];
                    }

                    //####################### CHIMICA ##################################

                    $sqlChimica = findChimicaLottoByCodChimica($CodiceChimica);
                    while ($rowChimica = mysql_fetch_array($sqlChimica)) {

                        $DescriFormula = $rowChimica['descri_formula'];
                        $CodiceLotto = $rowChimica['cod_lotto'];
                        $DescriLotto = $rowChimica['descri_lotto'];
                        $DataLotto = $rowChimica['dt_lotto'];
                        $DataLottoChimica = $rowChimica['dt_abilitato'];
                        $NumeroBolla = $rowChimica['num_bolla'];
                        $DataBolla = $rowChimica['dt_bolla'];
                    }

                    //######################### MISCELA ##############################


                    $dtAggiornamento = "";
                    $idCiclo = "";
                    $tipoCiclo = "";
                    $dtInizioCiclo = "";
                    $dtFineCiclo = "";
                    $idOrdine = "";
                    $idCat = "";
                    $velMix = "";
                    $tempoMix = "";
                    $numSacchi = "";
                    $numSacchiAgg = "";
                    $vibroAttivo = "";
                    $ariaCondScarico = "";
                    $ariaInternoValvola = "";
                    $ariaPulisciValvola = "";
                    $dtInizioProcesso = "";
                    $dtFineProcesso = "";


                    $sqlCiclo = findInfoCicloByIdProcessoIdMacchina($IdProcesso, $IdMacchina);
                    while ($rowCiclo = mysql_fetch_array($sqlCiclo)) {

                        $idCiclo = $rowCiclo['id_ciclo'];
                        $tipoCiclo = $rowCiclo['tipo_ciclo'];
                        $dtInizioCiclo = $rowCiclo['dt_inizio_ciclo'];
                        $dtFineCiclo = $rowCiclo['dt_fine_ciclo'];
                        $idOrdine = $rowCiclo['id_ordine'];
                        $idCat = $rowCiclo['id_cat'];
                        $nomeCat = $rowCiclo['nome_categoria'];
                        $velMix = $rowCiclo['velocita_mix'];
                        $tempoMix = $rowCiclo['tempo_mix'];
                        $numSacchi = $rowCiclo['num_sacchi'];
                        $numSacchiAgg = $rowCiclo['num_sacchi_aggiuntivi'];
                        $vibroAttivo = $rowCiclo['vibro_attivo'];
                        $ariaCondScarico = $rowCiclo['aria_cond_scarico'];
                        $ariaInternoValvola = $rowCiclo['aria_interno_valvola'];
                        $ariaPulisciValvola = $rowCiclo['aria_pulisci_valvola'];
                        $dtInizioProcesso = $rowCiclo['dt_inizio_processo'];
                        $dtFineProcesso = $rowCiclo['dt_fine_processo'];
                    }
                    
                    //Se c'è l'id del ciclo vado a recuperare le informazioni delle materie prime dalla tabella movimento_sing_mac
                                       
                     if (mysql_num_rows($sqlCiclo) > 0 ) {
                        $sqlMovMat = findMovimentoByIdCicloIdMacchina($idCiclo, $IdMacchina);
                    }


                    $sqlOper = findFiguraByCodice($CodOperatore);
                    while ($rowOp = mysql_fetch_array($sqlOper)) {

                        $NominativoOper = $rowOp['nominativo'];
                    }
                    ?>
                    <div id="container" style="width:60%; margin:15px auto ;">
                        <form id="DettaglioSacchetto" name="DettaglioSacchetto">
                            <table width="100%px">
                                <!--  ######################### STABILIMENTO ############################## -->

                                <th class="cella3" colspan="2"><?php echo $filtroProdottoFinito ?></th>

                                <tr>
                                    <td class="dataRig" colspan="2"><?php echo $filtroStabilimento ?></td>
                                </tr> 
                                <tr>
                                    <td width="40%" class="cella2"><?php echo $filtroMatricola ?></td>
                                    <td class="cella2"><?php echo $IdMacchina; ?></td>
                                </tr> 
                                <tr>
                                    <td width="40%" class="cella2"><?php echo $filtroCodStab ?></td>
                                    <td class="cella2"><?php echo $CodiceStabilimento; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2"><?php echo $filtroNome ?></td>
                                    <td class="cella2"><?php echo $DescriStabilimento; ?></a></td>
                                </tr>
                                <!--  ######################### PROCESSO ################################# -->
                                <tr>
                                    <td class="dataRig" colspan="2"><?php echo $filtroProcesso ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2"><?php echo $filtroTipoProcesso ?></td>
                                    <td class="cella2"><?php echo $TipoProcesso; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2" ><?php echo $filtroIdProcesso2 ?></td>
                                    <td class="cella2"><?php echo $IdProcesso; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2"><?php echo $filtroNomeProdotto ?></td>
                                    <td class="cella2"><a name="3" href="/CloudFab/prodotti/modifica_prodotto.php?Prodotto=<?php echo $IdProdotto ?>"><?php echo $CodiceProdotto . "  " . $NomeProdotto ?></a></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2" ><?php echo $filtroCodiceSacco ?></td>
                                    <td class="cella2"><?php echo $CodiceSacco; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2" ><?php echo $filtroPesoRealeSacco  ?></td>
                                    <td class="cella2"><?php echo $PesoRealeSacco. " " . $filtrogBreve; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2" ><?php echo $filtroDtProd ?> </td>
                                    <td class="cella2"><?php echo dataEstraiVisualizza($DataProduzione); ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2" ><?php echo $filtroDtInizioProcedura ?> </td>
                                    <td class="cella2"><?php echo dataEstraiVisualizza($dtInizioProcesso); ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2" ><?php echo $filtroDtFineProcedura ?> </td>
                                    <td class="cella2"><?php echo dataEstraiVisualizza($dtFineProcesso); ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2" ><?php echo $filtroCodiceColore ?></td>
                                    <td class="cella2"><?php echo $CodiceColore; ?></td>
                                </tr>
                                <tr>
                                    <td width="40%" class="cella2"><?php echo $filtroOperatore ?></td>
                                    <td class="cella2"><?php echo $NominativoOper; ?></td>
                                </tr>

                                <tr>
                                    <td width="40%" class="cella2"><?php echo $filtroCliente ?></td>
                                    <td class="cella2"><?php echo $Cliente; ?></td>
                                </tr>
                            </table>

                            <!-- ######################### PRODUZIONE MISCELA ##########################-->
                            <?php if (mysql_num_rows($sqlCiclo) > 0) { ?>

                                <table width="100%">  
                                    <tr>
                                        <td class="dataRig" colspan="3"><?php echo $filtroInfoCiclo ?></td>
                                    </tr>                                    
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroIdCiclo ?></td>
                                        <td class="cella2"><?php echo $idCiclo; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroTipo ?></td>
                                        <td class="cella2"><?php echo $tipoCiclo; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroCategoriaProdotto ?></td>
                                        <td class="cella2"><?php echo $nomeCat; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroDtInizioCiclo ?></td>
                                        <td class="cella2"><?php echo dataEstraiVisualizza($dtInizioCiclo); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroDtFineCiclo ?></td>
                                        <td class="cella2"><?php echo dataEstraiVisualizza($dtFineCiclo); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroOrdineInternoProd ?></td>
                                        <td class="cella2"><?php echo $idOrdine; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroVelocitaMiscelatore ?></td>
                                        <td class="cella2"><?php echo $velMix . " Hz/100" ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroTempoMiscelazione ?></td>
                                        <td class="cella2"><?php echo $tempoMix . " milliseconds" ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroNumSacchi ?></td>
                                        <td class="cella2"><?php echo $numSacchi . " " . $filtroPz; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroNumSacAggiuntivi ?></td>
                                        <td class="cella2"><?php echo $numSacchiAgg . " " . $filtroPz; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroVibro ?></td>
                                        <td class="cella2"><?php echo $vibroAttivo; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroAriaCondScarico ?></td>
                                        <td class="cella2"><?php echo $ariaCondScarico; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroAriaInternoValvola ?></td>
                                        <td class="cella2"><?php echo $ariaInternoValvola; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroAriaPulisciValvola ?></td>
                                        <td class="cella2"><?php echo $ariaPulisciValvola; ?></td>
                                    </tr>
                                </table>                            
                                <?php
                            }

                            if (isSet($sqlMovMat ) AND mysql_num_rows($sqlMovMat) > 0) {
                                ?>

                                <table width="100%">           
                                    <tr>
                                        <td class="dataRig" ><?php echo $filtroMaterieDrymix ?></td>
                                        <td class="dataRig"><?php echo $filtroPesoReale ?></td>
                                        <td class="dataRig" ><?php echo $filtroPesoTeo ?></td>
                                        <td class="dataRig" > <?php echo $filtroSilo ?></td>
                                        <td class="dataRig" > <?php echo $filtroMovMag ?></td>
                                      </tr>
                                    <?php
                                    $qtaMateriale="0";
                                    $pesoTeorico="0";
                                    $silo="";
                                    while ($rowMovMat = mysql_fetch_array($sqlMovMat)) {
                                        $idMateriale = $rowMovMat['id_materiale'];
                                        $IdMovInephos=$rowMovMat['id_mov_inephos'];
                                        $silo=$rowMovMat['silo'];
                                        
                                        $DescriComp="";
                                        $sqlNomeMat = findComponenteById($idMateriale);
                                        while ($rowNomeMat = mysql_fetch_array($sqlNomeMat)) {
                                            $DescriComp = $rowNomeMat['descri_componente'];
                                        }


                                        $qtaMateriale = $rowMovMat['quantita'];
                                        $pesoTeorico = $rowMovMat['peso_teorico'];
                                        
                                        ?>   

                                        <tr>
                                            <td width="40%" class="cella2"><?php echo $DescriComp; ?></td>
                                            <td class="cella2"><?php echo $qtaMateriale . " " . $filtrogBreve; ?></td>
                                            <td class="cella2"><?php echo $pesoTeorico . " " . $filtrogBreve; ?></td>
                                            <td class="cella2" ><?php echo $silo ?></td>
                                            <td class="cella2" >
                                                <a href="dettaglio_movimento_sing_mac.php?IdMovInephos=<?php echo $IdMovInephos ?>"><?php echo $IdMovInephos ?></a>
                                            </td>
                                        </tr>



                                    <?php
                                    } ?>
                                    
                                    </table>
                               <?php  } else if ($CodiceComponentiPeso != "") { ?>
                                    <table width="100%">           
                                        <tr>
                                            <td class="dataRig" colspan="3"><?php echo $filtroMaterieDrymix ?></td>
                                        </tr>
                                        <?php
                                        //Se il primo carattere non è un numero vuol dire che 
                                        //il codice non può essere splittato, è un codice vecchio
                                        if (is_numeric(substr($CodiceComponentiPeso, 0, 1))) {

                                            $ListaComponenti = array();
                                            $Comp = array();
                                            $ListaComponenti = explode('.', $CodiceComponentiPeso);

                                            $ListaCodComponentiIn = array();
                                            $ArrayCodiciCompIn = array();
                                            $ListaCodComponentiIn = explode('^', $CodCompIn);

                                            for ($i = 0; $i < count($ListaComponenti); $i++) {
                                                //Estraggo la formula del prodotto ovvero le quantita effettivamente 
                                                //utilizzate delle materie prima drymix
                                                $Comp = explode('_', $ListaComponenti[$i]);
                                                $IdComp = $Comp[0];
                                                $QtaComp = $Comp[1];

                                                $sqlNomeComp = findComponenteById($IdComp);
                                                while ($rowDescriComp = mysql_fetch_array($sqlNomeComp)) {
                                                    $DescriComp = $rowDescriComp['descri_componente'];
                                                }
                                                if ($CodCompIn != "") {
                                                    //Estraggo i codici relativi alle materie prime caricate nei silos 
                                                    //utili al fine della tracciabilita
                                                    $ArrayCodiciCompIn = explode('$', $ListaCodComponentiIn[$i]);
                                                    $Id = $ArrayCodiciCompIn[0];
                                                    $CodiceIn = $ArrayCodiciCompIn[1];

                                                    $sqlCodCompIn = findMovimentoByCodice($CodiceIn);
                                                    while ($row = mysql_fetch_array($sqlCodCompIn)) {
                                                        $CodIngressoComp = $row['cod_ingresso_comp'];
                                                    }
                                                }

                                                if ($idCiclo > 0 && $IdMacchina > 0) {
                                                    $sqlMovMag = findMovimentoByIdCiclo($idCiclo, $IdMacchina, $IdComp);
                                                    while ($rowMov = mysql_fetch_array($sqlMovMag)) {

                                                        $CodIngressoComp = $rowMov['cod_ingresso_comp'];
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td width="40%" class="cella2"><?php echo $DescriComp; ?></td>
                                                    <td class="cella2"><?php echo $QtaComp . " " . $filtrogBreve; ?></td>
                                                   <td class="cella2" title="<?php echo $filtroMovMag ?>">
                                                        <!--<a href="dettaglio_controllo_componente.php?CodCompIn=<?php echo $CodIngressoComp ?>">-->
                                                            <?php echo $CodIngressoComp ?>
                                                        <!--</a>-->
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            //#### CODICE PESO COMPONENTI NON NUMERICO #######################
                                            ?>
                                            <tr>
                                                <td width="40%" class="cella2"><?php echo $filtroCodiceCompPeso ?></td>
                                                <td class="cella2"><?php echo $CodiceComponentiPeso ?> </td>
                                            </tr>

                                            <?php
                                        }//END if(is_numeric(substr($CodiceComponentiPeso, 0,1)))
                                        //###############################################################
                                        ?>
                                    </table>

                                    <?php
                                }// END if codice comp peso diverso dal vuoto
                                ?>



                                <!--  ######################### FORMULA ################################# -->
                                <table width="100%"> 
                                    <tr>
                                        <td class="dataRig" colspan="2"><?php echo $filtroCompound ?></td>
                                    </tr>

                                    <tr>
                                        <td width="40%" class="cella2" ><?php echo $filtroFormula ?></td>
                                        <td class="cella2"><?php echo $CodiceFormula . "  " . $DescriFormula ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2" ><?php echo $filtroDtCreazione ?></td>
                                        <td class="cella2"><?php echo dataEstraiVisualizza($DataFormula); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2" ><?php echo $filtroDtUltimaMod ?>  </td>
                                        <td class="cella2"><?php echo dataEstraiVisualizza($DataAbilitatoFormula); ?></td>
                                    </tr>
                                    <!--  ######################### TRACCIABILITA ################################# -->
                                    <tr>
                                        <td width="40%" class="cella2" ><?php echo $filtroCodKit ?></td>
                                        <td class="cella2"><a id="91" href="dettaglio_chimica.php?Chimica=<?php echo $CodiceChimica ?>"><?php echo $CodiceChimica; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroCodLotto ?></td>
                                        <td class="cella2"><a id="92" href="dettaglio_lotto.php?Lotto=<?php echo $CodiceLotto ?>"><?php echo $CodiceLotto; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroDtCreazioneLotto ?></td>
                                        <td class="cella2"><?php echo dataEstraiVisualizza($DataLotto); ?></td>
                                    </tr>

                                    <tr>
                                        <td width="40%" class="cella2"><?php echo $filtroNumDdt ?></td>
                                        <td class="cella2"><a name="93" href="dettaglio_bolla.php?NumBolla=<?php echo $NumeroBolla; ?>&DtBolla=<?php echo $DataBolla; ?>"><?php echo $NumeroBolla; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td width="40%" class="cella2" ><?php echo $filtroDtDdt ?></td>
                                        <td class="cella2"><?php echo dataEstraiVisualizza($DataBolla); ?></td>
                                    </tr>
                                </table>


                                <?php
                            }
                            //#################### CODICE SACCO NON TROVATO   #############################
                        } else {
                            echo " <div style='color: #FF0000' >" . $msgInfoCodiceNonTrovato . "</div>";
                        }
                        ?>

                        <table width="100%"> 
                            <tr >
                                <td class="cella2"><input type="reset" value="<?php echo $valueButtonIndietro ?> " onClick="javascript:history.back();"/></td>
                            </tr>
                        </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>ActionOnLoad : " . $actionOnLoad;
                    echo "</br>Tab macchina : Utenti e aziende visibili " . $strUtentiAziende;
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
