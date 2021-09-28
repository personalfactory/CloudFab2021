<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        
        <?php include('../include/header.php'); 
        
            if($DEBUG) ini_set("display_errors", "1");
        ?>
    </head>
    
            <script language="javascript">
        function VerificaMiscela() {
            document.forms["AssociaCodLottoCodChimica"].action = "tracciabilita_sfusa.php";
            document.forms["AssociaCodLottoCodChimica"].submit();
        }
            </script>

            <?php
//            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_miscela.php');
            include('../sql/script_miscela_contenitore.php');
            include('../sql/script_produzione_miscela.php');
            include('../sql/script_accessorio_formula.php');
            include('../sql/script_formula.php');
//            ###########################################################################    
//            ####################### SCELTA CONTENITORE ################################
//            ###########################################################################

            $errore = false;
            $messaggio = "";
            $IdMiscela = 0;
            $DataMiscela = "0";
            $CodFormula = "0";
            $DescriFormula = "0";
            $CodFormulaDescri = "0";
            $PesoRealeMiscela = 0;


            if (!isset($_POST['Contenitore']) || $_POST['Contenitore'] == "") {
                //Inizializzo le due variabili di sessione relative al numero di lotti corrente ed al num di codchimica corrente


                $_SESSION['NumLottiTot'] = 0;
                $_SESSION['NumLottiSalvati'] = 0;

                $_SESSION['CodiceChimica'] = "";
                $_SESSION['CodiciLotto'] = array();

                $_SESSION['NumSacchetti'] = 0;
                $_SESSION['Contenitore'] = "0";
                $_SESSION['IdMiscela'] = 0;
                $_SESSION['DataMiscela'] = "0";
                $_SESSION['CodFormula'] = "0";
                $_SESSION['DescriFormula'] = "0";
                $_SESSION['CodFormulaDescri'] = "0";
                $_SESSION['PesoRealeMiscela'] = 0;
                $_SESSION['PesoLotto'] = 0;
                ?>        
    <body onload="document.getElementById('CodLotto').focus()">
        <div id="tracciabilitaContainer">
            <?php  include('../include/menu.php'); ?>
                <div id="tracciabilitaContainer" style=" width:70%; margin:15px auto;">

                    <form class="form" id="AssociaCodLottoCodChimica" name="AssociaCodLottoCodChimica" method="post" >
                        <table width="700px">
                            <tr>
                                <td class="cella33" colspan="2"><?php echo $titoloPaginaAssLottoChimSfusa ?></td>
                            </tr>
                            <tr>
                                <td class="cella22"><?php echo $filtroContenitore ?></td>
                                <td class="cella111">
                                    <select class="inputTracc" name="Contenitore" id="Contenitore" onchange="VerificaMiscela()" >
                                        <option value="0" selected=""><?php echo $labelOptionSelectContenitore ?></option>
                                        <?php
                                        //Viene data la possibilità di scelta tra i contenitori impegnati
                                        $sqlContenitore = selectContenitoreByStato("0");

                                        while ($rowContenitore = mysql_fetch_array($sqlContenitore)) {
                                            ?>
                                            <option value="<?php echo($rowContenitore['cod_contenitore']) ?>" size="40"><?php echo("Contenitore " . $rowContenitore['cod_contenitore']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <?php
            } else if (isset($_POST['Contenitore']) AND $_POST['Contenitore'] != "") {

                $Contenitore = $_POST['Contenitore'];

                //############################################################################
                //############ CONTROLLO ESISTENZA MISCELA ###################################
                //############################################################################
                $sqlMiscela = selectProdMiscelaByContenitore($Contenitore);

                if (mysql_num_rows($sqlMiscela) == 0) {
                    //Se entro nell'if vuol dire che la miscela non esiste
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrNessunaMiscelaAssCont . '<br />';
                }

                //Recupero i dati della miscela 
                while ($rowMiscela = mysql_fetch_array($sqlMiscela)) {
                    $IdMiscela = $rowMiscela['id_miscela'];
                    $DataMiscela = $rowMiscela['dt_miscela'];
                    $CodFormula = $rowMiscela['cod_formula'];
                    $DescriFormula = $rowMiscela['descri_formula'];
                    $CodFormulaDescri = $CodFormula . ":" . $DescriFormula;
                    $PesoRealeMiscela = $rowMiscela['peso_reale'];
                }


           
                //##########################################################################
                //### RECUPERO IL NUM LOTTI TOT, NUM KIT TOTALE, PESO DI UN LOTTO ##########
                //##########################################################################
                $PesoLotto=0;
                //15-12-2014 prima il num di lotti e di kit viene selezionato dalla tabella formula
                //nel caso della chimica sfusa non si tiene conto del numero di kit 
                
//                $sqlPesoLotto = findAnFormulaByCodice($CodFormula);
//                
//                //09-07-2015 ora il numero di lotti e di kit viene selezionato dalla tabella miscela
                  //ovviamente dopo che la miscela è stata sincronizzata dal tablet
                   $sqlPesoLotto=  findMiscelaById($IdMiscela);
                //Controllo esistenza
                if (mysql_num_rows($sqlPesoLotto) == 0) {
                    $errore = true;
                    $messaggio = $messaggio . ' ' . $msgErrImpSelectNumKitTot . '<br />' . $msgErrImposSelectNumLotti . '<br />'. $msgErrSelectPesoLotto . ' <br />';
                }
                while ($rowPesoLot = mysql_fetch_array($sqlPesoLotto)) {
                    $NumSacTot = $rowPesoLot['num_sac_in_lotto'];
                    $NumLottiTot = $rowPesoLot['num_lotti'];
                    $PesoLotto = $rowPesoLot['qta_lotto'];
                }
                if ($errore) {
                    echo $messaggio;
                } else {
//Inizializzo le variabili di sessione
                    $_SESSION['NumLottiTot'] = $NumLottiTot;

                    for ($i = 0; $i < $_SESSION['NumLottiTot']; $i++) {
                        $_SESSION['CodiciLotto'][$i] = "";
                    }

                    $_SESSION['NumSacchetti'] = $NumSacTot;
                    $_SESSION['Contenitore'] = $Contenitore;
                    $_SESSION['IdMiscela'] = $IdMiscela;
                    $_SESSION['DataMiscela'] = $DataMiscela;
                    $_SESSION['CodFormula'] = $CodFormula;
                    $_SESSION['DescriFormula'] = $DescriFormula;
                    $_SESSION['CodFormulaDescri'] = $CodFormulaDescri;
                    $_SESSION['PesoRealeMiscela'] = $PesoRealeMiscela;
                    $_SESSION['PesoLotto'] = $PesoLotto;
                    ?>

                    <script type="text/javascript">
                location.href = "tracciabilita_sfusa_carica_lotto.php"
                    </script>

                    <?php
                }
            }
            ?>
        </div><!--mainConatainer-->
    </body>
</html>

