<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            if ($DEBUG)
                ini_set('display_errors', 1);

            include('../include/menu.php');
            include('../include/funzioni.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_formula.php');
            include('../sql/script_materia_prima.php');
//            include('../sql/script_accessorio.php');
            include('../sql/script_accessorio_formula.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_generazione_formula.php');

            $Pagina = "vista_prodotto_formula";

            $CodiceProdPadre = "";
            $NomeProdPadre = "";

//A questa pagina si accede sia dalla gestione dei prodotti 
//e sia dalla gestione delle formule quindi bisogna distinguere i due casi con un if
//##############################################################################
//################### PRODOTTO ################################################# 
//##############################################################################
//Se arriva l'id_prodotto con il metodo GET (dalla pagina gestione_anagrafe_prodotti.php)
//Si ricava prima il codice prodotto e poi il codice formula
            if (isset($_GET['Prodotto'])) {
                $IdProdotto = $_GET['Prodotto'];

                $sqlCodProd = findAllDatiProdottoById($IdProdotto);
                while ($rowCodProd = mysql_fetch_array($sqlCodProd)) {
                    $CodiceProdotto = $rowCodProd['cod_prodotto'];
                    $IdProdottoPadre = $rowCodProd['colorato'];
                    $CodiceProdPadre = $CodiceProdotto;
                    $NomeProdPadre = $rowCodProd['nome_prodotto'];
                }
                $CodiceFormula = "K" . $CodiceProdotto;
                //Se si tratta di un prodotto figlio vado a cercare 
                //il codice chimica del prodotto padre
                if ($IdProdottoPadre > 0) {

                    $sqlProdPadre = findProdottoById($IdProdottoPadre);
                    while ($rowProdPadre = mysql_fetch_array($sqlProdPadre)) {
                        $CodiceProdPadre = $rowProdPadre['cod_prodotto'];
                        $NomeProdPadre = $rowProdPadre['nome_prodotto'];
                    }
                    $CodiceFormula = "K" . $CodiceProdPadre;
                }
                //NOTA: Se si tratta di un prodotto nipote al momento non viene 
                //trovata la chimica
            }
