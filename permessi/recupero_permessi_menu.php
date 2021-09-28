<?php

////////////////////////////////////////////////////////////////////////////////
////////////////////////////###########MENU####################/////////////////
////////////////////////////////////////////////////////////////////////////////



/**
 * Metodo che restituisce un oggetto menù contenente il menù generale
 * senza vincoli di utente, quindi contenente tutti i moduli, tutte le voci e tutte le sottovoci
 */
function getObjectMenuGenerale()
{

    $menuGenerico=new Menu(-1, '');



    //Elenco generale di moduli e voci
    $arrayGeneraleModuloVoci=selectElencoGeneraleModuliVoci();


    //Variabile utile a tenere la memoria del modulo corrente nello scorrimento
    //dei file restituiti dalla query
    $idModuloCorrente=-1;

    //Ciclo in cui scorro l'elenco generale, ordinato per modulo e per voce,  di tutti i moduli e di tutte le voci
    while ($rowModuloVociGen = mysql_fetch_array($arrayGeneraleModuloVoci))
    {
        $idModuloGenerico=$rowModuloVociGen['id_modulo'];
        $moduloGenerico=$rowModuloVociGen['modulo'];
        $varLinguaModuloGenerico=$rowModuloVociGen['var_lingua_modulo'];
        $idVoceGenerico=$rowModuloVociGen['id_voce'];
        $voceGenerico=$rowModuloVociGen['voce'];
        $varLinguaVoceGenerico=$rowModuloVociGen['var_lingua_voce'];
        $linkVoceGenerico=$rowModuloVociGen['link_voce'];
        //$varLinguaSottoVoceGenerico=$rowModuloVociGen['var_lingua_sotto_voce'];

        //Setto oggetto Voce, la voce corrente presa dalla prima query
        $voceCorrente=new Voce($idVoceGenerico, $voceGenerico, $linkVoceGenerico,$varLinguaVoceGenerico );


        //Elenco generale di sottovoci
        $arrayGeneraleSottoVoci=selectElencoGeneraleSottovoci();
        while ($rowModuloSottoVociGen = mysql_fetch_array($arrayGeneraleSottoVoci))
        {
            $idModuloGenSv=$rowModuloSottoVociGen['id_modulo'];
            $moduloGenSv=$rowModuloSottoVociGen['modulo'];
            $varLinguaModuloGenSv=$rowModuloSottoVociGen['var_lingua_modulo'];
            $idVoceGenSv=$rowModuloSottoVociGen['id_voce'];
            $voceGenSv=$rowModuloSottoVociGen['voce'];
            $linkVoceGenSv=$rowModuloSottoVociGen['link_voce'];
            $varLinguaVoceGenSv=$rowModuloSottoVociGen['var_lingua_voce'];
            $idSottoVoceGenSv=$rowModuloSottoVociGen['id_sotto_voce'];
            $sottoVoceGenSv=$rowModuloSottoVociGen['sotto_voce'];
            $linkSottoVoceGenSv=$rowModuloSottoVociGen['link_sotto_voce'];
            $varLinguaSottoVoceGenSv=$rowModuloSottoVociGen['var_lingua_sotto_voce'];

            if($idVoceGenSv==$idVoceGenerico)
            {

                $sottoVoceCorrente=new SottoVoce($idSottoVoceGenSv,$sottoVoceGenSv,$linkSottoVoceGenSv,$varLinguaSottoVoceGenSv );
                $voceCorrente->addSottoVoceObject($sottoVoceCorrente);
            }
        }


        //Creo un modulo e lo assegno al menu un nuovo modulo ogni qual volta sarà diverso
        if($idModuloCorrente!=$idModuloGenerico)
        {
            $moduloCorrente=new Modulo($idModuloGenerico, $moduloGenerico, $varLinguaModuloGenerico);

            $menuGenerico->addModuloObject($moduloCorrente);

            //Variabile necessaria in quanto si scorre, sostanzialmente, un elenco di voci
            //dove a gruppi il loro modulo è uguale, quindi per non ripetere la creazione di un nuovo
            //modulo, dove il modulo è uguale, si controllerà se la nuova voce inserita farà parte
            //dello stesso modulo o di un nuovo modulo, ed in questo caso ne verrà creato uno nuovo
            $idModuloCorrente=$idModuloGenerico;
        }


        $moduloCorrente->addVoceObject($voceCorrente);


    }



    return $menuGenerico;
}








