<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>

<?php include('../include/menu.php'); $IdMacchina=$_GET['IdMacchina'];
?>
<div id="container" style=" width:500px; margin:15px auto;">

	<form class="form" id="AggiungiParametro" name="AggiungiParametro" method="post" action="aggiungi_parsm_macchina2.php">
    <table width="500px">
    <input type="hidden" name="IdMacchina" id="IdMacchina" value="<?php echo $IdMacchina;?>"></input>
    	<tr>
            <td class="cella3" colspan="2">Associazione Nuovo Parametro alla Macchina</td>
        </tr>
        <tr>
            <td class="cella2">Parametro</td>
            <td class="cella1" >
            <select name="Parametro" id="Parametro">
            	<option value="" selected>Selezionare il nuovo Parametro</option>
                   
					<?php 
					include('../Connessioni/serverdb.php');
                    $ValoreBase=0;
					$sqlPar = mysql_query("SELECT * FROM parametro_sing_mac 
										   	WHERE 
													id_par_sm 
											NOT IN  
											(SELECT id_par_sm FROM valore_par_sing_mac WHERE id_macchina=".$IdMacchina.")
											ORDER BY descri_variabile") 
                          or die("Errore 112: " . mysql_error());
					while($rowPar=mysql_fetch_array($sqlPar)){
					   $ValoreBase=$rowPar['valore_base'];
					   ?>
                        <option value="<?php echo($rowPar['id_par_sm'])?>"><?php echo($rowPar['descri_variabile'])?></option>
                       <?php }?>
              </select>
        </tr>
    	<tr>
   	       <td colspan="2" class="cella3"><div id="MSG">Inserire il valore </div></td>
        </tr>
        <tr>
           	<td class="cella2">Valore </td>
			<td class="cella1"><input type="text" name="Valore" id="Valore" value="<?php echo $ValoreBase;?>">
            </td>
		</tr>
      		
    </tr>
    <tr>
    	<td><input type="submit" value="Salva" />
            <input type="reset" value="Annulla" onClick="javascript:history.back();"/>
        </td>
    </tr>
    </table>
    </form>
 
</div>
</body>
</html>
