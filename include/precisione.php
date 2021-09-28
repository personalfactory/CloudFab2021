<?php 
//##########################################################################
//###################### PARAMETRI VARI ####################################
/**
 * Numero di cifre decimali relative ai costi ed alle quantità di materie prime,
 * componenti e parametri.
 * Utilizzati nel modulo laboratorio 
 */
$PrecisioneCosti=2;
$PrecisioneQta=3;
$PrecisioneQtaRis=3;
$Prec100Kg=2;
$PrecTotali=2;

//Numero di cifre decimali relative alle qta di aterie prime all'interno 
//del codice di esestenza di una formula in laboratorio
$PrecCodEsistenza=3;                                

//Numero di cifre decimali con cui viene salvata la qta e la qta percentuale di materie prime nella tabella
//lab_matpri_teoria
$PrecSalvaQtaPerc=3;
$PrecSalvaQta=2;

/**
 * Variabili che indicano il tipo di un parametro 
 * specificano se i valori di un parametro devono 
 * essere calcolati in percentuale o meno.
 * Vengono salvati nella tabella lab_parametro
 */
$PercentualeSI="PercentualeSI";
$PercentualeNO="PercentualeNO";

/**
 * Valori di Default per i prodotti colorati, 
 * Vengono salvati nella tabella anagrafe_prodotto
 * Utilizzate nel modulo prodotti
 */
$DefaultLimiteColore="99999";
$DefaultFattoreDivisore="1";
$DefaultFascia="99999";

/**
 * Valori da salvare nella tabella gaz_movmag, a seconda dell'operazione fatta
 * Utilizzate nel modulo di produzione_chimica
 */
$valCarico="1";
$valScarico="-1";
$valCaricoPerAcq="LOADING FOR PURCHASE"; 
$valCaricoPerInv= "LOADING FOR INVENTORY";
$valScaricoPerLav= "UNLOADING FOR PROCESSING";
$valCaricoPerLav= "LOADING FOR PROCESSING";
$valScaricoPerInv= "UNLOADING FOR INVENTORY";
$valScaricoPerVen="UNLOADING FOR SALE";
$valReso="RETURN";
$valScaricatoSilos="DOWNLOADED SILO-AREA";
$valConforme=1;
$valNonConforme=0;
$valStabile=1;
$valNonStabile=0;
$valScaricoLotti="SCARICO DEI LOTTI";
$valAdmin="Admin";
$valDefaultNumOrdine="0";
$valDefaultDtOrdine="1970-01-02";
$valDefaultDtArrMerce="1970-01-02";

$valUniMisKg="kg";
$valUniMisPz="Pz";

$valTipoDocDdtAcq="ADT";
$valDesDocDdtAcq = "TRANSPORT DOCUMENT PURCHASE";

$valTipoDocDdtVen="DDT";
$valDesDocDdtVen ="TRANSPORT DOCUMENT OF SALE";

//############### ASSOCIAZIONE LOTTO _CHIMICA ##############
$valTipoDocProdIn="PRO-IN";
$valDesDocProdIn="PACKAGE BATCHS";
$valNumDocProIn="0";

//############# INVENTARIO ###################
$valTipoDocInv="INV";
$valDesDocInv="INVENTORY";
$valNumDocInv="0";

$valDefaultPrezzo=0;
$valClfocoPF="103000071";
$valFornitoreLotti="PERSONAL FACTORY";

//Valore del campo stato della tabella mov_magazzino di serverdb
//quando il codice è nuovo non ancora utilizzato
$valStatoCodMovNuovo=1;

//########### Percorso della cartella per l'upload dei ddt ###################
$destDdtUploadDir="/var/www/CloudFab/doc/ddt/";
$sourceDdtDownloadDir="/CloudFab/doc/ddt/";
$estFileDdt=".pdf";
$preFileDdt="Ddt";

/*
 * Prefisso che viene usato nella generazione del 
 * codice dei componenti drymix
 */
$prefissoCodComp="comp";
$prefissoCodMtChim="C-";

