<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript" type="text/javascript">

        function controllaCampi() {

            var rv = true;
            var msg = "";


            //####### CONTROLLO CAMPI ############################################
            if (document.getElementById('Nome').value === "") {
                rv = false;
                msg = msg + "Insert name! ";
            }
            if (document.getElementById('Cognome').value === "") {
                rv = false;
                msg = msg + "Insert surname! ";
            }
            if (document.getElementById('FiguraTipo').value === "") {
                rv = false;
                msg = msg + "Select title! ";
            }
            if (document.getElementById('IdMacchina').value === "") {
                rv = false;
                msg = msg + "Select factory! ";
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
    
    if ($DEBUG)
        ini_set('display_errors', 1);
    //############ GESTIONE UTENTI #############################################
    $strUtAzGruppo = getStrUtAzVisib($_SESSION['objPermessiVis'], 'gruppo');
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'figura');

    //############ VERIFICA PERMESSO SCRITTURA GENERICO ########################
    $actionOnLoad = "";
    $elencoFunzioni = array("96");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_comune.php');
            include('../sql/script_gruppo.php');
            include('../sql/script_figura_tipo.php');

            $pagina = "carica_figura.php";

            $sqlFig = findAllTipoFigure("figura", "1");
            ?>
            <div id="container" style="width:800px; margin:15px auto;">
                <form id="InserisciOperOri" name="InserisciOperOri" method="post" onsubmit="return controllaCampi()" action="carica_figura2.php">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $nuovoDipendente ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNome ?> </td>
                            <td class="cella1"><input type="text" name="Nome" id="Nome" maxlenght="8"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCognome ?> </td>
                            <td class="cella1"><input type="text" name="Cognome" id="Cognome" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFigura ?> </td>
                            <td class="cella1">
                                <select name="FiguraTipo" id="FiguraTipo">
                                    <option value="" selected=""><?php echo $labelOptionFiguraDefault ?></option>
                                    <?php
                                    while ($rowFig = mysql_fetch_array($sqlFig)) {
                                        ?>
                                        <option value="<?php echo $rowFig['id_figura_tipo']; ?>"><?php echo ($rowFig['figura']); ?></option>
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
<!--                        <tr>
                        <td class="cella2"><?php echo $filtroUtenteInephos ?> </td>
                        <td class="cella1">
                            <select name="UtenteInephos" id="UtenteInephos">
                                <option value="" selected=""><?php echo $labelOptionSelectUtente ?></option>
                        <?php
//                                    $sqlUt = mysql_query("SELECT * FROM serverdb.utente WHERE abilitato=1 GROUP BY id_utente ORDER BY cognome,nome") or die("Errore 1 SELECT serverdb.utente : " . mysql_error());
//                                    while ($rowUt = mysql_fetch_array($sqlUt)) {
                        ?>
                                    <option value="<?php // echo $rowUt['id_utente'];   ?>"><?php // echo ($rowUt['cognome'] . " " . $rowUt['nome']);   ?></option>
                        <?php // }  ?>
                            </select> 
                        </td>
                    </tr>-->

                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "ActionOnLoad: " . $actionOnLoad;
                    echo "</br>Tab gruppo : Utenti e aziende visibili " . $strUtAzGruppo;
                    echo "</br>Tabella figura: AZIENDE SCRIVIBILI: ";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
