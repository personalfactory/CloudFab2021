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
include('../Connessioni/serverdb.php');
include('../sql/script_accessorio.php');

$CodiceFormula=$_GET['CodiceFormula'];


//############# STRINGHE AZIENDE VISIBILI  #################################
    //Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
   $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'accessorio');

    //##########################################################################

  $sqlAccNp = findAccessoriNotInFormula($CodiceFormula, $strUtentiAziende);
?>
<div id="container" style="width:50%; margin:15px auto;">
	<form class="form" id="AggiungiAccessorio" name="AggiungiAccessorio" method="post" action="aggiungi_accessorio_formula2.php">
    <table width="100%">
    	<input type="hidden" name="CodiceFormula" id="CodiceFormula" value="<?php echo $CodiceFormula;?>"></input>
    		<tr>
            	<td class="cella3" colspan="2"><?php echo $titoloPaginaAggiungiAccessorio ?></td>
        	</tr>
        	<tr>
            	<td class="cella2" colspan="2">
                    <select style="width:80%" name="Accessorio" id="Accessorio">
                        <option value="" selected=""><?php echo $labelOptionSelectAccessorio  ?></option>
                            <?php 
                          
                            //Visualizzo solo i componenti che attualmente non sono associati alla formula
                            
                               while($row=mysql_fetch_array($sqlAccNp)){ ?>
                                <option value="<?php echo($row['codice'])?>"><?php echo $row['descri'] ?></option>
                               <?php }?>
                      </select>
              	</td>
            </tr>
            <tr>
           		<td class="cella2"><?php echo $filtroQuantita ?>  
           		<td class="cella1"><input type="text" name="Quantita" id="Quantita" value=""></td> 
        	</tr>  
		
    		 <?php include('../include/tr_reset_submit.php'); ?>
    	</table>
    </form>
    <div id="msgLog">
                        <?php
                        if ($DEBUG) {
                            echo "</br>Tabella accessorio : Utenti e aziende visibili : " . $strUtentiAziende;
                        }
                        ?>
                    </div>
    </div>
 </div>
</body>
</html>
