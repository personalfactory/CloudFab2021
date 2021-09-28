<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>    
    <?php
    if ($DEBUG)
        ini_set("display_errors", 1);
    //############# STRINGHE UTENTI - AZIENDE VISIBILI##########################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeForm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_formula');
    $strUtentiAziendeEsp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_esperimento');
    ?>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('sql/script_lab_formula.php');
            include('sql/script_lab_esperimento.php');
            include('sql/script_lab_matpri_teoria.php');
            include('sql/script_lab_parametro_teoria.php');
            include('./sql/script.php');

            $Pagina = "dettaglio_lab_target_formule";

            $ProdOb = $_GET['ProdOb'];

            //################## QUERY AL DB ###################################
            begin();
            $sqlListaFormule = "";
            $sqlListaFormule = findFormuleByProdOb($ProdOb, $strUtentiAziendeForm);
            //Se l'utente è amministratore vede tutte le formule altrimenti solo quelle del proprio gruppo
            /* if ($_SESSION['nome_gruppo_utente'] == 'Amministrazione') {
              $sqlListaFormule = findFormuleByProdOb($ProdOb,$strUtentiAziendeForm);
              } else {
              $sqlListaFormule = findFormuleByProdObUtenteGruppo($ProdOb, $_SESSION['username'], $_SESSION['nome_gruppo_utente'],$strUtentiAziendeForm);
              } */

            //Creo un array contenente i codici di tutte le formule del prod_target                                    
            if (mysql_num_rows($sqlListaFormule) > 0) {

                $k = 0;
                $arrayFormule = array();
                while ($rowListaPr = mysql_fetch_array($sqlListaFormule)) {

                    $arrayFormule[$k] = $rowListaPr['cod_lab_formula'];
                    $k++;
                }
                //Recupero l'elenco delle materie prime definite in tutte le formule
                //prese una sola volta
                $sqlMtFormule = findAllMtProdOb($ProdOb, $prefissoCodMtChim, $strUtentiAziendeForm);
                $sqlCompFormule = findAllMtProdOb($ProdOb, $prefissoCodComp, $strUtentiAziendeForm);
                $sqlParFormule = findAllParProdOb($ProdOb, $strUtentiAziendeForm);
//            }
//                $colspanForm = count($arrayFormule) + 1;
                $wid1Col = 400;
                $widCol = 150;
                $colspanForm = count($arrayFormule);
//                $widthContTot = count($arrayFormule) * $widCol + $wid1Col;
                $widthCont = count($arrayFormule) * $widCol ;

                $widthDivScroll=900;
                ?>
                <div id="container" style="margin:15px auto;width:100%" >
                    <div style="width:100%;height:800px;overflow-y:auto;overflow-x:hidden">
                    <table >    
                        <tr>                            
                            <td valign="top" align="left">
                                <div style="width:<?php echo $wid1Col ?>px">
                                <table width="100%" margin="15px">
                                    <th  class="cella3" style="width:100%;text-align:left;"><?php echo $titoloLabProdTarget . ": " . $ProdOb ?></th>
                                    <!--########################### ELENCO FORMULE ##################-->
                                    <tr>                       
                                        <td class="cellaMergeHFixI" height="60px" width="100%"><?php echo $filtroLabFormule . ": " ?></td>                                        
                                    </tr>
                                    <!--########################### MATERIE PRIME COMPOUND ##################-->
                                    <tr>
                                        <td class="cellaMergeHFix"><?php echo $filtroLabMatPrimeCompound ?></td>
                                    </tr>
                                    <?php
//Scorro l'elenco delle materie prime relative a tutte le formule 
                                    if(mysql_num_rows($sqlMtFormule)>0)
                                    mysql_data_seek($sqlMtFormule, 0);
                                    while ($rowMP = mysql_fetch_array($sqlMtFormule)) {
                                        ?>
                                        <tr>
                                            <td class="cellaMergeHFixMt" width="100%"><?php echo $rowMP['descri_materia'] ?></td>
                                        </tr>
                                    <?php } //End materie prime     ?>

                                    <!--########################### MATERIE PRIME DRYMIX ##################-->
                                    <tr>
                                        <td class="cellaMergeHFix" width="100%"><?php echo $filtroLabMaterieDrymix ?></td>
                                    </tr>
                                    <?php
                                    //Scorro l'elenco dei componenti definiti per tutte  le formule
                                    if(mysql_num_rows($sqlCompFormule)>0)
                                    mysql_data_seek($sqlCompFormule, 0);
                                    while ($rowComp = mysql_fetch_array($sqlCompFormule)) {
                                        ?>
                                        <tr>
                                            <td class="cellaMergeHFixMt" width="100%"><?php echo $rowComp['descri_materia'] ?></td> 
                                        </tr>
                                    <?php } //End materie prime drymix    ?>

                                    <!--########################### PARAMETRI ########################-->                                   
                                    <tr>
                                        <td class="cellaMergeHFix" width="100%"><?php echo $filtroLabParametri ?></td>
                                    </tr>
                                    <?php
                                    //Scorro l'elenco dei parametri definiti per le formule
                                    if(mysql_num_rows($sqlParFormule)>0)
                                    mysql_data_seek($sqlParFormule, 0);
                                    while ($rowPar = mysql_fetch_array($sqlParFormule)) {
                                        ?>
                                        <tr>
                                            <td class="cellaMergeHFixMt" width="100%"><?php echo $rowPar['nome_parametro'] ?></td> 
                                        </tr>
                                    <?php } //End parametri     ?>

                                    <!--########################### ELENCO FORMULE #####################-->
                                    <tr>
                                        <td class="cellaMergeHFixI" height="60px" width="100%"><?php echo $filtroLabFormule . ": " ?></td>
                                    </tr>                                  
                                    <!--########################### ELENCO ESPERIMENTI ##################-->   
                                        <tr>
                                            <td class="cellaMergeHFix" ></td>
                                        </tr> 
                                </table>                            
                            </div>
                            </td>
                            <td valign="top" align="left"> 
                                <div style="width:<?php echo $widthDivScroll?>px;overflow-x:auto;overflow-y:hidden">                                    
                                    <table width="<?php echo $widthCont?>px">
                                        <th  colspan="<?php echo $colspanForm ?>" class="cella3" style="text-align:left;"></th>
                                        <!--########################### ELENCO FORMULE ##################-->
                                        <tr>                       
                                            <?php for ($j = 0; $j < count($arrayFormule); $j++) { ?>
                                                <td  class="cellaMergeHFixI"  width="<?php echo $widCol ?>px"><a target="blank" href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo $arrayFormule[$j] ?>"><?php echo $arrayFormule[$j] ?></a></td>
                                            <?php } ?>
                                        </tr>
                                        <!--########################### MATERIE PRIME COMPOUND ##################-->
                                        <tr>
                                            <td class="cellaMergeHFix"  colspan="<?php echo $colspanForm ?>"></td>
                                        </tr>   
                                        <?php
//Scorro l'elenco delle materie prime relative a tutte le formule 
                                        if(mysql_num_rows($sqlMtFormule))
                                        mysql_data_seek($sqlMtFormule, 0);
                                        while ($rowMP = mysql_fetch_array($sqlMtFormule)) {
                                            ?>
                                            <tr>
                                                <?php
                                                //Scorro l'elenco delle formule
                                                for ($j = 0; $j < count($arrayFormule); $j++) {
                                                    ?>                                   
                                                    <td class="cellaMergeHFixMt" width="<?php echo $widCol ?>px">
                                                        <table  width="100%">
                                                            <?php
                                                            $sqlQtaTeo = findQtaByCodFormIdMat($arrayFormule[$j], $rowMP['id_mat']);
                                                            while ($rowQtaTeo = mysql_fetch_array($sqlQtaTeo)) {
                                                                ?>
                                                                <tr>
                                                                <!--<td class="dataRigGray" width="60px" title="<?php echo $arrayFormule[$j] . ": " . $rowMP['descri_materia'] ?>"><?php echo $rowQtaTeo['qta_teo'] . $filtroLabGrammo ?></td>--> 
                                                                    <td  width="100%" title="<?php echo $arrayFormule[$j] . ": " . $rowMP['descri_materia'] ?>"><?php echo $rowQtaTeo['qta_teo_perc'] . $filtroLabPerc ?></td> 
                                                                </tr>
                                                            <?php }//End qta      ?>
                                                        </table>

                                                    </td>
                                                <?php } //End formule     ?>
                                            </tr>
                                        <?php } //End materie prime     ?>

                                        <!--########################### MATERIE PRIME DRYMIX ##################-->
                                        <tr>
                                            <td class="cellaMergeHFix" colspan="<?php echo $colspanForm ?>"></td>
                                        </tr>
                                        <?php
                                        //Scorro l'elenco dei componenti definiti per tutte  le formule
                                        if(mysql_num_rows($sqlCompFormule)>0)
                                        mysql_data_seek($sqlCompFormule, 0);
                                        while ($rowComp = mysql_fetch_array($sqlCompFormule)) {
                                            ?>
                                            <tr>
                                            <!--<td class="cellaMergeHFix" width="<?php echo $wid1Col ?>"><?php echo $rowComp['descri_materia'] ?></td>--> 
                                                <?php for ($j = 0; $j < count($arrayFormule); $j++) { ?>                                    
                                                    <td class="cellaMergeHFixMt" width="<?php echo $widCol ?>px"> 
                                                        <table  width="100%">
                                                            <?php
                                                            $sqlQtaTeo = findQtaByCodFormIdMat($arrayFormule[$j], $rowComp['id_mat']);
                                                            while ($rowQtaTeo = mysql_fetch_array($sqlQtaTeo)) {
                                                                ?>
                                                                <tr>
                                                                <!--<td class="dataRigGray" width="60px" title="<?php echo $arrayFormule[$j] . ": " . $rowComp['descri_materia'] ?>"><?php echo $rowQtaTeo['qta_teo'] . $filtroLabGrammo ?></td>--> 
                                                                    <td  width="100%" title="<?php echo $arrayFormule[$j] . ": " . $rowComp['descri_materia'] ?>"><?php echo $rowQtaTeo['qta_teo_perc'] . $filtroLabPerc ?></td> 
                                                                </tr>
                                                            <?php }//End qta      ?>
                                                        </table>
                                                    </td>
                                                <?php } //End formule     ?>
                                            </tr>
                                        <?php } //End materie prime drymix    ?>

                                        <!--########################### TOTALE #############################-->
                    <!--                    <tr>
                                            <td class="dataRigWhite" style="width:400px"><?php echo $filtroLabTotale ?></td>
                                        <?php
                                        for ($j = 0; $j < count($arrayFormule); $j++) {
                                            $qtaTotale = 0;
                                            $sqlQtaTotTeo = findQtaTotMatPrimeByCodForm($arrayFormule[$j]);
                                            $rowTot = mysql_fetch_row($sqlQtaTotTeo);
                                            $qtaTotale = $rowTot[0];
                                            ?>
                                                                        <td class="dataRigWhite"  title="<?php echo $arrayFormule[$j] ?>"><?php echo $qtaTotale . $filtroLabGrammo ?></td> 
                                        <?php } ?>
                                        </tr>-->
                                        
                                        <!--########################### PARAMETRI ########################-->
                                        <tr>
                                            <td class="cellaMergeHFix" colspan="<?php echo $colspanForm ?>"></td>
                                        </tr>

                                        <?php
                                        //Scorro l'elenco dei parametri definiti per le formule
                                        if(mysql_num_rows($sqlParFormule)>0)
                                        while ($rowPar = mysql_fetch_array($sqlParFormule)) {
                                            ?>
                                            <tr>
                                                <?php for ($j = 0; $j < count($arrayFormule); $j++) { ?>                                    
                                                    <td class="cellaMergeHFixMt" width="<?php echo $widCol ?>px"> 
                                                        <table  width="100%">
                                                            <?php
                                                            $sqlQtaParTeo = findQtaByCodFormIdPar($arrayFormule[$j], $rowPar['id_par']);
                                                            while ($rowQtaParTeo = mysql_fetch_array($sqlQtaParTeo)) {
                                                                if ($rowPar['tipo'] == $PercentualeSI) {
                                                                    ?>                                      
                                                                    <td  width="100%" title="<?php echo $arrayFormule[$j] . ": " . $rowPar['nome_parametro'] ?>"><?php echo $rowQtaParTeo['valore_teo'] . $filtroLabPerc ?></td> 
                                                                <?php } else { ?>
                                                                    <td  width="100%" title="<?php echo $arrayFormule[$j] . ": " . $rowPar['nome_parametro'] ?>"><?php echo $rowQtaParTeo['valore_teo'] . $rowPar['unita_misura'] ?></td> 
                                                                <?php } ?>
                                                            <?php }//End qta    ?>
                                                        </table>
                                                    </td>
                                                <?php } //End formule      ?>
                                            </tr>
                                        <?php } //End parametri     ?>
                                        <!--########################### ELENCO FORMULE #####################-->
                                        <tr>
                                        <!--<td class="cellaMergeHFix" width="<?php echo $wid1Col ?>"><?php echo $filtroLabFormule . ": " ?></td>-->
                                            <?php for ($j = 0; $j < count($arrayFormule); $j++) { ?>
                                                <td class="cellaMergeHFixI"  width="<?php echo $widCol ?>px"><a target="blank" href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo $arrayFormule[$j] ?>"><?php echo $arrayFormule[$j] ?></a></td>
                                            <?php } ?>
                                        </tr>

                                        <!--########################### ELENCO ESPERIMENTI ##################-->   
                                        <tr>
                                            <td class="cellaMergeHFix" colspan="<?php echo $colspanForm ?>"><?php echo $filtroLabEsperimentiFatti ?></td>
                                        </tr>      
                                        <tr>

                                            <?php for ($j = 0; $j < count($arrayFormule); $j++) { ?>                                    

                                                <td class="cella1"  width="100px"> 
                                                    <table   width="100%">
                                                        <?php
                                                        $sqlListaProve = selectEsperimentiVisByFormula($arrayFormule[$j], $strUtentiAziendeEsp);

                                                        while ($rowProva = mysql_fetch_array($sqlListaProve)) {
                                                            ?>
                                                            <tr>
                                                                <td   title="<?php echo $arrayFormule[$j] ?>">
                                                                    <a target="blank" href="modifica_lab_risultati.php?IdEsperimento=<?php echo $rowProva['id_esperimento'] ?>"><?php echo $rowProva['cod_barre'] ?></td> 
                                                            </tr>
                                                        <?php } // End prove    ?>
                                                    </table>
                                                </td>
                                            <?php } //End formule  
                                            ?>
                                        </tr>

                                    </table>
                                        
                                </div>
                            </td>
                        </tr>

                    </table>      
                </div>
                                    </div>

            <?php } ?>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
//                        echo "actionOnLoad :" . $actionOnLoad;
                    echo "</br>Tab lab_formula : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziendeForm;
                    echo "</br>Tab lab_esperimento : Nuova stringa unica utenti e aziende visibili : " . $strUtentiAziendeEsp;
                }
                ?>
            </div>
        </div><!-- mainContainer -->
    </body>
</html>









