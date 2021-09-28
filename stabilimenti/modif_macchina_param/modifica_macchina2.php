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
    include('../include/gestione_date.php'); 
	  
    //INIZIALIZZAZIONE VARIABILI
    $TipoRiferimento="";
    $LivelloGruppo="";
    $CodiceStabilimento = 0;
    $DescrizioneStabilimento = "";
    $IdClienteGaz = 50;
    $Ragso1 = "";
    $IdLingua = 0;
    $UserOrigami = "";
    $PassOrigami = "";
    $ConfermaPassOrigami = "";
    $UserServer = "";
    $PassServer = "";
    $ConfermaPassServer = "";
    $UserFtp = "";
    $PassFtp = "";
    $ConfermaPassFtp = "";
    $PassZip= "";
    $ConfermaPassZip = "";
//################################################################################
//Recupero dei valori dei campi tipo_riferimento e geografico mandati tramite POST
//################################################################################      
      $TipoRiferimento = $_POST['scegli_geografico'];
      $Geografico = "";
      if ($TipoRiferimento == "Mondo") {
        $Geografico = "Mondo";
      } else if ($TipoRiferimento == "Continente") {
        $Geografico = $_POST['Continente'];
      } else if ($TipoRiferimento == "Stato") {
        $Geografico = $_POST['Stato'];
      } else if ($TipoRiferimento == "Regione") {
        $Geografico = $_POST['Regione'];
      } else if ($TipoRiferimento == "Provincia") {
        $Geografico = $_POST['Provincia'];
      } else if ($TipoRiferimento == "Comune") {
        $Geografico = $_POST['Comune'];
      }
//################################################################################
//Recupero dei valori dei campi livello_gruppo e gruppo mandati tramite POST
//################################################################################      
      $LivelloGruppo = $_POST['scegli_gruppo'];
      $Gruppo = "";
      if ($LivelloGruppo == "PrimoLivello") {
        $Gruppo = $_POST['PrimoLivello'];
      } else if ($LivelloGruppo == "SecondoLivello") {
        $Gruppo = $_POST['SecondoLivello'];
      } else if ($LivelloGruppo == "TerzoLivello") {
        $Gruppo = $_POST['TerzoLivello'];
      } else if ($LivelloGruppo == "QuartoLivello") {
        $Gruppo = $_POST['QuartoLivello'];
      } else if ($LivelloGruppo == "QuintoLivello") {
        $Gruppo = $_POST['QuintoLivello'];
      } else if ($LivelloGruppo == "SestoLivello") {
        $Gruppo = $_POST['SestoLivello'];
      }
//################################################################################
//Recupero dei valori dei campi mandati tramite post
//################################################################################
      $IdMacchina = $_POST['IdMacchina'];
      $CodiceStabilimento = str_replace("'", "''", $_POST['CodiceStab']);
      $DescrizioneStabilimento = str_replace("'", "''", $_POST['DescriStab']);
      $Ragso1 = str_replace("'", "''", $_POST['Ragso1']);
      $IdClienteGaz = str_replace("'", "''", $_POST['IdClienteGaz']);
      $Lingua = str_replace("'", "''", $_POST['Lingua']);
      $UserOrigami = str_replace("'", "''", $_POST['UserOrigami']);
      $UserServer = str_replace("'", "''", $_POST['UserServer']);
      $PassOrigami = str_replace("'", "''", $_POST['PassOrigami']);
      $ConfermaPassOrigami = str_replace("'", "''", $_POST['ConfermaPassOrigami']);
      $PassServer = str_replace("'", "''", $_POST['PassServer']);
      $ConfermaPassServer = str_replace("'", "''", $_POST['ConfermaPassServer']);
      $Geografico = str_replace("'", "''", $Geografico);
      $Gruppo = str_replace("'", "''", $Gruppo);
      $UserFtp = str_replace("'", "''", $_POST['UserFtp']);
      $PassFtp = str_replace("'", "''", $_POST['PassFtp']);
      $ConfermaPassFtp = str_replace("'", "''", $_POST['ConfermaPassFtp']);
      $PassZip= str_replace("'", "''", $_POST['PassZip']);
      $ConfermaPassZip = str_replace("'", "''", $_POST['ConfermaPassZip']);
      $Abilitato = str_replace("'", "''", $_POST['Abilitato']);
