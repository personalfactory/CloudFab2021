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
            
            
            begin();
            $sqlTipo = selectAllInfoGroupBy("tipo_info",$strUtentiAziendeMac);
            $sqlSottoTipo = selectAllInfoGroupBy("sotto_tipo",$strUtentiAziendeMac);
            $sqlStab = findAllMacchineVisAbilitate("id_macchina",$strUtentiAziendeMac);
            commit();
            ?>
            <script language="javascript" type="text/javascript">

                function controllaCampi(msgErrStab) {

                    var rv = true;
                    var msg = "";

                    if (document.getElementById('Stabilimento').value === "") {
                        rv = false;
                        msg = msg + ' ' + msgErrStab;
                    }

                    if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }
                function Salva() {

                    document.forms["InserisciInfoOri"].action = "carica_info_origami2.php";
                }

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
            </script>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="InserisciInfoOri" name="InserisciInfoOri" method="post" onsubmit="return controllaCampi('<?php echo $msgErrStab ?>')" >
                    <table width="100%">

                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovaInfoOri ?></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroStabilimento ?></td>
                            <td  class="cella1">
                                <select id="Stabilimento" name="Stabilimento">
                                    <option value="" selected=""><?php echo $labelOptionSelectStab ?> </option>
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
                                                    <option value="" selected=""><?php echo $labelOptionSelectTipoInfo ?> </option>
                                                    <?php while ($rowTipo = mysql_fetch_array($sqlTipo)) { ?>
                                                        <option value="<?php echo($rowTipo['tipo_info']) ?>"><?php echo($rowTipo['tipo_info']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" title="<?php echo $titleDigitaTipo ?>">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormNuovoTipo();" value="TipoNu" title="<?php echo $titleNuovoTipo ?>"/><?php echo $filtroNuovo ?></td>
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
                                            <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaListBoxSottoTipoEsistente();" value="SottoTipoEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                        <td class="cella1">
                                            <div id="SottoTipoEsistente" >
                                                <select id="SottoTipoEs" name="SottoTipoEs">
                                                    <option value="" selected=""><?php echo $labelOptionSelectSoTipoInfo ?> </option>
                                                    <?php while ($rowSTipo = mysql_fetch_array($sqlSottoTipo)) { ?>
                                                        <option value="<?php echo($rowSTipo['sotto_tipo']) ?>"><?php echo($rowSTipo['sotto_tipo']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" title="<?php echo $titleLabDigitaSottoTipo ?>">
                                            <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaFormNuovoSottoTipo();" value="SottoTipoNu" title="<?php echo $titleNuovoSTipo ?>"/><?php echo $filtroLabNuovo ?></td>
                                        <td class="cella1">
                                            <div id="SottoTipoNuovo" style="visibility:hidden;">
                                                <input type="text" name="SottoTipoNu" id="SottoTipoNu" size="50" title="<?php echo $titleLabDigitaSottoTipo ?>"/>

                                            </div></td>
                                    </tr> 
                                </table>
                            </td>
                        </tr> 
                       
                       <tr>
                           <td class="cella2"><?php echo $filtroPosizione ?></td>
                           <td class="cella1"><input type="radio" id="Posizione" name="Posizione" checked="checked" value="<?php echo $valPosAperta ?>" /><?php echo $filtroAperta ?></td>
                       </tr>
                                              
                        <tr>
                            <td class="cella2"><?php echo $filtroPriorita ?></td>
                            <td class="cella1" title="<?php echo $titlePrioritaMax ?>"> 
                                <select id="Priorita" name="Priorita" title="<?php echo $titlePrioritaMax ?>">  
                                    <option value="" selected="" title="<?php echo $titlePrioritaMax ?>"><?php echo $labelOptionSelectPriorita ?></option>
                                    <option value="1" title="<?php echo $titlePrioritaMax ?>">1</option>
                                   <option value="2">2</option>
                                   <option value="3">3</option>
                                   <option value="4">4</option>
                                   <option value="5">5</option>
                                   <option value="6">6</option>
                                   <option value="7">7</option>
                                   <option value="8">8</option>
                                   <option value="9">9</option>
                                   <option value="10">10</option>                                    
                                </select>
                            <?php echo $msgInfoPrioritaMax ?></td>
                        </tr> 
                        <tr>
                            <td class="cella4"><?php echo $filtroInfo ?> </td>
                            <td class="cella1"><textarea name="Info" id="Info" ROWS="2" COLS="49"></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabNote ?> </td>
                            <td class="cella1"><textarea name="Note" id="Note" ROWS="2" COLS="49"></textarea></td>
                        </tr>
                         <tr>
                            <td class="cella2"><?php echo $filtroStatoAt ?></td>
                            <td class="cella1"><input type="text" name="Stato" id="Stato" /></td>
                        </tr> 
                        <tr>
                            <td class="cella4"><?php echo $filtroDt ?></td>
                            <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
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



        </div><!--mainContainer-->

    </body>
</html>
