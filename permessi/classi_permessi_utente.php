<?php


ini_set('display_errors', 1);
//Classe che contiene l'informazione di quali siano le tabelle su cui scrive un utente
/*class TabelleUtenteProprietario extends Utente{


    public $arraytabelle;


    //Costruttore
    function __construct($idUt, $nUt, $arrTab)
    {
        $this->setUtente($idUt,$nUt);
        $this->arraytabelle = $arrTab;

    }

    public function setUtentiProprietari($idUt, $nUt, $tabs)
    {
        $this->setUtente($idUt,$nUt);
        $this->tabelle = $tabs;

    }

    public function getElencoTabelle(){    return $this->arraytabelle; }



}*/


//Classe che contiene l'informazione di quali siano gli utenti proprietari di quella tabella
//tiene conto anche di quali aziende siano i dati scritti
class TabellaProprietari extends Tabella
{
   //Old
   // private $arrayAziende;

    ##Array di oggetti di tipo UtenteProprietario##################################################
    //Array di utenti proprietari dei quali si possono visualizzare i dati///////////////////////
    private $arrayUtPropVisualizzabili;
    //Array di utenti proprietari dei quali si possono modificare i dati///////////////////////
    private $arrayUtPropModificabili;
    ////////////////////////////////////////////////////////////////////////////////////////////


    //Variabile che dice se la tabella è scrivibile o meno dall'utente loggato
    private $isWritable;

    //////////////////////////////////////////////////////////////////////////////////////////
    //Variabile che indica se i dati della tabella sono modificabili
    //se si l'array $arrayUtPropModificabili indica di quali utenti
    //i dati siano modificabili
    //Quindi la lettura dell'$arrayUtPropModificabili ha senso
    //sono se $idEditable è true
    //private $isEditable;          OLD


    //MODIFICA AGOSTO 2014: costruttore adattato alla nuova organizzazione utenti modificabile ed aziende di appartenenza
    //Costruttore
    //Riceve in input anche gli utenti proprietari visibili e quelli visualizzabili
    function __construct($idTab, $nTab, $arrUtPropVis, $arrUtPropMod,  $isWrite /*old: , $arrAz, $isEdit */ )
    {
        $this->setTabella( $idTab, $nTab );


        $this->arrayUtPropVisualizzabili = $arrUtPropVis;
        $this->arrayUtPropModificabili=$arrUtPropMod;


        $this->isWritable=$isWrite;

        //Old lines:
        // $this->arrayAziende = $arrAz;
       // $this->isEditable=$isEdit;

        //New lines: OLD
        //$this->isEditable=$isEdit;

    }



    /* public function setTabelleProprietari($idTab, $nTab, $arrUt, $arrAz, $isWrite)
     {
         $this->setTabella( $idTab, $nTab );
         $this->arrayUtPropVisualizzabili = $arrUt;
         $this->arrayAziende = $arrAz;
         $this->isWritable=$isWrite;
     }*/

    //metodo che imposta a true o a false la variabile che indica se
    //la tabella è o meno scrivibile
    public function setTableWritable( $isWrite ){ $this->isWritable=$isWrite; }

    //Metodo che restituisce true se si ha il diritto di
    //scrittura o meno su quella tabella
    public function tableIsWritable(){ return $this->isWritable; }


    //Restituisce true o false a seconda se si può o meno modificare dati in questa tabella
    //Lo fa controllando se ci sono utenti proprietari modificabili nell'array apposito
    public function tableIsEditable()
    {
        if(count($this->arrayUtPropModificabili)>0)
            return true;
        else
            return false;
    }


    public function getArrayUtentiPropVisib(){  return $this->arrayUtPropVisualizzabili;  }
    //public function getArrayAziendeVisibili(){  return $this->arrayAziende;  }
    public function getArrayUtentiPropModif(){ return $this->arrayUtPropModificabili; }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Metodo che controlla negli array degli utenti proprietari
    //le aziende complessive utilizzate per la tabella
    //In quanto di una azienda si potranno visualizzare i dati per i permessi >=1
    public function getArrayAziendeVisibTabella()
    {
        $arrayAziendeVisibiliTot=array();
        $indexArr=0;


        if(count($this->arrayUtPropVisualizzabili)>0)
        for($uV=0; $uV<count($this->arrayUtPropVisualizzabili); $uV++)
        {
            $arrayAziendeUtPropVis=$this->arrayUtPropVisualizzabili[$uV]->getArrayAziendeScrivibiliUtProp();
            for($azV=0; $azV<count($arrayAziendeUtPropVis); $azV++)
                if( !$this->findAzienda($arrayAziendeUtPropVis[$azV]->getIdAzienda(), $arrayAziendeVisibiliTot) )
                {
                    //Se l'azienda non è presente nell'elenco l'aggiungo all'array//////////
                    $arrayAziendeVisibiliTot[$indexArr]=$arrayAziendeUtPropVis[$azV];
                    $indexArr++;
                    ////////////////////////////////////////////////////////////////////////
                }

        }//arrayUtPropVisualizzabili


        if(count($this->arrayUtPropModificabili)>0)
        for($uM=0; $uM<count($this->arrayUtPropModificabili); $uM++)
        {

            $arrayAziendeUtPropMod = $this->arrayUtPropModificabili[$uM]->getArrayAziendeScrivibiliUtProp();
            for($azM=0; $azM<count($arrayAziendeUtPropMod); $azM++)
                if( !$this->findAzienda($arrayAziendeUtPropMod[$azM]->getIdAzienda(), $arrayAziendeVisibiliTot) )
                {
                    //Se l'azienda non è presente nell'elenco l'aggiungo all'array//////////
                    $arrayAziendeVisibiliTot[$indexArr]=$arrayAziendeUtPropMod[$azM];
                    $indexArr++;
                    ////////////////////////////////////////////////////////////////////////
                }

        }//arrayUtPropModificabili


        return $arrayAziendeVisibiliTot;

    }//getArrayAziendeVisibTabella


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Metodo che controlla negli array degli utenti proprietari
    //le aziende su cui si può srivere, quindi li dove si ha il permesso di tipo 2
    //e nel caso di questa classe li dove la variabile $isWritable è true
    public function getArrayAziendeScrivibTabella($idUtenteLoggato)
    {
        $arrayAziendeScrivibiliTot=array();
        $indexArr=0;

        if(count($this->arrayUtPropVisualizzabili)>0 &&  $this->isWritable)
            for($uV=0; $uV<count($this->arrayUtPropVisualizzabili); $uV++)
            {
                //Cerco tra gli utenti visibili l'utente loggato dato che
                //deve essere presente in quanto la variabile  $this->isWritable è true
                if($this->arrayUtPropVisualizzabili[$uV]->getIdUtente()==$idUtenteLoggato )
                    $arrayAziendeUtPropVis=$this->arrayUtPropVisualizzabili[$uV]->getArrayAziendeScrivibiliUtProp();

                for($azM=0; $azM<count($arrayAziendeUtPropVis); $azM++)
                    if( !$this->findAzienda($arrayAziendeUtPropVis[$azM]->getIdAzienda(), $arrayAziendeScrivibiliTot) )
                    {
                        //Se l'azienda non è presente nell'elenco l'aggiungo all'array//////////
                        $arrayAziendeScrivibiliTot[$indexArr]=$arrayAziendeUtPropVis[$azM];
                        $indexArr++;
                        ////////////////////////////////////////////////////////////////////////

                    }

            }//arrayUtPropVisualizzabili


         return $arrayAziendeScrivibiliTot;

    }//getArrayAziendeVisibTabella


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Metodo che controlla negli array degli utenti proprietari
    //le aziende su cui si può srivere e modificare i dati, quindi li dove
    //si ha il permesso di tipo 2 e di tipo 3 e nel caso di questa classe
    //li dove la variabile $isWritable è true e dove ci sono utPropModificabili
    public function getArrayAziendeScrivModifTabella($idUtenteLoggato)
    {
        $arrayAziendeScrivibiliModificTot=array();
        //@@ MODIFICA MARI 26 SETTEMBRE 2014
        $arrayAziendeUtPropVis=array();
        $indexArr=0;

        if( count($this->arrayUtPropVisualizzabili)>0 &&  $this->isWritable )
            for($uV=0; $uV<count($this->arrayUtPropVisualizzabili); $uV++)
            {
                //Cerco tra gli utenti visibili l'utente loggato dato che
                //deve essere presente in quanto la variabile  $this->isWritable è true
                if($this->arrayUtPropVisualizzabili[$uV]->getIdUtente()==$idUtenteLoggato )
                    $arrayAziendeUtPropVis=$this->arrayUtPropVisualizzabili[$uV]->getArrayAziendeScrivibiliUtProp();

                for($azM=0; $azM<count($arrayAziendeUtPropVis); $azM++)
                    if( !$this->findAzienda($arrayAziendeUtPropVis[$azM]->getIdAzienda(), $arrayAziendeScrivibiliModificTot) )
                    {
                        //Se l'azienda non è presente nell'elenco l'aggiungo all'array//////////
                        $arrayAziendeScrivibiliModificTot[$indexArr]=$arrayAziendeUtPropVis[$azM];
                        $indexArr++;
                        ////////////////////////////////////////////////////////////////////////
                    }

            }//arrayUtPropVisualizzabili


         if( count($this->arrayUtPropModificabili) > 0 )
            for( $uM=0; $uM<count($this->arrayUtPropModificabili); $uM++ )
            {
                //Cerco tra gli utenti visibili l'utente loggato dato che
                //deve essere presente in quanto la variabile  $this->isWritable è true

                $arrayAziendeUtPropMod = $this->arrayUtPropModificabili[$uM]->getArrayAziendeScrivibiliUtProp();

                for($azM=0; $azM<count($arrayAziendeUtPropMod); $azM++)
                    if( !$this->findAzienda($arrayAziendeUtPropMod[$azM]->getIdAzienda(), $arrayAziendeScrivibiliModificTot) )
                    {
                        //Se l'azienda non è presente nell'elenco l'aggiungo all'array//////////
                        $arrayAziendeScrivibiliModificTot[$indexArr]=$arrayAziendeUtPropMod[$azM];
                        $indexArr++;
                        ////////////////////////////////////////////////////////////////////////
                    }

            }//arrayUtPropModificabili

        return $arrayAziendeScrivibiliModificTot;

    }//getArrayAziendeVisibTabella


