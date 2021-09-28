<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>

    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);

    include('../include/gestione_date.php');
    include('../include/precisione.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script.php');
    include('../sql/script_figura.php');
    include('../sql/script_macchina.php');
    include('../sql/script_anagrafe_macchina.php');
    include('../sql/script_componente.php');
    include('../sql/script_movimento_sing_mac.php');
    include('../sql/script_parametro_glob_mac.php');
    include('../sql/script_allegato_mov_ori.php');

    begin();

    if (isSet($_GET['CodMovimento'])) {

        //Dal codice movimento recupero le informazioni relative al movimento di carico per acquisto
        findMovimentoByCodMovTipo($codMov, $tipoMov);
    }



    $IdMovInephos = $_GET['IdMovInephos'];

    $idMacchina = "";
    $descriStab = "";
    $idComp = "";
    $descriComp = "";
    $codice = "";
    $codOperatore = "";
    $fornitore = "";
    $dtAbilitato = "";
    $quantita = "";
    $marchioCe = "";
    $valutazioneMerce = "";
    $verificaStabilita = "";
    $proceduraAdottata = "";
    $note = "";
    $codiceCe = "";
    $respProduzione = "";
    $respQualita = "";
    $consTecnico = "";


    $sqlComp = findMovimentoByIdMovInephos($IdMovInephos);
    while ($row = mysql_fetch_array($sqlComp)) {
        $idCiclo = $row['id_ciclo'];
        $idMacchina = $row['id_macchina'];
        $descriStab = $row['descri_stab'];
        $idMovInephos = $row['id_mov_inephos'];
        $idMovOri = $row['id_mov_ori'];
        $operazione = $row['operazione'];
        $proceduraAdottata = $row['procedura_adottata'];
        $tipoMov = $row['tipo_mov'];
        $descriMov = $row['descri_mov'];
        $numDoc = $row['num_doc'];
        $dtDoc = $row['dt_doc'];
        $tipoMateriale = $row['tipo_materiale'];
        $idComp = $row['id_comp'];
        $codice = $row['cod_componente'];
        $descriComp = $row['descri_componente'];
        $CodiceCompIn = $row['cod_ingresso_comp'];
        $tipoConfezione = $row['tipo_confezione'];
        $pesoConfezione = $row['peso_confezione'];
        $numConfezioni = $row['numero_confezioni'];
        $quantita = $row['quantita'];
        $pesoTeorico = $row['peso_teorico'];
        $silo = $row['silo'];
        $dtInizioProc = $row['dt_inizio_procedura'];
        $dtFineProc = $row['dt_fine_procedura'];
        $abilitato = $row['abilitato'];
        $origineMov = $row['origine_mov'];
        $dtAbilitato = $row['dt_abilitato'];
        $marchioCe = $row['marchio_ce_conforme'];
        $valutazioneMerce = $row['merce_conforme'];
        $verificaStabilita = $row['stabilita_conforme'];
        $note = $row['note'];
        $codiceCe = $row['codice_ce'];
        $respProduzione = $row['responsabile_produzione'];
        $respQualita = $row['responsabile_qualita'];
        $consTecnico = $row['consulente_tecnico'];
        $codOperatore = $row['cod_operatore'];
        $fornitore = $row['fornitore'];
        $codiceIntegrazione = $row['info1'];
    }

    $arrayLinkAllegati = array();
    $i = 0;
    $sqlAllegati = findAllegatiByIdMov($IdMovInephos);
    while ($row = mysql_fetch_array($sqlAllegati)) {

        $arrayLinkAllegati[$i] = $row['link'];
        $i++;
    }


    //Se si tratta di un movimento in uscita relativo ad un processo vado a recuperare 
    //i movimenti in entrata associati allo stesso codice

    $strTipoMovWareHOut = "";
    $strTipoMovWareHIn = "";
    $sqlParGlob = findParGlobMac();
    while ($rowParGlob = mysql_fetch_array($sqlParGlob)) {

        switch ($rowParGlob['id_par_gm']) {


            /** case 119:
              //WAREHOUSE OUT
              $strTipoMovWareHOut = $rowParGlob['valore_variabile'];
              break;

              case 146:
              //WAREHOUSE IN
              $strTipoMovWareHIn = $rowParGlob['valore_variabile'];
              break;

             */
            case 118:
                //DELIVERY NOTE
                $strProcAdottataDN = $rowParGlob['valore_variabile'];
                break;


            case 121:
                //SILO LOADING
                $strProcAdottataSiloLoad = $rowParGlob['valore_variabile'];
                break;



            default:
                break;
        }
    }

    $idMovInephosEntrata = "0";
    $idMovInephosCaricoSilos = "0";
    if ($operazione == $valScarico) {
        //Se si tratta di un movimento in uscita, ad. es un processo recupero tutti i movimenti in entrata

        $sqlMov = findMovimentoByCodMovProcAdot($CodiceCompIn, $strProcAdottataDN);
        while ($row = mysql_fetch_array($sqlMov)) {

            $idMovInephosEntrata = $row['id_mov_inephos'];
        }

        $sqlMov2 = findMovimentoByCodMovProcAdot($CodiceCompIn, $strProcAdottataSiloLoad);
        while ($row = mysql_fetch_array($sqlMov2)) {

            $idMovInephosCaricoSilos = $row['id_mov_inephos'];
        }
    }



    commit();

    $actionOnLoad = "";
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

