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
include('../sql/script_gruppo.php');

$IdGruppo=$_GET['Gruppo'];

//################## COSA FA ##################################################
//Questa funzionalità consente di modificare l'intero record della tabella gruppo
//e modifica il campo gruppo (solo di primo livello )
//delle tabelle anagrafe_prodotto e anagrafe_macchina storicizzando tutto


$sql=findGruppoById($IdGruppo);
//$sql = mysql_query("SELECT * FROM gruppo WHERE id_gruppo=".$IdGruppo) 
//			or die("Errore 800: " . mysql_error());
	while($row=mysql_fetch_array($sql))
	{
		$PrimoLivello=$row['livello_1'];
		$SecondoLivello=$row['livello_2'];
        $TerzoLivello=$row['livello_3'];
       	$QuartoLivello=$row['livello_4'];
        $QuintoLivello=$row['livello_5'];
        $SestoLivello=$row['livello_6'];
        $Abilitato=$row['abilitato'];
       	$Data=$row['dt_abilitato'];
		}
mysql_close();
?>

<div id="container" style="width:400px; margin:15px auto;">
<form id="ModificaGruppo" name="ModificaGruppo" method="post" action="modifica_gruppo2.php">
    <table style="width:400px;">
		<input type="hidden" name="IdGruppo" id="IdGruppo" value=<?php echo $IdGruppo;?>></input>
	    <tr>
            <th class="cella3" colspan="2"><?php echo $titoloModGruppoSing?></th>
            
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroPrimoLivello?> </td>
            <td class="cella1"><input type="text" name="PrimoLivello" id="PrimoLivello" value=<?php echo '"'.$PrimoLivello.'"';?>></input></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroSecondoLivello?> </td>
            <td class="cella1"><input type="text" name="SecondoLivello" id="SecondoLivello" value=<?php echo '"'.$SecondoLivello.'"';?>></input></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroTerzoLivello?> </td>
            <td class="cella1"><input type="text" name="TerzoLivello" id="TerzoLivello" value=<?php echo '"'.$TerzoLivello.'"';?>></input></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroQuartoLivello?> </td>
            <td class="cella1"><input type="text" name="QuartoLivello" id="QuartoLivello" value=<?php echo '"'.$QuartoLivello.'"';?>></input></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroQuintoLivello?></td>
            <td class="cella1"><input type="text" name="QuintoLivello" id="QuintoLivello" value=<?php echo '"'.$QuintoLivello.'"';?>></input></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroSestoLivello?> </td>
            <td class="cella1"><input type="text" name="SestoLivello" id="SestoLivello" value=<?php echo '"'.$SestoLivello.'"';?>></input></td>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroAbilitato?></td>
             <td class="cella1"><?php echo $Abilitato;?>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroDt?></td>
             <td class="cella1"><?php echo $Data;?></td>
        </tr>
        <?php include('../include/tr_reset_submit.php'); ?>
 	</table>
</form>

</div><!--mainContainer-->

</div>
</body>
</html>
