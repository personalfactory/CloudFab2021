<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>

        <?php
        if ($DEBUG)
            ini_set('display_errors', '1');
        //Costruzione dell'array contenente i vari msg di errore
        $arrayMsgErrPhp = array($msgErrSelectAz, //0
            $msgErrSelectAnno, //1
            $msgErrSelectCliente, //2
            $msgErrTassoCambio,//3
            $msgAlertTassoCambio//4
        );
        ?>
        <script language="javascript" type="text/javascript">

            function BloccaTastoInvio(evento)
            {
                codice_tasto = evento.keyCode ? evento.keyCode : evento.which ? evento.which : evento.charCode;
                if (codice_tasto == 13)
                {
                    event.returnValue = false;
                } 
            }

            //Trasformo l'array da php a js
            var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");
            function controllaCampi(arrayMsgErrJs) {

                var rv = true;
                var msg = "";
                if (document.getElementById('Azienda').value === "") {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[0];
                }

                if (isNaN(document.getElementById('Anno').value) || document.getElementById('Anno').value === "") {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[1];
                }
                if (document.getElementById('Cliente').value === "") {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[2];
                }
                if (isNaN(document.getElementById('Cambio').value) ||
                        document.getElementById('Cambio').value === "" ||
                        document.getElementById('Cambio').value === "0") {
                    rv = false;
                    msg = msg + ' ' + arrayMsgErrJs[3];
                }
                if (!rv) {

                    document.getElementById('Anno').value = "";
                    document.getElementById('Cliente').value = "";
                    alert(msg);
                    rv = false;
                }
                return rv;
            }
            
            function AlertValuta(){
                alert(arrayMsgErrJs[4]);
            }
            function Conferma() {
                if (controllaCampi(arrayMsgErrJs)) {
                    document.forms["CaricaBs"].action = "carica_info_bs.php";
                    document.forms["CaricaBs"].submit();
                }
            }
            function AggiornaPagina() {
                //Funzione che viene chiamata per aggiornare la valuta in base al cambio (file include/scelata_valuta.php)
                document.forms["CaricaBs"].action = "carica_bs.php";
                document.forms["CaricaBs"].submit();
            }
        </script>
    </head>
    <?php
    include('../include/precisione.php');
    include('../include/gestione_date.php');
    include('../Connessioni/serverdb.php');
    include('../sql/script_bs_cliente.php');

    //###### VERIFICA PERMESSI #################################################
    $actionOnLoad = "";
    $elencoFunzioni = array("129"); //CREARE UNA NUOVA SIMULAZIONE
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziendeClienti = getStrUtAzVisib($_SESSION['objPermessiVis'], 'bs_cliente');

    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'bs_riepilogo');

    $_SESSION['Anno'] = "";
    $_SESSION['id_cliente'] = "";
    $_SESSION['Nominativo'] = "";

    $_SESSION['ScontoKit'] = "";
    $_SESSION['PrezzoMacchina'] = "";
    $_SESSION['CostoOperaio'] = "";
    $_SESSION['Produttivita'] = "";
    $_SESSION['CostoElettricita'] = "";
    $_SESSION['AnniAmmortamentoMac'] = "";
    $_SESSION['CostoSacco'] = "";
    $_SESSION['CostoTrasporto'] = "";
    $_SESSION['SpeseMarketing'] = "";
    $_SESSION['CostiAnno'] = "";
    $_SESSION['AnniAmmAltriInv'] = "";
    $_SESSION['AltriInvestimenti'] = "";
    $_SESSION['ScontoPrivato'] = "";
    $_SESSION['ScontoImpresa'] = "";
    $_SESSION['ScontoRivenditore'] = "";
    $_SESSION['NumeroOreLavorabili'] = "";

    $_SESSION['Cliente'] = ";" . $labelOptionSelectCliente;
    $_SESSION['Nominativo'] = $labelOptionSelectCliente;
    if (isSet($_POST['Cliente'])) {
        $_SESSION['Cliente'] = $_POST['Cliente'];
        list($IdCliente, $Nominativo) = explode(';', $_POST['Cliente']);
        $_SESSION['id_cliente'] = $IdCliente;
        $_SESSION['Nominativo'] = $Nominativo;
    }

    $_SESSION['Anno'] = $labelOptionSelectAnno;
    if (isset($_POST['Anno'])) {
        $_SESSION['Anno'] = trim($_POST['Anno']);
    }

    if (isset($_POST['Azienda'])) {
        list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
        $_SESSION['id_azienda'] = $IdAzienda;
    }


    //TODO_bs può essere NEW oppure MODIFY
    if (isSet($_GET['TODO_bs']))
        $_SESSION['TODO_bs'] = $_GET['TODO_bs'];


    $sqlClienti = findClientiBsByUtente($strUtentiAziendeClienti, "nominativo");


