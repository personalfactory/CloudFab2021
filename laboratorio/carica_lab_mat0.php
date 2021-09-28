<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>

<div id="mainContainer">

	<?php include('../include/menu.php'); ?>
    
    <div id="container" style="width:40%; margin:40px auto;">
    
        <table  width="100%" >
            <tr>
      		<td class="cella3" colspan="2"><?php echo $titoloPaginaLabNuovaMatPrima ?></td>
    	</tr>
            <tr>
                <td class="cella1"><?php echo $filtroLabSelezionaMatDaGazie ?></td>
                <td class="cella1" width="50px"><a href="carica_lab_materia.php?ToDo=<?php echo 'ScegliDaGazie'; ?>">
                        <img src="/CloudFab/images/pittogrammi/componenti_G.png" class="icone2" title="<?php echo $titleLabInsMatPrima?>"/></a></td>
            </tr>
            <tr>
                <td class="cella1"><?php echo $filtroLabInserisciNewMatPri ?></td>
                <td class="cella1" width="50px"><a href="carica_lab_materia.php?ToDo=<?php echo 'DigitaNuova'; ?>">
                        <img src="/CloudFab/images/pittogrammi/componenti_R.png" class="icone2" title="<?php echo $titleLabInsMatPrima?>"/></a></td>
            </tr>
                <td class="cella2" style="text-align: right " colspan="2"><input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"></td> 
            </tr>
        </table>
    </div>

</div> <!--mainContainer-->


</body>
</html>
