/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.process;

import it.personalfactory.syncorigami.datamanager.DataManagerS;
import it.personalfactory.syncorigami.exceptions.*;
import it.personalfactory.syncorigami.macchina.entity.AggiornamentoOri;
import it.personalfactory.syncorigami.server.entity.Aggiornamento;
import it.personalfactory.syncorigami.server.entity.Macchina;
import it.personalfactory.syncorigami.server.jpacontroller.MacchinaJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.utils.FileUtils;
import it.personalfactory.syncorigami.utils.MachineCredentials;
import it.personalfactory.syncorigami.utils.SyncOrigamiConstants;
import it.personalfactory.syncorigami.utils.UpdaterUtils;
import it.sauronsoftware.ftp4j.FTPAbortedException;
import it.sauronsoftware.ftp4j.FTPDataTransferException;
import it.sauronsoftware.ftp4j.FTPException;
import it.sauronsoftware.ftp4j.FTPIllegalReplyException;
import it.sauronsoftware.ftp4j.FTPListParseException;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.text.ParseException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Collections;
import java.util.List;
import java.util.logging.Level;
import java.util.regex.Pattern;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;
import javax.xml.bind.JAXBException;
import net.lingala.zip4j.exception.ZipException;
import org.apache.log4j.Logger;
import org.xml.sax.SAXException;

/**
 *
 * @author marilisa
 */
public class ServerProcess {

    private static Logger log = Logger.getLogger(ServerProcess.class);