    //Metodo di utilità di supporto al precedente getArrayAziendeVisibTabella()
    //che controlla se l'id dell'azienda presa in input è gia presente nell'array
    //di aziende che si stà costruendo
    //Restituisce true se l'azienda è gia presente false altrimenti
    public function findAzienda($idAzienda, $arrayAziende)
    {
        if(count($arrayAziende)>0)
            for($i=0; $i<count($arrayAziende) ; $i++)
                if($arrayAziende[$i]->getIdAzienda() == $idAzienda)
                  return true;


        return false;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////





    //Metodo che fonde i due array di classe e restituisce tutti gli utenti prop visibli
    //senza ripetizioni
    public function getArrayAllVisibleUsers()
    {
        $arrayGeneraleUtentiPropVisibili=array();
        //Inserisco parte degli utenti già nell'array generale
        $arrayGeneraleUtentiPropVisibili = $this->arrayUtPropVisualizzabili;
        $indiceAdd=0;

        $arrUtPropModif = $this->arrayUtPropModificabili;

        $utentePresente=false;

        if(count($arrUtPropModif)>0)
            for($uV=0; $uV<count($this->arrayUtPropVisualizzabili); $uV++ )
            {
                for($uM=0; $uM<count( $arrUtPropModif); $uM++ )
                    if($this->arrayUtPropVisualizzabili[$uV]->getIdUtente() != $arrUtPropModif[$uM]->getIdUtente())
                        if($this->arrayUtPropVisualizzabili[$uV]->getNomeUtente() != $arrUtPropModif[$uM]->getNomeUtente())
                        {
                            $utentePresente=true;
                            $utenteAggiuntivo=$arrUtPropModif[$uM];
                        }

                //Se non ho trovato l'utente nel secondo array allora
                //lo posso aggiungere all'array generale
                if(!$utentePresente)
                {
                   $arrayGeneraleUtentiPropVisibili[$indiceAdd]=$this->arrayUtPropVisualizzabili[$uV];
                   $indiceAdd++;
                }

            }//for

        return $arrayGeneraleUtentiPropVisibili;


    }//getArrayAllVisibleUsers()



}//TabellaProprietari


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//new AGOSTO 2014
//Classe contenente per una azienda l'informazione:
//  - utenti proprietari che vi scrivono
class UtenteProprietario extends Utente
{
    //Array contenente oggetti di tipo Azienda che corrispondono alle
    //aziende su cui l'utente proprietario può scrivere
    private $arrayAziendeScrittura=array();


    function __construct( $idUt, $nUt, $cognUt, $usrUt, $azAppart, $arrAzScri, $visibilita)
    {

        $this->setUtente($idUt, $nUt,$cognUt, $usrUt, $azAppart,$visibilita);
        $this->arrayAziendeScrittura=$arrAzScri;
        

    }

    public function setArrayAziendeScrivibiliUtProp($arrAzScri){ $this->arrayAziendeScrittura=$arrAzScri; }
    public function getArrayAziendeScrivibiliUtProp(){ return $this->arrayAziendeScrittura; }


    //Metodo che restituisce true se l'azienda in input è presente false altrimenti
    /*public function findAzienda($nomeAzienda)
    {
        for($i=0; $i<count($this->arrayAziendeScrittura); $i++)
           if( $this->arrayAziendeScrittura->getNomeAzienda() == $nomeAzienda)
                return true;

        return false;
    }*/
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Classe contenente un utente ed associato ad esso un elenco di tabelle
//ad onguna associato un insieme di utenti proprietari
class PermessiVisualizzazione extends Utente
{
    ######
    //Le informazioni dell'utente sono contenute in Utente utilizzate
    //tramite l'ereditarietà delle classi
    ######

    private $arrayTabelleProprietari=array();
    private $indexArray;


    //Array contenente le funzioni visibili all'utente loggato
    private $arrayFunzioni;