//##############################################################################     
//############ VARIABILI RELATIVE AD ERRORI SULLA TRANSAZIONE ##################
//##############################################################################
	  $erroreTransazione=false;
	  $selectServerdbMac = true;
          $insertStoricoMac = true;
          $selectServerdbAnMac = true;
          $insertStoricoAnMac = true;
          $updateServerdbMac = true;
          $updateServerdbAnMac = true;
          $selectServerdbValParSm = true;
          $insertStoricoValParSm = true;
          $updateServerdbValParSm = true;
          $selectServerdbParComp =true;
          $selectServerdbComp = true;
          $insertStoricoValParComp =true;
          $updateServerdbValParComp = true;
                    
//##############################################################################
//###################### Gestione degli errori input ###########################
//##############################################################################
      $errore = false;
      $messaggio = $msgErroreVerificato.'<br/>';

      $errorePar = false;
      $messaggioPar = $msgErroreVerificato.'<br/>';

      $erroreParComp = false;
      $messaggioParComp = $msgErroreVerificato.'<br/>';
      
      if (!isset($CodiceStabilimento) || trim($CodiceStabilimento) == "") {

        $errore = true;
        $messaggio = $messaggio . $msgErrCampoCodStabVuoto . '<br />';
      }
      if (!isset($DescrizioneStabilimento) || trim($DescrizioneStabilimento) == "") {

        $errore = true;
        $messaggio = $messaggio . $msgErrCampoDescriStabVuoto . '<br />';
      }
      if (!isset($Ragso1) || trim($Ragso1) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Ragione Sociale vuoto!<br />';
      }
      if (!isset($Abilitato) || trim($Abilitato) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Abilitato vuoto!<br />';
      }
      if (!isset($IdClienteGaz) || trim($IdClienteGaz) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Id Cliente Gazie vuoto!<br />';
      }
      if (!isset($Geografico) || trim($Geografico) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Riferimento Geografico vuoto!<br />';
      }
      if (!isset($Gruppo) || trim($Gruppo) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Gruppo vuoto!<br />';
      }

  //################# CREDENZIALI ORIGAMIDB ################################## 
      if (!isset($UserOrigami) || trim($UserOrigami) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Username Origami vuoto!<br />';
      }
      if (!isset($PassOrigami) || trim($PassOrigami) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Password Origami vuoto!<br />';
      }
      if (!isset($ConfermaPassOrigami) || trim($ConfermaPassOrigami) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password Origami vuoto!<br />';
      }
      if ($PassOrigami != $ConfermaPassOrigami) {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password Origami Errata!<br />';
      }
//################# CREDENZIALI SERVERDB ################################## 
      if (!isset($UserServer) || trim($UserServer) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Username Server vuoto!<br />';
      }
      if (!isset($PassServer) || trim($PassServer) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Password Server vuoto!<br />';
      }
      if (!isset($ConfermaPassServer) || trim($ConfermaPassServer) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password Server vuoto!<br />';
      }
      if ($PassServer != $ConfermaPassServer) {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password Server Errata!<br />';
      }
            
      //################# CREDENZIALI AGGIORNAMENTO ############################     
      
      if (!isset($UserFtp) || trim($UserFtp) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Username Ftp vuoto!<br />';
      }
      if (!isset($PassFtp) || trim($PassFtp) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Password FTP vuoto!<br />';
      }
      if (!isset($ConfermaPassFtp) || trim($ConfermaPassFtp) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password Ftp vuoto!<br />';
      }
      if ($PassFtp != $ConfermaPassFtp) {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password FTP Errata!<br />';
      }
      
  //####################### ZIP PASSWORD #######################################    
      
      if (!isset($PassZip) || trim($PassZip) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Password Zip vuoto!<br />';
      }
      if (!isset($ConfermaPassZip) || trim($ConfermaPassZip) == "") {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password Zip vuoto!<br />';
      }
      if ($PassZip != $ConfermaPassZip) {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Conferma Password Zip Errata!<br />';
      }          

  //########################### VERIFICA TIPO DI DATI ##########################
      
      if (!is_numeric($IdClienteGaz)) {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Identificativo cliente su Gazie deve essere un numero!<br />';
      }
      if (!is_numeric($CodiceStabilimento)) {

        $errore = true;
        $messaggio = $messaggio . ' - Campo Codice Stabilimento deve essere un numero!<br />';
      }
