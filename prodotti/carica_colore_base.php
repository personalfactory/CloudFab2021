<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
 

    <?php
    
    if($DEBUG) ini_set(display_errors, "1");
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'colore_base');  
    
  
    ?>
    <body >


<div id="mainContainer">

<?php include('../include/menu.php'); ?>

  <div id="container" style="width:500px; margin:15px auto;">
	<form id="InserisciColore" name="InserisciColore" method="post" action="carica_colore_base2.php">
      <table width="100%">
        <tr>
          <td class="cella3" colspan="2"><?php echo $linkNuovoColore?></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroCodice?> </td>
            <td class="cella1"><input type="text" name="CodiceColoreBase" id="CodiceColoreBase" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroNome?> </td>
            <td class="cella1"><input type="text" name="NomeColoreBase" id="NomeColoreBase" /></td>
        </tr>
        <tr>
          <td class="cella2"><?php echo $filtroCostoEuro?> </td>
            <td class="cella1"><input type="text" name="CostoColoreBase" id="CostoColoreBase" /></td>
        </tr>
          <tr>
          <td class="cella2"><?php echo $filtroTolleranza?> % </td>
            <td class="cella1"><input type="text" name="Tolleranza" id="Tolleranza" /></td>
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
                    echo "</br>Tabella colore_base: AZIENDE SCRIVIBILI: </br>";
                    for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                        echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                    }
                }
                ?>
            </div>
</div><!--mainContainer-->

</body>
</html>
