<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    ini_set('display_errors', 1);
    include('../include/validator.php');
    ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>  

    <?php
    //Costruzione dell'array contenente i vari msg di errore
    $arrayMsgErrPhp = array($filtroAbilitato . ' ' . $msgNonValido, //0
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
        
        function disabilitaOperazioni() {
            document.getElementById('Salva').disabled = true;
        }        

        //Trasformo l'array da php a js
        var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

        function controllaCampi(arrayMsgErrJs) {

            var rv = true;
            var msg = "";


            if (document.getElementById('CodiceStab').value === "") {
                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[1];
            }

            if (document.getElementById('DescriStab').value === "") {

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
            if (document.getElementById('Abilitato').value === "") {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[0];
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

            if (isNaN(document.getElementById('CodiceStab').value)) {

                rv = false;
                msg = msg + ' - ' + arrayMsgErrJs[11];

            }

            if ((document.getElementById('CodiceStab').value.length) < 8) {

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
    $pagina = "modifica_macchina";
    

    include('../Connessioni/serverdb.php');
    include('../sql/script.php');
    include('../sql/script_valore_par_comp.php');
    include('../sql/script_valore_par_sing_mac.php');
    include('../sql/script_macchina.php');
    include('../sql/script_lingua.php');
    include('../sql/script_comune.php');
    include('../sql/script_gruppo.php');


    //INIZIALIZZAZIONE VARIABILI
    $TipoRiferimento = "";
    $LivelloGruppo = "";
    $CodiceStabilimento = "";
    $DescrizioneStabilimento = "";
    $IdClienteGaz = 0;
    $Ragso1 = "";
    $IdLingua = 0;
    $UserOrigami = "";
    $PassOrigami = "";
    $ConfermaPassOrigami = "";
    $UserServer = "";
    $PassServer = "";
    $ConfermaPassServer = "";
    $UserFtp = "";
    $PassFtp = "";
    $ConfermaPassFtp = "";
    $PassZip = "";
    $ConfermaPassZip = "";
    $Abilitato = "";

    $IdMacchina = $_GET['Macchina'];

//Visualizzo il record che intendo modificare all'interno della form
//Estraggo i dati dello Stabilimento da modificare dalle tabelle [macchina] e [anagrafe_macchina]

    $sqlMacchina = selectAllInfoMacchinaById($IdMacchina);

    while ($rowMacchina = mysql_fetch_array($sqlMacchina)) {
        $CodiceStab = $rowMacchina['cod_stab'];
        $DescriStab = $rowMacchina['descri_stab'];
        $Ragso1 = $rowMacchina['ragso1'];
        $IdClienteGaz = $rowMacchina['id_cliente_gaz'];
        $Geografico = $rowMacchina['geografico'];
        $TipoRiferimento = $rowMacchina['tipo_riferimento'];
        $Gruppo = $rowMacchina['gruppo'];
        $LivelloGruppo = $rowMacchina['livello_gruppo'];
        $IdLingua = $rowMacchina['id_lingua'];
        $Lingua = $rowMacchina['lingua'];
        $UserOrigami = $rowMacchina['user_origami'];
        $PassOrigami = $rowMacchina['pass_origami'];
        $UserServer = $rowMacchina['user_server'];
        $PassServer = $rowMacchina['pass_server'];
        $UserFtp = $rowMacchina['ftp_user'];
        $PassFtp = $rowMacchina['ftp_password'];
        $PassZip = $rowMacchina['zip_password'];
        $Abilitato = $rowMacchina['abilitato'];
        $Data = $rowMacchina['dt_abilitato'];
        $IdAzienda = $rowMacchina['id_azienda'];
        $IdUtenteProp = $rowMacchina['id_utente'];
    }

    $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);

    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################            
    //Si recupera il proprietario della macchina e si verifica se l'utente 
    //corrente ha il permesso di editare  i dati di quell'utente proprietario 
    //nelle tabelle macchina 
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
    $actionOnLoad = "";
    $elencoFunzioni = array("96");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    
    $arrayTabelleCoinvolte = array("macchina");
    if ($IdUtenteProp != $_SESSION['id_utente']) {

        //Se il proprietario del dato è un utente diverso dall'utente 
        //corrente si verifica il permesso 3
        if ($DEBUG)
            echo "</br>Eseguita verifica permesso di tipo 3";
        $actionOnLoad = $actionOnLoad.verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp,$IdAzienda);
    }

    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'macchina');

    //############# STRINGHE UTENTI  AZIENDE VISIBILI###########################
     
    $strUtAzGruppo = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');    
    
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="ModificaMacchina" name="ModificaMacchina" method="post" action="modifica_macchina2.php" onsubmit="return controllaCampi(arrayMsgErrJs)">
                    <table width="100%" >
                        <tr>
                            <td height="42" colspan="2" class="cella3"><?php echo $titoloPaginaModStab ?></td>
                        </tr>
                        <input type="hidden" name="GruppoOld" id="GruppoOld" value="<?php echo $Gruppo; ?>"></input>
                            <input type="hidden" name="LivelloGruppoOld" id="LivelloGruppoOld" value="<?php echo $LivelloGruppo; ?>"></input>
                            <input type="hidden" name="GeograficoOld" id="GeograficoOld" value="<?php echo $Geografico; ?>"></input>
                            <input type="hidden" name="TipoRiferimentoOld" id="TipoRiferimentoOld" value="<?php echo $TipoRiferimento; ?>"></input>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroIdMacchina ?></td>
                            <td width="529" class="cella1">
                                <input type="hidden" name="IdMacchina" id="IdMacchina" value="<?php echo $IdMacchina; ?>" ><?php echo $IdMacchina; ?></input></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroCodice ?></td>
                            <td width="529" class="cella1"><input name="CodiceStab" type="text" id="CodiceStab" minlength="8" value="<?php echo $CodiceStab; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><input type="text" name="DescriStab" id="DescriStab" value="<?php echo $DescriStab; ?>" size="50px" ></input></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroRagioneSociale ?></td>
                            <td width="529" class="cella1"><input type="text" name="Ragso1" id="Ragso1" size="50px" value="<?php echo $Ragso1; ?>"></input></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroIdClienteGazie ?></td>
                            <td width="529" class="cella1"><input type="text" name="IdClienteGaz" id="IdClienteGaz" value="<?php echo $IdClienteGaz; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLingua ?></td>
                            <td class="cella1">
                                <select name="Lingua" id="Lingua">
                                    <option value="<?php echo $IdLingua; ?>" selected=""><?php echo $Lingua; ?></option>
                                    <?php
                                    $sql = findAltreLingue($Lingua);

                                    while ($row = mysql_fetch_array($sql)) {
                                        ?>
                                        <option value="<?php echo($row['id_lingua']) ?>"><?php echo($row['lingua']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGeografico ?></td>
                            <td class="cella11"><?php include('./moduli/visualizza_form_modifica_geografico.php'); ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGruppoAcquisto ?></td>
                            <td class="cella11"><?php include('./moduli/visualizza_form_modifica_gruppo.php'); ?></td>
                        </tr>

<!--                        <tr>
                            <td class="cella2"><?php echo $filtroOrigamiDb ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class="cella1"><input type="text" name="UserOrigami" id="UserOrigami" value="<?php echo $UserOrigami; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="PassOrigami" id="PassOrigami" value="<?php echo $PassOrigami; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="ConfermaPassOrigami" id="ConfermaPassOrigami" value="<?php echo $PassOrigami; ?>" /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroServerdb ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class=" cella1"><input type="text" name="UserServer" id="UserServer" value="<?php echo $UserServer; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="PassServer" id="PassServer" value="<?php echo $PassServer; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="ConfermaPassServer" id="ConfermaPassServer" value="<?php echo $PassServer; ?>"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>-->
                            <tr>
                            <td class="cella2"><?php echo $filtroVersioneCloudFab ?></td>
                            <td class="cella1"><input type="text" name="UserOrigami" id="UserOrigami" value="<?php echo $UserOrigami; ?>"/></td>
                            <input type="hidden" name="PassOrigami" id="PassOrigami" value="<?php echo $PassOrigami; ?>"/>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroVersioneOrigami ?></td>
                            <td class="cella1"><input type="text" name="UserServer" id="UserServer" value="<?php echo $UserServer; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroServerFtp ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class=" cella1"><input type="text" name="UserFtp" id="UserFtp" value="<?php echo $UserFtp; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="PassFtp" id="PassFtp" value="<?php echo $PassFtp; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="ConfermaPassFtp" id="ConfermaPassFtp" value="<?php echo $PassFtp; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroZipPassword ?></td>
                                        <td class="cella1"><input type="text" name="PassZip" id="PassZip" value="<?php echo $PassZip; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="text" name="ConfermaPassZip" id="ConfermaPassZip" value="<?php echo $PassZip; ?>"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroAbilitato; ?></td>
                            <td class="cella1"><input type="text" name="Abilitato" id="Abilitato" value="<?php echo $Abilitato; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtAbilitato; ?></td>
                            <td class="cella1"><?php echo $Data; ?></td>
                        </tr>

                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1">
                                <select name="Azienda" id="Azienda"> 
                                    <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                    <?php
                                    //Si selezionano solo le aziende scrivibili dall'utente
                                    for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                        $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                        $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                        if ($idAz <> $IdAzienda) {
                                            ?>
                                            <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>

                                        <?php }
                                    }
                                    ?>
                                </select> 
                            </td>
                        </tr>

                        <td class="cella2" style="text-align: right " colspan="4">

                            <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                            <input type="submit" id="Salva" value="<?php echo $valueButtonSalva ?>" />

                        </td>
                        </tr>
                    </table>
                </form>
            </div>
 <div id="msgLog">
               <?php 
       
        if ($DEBUG) {
        echo "ActionOnLoad : ".$actionOnLoad;
        echo "</br>Tabella gruppo : utenti e aziende visibili : ".$strUtAzGruppo;
        echo "</br>Tabella macchina: Aziende scrivibili: ";
        print_r($arrayAziendeScrivibili);
    }
    
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
