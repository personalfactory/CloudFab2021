/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.utils;

import it.personalfactory.syncorigami.exceptions.NonValidParamException;
import it.sauronsoftware.ftp4j.*;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import java.util.logging.Level;
import static javax.xml.XMLConstants.W3C_XML_SCHEMA_NS_URI;
import javax.xml.bind.JAXBContext;
import javax.xml.bind.JAXBException;
import javax.xml.bind.Marshaller;
import javax.xml.bind.Unmarshaller;
import javax.xml.bind.ValidationEvent;
import javax.xml.bind.ValidationEventHandler;
import javax.xml.validation.SchemaFactory;
import net.lingala.zip4j.core.ZipFile;
import net.lingala.zip4j.exception.ZipException;
import net.lingala.zip4j.model.ZipParameters;
import net.lingala.zip4j.util.Zip4jConstants;
import org.apache.commons.lang3.StringUtils;
import org.apache.log4j.Logger;
import org.xml.sax.SAXException;

/**
 *
 * @author marilisa
 */
public class UpdaterUtils {

    public static String MACCHINA_XML_DATA_IN_DOWNLOADED_DIR;
    private static Logger log = Logger.getLogger(UpdaterUtils.class);

//    /**
//     * Imposta la data utilizzata come valore di iniziale di default dei campi
//     * data
//     *
//     * @return dataDefault
//     */
//    public static Date dataDefault() {
//
//        Date dataDefault = null;
//        SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy - HH:mm:ss");
//        try {
//            dataDefault = sdf.parse("02/01/1970 - 00:00:00");
//        } catch (ParseException ex) {
//            log.error("Errore definizione della data di default");
//        }
//        return dataDefault;
//
//    }
    /**
     * <h1>Costruisce il nome del file in base alla data corrente ed alla
     * versione<h1> <p>Il formato del file deve essere:</br>
     * OUT_<ID_MACCHINA>_<VERSIONE_AGGIORNAMENTO>_<TS_CR_LOCALE>.xml</br>
     * dove:</br> SOUT</br> ID_MACCHINA è l'ID della macchina verso la quele si
     * costruisce l'aggiornamento</br> VERSIONE_AGGIONAMENTO è la versione
     * successiva a quella dell'ultimo aggiornamento memorizzato</br>
     * TS_CR_LOCALE è il timestamp locale (al server) di creazione
     * dell'aggiornamento. </br> <strong>Nota:</strong>L'estensione del file non
     * viene applicata in questo metodo </p>
     *
     * @param aggiornamentoOri aggiornamento costruito corrente
     * @return nome del file da applicare
     */
    public static String generaNomeFileOut(MachineCredentials mc, String nomeFile) {
        //String nomeFile = SyncOrigamiConstants.OUT_FILE_PFX;
        Integer idMacchinax = mc.getIdMacchina();
        String updateVersionx = mc.getNewRemoteUpdateVersion().toString();
        String ts = ((Long) System.currentTimeMillis()).toString();

        //################ AGGIUNTA DEGLI ZERI DAVANTI ALLA VERSIONE ###########
        //org.apache.commons.lang.StringUtils.leftPad("129018", 10, "0")
        updateVersionx = StringUtils.leftPad(updateVersionx, 6, "0");

        //######################################################################       

        nomeFile = nomeFile + "_" + idMacchinax + "_" + updateVersionx + "_" + ts;
        mc.setCurrentUpdateFileName(nomeFile);
        log.info("COSTRUITO NOME FILE DI SCAMBIO : " + nomeFile);
        return nomeFile;
    }