//############ CATEGORIE MERCEOLOGICHE DGLI ARTICOLI MOVIMENTATI #########
$valCatMerLotti="1";
$valCatMerMatPrime="2";

$valFornitore="SUPPLIER";
$valDataDefault="1970-01-02 00:00:00";

$valRespProd="PRODUCTION MANAGER";
$valRespQualita="QUALITY MANAGER";
$valConsTecnico="TECHNICAL CONSULTANT";
$valDefaultGiac=0;
$valDefaultInv=0;

$valAbilitato=1;
$valDisabilitato=0;


#### GESTIONE FILE ALLEGATI LABORATORIO ##################################
//Valori da salvare nella tabella lab_allegato per indeicare se il file è un allegato 
//di una caratteristica di una materia prima o di uno esperimento
$valRifEsperimento="Esperimento";
$valRifMateriaPrima="MateriaPrima";

$destLabUploadDir="/var/www/CloudFab/doc/lab/";
$sourceLabDownloadDir="/CloudFab/doc/lab/";
$destLabUploadDirOld="/var/www/CloudFab/doc/lab/old/";
$preFileLab="Lab";

$valCarNum="Numeric";
$valCarTxt="Text";

$fatConvKgGrammi=1000;

$lenghtCodMerge=11;

$preCodEspMerge="M-";
$valTipoLabMerge="MERGE";
$valTipoLabEsp="EXPERIMENT";
$valTipoLabCampione="SAMPLE";

$filtroPuntini="...";

//Numero di caratteri da visualizzare
$numCarVis=15;

//Valori relativi al campo peso_reale della tabella miscela miscela
$valPesoMisInit=0;
$valPesoMisIncompleta=1;

$valContImp=0;
$valContLibero=1;

//Valori che indicano se una rosetta è impegnata o libera
$valRosetImp=0;
$valRosetLibera=1;

//Valore di inizializzazione del campo peso della tabella lab_peso
$valDefaultLabPeso=0;

$valTipoMatCompound="Compound";
$valTipoMatDryMix="DryMix";

//Distinzione del tipo di materiale da pesare in una prova di laboratorio
$valMateriaPrima="MateriaPrima";
$valParametro="Parametro";

$tipoAggOut="OUT";
$tipoAggIn="IN";

$valPosAperta="APERTA";
$valPosChiusa="CHIUSA";

//La prima lettera che si mette davanti al codice di una formula
$valPrimaLetteraCod="K";

//Valori dei metodi di calcolo per la creazione di formule compound
$valMetodoLottiKit="LottiKit";
$valMetodoMiscelaTot="MiscelaTot";

$radicePercorsoSchedeTecnicheSito="http://www.personalfactory.eu/prodotti/schede/tecniche/download";

$valTipoAccessori="Accessori";

//### Percorso della cartella per l'upload delle presentazioni dei prodotti in business simulation
$destPresProdUploadDir="/var/www/CloudFab/bs/schede/presentazione/download/";
$sourcePresProdDownloadDir="/CloudFab/bs/schede/presentazione/download/";

$valGeneratoreListinoPF=3;

$valBsTipoProdPf="PF";
$valBsTipoProdNotPf="NOT-PF";

$valCatalogoSi='si';
$valCatalogoNo='no';

$destBackupOrigamiDBFileDir="/var/www/CloudFab/dbmacchina/";
$prefixFileName="origamidb";

$valDefaultPesoMiscela=100000;

//Valori default carico controllo materie prime in silos
$valOperazioneIn='1';
$valTipoMovIn='IN';
$valDescriMovIn="LOADING FOR PURCHASE";
$valDefaultCiclo='0';

$valOperazioneOut='-1';
$valTipoMovOut='OUT';
$valDescriMovOutProcess="MACHINE PROCESS";

$valTipoComp="RAW MATERIAL";
$valTipoColor="COLOR";

//Valori di default tabella processo-ciclo_origami
$valDefaultVibro="OFF";
$valDefaultAria="OFF";
$valDefaultVelMixer = 6000;
$valDefaultTimeMixer = 50000;

