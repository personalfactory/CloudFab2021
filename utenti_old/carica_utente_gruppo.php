<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <?php include('../Connessioni/serverdb.php'); ?>

            <div id="container" style="width:500px; margin:15px auto;">
                <form id="InserisciUtente" name="InserisciUtente" method="post" action="carica_utente_gruppo2.php">
                    <table width="500px">
                        <tr>
                            <td class="cella3" colspan="3" ><?php echo $nuovoGruppoUtenti ?></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroTipoGruppoUtente ?></td>
                            <td class="cella1">
                                <select name="Tipo" id="Tipo">
                                    <optgroup>
                                        <option value="Pubblico"><?php echo $filtroPubblico ?></option>
                                        <option value="Privato"><?php echo $filtroPrivato ?></option>
                                    </optgroup>
                                </select></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNome ?></td>
                            <td class="cella1"> <input type="text" name="NomeGruppo" id="NomeGruppo" /></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"> <input type="text" name="Descrizione" id="Descrizione" /></td>
                        </tr>
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
