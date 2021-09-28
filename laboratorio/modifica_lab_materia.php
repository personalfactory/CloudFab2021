 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <script language="javascript" type="text/javascript">
        //Funzioni per la visualizzazione del form relativo al tipo di mt
        function visualizzaFormMtCompound() {
            document.getElementById("Compound").style.visibility = "visible";
            document.getElementById("CodDrymix").style.visibility = "hidden";
        }
        function visualizzaFormMtDrymix() {
            document.getElementById("Compound").style.visibility = "hidden";
            document.getElementById("CodDrymix").style.visibility = "visible";
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
        
        function disabilitaOperazioni() {
            document.getElementById('DefinisciCar').disabled = true;
            document.getElementById('SalvaMat').disabled = true;
            for (i = 0; i < document.getElementsByName('EliminaCar').length; i++) {
                document.getElementsByName('EliminaCar')[i].removeAttribute('href');
            }
        }   
    </script>
    <?php
     if($DEBUG) ini_set('display_errors', 1);
    //###################### GESTIONE UTENTE ###################################
    //1)Si verifica se l'utente ha il permesso di vedere le caratteristiche delle materie prime 30
    //2)Si verifica se l'utente ha il permesso di vedere gli esperimenti 31
    $actionOnLoad="";    
    $elencoFunzioni = array("30","31");
    $actionOnLoad = gestisciPermessiUtenteOnLoad($elencoFunzioni,$_SESSION['objPermessiVis']);
    
    //#############  AZIENDE SCRIVIBILI  #######################################
    //Array contenente le aziende di cui l'utente può editare i dati nella tabella lab_materie_prime
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_materie_prime');
    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziendeVisPer = getStrUtAzVisib($_SESSION['objPermessiVis'], 'persona');      
    $strUtentiAziendeLabMat = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_materie_prime');

    include('../include/precisione.php');
    include('../Connessioni/serverdb.php');    
    include('sql/script.php');
    include('sql/script_lab_materie_prime.php');
    include('sql/script_lab_risultato_matpri.php');
    include('sql/script_lab_caratteristica_mt.php');
    include('sql/script_lab_matpri_car.php');
    include('sql/script_lab_allegato.php');
    include('../sql/script_persona.php');

    $IdMateria = $_GET['IdMateria'];
//La seguente variabile è utile al fine di conoscere la pagina da cui viene 
//richiesto la modifica, 
//la richiesta può provenire dalla pagina "carica_lab_formula" 
//oppure dalla pagina "gestione_lab_materie"
    $PaginaProvenienza ="";
    if(isSet($_GET['Pagina']))
    $PaginaProvenienza = $_GET['Pagina'];

    //########### QUERY AL DB ##################################################
    $sqlProve = "";
    begin();
    $sql = findMatPrimaById($IdMateria);
    $sqlCarAll = findAllegatiPropByIdRif($IdMateria, $valRifMateriaPrima);

    if ($_SESSION['nome_gruppo_utente'] == 'Amministrazione') {
        $sqlProve = findAllEsperimentiByIdMat($IdMateria);
    } else {
        $sqlProve = findEsperimentiByIdMat($IdMateria, $_SESSION['username'], $_SESSION['nome_gruppo_utente']);
    }

          
    

    $sqlSottoTipo = findAllTipiLabMatPri($strUtentiAziendeLabMat);
//            findAllTipo();
    $sqlFam = findAllFamiglieLabMatPri($strUtentiAziendeLabMat);
//            findAllFamiglie();
     $sqlForn = findPersoneByTipoVis($valFornitore, "nominativo", $strUtentiAziendeVisPer);
    commit();

    while ($row = mysql_fetch_array($sql)) {
        $Famiglia = $row['famiglia'];
        $SottoTipo = $row['tipo'];
        $Codice = $row['cod_mat'];
        $Descrizione = $row['descri_materia'];
        $Prezzo = $row['prezzo'];
        $PrezzoBs = $row['prezzo_bs'];
        $Fornitore = $row['fornitore'];
        $Note = $row['note'];
        $Data = $row['dt_abilitato'];
        $UnMisura = $row['unita_misura'];
        $IdUtenteProp = $row['id_utente'];
        $IdAzienda = $row['id_azienda'];
        $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);
        $Scaffale=$row['scaffale'];
        $Ripiano=$row['ripiano'];
        $tipo2=$row['tipo2'];
    }

    //Spostato dopo l'include del menu contenente le lingue