    function __construct( $idUt, $nUt, $cognUt, $usrUt, $objAz,$visibilita )
    {
        $this->setUtente($idUt, $nUt, $cognUt, $usrUt, $objAz,$visibilita);
        $this->indexArray=0;
        
    }



    //Old comment:
    //Metodo che supportato dalla classe TabellaProprietari, memorizza nell'array  $elencoTabelleProprietari
    //una tabella e ad essa associata un elenco di utenti
    //Ad ogni inserimento l'indice dell'array viene incrementato
    //OLD_   public  function addTabellaUtenti($idTabella, $nomeTabella, $utentiProprietari)
    //Aggiornamento: la variabile che indica la scrittura $isEdit è stata rinominata in $isWrit mentre
    //               la variabile $isEdit indica se la tabella è o meno modificabile
    //
    // //MODIFICATO AGOSTO 2014:
    //
    public  function addTabellaUtenti($idTabella, $nomeTabella, $arrUtPropVis,$arrUtPropMod,  $isWrit /*, old: $arrayAziende, $isEdit*/ )
    {
        //OLD:  $this->arrayTabelleProprietari[$this->indexArray]=new TabellaProprietari( $idTabella, $nomeTabella, $utentiProprietari );
        $this->arrayTabelleProprietari[$this->indexArray]=new TabellaProprietari( $idTabella, $nomeTabella, $arrUtPropVis, $arrUtPropMod,  $isWrit /*old: ,$arrayAziende,  $isEdit, */  );
        $this->indexArray++;
    }

    ##########GESTIONE FUNZIONI########################################################################

    //Metodi di set e get dell'array delle funzioni visibili all'utente
    public function setArrayFunzioniVisibili($arrayFunz){   $this->arrayFunzioni = $arrayFunz;  }
    public function getArrayFunzioniVisibili(){  return $this->arrayFunzioni;  }
    //Metodo che restituisce per una azienda le funzioni visibili
    public function getFunzioniVisibiliAzienda($idAzienda)
    {
        $arrayFunzioniPerAz = array();
        $indexArrFunz = 0;

        ###
        //Se trovo l'azienda all'interno del permesso assemblo
        //un nuovo oggetto Funzione contenente l'id ed il nome della funzione
        //L'array sarà composto di sole funzioni contenenti l'id dell'azienda in input
        ###


        for($f=0; $f<count($this->arrayFunzioni); $f++)
        {
            $arrayAziendeFunz = $this->arrayFunzioni[$f]->getArrayAziende();
            for($az=0; $az<count($arrayAziendeFunz); $az++)
                if($arrayAziendeFunz[$az]->getIdAzienda() == $idAzienda)
                {
                    $arrayFunzioniPerAz[$indexArrFunz]=new Funzione($this->arrayFunzioni[$f]->getIdFunzione(), $this->arrayFunzioni[$f]->getNomeFunzione() );
                    $indexArrFunz++;
                }
        }

        return $arrayFunzioniPerAz;

    }
    //Metodo che restituisce per una funzione le aziende visibili
    public function getAziendeVisibiliFunzione($idFunzione)
    {
        for($f=0; $f<count($this->arrayFunzioni); $f++)
            if($this->arrayFunzioni[$f]->getIdFunzione()== $idFunzione)
                return $this->arrayFunzioni[$f]->getArrayAziende();

        //Restituisce un array vuoto
        return array();
    }

    public function functionIsAllowed($idFunzione)
    {
        for($f=0; $f<count($this->arrayFunzioni); $f++)
            if($this->arrayFunzioni[$f]->getIdFunzione()== $idFunzione)
                return true;


        return false;
    }
    ###################################################################################################

    //Metodo che restituisce l'array di tabelle con utenti proprietari associati
    //L'array restituito conterrà oggetti di tipo TabellaProprietari
    public function getArrayTabelleProprietari()
    {
        return $this->arrayTabelleProprietari;
    }

    //Metodo che riceve il nome della tabella e restituisce un
    //array contenente l'insieme della aziende visibili per quella tabella
    //Il tutto riferito riferito all'utente possessore del permesso
    //Il metodo elabora i dati scorrendo le tabelle visibili e per ogni
    //tabella va a prendere gli utenti visualizzabili e di li le aziende
    //
    //Si intende aziende visibili quelle aziende appartenenti a permessi >=1
    //quindi ovunque si abbia un permesso di visualizzazione e/o di scrittura e/o di modifica
    //
    public function getAziendeVisibiliPerTabella($nomeTabella)
    {
        $arrayVuoto=array();

        if(isset($this->arrayTabelleProprietari))
            for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
               if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                  return $this->arrayTabelleProprietari[$i]->getArrayAziendeVisibTabella();

//        echo "PROBLEMA: array vuoto";
        return $arrayVuoto;
    }


    //Metodo che riceve un valore contenetne il nome della tabella e dovrà restituire un
    //array contenente l'insieme della aziende scrivibili per quella tabella
    //Il tutto riferito riferito all'utente possessore del permesso
    public function getAziendeScrivibiliPerTabella($nomeTabella)
    {
        $arrayVuoto=array();

        if(isset($this->arrayTabelleProprietari))
            for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
                if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                    if( count($this->arrayTabelleProprietari[$i]->getArrayAziendeScrivibTabella($this->getIdUtente()))>0 )
                        return $this->arrayTabelleProprietari[$i]->getArrayAziendeScrivibTabella($this->getIdUtente());

//        echo "PROBLEMA: array vuoto ";
        return $arrayVuoto;
    }



    //Metodo che riceve un valore contenetne il nome della tabella e dovrà restituire un
    //array contenente l'insieme della aziende scrivibili e modificabili per quella tabella
    //Il tutto riferito riferito all'utente possessore del permesso
    public function getAziendeScrivModifPerTabella($nomeTabella)
    {
        $arrayVuoto=array();

        if(isset($this->arrayTabelleProprietari))
            for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
                if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                    if( count($this->arrayTabelleProprietari[$i]->getArrayAziendeScrivModifTabella($this->getIdUtente()))>0 )
                        return $this->arrayTabelleProprietari[$i]->getArrayAziendeScrivModifTabella($this->getIdUtente());

//        echo "PROBLEMA: array vuoto ";
        return $arrayVuoto;
    }


    //ATTENZIONE!!! metodo eliminato perchè gia presente. Verificare se si può eliminare
    //Metodo che restiuisce per l'utente loggato
    //le aziende su cui l'utente può scrivere
    //L'array sarà di oggetti di tipo Azienda quindi contenti sia l'id che il nome Azienda
   /* public function getArrayAziendeScrivibili()
    {

        //Scorro gli utenti proprietari e se l'utente loggatto è proprietario
        //vado a recuperare le aziende su cui può scrivere
        if(count($this->getUtentiProprietariVisualizzabili())>0)
        for($i=0; $i<count($this->getUtentiProprietariVisualizzabili()); $i++)
            if($this->getUtentiProprietariVisualizzabili()[$i]->getIdUtente()==$this->getIdUtente())
               return $this->getUtentiProprietariVisualizzabili()[$i]->getArrayAziendeScrivibili();


        return array();
   }*/



