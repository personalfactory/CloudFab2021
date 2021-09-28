<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript" type="text/javascript">

        function controllaCampi(msgErrCodice) {

            var rv = true;
            var msg = "";


            if (document.getElementById('Codice').value === "") {
                rv = false;
                msg = msg + ' ' + msgErrCodice;
            }
            if (!rv) {
                alert(msg);
                rv = false;
            }
            return rv;

        }
        function Salva() {

            document.forms["InserisciAccessorio"].action = "carica_accessorio2.php";
        }

       
    </script>
<?php
    include('../Connessioni/serverdb.php');
    include('../include/gestione_date.php');
   

   if($DEBUG) ini_set(display_errors, "1");
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'accessorio');    
    ?>

    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:60%; margin:15px auto;">
                <form id="InserisciAccessorio" name="InserisciAccessorio" method="post" onsubmit="return controllaCampi('<?php echo $msgErrCodice ?>')" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovoAccessorio ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodice ?></td>
                            <td class="cella1"><input type="text" name="Codice" id="Codice" size="30px"/>
                            </td>
                        </tr>
                        <td class="cella4"><?php echo $filtroDescrizione ?> </td>
                        <td class="cella1"><input type="text" name="Descrizione" id="Descrizione" size="50"/></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroUniMisura ?></td>
                            <td class="cella1"><input type="text" name="UnitaMisura" id="UnitaMisura" size="50"/></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroPrezzoAcq ?></td>
                            <td class="cella1"><input type="text" name="PreAcq" id="PreAcq" size="50"/></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroDt ?></td>
                            <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
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
                                                <?php }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                        </tr>
                    </table>
                </form>
            </div>

<div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella accessorio: AZIENDE SCRIVIBILI: </br>";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>