//    $NomeUm = "";
//    if ($UnMisura == $valUniMisKg) {
//        $NomeUm = $filtroLabKg;
//    }
//    $Tipo = substr($Codice, 0, 4);
//    if (substr($Codice, 0, 4) == 'comp')
//        $Tipo = $filtroLabMtDrymix;
//    else
//        $Tipo = $filtroLabMtCompound;

    
    //######################################################################
    //#################### GESTIONE UTENTI #################################
    //######################################################################    
    //Si recupera il proprietario del dato e si verifica se l'utente 
    //corrente ha il permesso di editare  i dati di quell'utente proprietario 
    //nelle tabelle coinvolte
    //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
    //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##################
     
       $viewVerificaPermessi = 0;
        $arrayTabelleCoinvolte = array("lab_materie_prime");
        if ($IdUtenteProp != $_SESSION['id_utente']) {
            $viewVerificaPermessi = 1;
            //Se il proprietario del dato è un utente diverso dall'utente 
            //corrente si verifica il permesso 3
            if ($DEBUG)
                echo "</br>Eseguita verifica permesso di tipo 3";
            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
        }
    //######################################################################
   ?>
    <body onLoad="<?php echo $actionOnLoad ?>">     

        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            $NomeUm = "";
            if ($UnMisura == $valUniMisKg) {
                $NomeUm = $filtroLabKg;
            }
            $Tipo = substr($Codice, 0, 4);
            if (substr($Codice, 0, 4) == 'comp')
                $Tipo = $filtroLabMtDrymix;
            else
                $Tipo = $filtroLabMtCompound;

            if($tipo2==$valTipo2Pigment)
                $Tipo=$valTipo2Pigment;
            
            $sqlCar = findCaratteristicheByIdMat($IdMateria);
           
           
            ?>
            <form id="ModificaLabMateria" name="ModificaLabMateria" method="post" action="modifica_lab_materia2.php">
                <div id="container" style="width:90%; margin:15px auto;">
                    <table width="100%">
                        <input type="hidden" name="IdMateria" id="IdMateria" value="<?php echo $IdMateria; ?>"></input>
                        <input type="hidden" name="Codice" id="Codice" value="<?php echo $Codice; ?>"></input>
                        <input type="hidden" name="PaginaProvenienza" id="PaginaProvenienza" value="<?php echo $PaginaProvenienza; ?>"></input>
                        <input type="hidden" name="TipoMat" id="TipoMat" value="<?php echo $Tipo; ?>"></input>
                        <input type="hidden" name="DescrizioneOld" id="DescrizioneOld" value="<?php echo $Descrizione; ?>"></input>
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaLabMatPrima ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroLabTipo ?></td>
                            <td class="cella1"><?php echo $Tipo; ?></td>                      
                            <tr>
                                <td class="cella4"><?php echo $filtroLabSottoTipo . "<br/>".$filtroLabIndicaSottoTipo?></td>
                                <td>
                                    <table  width="100%">
                                        <tr>
                                            <td class="cella1">
                                                <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaListBoxSottoTipoEsistente();" value="SottoTipoEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
                                            <td class="cella1">

                                                <div id="SottoTipoEsistente" >
                                                    <select id="SottoTipoEs" name="SottoTipoEs">
                                                        <option value="<?php echo $SottoTipo ?>" selected="<?php echo $SottoTipo ?>"><?php echo $SottoTipo ?></option>
                                                        <?php while ($rowSTipo = mysql_fetch_array($sqlSottoTipo)) { ?>
                                                            <option value="<?php echo($rowSTipo['tipo']) ?>"><?php echo($rowSTipo['tipo']) ?></option>
                                                <?php } ?>
                                                    </select>
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="cella1" title="<?php echo $titleLabDigitaFamiglia ?>">
                                                <input type="radio" id="scegli_sottotipo" name="scegli_sottotipo" onclick="javascript:visualizzaFormNuovoSottoTipo();" value="SottoTipoNu" /><?php echo $filtroLabNuovo ?></td>
                                            <td class="cella1">
                                                <div id="SottoTipoNuovo" style="visibility:hidden;">
                                                    <input type="text" name="SottoTipoNu" id="SottoTipoNu" size="50" title="<?php echo $titleLabDigitaSottoTipo ?>"/>

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
                                                        <option value="<?php echo $Famiglia ?>" selected="<?php echo $Famiglia ?>"><?php echo $Famiglia ?></option>
                                                        <?php while ($rowFam = mysql_fetch_array($sqlFam)) { ?>
                                                            <option value="<?php echo($rowFam['famiglia']) ?>"><?php echo($rowFam['famiglia']) ?></option>
<?php } ?>
                                                    </select>
                                                </div></td>
                                        </tr>
                                        <tr>
                                            <td class="cella1" title="<?php echo $titleLabDigitaFamiglia ?>">
                                                <input type="radio" id="scegli_target" name="scegli_target" onclick="javascript:visualizzaFormNuovoFamiglia();" value="FamigliaNu" /><?php echo $filtroLabNuova ?></td>
                                            <td class="cella1">
                                                <div id="FamigliaNuova" style="visibility:hidden;">
                                                    <input type="text" name="FamigliaNu" id="FamigliaNu" size="50" title="<?php echo $titleLabDigitaFamiglia ?>"/>
                                                </div></td>
                                        </tr> 
                                    </table>
                                </td>
                            </tr> 
                            <tr>
                                <td width="250px" class="cella2"><?php echo $filtroLabNome ?></td>
                                <td class="cella1"><input style="width:340px" type="text" name="Descri" id="Descri" value="<?php echo $Descrizione; ?>"/></td>
                            </tr>
                            <tr>
                                <td width="250px" class="cella2"><?php echo $filtroLabCodice ?></td>
                                <td class="cella1"><?php echo $Codice; ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabFornitore ?></td>                               
                           
                           
                            <td class="cella1"> 
                                <select  name="Fornitore" id="Fornitore"  >
                                    <option value="<?php echo $Fornitore ?>" selected="<?php echo $Fornitore ?>"><?php echo $Fornitore ?></option>