    //MODIFICA AGOSTO 14
    //Metodo che riceve un valore contenetne il nome dell'azienda e dovrà restituisre un
    //array contenente l'insieme delle tabelle visibili per quella azienda
    //Il tutto riferito riferito all'utente possessore del permesso
    //Metodo che lavora in questo modo:
    //    - prendo in input il nomeDell'azienda $nomeAzienda
    //    - creo arrayDiTabelle
    //    - scorro array di tabelle visibili all'utente
    //           - scorro array di utenti prop per tabella
    //           - uso metodo della classe UtenteProprietario per trovare l'azieda inserita
    //                   - se l'azienda(i) == $nomeAzienda aggiungo la tabella all'array
    //
    //    - restituisco un array contenente le tabelle visibili per quell'azienda dall'utente possessore del permesso
    public function getTabellePerAzienda($nomeAzienda)
    {

        $arrayTabelle=array();
        $indexAdd=0;

        if(isset($this->arrayTabelleProprietari))
            for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
            {
                $idTabellaCorrente=$this->arrayTabelleProprietari[$i]->getIdTabella();
                $nomeTabellaCorrente=$this->arrayTabelleProprietari[$i]->getNomeTabella();

                $utentiPropVisib=array();
                $utentiPropVisib=$this->arrayTabelleProprietari[$i]->getArrayUtentiPropVisib();

                $utentiPropModif=array();
                $utentiPropModif=$this->arrayTabelleProprietari[$i]-> getArrayUtentiPropModif();




                //Scorro gli utenti proprietari visibili per verificare l'azienda
                for($uV=0; $uV<count($utentiPropVisib); $uV++)
                {
                    if($utentiPropVisib[$uV]->findAzienda($nomeAzienda))
                    {
                        $arrayTabelle[$indexAdd]=new Tabella($idTabellaCorrente,$nomeTabellaCorrente );
                        $indexAdd++;
                    }

                }

                //Scorro gli utenti proprietari modificabili per verificare l'azienda
                for($uM=0; $uM<count($utentiPropModif); $uM++)
                {
                    if($utentiPropVisib[$uM]->findAzienda($nomeAzienda))
                    {
                        $arrayTabelle[$indexAdd]=new Tabella($idTabellaCorrente,$nomeTabellaCorrente );
                        $indexAdd++;
                    }

                }
            }


        return $arrayTabelle;
    }



    //Metodo che riceve un valore contenetne il nome della tabella e di questa dovrà restituisre un
    //array contenente l'insieme degli utenti proprietari di cui l'utente potrà visualizzare i dati
    public function getUtentiPerTabella($nomeTabella)
    {
        if(isset($this->arrayTabelleProprietari))
            for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
            {
                if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                    return $this->arrayTabelleProprietari[$i]->getArrayUtentiPropVisib();
            }

        $arrayVuoto=array();
        return $arrayVuoto;
    }

    //Metodo che restituisce l'elenco delle tabelle che l'utente può visualizzare
    public function getElencoTabelle()
    {

        $arrayDiTabelle=array();

        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
            $arrayDiTabelle[$i]=$this->arrayTabelleProprietari[$i]->getNomeTabella();


        return $arrayDiTabelle;
    }


