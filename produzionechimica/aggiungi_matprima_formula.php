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
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_generazione_formula.php');

            $CodiceFormula = $_GET['CodiceFormula'];

            
            //############# STRINGHE AZIENDE VISIBILI  #################################
            //Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'formula');
            //Visualizzo solo i componenti che attualmente non sono associati alla formula
            $sqlMtPrNp = findMaterieNonPresentiInFormula($CodiceFormula, "descri_mat", $prefissoCodComp, $strUtentiAziende);
            ?>
            <div id="container" style="width:600px; margin:15px auto;">
                <form class="form" id="AggiungiMatPrima" name="AggiungiMatPrima" method="post" action="aggiungi_matprima_formula2.php">
                    <table width="100%">
                        <input type="hidden" name="CodiceFormula" id="CodiceFormula" value="<?php echo $CodiceFormula; ?>"></input>
                        <input type="hidden" name="NumSacTot" id="NumSacTot" value="<?php echo $NumSacTot; ?>"></input>
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaAggiungiMatPri ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" colspan="2">
                                <select style="width:80%" name="MateriaPrima" id="MateriaPrima">
                                    <option value="" selected=""><?php echo $labelOptionSelectMatPri ?></option>
                                    <?php while ($row = mysql_fetch_array($sqlMtPrNp)) { ?>
                                        <option value="<?php echo($row['cod_mat']) ?>"><?php echo $row['descri_mat'] . " " . $row['cod_mat'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroQtaPerKit ?>  
                                <td class="cella1"><input type="text" name="Quantita" id="Quantita" value=""><?php echo $filtrogBreve ?></td> 
                        </tr>  

                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>

                <div id="msgLog">
                    <?php
                    if ($DEBUG) {
                        echo "</br>Tabella formula : Utenti e aziende visibili : " . $strUtentiAziende;
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>