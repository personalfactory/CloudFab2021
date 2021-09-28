<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>
<div id="mainContainer">

<?php include('../include/menu.php'); ?>

<div id="container" style="width:500px; margin:15px auto;">
	<form id="InserisciGruppo" name="InserisciGruppo" method="post" action="carica_gruppo2.php">
    <table width="500px">
    <tr>
      <td class="cella3" colspan="2"><?php echo $titoloInsertGruppo?></td>
    </tr>
    <tr>
    	<td class="cella2"><?php echo $filtroPrimoLivello ?> </td><td class="cella1"><input type="text" name="PrimoLivello" id="PrimoLivello"/></td>
    </tr>
        <tr>
    	<td class="cella2"><?php echo $filtroSecondoLivello ?> </td><td class="cella1"><input type="text" name="SecondoLivello" id="SecondoLivello"/></td>
    </tr>
    <tr>
    	<td class="cella2"><?php echo $filtroTerzoLivello ?> </td><td class="cella1"><input type="text" name="TerzoLivello" id="TerzoLivello"/></td>
    </tr>
        <tr>
    	<td class="cella2"><?php echo $filtroQuartoLivello ?> </td><td class="cella1"><input type="text" name="QuartoLivello" id="QuartoLivello"/></td>
    </tr>
    <tr>
    	<td class="cella2"><?php echo $filtroQuintoLivello ?> </td><td class="cella1"><input type="text" name="QuintoLivello" id="QuintoLivello"/></td>
    </tr>
    <tr>
        <td class="cella2"><?php echo $filtroSestoLivello ?> </td><td class="cella1"><input type="text" name="SestoLivello" id="SestoLivello"/></td>
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

</div><!--mainContainer-->

</body>
</html>