<?php include('../include/menu.php'); ?>
            <div id="container" style="width:60%; margin:15px auto;">
                <form id="VediMovSingMac" name="VediMovSingMac" method="post" onsubmit="return controllaCampi(arrayMsgErrJs)" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="3"><?php echo $titoloPaginaDettaglioMovimento . " : " . $proceduraAdottata ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroStabilimento ?> </td>
                            <td class="cella2" colspan="2"><?php echo $descriStab ?> </td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroInfoMovimento ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroOrigineMov ?></td>
                            <td class="cella2" colspan="2"><?php echo $origineMov ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroIdMovInephos ?> </td>
                            <td class="cella2" colspan="2"><?php echo $idMovInephos ?> </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroIdMovOri ?> </td>
                            <td class="cella2" colspan="2"><?php echo $idMovOri ?> </td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroProceduraAdottata ?></td>
                            <td class="cella2" colspan="2"><?php echo $proceduraAdottata ?></td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroTipoMovimento ?></td>
                            <td class="cella2" colspan="2"><?php echo $tipoMov ?></td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroDescriMovimento ?></td>
                            <td class="cella2" colspan="2"><?php echo $descriMov ?></td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroNumDoc ?></td>
                            <td class="cella2" colspan="2"><?php echo $numDoc ?></td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroDtDdt ?></td>
                            <td class="cella2" colspan="2"><?php echo $dtDoc ?></td>
                        </tr>