//    echo "<br/>SESSION Anno : " . $_SESSION['Anno'];
//    echo "<br/>SESSION Nominativo : " . $_SESSION['Nominativo'];
//    echo "<br/>SESSION id_azienda : " . $_SESSION['id_azienda'];
//    echo "<br/>SESSION id_cliente : " . $_SESSION['id_cliente'];
//    echo "<br/>SESSION TODO_bs : " . $_SESSION['TODO_bs'];
//##################################################################    
//################### GESTIONE VALUTA ##############################
//##################################################################
    //Recupero il valore della valuta selezionata (vedi file include/scleta_valuta.php)
    if (isset($_POST['valutaBs'])) {

        foreach ($_POST['valutaBs'] as $key => $value) {

            $_SESSION['valutaBs'] = $key;
        }
    }
    if (isSet($_SESSION['valutaBs'])) {
        switch ($_SESSION['valutaBs']) {
            case 1:
                $_SESSION['cambio'] = 1;
                $_SESSION['filtro'] = "filtroEuro";
                break;
            case 2:
                if (isSet($_POST['Cambio']))
                    $_SESSION['cambio'] = trim($_POST['Cambio']);
                $_SESSION['filtro'] = "filtroDollaro";
                break;
        }
    } else {
        $_SESSION['valutaBs'] = 1;
        $_SESSION['cambio'] = 1;
        $_SESSION['filtro'] = "filtroEuro";
    }
    $filtroValuta = "{${$_SESSION['filtro']}}";


//            echo "<br/>valutabs: " . $_SESSION['valutaBs'];
//            echo "<br/>cambio: " . $_SESSION['cambio'];
//            echo "<br/>filtro: " . $_SESSION['filtro'];
    //##################################################################
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:60%; margin:15px auto;">


                <form id="CaricaBs" name="CaricaBs" method="POST" >
                    <?php include('../include/scelta_valuta.php'); ?>
                    <div style="float:right;" >
                        <?php echo $filtroTassoCambio ?>
                        <input type="text" style="text-align:right;width:50px" title="<?php echo $titleTassoCambio ?>"  id="Cambio" name="Cambio" value="<?php echo $_SESSION['cambio'] ?>" onkeypress="BloccaTastoInvio(event);" onChange="javascript:AlertValuta()"/>

                    </div>
                    <br/><br/><br/>
                    
                    <table width="100%">
                        <tr>
                            <td class="cella3"  colspan="2"><?php echo $titoloPaginaNuovaSimulazione ?></td>
                        </tr> 
                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1" >
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
                            <td class="cella2"><?php echo $filtroAnnoRif ?></td>
                            <td class="cella1">
                                <select name="Anno" id="Anno">
                                    <option value="<?php echo $_SESSION['Anno'] ?>" selected="<?php echo $_SESSION['Anno'] ?>"><?php echo $_SESSION['Anno'] ?></option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option> 
                                    <option value="2019">2019</option> 
                                    <option value="2020">2020</option> 
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroCliente ?></td>
                            <td class="cella1">
                                <select name="Cliente" id="Cliente" onChange="javascript:AggiornaPagina();"> 
                                    <option value="<?php echo $_SESSION['Cliente'] ?>" selected="<?php echo $_SESSION['Cliente'] ?>"><?php echo $_SESSION['Nominativo'] ?></option>
                                    <?php while ($rowCl = mysql_fetch_array($sqlClienti)) { ?>
                                        <option value="<?php echo $rowCl['id_cliente'] . ";" . $rowCl['nominativo'] ?>"><?php echo $rowCl['nominativo'] ?></option>
                                    <?php } ?>
                                </select> 
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="location.href='gestione_info_bs.php'"/>
                                <input type="button" name='129' value="<?php echo $valueButtonConferma ?>" onClick="controllaCampi(arrayMsgErrJs);Conferma();"/>
                            </td></tr>
                    </table>
                </form>
            </div>

            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella bs_riepilogo: AZIENDE SCRIVIBILI: </br>";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>