//Se arriva il codice formula con il metodo GET (dalla pagina gestione_formule.php)
//Si ricava prima il codice formula e poi l'id prodotto
            if (isset($_GET['CodiceFormula'])) {

                $CodiceFormula = $_GET['CodiceFormula'];
                $CodiceProdotto = substr($CodiceFormula, 1, 5);

                $IdProdotto = 0;
                $sqlCodProd = findProdottoByCodice($CodiceProdotto);
                while ($rowCodProd = mysql_fetch_array($sqlCodProd)) {
                    $IdProdotto = $rowCodProd['id_prodotto'];
                }
            }

            if ($IdProdotto != 0) {//Vuol dire che il prodotto e' stato creato
                //Visualizzo il record  all'interno della form
                //Estraggo i dati del prodotto da modificare dalle tabelle prodotto e anagrafe prodotto
                $sqlProdotto = findAllDatiProdottoById($IdProdotto);

                while ($rowProdotto = mysql_fetch_array($sqlProdotto)) {

                    $CodiceProdotto = $rowProdotto['cod_prodotto'];
                    $NomeProdotto = $rowProdotto['nome_prodotto'];
                    $Colorato = $rowProdotto['colorato'];
                    $LimiteColore = $rowProdotto['lim_colore'];
                    $FattoreDivisore = $rowProdotto['fattore_div'];
                    $Fascia = $rowProdotto['fascia'];
                    $IdMazzetta = $rowProdotto['id_mazzetta'];
                    $Mazzetta = $rowProdotto['cod_mazzetta'];
                    $Geografico = $rowProdotto['geografico'];
                    $TipoRiferimento = $rowProdotto['tipo_riferimento'];
                    $Gruppo = $rowProdotto['gruppo'];
                    $LivelloGruppo = $rowProdotto['livello_gruppo'];
                    $IdCategoria = $rowProdotto['id_cat'];
                    $Categoria = $rowProdotto['nome_categoria'];
                    $Abilitato = $rowProdotto['abilitato'];
                }

                $Data = maxDataProdotto($IdProdotto);
                ?>


                <div id="container" style="width:1000px; margin:15px auto;">
                    <table width="100%" >
                        <tr>
                            <td  colspan="9" class="cella3"><?php echo $filtroProdotto ?></td>
                        </tr>
                        <tr>
                            <td width="300px" class="cella4"><?php echo $filtroCodice ?></td>
                            <td class="cella11" ><?php echo $CodiceProdotto; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroNome ?></td>
                            <td class="cella11"><?php echo $NomeProdotto; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroCategoria ?></td>
                            <td class="cella11"><?php echo $Categoria; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroProdotto . " " . $filtroPadre ?></td>
                            <td class="cella11"><?php echo $CodiceProdPadre . " - " . $NomeProdPadre ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroDtUltimaMod ?></td>
                            <td class="cella11"><?php echo $Data; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroGeografico ?></td>
                            <td class="cella11"><?php echo $TipoRiferimento . " : " . $Geografico; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4" ><?php echo $filtroGruppoAcquisto ?> </td>
                            <td class="cella11"><?php echo $LivelloGruppo . " : " . $Gruppo; ?></td>
                        </tr>

                    </table>
                    <table width="100%" >
                        <tr>
                            <td class="cella3"><?php echo $filtroMaterieDrymix ?></td>
                            <td class="cella3"><?php echo $filtroQuantita ?></td>
                            <td class="cella3"><?php echo $filtroCosto ?> </td>
                            <td class="cella3"><?php echo $filtroCostoKilo ?></td>
                        </tr>
                        <?php
                        //Estraggo i dati dei componenti da modificare dalla tab componente_prodotto	
                        $NComp = 1;
                        $QtaTotale = 0;
                        $Prezzo = 0;
                        $PrezzoTotale = 0;
                        $PrezzoUnitarioQt=0;
                        $sqlComponente = selectComponentiByIdProdAbil($IdProdotto, $valAbilitato);
                        //selectComponentiByIdProdotto($IdProdotto);
                        while ($rowComponente = mysql_fetch_array($sqlComponente)) {
                            $QtaTotale = $QtaTotale + $rowComponente['quantita'];
                            ?>
                            <tr>
                                <td width="300" class="cella4"><?php echo($rowComponente['descri_componente']); ?></td>
                                <td  class="cella1"><?php echo($rowComponente['quantita']) . " " . $filtrogBreve ?></td>
                                <?php
                                //Inizio prezzo
                                $sqlPrezzo = findMatPrimaByCodice($rowComponente['cod_componente']);
                                while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {
                                    $PrezzoUnitarioQt = number_format($rowPrezzo['pre_acq'], 4, ',', '');
                                    $PrezzoUnitario = $rowPrezzo['pre_acq'] / 1000;
                                    $Prezzo = ($rowComponente['quantita']) * ($PrezzoUnitario);
                                    $PrezzoTotale = $PrezzoTotale + $Prezzo;
                                    ?>
                                    <td  class="cella1"><?php echo number_format($Prezzo, 4, ',', '') . " " . $filtroEuro ?></td>
                                    <td  class="cella1"><?php echo $PrezzoUnitarioQt . " " . $filtroEuro ?></td>
                                </tr>      
                                <?php
                                
                            }//End While Prezzo 
                            if(mysql_num_rows($sqlPrezzo)==0){?>
                                <td  class="cella1"><?php echo number_format($Prezzo, 4, ',', '') . " " . $filtroEuro ?></td>
                                <td  class="cella1"><?php echo $PrezzoUnitarioQt . " " . $filtroEuro ?></td>
                                </tr> 
                                
                            <?php }


                            $NComp++;
                        }//End While Componenti
                        ?>
                        <tr>
                            <td class="cella2" colspan="1"><?php echo $filtroTotali ?></td>
                            <td class="cella3" ><?php echo $QtaTotale . " " . $filtrogBreve ?></td>   
                            <td class="cella3" ><?php echo $PrezzoTotale . " " . $filtroEuro ?></td> 
                            <td class="cella3" ></td> 
                        </tr>   
                    </table>
                </div>   

                <?php
            }//End if IdProdotto!=0
