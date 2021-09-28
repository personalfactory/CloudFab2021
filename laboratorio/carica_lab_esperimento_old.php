<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
    <?php include('../include/header.php'); ?>
  </head>
  <body onload="document.getElementById('CodiceBarre').focus()">

    <h1>Laboratorio</h1>

    <div id="labContainer">

      <?php
      include('../Connessioni/serverdb.php');
      include('../include/gestione_date.php');
      include('../include/funzioni.php');
      include('./sql/script_lab.php');
      include('../include/menu.php'); 
      include('../include/precisione.php');
      ?>
<script type="text/javascript" src="../js/popup.js"></script>
      <script language="javascript">
        function Carica(){
          document.forms["InserisciLabEsperimento"].action = "carica_lab_primo_esperimento2.php";
          document.forms["InserisciLabEsperimento"].submit();
        }
        function AggiornaCalcoli(){
          document.forms["InserisciLabEsperimento"].action = "carica_lab_esperimento_old.php";
          document.forms["InserisciLabEsperimento"].submit();
        }
      </script>

      <?php
      
//###################### NOTA BENE #############################################
//Le variabili contenenti la stringa "acqua" o "ac" si riferiscono a tutti i 
//parametri di tipo PercentualeSI
//##############################################################################      
            
      
//##############################################################################
//####################### INIZIO PRIMO CARICAMENTO PAGINA ######################
//##############################################################################
//Se il codice formula non e'  stato settato allora viene visualizzata la form di inserimento vuota
      if ((!isset($_POST['CodiceBarreOld']) || $_POST['CodiceBarreOld'] == "")) {

        $_SESSION['carica_pagina'] = 0;
        ?>

        <div id="container" style="width:600px; margin:15px; font-size:16px">
          <form id="InserisciLabEsperimento" name="InserisciLabEsperimento" method="post" >
            <input type="hidden" name="starttime" id="starttime"  />
            <table style="width:600px;">

              <th colspan="2" class="cella3">Nuova Prova di Laboratorio</th>
              <tr>
                <td colspan="2" class="cella3">Inserire il codice a barre della prova da visualizzare</td> 
              </tr> 
              <tr>
                <td  class="cella2">Codice da Cercare :</td>
                <td class="cella1"><input type="text" name="CodiceBarreOld" id="CodiceBarreOld" /></td>
              </tr>
              <tr>
                <td colspan="2" class="cella3">Inserire il codice a barre della nuova prova da salvare</td>
              </tr>
              <tr>
                <td width="300" class="cella2">Nuovo Codice :</td>
                <td class="cella1"><input type="text" name="CodiceBarre" id="CodiceBarre" /></td>
              </tr>    
              <tr>
                <td colspan="2" class="cella2">Posizionare sulla bilancia la miscela da pesare</td>
              </tr>

            </table>
            <table>       
              <tr>
                <td><input type="button" onclick="javascript:AggiornaCalcoli();" value="Avanti" /></td>
                <td><input type="reset" value="Annulla" onClick="javascript:history.back();"/></td>
              </tr>
            </table>
          </form>
        </div>
        <?php
      }// End primo caricamento pagina
