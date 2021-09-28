<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    
     <?php
    if($DEBUG) ini_set("display_errors", 1);
    
    //#############  AZIENDE SCRIVIBILI  #######################################
    //Array contenente le aziende di cui l'utente può editare i dati nella tabella lab_materie_prime
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_materie_prime');
    
    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziendeVisPer = getStrUtAzVisib($_SESSION['objPermessiVis'], 'persona');      
    $strUtentiAziendeLabMat = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_materie_prime');
    
    
    ?>
   <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="mainContainer">
            <?php 
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_persona.php');
            include('sql/script_lab_materie_prime.php');
            include('sql/script.php');          
            
            begin();
            $sqlForn = findPersoneByTipoVis($valFornitore, "nominativo", $strUtentiAziendeVisPer);
                    
            $sqlFam = findAllFamiglieLabMatPri($strUtentiAziendeLabMat);
                   
            $sqlSottoTipo = findAllTipiLabMatPri($strUtentiAziendeLabMat);
                   
            commit();
            ?>
            <script language="javascript" type="text/javascript">

                function controllaCampi(msgErrCodice, msgErroreNome) {

                    var rv = true;
                    var msg = "";

                    if (document.getElementById('Nome').value === "") {
                        rv = false;
                        msg = msg + ' ' + msgErroreNome;
                    }
                    if (!rv) {
                        alert(msg);
                        rv = false;
                    }
                    return rv;

                }
                function Salva() {

                    document.forms["InserisciMateria"].action = "carica_lab_materia2.php";
                }

                //Funzioni per la visualizzazione del form relativo al tipo di mt
                function visualizzaFormMtCompound() {
                    document.getElementById("Compound").style.visibility = "visible";
                    document.getElementById("CodDrymix").style.visibility = "hidden";
                    document.getElementById("Pigment").style.visibility = "hidden";
                    document.getElementById("Additive").style.visibility = "hidden";

                }
                function visualizzaFormMtDrymix() {
                    document.getElementById("CodDrymix").style.visibility = "visible";
                    document.getElementById("Compound").style.visibility = "hidden";                    
                    document.getElementById("Pigment").style.visibility = "hidden";
                    document.getElementById("Additive").style.visibility = "hidden";
                }
                function visualizzaFormMtPigment() {
                    document.getElementById("Pigment").style.visibility = "visible";
                    document.getElementById("Compound").style.visibility = "hidden";                    
                    document.getElementById("CodDrymix").style.visibility = "hidden";
                    document.getElementById("Additive").style.visibility = "hidden";
                }
                function visualizzaFormMtAdditive() {
                    document.getElementById("Additive").style.visibility = "visible";
                    document.getElementById("Pigment").style.visibility = "hidden";
                    document.getElementById("Compound").style.visibility = "hidden";                    
                    document.getElementById("CodDrymix").style.visibility = "hidden";
                }

                //Funzioni per la visualizzazione del form relativo alla famiglia
                function visualizzaListBoxFamigliaEsistente() {
                    document.getElementById("FamigliaEs").style.visibility = "visible";
                    document.getElementById("FamigliaNu").style.visibility = "hidden";

                }
                function visualizzaFormNuovoFamiglia() {
                    document.getElementById("FamigliaEs").style.visibility = "hidden";
                    document.getElementById("FamigliaNu").style.visibility = "visible";

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
                function NuovoFornitore() {
                    location.href = "../produzionechimica/carica_persona.php?HrefBack=../laboratorio/carica_lab_materia.php";
                }
            </script>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="InserisciMateria" name="InserisciMateria" method="post" onsubmit="return controllaCampi('<?php echo $msgErrCodice ?>', '<?php echo $msgErroreNome ?>')" >
                    <table width="100%">

                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaLabNuovaMatPrima ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLabTipo ?></td>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td class="cella1" colspan="2">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormMtDrymix();" value="1" checked="checked" /><?php echo $filtroLabMtDrymix ?></td>
                                        <div id="MtDrymix"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" colspan="2">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormMtPigment();" value="2" /><?php echo $filtroPigmento ?></td>
                                        <div id="MtPigment" style="visibility:hidden;"></div>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td class="cella1" colspan="2">
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormMtAdditive();" value="3" /><?php echo $filtroAdditivo ?></td>
                                        <div id="MtAdditive" style="visibility:hidden;"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" >
                                            <input type="radio" id="scegli_tipo" name="scegli_tipo" onclick="javascript:visualizzaFormMtCompound();" value="4" /><?php echo $filtroLabMtCompound ?></td>
                                        <td class="cella1" > 
                                            <div id="Compound" style="visibility:hidden;">
                                                <input type="text" name="Compound" id="Compound" size="40px" placeholder="<?php echo $filtroLabDigitaCod ?>" value="" style="text-transform: uppercase;"></input>
                                            </div>
                                        </td>
                                    </tr> 
                                </table>
                            </td>
                        </tr>
                         <tr>
                            <td class="cella4"><?php echo $filtroLabSottoTipo. "<br/>".$filtroLabIndicaSottoTipo ?></td>
                            <td>
                                <table  width="100%">
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaListBoxSottoTipoEsistente();" value="SottoTipoEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                        <td class="cella1">
                                            <div id="SottoTipoEsistente" >
                                                <select id="SottoTipoEs" name="SottoTipoEs">
                                                    <option value="" selected=""><?php echo $labelOptionSelectSottoTipo ?> </option>
                                                    <?php while ($rowSTipo = mysql_fetch_array($sqlSottoTipo)) { ?>
                                                        <option value="<?php echo($rowSTipo['tipo']) ?>"><?php echo($rowSTipo['tipo']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" title="<?php echo $titleLabDigitaSottoTipo ?>">
                                            <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaFormNuovoSottoTipo();" value="SottoTipoNu" /><?php echo $filtroLabNuovo ?></td>
                                        <td class="cella1" >
                                            <div id="SottoTipoNuovo" style="visibility:hidden;">
                                                <input type="text" name="SottoTipoNu" id="SottoTipoNu" size="50" title="<?php echo $titleLabDigitaSottoTipo ?>" style="text-transform: lowercase;"/>

                                            </div></td>
                                    </tr> 
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td class="cella4"><?php echo $filtroFamiglia. "<br/>".$filtroLabIndicaFamiglia ?></td>
                            <td>
                                <table  width="100%">
                                    <tr>
                                        <td class="cella1">
                                            <input type="radio" id="scegli_target" name="scegli_target" onclick="javascript:visualizzaListBoxFamigliaEsistente();" value="FamigliaEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                        <td class="cella1">

                                            <div id="FamigliaEsistente" >
                                                <select id="FamigliaEs" name="FamigliaEs">
                                                    <option value="" selected=""><?php echo $labelOptionSelectFamiglia ?> </option>
                                                    <?php while ($rowFam = mysql_fetch_array($sqlFam)) { ?>
                                                        <option value="<?php echo($rowFam['famiglia']) ?>"><?php echo($rowFam['famiglia']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td class="cella1" title="<?php echo $titleLabDigitaFamiglia ?>">
                                            <input type="radio" id="scegli_target" name="scegli_target" onclick="javascript:visualizzaFormNuovoFamiglia();" value="FamigliaNu" /><?php echo $filtroLabNuova ?></td>
                                        <td class="cella1"  >
                                            <div id="FamigliaNuova" style="visibility:hidden;">
                                                <input type="text" name="FamigliaNu" id="FamigliaNu" size="50" title="<?php echo $titleLabDigitaFamiglia ?>" style="text-transform: uppercase;"/>

                                            </div></td>
                                    </tr> 
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td class="cella4"><?php echo $filtroLabNome ?> </td>
                            <td class="cella1"  ><input type="text" name="Nome" id="Nome" size="50" style="text-transform: uppercase;"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroFornitore ?></td>
                            <td class="cella1"> 
                                <select  name="Fornitore" id="Fornitore"  >
                                    <option value="" selected=""><?php echo $labelOptionSelectFornitore ?></option>
                                    <?php
                                    while ($rowForn = mysql_fetch_array($sqlForn)) {
                                        ?>
                                        <option value="<?php echo $rowForn["nominativo"] ?>" ><?php echo $rowForn["nominativo"] ?></option>
                                    <?php } ?>
                                </select>
                                <input type="button" value="<?php echo $valueButtonNew?>" onClick="javascript:NuovoFornitore();" title="<?php echo $titleNuovoFornitore ?>"/></td>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabUnMisura ?></td>
                                <td class="cella1"><?php echo $filtroLabKg ?> </td>                             
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabPrezzo ?> </td>
                                <td class="cella1"><input type="text" name="Prezzo" id="Prezzo" /><?php echo " " .$filtroEuro?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabPrezzoBs  ?> </td>
                                <td class="cella1" title="<?php echo $titleLabPrezzoBs ?>"><input type="text" name="PrezzoBs" id="PrezzoBs" /><?php echo " " .$filtroEuro?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabNote ?> </td>
                                <td class="cella1"><textarea name="Note" id="Note" ROWS="2" COLS="49"></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroLabData ?></td>
                                <td class="cella1"><?php echo dataCorrenteVisualizza() ?></td>
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
                                                <?php }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                             <tr>
                                <td class="cella4"><?php echo $filtroLabScaffale ?> </td>
                                <td class="cella1"><input type="text" name="Scaffale" id="Scaffale" /></td>
                            </tr>
                             <tr>
                                <td class="cella4"><?php echo $filtroLabRipiano ?> </td>
                                <td class="cella1"><input type="text" name="Ripiano" id="Ripiano" /></td>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                    <input type="submit" value="<?php echo $valueButtonSalva ?>" onClick="Salva()"/></td>
                            </tr>
                    </table>
                </form>
            </div>

<div id="msgLog">
                        <?php
                        if ($DEBUG) {
                           
                            echo "</br>Tabella lab_materie_prime: utenti e aziende vis : ".$strUtentiAziendeLabMat;
                            echo "</br>Tabella persona: utenti e aziende vis : ".$strUtentiAziendeVisPer;
                            echo "</br>Tabella lab_materie_prime: Aziende scrivibili: </br>";

                            for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                                echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                            }
                            
                        }
                        ?>
                    </div>

        </div><!--mainContainer-->

    </body>
</html>
