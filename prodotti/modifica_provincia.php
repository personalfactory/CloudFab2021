<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
<script language="javascript" src="../js/visualizza_elementi.js"></script>
            <?php
            include('../include/menu.php');
           //include('../js/visualizza_elementi.js');
            include('../Connessioni/serverdb.php');
            include('../sql/script_comune.php');

            $IdComune = $_GET['Comune'];
//visualizzo il record che intendo modificare all'interno della form

            $sql = findComuneById($IdComune);
//$sql = mysql_query("SELECT * FROM comune WHERE id_comune=".$IdComune) 
//			or die("Query fallita: " . mysql_error());
            while ($row = mysql_fetch_array($sql)) {
                $Cap = $row['cap'];
                $CodiceCatastale = $row['cod_cat'];
                $CodiceIstat = $row['cod_istat'];
                $Comune = $row['comune'];
                $CodiceProvincia = $row['cod_prov'];
                $Provincia = $row['provincia'];
                $CodiceRegione = $row['cod_reg'];
                $Regione = $row['regione'];
                $CodiceStato = $row['cod_stat'];
                $Stato = $row['stato'];
                $Continente = $row['continente'];
                $Mondo = $row['mondo'];
                $Abilitato = $row['abilitato'];
                $Data = $row['dt_abilitato'];
            }

            /* Per ora non serve
              //Memerizzo i tipi di riferimento estraendo i nomi dei campi della tabella comune
              $RiferimentoComune = mysql_field_name($sql, 4) . "\n";
              $RiferimentoProvincia = mysql_field_name($sql, 6). "\n";
              $RiferimentoRegione = mysql_field_name($sql, 8). "\n";
              $RiferimentoStato = mysql_field_name($sql, 10). "\n";
              $RiferimentoContinente = mysql_field_name($sql, 11). "\n";
              $RiferimentoMondo = mysql_field_name($sql, 12). "\n"; */
            mysql_close();
            ?>
            <div id="container" style="width:400px; margin:15px auto;">
                <form id="ModificaComune" name="ModificaComune" method="post" action="modifica_provincia2.php">
                    <table style="width:400px;">
                        <input type="hidden" name="IdComune" id="IdComune" value="<?php echo $IdComune; ?>"></input>

                        <tr>
                            <td height="42" colspan="2" class="cella3"><?php echo $titoloModificaLivelli ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodProvincia ?> </td>
                            <td class="cella1"><input type="text" name="CodiceProvincia" id="CodiceProvincia" value="<?php echo  $CodiceProvincia ; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroProvincia ?> </td>
                            <td class="cella1"><input type="text" name="Provincia" id="Provincia" value="<?php echo  $Provincia ; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodRegione ?> </td>
                            <td class="cella1"><input type="text" name="CodiceRegione" id="CodiceRegione" value="<?php echo  $CodiceRegione ; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroRegione ?> </td>
                            <td class="cella1"><input type="text" name="Regione" id="Regione" value="<?php echo  $Regione ; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCodStato ?> </td>
                            <td class="cella1"><input type="text" name="CodiceStato" id="CodiceStato" value="<?php echo  $CodiceStato ; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroStato ?> </td>
                            <td class="cella1"><input type="text" name="Stato" id="Stato" value="<?php echo  $Stato ; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroContinente ?> </td>
                            <td class="cella1"><input type="text" name="Continente" id="Continente" value="<?php echo  $Continente ; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroMondo ?> </td>
                            <td class="cella1"><input type="hidden" name="Mondo" id="Mondo" value="<?php echo  $Mondo ; ?>"><?php echo  $Mondo ; ?></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroAbilitato ?> </td>
                            <td class="cella1"><?php echo $Abilitato; ?>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDt ?> </td>
                            <td class="cella1"><?php echo $Data; ?></td>
                        </tr>
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
