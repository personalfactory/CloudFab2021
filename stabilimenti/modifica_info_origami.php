<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <script language="javascript" type="text/javascript">
                //Funzioni per la visualizzazione del form relativo al tipo di mt
                //Funzioni per la visualizzazione del form relativo al sottotipo
                function visualizzaListBoxTipoEsistente() {
                    document.getElementById("TipoEs").style.visibility = "visible";
                    document.getElementById("TipoNu").style.visibility = "hidden";

                }
                function visualizzaFormNuovoTipo() {
                    document.getElementById("TipoEs").style.visibility = "hidden";
                    document.getElementById("TipoNu").style.visibility = "visible";

                }
                //Funzioni per la visualizzazione del form relativo al sottotipo
                function visualizzaListBoxSottoTipoEsistente() {
                    document.getElementById("SottoTipoEs").style.visibility = "visible";
                    document.getElementById("SottoTipoNu").style.visibility = "hidden";

                }
                function visualizzaFormNuovoSottoTipo() {
                    document.getElementById("SottoTipoEs").style.visibility = "hidden";
                    document.getElementById("SottoTipoNu").style.visibility = "visible";

                }
                //Funzioni per la visualizzazione del form relativo alla posizione
                function visualizzaFormPosizioneAperta() {
                    document.getElementById("PosAperta").style.visibility = "visible";
                    document.getElementById("PosChiusa").style.visibility = "hidden";
                    document.getElementById("OpChiusa").style.visibility = "hidden";
                    

                }
                function visualizzaFormPosizioneChiusa() {
                    document.getElementById("PosAperta").style.visibility = "visible";
                    document.getElementById("PosChiusa").style.visibility = "visible";
                    document.getElementById("OpChiusa").style.visibility = "visible";

                }
            </script>
            <?php
            

            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_info_origami.php');
            include('../sql/script_macchina.php'); 
             
            if($DEBUG) ini_set("display_errors", "1");
            //############# STRINGA UTENTI-AZIENDE VISIBILI ############################
    //Stringa contenente l'elenco degli id degli utenti e delle aziende prop visibili 
    //dall'utente loggato   
    $strUtentiAziendeMac = getStrUtAzVisib($_SESSION['objPermessiVis'], 'macchina');
            
            $Id = $_GET['Id'];           
            
            //########### QUERY AL DB ############################
            

            begin();
            $sql=findInfoById($Id);
            $sqlTipo = selectAllInfoGroupBy("tipo_info",$strUtentiAziendeMac);
            $sqlSottoTipo = selectAllInfoGroupBy("sotto_tipo",$strUtentiAziendeMac);
            $sqlStab = findAllMacchineVisAbilitate("id_macchina",$strUtentiAziendeMac);
