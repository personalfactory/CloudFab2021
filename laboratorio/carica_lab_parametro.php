<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
        <script language="javascript" src="../js/visualizza_elementi.js"></script>
        <script language="javascript">
            function disabilitaOperazioni() {

                document.getElementById('Salva').disabled = true;

            }
        </script>
    </head>
    <?php
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_parametro');

    //############# VERIFICA PERMESSO DI SCRITTURA 2 ##############
    $actionOnLoad = "";
    $arrayTabelleCoinvolte = array("lab_parametro");
    //Se il proprietario del dato è un utente diverso dall'utente 
    //corrente si verifica il permesso 3
    if ($DEBUG)
        echo "</br>Eseguita verifica permesso di tipo 2";
    $actionOnLoad = verificaPermScrittura2($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte);
    ?>
    <body onLoad="<?php echo $actionOnLoad ?>"> 
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            ?>

            <div id="container" style="width:50%; margin:15px auto;">

                <form id="InserisciParametro" name="InserisciParametro" method="post" action="carica_lab_parametro2.php">
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="cella3"><?php echo $titoloPaginaLabNuovoParametro ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabNome ?></td>
                            <td class="cella1"><input type="text" size="40px" name="NomeParametro" id="NomeParametro" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabDescri ?></td>
                            <td class="cella1"><input type="text" size="40px" name="Descrizione" id="Descrizione" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabUnMisura ?></td>
                            <td class="cella1"><input type="text" name="UnitaMisura" id="UnitaMisura" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabTipo ?></td>
                            <td class="cella1">
                                <select name="Tipo" id="Tipo">
                                    <optgroup >
                                        <option value="<?php echo $PercentualeSI; ?>"><?php echo $filtroLabPercSi ?></option>
                                        <option value="<?php echo $PercentualeNO; ?>"><?php echo $filtroLabPercNo ?></option>
                                    </optgroup>
                                </select>
                            </td>
                        </tr>        
                        <tr>
                            <td class="cella2"><?php echo $filtroLabData ?></td>
                            <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
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
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>

        </div><!-- mainContainer-->

    </body>
</html>
