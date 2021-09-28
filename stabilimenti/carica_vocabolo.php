<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
<?php// include('../js/visualizza_elementi.js'); ?>
</head>
<body>
<script language="javascript" src="../js/visualizza_elementi.js"></script>

<div id="mainContainer">

<?php include('../include/menu.php'); ?>

	<div id="container" style="width:900px; margin:15px auto;">
	<form id="InserisciVocabolo" name="InserisciVocabolo" method="post" action="carica_vocabolo2.php">
	  <table width="900" >
	      <tr>
	        <td height="40" colspan="2" class="cella3">Inserimento Nuovo Vocabolo</td>
          </tr>
	      <tr>
	        <td class="cella4">Vocabolo Italiano</td>
	        <td class="cella11"><?php include('./moduli/visualizza_form_dizionario.php');?></td>
          </tr>
	    					
			<?php
            //Visualizzo l'elenco delle lingue presenti nella tabella lingua
			$NLin = 1;
            $sqlLingua = mysql_query("SELECT * FROM lingua 
                                                WHERE 
                                                    lingua<>'Italiano'
                                                ORDER BY 
                                                    lingua") 
                     or die("Errore 63: " . mysql_error());
                     while($rowLingua=mysql_fetch_array($sqlLingua)){
						?>
						<tr>
							<td class="cella4">Vocabolo <?php echo($rowLingua['lingua'])?></td>
							<td class="cella1"><input type="text" size="50" name="Lingua<?php echo($NLin);?>" id="Lingua<?php echo($NLin);?>" value="0" />
							</td>
						</tr>
						<?php 
                      $NLin++;
                   }//Fine lingue?>
        
          <tr>
       	    <td><input type="submit" value="Salva" /><input type="reset" value="Annulla" onClick="javascript:history.back();"><td>
          </tr>
    </table>
	  <p id="InserisciProdotto">&nbsp;</p>
    </form>
    </div>
    
</div><!--mainContainer-->

</body>
</html>