    //TEMPORANEAMENTE SCARTATO:
    //OLD:::::::::
    //NEW AGOSTO 14:
    // Metodo che restituisce una stringa contenente gli utenti proprietari e le aziende su cui scrivono
    // in un formato del tipo:
    //“(ut_prop=4 AND azienda=1)  OR
    // (ut_prop=1 AND azienda=3)  OR
    // (ut_prop=5 AND azienda=1)
    //
    // che riguardano, per l'utente loggato, gli utenti proprietari visibili e
    // a loro volta le aziende sulle quali scrivono
    /*public function getMySqlStringUtentiAziende( $nomeTabella )
    {
        //Prende in input il nome della tabella ed in base a questo
        //elabora una stringa compatibile con sql contenente dei vincoli sui dati
        //con la relazione tra utente proprietari e azienda di scrittura

        $arrayTabelleProprietari = $this->arrayTabelleProprietari;

        //Variabile che conterrà la stringa che verrà inserita all'interno delle
        //query sql
        $stringaUtentiAziende="";


        //Recupero la prima lettera della tabella in modo da poterla inserire come
        //alias della tabella della query
        $primaLetteraTab=$nomeTabella[0];

        $arrayGenUtPropVisib = $this -> getArrayAllVisibleUsersTable($nomeTabella);

        //Scorro array utenti visibili e recupero l'associazione per ogni utente proprietario
        //delle tabelle su cui scrivono
        //
        //Scorro array di oggetti di tipo UtenteProprietario
        for( $uV=0; $uV<count($arrayGenUtPropVisib); $uV++ )
        {
            $idUtentProp = $arrayGenUtPropVisib[$uV]->getIdUtente();
            $arrayAzScrivib = $arrayGenUtPropVisib[$uV]->getArrayAziendeScrivibiliUtProp();

            //Scorro aziende scrivibili
            //In questa fase strutturo l'associazione utente prop  - azienda scrivibile

            for($az=0; $az<count($arrayAzScrivib); $az++)
            {
                $idAzienda = $arrayAzScrivib[$az]->getIdAzienda();

                $stringaUtentiAziende = $stringaUtentiAziende."(".$primaLetteraTab.".id_utente=".$idUtentProp." AND ".$primaLetteraTab.".id_azienda=".$idAzienda.")";

                if($uV==(count($arrayGenUtPropVisib)-1) && $az==(count($arrayAzScrivib)-1) )
                    $stringaUtentiAziende=$stringaUtentiAziende;  //Ultima stampa senza OR finale
                else
                    $stringaUtentiAziende=$stringaUtentiAziende." OR ";  //Stampa interna


                //  La stringa conterrà il seguente codice:
                //   “(ut_prop=4 AND azienda=1)  OR
                //   (ut_prop=1 AND azienda=3)  OR
                //   (ut_prop=5 AND azienda=1) “.

            }//for 2

        }//for 1


        //Stampo stringa che ho composto
        print_r($stringaUtentiAziende);


        return $stringaUtentiAziende;

    }*/

public function getMySqlStringUtentiAziende( $nomeTabella )
    {
        //Prende in input il nome della tabella ed in base a questo
        //elabora una stringa compatibile con sql contenente dei vincoli sui dati
        //con la relazione tra utente proprietari visibili e azienda di scrittura

        $arrayTabelleProprietari = $this->arrayTabelleProprietari;

        //Variabile che conterrà la stringa che verrà inserita all'interno delle
        //query sql
        $stringaUtentiAziende="(";


        $arrayGenUtPropVisib = $this -> getArrayAllVisibleUsersTable($nomeTabella);
        
        //Controllo di prevenzione per i valori nulli con stringa di default ((-1,-1))
        if( count($arrayGenUtPropVisib)>0 )
        {

            //Scorro array utenti visibili e recupero l'associazione per ogni utente proprietario
            //delle tabelle su cui scrivono
            //
            //Scorro array di oggetti di tipo UtenteProprietario
            for( $uV=0; $uV<count($arrayGenUtPropVisib); $uV++ )
            {
                $idUtentProp = $arrayGenUtPropVisib[$uV]->getIdUtente();
                $arrayAzScrivib = $arrayGenUtPropVisib[$uV]->getArrayAziendeScrivibiliUtProp();
                
                //Controllo di prevenzione per i valori nulli con stringa di default ((-1,-1))
                if( count($arrayAzScrivib)>0 )
                {
                    
                    //Scorro aziende scrivibili
                    //In questa fase strutturo l'associazione utente prop  - azienda scrivibile
                    for($az=0; $az<count($arrayAzScrivib); $az++)
                    {
                        $idAzienda = $arrayAzScrivib[$az]->getIdAzienda();

                        $stringaUtentiAziende = $stringaUtentiAziende."(".$idUtentProp.",".$idAzienda.")";

                        if($uV==(count($arrayGenUtPropVisib)-1) && $az==(count($arrayAzScrivib)-1) )
                            $stringaUtentiAziende=$stringaUtentiAziende.")";  //Ultima stampa senza virgola finale ma con parentesi
                        else
                            $stringaUtentiAziende=$stringaUtentiAziende.",";  //Stampa interna


                        //  La stringa conterrà il seguente codice:
                        //   “(ut_prop=4 AND azienda=1)  OR
                        //   (ut_prop=1 AND azienda=3)  OR
                        //   (ut_prop=5 AND azienda=1) “.

                    }//for 2

                }
                else
                    return "((-1,-1))";

            }//for 1

        }
        else
            return "((-1,-1))";

        //Stampo stringa che ho composto
//        print_r($stringaUtentiAziende);


        return $stringaUtentiAziende;

    }
    //NEW SETTEMBRE 14:
    // Metodo che restituisce una matrice contenente gli utenti proprietari e le aziende su cui scrivono
    // in un formato del tipo:
    //	((4,1),(5,3))
    // in per l'utente loggato vengono elencati gli utenti proprietari visibilivi
    // e a loro volta le aziende sulle quali scrivono,
    // quindi l'utente 4 scrive sull'azienda 1, e l'utente 5 sulla tabella 3
    //
    public function getMySqlStringUtentiAziendeOld( $nomeTabella )
    {
        //Prende in input il nome della tabella ed in base a questo
        //elabora una stringa compatibile con sql contenente dei vincoli sui dati
        //con la relazione tra utente proprietari visibili e azienda di scrittura

        $arrayTabelleProprietari = $this->arrayTabelleProprietari;

        //Variabile che conterrà la stringa che verrà inserita all'interno delle
        //query sql
        $stringaUtentiAziende="(";

        $arrayGenUtPropVisib = $this -> getArrayAllVisibleUsersTable($nomeTabella);

        //Scorro array utenti visibili e recupero l'associazione per ogni utente proprietario
        //delle tabelle su cui scrivono
        //
        //Scorro array di oggetti di tipo UtenteProprietario
        for( $uV=0; $uV<count($arrayGenUtPropVisib); $uV++ )
        {
            $idUtentProp = $arrayGenUtPropVisib[$uV]->getIdUtente();
            $arrayAzScrivib = $arrayGenUtPropVisib[$uV]->getArrayAziendeScrivibiliUtProp();

            //Scorro aziende scrivibili
            //In questa fase strutturo l'associazione utente prop  - azienda scrivibile

            for($az=0; $az<count($arrayAzScrivib); $az++)
            {
                $idAzienda = $arrayAzScrivib[$az]->getIdAzienda();

                $stringaUtentiAziende = $stringaUtentiAziende."(".$idUtentProp.",".$idAzienda.")";

                if($uV==(count($arrayGenUtPropVisib)-1) && $az==(count($arrayAzScrivib)-1) )
                    $stringaUtentiAziende=$stringaUtentiAziende.")";  //Ultima stampa senza virgola finale ma con parentesi
                else
                    $stringaUtentiAziende=$stringaUtentiAziende.",";  //Stampa interna


                //  La stringa conterrà il seguente codice:
                //   “(ut_prop=4 AND azienda=1)  OR
                //   (ut_prop=1 AND azienda=3)  OR
                //   (ut_prop=5 AND azienda=1) “.

            }//for 2

        }//for 1


        //Stampo stringa che ho composto
//        print_r($stringaUtentiAziende);


        return $stringaUtentiAziende;

    }


    //Metodo che prende in input un nomeTabella
    //e per questa tabella restituisce l'elenco degli utenti proprietari visibili
    //in formato utilizzabile in query mysql
    public function getMysqlStringUtentiProprietariPerTabella($nomeTabella)
    {
        $arrayUtentiPropTabella=array();
        $arrayUtentiPropTabella=$this->getUtentiPerTabella($nomeTabella);

        $stringaIdUtenti='(';

        for($i=0; $i<count($arrayUtentiPropTabella); $i++)
        {
            $utentePropCorrente=$arrayUtentiPropTabella[$i];

            $idUtente= $utentePropCorrente->getIdUtente();
            $nomeUtente= $utentePropCorrente->getNomeUtente();
            $visibilitaTab=$utentePropCorrente->getVisibilita();
            
            $stringaIdUtenti=$stringaIdUtenti.$idUtente;

            if($i< (count($arrayUtentiPropTabella)-1))
                $stringaIdUtenti=$stringaIdUtenti.',';


        }
        $stringaIdUtenti=$stringaIdUtenti.')';

        return $stringaIdUtenti;
    }

   /* //Metodo che riceve un valore contenetne il nome della tabella e dovrà restituisre un
    //array contenente l'insieme della aziende visibili per quella tabella
    //Il tutto riferito riferito all'utente possessore del permesso
    public function getAziendePerTabella($nomeTabella)
    {

        if(isset($this->arrayTabelleProprietari))
            for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
                if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                    return $this->arrayTabelleProprietari[$i]->getArrayAziendeVisibTabella();


        $arrayVuoto=array();
        return $arrayVuoto;
    }
*/


    //METODO AGGIORNATO AGOSTO 14:
    //Metodo che prende in input un nomeTabella
    //e per questa tabella restituisce l'elenco degli aziende in formato utilizzabile in query ysql
    public function getMysqlStringAziendePerTabella($nomeTabella)
    {

        //controllare se funzionante

        $arrayAziendeTabella=array();
        $arrayAziendeTabella=$this->getAziendeVisibiliPerTabella($nomeTabella);


        $stringaIdAziende='(';

        for($i=0; $i<count($arrayAziendeTabella); $i++)
        {
            $aziendaCorrente=$arrayAziendeTabella[$i];

            $idAzienda= $aziendaCorrente->getIdAzienda();
            $nomeAzienda= $aziendaCorrente->getNomeAzienda();

            $stringaIdAziende=$stringaIdAziende.$idAzienda;


            if($i< (count($arrayAziendeTabella)-1))
                $stringaIdAziende=$stringaIdAziende.',';


        }//for

        $stringaIdAziende=$stringaIdAziende.')';


       // echo "getMysqlStringAziendePerTabella2: stringa: ".$stringaIdAziende;

        return $stringaIdAziende;
    }


