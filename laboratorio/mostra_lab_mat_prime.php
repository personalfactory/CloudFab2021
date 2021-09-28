<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<html>
<?php include('../include/validator.php'); ?>
<?php include('../include/header.php'); ?>

<?php include('../include/gestione_date.php'); ?>
<script type="text/javascript" src="./ajax/ajax_lab.js"></script>
</head>

<body>
<?php 
if ( isset($_GET["q"]) ){
	
	$q=$_GET["q"];
	
	$connessione = mysql_connect('localhost', 'root', 'isolmix1503');
	mysql_select_db("serverdb", $connessione);
	
	$CodiceFormula=$q;
	$QtaMiscela=1000;//////Questo valore mi deve arrivare assieme al codice formula
	
	//Calcolo e visualizzo il numero dell'esperimento corrente relativo alla formula selezionata
	$sqlEsper = mysql_query("SELECT MAX(num_prova) as num_esper,id_esperimento 
								FROM 
									lab_esperimento
								WHERE 
									cod_lab_formula='".$CodiceFormula."'") 
                          				
	or die("Errore 10: " . mysql_error());
	while ($rowEsper=mysql_fetch_array($sqlEsper)){
		$NumEsperimento=$rowEsper['num_esper'];   
	}
   	$NumEsperimento=$NumEsperimento+1;
	?> 
        <table style="width:600px;">
        <tr>
	        <td width="200" class="cella2">Numero Esperimento:</td>
	        <td class="cella1"><?php echo $NumEsperimento;?></td>
         </tr>
         
         <tr>
	        <td width="200" class="cella2">Data Registrazione :</td>
	        <td class="cella1"><?php echo dataCorrenteVisualizza();?></td>
         </tr>
         <tr>
	        <td width="200" class="cella2">Ora Registrazione :</td>
	        <td class="cella1"><?php echo OraAttuale();?></td>
         </tr>
        	<tr>
	        	<th height="42" colspan="2" class="cella3">Leggere il Codice a Barre</th>
          </tr>
          <tr>
       	 		<td width="200" class="cella2">Codice a barre:</td>
          		<td class="cella1"><input type="text" name="CodiceBarre" id="CodiceBarre" /></td>
          </tr>
        	          
	  </table>
	<table  style="width:600px;"> 
      	<tr>
	        <td class="cella3">Materie Prima</td>
            <td class="cella3">Quantit&agrave %</td>
            <td class="cella3">Quantit&agrave Teorica</td>
            <td class="cella3" >Pesa</td>
            <td class="cella3" >Risultato Pesa</td>
            
        </tr> 
<?php
 	/////////////////Visualizzo le materie prime pesate////////////////////////////////////////
     	
	   	$QuantitaRealeTot=0;
		//Visualizzo l'elenco materie prime presenti nella tabella lab_matpri_teo e nella tabella lab_peso associate alla formula
		$NMatPri = 1;
		$sqlMatPrime = mysql_query("SELECT
										lab_matpri_teoria.id_mat,
										lab_matpri_teoria.cod_lab_formula,
										lab_materie_prime.cod_mat AS codice,
										lab_materie_prime.descri_materia AS descri,
										lab_matpri_teoria.qta_teo,
										lab_matpri_teoria.qta_teo_perc,
										lab_peso.peso
										FROM
											lab_matpri_teoria
										INNER JOIN 
											lab_materie_prime ON lab_materie_prime.id_mat = lab_matpri_teoria.id_mat
										INNER JOIN 
											lab_peso ON lab_peso.id = lab_materie_prime.id_mat
										WHERE 
											lab_matpri_teoria.cod_lab_formula='".$CodiceFormula."'
										ORDER BY descri_materia") 
		or die("Errore 21: " . mysql_error());
		while($rowMatPrime=mysql_fetch_array($sqlMatPrime)){
		//E' la qta di materia prima da inserire calcolata in base al totale di miscela digitato ed alle percentuali definite nella formula
				  $QtaTeoNew=($rowMatPrime['qta_teo_perc']*$QtaMiscela)/100; 
                 ?>
            
				  <tr>
                     <td class="cella4"><?php echo($rowMatPrime['descri'])?></td>
                     <td class="cella2" >&nbsp;<?php echo ($rowMatPrime['qta_teo_perc']);?></td>
                     <td class="cella2" >&nbsp;<?php echo $QtaTeoNew;?>&nbsp; gr</td>	
                     <td class="cella1">
                        <a href="JavaScript:openWindow('carica_lab_peso.php? DatiPesa=<?php echo ($rowMatPrime['descri']).";".($rowMatPrime['codice']).";". $QtaTeoNew;?>')">
                        <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                    </td>	
					<td class="cella1">
                        <input type="text" style="width: 70px;"name="Qta<?php echo($NMatPri);?>" id="Qta<?php echo($NMatPri);?>" value="<?php echo $rowMatPrime['peso'];?>"/>&nbsp;gr
                    </td>		
				  	       
                </tr>
                <?php 
				$QuantitaRealeTot=$QuantitaRealeTot+$rowMatPrime['peso'];
				
            	$NMatPri++;
			}//End While materie prime ?>
			

		<tr>
			<td colspan="3" class="cella2" >Totale Miscela </td>
			<td class="cella3" colspan="2"><?php echo $QuantitaRealeTot;?>&nbsp;gr</td>
        </tr>
		</table>
        
        <table style="width:600px;">    	
            <tr>
                <td class="cella3">Parametro </td>
                <td class="cella3">Unita di Misura</td>
                <td class="cella3">Valore Teorico</td>
                <td class="cella3">Valore Reale</td>
                
            </tr> 
      	<?php
	 	//Visualizzo l'elenco dei parametri relativi alla formula
	 	$NPar = 1;
	 	$sqlPar = mysql_query("SELECT
									lab_parametro_teoria.id_par,
									lab_parametro_teoria.cod_lab_formula,
									lab_parametro.nome_parametro,
									lab_parametro.descri_parametro,
									lab_parametro.unita_misura,
									lab_parametro_teoria.valore_teo
								FROM
									lab_parametro_teoria
								INNER JOIN 
									lab_parametro ON lab_parametro_teoria.id_par = lab_parametro.id_par
								WHERE 
									lab_parametro_teoria.cod_lab_formula='".$CodiceFormula."'
								ORDER BY 
									nome_parametro") 
		or die("Errore 22: " . mysql_error());
		while($rowPar=mysql_fetch_array($sqlPar)){?>
			<tr>
				 <td class="cella4"><?php echo($rowPar['nome_parametro'])?></td>
                 <td class="cella2"><?php echo($rowPar['unita_misura']);?></td>
                 <td class="cella2"><?php echo($rowPar['valore_teo']);?></td>
           		 <td class="cella1"><input type="text" style="width: 70px;"name="Valore<?php echo($NPar);?>" id="Valore<?php echo($NPar);?>" value="0"/>
                 
			<?php
			$NPar++;
		}//End While parametri ?>
        </table>
        
        <?php 
		mysql_close($connessione);
		
	}else{
			
		//Niente per ora	
		
		}?>
        
</body>
</html>