<?php if ($CodiceCompIn != "0") { ?>
                            <tr>
                                <td class="cella2"><?php echo $filtroCodiceIdMovimento ?></td>
                                <td class="cella2" colspan="2"><a href="../produzioneorigami/gestione_movimento_sing_mac.php?CodIngresso=<?php echo $CodiceCompIn ?>"><?php echo $CodiceCompIn ?></a>
                                </td>
<?php } ?>
                        </tr>
                            <?php if ($idMovInephosEntrata != "0") { ?>
                            <tr>
                                <td class="cella2"><?php echo $filtroCodMovEntrata ?></td>
                                <td class="cella2" colspan="2"><a href="dettaglio_movimento_sing_mac.php?IdMovInephos=<?php echo $idMovInephosEntrata ?>"><?php echo $idMovInephosEntrata ?></a></td>
                            </tr>

<?php } ?>

                        <?php if ($idMovInephosCaricoSilos != "0") { ?>
                            <tr>
                                <td class="cella2"><?php echo $filtroCodMovCaricoSilo ?></td>
                                <td class="cella2" colspan="2"><a href="dettaglio_movimento_sing_mac.php?IdMovInephos=<?php echo $idMovInephosCaricoSilos ?>"><?php echo $idMovInephosCaricoSilos ?></a></td>
                            </tr>

<?php } ?>  

                        <tr>
                            <td class="cella2"><?php echo $filtroOperatore ?></td>
                            <td class="cella2" colspan="2"><?php echo $codOperatore ?></td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroInfoMatPrima ?></td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroTipoMateriale ?></td>
                            <td class="cella2" colspan="2"><?php echo $tipoMateriale ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroMateriaPrima ?></td>
                            <td class="cella2" colspan="2" > <?php echo $codice . " - " . $descriComp ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroCodiceIntegrazione ?></td>
                            <td class="cella2" colspan="2" > <?php echo $codiceIntegrazione ?></td>
                        </tr>

                        <tr>               
                            <td class="cella2"><?php echo $filtroTipoConfezione ?></td>
                            <td class="cella2" colspan="2"><?php echo $tipoConfezione ?></td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroPesoConfezione ?></td>
                            <td class="cella2" colspan="2"><?php echo $pesoConfezione . " " . $filtrogBreve ?></td>
                        </tr>
                        <tr>               
                            <td class="cella2"><?php echo $filtroNumConfezioni ?></td>
                            <td class="cella2" colspan="2"><?php echo $numConfezioni . " " . $filtroPz ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroQuantita ?></td>
                            <td class="cella2" colspan="2"><?php echo $quantita . " " . $filtrogBreve ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPesoTeorico ?></td>
                            <td class="cella2" colspan="2"><?php echo $pesoTeorico . " " . $filtrogBreve ?></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroFornitore ?></td>
                            <td class="cella2" colspan="2"><?php echo $fornitore ?></td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroInformazioniSulCiclo ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroIdCiclo ?></td>
                            <td class="cella2" colspan="2"><?php echo $idCiclo ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroSilo ?></td>
                            <td class="cella2" colspan="2"><?php echo $silo ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtInizioProcedura ?></td>
                            <td class="cella2" colspan="2"><?php echo $dtInizioProc ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtFineProcedura ?></td>
                            <td class="cella2" colspan="2"><?php echo $dtFineProc ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroAbilitato ?></td>
                            <td class="cella2" colspan="2"><?php echo $abilitato ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtAbilitato ?></td>
                            <td class="cella2" colspan="2"><?php echo $dtAbilitato ?></td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroInformazioniSulMarchioCe ?></td>
                        </tr>                                         
                        <tr>
                            <td class="cella2"><?php echo $filtroMarchioCE ?></td>
                            <td class="cella2" colspan="2"><?php echo $marchioCe ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroValutazioneMerce ?></td>

                            <td class="cella2" colspan="2"><?php echo $valutazioneMerce ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroVerificaStabilita ?></td>
                            <td class="cella2" colspan="2"><?php echo $verificaStabilita ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodiceCE ?></td>
                            <td class="cella2" colspan="2"><?php echo $codiceCe ?></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroRespProduzione ?></td>
                            <td class="cella2" colspan="2"><?php echo $respProduzione ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRespQualita ?></td>
                            <td class="cella2" colspan="2"><?php echo $respQualita ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroConsTecnico ?></td>
                            <td class="cella2" colspan="2"><?php echo $consTecnico ?></td>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="2"><?php echo $filtroAllegati ?></td>
                        </tr>
                        <?php for ($i = 0; $i < count($arrayLinkAllegati); $i++) { ?>
                        <tr><td class="cella2" colspan="2"><a href="<?php echo "../".$downloadDocMacchinaDir."/".$preDirMacchina.$idMacchina."/".$arrayLinkAllegati[$i]?>"><?php echo $arrayLinkAllegati[$i]?></a></td></tr>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="cella1" colspan="3"><?php echo $filtroNote ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" colspan="3"><?php echo $note ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="3">
                                <input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="javascript:history.back();"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="msgLog">

            </div>
        </div><!--mainContainer-->
    </body>
</html>