    //AGGIORNATO AGOSTO 14:
    //Metodo che restituisce gli utenti proprietari che l'utente loggato può vedere
    //Ciò non per una sola tabella ma per tutte le tabelle
    public function getUtentiProprietariVisualizzabili()
    {
        $arrayUtentiProprietari=array();
        $indexInsert=0;

        //Scorro array di oggetti TabellaProprietari
        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
        {
            //Assegno ad una variabile l'array di utenti proprietari visualizzabili
            //per la tabella i-esima dell'array arrayTabelleProprietari
            $arrayUtProprVisTabella=$this->arrayTabelleProprietari[$i]->getArrayAllVisibleUsers();  //old  getArrayUtenti();


            //Scorro l'elenco degli utenti proprietari per tabella ed ogni utente lo andrò a sommare all'array
            //L'elemento j-esimo è un oggetto di tipo Utente
            for($uV=0; $uV<count($arrayUtProprVisTabella); $uV++)
            {

             //   echo "getUtentiProprietariVisualizzabili dentro dentro: idUt: ".$arrayUtProprVisTabella[$uV]->getObjAzienda()."<br>";

                //AGOSTO 2014: Aggiunta info Azienda per l'Utente proprietario
              //OLD:  $utenteProprietario=new UtenteProprietario($arrayUtProprVisTabella[$uV]->getIdUtente(), $arrayUtProprVisTabella[$uV]->getNomeUtente(), $arrayUtProprVisTabella[$uV]->getObjAziendaAppartenenza(), $arrayUtProprVisTabella[$uV]->getObjAzienda());
                $arrayUtentiProprietari[$indexInsert]=$arrayUtProprVisTabella[$uV];//OLD: $utenteProprietario
                $indexInsert++;


            }



            ###Nuovo blocco AGOSTO 14:#######################
            //Assegno ad una variabile l'array di utenti proprietari modificabili e quindi anche visualizzabili
            //per la tabella i-esima dell'array arrayTabelleProprietari
            $arrayUtProprModifTabella=$this->arrayTabelleProprietari[$i]->getArrayUtentiPropModif();  //old  getArrayUtenti();

            //Scorro l'elenco degli utenti proprietari per tabella ed ogni utente lo andrò a sommare all'array
            //L'elemento j-esimo è un oggetto di tipo Utente
            for($uM=0; $uM<count($arrayUtProprModifTabella); $uM++)
            {
                //AGOSTO 2014: Aggiunta info Azienda per l'Utente proprietario
                //OLD: $utenteProprietario=new UtenteProprietario($arrayUtProprModifTabella[$uM]->getIdUtente(), $arrayUtProprModifTabella[$uM]->getNomeUtente(),$arrayUtProprModifTabella[$uM]->getObjAziendaAppartenenza(), $arrayUtProprModifTabella[$uM]->getObjAzienda());
                $arrayUtentiProprietari[$indexInsert]=$arrayUtProprModifTabella[$uM];//OLD: $utenteProprietario;
                $indexInsert++;
            }
            ###########################################

        }//for



        return $arrayUtentiProprietari;

    }

    //Funzione che, data una tabella, controlla se l'utente loggato
    //ha un permesso diverso dalla scrittura e dalla modifica quindi
    //se ha solo un permesso di tipo 1, di visualizzazione
    //Restituirà true se possiede il permesso e false altrimenti
   /* public function permessoVisualizzazione($nomeTabella)
    {
        $arrayTabelle=array();
        $arrayTabelle=$this->getElencoTabelle();

        //Scorro l'elenco delle tabelle visibili all'utente
        for($i=0; $i<count($arrayTabelle); $i++)
        {
            //Se la tabella è nella lista di tabelle generali e
            //se sulla tabella si ha il permesso di visualizzazione ma
            //non si ha quello di scrittura e quello di modifica
            //allora restituisco true
            if($arrayTabelle[$i] == $nomeTabella)
                if($this->tableIsViewable($nomeTabella) && !$this->tableIsWritable($nomeTabella) && !$this->tableIsEditable($nomeTabella,$this->getNomeUtente() ) )
                    return true;


        }

        return false;
    }*/



    //Metodo che controlla se una tabella è tra le tabelle visualizzabili dall'utente
    //Metodo booleano restituisce true se la tabella è visibile e false altrimenti
    public function tableIsViewable($nomeTabella)
    {
        $arrayTabelle=array();
        $arrayTabelle=$this->getElencoTabelle();

        //Scorro l'elenco delle tabelle visibili all'utente
        for($i=0; $i<count($arrayTabelle); $i++)
        {
            //Se la tabella è nell'elenco restituisco true
            //e l'utente potrà visualizzarla
            if($nomeTabella==$arrayTabelle[$i])
                return true;
        }

        //Caso in cui l'utente non ha il diritto di visualizzare la tabella
        return false;
    }

    //Metodo che restituisce true o false a seconda se l'utente ha il
    //permesso di scrittura o meno su una data tabella
    public function tableIsWritable($nomeTabella)
    {

        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
        {
            if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                if($this->arrayTabelleProprietari[$i]->tableIsWritable())
                    return true;

        }

        //Caso in cui l'utente non ha il diritto di scrittura sulla tabella
        return false;

    }
    
    //Metodo che restituisce true o false a seconda se l'utente ha il
    //permesso di modifica su una data tabella e su un dato utente proprietario per una data azienda
    public function tableIsEditable($nomeTabella, $utenteProprietario, $idAzienda)
    {

        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
        {
            if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                if($this->arrayTabelleProprietari[$i]->tableIsEditable())
                {
                    //Recupero l'array dei proprietari dei quali si può visualizzare i dati
                    $arrayUtPropMod=array();
                    $arrayUtPropMod=$this->arrayTabelleProprietari[$i]->getArrayUtentiPropModif();

                    //!!!!!!!! sistemare qui non trova l'oggetto '$arrayUtPropMod[$j] come oggetto di tipo utente



                    //Se l'array non è nullo e ha almeno un valore al suo interno
                    //lo scorro e verifico che c'è l'utente proprietario preso in input
                    //e se scrive per l'azienda presa in input
                    if(isset($arrayUtPropMod) && count($arrayUtPropMod)>0 )
                        for($j=0; $j<count($arrayUtPropMod); $j++)
                        {
                            $arrayAzScrivibPerTabella = $arrayUtPropMod[$j]->getArrayAziendeScrivibiliUtProp();

                            for( $az=0; $az<count($arrayAzScrivibPerTabella); $az++ )
                                if($arrayUtPropMod[$j]->getIdUtente()==$utenteProprietario &&
                                   $arrayAzScrivibPerTabella[$az]->getIdAzienda() == $idAzienda )
                                     return true;



                        }
                }//if tableIsEditable


        }// for array tabelle proprietari

        //Caso in cui l'utente non ha il diritto di modifica sulla tabella
        //per i dati dell'utente proprietario
        return false;

    }//tableIsEditable
    
