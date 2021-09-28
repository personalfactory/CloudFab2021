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
	<form id="InserisciComune" name="InserisciComune" method="post" action="carica_comune2.php">
    <table width="500px">
        <tr>
          <td class="cella3" colspan="2"><?php echo $titoloNuovoRif?></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroCap?> :</td>
            <td class="cella1"><input type="text" name="Cap" id="Cap" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroCatasto?> :</td>
            <td class="cella1"><input type="text" name="CodiceCatastale" id="CodiceCatastale" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroIstat?> :</td>
            <td class="cella1"><input type="text" name="CodiceIstat" id="CodiceIstat" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroComune?> :</td>
            <td class="cella1"><input type="text" name="Comune" id="Comune" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroCodProvincia?> :</td>
            <td class="cella1"><input type="text" name="CodiceProvincia" id="CodiceProvincia" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroProvincia?> :</td>
            <td class="cella1"><input type="text" name="Provincia" id="Provincia" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroCodRegione?> :</td>
            <td class="cella1"><input type="text" name="CodiceRegione" id="CodiceRegione" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroRegione?> :</td>
            <td class="cella1"><input type="text" name="Regione" id="Regione" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroCodStato?> :</td>
            <td class="cella1"><input type="text" name="CodiceStato" id="CodiceStato" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroStato?> :</td>
            <td class="cella1"><input type="text" name="Stato" id="Stato" /></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroContinente?> :</td>
            <td class="cella1"><input type="text" name="Continente" id="Continente" /></td>
        </tr>
        <?php include('../include/tr_reset_submit.php'); ?>
    </table>
    </form>
 </div>
 
</div><!--mainContainer-->

</body>
</html>