    public static MachineCredentials estraiDatiDaNomeFile(String nomeFile) throws NonValidParamException {
        MachineCredentials mc = new MachineCredentials();

        mc.setCurrentUpdateFileNameCompletePath(nomeFile);

        String[] datiFile = nomeFile.split("_");

        //log
        log.info("Esecuzione del metodo estraiDatiDaNomeFile ");
        log.info("nomeFile: " + nomeFile);
        log.info("Numero di parametri trovati: " + datiFile.length);
        int count = 0;
        for (String s : datiFile) {
            log.info("DATO " + count + " nel nome file: " + nomeFile + ": " + s);
            count++;
        }

        if (datiFile.length != 4) {
            throw new NonValidParamException("NOME DEL FILE: " + nomeFile + " NON CONFORME!!!");
        }

        mc.setIdMacchina(Integer.parseInt(datiFile[1]));
        //La nuova versione dell'aggiornamento viene presa dal nome del file
        mc.setNewRemoteUpdateVersion(Integer.parseInt(datiFile[2]));
        mc.setCurrentUpdateFileName(nomeFile);

        String[] tmp = datiFile[3].split("\\.");
        log.info("TS TROVATO: " + tmp[0] + " ESTENSIONE: " + tmp[1]);

        Date date = new Date(Long.parseLong(tmp[0]));
        mc.setNewRemoteUpdateTs(date);

//     Recupero il prefisso del nome del file, mi serve per distinguere gli aggiornamenti ordinari da quelli di backup
//     String[] tmpPfx = datiFile[0].split("/");
//     log.info("tmpPfx:" + tmpPfx[1]);
//     mc.setUpdateType(tmpPfx[1]);

        return mc;
    }

    /*
     * Metodo che crea, a partire dall'oggetto AggiornamentoOri l'XML di
     * trasferimento @param aggiornamentoOut @param destFileStr @return il path
     * completo al file appena creato @throws FileNotFoundException @throws
     * JAXBException
     */
    /**
     * Crea file xml a partire dall'oggetto objectOut, utilizzando le classi del
     * package jaxbPackageName (dove deve essere inserito il file jaxb.index) e
     * lo salva nella cartella destFileFolder
     *
     * @param objectOut oggetto di cui creare la versione xml con jaxb
     * @param fileName nome del file senza estensione
     * @param destFileFolder cartella nella quale meorizzare il file
     * @param jaxbPackageName
     * @return
     * @throws FileNotFoundException
     * @throws JAXBException
     */
    public static String createDataTransferXML(
            Object objectOut,
            String fileName,
            String destFileFolder, //MacchinaXMLDataOut - ServerXMLDataOut
            String jaxbPackageName,
            String xsdSchemaFile) throws FileNotFoundException,
            JAXBException,
            SAXException {
        //Salva in xml
        final String pathToFile = destFileFolder + File.separator + fileName + ".xml";


        log.info("Il path completo al file xml da creare è: " + pathToFile);
        final File destFile = new File(pathToFile);
        log.info("DestFile è: " + destFile);
        JAXBContext context = null;
        try {
            context = JAXBContext.newInstance(jaxbPackageName);
            Marshaller marshaller = context.createMarshaller();
            //MODIFICHE 9 APRILE 2014#####
            //VALIDAZIONE OGGETTO JAXB PRIMA DEL MARSHAL
            SchemaFactory sf = SchemaFactory.newInstance(W3C_XML_SCHEMA_NS_URI);
            URL schemaURL = Thread.currentThread().getContextClassLoader().getResource(xsdSchemaFile);
            //DefaultHandler will discard all the events, and the marshal() operation 
            //will throw a JAXBException if validation against the schema fails.
            try {
                marshaller.setSchema(sf.newSchema(schemaURL));
            } catch (SAXException ex) {
                throw ex;
            }
            //#################################################

            marshaller.marshal(objectOut.getClass().cast(objectOut), new FileOutputStream(destFile));
        } catch (FileNotFoundException ex) {
            throw ex;
        } catch (JAXBException ex) {
            throw ex;
        }
        return pathToFile;
    }

    public static String createDataTransferXML_1(
            Object objectOut,
            String fileName,
            String destFileFolder, //MacchinaXMLDataOut - ServerXMLDataOut
            String jaxbPackageName) throws FileNotFoundException,
            JAXBException {
        //Salva in xml
        final String pathToFile = destFileFolder + File.separator + fileName + ".xml";


//        log.info("Il path completo al file xml da creare è: " + pathToFile);
        final File destFile = new File(pathToFile);
        log.info("DestFile è: " + destFile);
        JAXBContext context = null;
        try {
            context = JAXBContext.newInstance(jaxbPackageName);
            Marshaller marshaller = context.createMarshaller();
            marshaller.marshal(objectOut.getClass().cast(objectOut), new FileOutputStream(destFile));
        } catch (FileNotFoundException ex) {
            throw ex;
        } catch (JAXBException ex) {
            throw ex;
        }
        return pathToFile;
    }

