<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php
        include('../include/header.php');
        ?>        
    </head>

    <?php
    $pagina = "carica_machina.php";
    //Costruzione dell'array contenente i vari msg di errore
    $arrayMsgErrPhp = array($filtroIdMacchina . ' ' . $msgNonValido, //0
        $filtroCodice . ' ' . $msgNonValido, //1
        $filtroDescrizione . ' ' . $msgNonValida, //2
        $filtroRagioneSociale . ' ' . $msgNonValida, //3
        $filtroLingua . ' ' . $msgNonValida, //4
        $filtroServerFtp . ': ' . $filtroUserName . ' ' . $msgNonValido, //5
        $filtroServerFtp . ': ' . $filtroPassword . ' ' . $msgNonValida, //6
        $filtroServerFtp . ': ' . $filtroConferma . " " . $filtroPassword . ' ' . $msgNonValida, //7
        $filtroServerFtp . ': ' . $filtroZipPassword . ' ' . $msgNonValida, //8
        $filtroServerFtp . ': ' . $filtroConferma . " " . $filtroPassword . ' ' . $msgNonValida, //9
        $filtroIdMacchina . ' ' . $msgNumerico, //10
        $filtroCodice . ' ' . $msgNumerico, //11
        $msgErrLunghezzaCodStab //12
    );
    ?>
    <script language="javascript">
//        function disabilitaAction40() {
//            location.href = '../permessi/avviso_permessi_visualizzazione.php'
//        }
//        function disabilitaAction96() {
//            //PERMESSO DI VEDERE IL SESTO LIVELLO DEI GRUPPI
//            document.getElementById("96").style.display = "none";
//        }
        //Trasformo l'array da php a js
        var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

        function controllaCampi(arrayMsgErrJs) {

            var rv = true;
            var msg = "";

            if (document.getElementById('IdMacchina').value === "") {
                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[0];
            }
            if (document.getElementById('CodiceStabilimento').value === "") {
                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[1];
            }
            if (document.getElementById('DescrizioneStabilimento').value === "") {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[2];
            }
            if (document.getElementById('Ragso1').value === "") {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[3];
            }
            if (document.getElementById('Lingua').value === "") {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[4];
            }
            if (document.getElementById('UserFtp').value === "") {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[5];
            }
            if (document.getElementById('PassFtp').value === "") {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[6];
            }
            if (document.getElementById('ConfermaPassFtp').value === "" ||
                    document.getElementById('ConfermaPassFtp').value !== document.getElementById('PassFtp').value) {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[7];
            }
            if (document.getElementById('PassZip').value === "") {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[8];
            }
            if (document.getElementById('ConfermaPassZip').value === "" ||
                    document.getElementById('ConfermaPassZip').value !== document.getElementById('PassZip').value) {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[9];
            }

            if (isNaN(document.getElementById('IdMacchina').value)) {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[10];

            }
            if (isNaN(document.getElementById('CodiceStabilimento').value)) {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[11];

            }

            if ((document.getElementById('CodiceStabilimento').value.length) < 8) {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[12];
            }

            if (!rv) {
                alert(msg);
                rv = false;
            }
            return rv;
        }

    </script>
    <script type="text/javascript" src="../js/visualizza_elementi.js"></script>

    <?php
     include('../include/precisione.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script.php');
    include('../sql/script_lingua.php');
    include('../sql/script_comune.php');
    include('../sql/script_gruppo.php');


    //############ VERIFICA PERMESSO SCRITTURA GENERICO ########################

    $actionOnLoad = "";
    $elencoFunzioni = array("96");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    $strUtAzGruppo = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'macchina');
    begin();
    $sql = selectAllLingua("lingua");
    commit();
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:70%; margin:15px auto;">
                <form id="InserisciProdotto" autocomplete="off" name="InserisciProdotto" method="post" action="carica_macchina2.php" onsubmit="return controllaCampi(arrayMsgErrJs)">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $nuovoStabilimento ?></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2" title="Matricola"><?php echo $filtroIdMacchina ?></td>
                            <td width="529" class="cella1"><input type="text" name="IdMacchina" id="IdMacchina" title="Matricola"/></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroCodice ?></td>
                            <td width="529" class="cella1"><input type="text" name="CodiceStabilimento" id="CodiceStabilimento" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><input type="text" name="DescrizioneStabilimento" id="DescrizioneStabilimento" size="50px" /></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroRagioneSociale ?></td>
                            <td width="529" class="cella1"><input type="text" name="Ragso1" id="Ragso1" size="50px"/></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroIdClienteGazie ?></td>
                            <td width="529" class="cella1"><input type="text" name="IdClienteGaz" id="IdClienteGaz" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLingua ?></td>
                            <td class="cella1">
                                <select name="Lingua" id="Lingua">
                                    <option value="" selected=""><?php echo $labelOptionLinguaDefault ?></option>
                                    <?php
                                    //$sql=mysql_query("SELECT * FROM lingua ORDER BY lingua") or die("ERRORE 1 SELECT FROM lingua: " . mysql_error());
                                    while ($row = mysql_fetch_array($sql)) {
                                        ?>
                                        <option value="<?php echo($row['id_lingua']) ?>"><?php echo($row['lingua']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGeografico ?></td>
                            <td class="cella11"><?php include('./moduli/visualizza_form_geografico.php'); ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGruppoAcquisto ?></td>
                            <td class="cella11"><?php include('./moduli/visualizza_form_gruppo.php'); ?></td>
                        </tr>
                        
<!--                     <td class="cella2"><?php echo $filtroOrigamiDb ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class="cella1"><input type="text" name="UserOrigami" id="UserOrigami" autocomplete="off"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="test" name="PassOrigami" id="PassOrigami" /></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="test" name="ConfermaPassOrigami" id="ConfermaPassOrigami" /></td>
                                    </tr>
                                </table>
                            </td>-->
                            <!--                        <tr>
                            <td class="cella2"><?php echo $filtroServerdb ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class=" cella1"><input type="text" name="UserServer" id="UserServer" /></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="PassServer" id="PassServer" /></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="ConfermaPassServer" id="ConfermaPassServer" /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>-->
                        <tr>
                            <td class="cella2"><?php echo $filtroVersioneCloudFab ?></td>
                            <td class="cella1"><input type="text" name="UserOrigami" id="UserOrigami" autocomplete="off" value="<?php echo $valSyncSftwVersion ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroVersioneOrigami ?></td>
                            <td class="cella1"><input type="text" name="UserServer" id="UserServer" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroServerFtp ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class=" cella1"><input type="text" name="UserFtp" id="UserFtp" /></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="PassFtp" id="PassFtp" /></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="ConfermaPassFtp" id="ConfermaPassFtp" /></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroZipPassword ?></td>
                                        <td class="cella1"><input type="text" name="PassZip" id="PassZip" /></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="ConfermaPassZip" id="ConfermaPassZip" /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1">
                                <select name="Azienda" id="Azienda"> 
                                    <option value="<?php echo $_SESSION['id_azienda'] . ";" . $_SESSION['nome_azienda'] ?>" selected="selected"><?php echo $_SESSION['nome_azienda'] ?></option>
                                    <?php
                                    //Si selezionano solo le aziende che l'utente ha il permesso di editare
                                    for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                        $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                        $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                        if ($idAz != $_SESSION['id_azienda']) {
                                            ?>
                                            <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select> 
                            </td>
                        </tr>                    
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="4">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>" /></td>
                        </tr>

                    </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab gruppo : Nuova stringa unica utenti e aziende visibili : " . $strUtAzGruppo;
                    echo "</br>Tabella macchina: AZIENDE SCRIVIBILI: ";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