<?php
while ($rowForn = mysql_fetch_array($sqlForn)) {
    ?>
                                        <option value="<?php echo $rowForn["nominativo"] ?>" size="40"><?php echo $rowForn["nominativo"] ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                                <!--<td class="cella1"><input style="width:340px" type="text" name="Fornitore" id="Fornitore" value="<?php echo $Fornitore; ?>"/></td>-->
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroUniMisura ?></td>
                                <td class="cella1"><?php echo $NomeUm ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabPrezzo ?></td>
                                <td class="cella1"><input style="width:70px" type="text" name="Prezzo" id="Prezzo" value="<?php echo $Prezzo; ?>"/><?php echo $filtroLabEuro ?></td>
                            </tr>
                        <tr>
                                <td class="cella2"><?php echo $filtroLabPrezzoBs ?></td>
                                <td class="cella1"><input style="width:70px" type="text" name="PrezzoBs" id="PrezzoBs" value="<?php echo $PrezzoBs; ?>"/><?php echo $filtroLabEuro ?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabNote ?></td>
                                <td class="cella1"><textarea  name="Note" id="Note" ROWS=4 COLS=40 value="<?php echo $Note; ?>"/><?php echo $Note; ?></textarea></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroLabData ?></td>
                                <td class="cella1"><?php echo $Data; ?></td>
                            </tr>
                            <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella1">
                                    <select name="Azienda" id="Azienda"> 
                                        <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                        <?php
                                        //Si selezionano solo le aziende scrivibili dall'utente
                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                            if ($idAz <> $IdAzienda) {
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
                                <td width="250px" class="cella2"><?php echo $filtroLabScaffale?></td>
                                <td class="cella1"><input type="text" name="Scaffale" id="Scaffale" value="<?php echo $Scaffale; ?>"/></td>
                            </tr>
                        <tr>
                                <td width="250px" class="cella2"><?php echo $filtroLabRipiano?></td>
                                <td class="cella1"><input type="text" name="Ripiano" id="Ripiano" value="<?php echo $Ripiano; ?>"/></td>
                            </tr>
                        
                        
                        
                    </table>

                            <table id="30" style="width:100%; margin:15px auto;">

                                <!--####################################################-->
                                <!--################ CARATTERISTICHE ###################-->
                                <!--####################################################-->

                                <?php
//                                $sqlCar = findCaratteristicheByIdMat($IdMateria);
                                if (mysql_num_rows($sqlCar) > 0 || mysql_num_rows($sqlCarAll) > 0) {
                                    ?>

                                    <tr>
                                        <td colspan="8" class="cella3" ><?php echo $filtroLabCaratteristiche ?></td>
                                    </tr>

                                    <?php
                                    $NCar = 1;
                                    while ($rowCar = mysql_fetch_array($sqlCar)) {
                                        $sqlFile = findAllegatiByIdRifCar($IdMateria, $rowCar['id_carat'], $valRifMateriaPrima, "lab_caratteristica_mt");
                                        ?>
                                        <tr>
                                            <td class="cella1"><?php echo $rowCar['caratteristica']; ?></td>
                                            <td class="cella1"><?php echo $rowCar['valore_caratteristica'] . " " . $rowCar['uni_mis_car']; ?></td>
                                            <td class="cella1"><?php echo $rowCar['valore_dimensione'] . " " . $rowCar['uni_mis_dim']; ?></td>
                                            <td class="cella1"><?php echo $rowCar['note']; ?></td>
                                            <td class="cella1"><?php echo $rowCar['dt_registrazione']; ?></td>
                                            <td class="cella1" width="30px">
                                                <a name="VediGrafico" target="_blank" href="grafico_lab_caratteristica_mt.php?IdMateria=<?php echo $IdMateria ?>&IdCar=<?php echo $rowCar['id_carat'] ?>">
                                                    <img src="/CloudFab/images/pittogrammi/grafico_G.png" class="icone"  title="<?php echo $titleVediGrafico ?>"/></a>

                                            </td>
                                            <td class="cella1" width="30px">
                                                <a name="EliminaCar" href='elimina_lab_dato.php?Tabella=lab_matpri_car&IdRecord=<?php echo $rowCar['id'] ?>&NomeId=id&RefBack=modifica_lab_materia.php?IdMateria=<?php echo $IdMateria ?> ' onClick="return VisualizzaMsgConferma();" >
                                                    <img src="/CloudFab/images/pittogrammi/patumiera_G.png" class="icone"  title="<?php echo $titleElimina ?>"/></a>
                                            </td>

                                            <td class="cella1" width="30px">
        <?php if (mysql_num_rows($sqlFile) > 0) { ?>
                                                    <a name="DettaglioAllegato" href="dettaglio_lab_allegato.php?IdRif=<?php echo $IdMateria ?>&IdCarat=<?php echo $rowCar['id_carat'] ?>&NomeCar=<?php echo $rowCar['caratteristica'] ?>&TipoRif=<?php echo $valRifMateriaPrima ?>&RefBack=modifica_lab_materia.php?IdMateria=<?php echo $IdMateria ?>">
                                                        <img src="/CloudFab/images/pittogrammi/allegato_R.png" class="icone"  title="<?php echo $titleVediAllegati ?>"/></a> 
        <?php } ?></td>

                                        </tr>
                                        <?php
                                        $NCar++;
                                    }

                                    //##################################################################
                                    //Caratteristiche che hanno un allegato nella tabella lab_allegato 
                                    //ma non hanno un valore salvato nella tabella lab_matpri_car
                                    $NCarAll = 1;
                                    while ($rowCarAll = mysql_fetch_array($sqlCarAll)) {
                                        ?>		
                                        <tr>
                                            <td width="300px" class="cella1" title="<?php echo $rowCarAll['descri_caratteristica']; ?>"><?php echo $rowCarAll['caratteristica']; ?></td>
                                            <td class="cella1" width="60px"><?php echo $filtroLabFile; ?></td>
                                            <td class="cella1" colspan="2"></td>
                                            <td class="cella1"  width="150px"><?php echo $rowCarAll['data_caricato'] ?></td>
                                            <td class="cella1" colspan="2"></td>
                                            <td class="cella1" width="30px">
                                                <a name="DettaglioAllegato" href="dettaglio_lab_allegato.php?IdRif=<?php echo $IdMateria ?>&IdCarat=<?php echo $rowCarAll['id_carat'] ?>&NomeCar=<?php echo $rowCarAll['caratteristica'] ?>&TipoRif=<?php echo $valRifMateriaPrima ?>&RefBack=modifica_lab_materia.php?IdMateria=<?php echo $IdMateria ?>">
                                                    <img src="/CloudFab/images/pittogrammi/allegato_R.png" class="icone"  title="<?php echo $titleVediAllegati ?>"/></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $NCarAll++;
                                    }//End While caratteristiche senza valore
                                   
                                } //End if car>0
                                ?>
                            </table> 
 <table id="31" width="100%">
                            <?php
                            if (mysql_num_rows($sqlProve) > 0) {
                                ?>    
                                <!--####################################################-->
                                <!--################ ESPERIMENTI #######################-->
                                <!--####################################################-->

                               
                                    <tr>
                                        <td colspan="4" class="cella3" ><?php echo $filtroLabStoricoProveMt ?></td>
                                    </tr>
                                    <tr>
                                        <td class="cella2"><?php echo $filtroLabFormula ?> </td>
                                        <td class="cella2"><?php echo $filtroLabEsperimentiFatti ?> </td>
                                        <td class="cella2"><?php echo $filtroLabData ?></td>
                                        <td class="cella2"></td>
                                    </tr>
                                    <?php
                                    $CodiceLabFormula = "0";
                                    $NumProva = 0;
                                    $DtProva = "0";
                                    $NProva = 1;
                                    while ($rowProva = mysql_fetch_array($sqlProve)) {
                                        ?>
                                        <tr>
                                            <td class="cella1"><?php echo($rowProva['cod_lab_formula']); ?></td>
                                            <td class="cella1"><?php echo($rowProva['num_prove_tot']); ?></td>
                                            <td class="cella1"><?php echo($rowProva['dt_prova']); ?></td>
                                            <td class="cella1" width="30px"><a name="DettaglioFormula" href="dettaglio_lab_formula_prove.php?CodLabFormula=<?php echo($rowProva['cod_lab_formula']) ?>" title="<?php echo $titleLabVediFormula ?>">
                                                    <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone"  title="<?php echo $titleVediFormula ?>"/></a></td>
                                        </tr>
                                        <?php
                                        $NProva++;
                                    }
                                }// End if prove>0
                                ?> 
                            </table>  
                            </div>
                            <div  style="width:90%; margin:15px auto;">
                                <table width="100%">
                                    <tr>
                                        <td class="cella2" style="text-align: right">
                                            <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                            <input type="button" id="DefinisciCar" value="<?php echo $valueButtonDefinisciCar ?>" onClick="location.href = 'aggiungi_caratteristica_mt.php?IdMat=<?php echo $IdMateria; ?>'" title="<?php echo $titleLabDefinCar ?>"/>
                                            <input type="submit" id="SalvaMat" value="<?php echo $valueButtonSalva ?>" /></td>
                                    </tr>
                                </table>    
                            </div>
                            </form>
            <div id="msgLog">
                        <?php
                        if ($DEBUG) {
                            if ($viewVerificaPermessi)
                            echo "</br>Eseguita verifica permesso di tipo 3"; 
                            echo "</br>ActionOnLoad : " . $actionOnLoad;                           
                            echo "</br>Id utente prop del dato: " . $IdUtenteProp;
                            echo "</br>Id azienda proprietaria del dato: " . $IdAzienda;
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
