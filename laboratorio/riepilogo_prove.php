<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
        <script src="../js/scrollfix.js" type="text/javascript"></script>
    </head>
    <body onunload="unloadP('UniquePageNameHereScroll')" onload="loadP('UniquePageNameHereScroll')"> 
    <!--<body>-->
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('./sql/script.php');
            include('./sql/script_lab_esperimento.php');
            include('./sql/script_lab_risultato_matpri.php');
            include('./sql/script_lab_formula.php');
            include('./sql/script_lab_matpri_teoria.php');
            include('./sql/script_lab_risultato_par.php');
            include('./sql/script_lab_risultato_car.php');

            if ($DEBUG)
                ini_set('display_errors', 1);

            $selezioneProve = 0;
            //Seleziono tutti gli esperimenti
            //Creo un array con i nomi delle formule degli esperimenti
            //uno con i codici a barre
            //un array con tutte le materie prime coinvolte
            //uno con drymix
            //uno con caratteristiche e risultati          
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_esperimento');


            //################## QUERY AL DB ###################################
            begin();

            $sqlProve = findEsperimentiAll($_SESSION['Filtro'], "id_esperimento", "", "", "", "", "", "", "", $strUtentiAziende, $_SESSION['visibilita_utente']);

            commit();

            //Creo un array contenente i codici a barre delle prove selezionate
            //##################################################################
            $k = 1;
            $array['id_prove'] = array();
            $array['prove'] = array();
            $array['formule'] = array();
            $array['qta_tot'] = array();
            while ($row = mysql_fetch_array($sqlProve)) {

                $codBarre = $row['cod_barre'];
                $idEsp = $row['id_esperimento'];

                //Verifico se ci sono formule da escludere
                if (isSet($_POST["elimina" . $codBarre]))
                    unset($_SESSION['cod'][$idEsp]);

                if (isSet($_SESSION['cod'][$idEsp]) AND $_SESSION['cod'][$idEsp] == $row['cod_barre']) {

                    //Bisogna mettere in sessione
                    $selezioneProve = 1;
                    $array['id_prove'][$k] = $row['id_esperimento'];

                    $sqlQtaTotProva = findQtaTotMatPrimeByIdEsper($row['id_esperimento']);
                    while ($rowQ = mysql_fetch_array($sqlQtaTotProva)) {
                        $array['qta_tot'][$k] = $rowQ['totale_qta_reale'];
                    }

                    $array['prove'][$k] = $row['cod_barre'];
                    $array['formule'][$k] = $row['cod_lab_formula'];
                    $k++;
                }
            }

            $stringaProve = "";
            if ($selezioneProve == 1) {

                //Costruisco stringa con elenco id_esperimenti selezionati
                //##################################################################
                $stringaProve = '(';

                for ($i = 1; $i <= count($array['id_prove']); $i++) {

                    $stringaProve = $stringaProve . $array['id_prove'][$i];

                    if ($i == (count($array['id_prove']) ))
                        $stringaProve = $stringaProve . ")";  //Ultima stampa senza virgola finale ma con parentesi
                    else
                        $stringaProve = $stringaProve . ",";  //Stampa interna
                }

//            echo "</br>Stringa prove selezionate" . $stringaProve . "<br/>";
                //###### MATERIE PRIME COMPOUND USATE IN TUTTE LE PROVE #############
                $array['id_mat'] = array();
                $array['cod_mat'] = array();
                $array['descri_materia'] = array();
                $qtaTotMat = 0;
                
                $j = 1;
                $sqlMatPrime = findAllMatPriByArrayEsperimenti($stringaProve,$prefissoCodMtChim);
                while ($row = mysql_fetch_array($sqlMatPrime)) {

                    $array['id_mat'][$j] = $row['id_mat'];
                    $array['cod_mat'][$j] = $row['cod_mat'];
                    $array['descri_materia'][$j] = $row['descri_materia'];
                    
                   
                    $j++;
                }
                
                //###### MATERIE PRIME DRYMIX USATE IN TUTTE LE PROVE ##############
                $array['id_mat_dm'] = array();
                $array['cod_mat_dm'] = array();
                $array['descri_materia_dm'] = array();
                $qtaTotDm = 0;
                $s=1;
                $sqlMatDryM=findAllMatPriDrymixByArrayEsperimenti($stringaProve,$prefissoCodComp);
                 while ($row = mysql_fetch_array($sqlMatDryM)) {

                    $array['id_mat_dm'][$s] = $row['id_mat'];
                    $array['cod_mat_dm'][$s] = $row['cod_mat'];
                    $array['descri_materia_dm'][$s] = $row['descri_materia'];
                    
                    $s++;
                }
                
                //###### PARAMETRI USATI IN TUTTE LE PROVE #########################    
                $array['id_par'] = array();
                $array['nome_parametro'] = array();
                $t = 1;
                $sqlPar = findAllParByArrayEsperimenti($stringaProve);
                while ($row = mysql_fetch_array($sqlPar)) {

                    $array['id_par'][$t] = $row['id_par'];
                    $array['nome_parametro'][$t] = $row['nome_parametro'];
                    $t++;
                }

                //###### CARATTERISTICHE  DEFINITE IN TUTTE LE PROVE ###############
                $array['id_car'] = array();
                $array['caratteristica'] = array();
                $array['num_righe_car'] = array();
                $c = 1;
                $sqlCar = findAllCarByArrayEsperimenti($stringaProve);
                while ($row = mysql_fetch_array($sqlCar)) {
                    //Escludo le note che mettero come ultimo elemento dell'array
                    if ($row['id_carat'] != 10) {
                        $array['id_car'][$c] = $row['id_carat'];
                        $array['caratteristica'][$c] = $row['caratteristica'];

                        //Conto il numero di risultati per stabilire la larghezza della riga
                        //di ogni caratteristica
                        $array['num_righe_car'][$c] = 1;
                        $sqlNumRighe = findMaxNumRigheRisIdCar($stringaProve, $row['id_carat']);
                        while ($row = mysql_fetch_array($sqlNumRighe)) {
                            $array['num_righe_car'][$c] = $row['max_ris'];
                        }

                        $c++;
                    }
                }

                //Come ultimo elemento dell'array caratteristiche inserisco le note da mostrare in coda ai risultati per ottimizzare la visualizzazione
                if (mysql_num_rows($sqlCar) > 0)
                    mysql_data_seek($sqlCar, 0);
                while ($row = mysql_fetch_array($sqlCar)) {
                    //escludo le note che mettero come ultimo elemento dell'array
                    if ($row['id_carat'] == 10) {
                        $array['id_car'][$c] = $row['id_carat'];
                        $array['caratteristica'][$c] = $row['caratteristica'];
                       
                        //Conto il numero di risultati per stabilire la larghezza della riga
                        //di ogni caratteristica
                        $array['num_righe_car'][$c] = 1;
                        $sqlNumRighe = findMaxNumRigheRisIdCar($stringaProve, $row['id_carat']);
                        while ($row = mysql_fetch_array($sqlNumRighe)) {
                            $array['num_righe_car'][$c] = $row['max_ris'];
                        }
                         $c++;
                    }
                }
                $widthTable = 300 + 100 * count($array['id_prove']);
                ?>
                <div id="container" style="margin:15px; width:<?php echo $widthTable ?>px;text-align:left" >
                    <div style="width:100%">
                        <table >    
                            <tr>
                                <th width="100%"><?php echo $titoloPagRiepilogoProve ?></th>
                                
                            </tr>
                            <tr>
                                <td>
                           <a href="gestione_lab_esperimenti.php"><?php echo $msgTornaAllaProve ?> </a>
                           </td>
                            </tr>
                            <tr>                            
                                <td valign="top" align="left" >
                                    <div>
                                        <table width="100%" margin="15px">
                                            <!--########################### LABEL FORMULE ##################-->
                                            <tr  style="width:100%;text-align:left;">
                                                <td class="cella1" width="100%"><?php echo $filtroLabFormule ?></td>
                                            </tr>
                                            <!--########################### LABEL PROVE ##################-->
                                            <tr>                       
                                                <td class="cella1" height="60px" width="100%"><?php echo $filtroLabProve ?></td>                                        
                                            </tr>
                                            <!--########################### LABEL MATERIE PRIME COMPOUND ##################-->
                                            <tr>
                                                <td class="cellaMergeHFix"><?php echo $filtroLabMatPrimeCompound ?></td>
                                            </tr>
    <?php
    //Scorro l'elenco delle materie prime relative a tutte le formule 
    for ($j = 1; $j <= count($array['descri_materia']); $j++) {
        ?>
                                                <tr>
                                                    <td class="cellaMergeHFixMt"><nobr><?php echo $array['descri_materia'][$j] ?></nobr></td>
                                                </tr>
        <?php
    } //End materie prime  compound  ?>
                                            <!--########################### LABEL E MATERIE PRIME DRYMIX##################-->
                                            <tr>
                                                <td class="cellaMergeHFix"><?php echo $filtroLabMaterieDrymix ?></td>
                                            </tr>
    <?php
    //Scorro l'elenco delle materie prime drymix relative a tutte le formule 
    for ($s = 1; $s <= count($array['descri_materia_dm']); $s++) {
        ?>
                                                <tr>
                                                    <td class="cellaMergeHFixMt"><nobr><?php echo $array['descri_materia_dm'][$s] ?></nobr></td>
                                                </tr>
        <?php
    } //End materie prime    drymix
    if (count($array['nome_parametro']) > 0) {
        ?>
<!-- riga totali -->
 <tr>
                                                 
                                                </tr>
                                                <!--########################### LABEL E NOMI PARAMETRI ##################-->   
                                                <tr>
                                                    <td class="cellaMergeHFix" ><?php echo $filtroLabParametri ?></td>
                                                </tr> 
        <?php
    }
    //Scorro l'elenco delle materie prime relative a tutte le formule 
    for ($j = 1; $j <= count($array['nome_parametro']); $j++) {
        ?>
                                                <tr>
                                                    <td class="cellaMergeHFixMt" width="100%"><nobr><?php echo $array['nome_parametro'][$j] ?></nobr></td>
                                                </tr>
    <?php } //End parametri     
    ?>
                                            <tr style="width:100%;"><td ></td></tr>

                                            <!-- RIPETO RIGA CON NOME FORMULE E PROVE -->
                                            <tr  style="width:100%;text-align:left;">
                                                <td class="cella1" width="100%"><?php echo $filtroLabFormule ?></td>
                                            </tr>
                                            <!--########################### ELENCO FORMULE ##################-->
                                            <tr>                       
                                                <td class="cella1" height="60px" width="100%"><?php echo $filtroLabProve ?></td>                                        
                                            </tr>
                                            <!--########################### ELENCO CARATTERISTICHE ##################-->   
                                            <tr>
                                                <td class="cellaMergeHFix" ><?php echo $filtroLabCaratteristiche ?></td>
                                            </tr> 
    <?php
    //Scorro l'elenco delle caratteristiche prime relative a tutte le formule 
    for ($j = 1; $j <= count($array['caratteristica']); $j++) {
        $idCar = $array['id_car'][$j];

        $heightRow = 30 * ( $array['num_righe_car'][$j] );
        ?>
                                                <tr>
                                                    <td class="cellaMergeHFixMt" width="100%" style='height:<?php echo $heightRow ?>px'><nobr><?php echo $array['caratteristica'][$j] ?></nobr></td>
                                                </tr>
        <?php
    } //End caratteristica
    ?>
                                        </table>                            
                                    </div>
                                </td>
                                <td valign="top" align="left"> 
                                    <div >
                                        <form name="RiepilogoProve" id="RiepilogoProve" action="" method="POST">                         
                                            <table>
                                                <!--########################### ELENCO FORMULE ##################-->
                                                <tr class="cella1">
    <?php
    for ($j = 1; $j <= count($array['id_prove']); $j++) {
        ?>
                                                    <td class="cella1" width="100%"><nobr><a target="blank" href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo $array['formule'][$j] ?>"><?php echo $array['formule'][$j] ?></nobr></td>
                                                    <?php } ?></tr>
                                                <!--########################### ELENCO PROVE ##################-->
                                                <tr>                       
                                                    <?php
                                                    for ($j = 1; $j <= count($array['prove']); $j++) {
                                                        ?>
                                                        <td  class="cella1"  width="<?php echo $widCol ?>px"><nobr><a target="blank" href="modifica_lab_risultati.php?IdEsperimento=<?php echo $array['id_prove'][$j] ?>"><?php echo $array['prove'][$j] ?></a>
                                                        <?php if (isSet($_POST["elimina" . $array['prove'][$j]])) { ?>
                                                                    <input type="checkbox"  checked name="elimina<?php echo $array['prove'][$j] ?>" value="Y" title="<?php echo $titleEscludiRiepilogo ?>" onClick="document.forms['RiepilogoProve'].submit();" />
                                                                <?php } else { ?>
                                                                    <input type="checkbox"  name="elimina<?php echo $array['prove'][$j] ?>" value="Y" title="<?php echo $titleEscludiRiepilogo ?>" onClick="document.forms['RiepilogoProve'].submit();" />
                                                                    <?php echo($row['cod_barre']) ?>
                                                                <?php } ?>
                                                            </nobr></td>
                                                            <?php } ?>
                                                </tr>
                                                <!--########################### MATERIE PRIME COMPOUND ##################-->
                                                <!-- RIGA DI SEPARAZIONE codice prove e materie prime -->
                                                <tr>
                                                    <td class="cellaMergeHFix"  colspan="<?php echo count($array['id_prove']) ?>"></td>
                                                </tr>   
    <?php
//Scorro l'elenco delle materie prime relative a tutte le prove 
    for ($j = 1; $j <= count($array['id_mat']); $j++) {
        ?>
                                                    <tr>
                                                    <?php
//Scorro l'elenco delle prove
                                                    for ($p = 1; $p <= count($array['id_prove']); $p++) {
                                                        ?>                                   
                                                            <td class="cella4Right" width="<?php echo $widCol ?>px">
                                                                <table  width="100%">
                                                            <?php
                                                            $qtaPer100Kg = 0;
                                                            $sqlQta = findQtaByProvaIdMat($array['id_prove'][$p], $array['id_mat'][$j]);
                                                            while ($rowQta = mysql_fetch_array($sqlQta)) {
                                                                if ($array['qta_tot'][$p] > 0)
                                                                    $qtaPer100Kg = (100000 * $rowQta['qta_reale']) / $array['qta_tot'][$p];
//                                                                $qtaTotMat=$qtaTotMat+$qtaPer100Kg;
                                                                ?>
                                                                        <tr>
                                                                            <td  width="100%" title="<?php echo $array['descri_materia'][$j] ?>"><?php echo number_format($qtaPer100Kg, $Prec100Kg, '.', '') . " " . $filtroLabGrammo ?></td> 
                                                                        </tr>
            <?php }//End qta             ?>
                                                                </table>

                                                            </td>
        <?php } //End prove           ?>
                                                    </tr>
                                                 
                                                    <?php } //End materie prime compound   ?>
                                                  
                                                <!--########################### MATERIE PRIME COMPOUND ##################-->
                                               
                                                <tr>
                                                    <td class="cellaMergeHFix"  colspan="<?php echo count($array['id_prove']) ?>"></td>
                                                </tr>   
    <?php
//Scorro l'elenco delle materie prime relative a tutte le prove 
    for ($s = 1; $s <= count($array['id_mat_dm']); $s++) {
        ?>
                                                    <tr>
                                                    <?php
//Scorro l'elenco delle prove
                                                    for ($p = 1; $p <= count($array['id_prove']); $p++) {
                                                        ?>                                   
                                                            <td class="cella4Right" width="<?php echo $widCol ?>px">
                                                                <table  width="100%">
                                                            <?php
                                                            $qtaPer100Kg = 0;
                                                            $sqlQta = findQtaByProvaIdMat($array['id_prove'][$p], $array['id_mat_dm'][$s]);
                                                            while ($rowQta = mysql_fetch_array($sqlQta)) {
                                                                if ($array['qta_tot'][$p] > 0)
                                                                    $qtaPer100Kg = (100000 * $rowQta['qta_reale']) / $array['qta_tot'][$p];
//                                                                $qtaTotDm=$qtaTotDm+$qtaPer100Kg;
                                                                ?>
                                                                        <tr>
                                                                            <td  width="100%" title="<?php echo $array['descri_materia_dm'][$s] ?>"><?php echo number_format($qtaPer100Kg, $Prec100Kg, '.', '') . " " . $filtroLabGrammo ?></td> 
                                                                        </tr>
            <?php }//End qta             ?>
                                                                </table>

                                                            </td>
        <?php } //End prove           ?> 
                                                        
                                                    
                                                    </tr>
                                                
                                                    <?php } //End materie prime  drymix          ?>
                                                      
                                                    
                                                <!--########################### PARAMETRI ########################-->
    <?php if (count($array['id_par']) > 0) { ?>
                                                    <!-- RIGA DI SEPARAZIONE  prove e parametri -->
                                                    <tr>
                                                        <td class="cellaMergeHFix"  colspan="<?php echo count($array['id_prove']) ?>"></td>
                                                    </tr>  
        <?php
    }
//Scorro l'elenco dei parametri relative a tutte le prove 
    for ($j = 1; $j <= count($array['id_par']); $j++) {
        ?>
                                                    <tr>
                                                    <?php
                                                    //Scorro l'elenco delle prove
                                                    for ($p = 1; $p <= count($array['id_prove']); $p++) {
                                                        ?>                                   
                                                            <td class="cella4Right" width="<?php echo $widCol ?>px">
                                                                <table  width="100%">
                                                            <?php
                                                            $valPer100Kg = 0;
                                                            $sqlVal = findQtaByProvaIdPar($array['id_prove'][$p], $array['id_par'][$j]);
                                                            while ($rowVal = mysql_fetch_array($sqlVal)) {
                                                                ?>
                                                                        <tr>
                                                                            <td  width="100%" title="<?php echo $array['prove'][$j] . ": " . $array['nome_parametro'][$j] ?>"><?php echo number_format($rowVal['valore_reale'], $Prec100Kg, '.', '') . " " . $filtroLabGrammo ?></td> 
                                                                        </tr>
            <?php }//End qta              ?>
                                                                </table>

                                                            </td>
        <?php } //End prove           ?>
                                                    </tr>

                                                    <?php } //End parametri   
                                                    ?>
                                                <tr style="width:100%;"><td ></td></tr>
                                                <!-- RIPETO RIGA FORMULE E PROVE--> 

                                                <!--########################### ELENCO FORMULE ##################-->

                                                <tr > 
    <?php
    for ($j = 1; $j <= count($array['id_prove']); $j++) {
        ?>
                                                        <td class="cella1" width="100%"><nobr><?php echo $array['formule'][$j] ?></nobr></td>
                                                    <?php } ?></tr>
                                                <!--########################### ELENCO PROVE ##################-->
                                                <tr>                       
                                                    <?php
                                                    for ($j = 1; $j <= count($array['prove']); $j++) {
                                                        ?>
                                                        <td  class="cella1"  width="<?php echo $widCol ?>px"><a target="blank" href="modifica_lab_risultati.php?IdEsperimento=<?php echo $array['id_prove'][$j] ?>"><?php echo $array['prove'][$j] ?></a>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                                <!-- RIGA DI SEPARAZIONE  parametri e caratteristiche -->
                                                <tr>
                                                    <td class="cellaMergeHFix"  colspan="<?php echo count($array['id_prove']) ?>"></td>
                                                </tr>   

                                                <!--########################### CARATTERISTICHE ########################-->
    <?php
//Scorro l'elenco delle caratteristiche relative a tutte le prove 
    for ($j = 1; $j <= count($array['id_car']); $j++) {

        $heightRow = 30 * ($array['num_righe_car'][$j]);
        ?>
                                                    <tr>
                                                    <?php
                                                    //Scorro l'elenco delle prove
                                                    for ($p = 1; $p <= count($array['id_prove']); $p++) {
                                                        ?>                                   
                                                            <td class="cella4Right" style='height:<?php echo $heightRow ?>px'>
                                                                <table width="100%">
                                                            <?php
                                                            $sqlRis = findQtaByProvaIdCar($array['id_prove'][$p], $array['id_car'][$j]);
                                                            while ($rowRis = mysql_fetch_array($sqlRis)) {
                                                                ?><tr>
                                                                            <td ><?php echo $rowRis['valore_caratteristica'] ?><nobr class="uniMisStyle"> <?php echo $rowRis['uni_mis_car'] ?></nobr></td>
                                                                        <?php if ($rowRis['dimensione'] != '') { ?>                                
                                                                                <td ><?php echo $rowRis['valore_dimensione']; ?><nobr class="uniMisStyle"> <?php echo $rowRis['uni_mis_dim'] ?></nobr></td>
                                                                            <?php } else { ?>
                                                                                <td colspan="2"></td>
                                                                                    <?php } ?>

                                                                        <?php }//End qta        ?>
                                                                </table>
                                                            </td>
                                                                    <?php } //End prove       ?>
                                                    </tr>
                                                        <?php
                                                    } //End caratteristiche  
                                                } else {
                                                    echo $msgSelectProveRiepilogo . '</br>';
                                                    echo '</br><a href="gestione_lab_esperimenti.php">' . $msgTornaAllaProve . '</a>';
                                                }
//end if selezione prove
                                                ?>
                                        </table>
                                    </form>                            
                                </div> 
                            </td>    
                        </tr>
                                              
                    </table>
                        
                </div>
                    
            </div>
        </div>
    </body>
</html>