//############################################################################## 
//################### FORMULA ##################################################
//############################################################################## 
            //Inizializzo le variabili numeriche
            $CostoKitMatCompoundTotale = 0;
            $CostoMiscelaMtTotale = 0;
            $TotaleQtaKit = 0;
            $TotaleQtaMiscela = 0;
            $TotalePercentuale = 0;
            $DataFormula = "";
            $DescriFormula = "";
            $NumSacchetti = "";
            $QtaSacchetto = "";
            $Abilitato = "";
            $Data = "";
            $sqlFormula = findAnFormulaByCodice($CodiceFormula);
            //NOTA : Se non si trova la formula vuol dire che il prodotto oltre 
            //ad essere un prodotto figlio è anke "nipote"....Quindi in questo caso non si 
            //la formula. Andrebbe fatta un'altra ricerca per vedere quale chimica usa il prodotto "nonno"
            if (mysql_num_rows($sqlFormula) > 0) {
                while ($rowFormula = mysql_fetch_array($sqlFormula)) {
                    $DataFormula = $rowFormula['dt_formula'];
                    $DescriFormula = $rowFormula['descri_formula'];
                    $NumSacchetti = $rowFormula['num_sac'];
                    $QtaSacchetto = $rowFormula['qta_sac'];
                    $Abilitato = $rowFormula['abilitato'];
                    $Data = $rowFormula['dt_abilitato'];
                    $NumeroLotti = $rowFormula['num_lotti'];
                    $QtaMiscelaInserita = $rowFormula['qta_tot_miscela'];
                    $PesoLotto = $rowFormula['qta_lotto'];
                    $NumeroKitSacchetti = $rowFormula['num_sac_in_lotto'];
                }
                ?>


                <div id="container" style="width:1000px; margin:15px auto;">
                    <table width="100%" >
                        <tr>
                            <td colspan="2" class="cella3"><?php echo $filtroFormula ?></td>
                        </tr>
                        <tr>
                            <td width="300px" class="cella4"><?php echo $filtroDtCreazione ?></td>
                            <td class="cella11"><?php echo $DataFormula; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroCodice ?></td>
                            <td class="cella11"><?php echo $CodiceFormula; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroDescrizione ?></td>
                            <td class="cella11"><?php echo $DescriFormula; ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroDtUltimaMod ?></td>
                            <td class="cella11"><?php echo $Data; ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                        <tr>
                            <td colspan="4" class="cella3"><?php echo $filtroMetodoCalcolo ?></td>
                        </tr>
                        <tr title="<?php echo $titleMetodoCalcoloMiscNumLotti ?>">
                            <td class="cella4"><?php echo $filtroNumKitPerLotto ?></td>
                            <td class="cella1"><?php echo $NumeroKitSacchetti . " " . $filtroPz; ?></td>
                            <td class="cella4"><?php echo $filtroNumLotti ?></td>
                            <td class="cella1"><?php echo $NumeroLotti . " " . $filtroPz; ?></td>
                        </tr>
                        <tr title="<?php echo $titleMetodoCalcoloMiscTot ?>">
                            <td class="cella4"><?php echo $filtroQtaTotaleMiscela ?></td>
                            <td class="cella1"><?php echo $QtaMiscelaInserita . " " . $filtrogBreve ?></td>
                            <td class="cella4"><?php echo $filtroPesoLotto ?></td>
                            <td class="cella1"><?php echo $PesoLotto . " " . $filtrogBreve ?></td>
                        </tr>
                    </table>
                    <table width="100%">
                         <tr>
                                <td class="cella3" colspan="2"><?php echo $filtroConfezionamento ?></td>
                                <td class="cella3"><?php echo $filtroCostoUn ?></td>
                                <td class="cella3"><?php echo $filtroQuantita ?></td>
                                <td class="cella3"><?php echo $filtroCosto ?></td>
                            </tr>
                        <?php
                            $NAcc = 1;
                            $CostoTotaleAccessori = 0;
                            $sqlAccessori = findAccessoriFormulaByCodFormula($CodiceFormula);
                            while ($rowAccessori = mysql_fetch_array($sqlAccessori)) {
                                $QtaAccessorio = $rowAccessori['quantita'];
                                if($QtaAccessorio>0)
                                    $CostoTotaleAccessori = $CostoTotaleAccessori + number_format($QtaAccessorio * $rowAccessori['pre_acq'], 2, '.', '');
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowAccessori['codice']) ?></td>
                                    <td class="cella4"><?php echo($rowAccessori['descri']) ?></td>
                                    <td class="cella4"><?php echo $rowAccessori['pre_acq']. " " . $filtroEuro?></td>
                                    <td class="cella4"><?php echo $QtaAccessorio." ".$rowAccessori['uni_mis']?></td>
                                    <td class="cella4"><?php echo number_format($QtaAccessorio * $rowAccessori['pre_acq'], 2, '.', '') . " " . $filtroEuro ?></td>
                                </tr>
                                <?php                                
                                $NAcc++;
                            }//End while Accessori
                            ?>
                            <tr>
                                <td class="dataRigWhite" colspan="4"><?php echo $filtroCostoTotale . " " . $filtroConfezionamento ?></td>
                                <td class="dataRigWhite"><?php echo number_format($CostoTotaleAccessori, 2, ',', '') . " " . $filtroEuro ?></td>
                            </tr>
                        </table>
                    <table width="100%" >
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $filtroMaterieCompound ?></td>
                            <td width="80px" class="cella3"><?php echo $filtroCosto . " " . $filtroEuroKg ?></td>
                            <td width="50px" class="cella3"><?php echo $filtroQuantita . " " . $filtroPerc ?></td>
                            <td width="100px" class="cella3"><?php echo $filtroQtaPerKit ?> </td>           
                            <td class="cella3"><?php echo $filtroCostoPerKit ?></td>
                            <td class="cella3"><?php echo $filtroQtaPerMiscela ?></td>
                            <td class="cella3"><?php echo $filtroCostoPerMiscela ?></td>
                        </tr> 
                        <?php
