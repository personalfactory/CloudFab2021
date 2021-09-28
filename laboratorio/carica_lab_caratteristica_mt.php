<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
     <?php
    if($DEBUG) ini_set(display_errors, "1"); 
    //############### STRINGHE AZIENDE SCRIVIBILI ##############################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_caratteristica_mt');       

    ?>
<body>
<div id="mainContainer">
<?php 
include('../include/menu.php');  
//include('../js/visualizza_elementi.js');  
include('../Connessioni/serverdb.php');
include('../include/gestione_date.php'); 
include('../include/precisione.php'); 
?>
<script language="javascript" src="../js/visualizza_elementi.js"></script>
<div id="container" style="width:60%; margin:15px auto;">
	<form id="InserisciCaratteristica" name="InserisciCaratteristica" method="post" action="carica_lab_caratteristica_mt2.php">
        <table width="100%">
            <tr>
               <td colspan="2" class="cella3"><?php echo $titoloPaginaLabNuovaProprieta ?></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabDescri ?></td>
                <td class="cella1"><textarea name="Descrizione" id="Descrizione" ROWS="2" COLS="48"></textarea></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabProprietaMt ?></td>
                <td class="cella1"><input type="text" name="Caratteristica" id="Caratteristica" size="48px"/></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabUnMisura ?></td>
                <td class="cella1"><input type="text" name="UniMisCar" id="UniMisCar" /></td>
            </tr>            
            <tr>
                <td  class="cella2"><?php echo $filtroLabTipoDato ?></td>
                <td class="cella1">
                <select name="TipoDato" id="TipoDato">
                    <option value="<?php echo $valCarNum ?>"><?php echo $filtroLabNumerico ?></option>
                    <option value="<?php echo $valCarTxt ?>"><?php echo $filtroLabTesto ?></option>
                    </optgroup>
                  </select></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabDimensione ?></td>
                <td class="cella1"><input type="text" name="Dimensione" id="Dimensione" /></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabUnMisura ." ".$filtroLabDimensione?></td>
                <td class="cella1"><input type="text" name="UniMisDim" id="UniMisDim" /></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabMetodologia ?></td>
                <td class="cella1"><input type="text" name="Metodologia" id="Metodologia" /></td>
            </tr>
            <tr>
                <td class="cella2"><?php echo $filtroLabData ?></td>
                <td class="cella1"><?php echo dataCorrenteVisualizza();?></td>
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
                           
                           
                            echo "</br>Tabella lab_caratteristica_mt: Aziende scrivibili: </br>";

                            for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                                echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                            }
                            
                        }
                        ?>
                    </div>
</div><!-- mainContainer-->

</body>
</html>
