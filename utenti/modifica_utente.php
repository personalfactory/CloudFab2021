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

$IdUtente=$_GET['Utente'];
//visualizzo il record che intendo modificare all'interno della form

$sql = mysql_query("SELECT
						utente.id_utente,
						utente.cognome,
						utente.nome,
						utente.id_gruppo_utente,
						utente_gruppo.nome_gruppo_utente,
						utente_gruppo.tipo_gruppo_utente,
						utente.username,
						utente.pswd,
						utente.abilitato,
						utente.dt_abilitato
					FROM
						utente
					INNER JOIN
						utente_gruppo
						ON utente.id_gruppo_utente=utente_gruppo.id_gruppo_utente
					WHERE id_utente=".$IdUtente) 
			or die("Query fallita: " . mysql_error());
	while($row=mysql_fetch_array($sql))
	{
		$IdGruppoUtente=$row['id_gruppo_utente'];
		$GruppoUtente=$row['nome_gruppo_utente'];
		$TipoGruppo=$row['tipo_gruppo_utente'];
		$Cognome=$row['cognome'];
		$Nome=$row['nome'];
		$Username=$row['username'];
		$PasswordOld=$row['pswd'];
		$Password=$row['pswd'];
		$Abilitato=$row['abilitato'];
		$Data=$row['dt_abilitato'];
		}

?>

<div id="container" style="width:600px; margin:15px auto;">
<form id="ModificaUtente" name="ModificaUtente" method="post" action="modifica_utente2.php">
    <table style="width:100%;">
		<input type="hidden" name="IdUtente" id="IdUtente" value="<?php echo $IdUtente;?>"/>
	    <th class="cella3" colspan="2"><?php echo $titoloPaginaModificaUtente ?></th>
        <tr>
            <tr>
            <td class="cella2"><?php echo $filtroId ?>  </td>
            <td class="cella1"><?php echo $IdUtente ?></td>
        </tr>
    	<td class="cella2"><?php echo $filtroGruppoUtente ?></td>
        <td class="cella1"> <select name="IdGruppoUtente" id="IdGruppoUtente">
                <option value="<?php echo $IdGruppoUtente;?>" selected=""><?php echo $GruppoUtente." ".$TipoGruppo; ?> </option>
                    <?php
					$sqlGruppo = mysql_query("SELECT id_gruppo_utente, nome_gruppo_utente, tipo_gruppo_utente 
                                                    FROM 
                                                        serverdb.utente_gruppo
                                                    ORDER BY nome_gruppo_utente") 
                                    
                                    or die("Errore 109: " . mysql_error());
                    while ($rowGruppo=mysql_fetch_array($sqlGruppo)){?>
                <option value="<?php echo ($rowGruppo['id_gruppo_utente']);?>"><?php echo ($rowGruppo['nome_gruppo_utente'])." ".($rowGruppo['tipo_gruppo_utente']);?></option>
                   <?php }?>
            </select> </td>
    </tr>
        
        <tr>
            <td class="cella2"><?php echo $filtroNome ?>  </td>
            <td class="cella1"><input type="text" name="Nome" id="Nome" value="<?php echo $Nome;?>"/></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroCognome ?> </td>
            <td class="cella1"><input type="text" name="Cognome" id="Cognome" value="<?php echo $Cognome;?>"/></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroUserName ?></td>
            <td class="cella1"><input type="text" name="Username" id="Username" value="<?php echo $Username;?>"/></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroPassword ?></td>
            <td class="cella1"><input type="password" name="Password" id="Password" value="<?php echo $PasswordOld;?>"/></td>
        </tr>
        <input type="hidden" name="PasswordOld" id="PasswordOld" value="<?php echo $PasswordOld;?>"/>
        <tr>
            <td class="cella2"><?php echo $filtroConferma." ".$filtroPassword ?></td>
            <td class="cella1"><input type="password" name="ConfermaPassword" id="ConfermaPassword" value="<?php echo $Password;?>"/></td>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroAbilitato ?></td>
             <td class="cella1"><?php echo $Abilitato;?></td>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroDtAbilitato?></td>
             <td class="cella1"><?php echo $Data;?></td>
        </tr>
        <?php include('../include/tr_reset_submit.php'); ?>
 	</table>
</form>
</div>

</div><!--mainContainer-->

</body>
</html>
