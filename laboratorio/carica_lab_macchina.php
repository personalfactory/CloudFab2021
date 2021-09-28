<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>

    <?php
    if ($DEBUG)
        ini_set(display_errors, "1");
    //############### STRINGHE AZIENDE SCRIVIBILI ##############################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_macchina');
    ?>
    <body>

        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>

            <div id="container" style="width:500px; margin:15px auto;">
                <form id="InserisciColore" name="InserisciLabMacchina" method="post" action="carica_lab_macchina2.php">
                    <table width="500px">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloLabPagNuovaRosetta ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabNome ?></td>
                            <td class="cella1"><input type="text" name="Nome" id="Nome" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabDescri ?></td>
                            <td class="cella1"><input style="width:300px" type="text" name="Descrizione" id="Descrizione" /></td>
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
                            <td class="cella2" colspan="2" style="text-align:right">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>" /></td>
                        </tr>
                    </table>
                </form>
            </div>

        </div><!--maincontainer-->

    </body>
</html>
