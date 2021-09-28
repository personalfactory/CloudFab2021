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
    include('../sql/script_ordine_elenco.php');
    include('../sql/script_ordine_sing_mac.php');
    include('../sql/script_valore_par_ordine.php');
    include('../sql/script_parametro_glob_mac.php');
    include('../sql/script_prodotto.php');
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:95%; margin:15px auto;font-size:13px">



                <?php
                begin();
                $IdOrdine = $_GET['IdOrdine'];

                $idMacchina = "";
                $descriStab = "";
                $note = "";
                $dtOrdine = "";
                $idProdotto = "";
                $codiceProdotto = "";
                $nomeProdotto = "";
                $ordineProduzione = "";
                $dtProgrammata = "";
                $numPezzi = "";
                $kgPezzo = "";
                $contatore = "";
                $descriStato = "";
                $dtProduzione = "";

                //Valore Par Ordine
                $tipoChimica = "";
                $numConfezioniMiscela = "";
                $pesoConfezione = "";
                $cambioConfezione = "";
                $disabilitaRibaltaConfezione = "";
                $cliente = "";
                $cambioCemento = "";
                $prodottoColorato = "";
                $cambioBilancia = "";


                $sqlOrdine = findDettaglioOrdineByIdOrdine($IdOrdine);
                while ($row = mysql_fetch_array($sqlOrdine)) {

                $idMacchina = $row['id_macchina'];
                $descriStab = $row['descri_stab'];
                $note = $row['note'];
                $dtOrdine = $row['dt_ordine'];
                $dtProgrammata = $row['dt_programmata'];
                }

                $parSeparatore = "";
                $sqlParSeparatore = findParGlobMacById(156);
                while ($row = mysql_fetch_array($sqlParSeparatore)) {

                $parSeparatore = $row['valore_variabile'];
                }
                $parSeparatore2 = "";
                $sqlParSeparatore2 = findParGlobMacById(22);
                while ($row = mysql_fetch_array($sqlParSeparatore2)) {

                $parSeparatore2 = $row['valore_variabile'];
                }
                ?>
                <table width="100%">
                    <tr>
                        <th class="cella3" colspan="4"><?php echo $filtroProgrammaProd ?></th>
                    </tr> 
                    <tr>
                        <td class="cella2"><?php echo $filtroIdOrdine ?></td>
                        <td class="cella2" ><?php echo $IdOrdine ?></td>

                        <td class="cella2"><?php echo $filtroDtInserimentoOrdine ?></td>
                        <td class="cella2" ><?php echo $dtOrdine ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroDtProgrammata ?></td>
                        <td class="cella2" colspan="3"><?php echo dataEstraiVisualizza($dtProgrammata) ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroStabilimento ?></td>
                        <td class="cella2" colspan="3"><?php echo $descriStab ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroNote ?></td>
                        <td class="cella2" colspan="3"><?php echo $note ?></td>
                    </tr>
                </table>

                <?php
                if (mysql_num_rows($sqlOrdine) > 0)
                mysql_data_seek($sqlOrdine, 0);
                while ($row = mysql_fetch_array($sqlOrdine)) {


                $idProdotto = $row['id_prodotto'];
                $codiceProdotto = $row['cod_prodotto'];
                $nomeProdotto = $row['nome_prodotto'];
                $ordineProduzione = $row['ordine_produzione'];

                $numPezzi = $row['num_pezzi'];
                $kgPezzo = $row['kg_pezzo'];
                $contatore = $row['contatore'];
                $descriStato = $row['descri_stato'];
                $dtProduzione = $row['dt_produzione'];
                $idOrdineSm = $row['id_ordine_sm'];
                $stato = $row['stato'];


                $idRicettaColore = 0;
                $nomeRicettaColore = "";
                $idRicettaAdditivo = 0;
                $nomeRicettaAdditivo = "";

                //Valore Par Ordine
                $sqlValPar = findValoreOrdineByIdOrdineSm($idOrdineSm, $idMacchina);
                while ($rowPar = mysql_fetch_array($sqlValPar)) {

                switch ($rowPar['id_par_ordine']) {

                case 1:
                //TIPO CHIMICA
                $tipoChimica = $rowPar['valore'];
                if ($tipoChimica == 0)
                $descriTipoChimica = $filtroDesKitChimica;
                else
                $descriTipoChimica = $filtroDesSfusa;
                break;
                case 2:
                //NUMERO DI CONFEZIONI PER MISCELA
                $numConfezioniMiscela = $rowPar['valore'];
                break;
                case 3:
                //PESO CONFEZIONE
                $pesoConfezione = $rowPar['valore'];
                break;
                case 4:
                //CAMBIO CONFEZIONE
                $cambioConfezione = $rowPar['valore'];

                if ($cambioConfezione == 0)
                $descriCambioConfezione = $filtroDesConfSacco;
                else
                $descriCambioConfezione = $filtroDesConfSecchio;
                break;
                case 5:

                //DISABILITA RIBALTA CONFEZIONE
                $disabilitaRibaltaConfezione = $rowPar['valore'];

                if ($disabilitaRibaltaConfezione == 0)
                $descriRibalta = $filtroDesAbilitaRibalta;
                else
                $descriRibalta = $filtroDesDisabilitaRibalta;

                break;
                case 6:
                //CLIENTE
                $cliente = $rowPar['valore'];
                break;

                case 9:
                //CAMBIO BILANCIA
                $cambioBilancia = $rowPar['valore'];
                if ($cambioBilancia == 0)
                $descriCambioBilancia = $filtroBilanciaStandard;
                else
                $descriCambioBilancia = $filtroBilanciaCambio;

                break;

                case 11:
                //RICETTA COLORE
                $idRicettaColore = $rowPar['valore'];
                $nomeRicettaColore = "";
                $sqlNomeColore = findProdottoById($idRicettaColore);
                while ($rowCol = mysql_fetch_array($sqlNomeColore))
                $nomeRicettaColore = $rowCol['nome_prodotto'];

                case 12:
                //RICETTA ADDITIVO
                $idRicettaAdditivo = $rowPar['valore'];
                $nomeRicettaAdditivo = "";
                $sqlNomeAdditivo = findProdottoById($idRicettaAdditivo);

                while ($rowAdd = mysql_fetch_array($sqlNomeAdditivo))
                $nomeRicettaAdditivo = $rowAdd['nome_prodotto'];

                break;


                case 13:

                $stringaCompFormula = $rowPar['valore'];

                $arrayComp1 = array();
                $arrayCompFormula = array();

                $arrayComp1 = explode($parSeparatore, $stringaCompFormula);
                //print_r($arrayComp1);

                for ($i = 0;
                $i < count($arrayComp1);
                $i++) {
                list($idCompOld, $idCompNew) = explode($parSeparatore2, $arrayComp1[$i]);

                $arrayCompFormula[$i] = $idCompNew;
                }

                break;

                default:
                break;
                }
                }



                $stringaNumPezzi = $numPezzi . " " . $filtroPz . " " . $filtroDa . " " . $kgPezzo . " " . $filtroKgBreve;
                ?>

                <table width="100%">
                    <tr>
                        <td class= "cella1" width="5%"><?php echo $ordineProduzione ?></td>
                        <td class= "cella1" width="30%">

                            <nobr><b><?php echo $codiceProdotto ." ". $nomeProdotto ?></b></nobr> 

                            <?php if($nomeRicettaColore!="") {?>
                            <nobr><li><?php echo $nomeRicettaColore ?></li></nobr> 

                            <?php } if($nomeRicettaAdditivo!="") {?>
                            <nobr><li><?php echo $nomeRicettaAdditivo ?></li></nobr> 
                            <?php } ?>
                        </td> 
                        <td class= "cella1" width="30%">
                            <?php
                            for ($t = 0; $t < count($arrayCompFormula); $t++) {

                                $descriComp = "";
                                $sqlDescri = findComponenteById($arrayCompFormula[$t]);
                                while ($row = mysql_fetch_array($sqlDescri)) {
                                    $descriComp = $row['descri_componente'];
                                }
                                ?>
                                <nobr><li><?php echo $descriComp ?></li></nobr>

<?php } ?>

                        </td>
                        <td class= "cella1" width="30%">
                            <nobr><li><?php echo $stringaNumPezzi ?></li></nobr>
                            <nobr><li><?php echo $filtroConfezioniPerMix . " : " . $numConfezioniMiscela . " " . $filtroPz ?></li></nobr>
                            <!--<nobr><li><?php echo $descriColorato ?></li></nobr>                         -->
                            <nobr> <li><?php echo $filtroCliente . " : " . $cliente ?></li></nobr>
                        </td> 

                        <td class= "cella1" width="30%">
                            <nobr><li><?php echo $descriTipoChimica ?></li></nobr>
                            <nobr> <li><?php echo $descriCambioConfezione ?></li></nobr>
                            <nobr> <li><?php echo $descriRibalta ?></li></nobr>
                            <nobr> <li><?php echo $descriCambioBilancia ?></li></nobr>
                        </td>
                        <td class= "cella1" width="5%"><?php echo $descriStato ?></td>

                        <td class= "cella1" width="5%">
                            <nobr>  
                                <a name="2" href="disabilita_ordine_sm.php?Tabella=ordine_sm&idOrdine=<?php echo $IdOrdine ?>&idOrdineSm=<?php echo $idOrdineSm ?>&RefBack=dettaglio_ordine.php?IdOrdine=<?php echo $IdOrdine ?>"><img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone" title="<?php echo $titleElimina ?> "/></a>
                                <a name="2" href="salta_ordine_sm.php?Tabella=ordine_sm&idOrdine=<?php echo $IdOrdine ?>&idOrdineSm=<?php echo $idOrdineSm ?>&RefBack=dettaglio_ordine.php?IdOrdine=<?php echo $IdOrdine ?>&stato=<?php echo $stato ?>"><img src="/CloudFab/images/pittogrammi/penna_R.png" class="icone" title="<?php echo $titleCambioStato ?> "/></a>
                            </nobr></td> </tr>

                    <tr>
                        <td class="cella2" style="text-align: right " colspan="7">

                        </td>
                    </tr>


                    <?php
                    }


                    commit();
                    $actionOnLoad = "";
                    ?>



                    <tr>
                        <td class="cella2" style="text-align: right " colspan="7">
                            <input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="location.href = 'gestione_ordini.php'"/>
                        </td>
                    </tr>

                </table>

            </div>
            <div id="msgLog">
<?php ?>
            </div>
        </div><!--mainContainer-->
    </body>
</html>
