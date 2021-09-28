<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <script language="javascript">
            function Salva() {

                document.forms["InserisciUtente"].action = "carica_utente2.php";
                document.forms["InserisciUtente"].submit();
            }

            //        function passaValoriPerRiferimento() {
            //
            //          open('/CloudFab/stabilimenti/setta_var_produttivita.php?Data3=' + document.Produttivita.date3.value +
            //                  '&Data4=' + document.Produttivita.date4.value +
            //                  '&Stabilimento=' + document.Produttivita.Stabilimento.value +
            //                  '&OreDaEscludere=' + document.Produttivita.OreDaEscludere.value +
            //                  '&Inattivita=' + document.Produttivita.Inattivita.value +
            //                  '&Operatore=' + document.Produttivita.Operatore.value +
            //                  '&Prodotto=' + document.Produttivita.Prodotto.value +
            //                  '&Submit=1', 'SettaVar');
            //        }
        </script>
        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');

            $_SESSION['GruppoUtenteScelto'] = "";
            $_SESSION['IdGruppoUtenteScelto'] = "";
            $_SESSION['NomeGruppoUtenteScelto'] = "";
            $_SESSION['TipoGruppoUtenteScelto'] = "";
            $_SESSION['Cognome'] = "";
            $_SESSION['Nome'] = "";
            $_SESSION['Username'] = "";
            $_SESSION['Password'] = "";
            $_SESSION['ConfermaPassword'] = "";

            if (isSet($_POST['GruppoUtenteScelto'])) {
                $_SESSION['GruppoUtenteScelto'] = trim($_POST['GruppoUtenteScelto']);

                list($_SESSION['IdGruppoUtenteScelto'], $_SESSION['NomeGruppoUtenteScelto'], $_SESSION['TipoGruppoUtenteScelto']) = explode(';', $_SESSION['GruppoUtenteScelto']);
            }

            if (isSet($_POST['Cognome']))
                $_SESSION['Cognome'] = trim($_POST['Cognome']);
            if (isSet($_POST['Nome']))
                $_SESSION['Nome'] = trim($_POST['Nome']);
            if (isSet($_POST['Username']))
                $_SESSION['Username'] = trim($_POST['Username']);
            if (isSet($_POST['Password']))
                $_SESSION['Password'] = trim($_POST['Password']);
            if (isSet($_POST['ConfermaPassword']))
                $_SESSION['ConfermaPassword'] = trim($_POST['ConfermaPassword']);
            ?>

            <div id="container" style="width:600px; margin:15px auto;">
                <form id="InserisciUtente" autocomplete="off" autofill="OFF" name="InserisciUtente" method="post" action="">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="3" ><?php echo $nuovoUtente ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGruppoUtente ?></td>
                            <td class="cella1"><select name="GruppoUtenteScelto" id="GruppoUtenteScelto" onChange="document.forms['InserisciUtente'].submit();">
                                    <option value="<?php echo $_SESSION['GruppoUtenteScelto'] ?>" selected="<?php echo $_SESSION['GruppoUtenteScelto'] ?>"><?php echo $_SESSION['NomeGruppoUtenteScelto'] . " " . $_SESSION['TipoGruppoUtenteScelto'] ?></option>
<?php
$sqlGruppo = mysql_query("SELECT id_gruppo_utente, nome_gruppo_utente, tipo_gruppo_utente 
                                                    FROM 
                                                        serverdb.utente_gruppo
                                                    ORDER BY nome_gruppo_utente") or die("Errore 109: " . mysql_error());
while ($rowGruppo = mysql_fetch_array($sqlGruppo)) {
    ?>

                                        <option value="<?php echo ($rowGruppo['id_gruppo_utente'] . ";" . $rowGruppo['nome_gruppo_utente'] . ";" . $rowGruppo['tipo_gruppo_utente']); ?>"><?php echo ($rowGruppo['nome_gruppo_utente']) . " " . ($rowGruppo['tipo_gruppo_utente']); ?></option>
                                    <?php } ?>
                                </select> </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCognome ?></td>
                            <td class="cella1"><input type="text" name="Cognome" id="Cognome" value="<?php echo $_SESSION['Cognome'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNome ?></td>
                            <td class="cella1"> <input type="text" name="Nome" id="Nome" value="<?php echo $_SESSION['Nome'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroUserName ?></td>
                            <td class="cella1"><input type="text" name="Username" id="Username" autocomplete="off" value="<?php echo $_SESSION['Username'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPassword ?></td>
                            <td class="cella1"><input  type="password" name="Password" id="Password"  autocomplete="off" value="<?php echo $_SESSION['Password'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                            <td class="cella1"><input  type="password" name="ConfermaPassword" id="ConfermaPassword" value="<?php echo $_SESSION['ConfermaPassword'] ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="button" value="<?php echo $valueButtonSalva ?>" onClick="javascript:Salva();"/></td>
                        </tr>   
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