    //Metodo che restituisce true o false a seconda se l'utente ha il
    //permesso di modifica su una data tabella e su un dato utente proprietario
    public function tableIsEditableOld($nomeTabella, $utenteProprietario)
    {
        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
        {

            if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                if($this->arrayTabelleProprietari[$i]->tableIsEditable())
                {
                    //Recupero l'array dei proprietari dei quali si può visualizzare i dati
                    $arrayUtPropMod=array();
                    $arrayUtPropMod=$this->arrayTabelleProprietari[$i]->getArrayUtentiPropModif();

                    //!!!!!!!! sistemare qui non trova l'oggetto '$arrayUtPropMod[$j] come oggetto di tipo utente



                    //Se l'array non è nullo e ha almeno un valore al suo interno
                    //lo scorro e verifico che c'è l'utente proprietario preso in imput
                    if(isset($arrayUtPropMod) && count($arrayUtPropMod)>0 )
                        for($j=0; $j<count($arrayUtPropMod); $j++)
                        {
                            if($arrayUtPropMod[$j]->getIdUtente()==$utenteProprietario)
                                return true;

                        }
                }//if tableIsEditable


        }// for array tabelle proprietari

        //Caso in cui l'utente non ha il diritto di modifica sulla tabella
        //per i dati dell'utente proprietario
        return false;

    }//tableIsEditable

    //Metodo che restituisce tutti gli utenti proprietari visibili per una determinata tabella
    //Utilizza il metodo analogo getArrayAllVisibleUsers() della classe TabellaProprietari
    //che restituisce l'array di utenti proprietari visibili per la tabella selezionata
    public function getArrayAllVisibleUsersTable($nomeTabella)
    {

         for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
            if($this->arrayTabelleProprietari[$i]->getNomeTabella()==$nomeTabella)
                return $this->arrayTabelleProprietari[$i]->getArrayAllVisibleUsers();



    }

    //Metodo che restituisce per l'utente loggato le aziende su cui può scrivere
    //Quindi si recuperano le tabelle in cui ha il permesso di scrittura e d li le
    //aziende presenti
    public function getArrayAziendeScrivibili()
    {
        $arrayAziendeScrivibili = array();
        $index=0;

        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
            if( $this->arrayTabelleProprietari[$i]->tableIsWritable() )
            {
                $arrayUtPropVisibili = $this->arrayTabelleProprietari[$i]->getArrayUtentiPropVisib();

                if(count($arrayUtPropVisibili)>0)
                     for($j=0; $j<count($arrayUtPropVisibili); $j++)
                       if($arrayUtPropVisibili[$j]->getIdUtente()==$this->getIdUtente())
                           for($az=0; $az<count($arrayUtPropVisibili[$j]->getArrayAziendeScrivibiliUtProp()); $az++)
                           {
                               $arrAzScrivibili = $arrayUtPropVisibili[$j]->getArrayAziendeScrivibiliUtProp();
                               $nuovaAzienda = $arrAzScrivibili[$az];
                               if(!$this->arrayTabelleProprietari[$i]->findAzienda($nuovaAzienda->getIdAzienda(), $arrayAziendeScrivibili))
                               {
                                   $arrayAziendeScrivibili[$index] = $nuovaAzienda;
                                   $index++;
                               }
                           }


            }


        return $arrayAziendeScrivibili;


    }





    //Metodo che restituisce l'array delle aziende editabili per l'utente loggato
    //Si scorrono le tabelle visualizzabili e si memorizzano solamente quelle
    //in cui l'elemente tableIsWritable è a true
    public function getTabelleEditabili()
    {
        //Array in cui memorizzo le tabelle su cui posso scrivere
        //Una volta che la tabella è di tipo writable salvo nell'array tutto
        //l'oggetto di tipo TabelleProprietari in modo da poter andare a recuperare
        //tutte le informazioni a disposizione per la tabella
        $arrayTabScrivibili=array();
        $index=0;

        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
            if($this->arrayTabelleProprietari[$i]->tableIsWritable())
            {
                $arrayTabScrivibili[$index]=$this->arrayTabelleProprietari[$i];
                $index++;
            }


        return $arrayTabScrivibili;
    }


    //Funzione che stampa i permessi di visualizzazione per l'utente
    //Stampa tutti i permessi per l'utente loggato con questa struttura:
    // - UTENTE LOGGATO:
    //       °°° TABELLA Visibile 1 [Scrivibile]
    //              #UTENTE PROPRIETARIO Visibile 1-n
    //              @AZIENDA Visibile  1-n
    //       °°° TABELLA Visibile n [Scrivibile]
    //              #UTENTE PROPRIETARIO Visibile 1-n
    //              @AZIENDA Visibile  1-n

