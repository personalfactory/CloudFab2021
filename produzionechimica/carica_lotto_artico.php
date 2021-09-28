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
            include('../include/gestione_date.php');
            ?>
            <script language="javascript" type="text/javascript">

                function controllaCampi(msgErrCodice, msgErroreNome) {

                    var rv = true;
                    var msg = "";

                    
                    if (document.getElementById('Nome').value === "") {
                        rv = false;
                        msg = msg + ' ' + msgErroreNome;
                    }
                    if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }
                function Salva() {

                    document.forms["InserisciLottoArtico"].action = "carica_lotto_artico2.php";
                }

            </script>

            <div id="container" style="width:60%; margin:15px auto;">
                <form id="InserisciLottoArtico" name="InserisciLottoArtico" method="post" onsubmit="return controllaCampi('<?php echo $msgErrCodice ?>', '<?php echo $msgErroreNome ?>')" >
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovoLottoArtico ?></td>
                        </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroCodice ?></td>
                                <td class="cella1"><input type="text" name="Codice" id="Codice" size="30px"/>
                                </td>
                            </tr>
                            <td class="cella4"><?php echo $filtroDescrizione ?> </td>
                            <td class="cella1"><input type="text" name="Descrizione" id="Descrizione" size="50"/></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDt ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
               

        </div><!--mainContainer-->

    </body>
</html>