    /**
     * Comprime il file sourceFileName che si trova nel folder sourceFileFolder
     * e crea un file destZipFileName compresso nel folder destFolderName
     *
     * @param sourceFileName nome del file completo di estensione
     * @param sourceFolderName cartella nella quale si trova il file da
     * comprimere
     * @param destZipFileName nome del file compresso senza estensione
     * @param destFolderName cartella di destinazione del file compresso
     * @param password per la decompressione
     * @return
     * @throws ZipException
     */
    public static String compress(
            String sourceFileName,
            String sourceFolderName,
            String destZipFileName,
            String destFolderName,//ServerXMLDataZipOut
            String password) throws ZipException {

        String zipFileCompletePath = null;
        //COMPRIME IL FILE CON PASSWORD
        try {
            // Initiate ZipFile object with the path/name of the zip file.
            // Zip file may not necessarily exist. If zip file exists, then 
            // all these files are added to the zip file. If zip file does not
            // exist, then a new zip file is created with the files mentioned
            zipFileCompletePath = destFolderName + File.separator + destZipFileName + ".zip";
            ZipFile zipFile = new ZipFile(zipFileCompletePath);

            // Build the list of files to be added in the array list
            // Objects of type File have to be added to the ArrayList
            ArrayList filesToAdd = new ArrayList();
            filesToAdd.add(new File(sourceFolderName + File.separator + sourceFileName));

            // Initiate Zip Parameters which define various properties such
            // as compression method, etc. More parameters are explained in other
            // examples
            ZipParameters parameters = new ZipParameters();
            parameters.setCompressionMethod(Zip4jConstants.COMP_DEFLATE); // set compression method to deflate compression

            // Set the compression level. This value has to be in between 0 to 9
            // Several predefined compression levels are available
            // DEFLATE_LEVEL_FASTEST - Lowest compression level but higher speed of compression
            // DEFLATE_LEVEL_FAST - Low compression level but higher speed of compression
            // DEFLATE_LEVEL_NORMAL - Optimal balance between compression level/speed
            // DEFLATE_LEVEL_MAXIMUM - High compression level with a compromise of speed
            // DEFLATE_LEVEL_ULTRA - Highest compression level but low speed
            parameters.setCompressionLevel(Zip4jConstants.DEFLATE_LEVEL_ULTRA);

            // Set the encryption flag to true
            // If this is set to false, then the rest of encryption properties are ignored
            parameters.setEncryptFiles(true);

            // Set the encryption method to Standard Zip Encryption
            parameters.setEncryptionMethod(Zip4jConstants.ENC_METHOD_STANDARD);

            // Set password
            parameters.setPassword(password);

            // Now add files to the zip file
            // Note: To add a single file, the method addFile can be used
            // Note: If the zip file already exists and if this zip file is a split file
            // then this method throws an exception as Zip Format Specification does not 
            // allow updating split zip files
            zipFile.addFiles(filesToAdd, parameters);
        } catch (ZipException ex) {
            log.error("ERRORE NEL CREARE IL FILE ZIP" + ex.getMessage());
            throw ex;
        }
        return zipFileCompletePath;
    }

    /**
     * Trasferisce sul server FTP (ftpServerName) primario il file compresso 
     *
     * @param ftpServerUser
     * @param ftpServerPassword
     * @param sourceFileFolder
     * @param sourceFileName file da trasferire completo di estensione
     * @param ftpServerName
     * @param ftpServerDestDir
     * @param tranferedFileBackupDir
     * @return percorso completo del file trasferito nella cartella di backup
     * @throws FTPDataTransferException
     * @throws FTPAbortedException
     * @throws IOException
     * @throws FTPIllegalReplyException
     * @throws FTPException
     */
    public static String uploadToFTP(
            String ftpServerUser,
            String ftpServerPassword,
            String sourceFileFolder,
            String sourceFileName,
            String ftpServerName,
            String ftpServerDestDir,
            String tranferedFileBackupDir) throws FTPDataTransferException,
            FTPAbortedException,
            IOException,
            FTPIllegalReplyException,
            FTPException {

        //Upload  del file zip nella cartella s2m 
        //dell'utente macchina sul server ftp

        String completePathOfTranferFile = sourceFileFolder + File.separator + sourceFileName;

        FTPClient uploadClient = new FTPClient();
        try {
            uploadClient.connect(ftpServerName);
            uploadClient.login(ftpServerUser, ftpServerPassword);
            //configurazione del client
            uploadClient.setPassive(true); // Server passivo
            uploadClient.setType(FTPClient.TYPE_BINARY);
            //uploadClient.setSecurity(FTPClient.SECURITY_FTPS);
            //verifichiamo in quale directory siamo
            String dir = uploadClient.currentDirectory();
            log.info("Directory remota corrente : " + dir + "\n");
            //Siamo nella home della macchina
            //Ci spostiamo nella cartella s2m
            uploadClient.changeDirectory(ftpServerDestDir);
            log.info("Cambiata directory : " + ftpServerDestDir);
            //uploadiamo il file
            uploadClient.upload(new java.io.File(completePathOfTranferFile), new FTPFileTranferingListener());
            //Ci disconnettiamo
            disconnettiClient(uploadClient);
            
        } catch (FileNotFoundException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPDataTransferException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPAbortedException ex) {
            log.error(ex);
            throw ex;
        } catch (IllegalStateException ex) {
            log.error(ex);
        } catch (IOException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPIllegalReplyException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPException ex) {
            log.error(ex);
            throw ex;
        }



        return completePathOfTranferFile;

    }