/**
 * Metodo che interagisce con altri metodi e recupera il menù completo 
 * che l'utente visualizzerà.
 * Le funzioni con cui interagisce sono creaMenuModuloVoci() creaMenuSottovoci() 
 * e getObjectMenuGenerale()
 * Scorrendo il menu generale con tutte i moduli le voci e le sottovoci, 
 * vedo dove ho corrispondenza con i due oggetti $menuModuloVoci e $menuSottovoci 
 * e dove trovo valore uguale aggiungo quel valore
 * @param type $idUtente
 * @param type $nomeUtente
 * @return \Menu
 */
function generaMenuUtenteCorrente($idUtente, $nomeUtente)
{
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //I due oggetti $menuModuloVoci e $menuSottovoci  li andrò a intersecare in un unico oggetto
    //contenente tutto il menu e lo faccio esaminando ogni singolo modulo, voce, sottovoce con l'elenco generale

    $menuModuloVoci=creaMenuModuloVoci($idUtente, $nomeUtente);
    $menuSottovoci=creaMenuSottovoci($idUtente, $nomeUtente);

    //Definisco quello che sarà l'oggetto menu definitivo creato con l'interazione
    //di altri menu provvisori
    $menuDefinitivoUtente=new Menu($idUtente, $nomeUtente);


    //Recupero menù generale da metodo apposito
    $menuGenerale=getObjectMenuGenerale();
    $arrayGeneraleModuli=$menuGenerale->getArrayModuli();

    //Setto due variabili generiche in modo che possano essere viste globalmente nei tre for
    $moduloAdd=new Modulo(-1, '', '');
    $voceAdd=new Voce(-1, '', '', '');


   //Scorro elenco generale di moduli
    for($i=0; $i<count($arrayGeneraleModuli); $i++)
    {
        $moduloGenCorrente=$arrayGeneraleModuli[$i];
        $idModuloGen=$moduloGenCorrente->getIdModulo();
        $moduloGen=$moduloGenCorrente->getNomeModulo();
        $varLinguaModuloGen=$moduloGenCorrente->getNomeVariabileLingua();

        /////////////////////OPERAZIONI SU MODULO///////////////////////////


        if(findModulo($idModuloGen,$moduloGen,$menuModuloVoci ,$menuSottovoci ))
        {
           $moduloAdd=new Modulo($idModuloGen, $moduloGen,$varLinguaModuloGen );
            $menuDefinitivoUtente->addModuloObject($moduloAdd);
        }

        //////////////////////////////////////////////////////////////////////

        $arrayGeneraleVoci=$moduloGenCorrente->getArrayVoci();
        for($j=0; $j<count($arrayGeneraleVoci); $j++)
        {
            $voceGenCorrente=$arrayGeneraleVoci[$j];
            $idVoceGen=$voceGenCorrente->getIdVoce();
            $voceGen=$voceGenCorrente->getNomeVoce();
            $linkVoceGen=$voceGenCorrente->getLinkVoce();
            $varLinguaVoceGen=$voceGenCorrente->getNomeVariabileLingua();

            /////////////////////OPERAZIONI SU VOCE///////////////////////////

            if(findVoce($idVoceGen,$voceGen,$menuModuloVoci ,$menuSottovoci ))
            {

                $voceAdd=new Voce($idVoceGen, $voceGen, $linkVoceGen, $varLinguaVoceGen);
                $moduloAdd->addVoceObject($voceAdd);

            }




            //////////////////////////////////////////////////////////////////////


            $arrayGeneraleSottovoci=$voceGenCorrente->getArraySottoVoci();
            for($k=0; $k<count($arrayGeneraleSottovoci); $k++)
            {
                $sottoVoceGenCorrente=$arrayGeneraleSottovoci[$k];
                $idSottoVoceGen=$sottoVoceGenCorrente->getIdSottoVoce();
                $sottVoceGen=$sottoVoceGenCorrente->getNomeSottoVoce();
                $linkSottVoceGen=$sottoVoceGenCorrente->getLinkSottoVoce();
                $varLinguaSottoVoceGen=$sottoVoceGenCorrente->getNomeVariabileLingua();

                /////////////////////OPERAZIONI SU SOTTOVOCE///////////////////////////

                if(findSottoVoce($idSottoVoceGen,$sottVoceGen,$menuModuloVoci ,$menuSottovoci ))
                {
                    $sottoVoceAdd=new SottoVoce($idSottoVoceGen, $sottVoceGen,$linkSottVoceGen,$varLinguaSottoVoceGen );
                    $voceAdd->addSottoVoceObject($sottoVoceGenCorrente);
                }


                //////////////////////////////////////////////////////////////////////

            }//for sottovoci

        }//for voci

    }//for moduli


    return $menuDefinitivoUtente;
}



