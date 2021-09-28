<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
<body>

<div id="mainContainer">

<?php
include('../include/menu.php'); include('../Connessioni/serverdb.php');

$IdGruppoUtente=$_GET['IdGruppoUtente'];
//visualizzo il record che intendo modificare all'interno della form

$sql = mysql_query("SELECT
						nome_gruppo_utente,
						tipo_gruppo_utente,
						descri_gruppo_utente,
						abilitato,
						dt_abilitato
					FROM
						utente_gruppo
					WHERE id_gruppo_utente=".$IdGruppoUtente) 
			or die("Query fallita: " . mysql_error());
	
	while($row=mysql_fetch_array($sql))
	{
		$NomeGruppo=$row['nome_gruppo_utente'];
		$Tipo=$row['tipo_gruppo_utente'];
		$Descrizione=$row['descri_gruppo_utente'];
		$Abilitato=$row['abilitato'];
		$Data=$row['dt_abilitato'];
	}

mysql_close();

?>
<div id="container" style="width:600px; margin:15px auto;">
<form id="ModificaUtente" name="ModificaUtente" method="post" action="modifica_utente_gruppo2.php">
    <table style="width:100%;">
		<input type="hidden" name="IdGruppoUtente" id="IdGruppoUtente" value=<?php echo $IdGruppoUtente;?>></input>
	    <th class="cella3" colspan="2"><?php echo $titoloPaginaModificaGruppoUtenti ?></th>
        <tr>
            <td class="cella2"><?php echo $filtroGruppoUtente ?></td>
            <td class="cella1"><input type="text" name="NomeGruppo" id="NomeGruppo" value="<?php echo $NomeGruppo;?>"></input></td>
    	</tr>
        <tr>
            <td class="cella2"><?php echo $filtroTipoGruppoUtente ?>  </td>
            <td class="cella1">
            <select name="Tipo" id="Tipo" value="<?php echo $Tipo?>">
                <optgroup>
                    <option value="Pubblico"><?php echo $filtroPubblico ?></option>
                    <option value="Privato"><?php echo $filtroPrivato ?></option>
                </optgroup>
          	</select></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroDescrizione ?></td>
            <td class="cella1"><input type="text"  size="50px" name="Descrizione" id="Descrizione" value="<?php echo $Descrizione;?>"></input></td>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroAbilitato ?></td>
             <td class="cella1"><?php echo $Abilitato;?>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroDtAbilitato ?></td>
             <td class="cella1"><?php echo $Data;?></td>
        </tr>
        <?php include('../include/tr_reset_submit.php'); ?>
 	</table>
</form>
</div>

</div><!--mainContainer-->

</body>
</html>