    /**
     * Genera l'aggiornamento per la singola macchina con id idMacchina
     *
     * @param Integer idMacchina
     * @param EntityManagerFactory
     * @throws DatiAggiornamentoNotFoundException
     * @throws InitializeException
     * @throws ProcessException
     * @throws ComunicationException
     */
    public static void uploadSingleMachineUpdate(EntityManagerFactory emf, Integer idMacchina)
            throws DatiAggiornamentoNotFoundException,
            InitializeException,
            ProcessException,
            ComunicationException,
            MachineCredentialsNotFoundException,
            ParseException,
            Exception {

        MachineCredentials mc = null;
        try {
            mc = DataManagerS.getMachineCredentials(idMacchina, emf, SyncOrigamiConstants.OUT_FILE_PFX);
        } catch (MachineCredentialsNotFoundException ex) {
            log.error(ex);
            throw new MachineCredentialsNotFoundException("CREDENZIALI DELLA MACCHINA NON TROVATE");
        }

        //######################################################################
        //########### COSTRUZIONE DEL NOME DEL FILE DI SCAMBIO #################
        //######################################################################
        
        //COSTRUISCE IL NOME DEL FILE IN BASE ALLA DATA CORRENTE ED ALLA VERSIONE     
        String nomeFileOut = UpdaterUtils.generaNomeFileOut(mc, SyncOrigamiConstants.OUT_FILE_PFX);

        //######################################################################
        //############# GENERAZIONE AGGIORNAMENTO ##############################
        //######################################################################
        
        //COSTRUISCE L'AGGIORNAMENTO PRENDENDO I DATI NUOVI DAL SERVER
        Aggiornamento aggiornamento = null;
        //aggiornamento = DataManagerS.costruisciAggiornamento(mc, emf, SyncOrigamiConstants.OUT_FILE_PFX);
        
        Integer syncSftwVersion = Integer.valueOf(mc.getSyncSoftwareVersion());//valore campo user_origami
        Integer machineSftwVersion = Integer.valueOf(mc.getMachineSoftwareVersion());        
        Integer origamiDbVersion = Integer.valueOf(mc.getOrigamiDbVersion());
        
        
        
        
        switch (syncSftwVersion) {

            case 2:
                log.info("@versioneSFTW : CASO syncSftwVersion=2");
                //Metodo che gestisce il passaggio di versione dalla 2 alla 3
                aggiornamento = DataManagerS.costruisciAggiornamento(mc, emf, SyncOrigamiConstants.OUT_FILE_PFX); 
                break;
                
            case 3:
                log.info("@versioneSFTW : CASO syncSftwVersion=3");
                //1) aggiornamenti successivi al primo con versione 3
                aggiornamento = DataManagerS.costruisciAggiornamento(mc, emf, SyncOrigamiConstants.OUT_FILE_PFX);       
                
                //Avanzamento di versione dalla 3 alla 4
                //primo nuovo aggiornamento 4
                if(origamiDbVersion.equals(4) & machineSftwVersion.equals(4)){
                    aggiornamento = DataManagerS.aggiungiDatiPrimoAggiornamento4(mc, emf, aggiornamento);
                }
                break;
                
            case 4:
                log.info("@versioneSFTW : CASO syncSftwVersion=4");
                //Se il campo user_origami della tabella macchina = 4 
                //Invio l'aggiornamento 4 completo                
                aggiornamento = DataManagerS.costruisciAggiornamento4(mc, emf, SyncOrigamiConstants.OUT_FILE_PFX);
                break;

                          
        }

       

        //Se la collection di dati daInserire è vuota non viene creato il file xml
        //Viene stampato un messaggio
        if (aggiornamento.getDaInserire() == null || aggiornamento.getDaInserire().isEmpty()) {

            log.info("@@NON CI SONO DATI NUOVI PER L'AGGIORNAMENTO");
            throw new DatiAggiornamentoNotFoundException("1) COLLETION DA INSERIRE VUOTA O NULL NELL' OGGETTO AGGIORNAMENTO");

        } else {

            //######## LOG 
            log.info("COSTRUITO OGGETTO AGGIORNAMENTO ");
            log.info("COLLETION DA INSERIRE NON VUOTA E NON NULL NELL' OGGETTO AGGIORNAMENTO");
//            log.info("COSTRUITO OGGETTO AGGIORNAMENTO " + aggiornamento.toString());
            Collection c = aggiornamento.getDaInserire();
            int count = 0;
            for (Object o : c) {
                if (o != null) {
//                    log.info(o.getClass().cast(o).toString());
                } else {
                    log.info("AGGIORNAMENTO - TROVATO/I n. " + count++ + " OGGETTO/I NULL!!!");
                }
            }
            //######## FINE LOG

            //######################################################################
            //############ ADATTAMENTO AGGIORNAMENTO AL FORMATO DI ARRIVO ##########
            //######################################################################
            AggiornamentoOri aggiornamentoOri = null;
            log.info("############ INIZIO ADATTAMENTO AGGIORNAMENTO AL FORMATO DI ARRIVO ############");
            aggiornamentoOri = DataManagerS.adattaAggiornamentoOut(aggiornamento, syncSftwVersion,origamiDbVersion,machineSftwVersion,SyncOrigamiConstants.IN_FILE_PFX, emf);

            //##################################################################
            //Modifica del 28 maggio 2015
            if (aggiornamentoOri.getDaInserire() == null || aggiornamentoOri.getDaInserire().isEmpty()) {
//                log.info("@@Colletion DaInserire vuota o null nell'oggetto AggiornamentoOri");
                throw new DatiAggiornamentoNotFoundException("2) COLLETION DA INSERIRE VUOTA O NULL NELL' OGGETTO AGGIORNAMENTO ORI");
            } else {
            //##################################################################

                //######## LOG
                log.info("############# AGGIORNAMENTO TRASFORMATO IN AGGIORNAMENTO_ORI #################");
                Collection c1 = aggiornamentoOri.getDaInserire();
//            log.info(aggiornamentoOri.toString());
                count = 0;
                for (Object o : c1) {
                    if (o != null) {
//                        log.info(o.getClass().cast(o).toString());
                    } else {
                        log.info("AGGIORNAMENTO_ORI TROVATO/I n. " + count++ + " OGGETTO/I NULL!!!");
                    }
                }
            //######## FINE LOG

            //########################################################################
                //################## COSTRUZIONE FILE XML DI SCAMBIO #####################
                //########################################################################
                log.info("############ INIZIO COSTRUZIONE FILE XML DI SCAMBIO ###################");
                //COSTRUISCE IL FILE XML A PARTIRE DA AggiornamentoORI E LO METTE NELLA 
                //DIRECTORY CORRISPONDENTE
                String completePathToXMLFileOut = null;
                try {
                    //COSTRUISCE IL FILE XML
                    completePathToXMLFileOut = UpdaterUtils.createDataTransferXML(
                            aggiornamentoOri,
                            nomeFileOut,
                            SyncOrigamiConstants.SERVER_XML_DATA_OUT_GENERATE_DIR,
                            SyncOrigamiConstants.SERVER_JAXB_OUTPUT_PACKAGE_NAME,
                            SyncOrigamiConstants.XSD_MACCHINA_FILE_NAME);
                    log.info("############ FILE GENERATO CON SUCCESSO: " + completePathToXMLFileOut);

                    mc.setCurrentUpdateFileNameCompletePath(completePathToXMLFileOut);

                } catch (FileNotFoundException ex) {
                    log.error("ERRORE NELLA CREAZIONE DEL FILE " + completePathToXMLFileOut + "\n" + ex.getMessage());
                    throw new ProcessException("ERRORE NELLA CREAZIONE DEL FILE (Errore di creazione)" + completePathToXMLFileOut + "\n");
                } catch (JAXBException ex) {
                    log.error("ERRORE NELLA GENERAZIONE DEL FILE (Errore JAXB)" + completePathToXMLFileOut + "\n" + ex.getMessage());
                    throw new ProcessException("ERRORE NELLA CREAZIONE DEL FILE (Errore JAXB)" + completePathToXMLFileOut + "\n");
                } catch (SAXException ex) {
                    log.error("ERRORE NELLA GENERAZIONE DEL FILE (Errore JAXB)" + completePathToXMLFileOut + "\n" + ex.getMessage());
                    throw new ProcessException("ERRORE NELLA CREAZIONE DEL FILE (Errore JAXB)" + completePathToXMLFileOut + "\n");
                }

            //########################################################################
                //#################### COSTRUZIONE FILE COMPRESSO ########################
                //########################################################################
                log.info("############### INIZIO CREAZIONE FILE COMPRESSO ###############");
                //COMPRIME IL FILE XML E LO METTE NELLA DIRECTORY CORRISPONDENTE
                String completePathToXMLCompressedFileOut = null;
                try {

                    //nomeFileOut è senza estensione
                    completePathToXMLCompressedFileOut = UpdaterUtils.compress(
                            nomeFileOut + ".xml",
                            SyncOrigamiConstants.SERVER_XML_DATA_OUT_GENERATE_DIR,
                            nomeFileOut,
                            SyncOrigamiConstants.SERVER_XML_DATA_OUT_COMPRESS_DIR,
                            mc.getZipPassword());
                    log.info("########### FINE CREAZIONE FILE COMPRESSO ##########");
                } catch (ZipException ex) {
                    log.error(ex);
                    throw new ProcessException("ERRORE NELLA CREAZIONE DEL FILE COMPRESSO" + completePathToXMLFileOut + "\n");
                }

                log.info("completePathToXMLCompressedFileOut : " + completePathToXMLCompressedFileOut);

            //########################################################################
                //##################### UPLOAD IN CARTELLA REMOTA ########################
                //########################################################################
                //MODIFICHE 7 Aprile 2014 ##########################################
                //PER OGNI SERVER FTP IN LISTA INVIO UN FILE #######################
                //Variabile che controlla l'invio del file su tutti i server ftp
                boolean errorTransferFile = false;
                int i = 0;
                int numFileTransfered = 0;
                for (String ftpName : SyncOrigamiConstants.FTP_SERVER_MIRROR_LIST) {
                    log.info("server ftp" + i + " = " + ftpName);

                    log.info("############ INIZIO UPLOAD IN CARTELLA REMOTA ##########");
                    //FA L'UPLOAD DEL FILE NELLA CARTELLA REMOTA S2M
                    String completePathTransferedFileOut = null;
                    try {
                        completePathTransferedFileOut = UpdaterUtils.uploadToFTP(
                                mc.getFtpUser(),
                                mc.getFtpPassword(),
                                SyncOrigamiConstants.SERVER_XML_DATA_OUT_COMPRESS_DIR,//ServerXMLDataZidOut
                                nomeFileOut + ".zip",
                                ftpName, //SyncOrigamiConstants.FTP_SERVER_NAME,
                                SyncOrigamiConstants.SERVER_FTP_SERVER_OUT_DIR,//s2m
                                SyncOrigamiConstants.SERVER_XML_DATA_OUT_TRANSFERED_DIR//ServerFTPTransferOut
                        );
                        if (completePathTransferedFileOut == null) {
                            errorTransferFile = true;
                        } else {

                            numFileTransfered++;
                        }
                        log.info("############ FINE UPLOAD IN CARTELLA REMOTA ##########");
                        log.info("completePathTransferedFileOut  " + completePathTransferedFileOut);
                    } catch (IOException ex) {
                        errorTransferFile = true;
                        throw new ComunicationException("ERRORE NEL PROCESSO DI TRASFERIMENTO " + completePathToXMLCompressedFileOut);
                    } catch (FTPDataTransferException ex) {
                        errorTransferFile = true;
                        log.error(ex);
                        throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + completePathToXMLCompressedFileOut);
                    } catch (FTPAbortedException ex) {
                        errorTransferFile = true;
                        log.error(ex);
                        throw new ComunicationException("COMUNICAZIONE INTERROTTA!!!");
                    } catch (FTPIllegalReplyException ex) {
                        errorTransferFile = true;
                        log.error(ex);
                        throw new ComunicationException("IL SERVER FTP NON RISPONDE CORRETTAMENTE!!!");
                    } catch (FTPException ex) {
                        errorTransferFile = true;
                        log.error(ex);
                        throw new ComunicationException("ERRORE FTP!!!" + ex.getMessage());
                    }
                    i++;
                }
                if (numFileTransfered == 0) {

                    throw new ComunicationException("TRASMISSIONE FILE NON RIUSCITA !!!");
                }

                //########################################################################
                //######## SPOSTAMENTO DEL FILE TRASMESSO NELLA CARTELLA DI BKP ##########
                //########################################################################
                String transferedFile = null;
                //Solo se il file è stato inviato con successo a tutti i server ftp 
                //lo sposto nella cartella di backup
                if (!errorTransferFile) {
                    try {

                        transferedFile = UpdaterUtils.cutFile(SyncOrigamiConstants.SERVER_XML_DATA_OUT_TRANSFERED_DIR,
                                SyncOrigamiConstants.SERVER_XML_DATA_OUT_COMPRESS_DIR,
                                nomeFileOut + ".zip");
                        log.info("Il file appena trasferito è stato spostato nella cartella di bkp ServerFTPTransferOut");
                    } catch (IOException ex) {
                        log.error(ex);
                        throw new ProcessException("IMPOSSIBILE SPOSTARE O RIMUOVERE IL FILE TRASFERITO!!!" + ex.getMessage());
                    }

                }

                //##########################################################################
                //################## REGISTRAZIONE AGGIORNAMENTO NEL DB ####################
                //##########################################################################
                log.info("############ INIZIO REGISTRAZIONE AGGIORNAMENTO NEL DB ##########");
                // Se il processo di upload è andato a buon fine si registra l'aggiornamento 
                //nella tabella aggiornamento
                DataManagerS.salvaAggiornamentoOut(aggiornamento, emf, mc);

                log.info("########### SALVATO NUOVO AGGIORNAMENTO IN USCITA NELLA TABELLA aggiornamento ");
                log.info("MACHINE CREDENTIALS : " + mc.toString());
            }//controllo oggetto aggiornamentoOri (colletion DaInserire) //Modifica 28 maggio 2015
        }
    }

    /**
     * Metodo che scarica tutti i file provenienti dalle varie macchine
     *
     * @param serverPersistenceUnit
     * @throws InitializeException
     * @throws ComunicationException
     * @throws ProcessException
     * @throws InvalidUpdateContentException
     * @throws InvalidUpdateVersionException
     * @throws InvalidUpdateTypeException
     * @throws NonexistentEntityException
     * @throws Exception
     */
    public static void downloadAllUpdates(String serverPersistenceUnit, String propFileStr)
            throws InitializeException,
            ComunicationException,
            ProcessException,
            FileToDownloadNotFoundException,
            Exception {
        //##########################################################################
        //####################### FASE DI INIZIALIZZAZIONE #########################
        //##########################################################################

        log.info("########## CREAZIONE PERSISTENCE UNIT : ##############");
        EntityManagerFactory emf = Persistence.createEntityManagerFactory(serverPersistenceUnit);
        log.info("########## FINE CREAZIONE PERSISTENCE UNIT ##############");

//    SyncOrigamiConstants.loadServerPropertiesFromDb(emf);
        log.info("########## CARICAMENTO DELLE PROPRIETA' DAL FILE : ##############");
        SyncOrigamiConstants.loadServerProperties(propFileStr);
        log.info("########## FINE CARICAMENTO PROPRIETA' ##############");

        //##########################################################################
        //################### DOWNLOAD DALLA CARTELLA REMOTA #######################
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_USER " + SyncOrigamiConstants.SERVER_FTP_SERVER_USER);
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD " + SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD);
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR " + SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR);
        log.info("SyncOrigamiConstants.FTP_SERVER_NAME " + SyncOrigamiConstants.FTP_SERVER_NAME);
        log.info("SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR " + SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR);
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR_OLD " + SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR_OLD);

        //##########################################################################
        log.info("############### INIZIO METODO downloadAllFromFTP ##################### ");
        Collection<String> downloadedFiles = null;
        try {
            downloadedFiles = UpdaterUtils.downloadAllFromFTP(
                    SyncOrigamiConstants.SERVER_FTP_SERVER_USER,
                    SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD,
                    SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR,
                    SyncOrigamiConstants.FTP_SERVER_NAME,
                    SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR,
                    SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR_OLD);

        } catch (IllegalStateException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPListParseException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FileNotFoundException ex) {
            log.error(ex);
            throw new InitializeException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPDataTransferException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPAbortedException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPIllegalReplyException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (IOException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        }

        //NESSUN FILE SCARICATO
        if (downloadedFiles.isEmpty()) {
            throw new FileToDownloadNotFoundException("NON SONO STATI TROVATI AGGIORNAMENTI DA SCARICARE SUL FTP");
        } else {

            //ORA HO TUTTI I NOMI DEI FILE DENTRO L'ARRAY
            for (String s : downloadedFiles) {
                log.info(" ############ SCARICATO FILE : " + s);
            }

            //Troviamo tutte le MachineCredentials dei files scaricati
            Collection<MachineCredentials> mcIns = new ArrayList<MachineCredentials>();
            for (String fileIn : downloadedFiles) {
                //deve andare a prendere, leggendo dal nome del file, l'ID della macchina
                //e le credenziali per decomprimere il file

                MachineCredentials mc;
                try {
                    mc = UpdaterUtils.estraiDatiDaNomeFile(fileIn);
                } catch (NonValidParamException ex) {
                    log.error("IMPOSSIBILE PROCESSARE IL FILE");
                    throw new ProcessException("IMPOSSIBILE PROCESSARE IL FILE");
                }

                //A questo punto andiamo a prendere gli altri parametri della macchina dal DB
                try {

                    MachineCredentials mc1 = DataManagerS.getMachineCredentials(mc.getIdMacchina(), emf, SyncOrigamiConstants.OUT_FILE_PFX);
                    //se non ha generato eccezione vuol dire che lo ha trovato, quindi 
                    //uploadiamo mc
                    mc.setFtpPassword(mc1.getFtpPassword());
                    mc.setFtpUser(mc1.getFtpUser());
                    mc.setZipPassword(mc1.getZipPassword());
                    mc.setLastUpdateDate(mc1.getLastUpdateDate());
                    mc.setLastUpdateVersion(mc1.getLastUpdateVersion());
                    

                } catch (MachineCredentialsNotFoundException ex) {
                    log.error(ex);
                }
                log.info(" ############## NUOVO MACHINE CREDENTIALS MACCHINA ###########: " + mc.toString());
                mcIns.add(mc);

            }

            //Ora abbiamo tutti i MachineCredentials degli aggiornamenti ricevuti da tutte le macchine
            //a questo punto dobbiamo ordinare la collection per fare in modo che se
            //c'è più di un aggiornamento in coda per una singola macchina questo 
            //venga processato in ordine di versione
            //ordiniamo la collection
            Collections.sort((List<MachineCredentials>) mcIns);

            log.info("DIMENSIONE COLLECTION MACHINE CREDENTIALS: " + mcIns.size());
            log.info("########## INIZIO CICLO PROCESSAMENTO DEI FILE #############");
            //PROCESSIAMO L'AGGIORNAMENTO
            for (MachineCredentials mc : mcIns) {

                //LOG
                log.info("########## INIZIO FILE ################");

                String fileIn = mc.getCurrentUpdateFileNameCompletePath();

                try {

                    log.info("fileIn A " + fileIn);
                    log.info("fileIn.replaced A " + fileIn.replace(".zip", ".xml"));
                    log.info("SyncOrigamiConstants.SERVER_XML_DATA_IN_UNCOMPRESS_DIR " + SyncOrigamiConstants.SERVER_XML_DATA_IN_UNCOMPRESS_DIR);
                    log.info("mc.getZipPassword() " + mc.getZipPassword());

                    //Recupero del nome del file originale
                    //Estraggo il nome del file senza il nome della cartella
                    String splitRegex = Pattern.quote(System.getProperty("file.separator"));
                    String[] tmp = fileIn.split(splitRegex);

                    log.info("1: " + tmp[0]);
                    log.info("2: " + tmp[1]);
                    //Cambio l'estenzione del file
                    String destFile = tmp[1].replace(".zip", ".xml");

                    log.info("destFile: " + destFile);

                    log.info("############ DECOMPRESSIONE DEL FILE #################");
                    //Per ognuno dei file scaricati decomprimiamo e se la decompressione è andata
                    //a buon fine spostiamo il file xml nella cartella dei decompressi e il file
                    //compresso dalla cartella degli scaricati a quella dei compressi in ingresso
                    String fileDestCompletePath = UpdaterUtils.uncompress(
                            fileIn,
                            //       fileIn.replace(".zip", ".xml"), 
                            destFile,
                            SyncOrigamiConstants.SERVER_XML_DATA_IN_UNCOMPRESS_DIR,
                            mc.getZipPassword());

                    //Spostiamo il file compresso nel folder compressed
                    log.info("SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR: " + SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR);
                    log.info("SyncOrigamiConstants.SERVER_XML_DATA_IN_COMPRESS_DIR: " + SyncOrigamiConstants.SERVER_XML_DATA_IN_COMPRESS_DIR);
                    log.info("fileIn B: " + fileIn);
                    log.info("fileInReplaced B: " + fileIn.replace(SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR, SyncOrigamiConstants.SERVER_XML_DATA_IN_COMPRESS_DIR));

                    FileUtils.copyFile(
                            new File(fileIn),
                            new File(fileIn.replace(SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR, SyncOrigamiConstants.SERVER_XML_DATA_IN_COMPRESS_DIR)));
                    FileUtils.delete(new File(fileIn));

                    //Setto il campo FileNameCompletePath del MachineCredentials
                    mc.setCurrentUpdateFileNameCompletePath(fileDestCompletePath);

//              Estraggo il nome del file senza l'estenzione
                    String[] nomeTmp = destFile.split("\\.");
                    mc.setCurrentUpdateFileName(nomeTmp[0]);
                    log.info("CurrentUpdateFileName : " + mc.getCurrentUpdateFileName());

                } catch (IOException ex) {
                    log.error(ex);
                    throw new ProcessException("IMPOSSIBILE SPOSTARE L'AGGIORNAMENTO " + fileIn + "NELLA CARTELLA DI BACKUP");
                } catch (ZipException ex) {
                    log.error(ex);
                    throw new ProcessException("ERRORE NEL DECOMPRIMERE L'AGGIONRAMENTO " + fileIn);
                }

            }

            log.info("################ FINE CICLO PROCESSAMNETO DEI FILE #################");

            //ATTENZIONE...LA MACCHINA MANDA UN AGGIORNAMENTO_ORI....QUINDI BISONG USARE XSD_MACCHINA_FILE_NAME
            for (MachineCredentials mc : mcIns) {

                Object o = UpdaterUtils.retrieveData(
                        SyncOrigamiConstants.SERVER_JAXB_OUTPUT_PACKAGE_NAME,
                        SyncOrigamiConstants.XSD_MACCHINA_FILE_NAME,
                        mc.getCurrentUpdateFileNameCompletePath());

                //##########################################################################
                //###### VALIDAZIONE, TRASFORMAZIONE, SALVATAGGIO AGGIORNAMENTO IN ###########
                //##########################################################################  
                log.info("################# VALIDAZIONE AGGIORNAMENTO IN ENTRATA : #####################");
                try {

                    DataManagerS.validaAggiornamentoIn(
                            o,
                            SyncOrigamiConstants.OUT_FILE_PFX,
                            SyncOrigamiConstants.IN_FILE_PFX,
                            mc,
                            emf);
                    log.info("################# FINE VALIDAZIONE AGGIORNAMENTO IN ENTRATA #####################");
                } catch (InvalidUpdateContentException ex) {
                    throw ex;
                } catch (InvalidUpdateVersionException ex) {
                    throw ex;
                } catch (InvalidUpdateTypeException ex) {
                    throw ex;
                }

                AggiornamentoOri aggiornamentoOri = (AggiornamentoOri) o;

                Aggiornamento aggiornamento = null;
                
                  
                try {
                    log.info("############ TRASFORMAZIONE DA AGGIORNAMENTO_ORI AD AGGIORNAMENTO : ###########");
                    aggiornamento = DataManagerS.adattaAggiornamentoIn(aggiornamentoOri,                                           
                            emf,
                            mc,
                            SyncOrigamiConstants.IN_FILE_PFX);
                    log.info("############ FINE TRASFORMAZIONE DA AGGIORNAMENTO_ORI AD AGGIORNAMENTO ###########");
                } catch (InvalidUpdateContentException ex) {
                    throw ex;
                }

                try {

                    DataManagerS.salvaDatiAggiornamentoIn(aggiornamento, emf);

                } catch (NonexistentEntityException ex) {
                    throw ex;
                } catch (Exception ex) {
                    throw ex;
                }

                //##################################################################
                boolean aggiornamentoCompleto = false;
                aggiornamentoCompleto = UpdaterUtils.renameFileFTP(
                        SyncOrigamiConstants.SERVER_FTP_SERVER_USER,
                        SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD,
                        SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR,//.
                        SyncOrigamiConstants.FTP_SERVER_NAME,
                        SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR_OLD,//old
                        mc.getCurrentUpdateFileName());

                if (aggiornamentoCompleto) {
                    //Salvo nella tabella AggiornamentoOri
                    DataManagerS.salvaAggiornamentoIn(aggiornamento, emf, mc);

                    log.info("MACHINE CREDENTIALS : " + mc.toString());
                    log.info("AGGIORNAMENTO COMPLETO! ");

                } else {
                    throw new ProcessException("Aggiornamento non completato : il file " + mc.getCurrentUpdateFileName()
                            + " è stato processato ma non spostato nella cartella old");

                }

                //##################################################################
            }
        }
    }

    /**
     * Metodo che scarica i file di backup provenienti dalle varie macchine, i
     * file si trovano nella cartella bck dell'utente server sul FTP
     *
     * @param serverPersistenceUnit
     * @throws InitializeException
     * @throws ComunicationException
     * @throws ProcessException
     * @throws InvalidUpdateContentException
     * @throws InvalidUpdateVersionException
     * @throws InvalidUpdateTypeException
     * @throws NonexistentEntityException
     * @throws Exception
     */
    public static void downloadBackupDb(String serverPersistenceUnit, String propFileStr)
            throws InitializeException,
            ComunicationException,
            ProcessException,
            NonexistentEntityException,
            Exception {
        //##########################################################################
        //####################### FASE DI INIZIALIZZAZIONE #########################
        //##########################################################################

        log.info("########## CREAZIONE PERSISTENCE UNIT : ##############");
        EntityManagerFactory emf = Persistence.createEntityManagerFactory(serverPersistenceUnit);
        log.info("########## FINE CREAZIONE PERSISTENCE UNIT ##############");

        log.info("########## CARICAMENTO DELLE PROPRIETA' DAL FILE : ##############");
        try {
            SyncOrigamiConstants.loadServerProperties(propFileStr);
        } catch (InitializeException ex) {
            throw new InitializeException("ERRORE NEL CARICARE LE PROPRIETA' DEL SERVER");

        }
        log.info("########## FINE CARICAMENTO PROPRIETA' ##############");

        //##########################################################################
        //############## DOWNLOAD DALLA CARTELLA REMOTA DI BACKUP ##################
        log.info(" ###################### ESECUZIONE METODO downloadBackupDb ########################");

        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_USER " + SyncOrigamiConstants.SERVER_FTP_SERVER_USER);
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD " + SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD);
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR " + SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR);
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR_OLD " + SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR_OLD);
        log.info("SyncOrigamiConstants.FTP_SERVER_NAME " + SyncOrigamiConstants.FTP_SERVER_NAME);
        log.info("SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR " + SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR);
        log.info("SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR_OLD " + SyncOrigamiConstants.SERVER_FTP_SERVER_IN_DIR_OLD);

        //##########################################################################
        Collection<String> downloadedFiles = null;
        try {
            downloadedFiles = UpdaterUtils.downloadAllFromFTP(
                    SyncOrigamiConstants.SERVER_FTP_SERVER_USER,
                    SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD,
                    SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR,
                    SyncOrigamiConstants.FTP_SERVER_NAME,
                    SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR,
                    SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR_OLD);

        } catch (IllegalStateException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPListParseException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FileNotFoundException ex) {
            log.error(ex);
            throw new InitializeException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPDataTransferException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPAbortedException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPIllegalReplyException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (IOException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        } catch (FTPException ex) {
            log.error(ex);
            throw new ComunicationException("ERRORE NEL TRASFERIMENTO DEL FILE " + ex);
        }

        //NESSUN FILE SCARICATO
        if (downloadedFiles.isEmpty()) {
            throw new FileToDownloadNotFoundException("NON SONO STATI TROVATI BACKUP DA SCARICARE SUL FTP");
        } else {

            //ORA HO TUTTI I NOMI DEI FILE DENTRO L'ARRAY
            for (String s : downloadedFiles) {
                log.info("Scaricato file: " + s);
            }

            //Troviamo tutte le MachineCredentials dei files scaricati
            Collection<MachineCredentials> mcIns = new ArrayList<MachineCredentials>();
            for (String fileIn : downloadedFiles) {
                //deve andare a prendere, leggendo dal nome del file, l'ID della macchina
                //e le credenziali per decomprimere il file

                MachineCredentials mc;
                try {
                    mc = UpdaterUtils.estraiDatiDaNomeFile(fileIn);
                } catch (NonValidParamException ex) {
                    log.error("IMPOSSIBILE PROCESSARE IL FILE");
                    throw new ProcessException("IMPOSSIBILE PROCESSARE IL FILE");
                }

                //A questo punto andiamo a prendere gli altri parametri della macchina dal DB
                try {

                    MachineCredentials mc1 = DataManagerS.getMachineCredentials(
                            mc.getIdMacchina(),
                            emf,
                            SyncOrigamiConstants.BKP_FILE_PFX);
                    mc.setFtpPassword(mc1.getFtpPassword());
                    mc.setFtpUser(mc1.getFtpUser());
                    mc.setZipPassword(mc1.getZipPassword());
                    mc.setLastUpdateDate(mc1.getLastUpdateDate());
                    mc.setLastUpdateVersion(mc1.getLastUpdateVersion());

                } catch (MachineCredentialsNotFoundException ex) {
                    log.error(ex);
                }
                log.info(" ############## Ecco il machine credentials ###########: " + mc.toString());
                mcIns.add(mc);

            }

            //Ora abbiamo tutti i MachineCredentials degli aggiornamenti ricevuti da tutte le macchine
            //a questo punto dobbiamo ordinare la collection per fare in modo che se
            //c'è più di un aggiornamento in coda per una singola macchina questo 
            //venga processato in ordine di versione
            //Ordiniamo la collection
            Collections.sort((List<MachineCredentials>) mcIns);

            log.info("DIMENSIONE COLLECTION MACHINE CREDENTIALS: " + mcIns.size());

            for (MachineCredentials mc : mcIns) {

                //LOG
                log.info("##############################################################");
                log.info("################ INIZIO LOOP MACHINE CREDENTIALS #############");
                log.info("##############################################################\n");

                String fileIn = mc.getCurrentUpdateFileNameCompletePath();

                try {

                    log.info("fileIn A " + fileIn);
                    log.info("fileIn.replaced A " + fileIn.replace(".zip", ".xml"));
                    log.info("SyncOrigamiConstants.SERVER_XML_DATA_IN_UNCOMPRESS_DIR " + SyncOrigamiConstants.SERVER_XML_DATA_IN_UNCOMPRESS_DIR);
                    log.info("mc.getZipPassword() " + mc.getZipPassword());

                    //Recupero del nome del file originale
                    //Estraggo il nome del file senza il nome della cartella
                    String splitRegex = Pattern.quote(System.getProperty("file.separator"));
                    String[] tmp = fileIn.split(splitRegex);

                    log.info("tmp[0] = DIRECTORY : " + tmp[0]);
                    log.info("tmp[1] = NOME DEL FILE .zip: " + tmp[1]);

                    String[] fileNameMenoEst = tmp[1].split("\\.");
                    mc.setCurrentUpdateFileName(fileNameMenoEst[0]);

                    String destFile = tmp[1].replace(".zip", ".xml");

                    log.info("destFile = NOME DEL FILE .xml: " + destFile);

                    FileUtils.copyFile(
                            new File(fileIn),
                            new File(fileIn.replace(SyncOrigamiConstants.SERVER_XML_DATA_IN_DOWNLOADED_DIR, SyncOrigamiConstants.SERVER_XML_DATA_IN_COMPRESS_DIR)));
                    FileUtils.delete(new File(fileIn));

                } catch (IOException ex) {
                    log.error(ex);
                    throw new ProcessException("IMPOSSIBILE SPOSTARE L'AGGIORNAMENTO " + fileIn + "NELLA CARTELLA DI BACKUP");
                }

                //LOG
                log.info("\n##############################################################");
                log.info("################ FINE CICLO MACHINE CREDENTIALS #############");
                log.info("##############################################################\n");

                //##################################################################
                boolean downloadCompleto = false;
                downloadCompleto = UpdaterUtils.renameFileFTP(
                        SyncOrigamiConstants.SERVER_FTP_SERVER_USER,
                        SyncOrigamiConstants.SERVER_FTP_SERVER_PASSWORD,
                        SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR,//.
                        SyncOrigamiConstants.FTP_SERVER_NAME,
                        SyncOrigamiConstants.SERVER_FTP_SERVER_IN_BKP_DIR_OLD,//old
                        mc.getCurrentUpdateFileName());

                if (downloadCompleto) {

                    log.info("MACHINE CREDENTIALS : " + mc.toString());

                } else {
                    log.info("DIMENSIONE COLLECTION MACHINE CREDENTIALS: " + mcIns.size());
                    log.info("MACHINE CREDENTIALS : " + mc.toString());
                    throw new ProcessException("DOWNLOAD NON COMPLETATO : il file " + mc.getCurrentUpdateFileName()
                            + " è stato SCARICATO ma non spostato nella cartella old del FTP");

                }

                //##################################################################
            }

            log.info("DOWNLOAD_COMPLETATO");
        }

    }

    /**
     * Metodo che prende la lista delle macchine dalla tabella macchina e chiama
     * il metodo uploadSingleMachineUpdate per ciascuna macchina, dunque
     * costruisce gli aggiornamenti per tutte le macchine
     *
     * @param emf
     * @throws DatiAggiornamentoNotFoundException
     * @throws InitializeException
     * @throws ProcessException
     * @throws ComunicationException
     * @throws MachineCredentialsNotFoundException
     */
    public static void uploadAllUpdates(EntityManagerFactory emf)
            throws InitializeException,
            ProcessException,
            ComunicationException,
            MachineCredentialsNotFoundException,
            ParseException {

        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
        //Recuperiamo la lista delle macchine da aggiornare
        Collection<Macchina> macchinaColl = new ArrayList();

//        macchinaColl = macchinaJc.findMacchinaAll();
        macchinaColl = macchinaJc.findMacchineAbilitate(SyncOrigamiConstants.ABILITATO);
        //Per ciascuna macchina generiamo l'aggiornamento
        int count = 0;
        int countAggNonCostruiti = 0;
        for (Macchina m : macchinaColl) {

            log.info("#### NUOVA MACCHINA : " + m);
            log.info("Macchina numero : " + count + " dell'elenco, con idMacchina = " + m.getIdMacchina());

            try {

                ServerProcess.uploadSingleMachineUpdate(emf, m.getIdMacchina());

            } catch (DatiAggiornamentoNotFoundException ex) {
                log.warn(ex);
                countAggNonCostruiti++;
                //ATTENZIONE : Non rilancio l'eccezione altrimenti non va avanti 
                //a costruire gli aggiornamenti per le altre macchine
                //throw new DatiAggiornamentoNotFoundException("ERROR :"+ex);
            } catch (ProcessException ex) {
                log.error(ex);
                throw new ProcessException("ERROR :" + ex);
            } catch (ComunicationException ex) {
                log.error(ex);
                throw new ComunicationException("ERROR :" + ex);
            } catch (MachineCredentialsNotFoundException ex) {
                log.error(ex);
                throw new MachineCredentialsNotFoundException("MachineCredentialsNotFound :" + ex);
            } catch (Exception ex) {
                log.warn("Errore durante la modifica del campo user_origami: " + ex);
            }
            count++;
        }

        log.info("Sono stati verificati i dati per " + count + " Macchine");
        log.info("Sono stati costruiti " + (count - countAggNonCostruiti) + " aggiornamenti");

    }

}