function creaMenuModuloVoci($idUtente, $nomeUtente)
{
    /////////////////////////////////////////////////////////////////////////////////
    ///////////////////Porzione di settaggio menu modulo voce e sottovoce////////////

    //Variabile utile a tenere la memoria del modulo corrente nello scorrimento
    //dei file restituiti dalla query
    $idModuloCorrente=-1;

    //Creo un nuovo menu per le voci
    $menuModuloVoci=new Menu($idUtente, $nomeUtente);

    $moduloCorrente=new Modulo(-1, '', '');

    //Scorro elenco moduli, voci e ne creo un oggetto
    $arrayModuloVoci=selectElencoModuloVoce($idUtente);
    while ($rowModuloVoci = mysql_fetch_array($arrayModuloVoci))
    {

        $idModulo=$rowModuloVoci['id_modulo'];
        $modulo=$rowModuloVoci['modulo'];
        $varLinguaModulo=$rowModuloVoci['var_lingua_modulo'];
        $idVoce=$rowModuloVoci['id_voce'];
        $voce=$rowModuloVoci['voce'];
        $linkVoce=$rowModuloVoci['link_voce'];
        $varLinguaVoce=$rowModuloVoci['var_lingua_voce'];


        if($idModuloCorrente!=$idModulo)
        {
            $moduloCorrente=new Modulo($idModulo, $modulo,$varLinguaModulo);
            $menuModuloVoci->addModuloObject($moduloCorrente);
            $idModuloCorrente=$idModulo;
        }

        $voceCorrente=new Voce($idVoce, $voce,$linkVoce,$varLinguaVoce );
        $moduloCorrente->addVoceObject($voceCorrente);




    }//while


    return $menuModuloVoci;
}

/**
 * 
 * @param type $idUtente
 * @param type $nomeUtente
 * @return \Menu
 */
function creaMenuSottovoci($idUtente, $nomeUtente)
{
    //Variabile utile a tenere la memoria del modulo corrente nello scorrimento
    //dei file restituiti dalla query
    $idModuloCorrenteSv=-1;
    $idVoceCorrenteSv=-1;

    //Creo un nuovo menu per le sottovoci
    $menuSottovoci=new Menu($idUtente, $nomeUtente);

    $moduloCorrente=new Modulo(-1, '','');
    $voceCorrente=new Voce(-1, '', '','');

    //Scorro elenco moduli, voci, sottovoci e ne creo un oggeto
    $arraySottoVoci=selectElencoSottoVoce($idUtente);
    while ($rowSottoVoci = mysql_fetch_array($arraySottoVoci))
    {
        $idModuloSv=$rowSottoVoci['id_modulo'];
        $moduloSv=$rowSottoVoci['modulo'];
        $varLinguaModuloSv=$rowSottoVoci['var_lingua_modulo'];
        $idVoceSv=$rowSottoVoci['id_voce'];
        $voceSv=$rowSottoVoci['voce'];
        $linkVoceSv=$rowSottoVoci['link_voce'];
        $varLinguaVoceSv=$rowSottoVoci['var_lingua_voce'];
        $idSottoVoce=$rowSottoVoci['id_sotto_voce'];
        $sottoVoce=$rowSottoVoci['sotto_voce'];
        $linkSottoVoce=$rowSottoVoci['link_sotto_voce'];
        $varLinguaSottoVoceSv=$rowSottoVoci['var_lingua_sotto_voce'];


        if($idModuloCorrenteSv!=$idModuloSv)
        {
            $moduloCorrente=new Modulo($idModuloSv, $moduloSv,$varLinguaModuloSv);
            $menuSottovoci->addModuloObject($moduloCorrente);
            $idModuloCorrenteSv=$idModuloSv;
        }

        if($idVoceCorrenteSv!=$idVoceSv)
        {
            $voceCorrente=new Voce($idVoceSv, $voceSv, $linkVoceSv, $varLinguaVoceSv);

            $idVoceCorrenteSv=$idVoceSv;
        }

        $sottoVoceCorrente=new SottoVoce($idSottoVoce,$sottoVoce,$linkSottoVoce, $varLinguaSottoVoceSv );
        $voceCorrente->addSottoVoceObject($sottoVoceCorrente);
        $moduloCorrente->addVoceObject($voceCorrente);


    }//while


    return $menuSottovoci;
}


