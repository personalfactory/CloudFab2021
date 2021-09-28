<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>

    <script language="javascript">
        function Aggiorna() {
            document.forms["VediProdottiAssegnati"].action = "vista_prodotti_per_impianto.php";
            document.forms["VediProdottiAssegnati"].submit();
        }
    </script>
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

            $actionOnLoad = "";
            //1) Si verifica se l'utente ha il permesso di visualizzare la lista dei prodotti
            $elencoFunzioni = array("1");
            $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni, $_SESSION['objPermessiVis']);

            $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');

            if (isset($_GET['IdMacchina']) AND isset($_GET['DescriStab'])) {

                $_SESSION['id_macchina'] = $_GET['IdMacchina'];
                $_SESSION['DescriStab'] = $_GET['DescriStab'];
            }

            if ($_SESSION['id_macchina'] != "") {

                $_SESSION['IdProdotto'] = "";
                $_SESSION['CodProdotto'] = "";
                $_SESSION['NomeProdotto'] = "";

                if (isset($_POST['IdProdotto'])) {
                    $_SESSION['IdProdotto'] = trim($_POST['IdProdotto']);
                }

                if (isset($_POST['CodProdotto'])) {
                    $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
                }

                if (isset($_POST['NomeProdotto'])) {
                    $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
                }
                ?>

                <div id="container" style="width:60%; margin:15px auto;">
                    <form  name="VediProdottiAssegnati" id="VediProdottiAssegnati" action="" method="POST">
                        <table>
                            <tr>
                                <th colspan="4"><?php echo $filtroProdAssegnatiImpianto?> <b><?php echo $_SESSION['DescriStab'] ?></b></th>
                            </tr>

                            <tr>
                                <td><input style="width:100%" placeholder="Filtra per id"     type="text" name="IdProdotto" value="<?php echo $_SESSION['IdProdotto'] ?>" /></td>
                                <td><input style="width:100%" placeholder="Filtra per codice" type="text" name="CodProdotto" value="<?php echo $_SESSION['CodProdotto'] ?>" /></td>
                                <td><input style="width:100%" placeholder="Filtra per nome"   type="text" name="NomeProdotto" value="<?php echo $_SESSION['NomeProdotto'] ?>" /></td>
                                <td><input  type="button" value="<?php echo $valueButtonCerca ?>" onClick="Aggiorna();" /></td>
                            </tr>
                        </table>
                    </form>
                    <?php
//A questa pagina si accede sia dalla gestione delle macchine 
                    //SELEZIONARE I PRODOTTI ASSEGNATI ALL'IMPIANTO IN BASE AL GRUPPO E AL RIFERIMENTO GEOGRAFICO

                    $arrayProdPerMac = trovaProdottiAssegnatiAMacchina($_SESSION['id_macchina']);

                    //$sqlProdotti = findProdottiAssegnatiAMacchina("cod_prodotto", $arrayProdPerMac, $strUtentiAziendeProd);
                    
                    
                    

                    $sqlProdotti = findProdottiColoriAdditiviAssegnatiByFiltri("cod_prodotto", "id_prodotto", $_SESSION['IdProdotto'], $_SESSION['CodProdotto'], $_SESSION['NomeProdotto'], $arrayProdPerMac, $strUtentiAziendeProd);
//##############################################################################
//################### PRODOTTO ################################################# 
//##############################################################################

                    $NProd = 0;

                    if (mysql_num_rows($sqlProdotti) > 0)
                        mysql_data_seek($sqlProdotti, 0);

                    while ($rowProdotto = mysql_fetch_array($sqlProdotti)) {


                        /** $sqlCodProd = findAllDatiProdottoById($IdProdotto);
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
                          } */
                        $IdProdotto = $rowProdotto['id_prodotto'];
                        $CodiceProdotto = $rowProdotto['cod_prodotto'];
                        $NomeProdotto = $rowProdotto['nome_prodotto'];
                        $Colorato = $rowProdotto['colorato'];
                        $Geografico = $rowProdotto['geografico'];
                        $TipoRiferimento = $rowProdotto['tipo_riferimento'];
                        $Gruppo = $rowProdotto['gruppo'];
                        $LivelloGruppo = $rowProdotto['livello_gruppo'];
                        
                        //Se il valore del campo colorato della tabella prodotto è diverso dall'id del prodotto
                        //vuol dire che si tratta di un prodotto derivato
                        $stringaProdDerivato=$filtroProdottoStandard;
                        if($Colorato!=$IdProdotto){
                            
                            $sqlProdPadre= findProdottoById($Colorato);
                            while ($row = mysql_fetch_array($sqlProdPadre)) {
                                $codProdPadre=$row['cod_prodotto'];
                                $nomeProdottoPadre=$row['nome_prodotto'];
                                $stringaProdDerivato=$filtroProdottoDerivato." ".$codProdPadre." ".$nomeProdottoPadre;
                            }
                            
                        }


                        $Data = maxDataProdotto($IdProdotto);
                        ?>


                        <table width="100%">
                            <tr>
                                <td class="cella11" colspan="2" style='font-size:18px'><?php echo $IdProdotto . " " . $CodiceProdotto . " " . $NomeProdotto; ?></td>
                                                         </tr>
                            
                            <tr>
                             <td class="cella11" colspan="2"><?php echo $stringaProdDerivato; ?></td>
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




                        <?php
                        $NProd++;
                    }
                    ?>

                </div>   

            <?php } else {
                ?>
                <div id="container" style="width:700px; margin:50px auto;">
                    <span style='font-size:25px'><?php echo $filtroNessunProdotto ?></span>
                </div>
                <?php
            }
            ?>

        </div><!--maincontainer-->

    </body>
</html>
