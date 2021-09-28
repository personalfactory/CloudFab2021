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
                ini_set("display_errors", "1");
            include_once('../include/funzioni.php');
            include_once('../include/precisione.php');
            include_once('../include/gestione_date.php');
            include_once('../Connessioni/serverdb.php');
            include_once ('../sql/script.php');
            include_once ('../sql/script_macchina.php');
            include_once ('../sql/script_parametro_prod_mac.php');
            include_once ('../sql/script_valore_par_prod_mac.php');

            $InsertValoreParProdMac = true;
            $erroreInsertValoreParProdMac = false;
//##############################################################################
//################# SELEZIONO TUTTE LE MACCHINE ################################
//##############################################################################
            begin();
            $selectMacchine = findMacchinaByAbilitato($valAbilitato);
            while ($rowMac = mysql_fetch_array($selectMacchine)) {

                $IdMacchina = $rowMac['id_macchina'];
                $DescriStab = $rowMac['descri_stab'];

                //##########################################################################
                //################### PRODOTTI ASSEGNATI A MACCHINA ########################
                //##########################################################################
                $arrayProdPerMac = array();
                $arrayProdPerMac = trovaProdottiAssegnatiAMacchina($IdMacchina);
                if (count($arrayProdPerMac) > 0) {
                    echo "<br /><br /> PRODOTTI ASSEGANTI ALLA MACCHINA : " . $IdMacchina . " - " . $DescriStab . "  <br />";
                }
                for ($i = 0; $i < count($arrayProdPerMac); $i++) {
                    echo $arrayProdPerMac[$i] . " - ";
//                    $sqlProd=findProdottoById($idProdotto);
//                    while ($row = mysql_fetch_array($sqlProd)) {
//                        $codProd
//                    }
                    
                }

                //##########################################################################
                //################### PARAMETRI PRODOTTO MACCHINA ##########################
                //##########################################################################
                $NParPr = 1;
                $SelectParametroPr = findAllParametriProdMac("id_par_pm");
                mysql_data_seek($SelectParametroPr, 0);
                while ($rowParametroPr = mysql_fetch_array($SelectParametroPr)) {

                    $IdParPrM = $rowParametroPr['id_par_pm'];
                    $ValoreProd = $rowParametroPr['valore_base'];
                    
                    //########## CICLO PRODOTTI ASSEGNATI ##################                   
                    for ($z = 0; $z < count($arrayProdPerMac); $z++) {

                        $InsertValoreParProdMac = insertIfNotExistValParProdMac($arrayProdPerMac[$z], $IdParPrM, $ValoreProd, $IdMacchina, dataCorrenteInserimento());

                        if (!$InsertValoreParProdMac) {
                            $erroreInsertValoreParProdMac = true;
                        }
                    }
                    $NParPr++;
                }//End while fine parametri prodotto macchina 
            }
            if ($erroreInsertValoreParProdMac) {
                echo "</br></br><span style='color:#A00028'>ERRORE DURANTE LA GENERAZIONE DEI VALORI DEI PARAMETRI DEI PRODOTTI</span>";
                rollback();
            } else {
                echo "</br></br><span style='color:#008000'>I VALORI DEI PARAMETRI PRODOTTO SONO STATI AGGIORNATI CORRETTAMENTE!</span>";
                commit();
            }
            ?>
        </div>
    </body>
</html>