    /**
     * Metodo che taglia il file sourceFileName dalla cartella sourceFileFolder 
     * alla cartella backupDir
     *
     * @param backupDir
     * @param sourceFileFolder
     * @param sourceFileName
     * @return
     */
    public static String cutFile(String backupDir, String sourceFileFolder, String sourceFileName) throws IOException {

        String transferedFile = "";
        try {
            //Muoviamo il file nella cartella backupDir
            transferedFile = backupDir + File.separator + sourceFileName;
            String completePathOfTranferFile = sourceFileFolder + File.separator + sourceFileName;
            FileUtils.copyFile(
                    new File(completePathOfTranferFile), new File(transferedFile));
            FileUtils.delete(new File(completePathOfTranferFile));
        } catch (IOException ex) {
            log.error(ex);
            throw ex;

        }

        return transferedFile;

    }

    public static String uploadToFTP_1(
            String ftpServerUser,
            String ftpServerPassword,
            String sourceFileFolder,
            String sourceFileName,
            String ftpServerName,
            String ftpServerDestDir,
            String tranferedFileBackupDir) throws FTPDataTransferException,
            FTPAbortedException,
            IOException,
            FTPIllegalReplyException,
            FTPException {

        //Upload dalla macchina : facciamo l'upload del file zip nella cartella home dell'utente server sul server ftp
        //Upload dal server: facciamo l'upload  del file zip nella cartella s2m dell'utente macchina sul server ftp

        String completePathOfTranferFile = sourceFileFolder + File.separator + sourceFileName;

        FTPClient uploadClient = new FTPClient();
        try {
            uploadClient.connect(ftpServerName);
            uploadClient.login(ftpServerUser, ftpServerPassword);
            //configurazione del client
            uploadClient.setPassive(true); // Server passivo
            uploadClient.setType(FTPClient.TYPE_BINARY);
            //verifichiamo in quale directory siamo
            String dir = uploadClient.currentDirectory();
            log.info("Directory remota: " + dir + "\n");
            //Dovremmo essere nella home della macchina...controllare
            //Ci spostiamo nella cartella s2m
            uploadClient.changeDirectory(ftpServerDestDir);
            log.info("Cambiata directory : " + ftpServerDestDir);
            //uploadiamo il file
            uploadClient.upload(new java.io.File(completePathOfTranferFile), new FTPFileTranferingListener());
            //uploadClient.disconnect(true);
            disconnettiClient(uploadClient);
        } catch (FileNotFoundException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPDataTransferException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPAbortedException ex) {
            log.error(ex);
            throw ex;
        } catch (IllegalStateException ex) {
            log.error(ex);
        } catch (IOException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPIllegalReplyException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPException ex) {
            log.error(ex);
            throw ex;
        }

        String transferedFile = "";
        try {
//            Muoviamo il file appena trasmesso nella cartella FTPTransferOUT
            transferedFile = tranferedFileBackupDir + File.separator + sourceFileName;
            FileUtils.copyFile(
                    new File(completePathOfTranferFile), new File(transferedFile));
            FileUtils.delete(new File(completePathOfTranferFile));
        } catch (IOException ex) {
            log.error(ex);
        }

        return transferedFile;

    }
    //TODO: DA AGGIUSTARE NEL CASO IN CUI CI SIANO PIU' FILE DA SCARICARE

