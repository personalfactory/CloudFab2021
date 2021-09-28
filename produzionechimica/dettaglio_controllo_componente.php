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
    include('../sql/script_componente_controllo.php');


    begin();
    $CodiceCompIn = $_GET['CodCompIn'];

    $IdMacchina = "";
    $DescriStab = "";
    $IdComp = "";
    $DescriComp = "";
    $Codice = "";
    $CodOperatore = "";
    $Fornitore = "";
    $DtAbilitato = "";
    $Quantita = "";
    $MarchioCe = "";
    $ValutazioneMerce = "";
    $VerificaStabilita = "";
    $ProceduraAdottata = "";
    $Note = "";
    $CodiceCe = "";
    $RespProduzione = "";
    $RespQualita = "";
    $ConsTecnico = "";

    $sqlComp = findInfoControlloCompByCodice($CodiceCompIn);
    while ($row = mysql_fetch_array($sqlComp)) {
        $IdMacchina = $row['id_macchina'];
        $DescriStab = $row['descri_stab'];
        $IdComp = $row['id_comp'];
        $DescriComp = $row['descri_componente'];
        $Codice = $row['cod_componente'];
        $CodOperatore = $row['cod_operatore'];
        $Fornitore = $row['fornitore'];
        $DtAbilitato = $row['dt_abilitato'];
        $Quantita = $row['quantita'];
        $MarchioCe = $row['marchio_ce_conforme'];
        $ValutazioneMerce = $row['merce_conforme'];
        $VerificaStabilita = $row['stabilita_conforme'];
        $ProceduraAdottata = $row['procedura_adottata'];
        $Note = $row['note'];
        $CodiceCe = $row['codice_ce'];
        $RespProduzione = $row['responsabile_produzione'];
        $RespQualita = $row['responsabile_qualita'];
        $ConsTecnico = $row['consulente_tecnico'];
    }

    commit();
    $actionOnLoad = "";
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:80%; margin:15px auto;">
                <form id="InserisciControlloComp" name="InserisciControlloComp" method="post" onsubmit="return controllaCampi(arrayMsgErrJs)" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="3"><?php echo $titoloPaginaCaricaControlloComp ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroStabilimento ?> </td>
                            <td class="cella1" colspan="2"><?php echo $DescriStab ?> </td>
                        </tr>
                        <tr>
                            <td class="cella2" ><?php echo $filtroMateriaPrima ?></td>
                            <td class="cella1" colspan="2" > <?php echo $Codice . " - " . $DescriComp ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodiceMatPri ?></td>
                            <td class="cella1" colspan="2"><?php echo $CodiceCompIn ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroOperatore ?></td>
                            <td class="cella1" colspan="2"><?php echo $CodOperatore ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFornitore ?></td>
                            <td class="cella1" colspan="2"><?php echo $Fornitore ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtArrivoMerce ?></td>
                            <td class="cella1" colspan="2"><?php echo $DtAbilitato ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroQuantita ?></td>
                            <td class="cella1" colspan="2"><?php echo $Quantita ." ".$filtrogBreve?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroMarchioCE ?></td>
                            <?php if ($MarchioCe == $valConforme) { ?>                               
                                <td class="cella1" colspan="2"><?php echo $filtroConforme ?></td>

                            <?php } else if ($MarchioCe == $valNonConforme) { ?>
                                <td class="cella1" colspan="2"><?php echo $filtroNonConforme ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroValutazioneMerce ?></td>
                            <?php if ($ValutazioneMerce == $valConforme) { ?>                               
                                <td class="cella1" colspan="2"><?php echo $filtroConforme ?></td>

                            <?php } else if ($ValutazioneMerce == $valNonConforme) { ?>
                                <td class="cella1" colspan="2"><?php echo $filtroNonConforme ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroVerificaStabilita ?></td>
                            <?php if ($VerificaStabilita == $valStabile) { ?> 
                                <td class="cella1" colspan="2"><?php echo $filtroConforme ?></td>
                            <?php } else if ($VerificaStabilita == $valNonStabile) { ?>
                                <td class="cella1" colspan="2"><?php echo $filtroNonConforme ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroProceduraAdottata ?></td>
                            <?php if ($ProceduraAdottata == $valReso) { ?> 
                                <td class="cella1" colspan="2"><?php echo $filtroReso ?></td>
                            <?php } else if ($ProceduraAdottata == $valScaricatoSilos) { ?>
                                <td class="cella1" colspan="2"><?php echo $filtroScaricatoSilos ?></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNote ?></td>
                            <td class="cella1" colspan="2"><?php echo $Note ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodiceCE ?></td>
                            <td class="cella1" colspan="2"><?php echo $CodiceCe ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRespProduzione ?></td>
                            <td class="cella1" colspan="2"><?php echo $RespProduzione ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRespQualita ?></td>
                            <td class="cella1" colspan="2"><?php echo $RespQualita ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroConsTecnico ?></td>
                            <td class="cella1" colspan="2"><?php echo $ConsTecnico ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="3">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                ?>
            </div>
        </div><!--mainContainer-->
    </body>
</html>
