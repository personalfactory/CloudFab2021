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
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../include/funzioni.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_lotto_artico.php');
            include('../sql/script_formula.php');
            include('../sql/script_generazione_formula.php');
            include('../sql/script_materia_prima.php');
            include('../sql/script_persona.php');

            ini_set('display_errors', '1');

//##############################################################################
//################### NUOVA MATERIA PRIMA ######################################
//##############################################################################

            $errore = false;
            $messaggio = $msgErroreVerificato . '<br/>';


            $NumArticoli = str_replace("'", "''", $_POST['NumArticoli']);

            if (!is_numeric($NumArticoli)) {

                $errore = true;
            }

            $messaggio = $messaggio . '<a href="javascript:history.back()">' . $msgRicontrollaDati . '</a>';

            if ($errore) {
                //Ci sono errori quindi non salvo
                echo '<div id="msgErr">' . $messaggio . '</div>';
            } else {
                ?>
                <div style=" width:850px; margin:50px auto;">
                    <table width="100%">
                        <tr>
                            <td class="cella2">PRODOTTO</td> 
                            <td class="cella2">ORDINE</td> 
                            <td class="cella2">SCATOLE IN GIACENZA</td> 
                            <td class="cella2">SCATOLE DA PRODURRE</td>
                        </tr>
                        <?php
                        $j = 0; //Contatore delle materie prime presenti in tutte le formule 
                        $arrayMat = array();
                        for ($i = 0; $i < $NumArticoli; $i++) {

                            $Articolo = str_replace("'", "''", $_POST['Articolo' . $i]);
                            list($Artico, $DescriArticolo) = explode(";", $Articolo);
                            $QtaArticolo = str_replace("'", "''", $_POST['QtaArticolo' . $i]);
                            $codFormula = "K" . substr($Artico, 1, 5);

                            $qtaTotMat = 0;

                            //################# LOG (faccio query solo per stampare il LOG)
                            //1) Verifico il numero di scatole in giacenza nella tabella lotto artico
                            $giacenzaAtt = 0;
                            $sqlLotto = findLottoArticoByCodice($Artico);
                            while ($row = mysql_fetch_array($sqlLotto)) {

                                $giacenzaAtt = $row['giacenza_attuale'];
                                if ($giacenzaAtt < 0)
                                    $giacenzaAtt = 0;
                            }
                            if ($giacenzaAtt < $QtaArticolo) {
                                $scatoleDaProd[$i] = $QtaArticolo - $giacenzaAtt;
                            } else if ($QtaArticolo <= $giacenzaAtt) {
                                $scatoleDaProd[$i] = 0;
                            }
                            //##########################################################
                            ?>
                            <tr>
                                <td class="cella2" ><?php echo $Artico . " " . $DescriArticolo ?></td>
                                <td class="cella2" style="text-align: right"><?php echo $QtaArticolo . " " . $filtroPz ?></td>
                                <td class="cella2" style="text-align: right"><?php echo $giacenzaAtt . " " . $filtroPz ?></td>
                                <td class="cella2" style="text-align: right"><?php echo $scatoleDaProd[$i] . " " . $filtroPz ?></td>
                            </tr>

                            <?php
                            //### CREO ARRAY CON TUTTE LE MATERIE PRIME ################
                            //Selezionare tutte le materie prime di tutti i prodotti
                            $sqlFormula = findMateriePriFormulaByCod($codFormula, 'm.cod_mat');
                            while ($row = mysql_fetch_array($sqlFormula)) {
                                $qtaMatLotto = $row['quantita'] / $row['num_lotti'];
                                $arrayMat[$j] = $row['cod_mat'];

                                $j++;
                            }
                        }
                        ?></table>
                    <?php
                    $arrayMat = array_unique($arrayMat);

                    sort($arrayMat);
//                print_r($arrayMat);
                    //A questo punto ho un array con tutte le materie prime contenute nei prodotti richiesti
                    //Per ogni materia prima considerare la quantit?? necessaria per ciascuna formula  
                    $qtaTotMat = array();
                    $qtaTotMatOrdine = array();
                    $scatoleDaProd = array();
                    for ($j = 0; $j < count($arrayMat); $j++) {

                        $qtaTotMat[$j] = 0;
                        $qtaTotMatOrdine[$j] = 0;


                        //Per ogni prodotto 
                        for ($i = 0; $i < $NumArticoli; $i++) {

                            $Articolo = str_replace("'", "''", $_POST['Articolo' . $i]);
                            list($Artico, $DescriArticolo) = explode(";", $Articolo);
                            $QtaArticolo = str_replace("'", "''", $_POST['QtaArticolo' . $i]);
                            $codFormula = "K" . substr($Artico, 1, 5);
                            //Per ogni  prodotto
                            //1) Verifico il numero di scatole in giacenza nella tabella lotto artico
                            $giacenzaAtt = 0;
                            $sqlLotto = findLottoArticoByCodice($Artico);
                            while ($row = mysql_fetch_array($sqlLotto)) {

                                $giacenzaAtt = $row['giacenza_attuale'];
                                if ($giacenzaAtt < 0)
                                    $giacenzaAtt = 0;
                            }
                            //Se il num di scatole in giacenza < della qta richiesta verifico le materie prime necessarie
                            //############ INIZIO CONTROLLO MATERIE PRIME ##########
                            if ($giacenzaAtt < $QtaArticolo) {
                                $scatoleDaProd[$i] = $QtaArticolo - $giacenzaAtt;
                            } else if ($QtaArticolo <= $giacenzaAtt) {
                                $scatoleDaProd[$i] = 0;
                            }

                            $qtaMiscela = 0;
                            $sqlQta = findMatPrimaByFormulaAndCod($codFormula, $arrayMat[$j]);
                            while ($row = mysql_fetch_array($sqlQta)) {

                                $qtaMiscela = $row['quantita'] / 1000;
                            }

                            $sqlNumLotti = findAnFormulaByCodice($codFormula);
                            while ($row = mysql_fetch_array($sqlNumLotti)) {

                                $numLot = $row['num_lotti'];
                            }
                            //Quantita di materia prima per produrre un lotto
                            $qtaLotto = $qtaMiscela / $numLot;

                            //Quantita necessaria per produrre la differenza fra le scatole in giacenza e quelle ordinate in totale
                            $qtaMat = $scatoleDaProd[$i] * $qtaLotto;
                            $qtaTotMat[$j] = $qtaTotMat[$j] + $qtaMat;

                            //Quantita necessaria per produrre le scatole ordinate in totale senza tenere conto della giacenza
                            $qtaMatOrdine = $QtaArticolo * $qtaLotto;
                            $qtaTotMatOrdine[$j] = $qtaTotMatOrdine[$j] + $qtaMatOrdine;
//                        }
                        }
                    }
                    ?>
                    <!--################# STATO ORDINE - GIACENZA ###################################-->
                    <br/>
                    <br/>
                    <table width="100%">
                        <th colspan="4">PRODUZIONE ORDINE VISTA LA GIACENZA DEI LOTTI</th>
                        <tr>
                            <td class="cella2">MATERIE PRIME</td> 
                            <td class="cella2">GIACENZA</td> 
                            <td class="cella2">QUANTIT?? NECESSARIA </td>
                            <td class="cella2">QUANTIT?? MANCANTE </td>

                        </tr>
                        <?php
                        $ordineEvaso = true;
                        for ($j = 0; $j < count($arrayMat); $j++) {

//Per ogni materia prima faccio la differenza tra la giacenza e la qta necessaria 
                            $sqlGiacenza = findMatPrimaByCodice($arrayMat[$j]);
                            while ($row = mysql_fetch_array($sqlGiacenza)) {
                                $giacenzaMat = $row['giacenza_attuale'];
                                $descriMateria = $row['descri_mat'];
                            }
//Se la giacenza ?? inferiore alla qta richiesta stampo la qta necessaria 
                            if ($giacenzaMat < $qtaTotMat[$j]) {
                                $ordineEvaso = false;
                                ?>
                                <tr>
                                    <td class="cella2" style='color:#A00028;'><?php echo $arrayMat[$j] . " " . $descriMateria ?></td>
                                    <td class="cella2" style='color:#A00028;text-align: right'><?php echo number_format($giacenzaMat, "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#A00028;text-align: right'><?php echo $qtaTotMat[$j] . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#A00028;text-align: right'><?php echo number_format(($qtaTotMat[$j] - $giacenzaMat), "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                </tr>
        <?php } else { ?>
                                <tr><td class="cella2" style='color:#008000;'><?php echo $arrayMat[$j] . " " . $descriMateria ?></td>
                                    <td class="cella2" style='color:#008000;text-align: right'><?php echo number_format($giacenzaMat, "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#008000;text-align: right'><?php echo number_format($qtaTotMat[$j], "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#008000;text-align: right'><?php echo "0 " . $filtroKgBreve ?></td>
                                </tr>
                            <?php } ?>

    <?php } ?>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <?php
                                if (!$ordineEvaso)
                                    echo "<br/><span style='font-size:20px;color:#A00028;'><br/>L' ordine non pu?? essere evaso : materie prime insufficienti!";
                                else
                                    echo "<br/><span style='font-size:20px;color:#008000;'><br/>L' ordine pu?? essere evaso considerando le scatole in giacenza</span>";
                                ?></td>
                        </tr>
                    </table>
                    <!--################# STATO ORDINE TOTALE ###################################-->
                    <br/>
                    <br/>
                    <table width="100%">
                        <th colspan="4">PRODUZIONE ORDINE COMPLETO</th>
                        <tr>
                            <td class="cella2">MATERIE PRIME</td> 
                            <td class="cella2">GIACENZA</td> 
                            <td class="cella2">QUANTIT?? NECESSARIA</td>
                            <td class="cella2"><nobr>QUANTIT?? MANCANTE</nobr></td>

                        </tr>
                        <?php
                        $ordineTotEvaso = true;
                        for ($j = 0; $j < count($arrayMat); $j++) {

//Per ogni materia prima faccio la differenza tra la giacenza e la qta necessaria 
                            $sqlGiacenza = findMatPrimaByCodice($arrayMat[$j]);
                            while ($row = mysql_fetch_array($sqlGiacenza)) {
                                $giacenzaMat = $row['giacenza_attuale'];
                                $descriMateria = $row['descri_mat'];
                            }
//Se la giacenza ?? inferiore alla qta richiesta stampo la qta necessaria 
                            if ($giacenzaMat < $qtaTotMatOrdine[$j]) {
                                $ordineTotEvaso = false;
                                ?>
                                <tr>
                                    <td class="cella2" style='color:#A00028;'><?php echo $arrayMat[$j] . " " . $descriMateria ?></td>
                                    <td class="cella2" style='color:#A00028;text-align: right'><?php echo number_format($giacenzaMat, "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#A00028;text-align: right'><?php echo $qtaTotMatOrdine[$j] . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#A00028;text-align: right'><?php echo number_format(($qtaTotMatOrdine[$j] - $giacenzaMat), "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                </tr>
        <?php } else { ?>
                                <tr><td class="cella2" style='color:#008000;'><?php echo $arrayMat[$j] . " " . $descriMateria ?></td>
                                    <td class="cella2" style='color:#008000;text-align: right'><?php echo number_format($giacenzaMat, "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#008000;text-align: right'><?php echo number_format($qtaTotMatOrdine[$j], "2", ",", ".") . " " . $filtroKgBreve ?></td>
                                    <td class="cella2" style='color:#008000;text-align: right'><?php echo "0 " . $filtroKgBreve ?></td>
                                </tr>
                            <?php } ?>

    <?php } ?>
                    </table>

                    <table><tr><td>

                                <?php
                                if (!$ordineTotEvaso)
                                    echo "<br/><span style='font-size:20px;color:#A00028;'><br/> L' ordine completo non pu?? essere evaso : materie prime insufficienti!";
                                else
                                    echo "<br/><span style='font-size:20px;color:#008000;'><br/> L' ordine completo pu?? essere evaso</span>";
                                ?>
                            </td></tr></table>

                </div>
<?php } ?>
        </div>
    </body>
</html>