//Calcolo il totale delle quantita di mat prime per poter calcolarne il valore percentuale 
                        $NMtPr = 1;
                        $sqlMtPr = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
                        while ($rowMtPr = mysql_fetch_array($sqlMtPr)) {
//                            if ($NumSacchetti > 0)
//                                $QuantitaKit = $rowMtPr['quantita'] / $NumSacchetti;
                                $QuantitaKit = $rowMtPr['qta_kit'];
                            $TotaleQtaKit = $TotaleQtaKit + $QuantitaKit;
                            $NMtPr++;
                        }//End while calcolo totale quantita
//Visualizzo l'elenco delle materie prime presenti nella tabella generazione_formula
                        $NMatPri = 1;
                        mysql_data_seek($sqlMtPr, 0);
                        while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {
                            
                                //Inizio prezzo
                                $sqlPrezzo = findMatPrimaByCodice($rowMatPrime['cod_mat']);
                                while ($rowPrezzo = mysql_fetch_array($sqlPrezzo)) {

                                    $CostoUnitarioKg = $rowPrezzo['pre_acq'];
                                    $CostoUnitario = $rowPrezzo['pre_acq'] / 1000;

                                    //$QuantitaMiscela=$rowMatPrime['quantitaMt']*$NumeroKitSacchetti*$ScatolaPerLotto;
                                    //La qta per miscela è quella registrata in tabella 
                                    $QuantitaMiscela = $rowMatPrime['quantita'];
                                    $CostoMiscela = $QuantitaMiscela * $CostoUnitario;
                                    $CostoMiscelaMtTotale = $CostoMiscelaMtTotale + $CostoMiscela;

//			$CostoKit=$rowMatPrime['quantitaMt']*$CostoUnitario;
//                                    if ($NumSacchetti > 0)
//                                        $QuantitaPerKit = $QuantitaMiscela / $NumSacchetti;
                                        $QuantitaPerKit = $rowMatPrime['qta_kit'];
                                        
                                    $CostoKit = $QuantitaPerKit * $CostoUnitario;
//                                    $CostoKitTotale = $CostoKitTotale + $CostoKit;
                                    $CostoKitMatCompoundTotale = $CostoKitMatCompoundTotale + $CostoKit;

                                    //Trasformo le qta in percentuale
                                    if ($TotaleQtaKit > 0)
                                        $QuantitaPercentuale = ($QuantitaPerKit * 100) / $TotaleQtaKit;
                                    $TotalePercentuale = $TotalePercentuale + $QuantitaPercentuale;
                                }//End While Prezzo 
                                ?>
                        <tr>
                                <td class="cella4" width="80px"><?php echo($rowMatPrime['cod_mat']) ?></td>
                                <td class="cella4" width="300px"><?php echo($rowMatPrime['descri_mat']) ?></td>
                                <td class="cella1"><?php echo number_format($CostoUnitarioKg, 4, ',', '') . " " . $filtroEuro ?></td>
                                <td class="cella1"><?php echo number_format($QuantitaPercentuale, 2, ',', '') . " " . $filtroPerc ?></td>
                                <td class="cella1"><?php echo number_format($QuantitaPerKit, 0, ',', '' ). " " . $filtrogBreve ?></td>
                                <td class="cella1"><?php echo number_format($CostoKit, 2, ',', '') . " " . $filtroEuro ?></td>
                                <td class="cella1"><?php echo number_format($QuantitaMiscela, 0, ',', '') . " " . $filtrogBreve ?></td>	      
                                <td class="cella1"><?php echo number_format($CostoMiscela, 2, ',', '') . " " . $filtroEuro ?></td>
                            </tr>
                            <?php
                            $TotaleQtaMiscela = $TotaleQtaMiscela + $QuantitaMiscela;
                            $NMatPri++;
                        }//End While Materie Prima
