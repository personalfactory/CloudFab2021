<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('./sql/script_lab_caratteristica.php');
            ini_set(display_errors, "1");
           
           list($IdCar, $NomeCar) = explode(";", $_POST['Caratteristica']);
           $IdEsperimento= $_POST['IdEsperimento'];
           ?>
           
            <div id="container" style="width:60%; margin:15px auto;">
                <form id="NuovoAllegato" name="NuovoAllegato" method="POST"  enctype="multipart/form-data" action="carica_lab_allegato2.php"  >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovoAllegato ?></td>
                        </tr>
                    <tr>
                            <td class="cella2"><?php echo $filtroLabCaratteristica ?></td>

                            <td class="cella1">
                               <?php echo $NomeCar ?>
                             <input type="hidden" name="IdCarat" value="<?php echo $IdCar ?>"/>  
                             <input type="hidden" name="IdEsper" value="<?php echo $IdEsperimento ?>"/>  
                            </td>
                        </tr>  
                        <tr>
                            <td class="cella2"><?php echo $filtroDescriFile ?></td>
                            <td class="cella1" ><textarea name="Descri" id="Descri" ROWS="2" COLS="60"></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCaricaDocumento ?></td>
                            <td class="cella1" ><input type="file" name="user_file" value="dsfgdfg"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type ="submit" value="<?php echo $valueButtonCarica ?>" /></td>
                        </tr>
                    </table>
                </form>
            </div>