//##############################################################################
//####################### AGGIORNAMENTO PAGINA #################################
//##############################################################################
//Se il codice  formula e' stato settato tramite un POST allora viene effettuato l'aggiornamento della pagina
//Vengono calcolate e visualizzate le Quantit&agrave; delle materie prime della formula scelta

      if ((isset($_POST['CodiceBarreOld']) && $_POST['CodiceBarreOld'] != "")) {

        //Incremento la variabile aggiornamento per aggiornare la sessione e mantenerla in vita pi� a lungo.
        $_SESSION['aggiornamento']++;

        //Ricavo il valore dei campi arrivati tramite POST : codice dell'esperimento di origine e codice del nuovo esperimento

        $CodiceBarreOld = $_POST['CodiceBarreOld'];
        $CodiceBarre = $_POST['CodiceBarre'];
		
			
        //Incremento la variabile che indica il numero di aggiornamenti fatti sulla pagina
        //Utile per le azioni da eseguire solo al primo aggiornamento 
        $_SESSION['carica_pagina']++;

        $errore = false;
        
        $messaggio = "";

        //Verifica esistenza vecchio codice a barre
        $query = "SELECT * FROM lab_esperimento WHERE cod_barre = '" . $CodiceBarreOld . "'";
        $result = mysql_query($query, $connessione) or die(mysql_error());

        if (mysql_num_rows($result) == 0) {
          //Se entro nell'if vuol dire che esiste
          $errore = true;
          $messaggio = 'Il vecchio Codice a barre inserito non &egrave; associato a nessun esperimento !<br />';
        }

        //Verifica esistenza nuovo codice a barre
        $query = "SELECT * FROM lab_esperimento WHERE cod_barre = '" . $CodiceBarre . "'";
        $result = mysql_query($query, $connessione) or die(mysql_error());

        if (mysql_num_rows($result) != 0) {
          //Se entro nell'if vuol dire che esiste
          $errore = true;
          $messaggio = $messaggio . 'Il Nuovo Codice a barre inserito &egrave; gi&agrave; associato ad un esperimento !<br />';
        }

        if ($errore) {
          //Ci sono errori quindi non salvo
          $messaggio = $messaggio . '<a href="javascript:history.back()">Ricontrollare i dati</a>';
          echo $messaggio;
        } else {


          //Estraggo il codice formula dell'esperimento
          $sqlProva = mysql_query("SELECT id_esperimento, cod_lab_formula
								FROM 
									lab_esperimento
								WHERE 
									cod_barre='" . $CodiceBarreOld . "'")
                  or die("Errore 109: " . mysql_error());
          while ($rowProva = mysql_fetch_array($sqlProva)) {

            $IdEsperimento = $rowProva['id_esperimento'];
            $CodiceFormula = $rowProva['cod_lab_formula'];
          }


          //Solo al primo aggiornamento avviene l'azzeramento della tabella [lab_peso] e l'inizializzazione 
          //della stessa con i codici delle materie prime oggetto di variazione relativi alla formula selezionata
          //e le Quantit&agrave; nulle 
          //e con le altre qta delle materie prime che in realta non verranno pesate 
          //ma sono considerate fisse per la formula.
          if ($_SESSION['carica_pagina'] == 1) {

            //Leggo il peso dalla bilancia
            $sqlPesoMiscela = mysql_query("SELECT bilancia1,bilancia2,bilancia3 
                                            FROM 
                                              lab_bilancia 
                                            WHERE 
                                              id_lab_macchina= ".$_SESSION['lab_macchina'])
                    or die("Errore 125 :" . mysql_error());
            while ($rowPesoMiscela = mysql_fetch_array($sqlPesoMiscela)) {

              $_SESSION['$PesoMiscela'] = $rowPesoMiscela['bilancia1'] + $rowPesoMiscela['bilancia2'] + $rowPesoMiscela['bilancia3'];
            }

            azzeraInizializzaSecondaPesa($IdEsperimento, $CodiceBarre);
          }


          //Calcolo del numero dell'esperimento corrente relativo alla formula selezionata
          $sqlEsper = mysql_query("SELECT MAX(num_prova) as num_esper,id_esperimento 
								FROM 
									lab_esperimento
								WHERE 
									cod_lab_formula='" . $CodiceFormula . "'")
                  or die("Errore 109: " . mysql_error());
          while ($rowEsper = mysql_fetch_array($sqlEsper)) {

            $NumEsperimento = $rowEsper['num_esper'];
          }
          $NumEsperimento = $NumEsperimento + 1;

          //Prova cronometro
          $starttime = time();
          ?>
          <!--############################################################################-->            
          <!--###### Visualizzo l'anagrafe dell'esperimento ##############################-->
          <!--############################################################################-->  

          <div id="container" style="width:800px; margin:15px;">
            <form id="InserisciLabEsperimento" name="InserisciLabEsperimento" method="post" >
              <input type="hidden" name="starttime" id="starttime"  value="<?php echo $starttime; ?>"/>
              <table  style="width:700px;">

                <th  colspan="2" class="cella3">Formula : <?php echo $CodiceFormula; ?></th>
                <input type="hidden" name="Formula" id="Formula" value="<?php echo $CodiceFormula; ?>"/>
                <tr>
                  <td width="200" class="cella3">Nuovo Codice a barre </td>
                  <td class="cella1">
                    <input type="text" name="CodiceBarre" id="CodiceBarre" value="<?php echo $CodiceBarre; ?>"/></td>
                </tr>
                <tr>
                  <td width="200" class="cella3">Data Registrazione </td>
                  <td class="cella1"><?php echo dataCorrenteVisualizza(); ?></td>
                </tr>
                <tr>
                  <td width="200" class="cella3">Ora Registrazione </td>
                  <td class="cella1"><?php echo OraAttuale(); ?></td>
                </tr>
                <tr>
                  <td width="200" class="cella3">Numero Prove Effettuate</td>
                  <td class="cella1"><?php echo $NumEsperimento; ?></td>
                </tr>
                <tr>
                  <td width="200" class="cella3">Quantit&agrave; Totale di Miscela </td>
                  <td class="cella1"><input type="text" name="PesoMiscela" id="PesoMiscela" value="<?php echo $_SESSION['$PesoMiscela']; ?>"/>&nbsp;gr</td>
                </tr>


              </table>
              <!--################################################################################-->            
              <!--### Visualizzo le materie prime associate alla formula con le qta relative #####-->
              <!--### al primo esperimento fatto sulla stessa formula ############################-->  
              <!--################################################################################-->    
              <table  style="width:700px;"> 
                <tr>
                  <th class="cella3">Materie Prime </th>
                  <td class="cella3">Quantit&agrave; % <br/>Teorica</td><!--Quantita teorica presa dalla Formula-->
                  <td class="cella3">Quantit&agrave; % <br/>Reale</td><!--Quantita perc reale pesata nell' esperimento precedente-->
                  <td class="cella3" >Risultato Pesa</td>
                  <td class="cella3" >Pesa</td>
                </tr> 
                <?php
                //Inizializzo i totali
                $QuantitaPercTotReale = 0;
                $QuantitaRealeTotMtComp = 0;

                //Calcolo il totale delle quantita' reale per poter visualizzarla e per calcolare le percentuali reali 
                $sqlTotQtaReale = mysql_query("SELECT
										lab_risultato_matpri.qta_reale
									FROM
										lab_risultato_matpri
									WHERE 
										lab_risultato_matpri.id_esperimento=" . $IdEsperimento)
                        or die("Errore  56: " . mysql_error());

                while ($rowTotQtaRea = mysql_fetch_array($sqlTotQtaReale)) {
                  $QuantitaRealeTotMtComp = $QuantitaRealeTotMtComp + $rowTotQtaRea['qta_reale'];
                }


                $QuantitaRealeTot = 0;

                $NMatPri = 1;
                $sqlMatPrime = mysql_query("SELECT
                                            lab_risultato_matpri.id_esperimento,
                                            lab_risultato_matpri.id_mat,
                                            lab_materie_prime.cod_mat AS codice,
                                            lab_materie_prime.descri_materia AS descri,
                                            lab_risultato_matpri.qta_reale,
                                            lab_matpri_teoria.qta_teo_perc,
                                            lab_peso.peso
                                          FROM
                                              lab_risultato_matpri
                                          INNER JOIN 
                                              lab_materie_prime ON lab_materie_prime.id_mat = lab_risultato_matpri.id_mat
                                          INNER JOIN 
                                              lab_peso ON lab_peso.id = lab_materie_prime.id_mat
                                          INNER JOIN 
                                              lab_matpri_teoria ON lab_matpri_teoria.id_mat = lab_risultato_matpri.id_mat
                                          
                                          WHERE 
                                              lab_risultato_matpri.id_esperimento='" . $IdEsperimento . "'
                                              AND 
                                              lab_matpri_teoria.cod_lab_formula='" . $CodiceFormula . "'
                                              AND
                                              cod_mat NOT LIKE 'comp%'
                                              AND 
                                              lab_peso.id_lab_macchina = ".$_SESSION['lab_macchina']."
                                          GROUP BY id_mat
                                          ORDER BY descri_materia
                                            ")
                        or die("Errore 20: " . mysql_error());
                while ($rowMatPrime = mysql_fetch_array($sqlMatPrime)) {

                  $QtaTeoNew = 0;

                  $QuantitaPercReale = ($rowMatPrime['qta_reale'] * 100) / $QuantitaRealeTotMtComp; //Quantita percentuale reale
                  $QuantitaPercTotReale = $QuantitaPercTotReale + $QuantitaPercReale; //Quantita percentuale reale totale
                  ?>

                  <tr>
                    <td class="cella4"><?php echo($rowMatPrime['descri']) ?></td>
                    <td class="cella2" >&nbsp;<?php echo ($rowMatPrime['qta_teo_perc']); ?></td>
                    <td class="cella1"><?php echo number_format($QuantitaPercReale, $PrecisioneQta, '.', ''); ?>&nbsp;%</td>
                    <td class="cella1">
                      <input type="text" style="width: 80px;" name="Qta<?php echo($NMatPri); ?>" id="Qta<?php echo($NMatPri); ?>" value="<?php echo $rowMatPrime['peso']; ?>"/> 
                    </td>

                    <!--Passaggio per riferimento dei dati utili alla Pesa -->		
                    <td class="cella1">
                      <a href="JavaScript:openWindow('carica_lab_peso.php? DatiPesa=<?php echo ($rowMatPrime['descri']) . ";" . ($rowMatPrime['codice']) . ";" . $QtaTeoNew; ?>')">
                        <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                    </td>	      
                  </tr>
                  <?php
                  $QuantitaRealeTot = $QuantitaRealeTot + $rowMatPrime['peso'];

                  $NMatPri++;
                }//End While materie prime 
                ?>
                <!--################################################################################-->            
                <!--### Visualizzo i componenti associati alla formula con le qta relative #########-->
                <!--### al primo esperimento fatto sulla stessa formula ############################-->  
                <!--################################################################################-->   

                <tr>     
                  <th class="cella3">Componenti</th>
                  <td class="cella3">Quantit&agrave; % <br/>Teorica</td>
                  <td class="cella3">Quantit&agrave; % <br/>Reale</td>
                  <td class="cella3">Risultato Pesa</td>
                  <td class="cella3">Pesa</td>
                </tr> 
                <?php
                $QuantitaPercRealeComp = 0;

                $NComp = 1;
                $sqlComp = mysql_query("SELECT
                                            lab_risultato_matpri.id_esperimento,
                                            lab_risultato_matpri.id_mat,
                                            lab_materie_prime.cod_mat AS codice,
                                            lab_materie_prime.descri_materia AS descri,
                                            lab_risultato_matpri.qta_reale,
                                            lab_matpri_teoria.qta_teo_perc,
                                            lab_peso.peso
                                          FROM
                                              lab_risultato_matpri
                                          INNER JOIN 
                                              lab_materie_prime ON lab_materie_prime.id_mat = lab_risultato_matpri.id_mat
                                          INNER JOIN 
                                              lab_peso ON lab_peso.id = lab_materie_prime.id_mat
                                          INNER JOIN 
                                              lab_matpri_teoria ON lab_matpri_teoria.id_mat = lab_risultato_matpri.id_mat
                                          
                                          WHERE 
                                              lab_risultato_matpri.id_esperimento='" . $IdEsperimento . "'
                                            AND 
                                              lab_matpri_teoria.cod_lab_formula='" . $CodiceFormula . "'
                                            AND
                                                cod_mat LIKE 'comp%'
                                            AND 
                                              lab_peso.id_lab_macchina = ".$_SESSION['lab_macchina']."
                                            GROUP BY 
                                                id_mat
                                            ORDER BY 
                                                descri_materia")
                        or die("Errore 21: " . mysql_error());
                while ($rowComp = mysql_fetch_array($sqlComp)) {
                  //Calcolo della qta di mat prima in base al totale di miscela digitato ed alle percentuali definite nella formula
                  $QtaTeoNew = 0;
                  $QuantitaPercRealeComp = ($rowComp['qta_reale'] * 100) / $QuantitaRealeTotMtComp; //Quantita percentuale reale
                  $QuantitaPercTotReale = $QuantitaPercTotReale + $QuantitaPercReale; //Quantita percentuale reale totale
                  //Quantit&agrave; delle mat prime in proporzione alla nuova Quantit&agrave; di miscela pesata
                  //$QtaCompFissa=($_SESSION['$PesoMiscela']*$rowComp['qta_teo_perc'])/100;
                  ?>

                  <tr>
                    <td class="cella4"><?php echo($rowComp['descri']) ?></td>
                    <td class="cella2" >&nbsp;<?php echo $rowComp['qta_teo_perc']; ?></td>
                    <td class="cella1"><?php echo number_format($QuantitaPercRealeComp, $PrecisioneQta, '.', ''); ?>&nbsp;%</td>
                    <td class="cella1">
                      <input type="text" style="width:80px;" name="QtaComp<?php echo($NComp); ?>" id="QtaComp<?php echo($NComp); ?>" value="<?php echo $rowComp['peso']; ?>"/>&nbsp;gr
                    </td>
                    <!--Passaggio per riferimento dei dati utili alla Pesa -->		
                    <td class="cella1">
                      <a href="JavaScript:openWindow('carica_lab_peso.php? DatiPesa=<?php echo ($rowComp['descri']) . ";" . ($rowComp['codice']) . ";" . $QtaTeoNew; ?>')">
                        <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                    </td>	      
                  </tr>
                  <?php
                  $QuantitaRealeTot = $QuantitaRealeTot + $rowComp['peso'];

                  $NComp++;
                }//End While materie prime 
                ?>
                <tr>
                  <td colspan="3" class="cella2" >Totale Miscela </td>
                  <input type="hidden" name="QtaMiscela" id="QtaMiscela" value="<?php echo $QuantitaRealeTot; ?>"/>
                  <td class="cella3" colspan="2"><?php echo $QuantitaRealeTot; ?>&nbsp;gr</td>
                </tr>
              </table>
              <!--################################################################################-->            
              <!--### Visualizzo i parametri di tipo PercentualeSI con le qta relative ###########-->
              <!--### al primo esperimento fatto sulla stessa formula ############################-->  
              <!--################################################################################--> 
              <table style="width:700px;">    	
                <tr>
                  <th class="cella3">Parametri </th>
                  <td class="cella3">Unita di Misura</td>
                  <td class="cella3">Valore %<br/>Teorico</td>
                  <td class="cella3">Valore %<br/>Reale </td>
                  <td class="cella3" colspan="2">Valore Reale</td>

                </tr> 
                <?php
                //Visualizzo i parametri di tipo PercentualeSI presenti nella tabella [lab_risultato_par] 
                $QtaAcPercReale = 0;

                $NParAcqua = 1;
                $sqlParAcqua = mysql_query("SELECT
                                            lab_risultato_par.id_par,
                                            lab_risultato_par.id_esperimento,
                                            lab_parametro.nome_parametro AS codice,
                                            lab_parametro.descri_parametro AS descri,
                                            lab_parametro.unita_misura,
                                            lab_risultato_par.valore_reale,
                                            lab_peso.peso
                                        FROM
                                            lab_risultato_par
                                        INNER JOIN 
                                            lab_parametro ON lab_risultato_par.id_par = lab_parametro.id_par
                                        INNER JOIN 
                                            lab_peso ON lab_peso.id = lab_parametro.id_par
                                         WHERE 
                                            lab_risultato_par.id_esperimento='" . $IdEsperimento . "'
                                            									
                                                AND 
                                                (tipo LIKE '%" . $PercentualeSI . "%')					
                                                AND 
                                              lab_peso.id_lab_macchina = ".$_SESSION['lab_macchina']."
                                            GROUP BY 
                                                id_par
                                            ORDER BY 
                                                nome_parametro")
                        or die("Errore 21: " . mysql_error());
                while ($rowParAcqua = mysql_fetch_array($sqlParAcqua)) {
                  $QtaAcNew = 0;

                  //Percentuale reale dei parametri di tipo PercentualeSI pesata 
                  //nell'esperimento di origine
                  $QtaAcPercReale = ($rowParAcqua['valore_reale'] * $QuantitaRealeTotMtComp) / 100;

//Seleziono dalla FORMULA TEORICA la percentuale per visualizzarla 
                  $sqlQtaPercAcqua = mysql_query("SELECT
														valore_teo
													FROM
														lab_parametro_teoria
													WHERE 
														cod_lab_formula='" . $CodiceFormula . "'
													AND
														id_par=" . $rowParAcqua['id_par'])
                          or die("Errore 109.3: " . mysql_error());
                  while ($rowQtaPercAcqua = mysql_fetch_array($sqlQtaPercAcqua)) {

                    $QtaPercAcqua = $rowQtaPercAcqua['valore_teo'];
                  }
                  ?>

                  <tr>
                    <td class="cella4"><?php echo($rowParAcqua['codice']) ?></td>
                    <td class="cella2"><?php echo($rowParAcqua['unita_misura']) ?></td>
                    <td class="cella2"><?php echo($QtaPercAcqua); ?></td>
                    <td class="cella2"><?php echo($QtaAcPercReale); ?></td>
                    <td class="cella1">
                      <input type="text" style="width: 80px;" name="QtaAc<?php echo($NParAcqua); ?>" id="QtaAc<?php echo($NParAcqua); ?>" value="<?php echo $rowParAcqua['peso']; ?>"/>&nbsp;gr
                    </td>
                    <!--Passaggio per riferimento dei dati relativi alla pesa dei parametri di tipo PercentualeSI -->
                    <td class="cella1">
                      <a href="JavaScript:openWindow('carica_lab_peso.php? DatiPesa=<?php echo ($rowParAcqua['descri']) . ";" . ($rowParAcqua['codice']) . ";" . $QtaAcNew; ?>')">
                        <img src="/CloudFab/images/pittogrammi/bilancia_media_R.png" class="icone" title="Clicca per pesare"/></a>
                    </td>	
                  </tr>
                  <?php
                  $NParAcqua++;
                }//End While parametri
                //
              //################################################################################-->            
              //### Visualizzo i parametridi tipo PercentualeNO  ################################-->
              //### con le qta relative al primo esperimento fatto sulla stessa formula ########-->  
              //################################################################################--> 
                
                $NPar = 1;
                $sqlPar = mysql_query("SELECT
                                        lab_risultato_par.id_par,
                                        lab_risultato_par.id_esperimento,
                                        lab_parametro.nome_parametro,
                                        lab_parametro.descri_parametro,
                                        lab_parametro.unita_misura,
                                        lab_risultato_par.valore_reale
                                        
                                    FROM
                                        lab_risultato_par
                                    INNER JOIN 
                                        lab_parametro ON lab_risultato_par.id_par = lab_parametro.id_par
                                    
                                    WHERE 
                                        lab_risultato_par.id_esperimento='" . $IdEsperimento . "'
                                        AND 
                                        (tipo LIKE '%" . $PercentualeNO . "%')
                                    ORDER BY 
                                        nome_parametro")
                        or die("Errore 22: " . mysql_error());
                while ($rowPar = mysql_fetch_array($sqlPar)) {
                  ?>
                  <tr>
                    <td class="cella4"><?php echo($rowPar['nome_parametro']) ?></td>
                    <td class="cella2"><?php echo($rowPar['unita_misura']); ?></td>
                    <td class="cella2"></td>
                    <td class="cella1"><input type="text" style="width: 70px;" name="Valore<?php echo($NPar); ?>" id="Valore<?php echo($NPar); ?>" value="<?php echo ($rowPar['valore_reale']); ?>"/></td>
                  </tr>                         
                  <?php
                  $NPar++;
                }//End While parametri PercentualeNO
                ?>

              </table>

              <table>       
                <tr>
                   <!--<td><input type="button" onclick="javascript:AggiornaCalcoli();" value="Aggiorna" /></td>-->
                  <td><input type="button" onclick="javascript:Carica();" value="Salva" /></td>
                  <td><input type="reset" value="Annulla" onClick="location.href='gestione_lab_esperimenti.php';"/></td>
                </tr>
              </table>
            </form>
          </div>
          <?php
		
        }//End Aggiornamento $_POST[Formula]
      }//If errore esistenza codice a barre
      ?>

    </div><!--mainContainer-->

  </body>
</html>