//            $sqlUtente = findAllUtenti("cognome");
            commit();
            
            $IdMaccchina=0;
            while ($row = mysql_fetch_array($sql)) {
                $IdMaccchina=$row['id_macchina'];
                $Tipo=$row['tipo_info'];
                $SottoTipo=$row['sotto_tipo'];
                $Info = $row['info'];
                $Note = $row['note'];
                $Stato = $row['stato'];
                $DtAbilitato = $row['dt_abilitato'];
                $Utente = $row['utente'];
                $PosizioneOld= $row['posizione'];
                $DtApertura=$row['dt_apertura'];
                $DtChiusura=$row['dt_chiusura'];
                $Priorita=$row['priorita'];
                $OperChiusura=$row['operatore_chiusura'];
                
            }
                        
            $sqlMac=findMacchinaById($IdMaccchina);
            while ($rowMac = mysql_fetch_array($sqlMac)) {
                $DescriStab=$rowMac['descri_stab'];
            }
            
            ?>
            <div id="container" style="width:80%; margin:15px auto;">
                <form id="ModificaInfo" name="ModificaInfo" method="post" action="modifica_info_origami2.php">
                    <table width="100%">
                        <input type="hidden" name="Id" id="Id" value="<?php echo $Id; ?>"></input>
                        <input type="hidden" name="PosizioneOld" id="PosizioneOld" value="<?php echo $PosizioneOld ?>"/>
                        <input type="hidden" name="DtChiusuraOld" id="DtChiusuraOld" value="<?php echo $DtChiusura ?>"/>
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaModInfoOrigami ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroStabilimento ?></td>
                            <td  class="cella1">
                                <select id="Stabilimento" name="Stabilimento">
                                    <option value="<?php echo $IdMaccchina?>" selected="<?php echo $IdMaccchina?>"><?php echo $DescriStab ?> </option>
                                    <?php while ($rowStab = mysql_fetch_array($sqlStab)) { ?>
                                        <option value="<?php echo($rowStab['id_macchina']) ?>"><?php echo($rowStab['descri_stab']) ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>                
                        
                        <tr>
                            <td class="cella4"><?php echo $filtroTipoInfo ?></td>
                            <td>
                                <table  width="100%">
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaListBoxTipoEsistente();" value="TipoEs" checked="checked"/><?php echo $filtroEsistente ?></td>
                                        <td class="cella1">
                                            <div id="TipoEsistente" >
                                                <select id="TipoEs" name="TipoEs">
                                                    <option value="<?php echo $Tipo ?>" selected="<?php echo $Tipo ?>"><?php echo $Tipo ?> </option>
                                                    <?php while ($rowTipo = mysql_fetch_array($sqlTipo)) { ?>
                                                        <option value="<?php echo($rowTipo['tipo_info']) ?>"><?php echo($rowTipo['tipo_info']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" title="<?php echo $titleDigitaTipo ?>">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormNuovoTipo();" value="TipoNu" /><?php echo $filtroNuovo ?></td>
                                        <td class="cella1">
                                            <div id="TipoNuovo" style="visibility:hidden;">
                                                <input type="text" name="TipoNu" id="TipoNu" size="50" title="<?php echo $titleDigitaTipo ?>"/>

                                            </div></td>
                                    </tr> 
                                </table>
                            </td>
                        </tr> 

                        <tr>
                            <td class="cella4"><?php echo $filtroLabSottoTipo ?></td>
                            <td>
                                <table  width="100%">
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaListBoxSottoTipoEsistente();" value="SottoTipoEs" checked="checked"/><?php echo $filtroEsistente ?></td>
                                        <td class="cella1">
                                            <div id="SottoTipoEsistente" >
                                                <select id="SottoTipoEs" name="SottoTipoEs">
                                                    <option value="<?php echo $SottoTipo ?>" selected="<?php echo $SottoTipo ?>"><?php echo $SottoTipo ?> </option>
                                                    <?php while ($rowSTipo = mysql_fetch_array($sqlSottoTipo)) { ?>
                                                        <option value="<?php echo($rowSTipo['sotto_tipo']) ?>"><?php echo($rowSTipo['sotto_tipo']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" title="<?php echo $titleLabDigitaSottoTipo ?>">
                                            <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaFormNuovoSottoTipo();" value="SottoTipoNu" /><?php echo $filtroNuovo ?></td>
                                        <td class="cella1">
                                            <div id="SottoTipoNuovo" style="visibility:hidden;">
                                                <input type="text" name="SottoTipoNu" id="SottoTipoNu" size="50" title="<?php echo $titleLabDigitaSottoTipo ?>"/>

                                            </div></td>
                                    </tr> 
                                </table>
                            </td>
                        </tr> 
                       
                        
                        <!--################################################################
                        ################# POSIZIONE APERTA #################################
                        #################################################################-->
                         <tr>
                             <input type="hidden" name="PosizioneOld" id="PosizioneOld" value="<?php echo $PosizioneOld ?>"/>
                            <td class="cella2"><?php echo $filtroPosizione ?></td>
                            <?php if($PosizioneOld==$valPosAperta){ ?>
                           <td>
                                <table  width="100%">
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegliPos" name="scegliPos" onclick="javascript:visualizzaFormPosizioneAperta();" value="PosizioneAp" checked="checked"/><?php echo $filtroAperta ?></td>
                                        <td class="cella1" colspan="2">
                                            <div id="PosAperta" >
                                               <input type="hidden" name="PosAperta" id="PosAperta" /><?php echo dataEstraiVisualizza($DtApertura) ?>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegliPos" name="scegliPos" onclick="javascript:visualizzaFormPosizioneChiusa();" value="PosizioneCh" /><?php echo $filtroChiusa ?></td>
                                        <td class="cella1">
                                            <div id="PosChiusa" style="visibility:hidden;"><?php echo dataCorrenteVisualizza() ?></div></td>
                                        
                                        <td class="cella1">
                                            <div id="OpChiusa" style="visibility:hidden;"> 
                                                <?php echo $filtroOperatore ?>
                                                <input type="text" name="OperChiusura" id="OperChiusura" value=""/>
<!--                                                <select id="OperChiusura" name="OperChiusura">
                                                    <option value="" selected=""><?php echo $labelOptionSelectOper ?> </option>
                                                   <?php while ($rowUt = mysql_fetch_array($sqlUtente)) { ?>
                                                        <option value="<?php echo ($rowUt['cognome']." ".$rowUt['nome']) ?>"><?php echo($rowUt['cognome']." ".$rowUt['nome'])  ?></option>
                                                    <?php } ?>
                                                </select>-->

                                            </div></td>
                                        
                                    </tr> 
                                </table>
                            </td> 
                            
                            
                            <?php  } else { ?>
                        <!--################################################################
                        ################# POSIZIONE CHIUSA #################################
                        #################################################################-->
                             <td>
                                <table  width="100%">
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegliPos" name="scegliPos" onclick="javascript:visualizzaFormPosizioneAperta();" value="PosizioneAp" /><?php echo $filtroAperta ?></td>
                                        <td class="cella1" colspan="2">
                                            <div id="PosAperta" >
                                               <?php echo dataEstraiVisualizza($DtApertura) ?>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegliPos" name="scegliPos" onclick="javascript:visualizzaFormPosizioneChiusa();" value="PosizioneCh" checked="checked"/><?php echo $filtroChiusa ?></td>
                                        <td class="cella1">
                                            <div id="PosChiusa" style="visibility:visible;"><?php echo dataEstraiVisualizza($DtChiusura) ?></div></td>
                                            
                                        <td class="cella1">
                                            <div id="OpChiusa" style="visibility:visible;">
                                                
                                               <?php echo $filtroOperatore ?>
<input type="text" name="OperChiusura" id="OperChiusura" value="<?php echo $OperChiusura ?>"/>
                                      <!--           <select id="OperChiusura" name="OperChiusura">
                                                    <option value="<?php echo $OperChiusura ?>" selected="<?php echo $OperChiusura ?>"><?php echo $OperChiusura ?> </option>
                                                    <?php while ($rowUt = mysql_fetch_array($sqlUtente)) { ?>
                                                        <option value="<?php echo ($rowUt['cognome']." ".$rowUt['nome']) ?>"><?php echo($rowUt['cognome']." ".$rowUt['nome'])  ?></option>
                                                    <?php } ?>
                                                </select>-->

                                            </div></td>
                                        
                                    </tr> 
                                </table>
                            </td>                             
                          <?php } ?>                                          
                        </tr>                      
                        <tr>                           
                            <td class="cella2"><?php echo $filtroPriorita ?></td>
                            <td class="cella1" title="<?php echo $titlePrioritaMax ?>"> 
                                <select id="Priorita" name="Priorita" title="<?php echo $titlePrioritaMax ?>">                                    
                                    <option value="<?php echo $Priorita ?>" selected="<?php echo $Priorita ?>"><?php echo $Priorita ?></option>
                                    <option value="10">10</option>
                                    <option value="9">9</option>
                                    <option value="8">8</option>
                                    <option value="7">7</option>
                                    <option value="6">6</option>
                                    <option value="5">5</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1" title="<?php echo $titlePrioritaMax ?>">1</option>
                                </select></td>
                        </tr> 
                         <tr>
                            <td class="cella4"><?php echo $filtroInfo ?> </td>
                            <td class="cella1"><textarea name="Info" id="Info" ROWS="2" COLS="49"><?php echo $Info ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabNote ?> </td>
                            <td class="cella1"><textarea name="Note" id="Note" ROWS="2" COLS="49"><?php echo $Note ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroStatoAt ?></td>
                            <td class="cella1"><input type="text" name="Stato" id="Stato" value="<?php echo $Stato ?>"/></td>
                        </tr> 
                        <tr>
                            <td class="cella4"><?php echo $filtroDtUltimaMod ?></td>
                            <td class="cella1"><?php echo $DtAbilitato ?></td>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                        </tr>
                    </table>
                </form>
                <div id="msgLog">
                <?php
                if ($DEBUG) {

                   echo "</br>Tab macchina : Utenti e aziende visibili " . $strUtentiAziendeMac;
                }
                ?>
            </div>
            </div>

                        
    </body>
</html>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
  