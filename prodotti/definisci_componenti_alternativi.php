<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <div id="mainContainer">
        <body>
            <?php
//TO DO : Valutare se inserire il controllo sul permesso dell'utente
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_componente.php');
            include('../sql/script_componente_pesatura.php');
            include('../sql/script_parametro_glob_mac.php');

            $IdCompOld = $_GET['IdComponente'];
            $IdProdotto = $_GET['IdProdotto'];
            $nomeProdotto = $_GET['NomeProd'];

            $stringaCompAlternativi = "";
            $arrayComponentiAlternativi = array();

            $sqlDescriComp = findComponenteById($IdCompOld);
            while ($rowDescriComp = mysql_fetch_array($sqlDescriComp)) {

                $DescriCompOld = $rowDescriComp['descri_componente'];
            }

            $sqlParSeparatore = findParGlobMacById("156");
            while ($row = mysql_fetch_array($sqlParSeparatore)) {

                $parSeparatore = $row['valore_variabile'];
            }

            $sqInfoCompProd = findCompPesaturaByIdProdIdComp($IdCompOld, $IdProdotto);
            while ($rowCompProd = mysql_fetch_array($sqInfoCompProd)) {

                $stringaCompAlternativi = $rowCompProd['info1'];
            }
            

//############ STRINGA UTENTI E AZIENDE VISIBILI #############################
            $strUtentiAziendeVisComp = getStrUtAzVisib($_SESSION['objPermessiVis'], 'componente');
            ?>
            <div id="container" style="width:700px; margin:100px auto;">

                <form class="form" id="DefinisciCompAlternativo" name="DefinisciCompAlternativo" method="post" action="definisci_componenti_alternativi2.php">
                    <table width="100%">
                        <input type="hidden" name="IdProdotto" id="IdProdotto" value="<?php echo $IdProdotto; ?>"></input>
                        <input type="hidden" name="IdCompOld" id="IdCompOld" value="<?php echo $IdCompOld; ?>"></input>
                        <input type="hidden" name="StringaComp" id="StringaComp" value="<?php echo $stringaCompAlternativi; ?>"></input>
                        <tr>
                            <td class="cella3" colspan="2" style="height:60px"><?php echo $titoloPaginaDefinisciCompAlternativo . " <br/><br/>" . $DescriCompOld ?></td>
                        </tr>
                        <!--############### VISUALIZZAZIONE COMPONENTI ALTERNATIVI ####################################-->
                        <?php
                        $arrayComponentiAlternativi = explode($parSeparatore, $stringaCompAlternativi);
                        for ($i = 0; $i < count($arrayComponentiAlternativi); $i++) {

                            $sqlNomeComp = findComponenteById($arrayComponentiAlternativi[$i]);
                            while ($rowDescriComp = mysql_fetch_array($sqlNomeComp)) {
                                ?>
                                <tr>
                                    <td class="cella1" style="height:40px" ><?php echo $rowDescriComp['cod_componente'] . " - " . $rowDescriComp['descri_componente'] ?></td> 
                                    <td class="cella1" style="height:40px; width:20px" ><a style="text-align:right" name="EliminaCompAlternativo" href="elimina_comp_alternativo.php?IdProdotto=<?php echo $IdProdotto ?>&IdComponente=<?php echo $arrayComponentiAlternativi[$i] ?>&StringaComp=<?php echo $stringaCompAlternativi ?>&IdCompOld=<?php echo $IdCompOld ?>">
                                        <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone" /></a></td>
                                </tr>
                                <?php
                            }
                        }

                        //Verifico quanti componenti nella formula hanno già almeno un componente alternativo
                        //Il numero massimo di componenti alternativi che un prodotto può avere è 4.
                        $strCompAlternativiTotali = 0;
                        $sql = selectComponentiAlternativiTotByIdProdotto($IdProdotto);
                        if (mysql_num_rows($sql) < 4 OR $stringaCompAlternativi!=''){
                            
                            ?>                                
                            <tr colspan="2">
                                <td class="cella1" style="height:40px;" colspan="2" >
                                    <select name="NuovoComponente" id="NuovoComponente" style="width: 90%;">
                                        <option value="" selected=""><?php echo $labelOptionAddMatAlternativa ?></option>
                                        <?php
                                        //Visualizzo solo i componenti che attualmente non sono associati alla formula
                                        $sqlComp = findCompNotInProdotto($IdProdotto, $prefissoCodComp, $strUtentiAziendeVisComp);
                                        while ($rowComp = mysql_fetch_array($sqlComp)) {
                                            ?>
                                            <option value="<?php echo($rowComp['id_comp']) ?>"><?php echo($rowComp['cod_componente'] . " - " . $rowComp['descri_componente']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>                        
                        <?php } else { ?>
                            
                            <tr colspan="2">
                                <td class="cella1" style="height:40px" colspan="2">
                                    <?php echo $filtroLimiteMateriePrimeAlternative ?>
                                </td>
                            </tr>        
                                                      
                            
                  <?php      }
                                               
                        ?>
                        <tr >
                            <td class="cella2" style="height:40px" colspan="2"><?php echo $filtroInfoBreve . " <br/><br/>" . $filtroMateriePrimeAlternative . " <br/><br/>" . $nomeProdotto . "<br/><br/>" . $filtroAlPostoDi . " <br/><br/>" . $DescriCompOld . " <br/><br/>"  ?></td>
                            
                        </tr>
                        <?php include('../include/tr_reset_submit.php'); ?>
                    </table>
                </form>
            </div>
            <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella componente - Utenti e aziende visibili : " . $strUtentiAziendeVisComp;
                }
                ?>
            </div>
            </body>

    </div>
</html>
