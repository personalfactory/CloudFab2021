<?php

/**
 * Restituisce un elenco di oggetti di tipo UtentiProprietari che contiene
 * per ogni utente un elenco di tabelle di cui è proprietario
 */


function getArrayTabellePerUtenteProprietario()
{

    $i = 0;
    $arrayTabelle = array();
    $arrayUtenteProprietarioTabelle = array();


    //Recupero elenco tabelle per poi utilizzarle nella query seguente
    $resultElencoUtenti = selectElencoUtenti();
    while ($rowResult = mysql_fetch_array($resultElencoUtenti))
    {
        $idUtente = $rowResult['id_utente'];
        $nomeUtente = $rowResult['nome'];
        $cognomeUtente = $rowResult['cognome'];
        $usernameUtente = $rowResult['username'];

        $tabelle = selectTabellePerUtenteProprietario($idUtente);

        //Creo un array di oggetti di tipo Tabella
        $arrayTabelle = array();
        $y = 0;
        while ($rowTable = mysql_fetch_array($tabelle)) {

            $arrayTabelle[$y] = new Tabella($rowTable['id_tabella'], $rowTable['nome']);
            $y++;
        }

        $utenteProprietario = new TabelleUtenteProprietario($idUtente, $nomeUtente, $arrayTabelle);

        //Creo un array di oggetti UtentiProprietari
        $arrayUtenteProprietarioTabelle[$i] = $utenteProprietario;


        $i++;
    }


    return $arrayUtenteProprietarioTabelle;
}



/**
 * Metodo che restituisce un oggetto contenente per l'utente le tabelle che puo
 * visualizzare e gli utenti proprietari di quella tabella che puo visualizzare
 */
