<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <?php
  
    if ($DEBUG) ini_set('display_errors', 1);
    
    include('../Connessioni/serverdb.php');
    include('../sql/script_aggiornamento_config.php');

    $Id = $_GET['Id'];

//Visualizzazione del record che si intende modificare all'interno della form
    $sql = selectParametroById($Id);
    while ($row = mysql_fetch_array($sql)) {
        $parametro = $row['parametro'];
        $valore = $row['valore'];
        $tipo = $row['tipo'];
        $descrizione = $row['descrizione'];
        $abilitato = $row['abilitato'];
        $dtAbilitato=$row['dt_abilitato'];
        
    }
    
    
    ?>
    <body >
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style="width:600px; margin:50px auto;">
                <form id="ModificaAggConfig" name="ModificaAggConfig" method="post" action="modifica_agg_config2.php">
                    <table style="width:100%;">
                        <input type="hidden" name="Id" id="Id" value=<?php echo $Id; ?>></input>
                        <th class="cella3" colspan="2"><?php echo $titoloPaginaModAggConfig ?></th>
                        <tr>
                            <td class="cella2"><?php echo $filtroId ?></td>
                            <td class="cella1"><?php echo $Id  ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPar ?> </td>
                            <td class="cella1"><textarea name="Parametro" id="Parametro" rows="1" cols="45"><?php echo  $parametro  ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroValore ?></td>
                            <td class="cella1"><textarea name="Valore" id="Valore" rows="1" cols="45"><?php echo  $valore  ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroTipo ?></td>
                            <td class="cella1"><input type="text" name="Tipo" id="Tipo" value="<?php echo  $tipo  ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><textarea name="Descrizione" id="Descrizione" rows="1" cols="45"><?php echo  $descrizione  ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroAbilitato ?></td>
                            <td class="cella1"><input type="text" name="Abilitato" id="Abilitato" value="<?php echo  $abilitato  ?>"/>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtAbilitato ?></td>
                            <td class="cella1"><?php echo $dtAbilitato ?></td>
                        </tr>
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