/**
 * Metodo che prende in input un nome di un modulo e due oggetti menu e cerca all'interno dei menu se
 * il modulo è presente, se si restituisce true in modo che il modulo possa essere inserito
 * @param type $idModulo
 * @param type $modulo
 * @param type $menuModVoci
 * @param type $menuSottovoci
 * @return boolean
 */
function findModulo($idModulo, $modulo, $menuModVoci, $menuSottovoci)
{
    $arrayModuliVoci=$menuModVoci->getArrayModuli();
    for($i=0; $i<count($arrayModuliVoci); $i++)
       if($arrayModuliVoci[$i]->getIdModulo()==$idModulo && $arrayModuliVoci[$i]->getNomeModulo()==$modulo)
            return true;

    $arrayModuliSottoVoci=$menuSottovoci->getArrayModuli();
    for($i=0; $i<count($arrayModuliSottoVoci); $i++)
       if($arrayModuliSottoVoci[$i]->getIdModulo()==$idModulo && $arrayModuliSottoVoci[$i]->getNomeModulo()==$modulo)
            return true;


    return false;  //Se in nessuno dei due array trovo il modulo ritorno false
}


//Metodo che prende in input un nome di una voce e due oggetti menu e cerca all'interno dei menu se
//la voce è presente, se si restituisce true in modo che la voce possa essere inserita
function findVoce($idVoce, $voce, $menuModVoci, $menuSottovoci)
{
    $arrayModuliVoci=$menuModVoci->getArrayModuli();
    for($i=0; $i<count($arrayModuliVoci); $i++)
    {
        $arrayDiVoci=$arrayModuliVoci[$i]->getArrayVoci();
        for($j=0; $j<count($arrayDiVoci); $j++)
          if($arrayDiVoci[$j]->getIdVoce()==$idVoce && $arrayDiVoci[$j]->getNomeVoce()==$voce)
            return true;
    }

    $arrayModuliSottoVoci=$menuSottovoci->getArrayModuli();
    for($i=0; $i<count($arrayModuliSottoVoci); $i++)
    {
        $arrayDiVoci=$arrayModuliSottoVoci[$i]->getArrayVoci();
        for($j=0; $j<count($arrayDiVoci); $j++)
          if($arrayDiVoci[$j]->getIdVoce()==$idVoce && $arrayDiVoci[$j]->getNomeVoce()==$voce)
            return true;
    }

    return false;  //Se in nessuno dei due array trovo il modulo ritorno false
}

//Metodo che prende in input un nome di una sottovoce e due oggetti menu e cerca all'interno dei menu se
//la sottovoce è presente, se si restituisce true in modo che la voce possa essere inserita
function findSottovoce($idSottovoce, $sottovoce, $menuModVoci, $menuSottovoci)
{
    $arrayModuliVoci=$menuModVoci->getArrayModuli();
    for($i=0; $i<count($arrayModuliVoci); $i++)
    {
        $arrayDiVoci=$arrayModuliVoci[$i]->getArrayVoci();
        for($j=0; $j<count($arrayDiVoci); $j++)
        {
           if( $arrayDiVoci[$j]->sottovoce())
           {
               $arrayDiSottovoci=$arrayDiVoci[$j]->getArraySottoVoci();
               for($k=0; $k<count($arrayDiSottovoci); $k++)
                   if($arrayDiSottovoci[$k]->getIdSottoVoce()==$idSottovoce && $arrayDiSottovoci[$k]->getNomeSottoVoce()==$sottovoce)
                       return true;
           }
        }


    }


    $arrayModuliSottoVoci=$menuSottovoci->getArrayModuli();
    for($i=0; $i<count($arrayModuliSottoVoci); $i++)
    {
        $arrayDiVoci=$arrayModuliSottoVoci[$i]->getArrayVoci();
        for($j=0; $j<count($arrayDiVoci); $j++)
        {
            if( $arrayDiVoci[$j]->sottovoce())
            {
                $arrayDiSottovoci=$arrayDiVoci[$j]->getArraySottoVoci();
                for($k=0; $k<count($arrayDiSottovoci); $k++)
                    if($arrayDiSottovoci[$k]->getIdSottoVoce()==$idSottovoce && $arrayDiSottovoci[$k]->getNomeSottoVoce()==$sottovoce)
                        return true;
            }
        }


    }

    return false;  //Se in nessuno dei due array trovo il modulo ritorno false
}



?>