    public static Collection<String> downloadAllFromFTP(
            String ftpServerUser,
            String ftpServerPassword,
            String remoteFileFolder,//s2m
            String ftpServerName,
            String localDestDir,//MacchinaXMLDataIn
            String remoteBackupDir)//old
            throws FTPListParseException,
            FileNotFoundException,
            FTPDataTransferException,
            FTPAbortedException,
            IOException,
            FTPIllegalReplyException,
            IllegalStateException,
            FTPException {
        //Download lato server: facciamo il download del file dalla cartella agg dell'utente server sul server ftp
        Collection<String> downloadedFiles = new ArrayList<String>();

        FTPClient downloadClient = new FTPClient();
        try {
            downloadClient.connect(ftpServerName);
            downloadClient.login(ftpServerUser, ftpServerPassword);
            //configurazione del client
            downloadClient.setPassive(true); // Server passivo
            downloadClient.setType(FTPClient.TYPE_BINARY);

            //verifichiamo in quale directory siamo
            //Download lato macchina: siamo nella home dell'utente macchina e dobbiamo spostarci nella cartella s2m
            //Download del server: siamo già nella home dell'utente server e non serve spostarci
            String dir = downloadClient.currentDirectory();
            log.info("Directory remota: " + dir + "\n");

            //Ci spostiamo nella cartella s2m/.
            downloadClient.changeDirectory(remoteFileFolder);

            //ORA SIAMO NEL FOLDER REMOTO
            log.info("CARTELLA REMOTA: " + downloadClient.currentDirectory());

            //Prendiamo la lista dei file da scaricare
            FTPFile[] list = downloadClient.list();

            for (FTPFile f : list) {

                //La distinzione tra i percorsi nei diversi sistemi operativi
                // è gestita nelle proprietà salvate nel db
                String destFileName = localDestDir + File.separator + f.getName();


                if (f.getType() == FTPFile.TYPE_FILE) {

                    downloadClient.download(
                            f.getName(),
                            new java.io.File(destFileName),
                            new FTPFileTranferingListener());

                    //TODO :Spostare il file solo se l'aggiornamento va a buon fine
                    //ora dobbiamo spostare il file remoto appena scaricato nella cartella old
                    //di backup del serverftp ... ricordarsi che siamo ancora dentro la cartella
                    //remota
                    //Attenzione: il comando rename se ha due dirpath differenti sposta il file!!!
//          log.info("RINOMINA FILE : " + f.getName() + " " + remoteBackupDir + File.separator + f.getName());
//          //Spostiamo il file scaricato nella cartella old
//          downloadClient.rename(f.getName(), remoteBackupDir + File.separator + f.getName());
//
//                    log.info("RINOMINA FILE : " + f.getName() + " " + remoteBackupDir + SyncOrigamiConstants.FTP_FILE_SEPARATOR + f.getName());
//                    downloadClient.rename(f.getName(), remoteBackupDir + SyncOrigamiConstants.FTP_FILE_SEPARATOR + f.getName());


                    //Alla fine aggiorniamo il vettore risultato
                    downloadedFiles.add(destFileName);

                } else {
                    if (f.getType() == FTPFile.TYPE_DIRECTORY) {
                        log.info("Trovata Directory : " + f.getName());
                    }
                    if (f.getType() == FTPFile.TYPE_LINK) {
                        log.info("Trovato link : " + f.getName());
                    }
                }
            }

            log.info("################### Completato metodo downloadAllFromFTP !");

        } catch (FileNotFoundException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPDataTransferException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPAbortedException ex) {
            log.error(ex);
            throw ex;
        } catch (IllegalStateException ex) {
            log.error(ex);
            throw ex;
        } catch (IOException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPIllegalReplyException ex) {
            log.error(ex);
            throw ex;
        } catch (FTPException ex) {
            log.error(ex);
        } finally {
            //disconnettiamo
            disconnettiClient(downloadClient);
        }
        return downloadedFiles;

    }
//#####################################################################

