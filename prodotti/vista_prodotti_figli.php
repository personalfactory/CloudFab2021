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
            include('../sql/script_accessorio_formula.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_anagrafe_prodotto.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_generazione_formula.php');

            $Pagina = "vista_prodotti_figli";

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


                $sqlProdFigli = selectProdFiglioByPadre($IdProdotto);
                
                if (mysql_num_rows($sqlProdFigli) > 0) {

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

                    <div id="container" style="width:500px; margin:15px auto;float:left;">
                        <?php echo "<span style='font-size:25px'>PRODOTTO STANDARD</span>" ?>
                        <table width="100%">
                            <tr>
                                <td class="cella11" colspan="2" style='font-size:18px'><?php echo $CodiceProdotto . " " . $NomeProdotto; ?></td>
                            </tr>
                            <tr>
                                <td class="cella11"><?php echo $Geografico; ?></td>
                                <td class="cella11"><?php echo $LivelloGruppo . " : " . $Gruppo; ?></td>
                            </tr>
                        </table>
                        <table width="100%" >

                            <?php
                            //Estraggo i dati dei componenti da modificare dalla tab componente_prodotto	
                            $NComp = 1;
                            $QtaTotale = 0;
                            $Prezzo = 0;
                            $PrezzoTotale = 0;
                            $PrezzoUnitarioQt = 0;
                            $sqlComponente = selectComponentiByIdProdAbil($IdProdotto, $valAbilitato);

                            while ($rowComponente = mysql_fetch_array($sqlComponente)) {
                                $QtaTotale = $QtaTotale + $rowComponente['quantita'];
                                ?>
                                <tr>
                                    <td class="cella4" width="30px"><?php echo($rowComponente['cod_componente']); ?></td>
                                    <td class="cella4" width="200px" ><?php echo($rowComponente['descri_componente']); ?></td>
                                    <td class="cella4" width="50px"><?php echo($rowComponente['quantita']) . " " . $filtrogBreve ?></td>
                                </tr> 
                                <?php
                                $NComp++;
                            }//End While Componenti
                            ?>
                            <tr>
                                <td class="dataRigWhite" colspan="2"><?php echo $filtroTotali ?></td>
                                <td class="dataRigWhite" ><?php echo $QtaTotale . " " . $filtrogBreve ?></td>   
                            </tr>   
                        </table>
                        <table width="100%" >

                            <?php
//Visualizzo l'elenco delle materie prime presenti nella tabella generazione_formula
                            $TotaleQtaKit = 0;
                            $NMatPri = 1;
                            $sqlMtPr = findMaterieFormulaByCodice($CodiceFormula, "descri_mat");
                            while ($rowMatPrime = mysql_fetch_array($sqlMtPr)) {
                                ?>

                                <tr>
                                    <td class="cella4" width="30px"><?php echo($rowMatPrime['cod_mat']) ?></td>
                                    <td class="cella4" width="200px"><?php echo($rowMatPrime['descri_mat']) ?></td>
                                    <td class="cella4" width="50px"><?php echo number_format($rowMatPrime['qta_kit'], 0, ',', '') . " " . $filtrogBreve ?></td>	      
                                </tr>
                                <?php
                                $TotaleQtaKit = $TotaleQtaKit + $rowMatPrime['qta_kit'];
                                $NMatPri++;
                            }//End While Materie Prima
//Visualizzo i costi totali e le quantita totali
                            ?>     	
                            <tr>
                                <td class="dataRigWhite" colspan="2"><?php echo "TOTALE COMPOUND CHIMICO" ?>  </td>
                                <td class="dataRigWhite"><?php echo $TotaleQtaKit . " " . $filtrogBreve ?></td>
                            </tr>	
                        </table>
                    </div>   
        <?php
        //##########################################################################
        //#################### PRODOTTI FIGLI ######################################
        //##########################################################################
        //Per ogni prodotto padre seleziono eventuali figli
        ?>
                    <div id="container" style="width:700px; margin:15px auto;float:right">
                    <?php
                    echo "<span style='font-size:25px'>PRODOTTI DERIVATI</span>";
                    while ($rowF = mysql_fetch_array($sqlProdFigli)) {
                        $IdProdottoF = $rowF['id_prodotto'];
                        $CodProdottoF = $rowF['cod_prodotto'];
                        $NomeProdottoF = $rowF['nome_prodotto'];
                        $GeograficoF = $rowF['geografico'];
                        $TipoRiferimentoF = $rowF['tipo_riferimento'];
                        $GruppoF = $rowF['gruppo'];
                        $LivelloGruppoF = $rowF['livello_gruppo'];
                        ?>
                            <table width="100%" >
                                <tr>
                                    <td class="cella11" colspan="2" style='font-size:18px'><?php echo $CodProdottoF . " " . $NomeProdottoF; ?></td>
                                </tr>
                                <tr>
                                    <td class="cella11"><?php echo $TipoRiferimentoF . " : " . $GeograficoF; ?></td>
                                    <td class="cella11"><?php echo $LivelloGruppoF . " : " . $GruppoF; ?></td>
                                </tr>
                            </table>

                            <table width="100%" >

            <?php
            //Estraggo i dati dei componenti  dalla tab componente_prodotto	
            $NCompF = 1;
            $QtaTotaleF = 0;
            $PrezzoF = 0;
            $PrezzoTotaleF = 0;
            $sqlComponente = selectComponentiByIdProdAbil($IdProdottoF, $valAbilitato);

            while ($rowComponente = mysql_fetch_array($sqlComponente)) {
                $QtaTotaleF = $QtaTotaleF + $rowComponente['quantita'];
                ?>
                                    <tr>
                                        <td width="30px" class="cella4"><?php echo($rowComponente['cod_componente']); ?></td>
                                        <td width="200px" class="cella4"><?php echo($rowComponente['descri_componente']); ?></td>
                                        <td width="50px"  class="cella4"><?php echo($rowComponente['quantita']) . " " . $filtrogBreve ?></td>
                                    </tr> 

                <?php
                $NComp++;
            }//End While Componenti
            ?>
                                <tr>
                                    <td class="dataRigWhite" colspan="2"><?php echo $filtroTotali ?></td>
                                    <td class="dataRigWhite" ><?php echo $QtaTotaleF . " " . $filtrogBreve ?></td>   
                                </tr>   
                            </table>
                            <br/>
                            <br/>

        <?php }
        ?>
                    </div> 
                        <?php
                    } 
                } else {?>
<div id="container" style="width:700px; margin:50px auto;">
                        <span style='font-size:25px'><?php echo $filtroNessunProdottoFiglio ?></span>
</div>
                  <?php  }
                }//End if IdProdotto!=0
                ?>

        </div><!--maincontainer-->

    </body>
</html>