//Verifico il num di caratteri del codice prodotto
      if (strlen($CodiceStabilimento) < 8) {
        $errore = true;
        $messaggio = $messaggio . ' - Campo Codice Stabilimento deve essere almeno di 8 caratteri!<br />';
      }
//################################################################################
//##################### VERIFICA ESISTENZA #######################################
//################################################################################

//Apro la connessione al db
      include('../Connessioni/serverdb.php');

      $query = "SELECT * FROM macchina 
				WHERE 
					cod_stab = '" . $CodiceStabilimento . "' 
				AND 
					descri_stab = '" . $DescrizioneStabilimento . "'
				AND 
					id_macchina<>" . $IdMacchina;
      $result = mysql_query($query, $connessione) or die("ERRORE 1 SELECT FROM serverdb.macchina : " . mysql_error());

      if (mysql_num_rows($result) != 0) {
        //Se entro nell'if vuol dire che il valore inserito esiste gi� nel db
        $errore = true;
        $messaggio = $messaggio . $msgDuplicaRecord .'<br />';
      }


      $messaggio = $messaggio . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

      if ($errore) {
        //Ci sono errori quindi non salvo
        echo $messaggio;
      } else {
        
        //######################################################################
        //######### CONTROLLO INPUT PARAMETRI SINGOLA MACCHINA #################
        //######################################################################
        $NParEr = 1;
        $selectServerdbValParSm = mysql_query("SELECT   
                                        valore_par_sing_mac.id_val_par_sm,
                                        valore_par_sing_mac.id_par_sm,
                                        valore_par_sing_mac.valore_variabile,
                                        valore_par_sing_mac.abilitato,
                                        valore_par_sing_mac.dt_abilitato,
                                        parametro_sing_mac.nome_variabile,
                                        parametro_sing_mac.descri_variabile
                                FROM 
                                        serverdb.valore_par_sing_mac
                                LEFT JOIN serverdb.parametro_sing_mac
                                ON
                                        valore_par_sing_mac.id_par_sm=parametro_sing_mac.id_par_sm
                                WHERE
                                        serverdb.valore_par_sing_mac.id_macchina=" . $IdMacchina . "
                                ORDER BY 
                                        serverdb.parametro_sing_mac.id_par_sm")
                or die("ERRORE 2 SELECT FROM serverdb.valore_par_sing_mac : " . mysql_error());

//Memorizzo nelle rispettive variabili i valori (arrivati tramite form) relativi 
//ai parametri della macchina che si sta modificando 
        while ($rowValore = mysql_fetch_array($selectServerdbValParSm)) {

          $Valore = $_POST['Valore' . $NParEr];

          //Controllo degli input valore eventualmente modificato 
          if (!isset($Valore) || trim($Valore) == "") {

            $errorePar = true;
            $messaggioPar = $messaggioPar . " Valore del parametro (" . $rowValore['descri_variabile'] . ") vuoto!<br />";
          }
          $NParEr++;
        }//End while finiti i parametri

        $messaggioPar = $messaggioPar . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

        if ($errorePar) {
          //Ci sono errori quindi non effettuo la modifica e visualizzo il messaggio di errore
          echo $messaggioPar;
        } else {


          //######################################################################
          //########  CONTROLLO INPUT PARAMETRI COMPONENTI PRODOTTO  #############
          //######################################################################
          $NParCpErr = 1;
          $NCompErr = 1;
          $selectServerdbParCompErr = mysql_query("SELECT
                                                valore_par_comp.id_par_comp,
                                                parametro_comp_prod.nome_variabile,
                                                parametro_comp_prod.descri_variabile
                                                FROM
                                                serverdb.valore_par_comp
                                        INNER JOIN serverdb.macchina 
                                        ON 
                                                valore_par_comp.id_macchina = macchina.id_macchina
                                        INNER JOIN serverdb.parametro_comp_prod 
                                        ON 
                                                valore_par_comp.id_par_comp = parametro_comp_prod.id_par_comp
                                        WHERE 
						valore_par_comp.id_macchina=" . $IdMacchina . "
                                        GROUP BY 
                                            valore_par_comp.id_par_comp					
                                        ORDER BY 
                                            parametro_comp_prod.id_par_comp")
                  or die("ERRORE 3 SELECT FROM serverdb.valore_par_comp  " . mysql_error());

          while ($rowParametroCpErr = mysql_fetch_array($selectServerdbParCompErr)) {

            //##################### CICLO COMPONENTI #########################

            $selectServerdbCompErr = mysql_query("SELECT
                                            componente.id_comp,
                                          componente.descri_componente,
                                        valore_par_comp.valore_variabile
                                FROM
                                        serverdb.valore_par_comp
                                INNER JOIN serverdb.macchina 
                                ON 
                                        valore_par_comp.id_macchina = macchina.id_macchina
                                INNER JOIN serverdb.componente 
                                ON 
                                        valore_par_comp.id_comp = componente.id_comp
                                WHERE 
                                        valore_par_comp.id_macchina=" . $IdMacchina . "
                                AND 
                                    valore_par_comp.id_par_comp=" . $rowParametroCpErr['id_par_comp'] . "
                                ORDER BY 
                                        componente.descri_componente")
                    or die("ERRORE 4 SELECT FROM serverdb.valore_par_comp :  " . mysql_error());

            while ($rowCompErr = mysql_fetch_array($selectServerdbCompErr)) {

              $ValoreCompErr = $_POST['ValoreComp' . $NCompErr];

              if (!isset($ValoreCompErr) || trim($ValoreCompErr) == "") {

                $erroreParComp = true;
                $messaggioParComp = $messaggioParComp . " Valore del parametro (" . $rowParametroCpErr['nome_variabile'] . " di " . $rowCompErr['descri_componente'] . ") vuoto!<br />";
              }
              $NCompErr++;
            }
            $NParCpErr++;
          }

          $messaggioParComp = $messaggioParComp . '<a href="javascript:history.back()">'.$msgRicontrollaDati.'</a>';

          if ($erroreParComp) {
            //Ci sono errori quindi non effettuo la modifica e visualizzo il messaggio di errore
            echo $messaggioParComp;
          } else {//Fine parametri componenti          
              
//##############################################################################
//################### INIZIO TRANSAZIONE SALVATAGGIO E STORICIZZAZIONE #########
//##############################################################################

            //Seleziono il record  che si vuole modificare dalla tabella [macchina] e memorizzo il contenuto dei vari campi
//            include('../Connessioni/serverdb.php');
            include('../Connessioni/storico.php');
            include('../sql/script.php');
            
            begin();
            
            $selectServerdbMac = mysql_query("SELECT 	     						
                                id_macchina,
                                cod_stab,
                                descri_stab,
                                ragso1,
                                abilitato,
                                dt_abilitato,
                                user_origami,
                                user_server,
                                pass_origami,
                                pass_server
                        FROM 
                                serverdb.macchina
                        WHERE 
                                id_macchina=" . $IdMacchina);
//                or die("ERRORE 5 SELECT FROM serverdb.macchina : " . mysql_error());
            while ($rowMacchina = mysql_fetch_array($selectServerdbMac)) {

              $id_macchina = $rowMacchina['id_macchina'];
              $cod_stab = $rowMacchina['cod_stab'];
              $descri_stab = $rowMacchina['descri_stab'];
              $ragso1 = $rowMacchina['ragso1'];
              $user_origami = $rowMacchina['user_origami'];
              $user_server = $rowMacchina['user_server'];
              $pass_origami = $rowMacchina['pass_origami'];
              $pass_server = $rowMacchina['pass_server'];
              $abilitato = $rowMacchina['abilitato'];
              $dt_abilitato = $rowMacchina['dt_abilitato'];
            }

            //Inserisco nello storico delle macchine i valori appena memorizzati relativi al vecchio record
            $insertStoricoMac = mysql_query("INSERT INTO storico.macchina	
                            (id_macchina,
                                cod_stab,
                                descri_stab,
                                ragso1,
                                user_origami,
                                user_server,
                                pass_origami,
                                pass_server,
                                abilitato,
                                dt_abilitato)
                         VALUES(
                                " . $id_macchina . ",
                                '" . $cod_stab . "',
                                '" . $descri_stab . "',
                                '" . $ragso1 . "',
                                '" . $user_origami . "',
                                '" . $user_server . "',
                                '" . $pass_origami . "',
                                '" . $pass_server . "',
                                " . $abilitato . ",
                                '" . $dt_abilitato . "')");
//                    or die("ERRORE 6 INSERT INTO storico.macchina : " . mysql_error());

            //Seleziono il record vecchio dalla tabella [anagrafe_macchina] e memorizzo il contenuto dei vari campi
            $selectServerdbAnMac = mysql_query("SELECT 			
                                        id_macchina,
                                        id_cliente_gaz,
                                        geografico,
                                        tipo_riferimento,
                                        gruppo,
                                        livello_gruppo,
                                        id_lingua,
                                        abilitato,
                                        dt_abilitato
                                FROM
                                        serverdb.anagrafe_macchina
                                WHERE 
                                        id_macchina=" . $IdMacchina);
//                                or die("ERRORE 7 SELECT FROM serverdb.anagrafe_macchina: " . mysql_error());

            while ($rowAnMac = mysql_fetch_array($selectServerdbAnMac)) {

              $id_macchina = $rowAnMac['id_macchina'];
              $id_cliente_gaz = $rowAnMac['id_cliente_gaz'];
              $rifgeografico = $rowAnMac['geografico'];
              $tipo_riferimento = $rowAnMac['tipo_riferimento'];
              $gruppo = $rowAnMac['gruppo'];
              $livello_gruppo = $rowAnMac['livello_gruppo'];
              $id_lingua = $rowAnMac['id_lingua'];
              $abilitato = $rowAnMac['abilitato'];
              $dt_abilitato = $rowAnMac['dt_abilitato'];
            }

            // Inserisco nello storico dell'anagrafe_macchina i valori appena memorizzati del vecchio record
            $insertStoricoAnMac = mysql_query("INSERT INTO storico.anagrafe_macchina 
                                (id_macchina,
                                    id_cliente_gaz,
                                    geografico,
                                    tipo_riferimento,
                                    gruppo,
                                    livello_gruppo,
                                    id_lingua,
                                    abilitato,
                                    dt_abilitato) 
                        VALUES( 
                                    " . $id_macchina . ",
                                    " . $id_cliente_gaz . ",
                                    '" . $rifgeografico . "',
                                    '" . $tipo_riferimento . "',
                                    '" . $gruppo . "',
                                    '" . $livello_gruppo . "',
                                    " . $id_lingua . ",
                                    " . $abilitato . ",
                                    '" . $dt_abilitato . "')");
//                    or die("ERRORE 8 INSERT INTO storico.anagrafe_macchina : " . mysql_error());

//##############################################################################
//########################## MODIFICO SERVERDB #################################
//##############################################################################

            //Modifico il record corrispondente all'id_macchina selezionato nella tabella [macchina]
            $updateServerdbMac = mysql_query("UPDATE serverdb.macchina 
                                                SET     
                    cod_stab=if(cod_stab != '" . $CodiceStabilimento . "','" . $CodiceStabilimento . "',cod_stab),
                    descri_stab=if(descri_stab != '" . $DescrizioneStabilimento . "','" . $DescrizioneStabilimento . "',descri_stab),
                    ragso1=if(ragso1 != '" . $Ragso1 . "','" . $Ragso1 . "',ragso1),    
                    user_origami=if(user_origami != '" . $UserOrigami . "','" . $UserOrigami . "',user_origami),
                    user_server=if(user_server != '" . $UserServer . "','" . $UserServer . "',user_server),
                    pass_origami=if(pass_origami != '" . $PassOrigami . "','" . $PassOrigami . "',pass_origami),
                    pass_server=if(pass_server != '" . $PassServer . "','" . $PassServer . "',pass_server),
                    ftp_user=if(ftp_user != '" . $UserFtp . "','" . $UserFtp . "',ftp_user),
                    ftp_password=if(ftp_password != '" . $PassFtp . "','" . $PassFtp . "',ftp_password),    
                    zip_password=if(zip_password != '" . $PassZip . "','" . $PassZip . "',zip_password),
                    abilitato='".$Abilitato."'
                        WHERE id_macchina=".$IdMacchina );
//                    or die("ERRORE 9 UPDATE serverdb.macchina : " . mysql_error());

            //Modifico il record corrispondente all'id_macchina selezionato nella tabella [anagrafe_macchina]
            $updateServerdbAnMac = mysql_query("UPDATE serverdb.anagrafe_macchina 
                            SET 
                            id_cliente_gaz=if(id_cliente_gaz != '" . $IdClienteGaz . "','" . $IdClienteGaz . "',id_cliente_gaz),
                            id_lingua=if(id_lingua != '" . $Lingua . "','" . $Lingua . "',id_lingua),  
                            geografico=if(geografico != '" . $Geografico . "','" . $Geografico . "',geografico), 
                            tipo_riferimento=if(tipo_riferimento != '" . $TipoRiferimento . "','" . $TipoRiferimento . "',tipo_riferimento), 
                            gruppo=if(gruppo != '" . $Gruppo . "','" . $Gruppo . "',gruppo), 
                            livello_gruppo=if(livello_gruppo != '" . $LivelloGruppo . "','" . $LivelloGruppo . "',livello_gruppo),     
                            abilitato='".$Abilitato."'
                            WHERE 
                                    id_macchina=" . $IdMacchina );
//                    or die("ERRORE 10 UPDATE serverdb.anagrafe_macchina : " . mysql_error());

//##############################################################################
//#### SALVATAGGIO E STORICIZZAZIONE PARAMETRI SINGOLA MAC #####################
//##############################################################################
                                    
            //Seleziono i vecchi valori dalla tab valore_par_sing_mac, prima dell'eventuale loro modifica, 
            //per inserirli nello storico.
            $NPar = 1;
            $selectServerdbValParSm = mysql_query("SELECT   
                                            valore_par_sing_mac.id_val_par_sm,
                                            valore_par_sing_mac.id_par_sm,
                                            valore_par_sing_mac.valore_variabile,
                                            valore_par_sing_mac.abilitato,
                                            valore_par_sing_mac.dt_abilitato,
                                            parametro_sing_mac.nome_variabile,
                                            parametro_sing_mac.descri_variabile
                                    FROM 
                                            serverdb.valore_par_sing_mac
                                    LEFT JOIN serverdb.parametro_sing_mac
                                    ON
                                            valore_par_sing_mac.id_par_sm=parametro_sing_mac.id_par_sm
                                    WHERE
                                            serverdb.valore_par_sing_mac.id_macchina=" . $IdMacchina . "
                                    ORDER BY 
                                            serverdb.parametro_sing_mac.id_par_sm");
//                    or die("ERRORE 11 serverdb.valore_par_sing_mac : " . mysql_error());

            //Memorizzo nelle rispettive variabili i valori (arrivati tramite form) relativi ai parametri della macchina che si sta modificando 
            while ($rowValore = mysql_fetch_array($selectServerdbValParSm)) {

              $Valore = $_POST['Valore' . $NPar];

              //Inserisco nello storico i vecchi record relativi ai parametri i cui valori si stanno modificando
              $insertStoricoValParSm = mysql_query("INSERT INTO storico.valore_par_sing_mac 	
                            (id_val_par_sm,id_par_sm,id_macchina,valore_variabile,abilitato,dt_abilitato)
                                    VALUES(
                                            " . $rowValore['id_val_par_sm'] . ",
                                            " . $rowValore['id_par_sm'] . ",
                                            " . $IdMacchina . ",
                                            '" . $rowValore['valore_variabile'] . "',
                                            " . $rowValore['abilitato'] . ",
                                            '" . $rowValore['dt_abilitato'] . "')");
//                      or die("ERRORE 12 INSERT INTO storico.valore_par_sing_mac : " . mysql_error());

              //Salvo la modifica dei valori parametri nella tabella valore_par_sing_mac
              $updateServerdbValParSm = mysql_query("UPDATE serverdb.valore_par_sing_mac 
                                                        SET 
                                dt_abilitato=if(valore_variabile != '" . $Valore . "','" . dataCorrenteInserimento() . "',dt_abilitato),
                                valore_variabile=if(valore_variabile != '" . $Valore . "','" . $Valore . "',valore_variabile)
                                                        WHERE
                                                                id_macchina=" . $IdMacchina . "
                                                        AND
                                                                id_par_sm=" . $rowValore['id_par_sm']);
//                      or die("ERRORE 13 UPDATE serverdb.valore_par_sing_mac: " . mysql_error());

               if (!$insertStoricoValParSm OR !$updateServerdbValParSm) {
                        $erroreTransazione = true;
                    }
              
              $NPar++;
            }// end while finiti i parametri singola macchina
            //######################################################################
            //#############SALVATAGGIO PARAMETRI COMPONENTI PROD  ##################
            //######################################################################
            $NParCp = 1;
            $NComp = 1;
            $selectServerdbParComp = mysql_query("SELECT
                                                    valore_par_comp.id_val_comp,
                                                    valore_par_comp.id_par_comp,
                                                    parametro_comp_prod.nome_variabile,
                                                    parametro_comp_prod.descri_variabile
                                                FROM
                                                    serverdb.valore_par_comp
                                                INNER JOIN serverdb.macchina 
                                                ON 
                                                        valore_par_comp.id_macchina = macchina.id_macchina
                                                INNER JOIN serverdb.parametro_comp_prod 
                                                ON 
                                                        valore_par_comp.id_par_comp = parametro_comp_prod.id_par_comp
                                                WHERE 
                                                        valore_par_comp.id_macchina=" . $IdMacchina . "
                                                GROUP BY 
                                                        valore_par_comp.id_par_comp					
                                                ORDER BY 
                                                        parametro_comp_prod.id_par_comp");
//                    or die("ERRORE 14 SELECT FROM serverdb.valore_par_comp  " . mysql_error());

            while ($rowParametroCp = mysql_fetch_array($selectServerdbParComp)) {

              $IdParComp = $_POST['IdParComp' . $NParCp];

              //##################### CICLO COMPONENTI #########################

              $selectServerdbComp = mysql_query("SELECT
                                            componente.id_comp,
                                            componente.descri_componente,
                                            valore_par_comp.valore_variabile,
                                            valore_par_comp.valore_iniziale,
                                            valore_par_comp.dt_valore_iniziale,
                                            valore_par_comp.dt_modifica_mac,
                                            valore_par_comp.dt_agg_mac,
                                            valore_par_comp.valore_mac,
                                            valore_par_comp.abilitato,
                                            valore_par_comp.dt_abilitato
                                    FROM
                                            serverdb.valore_par_comp
                                    INNER JOIN serverdb.macchina 
                                    ON 
                                            valore_par_comp.id_macchina = macchina.id_macchina
                                    INNER JOIN serverdb.componente 
                                    ON 
                                            valore_par_comp.id_comp = componente.id_comp
                                    WHERE 
                                            valore_par_comp.id_macchina=" . $IdMacchina . "
                                    AND 
                                            valore_par_comp.id_par_comp=" . $rowParametroCp['id_par_comp'] . "
                                    ORDER BY 
                                            componente.descri_componente");
//                      or die("ERRORE 15 SELECT FROM serverdb.valore_par_comp  " . mysql_error());

              while ($rowComp = mysql_fetch_array($selectServerdbComp)) {

                $ValoreComp = $_POST['ValoreComp' . $NComp];
                                
              //Inserisco nello storico i vecchi record relativi ai parametri i cui valori si stanno modificando
              $insertStoricoValParComp = mysql_query("INSERT INTO storico.valore_par_comp 	
                            (id_val_comp,
                            id_par_comp,
                            id_comp,
                            id_macchina,
                            valore_variabile,
                            abilitato,
                            dt_abilitato,
                            valore_iniziale,
                            dt_valore_iniziale,
                            dt_modifica_mac,
                            dt_agg_mac,
                            valore_mac)
                                    VALUES( " . $rowParametroCp['id_val_comp'] . ",
                                            " . $rowParametroCp['id_par_comp'] . ",
                                            " . $rowComp['id_comp'] . ",
                                            " . $IdMacchina . ",
                                            '" . $rowComp['valore_variabile'] . "',
                                            " . $rowComp['abilitato'] . ",
                                            '" . $rowComp['dt_abilitato'] . "',
                                            '" . $rowComp['valore_iniziale'] . "',
                                            '" . $rowComp['dt_valore_iniziale'] . "',
                                            '" . $rowComp['dt_modifica_mac'] . "',
                                            '" . $rowComp['dt_agg_mac'] . "',
                                            '" . $rowComp['valore_mac'] . "')");
//                      or die("ERRORE 16 INSERT INTO storico.valore_par_comp : " . mysql_error());

                //Salvo la modifica dei valori parametri nella tabella valore_par_comp
                $updateServerdbValParComp = mysql_query("UPDATE serverdb.valore_par_comp
                                SET 
                                dt_abilitato=if(valore_variabile != '" . $ValoreComp . "','" . dataCorrenteInserimento() . "',dt_abilitato),
                                valore_variabile=if(valore_variabile != '" . $ValoreComp . "','" . $ValoreComp . "',valore_variabile)
                                WHERE
                                        id_macchina=" . $IdMacchina . "
                                AND
                                        id_par_comp=" . $rowParametroCp['id_par_comp'] . "
                                AND 
                                    id_comp=" . $rowComp['id_comp']);
//                        or die("ERRORE 17 UPDATE serverdb.valore_par_comp : " . mysql_error());

                if (!$updateServerdbValParComp OR !$insertStoricoValParComp ) {
                        $erroreTransazione = true;
                    }
                $NComp++;
              }
              
              $NParCp++;
            }
//############################ FINE PARAMETRI COMP PROD #####################################
if ($erroreTransazione
                    OR !$selectServerdbMac 
                    OR !$insertStoricoMac
                    OR !$selectServerdbAnMac
                    OR !$insertStoricoAnMac
                    OR !$updateServerdbMac
                    OR !$updateServerdbAnMac
                    OR !$selectServerdbValParSm//?
                    OR !$selectServerdbParComp//?
                    OR !$selectServerdbComp//?
                    ) {

                    rollback();
                    echo $msgTransazioneFallita." ".$msgErrContattareAdmin;
                } else {

                    commit();
                    mysql_close();
                    ?>
                    <script type="text/javascript">
                        location.href="modifica_macchina.php?Macchina=<?php echo $IdMacchina; ?>"
                    </script> 

                <?php
                }

//            echo 'Modifica completata con successo! <a href="gestione_macchine.php">Torna agli Stabilimenti</a>';
          }// Fine erroreParComp
        }//Fine if errorePar
      }//Fine primo if($errore) controllo degli input relativo al prodotto 
      ?>

    </div>
  </body>
</html>