$valDefaultQtaTeo=0;
$valDefaultErrore=0;

$valVibroOn="ON";
$valVibroOff="OFF";

$valAriaOn="ON";
$valAriaOff="OFF";

//Valori che Origami inserisce nella tabella processo ori nel campo cod_colore 
//quando un colore non esiste
$valDefaultOriColore1="Codice colore";
$valDefaultOriColore2="nessuno";
$valDefaultOriColore3="COD_COLORE_PULIZIA";

//Da tabella tipo_processo
$tipoProcessoProd=1;

//Valore campo parent 
$valStatoLottoDisponibile=1;
$valStatoLottoVenduto=0;

$valTipoDocInternalTest="TEST";
$valDesDocInternalTest ="INTERNAL TEST";
$valCausaleInternalTest="UNLOADING FOR INTERNAL TEST";
$valProceduraIntTest="INTERNAL TEST";

$valTipoDocCampioni="SAM";
$valDesDocCampioni ="SAMPLING FOR CUSTOMERS";
$valCausaleCampioni="UNLOADING FOR SAMPLING";
$valProceduraCampioni="SAMPLING";

$valTipDocProMix="PRO-MIX";
$valDesDocProCompound="COMPOUND FOR FINAL PRODUCT";

$valProceduraAdotCompound="COMPOUND FOR FINAL PRODUCT";

$valTipoDocDdtPrf="DDT-PRF";
$valCausaleDdtPrf="UNLOADING FOR SALE FINAL PRODUCT";
$valDesDocDdtPrf="TRANSPORT DOCUMENT OF SALE FINAL PRODUCT";
$valProceduraDdtPrf="TRANSPORT DOCUMENT OF SALE FINAL PRODUCT"; 

$valDefaultNumDdt=0;

$valDefaultLivello4="CompoundPF";
$valDefaultLivello5="Personal Factory";
$valDefaultLivello6="Universale";

//Id par sing mac = quantita da togliere al totale miscela per calcolare il num di sacchi
$valIdParCorrettivoFormula="344";
$valApprosPesoSacchi="250";


$valStatoInsOrdineOri="0";
$valDescriStatoInsOrdineOri="TO PRODUCE";

$valStatoEvasoOrdineOri="1";
$valDescriStatoEvasoOrdineOri="PROCESSED";

$valStatoSaltaOrdineOri="-1";
$valDescriStatoSaltaOrdineOri="SKIPPED";


$valStrConforme="CONFORM";
$valStrNonConforme="NOT CONFORM";

$valTipoMovWareH="WAREHOUSE";

$valIdMovOri=0;
$valIdCicloDefault=0;

//Indica la stringa da inserire nel campo tipo della tabella prodotto
$valIdParGlobTipoProd="152";
//Indica la stringa da inserire nel campo serie colore e serie additivo della tabella prodotto "NONE"
$valIdParGlobSerie="155";


//Valore del campo "tipo2" tabella lab_materie_prime
$valStrColor="COLOR";

//Mazzetta Non definita
$valDefaultMazz="14";

$valTipo3Compound="COMPOUND";
$valTipo3Drymix="DRYMIX";

$valTipo2Pigment="PIGMENT";
$valTipo2RawMaterial="RAW MATERIAL";
$valTipo2Additivo="ADDITIVE";

$valFamigliaColoreDefault="FC0";

//Id della categoria che viene usata di default per le integrazioni ai prodotti, colori e additivi
$valIdCatDefaultIntegrazioni=40;

$valFamigliaAdditivoDefault="RDV";


//valore di default del campo user_origami quando si carica una nuova macchina
//Indica la versione del sft CloudFab e aggiornamento
$valSyncSftwVersion="4";

$valPrefissoFormulaAdditivo="ADDITIVE";


//########### Percorso della cartella per l'upload dei ddt ###################
$destUploadDirMovOri="/var/www/CloudFab/dbmacchina/";
$downloadDocMacchinaDir="dbmacchina";
$preDirMacchina='macchina';
$preFileMovOri="Mov";