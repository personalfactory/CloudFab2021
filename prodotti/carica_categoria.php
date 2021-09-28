<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
    
    if($DEBUG) ini_set(display_errors, "1");
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'categoria');    
    ?>
<script language="javascript">
                function Carica() {
                    document.forms["InserisciCategoria"].action = "carica_categoria2.php";
                    document.forms["InserisciCategoria"].submit();
                }
                function Aggiorna() {
                    document.forms["InserisciCategoria"].action = "carica_categoria.php";
                    document.forms["InserisciCategoria"].submit();
                }
            </script>
    <body >  

        <div id="mainContainer">

            
<?php
include('../include/menu.php');
if (!isset($_POST['NomeCategoria']) && !isset($_POST['DescriCategoria'])) {
    ?>

                <div id="container" style="width:600px; margin:15px auto;">
                    <form id="InserisciCategoria" name="InserisciCategoria" method="post" >
                        <table style="width:600px;">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $linkPaginaCategoria ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroNome . ' : ' ?></td>
                                <td class="cella1"><input type="text" name="NomeCategoria" id="NomeCategoria" /></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroDescrizione . ' : ' ?></td>
                                <td class="cella1"><textarea name="DescriCategoria" id="DescriCategoria" ROWS="1" ></textarea>
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
                                                <?php }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2" ><?php echo $filtroSolNumSacchi . ' : ' ?></td>
                                <td class="cella1"><input type="text" name="SoluzioniTot" id="SoluzioniTot" title="<?php echo $titleNumSoluzioni ?>"/></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="button" onclick="javascript:Aggiorna();" value="<?php echo $valueButtonAggiorna ?>" />
                            </tr>
                        </table>  
                    </form>
                </div>
                <?php
            } else {
                $errore = false;
                $messaggio = $msgErroreVerificato . '<br />';

                if (!isset($_POST['NomeCategoria']) || trim($_POST['NomeCategoria']) == "") {

                    $errore = true;
                    $messaggio = $messaggio . $msgErroreNome . ' !<br />';
                }
                if (!isset($_POST['DescriCategoria']) || trim($_POST['DescriCategoria']) == "") {

                    $errore = true;
                    $messaggio = $messaggio . $msgErrDescri . ' !<br />';
                }
               
                if (!isset($_POST['SoluzioniTot']) || trim($_POST['SoluzioniTot']) == "") {

                    $errore = true;
                    $messaggio = $messaggio . $msgInsertSolSacc . '<br />';
                }
                if (!is_numeric($_POST['SoluzioniTot']) || $_POST['SoluzioniTot'] < 0) {
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrSolSaccNumer . '<br />';
                }
                if ($errore) {
                    //Ci sono errori quindi non salvo
                    echo $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';
                } else {



                    $NomeCategoria = str_replace("'", "''", $_POST['NomeCategoria']);
                    $DescriCategoria = str_replace("'", "''", $_POST['DescriCategoria']);
                    $SoluzioniTot = str_replace("'", "''", $_POST['SoluzioniTot']);
                    list($IdAzienda, $NomeAzienda) = explode(';', $_POST['Azienda']);
                    ?>
                    <div id="container" style="width:600px; margin:15px auto;">
                        <form id="InserisciCategoria" name="InserisciCategoria" method="post" >
                            <table style="width:600px;">
                                <tr>
                                    <td class="cella3" colspan="2"><?php echo $linkPaginaCategoria ?></td>
                                </tr>
                                <tr>
                                    <td class="cella2"><?php echo $filtroNome . ' : ' ?></td>
                                    <td class="cella1"><input type="text" name="NomeCategoria" id="NomeCategoria" value="<?php echo $NomeCategoria; ?>"/></td>
                                </tr>
                                <tr>
                                    <td class="cella2"><?php echo $filtroDescrizione . ' : ' ?></td>
                                    <td class="cella1"><input type="text" name="DescriCategoria" id="DescriCategoria" value="<?php echo $DescriCategoria; ?>"/></td>
                                </tr>
                                <tr>
                                            <tr>
                                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                                <td class="cella1">
                                                    <select name="Azienda" id="Azienda"> 
                                                        <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                                        <?php
                                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                                            if ($idAz != $IdAzienda) {
                                                                ?>
                                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
            <?php }
        } ?>
                                                    </select> 
                                                </td>
                                            </tr>
                                <tr>
                                    <td class="cella2" ><?php echo $filtroSolNumSacchi . ' : ' ?></td>
                                    <td class="cella1"><input type="text" name="SoluzioniTot" id="SoluzioniTot"  value="<?php echo $SoluzioniTot; ?>"/></td>
                                </tr>
        <?php
        for ($i = 1; $i <= $SoluzioniTot; $i++) {
            if (isset($_POST['Soluzione' . $i])) {
                ?>
                                        <tr>
                                            <td class="cella2"><?php echo $filtroNumSacPerSol . ' ' . $i; ?>  :</td>
                                            <td class="cella1"><input type="text" name="Soluzione<?php echo $i; ?>" id="Soluzione<?php echo $i; ?>" value="<?php echo $_POST['Soluzione' . $i]; ?>"/></td>
                                        </tr>
            <?php } else {
                ?>
                                        <tr>
                                            <td class="cella2"><?php echo $filtroNumSacPerSol . ' ' . $i; ?>  :</td>
                                            <td class="cella1"><input type="text" name="Soluzione<?php echo $i; ?>" id="Soluzione<?php echo $i; ?>" /></td>
                                        </tr>	
                <?php
            }
        }
        ?>
                                <tr>
                                    <td class="cella2" style="text-align: right " colspan="2">
                                        <input type="reset" value="<?php echo $valueButtonAnnulla ?>"  onClick="javascript:history.back();"/>
                                        <input type="button" value="<?php echo $valueButtonAggiorna ?>" onClick="javascript:Aggiorna();"   />
                                        <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="javascript:Carica();"/></td>
                                </tr>

                            </table> 
                            </form>
            </div> 

    <?php }
}
?>

<div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella categoria: AZIENDE SCRIVIBILI: </br>";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
        </div><!--mainContainer-->
    </body>
</html> 