    //  AZIENDE su cui scrive Ut.Loggato
    //
    ////////////////////////////////////////////////////////////////
    public function printPermessi()
    {
        echo "<br>";
        echo "<br>";
        echo "Stampo permessi di visualizzazione per l'utente loggato: ";
        echo "<br>";
        echo "<br>";

        echo "ID Utente: ".$this->getIdUtente();
        echo "<br>";
        echo "Nome Utente: ".$this->getNomeUtente();
        echo "<br>";
        echo "Cognome Utente: ".$this->getCognomeUtente();
        echo "<br>";
        echo "Username Utente: ".$this->getUsernameUtente();
        echo "<br>";
        echo "<br>";

        for($i=0; $i<count($this->arrayTabelleProprietari); $i++)
        {
            echo "#########################################################################";
            echo "<br>";
            echo "Tabella: ".$this->arrayTabelleProprietari[$i]->getNomeTabella();
            if($this->arrayTabelleProprietari[$i]->tableIsWritable())
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."--Scrivibile--";
            echo "<br>";
            echo "<br>";
            echo "UtentiProprietari Visibili: ";
            echo "<br>";

            $arrayUtentiPerTabella=$this->arrayTabelleProprietari[$i]->getArrayUtentiPropVisib();
            for($j=0; $j<count($arrayUtentiPerTabella); $j++)
            {
                echo "&nbsp;&nbsp;".$arrayUtentiPerTabella[$j]->getIdUtente();
                echo "&nbsp;".$arrayUtentiPerTabella[$j]->getUsernameUtente();
                echo "<br>";

                echo "&nbsp; Aziende:";
                $aziendeScrivibUtProp = $arrayUtentiPerTabella[$j]->getArrayAziendeScrivibiliUtProp();
                if(isset($aziendeScrivibUtProp))
                    for($a=0; $a<count($aziendeScrivibUtProp); $a++)
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;".$aziendeScrivibUtProp[$a]->getNomeAzienda();

                echo "<br>";
            }

            $arrayUtentiModifPerTabella=$this->arrayTabelleProprietari[$i]-> getArrayUtentiPropModif();
            if(count($arrayUtentiModifPerTabella)>0)
            {
                echo "<br>";
                echo "UtentiProprietari Modificabili: ";
                echo "<br>";


                for($j=0; $j<count($arrayUtentiModifPerTabella); $j++)
                {
                    echo "&nbsp;&nbsp;".$arrayUtentiModifPerTabella[$j]->getIdUtente();
                    echo "&nbsp;".$arrayUtentiModifPerTabella[$j]->getUsernameUtente();
                    echo "<br>";

                    echo "&nbsp; Aziende:";
                    $aziendeScrivibUtPropMod = $arrayUtentiModifPerTabella[$j]->getArrayAziendeScrivibiliUtProp();
                    if(isset($aziendeScrivibUtPropMod))
                        for($a=0; $a<count($aziendeScrivibUtPropMod); $a++)
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;".$aziendeScrivibUtPropMod[$a]->getNomeAzienda();

                    echo "<br>";
                }
            }




            echo "#########################################################################";
            echo "<br>";
            echo "<br>";

        }//for


        if( count($this->getArrayAziendeScrivibili())>0 )
        {
            echo "<br>";
            echo "<br>";
            echo ":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::"."<br>";
            echo "Array di aziende su cui scrive l'utente loggato: ";
            echo "<br>";
            echo "<br>";


            for($t=0; $t<count($this->getArrayAziendeScrivibili()); $t++)
            {
                $arrAzScrivibili = $this->getArrayAziendeScrivibili();
                echo "&nbsp;&nbsp;&nbsp;&nbsp;-> ".$arrAzScrivibili[$t]->getNomeAzienda()."<br>";
            }


            echo ":::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::";
            echo "<br>";
            echo "<br>";
        }



        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
    }




}//PermessiVisualizzazione



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class Funzione
{
    private $idFunzione;
    private $nomeFunzione;

    //Aziende visibili per una funzione
    //Per esempio la funzione 1 potrà essere vista dall'azieda 2 e/o 3
    private $arrayAziende;


    function __construct($idFunz=null, $nomeFunz=null, $arrAz=null)
    {
        $this->idFunzione = $idFunz;
        $this->nomeFunzione = $nomeFunz;
        $this->arrayAziende = $arrAz;
    }


    public function getIdFunzione(){  return  $this->idFunzione;  }
    public function getNomeFunzione(){  return  $this->nomeFunzione; }
    public function getArrayAziende(){ return $this->arrayAziende;  }

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//Classe che contiene l'informazioni di un utente
class Utente{

    private $idUtente;
    private $nomeUtente;
    private $cognomeUtente;
    private $usernameUtente;
    private $objAzienda;
    private $visibilita;


    //!!!!!!!!ATTENZIONE:
    //Per il futuro sistemare il costruttore in modo che abbia tutte le informazioni della tab utente del tipo:
    //($idUt, $nUt, $cognUt, $usrUt, $objAz)

    //Costruttore
    function __construct($idUt=null, $nUt=null, $cognUt=null, $usrUt=null, $objAz=null,$visibilita=null)
    {
        $this->idUtente = $idUt;
        $this->nomeUtente = $nUt;
        $this->cognomeUtente = $cognUt;
        $this->usernameUtente=$usrUt;
        $this->objAzienda=$objAz;
        $this->visibilita=$visibilita;

    }


    public function setUtente($idUt=null, $nUt=null, $cognUt=null, $usrUt=null, $objAz=null,$visibilita=null)
    {
        $this->idUtente = $idUt;
        $this->nomeUtente = $nUt;
        $this->cognomeUtente = $cognUt;
        $this->usernameUtente=$usrUt;
        $this->objAzienda=$objAz;
        $this->visibilita=$visibilita;

    }




    public function getUtenteObject(){  return $this; }

    public function getIdUtente(){  return $this->idUtente; }

    public function getNomeUtente(){   return $this->nomeUtente; }

    public function getCognomeUtente(){   return $this->cognomeUtente; }

    public function getUsernameUtente(){   return $this->usernameUtente; }

    public function getObjAziendaAppartenenza(){return $this->objAzienda; }

    public function getVisibilita() {return $this->visibilita; }


    
    
    
    
    }



//Classe che contiene l'informazioni di un utente
class Tabella{

    private $idTabella;
    private $nomeTabella;

    //Costruttore
    function __construct($idTab, $nTab)
    {
        $this->idTabella = $idTab;
        $this->nomeTabella = $nTab;
    }

    public function setTabella($idTab, $nTab)
    {
        $this->idTabella = $idTab;
        $this->nomeTabella = $nTab;
    }



    public function getIdTabella(){  return $this->idTabella; }

    public function getNomeTabella(){   return $this->nomeTabella; }


}

//Classe contenente l'informazione dell'azienda
class Azienda
{
    private $idAzienda;
    private $nomeAzienda;

    //Costruttore
    function __construct($idAz, $nAz)
    {
        $this->idAzienda = $idAz;
        $this->nomeAzienda = $nAz;
    }

    public function setAzienda($idAz, $nAz)
    {
        $this->idAzienda = $idAz;
        $this->nomeAzienda = $nAz;
    }



    public function getIdAzienda(){  return $this->idAzienda; }

    public function getNomeAzienda(){   return $this->nomeAzienda; }

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Classe contenente informazioni di supporto alla gestione del programma
class MyUtility
{
    //Array contenente le aziende totali nel sistema
    private $aziende;
    //Array contenente le tabelle totali nel sistema
    private $tabelle;
    //Array contenente gli utenti totali nel sistema
    private $utenti;

    //Costruttore
    function __construct()
    {
        $this->aziende = array();
        $this->tabelle = array();
        $this->utenti = array();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////
    public function setAziende($arrAz){  $this->aziende = $arrAz; }
    public function setTabelle($arrTab){  $this->tabelle = $arrTab; }
    public function setUtenti($arrUt){  $this->utenti = $arrUt; }

    public function getArrayAziende(){ return $this->aziende; }
    public function getArrayTabelle(){ return  $this->tabelle; }
    public function getArrayUtenti(){ return  $this->utenti; }
    ////////////////////////////////////////////////////////////////////////////////////////////



    ////////////////////////////////////////////////////////////////////////////////////////////
    public function getNomeAzienda( $idAz)
    {
        for($i=0; $i<count( $this->aziende); $i++)
            if( $this->aziende[$i]->getIdAzienda() == $idAz )
                return $this->aziende[$i]->getNomeAzienda();

        return array();
    }

    public function getNomeTabella( $idTab )
    {
        for($i=0; $i<count( $this->tabelle); $i++)
            if( $this->tabelle[$i]->getIdTabella() == $idTab )
                return $this->tabelle[$i]->getNomeTabella();

        return array();
    }

    public function getNomeUtente( $idUt )
    {
        for($i=0; $i<count( $this->utenti); $i++)
            if( $this->utenti[$i]->getIdUtente() == $idUt )
                return $this->utenti[$i]->getNomeUtente();

        return array();
    }
    ////////////////////////////////////////////////////////////////////////////////////////////


    ////////////////////////////////////////////////////////////////////////////////////////////
    public function getIdAzienda( $nomeAz )
    {
        for($i=0; $i<count( $this->aziende); $i++)
            if( $this->aziende[$i]->getNomeAzienda() == $nomeAz )
                return $this->aziende[$i]->getIdAzienda();

        return array();
    }

    public function getIdTabella( $nomeTab )
    {
        for($i=0; $i<count( $this->tabelle); $i++)
            if( $this->tabelle[$i]->getNomeTabella() == $nomeTab )
                return $this->tabelle[$i]->getIdTabella();

        return array();
    }

    public function getIdUtente( $nomeUt )
    {
        for($i=0; $i<count( $this->utenti); $i++)
            if( $this->utenti[$i]->getNomeUtente() == $nomeUt )
                return $this->utenti[$i]->getIdUtente();

        return array();
    }
    /////////////////////////////////////////////////////////////////////////////////////



}

?>