    /**
     * Metodo che consente di spostare un file dalla cartella s2m alla cartella
     * old del server FTP
     *
     * @param ftpServerUser
     * @param ftpServerPassword
     * @param remoteFileFolder
     * @param ftpServerName
     * @param remoteBackupDir
     * @param processedFileName
     * @return
     * @throws FTPListParseException
     * @throws FileNotFoundException
     * @throws FTPDataTransferException
     * @throws FTPAbortedException
     * @throws IOException
     * @throws FTPIllegalReplyException
     * @throws IllegalStateException
     * @throws FTPException
     */
    public static boolean renameFileFTP(
            String ftpServerUser,
            String ftpServerPassword,
            String remoteFileFolder,//agg
            String ftpServerName,
            String remoteBackupDir,//old
            String processedFileName)
            throws FTPListParseException,
            FileNotFoundException,
            FTPDataTransferException,
            FTPAbortedException,
            IOException,
            FTPIllegalReplyException,
            IllegalStateException,
            FTPException {

        FTPClient ftpClient = new FTPClient();
        boolean fileMoved = false;
        try {
            log.info("INIZIO METODO METODO renameFileFTP");
            log.info("Tentativo di connessione al FTP");
            ftpClient.connect(ftpServerName);
            log.info("Tentativo di login al FTP");
            ftpClient.login(ftpServerUser, ftpServerPassword);
            //configurazione del client
            ftpClient.setPassive(true); // Server passivo
            ftpClient.setType(FTPClient.TYPE_BINARY);

            //verifichiamo in quale directory siamo
            //Lato macchina: siamo nella home dell'utente macchina e dobbiamo spostarci nella cartella s2m
            //Lato server: siamo già nella home dell'utente server e non serve spostarci
            String dir = ftpClient.currentDirectory();
            log.info("Directory remota: " + dir + "\n");
            log.info("Siamo nel folder remoto");
            //Ci spostiamo nella cartella s2m/.
            ftpClient.changeDirectory(remoteFileFolder);

            //ORA SIAMO NEL FOLDER REMOTO
            log.info("CARTELLA REMOTA: " + ftpClient.currentDirectory());

            //Prendiamo la lista dei file da scaricare
            FTPFile[] list = ftpClient.list();

            for (FTPFile f : list) {

                log.info("Recupero il nome del file appena processato sul FTP senza estensione .zip");
                log.info("processedFileName : " + processedFileName);
                //Recupero il nome del file sul FTP senza estensione .zip
                String[] fileFTPName = f.getName().split("\\.");
                String fileNameFTP = fileFTPName[0];
                log.info("fileNameFTP : " + fileNameFTP);

                if (f.getType() == FTPFile.TYPE_FILE & fileNameFTP.equals(processedFileName)) {

                    //Attenzione: il comando rename se ha due dirpath differenti sposta il file!!! 
                    ftpClient.rename(f.getName(), remoteBackupDir + SyncOrigamiConstants.FTP_FILE_SEPARATOR + f.getName());
                    fileMoved = true;
                    log.info("RINOMINATO FILE : " + f.getName() + " " + remoteBackupDir + SyncOrigamiConstants.FTP_FILE_SEPARATOR + f.getName());
                    log.info("SPOSTATO FILE");

                }
//                else {
//
//                    if (f.getType() == FTPFile.TYPE_DIRECTORY) {
//                        log.info("Trovata Directory : " + f.getName());
//                    }
//                    if (f.getType() == FTPFile.TYPE_LINK) {
//                        log.info("Trovato link : " + f.getName());
//                    }
//                    if (!fileNameFTP.equals(processedFileName)) {
//                        log.info("File ftp : " + f.getName());
//                        log.info("File processato : " + processedFileName);
//                    }
//                }
            }


        } catch (FileNotFoundException ex) {
            log.error(ex + "FILE PROCESSATO NON TROVATO SU FTP");
            throw ex;
        } catch (FTPAbortedException ex) {
            log.error(ex + "CONNESSIONE INTERROTTA! IMPOSSIBILE SPOSTARE IL FILE PROCESSATO NELLA CATELLA old DEL FTP");
            throw ex;
        } catch (IllegalStateException ex) {
            log.error(ex + "CONNESSIONE INTERROTTA! IMPOSSIBILE SPOSTARE IL FILE PROCESSATO NELLA CATELLA old DEL FTP");
            throw ex;
        } catch (IOException ex) {
            log.error(ex + "CONNESSIONE INTERROTTA! IMPOSSIBILE SPOSTARE IL FILE PROCESSATO NELLA CATELLA old DEL FTP");
            throw ex;
        } catch (FTPIllegalReplyException ex) {
            log.error(ex + "CONNESSIONE INTERROTTA! IMPOSSIBILE SPOSTARE IL FILE PROCESSATO NELLA CATELLA old DEL FTP");
            throw ex;
        } catch (FTPException ex) {
            log.error(ex + "CONNESSIONE INTERROTTA! IMPOSSIBILE SPOSTARE IL FILE PROCESSATO NELLA CATELLA old DEL FTP");
            throw ex;
        } finally {
            //disconnettiamo
            disconnettiClient(ftpClient);
            return fileMoved;
        }


    }

