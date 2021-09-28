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
            include('../Connessioni/serverdb.php');

            $CodiceSacco = $_GET['Sacco'];
            $IdProcesso = "";
            $CodiceStabilimento = "";
            $DataProduzione = "";
            $CodiceChimica = "";
            $CodiceProdotto = "";
            $CodiceFormula = "";
            $DescriFormula = "";
            $DataFormula = "";
            $CodiceColore = "";
            $CodiceComponentiPeso = "";
            $Cliente = "";
            $IdMiscela = "";
            $DataMiscela = "";
            $PesoRealeMiscela = "";
            $Contenitore = "";
            $CodiceLotto = "";
            $DescriLotto = "";
            $DataLotto = "";
            $DataLottoChimica = "";
            $NumeroBolla = "";
            $DataBolla = "";
            $PesoRealeSacco = "";
            $DescriComp = "";
            $QtaComp = "";

            //####################### PROCESSO ###################################           

            $sqlProcesso = mysql_query("SELECT
				   	processo.id_processo ,
						processo.cod_stab,
            processo.descri_stab,
            processo.id_macchina,
						processo.dt_produzione_mac,
						processo.cod_sacco,
            processo.peso_reale_sacco,						
            processo.cod_chimica,
						processo.cod_prodotto,
						processo.cod_colore,
						processo.cod_comp_peso,
						processo.cliente,
            processo.dt_abilitato						
			FROM
					processo
											
			WHERE 
		 			processo.cod_sacco='" . $CodiceSacco . "'")
                    or die("ERRORE 1 SELECT FROM processo: " . mysql_error());

            if (mysql_num_rows($sqlProcesso) > 0) {



                while ($rowProc = mysql_fetch_array($sqlProcesso)) {

                    $IdProcesso = $rowProc['id_processo'];
                    $IdMacchina = $rowProc['id_macchina'];
                    $CodiceStabilimento = $rowProc['cod_stab'];
                    $DescriStabilimento = $rowProc['descri_stab'];
                    $DataProduzione = $rowProc['dt_produzione_mac'];
                    $CodiceChimica = $rowProc['cod_chimica'];
                    $CodiceProdotto = $rowProc['cod_prodotto'];
                    $CodiceFormula = "K" . substr($CodiceChimica, 1, 5);
                    $CodiceColore = $rowProc['cod_colore'];
                    $CodiceComponentiPeso = $rowProc['cod_comp_peso'];
                    $Cliente = $rowProc['cliente'];
                    $PesoRealeSacco = $rowProc['peso_reale_sacco'];
                }

//####################### PRODOTTO ###################################

                $sqlProdotto = mysql_query("SELECT
                          id_prodotto,
                          nome_prodotto
                      FROM
                          prodotto 
                      
                      WHERE 
                      cod_prodotto='" . $CodiceProdotto . "'")
                        or die("ERRORE 2 SELECT FROM chimica: " . mysql_error());

                while ($rowProdotto = mysql_fetch_array($sqlProdotto)) {
                    $IdProdotto = $rowProdotto['id_prodotto'];
                    $NomeProdotto = $rowProdotto['nome_prodotto'];
                }
//####################### FORMULA ###################################

                $sqlFormula = mysql_query("SELECT dt_formula, dt_abilitato, descri_formula
                      FROM
                          formula 
                      WHERE 
                        cod_formula = '" . $CodiceFormula . "'")
                        or die("ERRORE 3 SELECT FROM chimica: " . mysql_error());

                while ($rowFormula = mysql_fetch_array($sqlFormula)) {

                    $DescriFormula = $rowFormula['descri_formula'];
                    $DataFormula = $rowFormula['dt_formula'];
                    $DataAbilitatoFormula = $rowFormula['dt_abilitato'];
                }

//####################### CHIMICA ###################################

                $sqlChimica = mysql_query("SELECT
				   						
                      chimica.descri_formula,
                      chimica.cod_lotto,
                      chimica.descri_formula,
                      lotto.descri_lotto,
                      lotto.dt_lotto,
                      chimica.data,
                      lotto.num_bolla,
                      lotto.dt_bolla                      
								
            FROM
                chimica 
            INNER JOIN 
            
                    lotto ON lotto.cod_lotto = chimica.cod_lotto

            WHERE 
                chimica.cod_chimica='" . $CodiceChimica . "'")
                        or die("ERRORE 4 SELECT FROM chimica: " . mysql_error());

                while ($rowChimica = mysql_fetch_array($sqlChimica)) {

                    $DescriFormula = $rowChimica['descri_formula'];
                    $CodiceLotto = $rowChimica['cod_lotto'];
                    $DescriLotto = $rowChimica['descri_lotto'];
                    $DataLotto = $rowChimica['dt_lotto'];
                    $DataLottoChimica = $rowChimica['data'];
                    $NumeroBolla = $rowChimica['num_bolla'];
                    $DataBolla = $rowChimica['dt_bolla'];
                }

                //######################### MISCELA #################################        



                $sqlMiscela = mysql_query("SELECT
                                    sacchetto_chimica.id_miscela,
                                    miscela.dt_miscela,
                                    miscela.cod_contenitore,
                                    miscela.peso_reale
                                  FROM
                                    miscela
                                  INNER JOIN 
                                    sacchetto_chimica 
                                  ON miscela.id_miscela = sacchetto_chimica.id_miscela
                                  WHERE 
                                    sacchetto_chimica.cod_chimica='" . $CodiceChimica . "'")
                        or die("ERRORE 5 SELECT FROM MISCELA : " . mysql_error());

                while ($rowMiscela = mysql_fetch_array($sqlMiscela)) {

                    $IdMiscela = $rowMiscela['id_miscela'];
                    $DataMiscela = $rowMiscela['dt_miscela'];
                    $Contenitore = $rowMiscela['cod_contenitore'];
                    $PesoRealeMiscela = $rowMiscela['peso_reale'];
                }
                ?>
                <div id="container" style="width:800px; margin:15px auto ;">
                    <form id="DettaglioSacchetto" name="DettaglioSacchetto">
                        <table width="100%px">

                            <!--  ######################### STABILIMENTO ################################# -->

                            <th class="cella3" colspan="2">STABILIMENTO </th>

                            <tr>
                                <td height="30px" class="cella2">ID STABILIMENTO</td>
                                <td class="cella1"><?php echo $IdMacchina; ?></td>
                            </tr> 
                            <tr>
                                <td height="30px" class="cella2">CODICE STABILIMENTO</td>
                                <td class="cella1"><?php echo $CodiceStabilimento; ?></td>
                            </tr>

                            <tr>
                                <td height="30px" class="cella2">NOME STABILIMENTO</td>
                                <td class="cella1"><?php echo $DescriStabilimento; ?></a></td>
                            </tr>
                            <!--  ######################### PROCESSO ################################# -->
                            <th class="cella3" colspan="2">PRODOTTO FINITO</th>
                            <tr>
                                <td height="30px" class="cella2" >ID PROCESSO </td>
                                <td class="cella1"><?php echo $IdProcesso; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2" >PRODOTTO </td>
                                <td class="cella1"><?php echo $CodiceProdotto . "  " . $NomeProdotto ?></td>
                            </tr>
                            <tr>
                                <td height="30px" width="200px" class="cella2" >CODICE SACCO </td>
                                <td class="cella1"><?php echo $CodiceSacco; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" width="200px" class="cella2" >PESO REALE &ensp;g </td>
                                <td class="cella1"><?php echo $PesoRealeSacco; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2" >DATA DI PRODUZIONE </td>
                                <td class="cella1"><?php echo dataEstraiVisualizza($DataProduzione); ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2" >CODICE COLORE </td>
                                <td class="cella1"><?php echo $CodiceColore; ?></td>
                            </tr>
<!--                            <tr>
                                <td height="30px" class="cella2">PESO COMPONENTI </td>
                                <td class="cella1"><?php echo $CodiceComponentiPeso; ?></td>
                            </tr>-->
                            <tr>
                                <td height="30px" class="cella2">CLIENTE</td>
                                <td class="cella1"><?php echo $Cliente; ?></td>
                            </tr>
                        
                        
                        <!--  ######################### FORMULA ################################# -->
                       
                            <th class="cella3" colspan="2">FORMULA</th>
                            <tr>
                                <td height="30px" class="cella2" >FORMULA </td>
                                <td class="cella1"><?php echo $CodiceFormula . "  " . $DescriFormula ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2" >DATA CREAZIONE  </td>
                                <td class="cella1"><?php echo dataEstraiVisualizza($DataFormula); ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2" >DATA MODIFICA  </td>
                                <td class="cella1"><?php echo dataEstraiVisualizza($DataAbilitatoFormula); ?></td>
                            </tr>

                            <!--  ######################### TRACCIABILITA ################################# -->
                            <th class="cella3" colspan="2">KIT E LOTTO CHIMICA</th>
                            <tr>
                                <td height="30px" class="cella2" >CODICE CHIMICA </td>
                                <td class="cella1"><?php echo $CodiceChimica; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2">CODICE LOTTO</td>
                                <td class="cella1"><?php echo $CodiceLotto; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2">DATA LOTTO</td>
                                <td class="cella1"><?php echo dataEstraiVisualizza($DataLotto); ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2">NOME LOTTO</td>
                                <td class="cella1"><?php echo $DescriLotto; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2">DATA ASSOCIAZIONE LOTTO-CHIMICA</td>
                                <td class="cella1"><?php echo dataEstraiVisualizza($DataLottoChimica); ?></td>
                            </tr>
                            <!--  ######################### DDT ################################# -->

                            <th class="cella3" colspan="2">DOCUMENTO DI TRASPORTO</th>
                            <tr>
                                <td height="30px" class="cella2">NUMERO DDT</td>
                                <td class="cella1"><?php echo $NumeroBolla; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2" >DATA DDT </td>
                                <td class="cella1"><?php echo dataEstraiVisualizza($DataBolla); ?></td>
                            </tr>
                            <!--  ######################### PRODUZIONE MISCELA ################################# -->

                            <th class="cella3" colspan="2">PRODUZIONE MISCELA</th>
                            <tr>
                                <td height="30px" class="cella2">ID MISCELA</td>
                                <td class="cella1"><?php echo $IdMiscela; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2">DATA MISCELA</td>
                                <td class="cella1"><?php echo dataEstraiVisualizza($DataMiscela); ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2">PESO REALE </td>
                                <td class="cella1"><?php echo $PesoRealeMiscela . "&ensp;g"; ?></td>
                            </tr>
                            <tr>
                                <td height="30px" class="cella2">CONTENITORE</td>
                                <td class="cella1"><?php echo $Contenitore; ?></td>
                            </tr>

                        </table>

                        
<!--  //############# FORMULA PRODOTTO #####################################-->
   <table width="100%">
                       <?php     if (is_numeric(substr($CodiceComponentiPeso, 0, 1))) {
                                ?>                                
                            <tr>
                                <td class="cella3">COMPONENTI</td>
                                <td class="cella3">PESO REALE </td>
                           </tr>
           <?php                  
                            $ListaComponenti = array();
                            $Comp = array();
//                            $parola = "3_035700.11_063600";
                            $ListaComponenti = explode('.', $CodiceComponentiPeso);

                            for ($i = 0; $i < count($ListaComponenti); $i++) {

                                $Comp = explode('_', $ListaComponenti[$i]);
                                $IdComp = $Comp[0];
                                $QtaComp = $Comp[1];

                                $sqlNomeComp = mysql_query("SELECT
                                    descri_componente
                                  FROM
                                    componente
                                  WHERE 
                                    id_comp=" . $IdComp)
                                        or die("ERRORE  SELECT FROM componente : " . mysql_error());

                                while ($rowDescriComp = mysql_fetch_array($sqlNomeComp)) {

                                    $DescriComp = $rowDescriComp['descri_componente'];
                                }
                                ?>
                                <tr>
                                    <td class="cella1"><?php echo $DescriComp; ?></td>
                                    <td class="cella1"><?php echo $QtaComp . "&ensp;g"; ?></td>
                                </tr>
                            <?php }
                             } else {?>
                                    
                                    <tr>
                                        <td class="cella2">CODICE COMPONENTI DRYMIX</td>
                                        <td class="cella1"><?php echo $CodiceComponentiPeso?> </td>
                                    </tr>
                                    
                                    <?php }//END if(is_numeric(substr($CodiceComponentiPeso, 0,1)))
                                ?>
                           
                        </table>
                        <?php
} else {
    echo " <div style='color: #FF0000' >CODICE NON TROVATO!</div>";
}
?>
                        <tr>
                            <td><input type="reset" value="TORNA INDIETRO " onClick="javascript:history.back();"/></td>
                        </tr>
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>
