<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('../object/OrdineOri.php');
    include('../include/validator.php');
    ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
               <?php 
             //Costruzione dell'array contenente i vari msg di errore
            $arrayMsgErrPhp = array($msgErrDataOrdine, //0
                $msgErrControlloDtOrdine, //1
                $msgErrSelectStab //2
            );
            ?>
            
            <script language="javascript">
                
                var arrayMsgErrJs = new Array("<?= join('", "', $arrayMsgErrPhp) ?>");

                function controllaCampi(arrayMsgErrJs) {

                    var rv = true;                    
                    var msg = "";                   
                   
                        if (document.getElementById('GiornoOrdine').value === ""
                                || document.getElementById('MeseOrdine').value === ""
                                || document.getElementById('AnnoOrdine').value === ""
                                || isNaN(document.getElementById('GiornoOrdine').value)
                                || isNaN(document.getElementById('MeseOrdine').value)
                                || isNaN(document.getElementById('AnnoOrdine').value)) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[0];
                        }

                        if (!(document.getElementById('GiornoOrdine').value.length === 2)
                                || !(document.getElementById('AnnoOrdine').value.length === 4)
                                || document.getElementById('GiornoOrdine').value < 1
                                || document.getElementById('GiornoOrdine').value > 31) {
                            rv = false;
                            msg = msg + ' ' + arrayMsgErrJs[1];
                        }
                    
                    if (document.getElementById('Stabilimento').value === "") {

                        rv = false;
                        msg = msg + ' ' + arrayMsgErrJs[2];
                    }
                    if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }
                
                function AggiornaCalcoli() {
                    document.forms["InserisciOrdine"].action = "carica_programma_ori1.php";                    
                }
                
            </script>
    
            <?php
            if ($DEBUG) ini_set('display_errors', '1');
            //############# STRINGHE UTENTI - AZIENDE VISIBILI##################
            //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
            //dall'utente loggato   
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
            $strUtentiAziendeProd = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
           
            $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'ordine_elenco');

            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../include/gestione_date.php');
            include('../include/precisione.php');
            
            ////////////////////////////////////////////////////////////////////
                        
            include('../sql/script.php');
            include('../sql/script_macchina.php');
            include('../sql/script_prodotto.php');
            include('../sql/script_categoria.php');
            include('../sql/script_componente_prodotto.php');
            include('../sql/script_valore_par_sing_mac.php');
            
            $Pagina = "carica_programma_ori";

            //########### FILTRI SULLA VISUALIZZAZIONE MATERIE PRIME ###########
            $_SESSION['IdProdotto'] = "";
            $_SESSION['CodProdotto'] = "";
            $_SESSION['NomeProdotto'] = "";
            $_SESSION['Famiglia'] = "";

            if (isset($_POST['IdProdotto'])) {
                $_SESSION['IdProdotto'] = trim($_POST['IdProdotto']);
            }
            if (isset($_POST['CodProdotto'])) {
                $_SESSION['CodProdotto'] = trim($_POST['CodProdotto']);
            }
            if (isset($_POST['NomeProdotto'])) {
                $_SESSION['NomeProdotto'] = trim($_POST['NomeProdotto']);
            }
            if (isset($_POST['Famiglia'])) {
                $_SESSION['Famiglia'] = trim($_POST['Famiglia']);
            }
            $_SESSION['Filtro'] = "cod_prodotto";
            

            //################# QUERY AL DB ####################################
            begin();
                       
            $sqlMacchine=findAllMacchineVisAbilitate("descri_stab",$strUtentiAziende);
            
            $sqlProdotti=findAllProdottiByFiltri($_SESSION['Filtro'],"id_prodotto",$_SESSION['IdProdotto'],$_SESSION['CodProdotto'],$_SESSION['NomeProdotto'], $strUtentiAziendeProd);
                        
            commit();

//##############################################################################      
//##################### PRIMA ESECUZIONE SCRIPT ################################
//##############################################################################

                            
                //#### OGGETTO OrdineOri #######################################
                $_SESSION['OrdineOri'] = array();
                //Contatore delle materie prime con qta >0 
                //da aggiungere alla formula e salvare nell'oggetto
                $k = 0;
//                echo "########### k: " . $k;
                ?>
     <body>
        <div id="mainContainer">
                <div id="container" style="width:70%; margin:100px auto;">
                    <form id="InserisciOrdine" name="InserisciOrdine" method="POST" onsubmit="return controllaCampi(arrayMsgErrJs)">
                        <input type="hidden" name="k" value="<?php echo $k ?>"/>
                        <table width="100%" >
                            <tr>
                                <td height="42"  colspan="2" class="cella3"><?php echo $filtroNuovoProgProduzione ?></td>
                            </tr>
                            <!--#####################################################################-->
                            <!--####################  ORDINE ########################################-->
                            <!--#####################################################################-->
                            <input type="hidden" name="primaEsecuzione" id="primaEsecuzione" value="1"/>
                            <tr>
                                <td class="cella4" ><?php echo $filtroStabilimento ?></td>
                                <td class="cella1">
                                    <select name="Stabilimento" id="Stabilimento">
                                        <option value="" selected=""><?php echo $labelOptionSelectStab ?></option>
                                        
                                        <?php
                                        while ($row = mysql_fetch_array($sqlMacchine)) {
                                            ?>
                                            <option value="<?php echo $row['id_macchina'] . " - " . $row['descri_stab']; ?>"><?php echo  $row['descri_stab']; ?></option>
                                        <?php } ?>
                                    </select>
                            </tr>
                             <tr>
                                <td class="cella4"><?php echo $filtroDtProdPrevista ?> </td>
                                <td class="cella1" colspan="4"><?php formSceltaData("GiornoOrdine", "MeseOrdine", "AnnoOrdine", $arrayFiltroMese) ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroDtInserimentoOrdine ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroNote ?> </td>
                                <td class="cella1"><textarea name="Note" id="Note" ROWS="2" COLS="49"></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella1">
                                    <select name="Azienda" id="Azienda"> 
                                        <option value="<?php echo $_SESSION['id_azienda'] . ";" . $_SESSION['nome_azienda'] ?>" selected="selected"><?php echo $_SESSION['nome_azienda'] ?></option>
                                        <?php
                                        //Si selezionano solo le aziende che l'utente ha il permesso di editare
                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                            if ($idAz != $_SESSION['id_azienda']) {
                                                ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right; " colspan="4">
                                    <input type="reset"  onClick="javascript:history.back();" value="<?php echo $valueButtonAnnulla ?>"/>
                                    <input type="submit" onClick="AggiornaCalcoli();"  value="<?php echo $valueButtonConferma ?>" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

   
            <div id="msgLog">
            <?php
            if ($DEBUG) {

                echo "</br>Tab prodotto : Utenti e aziende visibili " . $strUtentiAziende;
                echo "</br>Tabella prodotto: AZIENDE SCRIVIBILI: ";
                for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                    echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                }
            }
            ?>
            </div>
        </div><!--mainContainer-->
    </body>
</html>
