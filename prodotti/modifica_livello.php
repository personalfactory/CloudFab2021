<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
<script language="javascript" src="../js/visualizza_elementi.js"></script>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            //include('../js/visualizza_elementi.js');
            include('../Connessioni/serverdb.php');
            include('../sql/script_gruppo.php');

            $IdGruppo = $_GET['Gruppo'];

//visualizzo il record che intendo modificare all'interno della form

            $sql = findGruppoById($IdGruppo);
//$sql = mysql_query("SELECT * FROM gruppo WHERE id_gruppo=".$IdGruppo) 
//			or die("Errore 800: " . mysql_error());
            while ($row = mysql_fetch_array($sql)) {
                $PrimoLivello = $row['livello_1'];
                $SecondoLivello = $row['livello_2'];
                $TerzoLivello = $row['livello_3'];
                $QuartoLivello = $row['livello_4'];
                $QuintoLivello = $row['livello_5'];
                $SestoLivello = $row['livello_6'];
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
                <form id="ModificaGruppo" name="ModificaGruppo" method="post" action="modifica_livello2.php">
                    <table style="width:400px;">
                        <input type="hidden" name="IdGruppo" id="IdGruppo" value=<?php echo $IdGruppo; ?>></input>

                        <tr>
                            <td height="42" colspan="2" class="cella3"><?php echo $titoloModLiv ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroSecondoLivello ?> </td>
                            <td class="cella1"><input type="text" name="SecondoLivello" id="SecondoLivello" value=<?php echo '"' . $SecondoLivello . '"'; ?>></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroTerzoLivello ?>  </td>
                            <td class="cella1"><input type="text" name="TerzoLivello" id="TerzoLivello" value=<?php echo '"' . $TerzoLivello . '"'; ?>></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroQuartoLivello ?>  </td>
                            <td class="cella1"><input type="text" name="QuartoLivello" id="QuartoLivello" value=<?php echo '"' . $QuartoLivello . '"'; ?>></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroQuintoLivello ?> </td>
                            <td class="cella1"><input type="text" name="QuintoLivello" id="QuintoLivello" value=<?php echo '"' . $QuintoLivello . '"'; ?>></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroSestoLivello ?>  </td>
                            <td class="cella1"><input type="text" name="SestoLivello" id="SestoLivello" value=<?php echo '"' . $SestoLivello . '"'; ?>></input></td>
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
