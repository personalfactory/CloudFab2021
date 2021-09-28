<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<!-- posiziona il cursore nell'input text -->
<body onload="document.getElementById('CodiceMatReale').focus()">
<h1><img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone2" title="Clicca per pesare"/> </h1>


<?php 
//Se non è ancora stato letto il codice della scatola di materia prima compare la form vuota 
//Vengono memorizzati nelle rispettive variabili i dati relativi alla pesa da effettuare che sono arrivati tramite GET
//Vengono inoltre mandati tramite POST all'aggiornamento della pagina stessa

if (isset($_POST['CodiceMatTeo']) && isset($_POST['CodiceMatTeo'])){
	$DescriMatTeo=$_POST['DescriMatTeo']; 
	$CodiceMatTeo=$_POST['CodiceMatTeo']; 
	$QtaTeoNew = $_POST['QtaTeoNew']; 
	
	?>
    <h1>Pesa di <?php  echo $DescriMatTeo;?></h1>
	<div id="container" style="width:500px; margin:15px ;">
   
	<?php 
	$Peso=0;
	//Seleziono la bilancia da cui estrarre il peso in base alla quantità di materia prima da pesare 
				include('../Connessioni/serverdb.php'); 
				if( $QtaTeoNew>0 && $QtaTeoNew<=10 )	  	{ $Bilancia=1; }
				if( $QtaTeoNew>=11 && $QtaTeoNew<=1000 )	{ $Bilancia=2; }
				if( $QtaTeoNew>1000 )						{ $Bilancia=3; }
                
				
				//Seleziono il valore del peso dalla bilancia 
				if($Bilancia==1){ 
					
					$sqlPeso=mysql_query("SELECT bilancia1 FROM lab_bilancia ")
					or die("Errore 125 :".mysql_error()); 
					while ($rowPeso=mysql_fetch_array($sqlPeso)){
							$Peso=$rowPeso['bilancia1'];
							
					}
				}
				if($Bilancia==2){ 
					
					$sqlPeso=mysql_query("SELECT bilancia2 FROM lab_bilancia ")
					or die("Errore 125 :".mysql_error());  
					while ($rowPeso=mysql_fetch_array($sqlPeso)){
							$Peso=$rowPeso['bilancia2']; 
							
					}
				}
				if($Bilancia==3){ 
					
					$sqlPeso=mysql_query("SELECT bilancia3 FROM lab_bilancia ")
					or die("Errore 125 :".mysql_error());  
					while ($rowPeso=mysql_fetch_array($sqlPeso)){
						$Peso=$rowPeso['bilancia3'];
					
					}
                }
			
			//Aggiorno il peso della materia prima nella mia tabella [lab_peso] con il valore letto dalla tabella [lab_bilancia]
			mysql_query("UPDATE lab_peso SET peso=". $Peso ." WHERE cod_mat='".$CodiceMatTeo."'")
			or die("Errore 125.1 :".mysql_error()); 

			//Azzero la tabella [lab_bilancia]
			mysql_query("DELETE FROM lab_bilancia")
			or die("Errore 125.2 :".mysql_error()); 	
			
			echo'<div id="msg">Registrati '.$Peso.' grammi !</div><br/>'; ?>
            
			<input type="reset" value="Fine" onclick="window.opener.location.reload(); window.close();" /> 
    
 	</div>
<?php 

}?>

		
		
	

   
</body>
</html> 