//Visualizzo i costi totali e le quantita totali
                        ?>     	
                        <tr>
                            <td class="dataRigWhite" colspan="3"><?php echo $filtroTotali ?>  </td>
                            <td class="dataRigWhite"><?php echo $TotalePercentuale . " " . $filtroPerc ?></td>
                            <td class="dataRigWhite"><?php echo $TotaleQtaKit . " " . $filtrogBreve ?></td>
                            <td class="dataRigWhite"><?php echo number_format($CostoKitMatCompoundTotale, 2, ',', '') . " " . $filtroEuro ?></td>
                            <td class="dataRigWhite"><?php echo $TotaleQtaMiscela . " " . $filtrogBreve ?></td>
                            <td class="dataRigWhite"><?php echo number_format($CostoMiscelaMtTotale, 2, ',', '') . " " . $filtroEuro ?></td>
                        </tr>	
                    </table>

                    <?php
                    include('../include/tabella_costi_formula.php');
                }  // END if mysql_num_row($sqlFormula)>0
                ?>    
                <table width="100%">       
                    <tr>
                        <td><input type="reset" value="<?php echo $valueButtonIndietro ?>" onClick="javascript:history.back();"/></td>
                    </tr>
                </table>     	
            </div>

        </div><!--maincontainer-->

    </body>
</html>
