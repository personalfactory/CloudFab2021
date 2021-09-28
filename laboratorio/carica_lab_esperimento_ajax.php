<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
<?php include('../include/gestione_date.php'); ?>
</head>
<script type="text/javascript" src="./ajax/ajax_lab.js"></script>
<script type="text/javascript" src="../js/popup.js"></script>
<body onload="init();">
    
<h1>Laboratorio</h1>
<?php 
include('../include/menu.php'); 

$connessione = mysql_connect('localhost', 'root', 'isolmix1503');
mysql_select_db("serverdb", $connessione);

?>

<div id="container" style="width:600px; margin:15px auto;">
<form id="InserisciLabMiscela" name="InserisciLabMiscela"  >
	  <table style="width:600px;">
	      <tr>
	        	<th height="42" colspan="2" class="cella3">Nuovo Prova di Laboratorio</th>
          </tr>
          <tr>
	      		<td width="200" class="cella2">Formula:</td>
	        	<td class="cella1">
            	<select name="Formula" id="Formula" onChange="mostraInfo(this.value)">
            		<option value="" selected>Selezionare il Codice </option>
				  <?php
                  //Visualizzo solo i codici formula esistenti 
                  $sqlCodFormula = mysql_query("SELECT cod_lab_formula
                                                  FROM 
                                                      serverdb.lab_formula
                                                  ORDER BY 
                                                      cod_lab_formula") 
                                    or die("Errore 109: " . mysql_error());
                  while ($rowCodFormula=mysql_fetch_array($sqlCodFormula)){
		
		
                   		echo "<option value='$rowCodFormula[cod_lab_formula]'>$rowCodFormula[cod_lab_formula]																														 					</option>";
                    }//End while codici formula?>
                </select> 
            	</td>
          </tr>
  <!--E' questa la quantit� che devo mandare assieme al codice formula-->
           <tr>
       	 		<td width="200" class="cella2">Quantit&agrave; Totale di Miscela :</td>
          		<td class="cella1"><input type="text" name="QtaMiscela" id="QtaMiscela" value="0"/>&nbsp;gr</td>
          </tr>
                  
      </table>
       <div id="info">
    
   		<!--Visualizza Materie prime e parametri associati all formula vedi mostra_lab_mat_prime.php-->
        
       </div>
     </form>
  	    	
        
       
    </form>
 </div>
 
</body>
</html>