    public static String uncompress(
            String sourceCompressedFileCompletePath,
            String destFileName,
            String destFileFolder,
            String zipPassword) throws ZipException {
        //DECOMPRIMIAMO IL FILE PROTETTO DA PASSWORD
        try {
//      
//     
//      //TODO: PEZZA DA CAMBIARE!!! Sostiutuisce null con vuoto
//      destFileName = destFileName.replace(SyncOrigamiConstants.MACCHINA_XML_DATA_IN_DOWNLOADED_DIR + File.separator, "");
//      

            log.info("SOURCE FILE: " + sourceCompressedFileCompletePath);
            log.info("DEST FILE NAME:  " + destFileName);
            log.info("DEST FILE FOLDER " + destFileFolder);

            // Initiate ZipFile object with the path/name of the zip file.
            ZipFile zipFile = new ZipFile(sourceCompressedFileCompletePath);

            // Check to see if the zip file is password protected 
            if (zipFile.isEncrypted()) {
                // if yes, then set the password for the zip file
                zipFile.setPassword(zipPassword);
            }

            // Specify the file name which has to be extracted and the path to which
            // this file has to be extracted
            zipFile.extractFile(destFileName, destFileFolder);

            // Note that the file name is the relative file name in the zip file.
            // For example if the zip file contains a file "mysong.mp3" in a folder 
            // "FolderToAdd", then extraction of this file can be done as below:
            //EG. zipFile.extractFile("FolderToAdd\\myvideo.avi", "c:\\ZipTest\\");

        } catch (ZipException ex) {
            log.error(ex);
            throw ex;
        }

        log.info("FILE DEST COMPLETE PATH: " + destFileFolder + File.separator + destFileName);

        return destFileFolder + File.separator + destFileName;
    }

    public static Object retrieveData(
            String jaxbPackageName,
            String xsdSchemaFile,
            String xmlSourceFileCompletePath) {
        //Ora leggiamo dall'xml
        Unmarshaller unmarshaller;
        Object result = null;
        JAXBContext context = null;
        try {
            context = JAXBContext.newInstance(jaxbPackageName);
            unmarshaller = context.createUnmarshaller();
            SchemaFactory sf = SchemaFactory.newInstance(W3C_XML_SCHEMA_NS_URI);
            //URL schemaURL = TestJAXB.class.getResource("META-INF/schema1.xsd");
            URL schemaURL = Thread.currentThread().getContextClassLoader().getResource(xsdSchemaFile);
            unmarshaller.setSchema(sf.newSchema(schemaURL));
            result = unmarshaller.unmarshal(
                    new File(xmlSourceFileCompletePath));
        } catch (SAXException ex) {
            log.error(ex);
        } catch (JAXBException ex) {
            log.error(ex);
        }

        return result;

    }

    private static void disconnettiClient(FTPClient downloadClient) {
        //IllegalStateException Client not connected
        if (downloadClient.isConnected()) {
            log.warn("Il client risulta connesso! Proviamo a disconnetterci");
            try {

                downloadClient.disconnect(true);

            } catch (IllegalStateException ex) {
                log.error("IMPOSSIBILE CHIUDERE LA CONNESSIONE FTP CON IL COMANDO DI LIBRERIA...CMQ CONTINUIAMO!!!" + ex);
            } catch (FTPIllegalReplyException ex) {
                log.error("IMPOSSIBILE CHIUDERE LA CONNESSIONE FTP CON IL COMANDO DI LIBRERIA...CMQ CONTINUIAMO!!!" + ex);
            } catch (FTPException ex) {
                log.error("IMPOSSIBILE CHIUDERE LA CONNESSIONE FTP CON IL COMANDO DI LIBRERIA...CMQ CONTINUIAMO!!!" + ex);
            } catch (IOException ex) {
                log.error("IMPOSSIBILE CHIUDERE LA CONNESSIONE FTP CON IL COMANDO DI LIBRERIA...CMQ CONTINUIAMO!!!" + ex);
            }

        } else {

            log.warn("Il client risulta già disconnesso! Non proviamo a disconnetterci!");
        }
    }
}