//I valori in input son l'id ed il nome dell'utente loggato
function getObjectPermessiVisualizzazione($idUt)
{
   /*NON USATO:
    $arrayUtenti = array();
    $arrayUtenti = selectElencoUtenti();
*/

    ############################################################################################
    $resDatiUtente=selectDatiUtente($idUt);
    $rowDatiUt = mysql_fetch_array($resDatiUtente);

    $idUtenteLog =  $rowDatiUt['id_utente'];
    $nomeUtenteLog = $rowDatiUt['nome'];
    $cognomeUtenteLog = $rowDatiUt['cognome'];
    $usernameUtenteLog = $rowDatiUt['username'];
    $visibilitaUtenteLog = $rowDatiUt['visibilita'];
//    echo "visibilita ".$visibilitaUtenteLog;
    ############################################################################################


    #############################################################################################
    /////////Recupero il nome e l'id della azienda di appartenenza dell'utente///////////////////
    $resAziendaUt=selectAziendaUtente($idUtenteLog);
    $rowAzienda = mysql_fetch_array($resAziendaUt);
    $objAziendaUt=new Azienda($rowAzienda['id_azienda'], $rowAzienda['nome']);
    #############################################################################################



    #######################################################################################
    //Creo quindi un oggetto PermessiVisualizzazione che contiene questa informazione:
    //un utente visualizza piu tabelle e per ongi tabella visualizza uno o piu utenti
    //Dato che avra più utenti e più tabelle creerò un array di oggetti
    $objectPermessiVisualizzazione = new PermessiVisualizzazione($idUtenteLog, $nomeUtenteLog, $cognomeUtenteLog, $usernameUtenteLog, $objAziendaUt,$visibilitaUtenteLog);

//    echo "<br/>costruito oggetto PermessiVisualizzazione";




    #######################################################################################
    //Recupero le tabelle che l'utente corrente puo visualizzare
    $arrayTabelleVisibili = array();
    $arrayTabelleVisibili = selectTabelleVisibiliUtente($idUtenteLog);

    while ($rowTable = mysql_fetch_array($arrayTabelleVisibili))
    {

        $idTabella = $rowTable['id_tabella'];
        $nomeTabella = $rowTable['nome'];
        $uVis = 0;
       // $j = 0;
        $uMod = 0;

       /*
        * Stampa verifica dati:
         echo "<br>";
        echo "<br>";
        echo "Tabella: ".$nomeTabella;
        echo "<br>";*/

        //Variabile che indica se la tabella corrente � scrivibile o meno
        //dall'utente possessore del permesso
        $isWrite = false;

        //ELIMINATA AGOSTO 2014:
        //Variabile che indica se la tabella corrente � modificabile o meno
        //dall'utente possessore del permesso
       // $isEdit = false;

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $arrayUtentiPropVisibili = array();

        //Per ogni tabella recupero e memorizzo gli utenti proprietari 
        //visualizzabili per l'utente 
        //Il metodo selectUtentiVisibiliTabella prende un nome utente e per la tabella 
        //inserita cerca gli utenti proprietari che possono essere visualizzati
       // $resArrayUtentiProprietariVisibili = array();
        $resArrayUtentiProprietariVisibili = selectUtentiVisibiliTabella($idUtenteLog, $idTabella);

       //- echo "Tabella: ".$nomeTabella."<br>";

        while ($rowUtProp = mysql_fetch_array($resArrayUtentiProprietariVisibili))
        {
            //In questo punto ho tutta l'informazione necessaria
            //-utente loggato u1
            //-tabella visualizzabile da u1
            //-utenti proprietari visualizzabili da u1 in quella tabella
            $idUtProp = $rowUtProp['id_utente'];
            $nomeUtProp = $rowUtProp['nome'];
            $cognomeUtProp = $rowUtProp['cognome'];
            $usernameUtProp = $rowUtProp['username'];
            $visibilita = $rowUtProp['visibilita'];

           // echo "Utente proprietario visibile: ".$nomeUtProp."<br>";


            ///////NEW AGOSTO
            #############################################################################################
            /////////Recupero il nome e l'id della azienda di appartenenza dell'utente///////////////////
            $arrayAziendaUt=selectAziendaUtente($idUtProp);
            $rowAzienda = mysql_fetch_array($arrayAziendaUt);
                $objAziendaUt=new Azienda($rowAzienda['id_azienda'], $rowAzienda['nome']);

            #############################################################################################



            //##### Modifica Mari ######
            $tipoPermesso = $rowUtProp['permesso'];
            //Se uno degli utenti proprietari della tabella corrente
            //e' l'utente loggato allora setta la variabile isWrite a true
           // echo "</br>idUtProp : " . $idUtProp . " - idUtente" . $idUtente . "</br>";
           // echo "</br>nomeUtProp : " . $nomeUtProp . " - nomeUtente " . $nomeUtente . "</br>";
            if ($idUtProp == $idUtenteLog && $tipoPermesso>1 /*&& $nomeUtProp==$nomeUtente*/ )
            {
               // echo $nomeTabella . " : scrivibile</br>";
                $isWrite = true;
            }

            //NEW AGOSTO 14:
            #############################################################################################
            //Recupero aziende su ui scrive un utente proprietario:
            $arrayAzScritt=array();
            $indexAz=0;

            $resArrayAzUtPropVis = array();
            $resArrayAzUtPropVis = selectAziendeVisibiliUtLoggato($idUtenteLog, $idUtProp, $idTabella);
            while ($rowAzUtPropVisual = mysql_fetch_array($resArrayAzUtPropVis))
            {

                $idAzScrivUtPropVisual=$rowAzUtPropVisual['id_azienda'];
                $nomeAzScrivUtPropVisual=$rowAzUtPropVisual['nome'];

                //echo "Aziende scrivibili: ".$nomeAzScrivUtPropVisual."<br>";


                $arrayAzScritt[$indexAz]=new Azienda($idAzScrivUtPropVisual,$nomeAzScrivUtPropVisual);
                $indexAz++;
            }
            #############################################################################################

           /*
            *
           Linee di stampa per verifica dati:

           echo "Aggiungo utente prop visibile: ".$idUtProp.", ".$nomeUtProp."<br>";
            echo "Array aziende su cui scrive: "."<br>";
           for($z=0; $z<count($arrayAzScritt); $z++)
              echo $arrayAzScritt[$z]->getNomeAzienda()."<br>";
           */

            $arrayUtentiPropVisibili[$uVis] = new UtenteProprietario($idUtProp, $nomeUtProp, $cognomeUtProp, $usernameUtProp, $objAziendaUt, $arrayAzScritt,$visibilita);
            $uVis++;

            ///////#####OLD MIO da Modifica Mari a qui:///////////////////////
            //Se uno degli utenti proprietari della tabella corente
            //è l'utente loggato allora setta la variabile isEdit a true
            /*if($idUtProp==$idUtente && $nomeUtProp==$nomeUtente)
                $isWrite=true;

            $arrayUtentiPropVisibili[$i]=new Utente($idUtProp ,$nomeUtProp);
            $i++;*/

        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
       //ELIMINATO AGOSTO 14:
       /* $arrayAziendeVisibili = array();

        $resArrayAziende = array();
        $resArrayAziende = selectUtenteTabellaAziende($idUtente, $idTabella);
        while ($rowUtTabAziende = mysql_fetch_array($resArrayAziende))
        {
            //In questo punto ho tutta l'informazione necessaria
            //-utente loggato u1
            //-tabella visualizzabile da u1
            //-utenti proprietari visualizzabili da u1 in quella tabella
            $arrayAziendeVisibili[$j] = new Azienda($rowUtTabAziende['id_azienda'], $rowUtTabAziende['nome']);

            $j++;
        }*/
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////
        $arrayUtentiPropModificabili = array();

        $resArrayUtPropMod = array();
        $resArrayUtPropMod = selectElencoPermessiModifica($idUtenteLog, $idTabella);
        while ($rowUtPropModif = mysql_fetch_array($resArrayUtPropMod))
        {

            //In questo punto ho l'informazione
            //-utente loggato u1
            //-tabella modificabile da u1
            //-utenti proprietari di cui si possono modificare i dati

            $idUtPropModif=$rowUtPropModif['id_utente'];
            $nomeUtPropModif=$rowUtPropModif['nome'];
            $cognomeUtPropModif=$rowUtPropModif['cognome'];
            $usernameUtPropModif=$rowUtPropModif['username'];
            $visibilitaUtPropModif=$rowUtPropModif['visibilita'];



             ///////NEW AGOSTO 14:
            #############################################################################################
            /////////Recupero il nome e l'id della azienda di appartenenza dell'utente///////////////////
            $arrayAziendaUt=selectAziendaUtente($idUtPropModif);
            $rowAzienda = mysql_fetch_array($arrayAziendaUt);
                $objAziendaUt=new Azienda($rowAzienda['id_azienda'], $rowAzienda['nome']);

            #############################################################################################


            //NEW AGOSTO 14:
            #############################################################################################
            //Recupero aziende su ui scrive un utente proprietario:
            $arrayAzScritt=array();
            $indexAz=0;


            $resArrayAzUtPropMod = array();

            $resArrayAzUtPropMod = selectAziendeVisibiliUtLoggato($idUtenteLog, $idUtPropModif, $idTabella);
            while ($rowAzUtPropModif = mysql_fetch_array($resArrayAzUtPropMod))
            {

                $idAzScrivUtPropModif=$rowAzUtPropModif['id_azienda'];
                $nomeAzScrivUtPropModif=$rowAzUtPropModif['nome'];

                $arrayAzScritt[$indexAz]=new Azienda($idAzScrivUtPropModif,$nomeAzScrivUtPropModif);
                $indexAz++;

            }
            #############################################################################################


            $arrayUtentiPropModificabili[$uMod] = new UtenteProprietario($idUtPropModif, $nomeUtPropModif, $cognomeUtPropModif, $usernameUtPropModif, $objAziendaUt, $arrayAzScritt,$visibilitaUtPropModif);
            $uMod++;


        }//while










        //OLD: non più utile in quanto l'info si prende dal array degli ut prop modifcabili
      //  if (count($arrayUtentiPropModificabili) > 0)
       //     $isEdit = true;

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //echo "punto 2";
        #######################################################################################
        //Aggiungo la tabella e l'array di proprietari visibili corrispondenti
        //OLD OLD: $objectPermessiVisualizzazione->addTabellaUtenti($idTabella, $nomeTabella, $arrayUtentiProp );


        //new line AGOSTO 14:
        $objectPermessiVisualizzazione->addTabellaUtenti($idTabella, $nomeTabella, $arrayUtentiPropVisibili, $arrayUtentiPropModificabili,  $isWrite);

       //OLD: $objectPermessiVisualizzazione->addTabellaUtenti($idTabella, $nomeTabella, $arrayUtentiPropVisibili, $arrayAziendeVisibili, $isWrite, $isEdit, $arrayUtPropModificabili);
        #######################################################################################


        echo "<br>";
        echo "<br>";

    }//while tabelle


    //NEW SETTEMBRE 2014:
    //Blocco riguardante il recupero delle funzioni visibili all'utente e
    //la conseguente assegnazione all'iterno della classe PermessiVisualizzazione
    //in un array contenente oggetti di tipo Funzione
    $arrayFunzioniUtLoggato=array();
    $indexFunz=0;

    $resFunzioniUt = selectFunzioniUtLoggato($idUtenteLog);
    while ($rowFunzioniUt = mysql_fetch_array($resFunzioniUt))
    {
        $idFunzione=$rowFunzioniUt['id_funzione'];
        $nomeFunzione=$rowFunzioniUt['funzione'];


        ####Aziende: #############################################
        $arrayAzFunz = array();
        $indexAz=0;

        //Recupero per ogni funzione, le aziende visibili
        $resAziendeFunzUt = selectAziendeFunzioniUtLoggato($idUtenteLog, $idFunzione);
        while ($rowAziendeFunzUt = mysql_fetch_array($resAziendeFunzUt))
        {
            $idAziendaFunz=$rowAziendeFunzUt['id_azienda'];
            $nomeAziendaFunz=$rowAziendeFunzUt['nome'];

            $arrayAzFunz[$indexAz] = new Azienda($idAziendaFunz, $nomeAziendaFunz);
            $indexAz++;
        }
        ###########################################################

        $arrayFunzioniUtLoggato[$indexFunz]=new Funzione($idFunzione,$nomeFunzione, $arrayAzFunz);
        $indexFunz++;

        echo "<br>";
    }
    #############################################################################################

    //Setto le funzioni visibili all'interno della classe PermessiVisualizzazione
    $objectPermessiVisualizzazione->setArrayFunzioniVisibili($arrayFunzioniUtLoggato);


    //////////////////////////////////////////////////////////////////////////////
    //Restituisco l'oggetto di tipo PermessiVisualizzazione contenente:
    // - idUtente
    // - nomeUtente
    // - arrayTabelleProprietari
    //                   - idTabella
    //                   - nomeTabella
    //                   - arrayDiUtentiProprietari
    return $objectPermessiVisualizzazione;

}


function getObjectDataUtility()
{

    $objectDataUtility = new MyUtility();

    $idAz=0;
    $arrayAziende = array();

    $idTab=0;
    $arrayTabelle = array();

    $idUt=0;
    $arrayUtenti = array();


    $resAziende= selectElencoAziende();
    while ($rowAz= mysql_fetch_array($resAziende))
    {
        $idAzienda = $rowAz['id_azienda'];
        $nomeAzienda = $rowAz['nome'];

        $arrayAziende[$idAz]=new Azienda($idAzienda, $nomeAzienda );
        $idAz++;
    }

    $resTabelle = selectElencoTabelle();
    while ($rowTab = mysql_fetch_array($resTabelle))
    {
        $idTabella = $rowTab['id_tabella'];
        $nomeTabella = $rowTab['nome'];

        $arrayTabelle[$idTab]=new Tabella($idTabella, $nomeTabella );
        $idTab++;
    }

    $resUtenti = selectElencoUtenti();
    while ($rowUt = mysql_fetch_array($resUtenti))
    {

        $idUtente = $rowUt['id_utente'];
        $nomeUtente = $rowUt['nome'];
        $cognomeUtente = $rowUt['cognome'];
        $usernameUtente = $rowUt['username'];
        $idAzAppart = $rowUt['id_azienda'];
        $visibilita = $rowUt['visibilita'];


        $aziendaAppartenenza="";
        $resAzAppart = selectAziendaUtente($idUtente);
        while ($rowAzApp = mysql_fetch_array($resAzAppart))
        {
            $idAzApp = $rowAzApp['id_azienda'];
            $nomeAzApp = $rowAzApp['nome'];

            $aziendaAppartenenza = new Azienda($idAzApp, $nomeAzApp);
        }


        //!!!ATTENZIONE:
        // impostare l'assegnazione all'oggetto utente del cognome e dell'username


        $arrayUtenti[$idUt]=new Utente($idUtente, $nomeUtente,$aziendaAppartenenza,$visibilita /* $cognomeUtente, $usernameUtente*/  );
        $idUt++;
    }



    $objectDataUtility->setAziende($arrayAziende);
    $objectDataUtility->setTabelle($arrayTabelle);
    $objectDataUtility->setUtenti($arrayUtenti);


    return $objectDataUtility;

}//getObjectDataUtility



//Restituisce un elenco di oggetti di tipo TabelleProprietari che contiene
//per ogni tabella un elenco di utenti proprietari di quella tabella
/* function getArrayUtentiProprietriPerTabella()
  {


  $i=0;

  $arrayTabellaUtentiProprietari=array();

  $resultElencoTabelle = selectElencoTabelle();
  while ( $rowResult = mysql_fetch_array($resultElencoTabelle) )
  {

  $idTabella=$rowResult['id_tabella'];
  $nomeTabella=$rowResult['nome'];


  $utenti = selectUtentiProprietariPerTabella($idTabella);

  $y=0;
  while ($rowUser = mysql_fetch_array($utenti))
  {
  $arrayUtenti[$y]=new Utente($rowUser['id_utente'], $rowUser['nome']);
  $y++;
  }

  $utenteProprietario = new TabelleProprietari( $idTabella, $nomeTabella, $arrayUtenti );

  //Creo un array di oggetti TabelleProprietari
  $arrayTabellaUtentiProprietari[$i]=$utenteProprietario;

  $i++;

  }

  return $arrayTabellaUtentiProprietari;

  }
 */


//Metodo che restituisce un oggetto contenente per l'utente le tabelle che può visualizzare
//e gli utenti proprietari di quella tabella che può visualizzare
//function getObjectPermessiVisualizzazione($idUtente , $nomeUtente)
//{
//
//
//        $arrayUtenti=array();
//        $arrayUtenti=selectElencoUtenti();
//
//
//
//        #######################################################################################
//        //Creo quindi un oggetto PermessiVisualizzazione che contiene questa informazione:
//        //un utente visualizza piu tabella e per ongi tabella visualizza uno o piu utenti
//        //Dato che avrò più utenti e più tabelle creerò un array di oggetti
//        $objectPermessiVisualizzazione=new PermessiVisualizzazione($idUtente,$nomeUtente);
//        #######################################################################################
//
//
//
//        //Recupero le tabelle che l'utente corrente può visualizzare
//        $arrayTabelleVisibili=array();
//        $arrayTabelleVisibili=selectTabelleVisibiliUtente($idUtente);
//
//
//        while ($rowTable = mysql_fetch_array($arrayTabelleVisibili))
//        {
//
//           $idTabella=$rowTable['id_tabella'];
//           $nomeTabella=$rowTable['nome'];
//           $i=0;
//           $j=0;
//
//
//           //Variabile che indica se la tabella corrente è modificabile o meno
//           //dall'utente possessore del permesso
//           $isEdit=false;
//
//           $arrayUtentiProp=array();
//           //Per ogni tabella recupero e memorizzo gli utenti proprietari visualizzabili per l'utente
//           //Il metodo selectUtentiVisibiliTabella prende un nome utente e per la tabella
//           // inserita cerca gli utenti proprietari che possono essere visualizzati
//           $arrayUtentiProprietariVisibili=array();
//           $arrayUtentiProprietariVisibili=selectUtentiVisibiliTabella($idUtente, $idTabella );
//           while ($rowUtProp = mysql_fetch_array($arrayUtentiProprietariVisibili))
//           {
//               //In questo punto ho tutta l'informazione necessaria
//               //-utente loggato u1
//               //-tabella visualizzabile da u1
//               //-utenti proprietari visualizzabili da u1 in quella tabella
//               $idUtProp=$rowUtProp['id_utente'];
//               $nomeUtProp=$rowUtProp['nome'];
//
//               //Se uno degli utenti proprietari della tabella corrente
//               //è l'utente loggato allora setta la variabile isEdit a true
//               if($idUtProp==$idUtente && $nomeUtProp==$nomeUtente)
//                   $isEdit=true;
//
//               $arrayUtentiProp[$i]=new Utente($idUtProp ,$nomeUtProp);
//               $i++;
//
//           }
//
//
//
//            $arrayAziendeVisibili=array();
//            $arrayAziendeVisibili=selectUtenteTabellaAziende($idUtente, $idTabella );
//            while ($rowUtTabAziende = mysql_fetch_array($arrayAziendeVisibili))
//            {
//                //In questo punto ho tutta l'informazione necessaria
//                //-utente loggato u1
//                //-tabella visualizzabile da u1
//                //-utenti proprietari visualizzabili da u1 in quella tabella
//                $arrayAziende[$j]=new Azienda($rowUtTabAziende['id_azienda'], $rowUtTabAziende['nome']);
//
//                $j++;
//            }
//
//
//           #######################################################################################
//           //Aggiungo la tabella e l'array di proprietari visibili corrispondenti
//           //OLD: $objectPermessiVisualizzazione->addTabellaUtenti($idTabella, $nomeTabella, $arrayUtentiProp );
//            $objectPermessiVisualizzazione->addTabellaUtenti($idTabella, $nomeTabella, $arrayUtentiProp, $arrayAziende, $isEdit );
//           #######################################################################################
//
//        }//while tabelle
//
//
//    //////////////////////////////////////////////////////////////////////////////
//    //Restituisco l'oggetto di tipo PermessiVisualizzazione contenente:
//    // - idUtente
//    // - nomeUtente
//    // - arrayTabelleProprietari
//    //                   - idTabella
//    //                   - nomeTabella
//    //                   - arrayDiUtentiProprietari
//    return $objectPermessiVisualizzazione;
//
//}


/**
 * Restituisce gli utenti proprietari visibili per una data tabella dall'utente loggato
 * @param type $objctPermVis
 * @param type $nomeTabella
 * @return type
 */
//function getUtentiPropVisib($objctPermVis,$nomeTabella)
//{   
//    return  $objctPFrmVis->getMysqlStringUtentiProprietariPerTabella($nomeTabella);
//}

/**
 * Restituisce le aziende visibili per una data tabella tabella dall'utente loggato
 * @param type $objctPermVis
 * @param type $nomeTabella
 * @return type
 */
//function getAziendeVisib($objctPermVis,$nomeTabella)
//{   
//    return  $objctPermVis->getMysqlStringAziendePerTabella($nomeTabella);
//}

?>