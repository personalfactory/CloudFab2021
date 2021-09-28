<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<!-- posiziona il cursore nell'input text -->
<body onload="document.getElementById('CodiceMatReale').focus()">

<script language="javascript">
	function RegistraPeso(){
		document.forms["PesaMateriePrime"].action = "carica_lab_peso2.php";
		document.forms["PesaMateriePrime"].submit();
	}
	function Aggiorna(){
		document.forms["PesaMateriePrime"].action = "carica_lab_peso.php";
		document.forms["PesaMateriePrime"].submit();
	}
</script>
<?php 
//Se non è ancora stato letto il codice della scatola di materia prima compare la form vuota 
//Vengono memorizzati nelle rispettive variabili i dati relativi alla pesa da effettuare che sono arrivati tramite GET
//Vengono inoltre mandati tramite POST all'aggiornamento della pagina stessa

if (!isset($_POST['CodiceMatReale']) ){
	list($DescriMatTeo,$CodiceMatTeo, $QtaTeoNew) = explode (';',$_GET['DatiPesa']);
	?>
    <h1><img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone2" title="Clicca per pesare"/> Pesa di <?php  echo $DescriMatTeo;?></h1>
	<div id="container" style="width:600px; margin:15px auto;">
		<form id="PesaMateriePrime" name="PesaMateriePrime" method="post" >
    		<table style="width:600px;">
                <tr>
                  <td class="cella3" colspan="2">Leggere con lettore ottico il Codice della Materia Prima</td>
                </tr>
                <tr>
                    <td class="cella2">Codice Materia Prima :</td>
                    <td class="cella1"><input type="text" name="CodiceMatReale" id="CodiceMatReale" /></td>
                </tr>
                <tr>
                    <td class="cella2">Quantità di Materia Prima  :</td>
                    <td class="cella1"><?php  echo  $QtaTeoNew; ?>&nbsp;g</td>
                </tr>
                <!--mando i campi utili all'aggiornameto della pagina  -->
                <input type="hidden" name="DescriMatTeo" id="DescriMatTeo" value="<?php  echo $DescriMatTeo;?>"/>
                <input type="hidden" name="CodiceMatTeo" id="CodiceMatTeo" value="<?php  echo $CodiceMatTeo;?>"/>
                <input type="hidden" name="QtaTeoNew" id="QtaTeoNew" value="<?php  echo $QtaTeoNew;?>"/>
                                
         	</table>   
         	<table>
              	<tr >
                  <td><input type="button" onclick="javascript:Aggiorna();" value="Avanti" /></td>
                 </tr>  
      		</table>  
   		</form>
 	</div>
<?php 

}
//Se è stato letto il codice della materia prima 
//1)bisogna verificare che questo coincida con il codice teorico 
//2)bisogna scegliere la bilancia da cui leggere il peso in base alla quantità teorica della materia prima e stampare un messaggio che informa l'utente sulla bilancia da usare

if (isset($_POST['CodiceMatReale']) ){/////////AGGIORNAMENTO
	
	 
	$CodiceMatReale = str_replace("'","''",$_POST['CodiceMatReale']); 
	$DescriMatTeo = str_replace("'","''",$_POST['DescriMatTeo']);	
	$CodiceMatTeo = str_replace("'","''",$_POST['CodiceMatTeo']);
	$QtaTeoNew = str_replace("'","''",$_POST['QtaTeoNew']);
		
	if($CodiceMatReale==$CodiceMatTeo){
		
		//Inserimento del codice mat nella tabella lab_peso 
		include('../Connessioni/serverdb.php'); 
		$errore=false;
		$messaggio = '<input type="reset" value="Rieseguire l\'operazione" onclick="window.opener.location.reload();window.close();" /> ';
		
		//Verifico che la materia prima non sia già presente nella tabella [lab_peso]
		
		/*$sqlPeso=mysql_query("SELECT peso FROM lab_peso WHERE cod_mat='".$CodiceMatReale."'")
		or die("Errore 19.1: " . mysql_error());
		while($rowPeso=mysql_fetch_array($sqlPeso))
		if($rowPeso['peso']>0)
		{	
			//Se entro nell'if vuol dire che esiste
			$errore=true;
			$messaggio=' - La materia prima selezionata è stata già pesata!<br />'.$messaggio;
		}*/
		
		if($errore){
			//Ci sono errori quindi non salvo
			echo $messaggio;
		}else{?>
        
         <div id="container" style="width:400px; margin:15px ;">
            <img src="/CloudFab/images/pittogrammi/bilancia_piccola_G.png" class="icone2" title="Clicca per pesare"/>Bilancia1
            <img src="/CloudFab/images/pittogrammi/bilancia_media_G.png" class="icone2" title="Clicca per pesare"/>Bilancia2
            <img src="/CloudFab/images/pittogrammi/bilancia_grande_G.png" class="icone2" title="Clicca per pesare"/>Bilancia3<br/>
      	</div>
       	<div id="container" style="width:400px; margin:15px ;">
      	<div id="msg">Il Codice inserito è corretto!<br/></div>
       
		<?php
        //Scelta della bilancia
		if($QtaTeoNew>0 && $QtaTeoNew<=10)	  { $Bilancia=1; echo '<div id="msg">Utilizzare la Bilancia Numero 1</div>';}
		if($QtaTeoNew>=11 && $QtaTeoNew<=1000){ $Bilancia=2; echo '<div id="msg">Utilizzare la Bilancia Numero 2</div>';}
		if($QtaTeoNew>1000)					  { $Bilancia=3; echo '<div id="msg">Utilizzare la Bilancia Numero 3</div>';}
		?>
        <div id="msg"> Pesare <?php  echo $QtaTeoNew;?> g di <?php  echo $CodiceMatReale;?></div><br/>
        <form id="PesaMateriePrime" name="PesaMateriePrime" method="post" >
				<input type="hidden" name="DescriMatTeo" id="DescriMatTeo" value="<?php  echo $DescriMatTeo;?>"/>
                <input type="hidden" name="CodiceMatTeo" id="CodiceMatTeo" value="<?php  echo $CodiceMatTeo;?>"/>
                <input type="hidden" name="QtaTeoNew" id="QtaTeoNew" value="<?php  echo $QtaTeoNew;?>"/>
        	
            	<input type="button" onclick="javascript:RegistraPeso();" value="RegistraPeso" />
        </form>
            <!--<input type="reset" value="Registra Peso" onclick="window.opener.location.reload(); window.close();" /> -->
        	
			<?php 
			
		}//End if errore
		
	}// End if codici uguali
	
	if($CodiceMatReale!=$CodiceMatTeo){
		echo "Il Codice Reale :".$CodiceMatReale."<br/>Il Codice Teorico è :".$CodiceMatTeo;
		echo '<div id="msg">Il codice inserito non è esatto!</div>';?>
		            
         <table>
           <tr>
           	  <td><input type="reset" value="Riprova"  onClick="window.close()" ></td>
           </tr>  
        </table> 
    </div>
	<?php 
	}//End if codici diversi 
	
}//End Aggiornamento?>
   
</body>
</html> 