<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
     <?php
    
    if($DEBUG) ini_set(display_errors, "1");
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'codice');    
    ?>
    
    <body >
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:500px; margin:15px auto;">
                <form id="InserisciCodice" name="InserisciCodice" method="post" action="carica_codice2.php">
                    <table width="500px">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $labelInserimentoCodice ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroTipoCodice ?> </td>
                            <td class="cella1"><input type="text" name="TipoCodice" id="TipoCodice" maxlenght="3"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?> </td>
                            <td class="cella1"><input type="text" name="Descrizione" id="Descrizione" /></td>
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
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>
<div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella codice: AZIENDE SCRIVIBILI: </br>";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>
