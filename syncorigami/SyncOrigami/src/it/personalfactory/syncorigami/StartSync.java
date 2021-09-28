/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami;

import it.personalfactory.syncorigami.exceptions.*;
import it.personalfactory.syncorigami.process.ServerProcess;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.utils.EmailSender;
import it.personalfactory.syncorigami.utils.SyncOrigamiConstants;
import java.io.FileInputStream;
import java.text.ParseException;
import java.util.Properties;
import java.util.logging.Level;
import javax.mail.MessagingException;
import javax.mail.NoSuchProviderException;
import javax.mail.internet.AddressException;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;
import org.apache.log4j.Logger;
import org.apache.log4j.PropertyConfigurator;

/**
 *
 * @author marilisa
 */
public class StartSync {

    /**
     * @param args the command line arguments args[0] definisce il
     * sottoprogramma da caricare args[1..n] parametri 1...n dei programmi
     * args[1]= idMacchina
     *
     * ATTENZIONE: le eccezioni non vanno più rilanciate, ma gestite TOGLIERE
     * DAL THROWS del metodo main!!!!!!
     *
     * Per chiamare il programma sulla macchina basta importare la libreria
     * SyncOrigami e chiamare i metodi statici : es.
     * StartSync.downloadAggiornamentiDaServer() es.
     * StartSync.uploadAggiornamentiDaSingolaMacchina() Per richiamare il
     * programma sul server da shell #java -jar SyncOrigami.jar
     * uploadAggiornamentoDaServerPerMacchina #java -jar SyncOrigami.jar
     * downloadAggiornamentiDaMacchine 1
     */
    private static Logger log = Logger.getLogger(StartSync.class);

    //Server  
    private static final String UPLOAD_AGGIORNAMENTO_DA_SERVER_PER_MACCHINA = "uploadAggiornamentoDaServerPerMacchina";
    private static final String DOWNLOAD_AGGIORNAMENTI_DA_MACCHINE = "downloadAggiornamentiDaMacchine";
    private static final String DOWNLOAD_BACKUP_DA_MACCHINE = "downloadBackupDaMacchine";
    private static final String UPLOAD_AGGIORNAMENTI_DA_SERVER_PER_TUTTE_LE_MACCHINE = "uploadAggiornamentiDaServerPerTutteLeMacchine";
    private static final String serverPersistenceUnit = "SERVER_PU";
    private static final String propFileStr = "syncorigami.properties";
    //####### NOTIFICHE EMAIL ############################################
    private static final String mailSenderUser = "syncorigami@isolmix.com";
    private static final String mailSenderPassword = "syncorigamimail";
    private static final String mailHost = "smtp.gmail.com";
    private static final String mailAddressSender = "syncorigami@isolmix.com";
    private static final String mailAddressReceiver = "syncorigami@isolmix.com";
    private static final String mailObject = "ERRORE SYNCORIGAMI SERVER";
    private static final String mailPathFile = "/var/www/CloudFab/syncorigami/SyncOrigami/dist/log/syncorigami";

    public static void main(String[] args)
            throws
            NonValidParamException,
            ProcessException,
            NonexistentEntityException,
            Exception {

//Nota: per caricare il file di properties bisogna eseguire il programma come root 
        //           da terminale perchè altrimenti non si hanno i permessi
        Properties props = new Properties();
        props.load(new FileInputStream("./src/log4j.properties"));
        PropertyConfigurator.configure(props);

        //###########################################################################
        //#################### OGGETTO EMAIL SENDER #################################
        //###########################################################################
        EmailSender email = new EmailSender(
                mailSenderUser,
                mailSenderPassword,
                mailHost,
                mailAddressSender,
                mailAddressReceiver,
                mailObject,
                mailPathFile);

        log.info("############# ISTANZIATO OGGETTO EMAIL SENDER ################");
//##############################################################################
//############ CONTROLLO SUL PRIMO PARAMETRO DI INPUT ##########################
//##############################################################################

        if (!(args[0].equals(UPLOAD_AGGIORNAMENTO_DA_SERVER_PER_MACCHINA))
                && !(args[0].equals(UPLOAD_AGGIORNAMENTI_DA_SERVER_PER_TUTTE_LE_MACCHINE))
                && !(args[0].equals(DOWNLOAD_BACKUP_DA_MACCHINE))
                && !(args[0].equals(DOWNLOAD_AGGIORNAMENTI_DA_MACCHINE))) {
            throw new NonValidParamException("ERRORE SUL PRIMO ARGOMENTO : IL NOME DEL METODO DA ESEGUIRE NON E' VALIDO!");
        }

        //################### PROGRAMMI DA ESEGUIRE SUL SERVER #####################
        //##########################################################################
        //##### CARICA UN AGGIORNAMENTO DA SERVER PER SINGOLA MACCHINA SUL FTP #####
        //##########################################################################
        if (args[0].equals(UPLOAD_AGGIORNAMENTO_DA_SERVER_PER_MACCHINA)) {

            log.info("###### INIZIO METODO UPLOAD_AGGIORNAMENTO_DA_SERVER_PER_MACCHINA ######");
            //############ CONTROLLO SUL SECONDO PARAMETRO DI INPUT #################
            String idMacchinaStr = args[1];
            if (idMacchinaStr == null) {
                throw new NonValidParamException("ID MACCHINA NULL");
            }

            //Trasforma l'ID della macchina in intero
            Integer idMacchina = null;
            try {
                idMacchina = Integer.parseInt(idMacchinaStr);
            } catch (NumberFormatException e) {
                throw new NonValidParamException("PARAMETRO DI INPUT (ID MACCHINA) NON CORRETTO. NON E' UN NUMERO!");
            }
            if (idMacchina == null) {
                throw new NonValidParamException("ID MACCHINA CONVERTITO NULL");
            }

            try {

                uploadAggiornamentoDaServerPerMacchina(serverPersistenceUnit, idMacchina);

            } catch (MachineCredentialsNotFoundException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentoDaServerPerMacchina " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (DatiAggiornamentoNotFoundException ex) {
                log.warn(ex);

            } catch (InitializeException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentoDaServerPerMacchina " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ProcessException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentoDaServerPerMacchina " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ComunicationException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentoDaServerPerMacchina " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ParseException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentoDaServerPerMacchina " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            }
            log.info("###### FINE METODO UPLOAD_AGGIORNAMENTO_DA_SERVER_PER_MACCHINA ######");
            log.info("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@");

        }

        //##########################################################################
        //### CARICA GLI AGGIORNAMENTI DA SERVER PER TUTTE LE MACCHINE SUL FTP #####
        //##########################################################################
        if (args[0].equals(UPLOAD_AGGIORNAMENTI_DA_SERVER_PER_TUTTE_LE_MACCHINE)) {

            try {

                uploadAggiornamentiDaServerPerTutteLeMacchine(serverPersistenceUnit, propFileStr);

            } catch (MachineCredentialsNotFoundException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentiDaServerPerTutteLeMacchine " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (InitializeException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentiDaServerPerTutteLeMacchine " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ProcessException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentiDaServerPerTutteLeMacchine " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ComunicationException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentiDaServerPerTutteLeMacchine " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ParseException ex) {
                log.error(ex);
                try {
                    email.sendEmail("StartSyc.uploadAggiornamentiDaServerPerTutteLeMacchine " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            }

        }

        //##########################################################################
        //### SCARICA DAL FTP GLI AGGIORNAMENTI PROVENIENTI DA TUTTE LE MACCHINE ###
        //##########################################################################
        if (args[0].equals(DOWNLOAD_AGGIORNAMENTI_DA_MACCHINE)) {

            log.info("###### INIZIO METODO DOWNLOAD_AGGIORNAMENTI_DA_MACCHINE ######");
            try {

                ServerProcess.downloadAllUpdates(serverPersistenceUnit, propFileStr);

            } catch (InvalidUpdateContentException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadAllUpdates " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (FileToDownloadNotFoundException ex) {
                log.warn(ex);
                try {
                    email.sendEmail("ServerProcess.downloadAllUpdates " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (InvalidUpdateVersionException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadAllUpdates " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (InvalidUpdateTypeException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadAllUpdates " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (InitializeException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadAllUpdates " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ProcessException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadAllUpdates " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ComunicationException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadAllUpdates " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            }
            log.info("###### FINE METODO DOWNLOAD_AGGIORNAMENTI_DA_MACCHINE ######");
            log.info("@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@");
        }

        //##########################################################################
        //### SCARICA DAL FTP I BACKUP PROVENIENTI DA TUTTE LE MACCHINE ############
        //##########################################################################
        if (args[0].equals(DOWNLOAD_BACKUP_DA_MACCHINE)) {

            try {

                ServerProcess.downloadBackupDb(serverPersistenceUnit, propFileStr);

            } catch (InitializeException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadBackupDb " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ProcessException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadBackupDb " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            } catch (ComunicationException ex) {
                log.error(ex);
                try {
                    email.sendEmail("ServerProcess.downloadBackupDb " + ex.toString());
                } catch (AddressException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (NoSuchProviderException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                } catch (MessagingException ex1) {
                    log.error(ex + "INVIO EMAIL NON RIUSCITO! " + ex1);
                }
            }

        }

    }

    public static void uploadAggiornamentoDaServerPerMacchina(String serverPersistenceUnit, Integer idMacchina)
            throws InitializeException,
            DatiAggiornamentoNotFoundException,
            ProcessException,
            ComunicationException,
            MachineCredentialsNotFoundException,
            ParseException,
            Exception {

        log.info("############# INIZIO CREAZIONE PERSISTENCE UNIT ############");

        EntityManagerFactory emf = Persistence.createEntityManagerFactory(serverPersistenceUnit);

        log.info("############# FINE CREAZIONE PERSISTENCE UNIT ##############");

        try {

            log.info("######## INIZIO CARICAMENTO PROPRIETA DAL FILE syncorigami.properties");
            SyncOrigamiConstants.loadServerProperties(propFileStr);
            log.info("######## FINE CARICAMENTO PROPRIETA DAL FILE syncorigami.properties");

        } catch (InitializeException ex) {
            throw new InitializeException("ERRORE NEL CARICARE LE PROPRIETA' DEL SERVER");

        }

        try {

            ServerProcess.uploadSingleMachineUpdate(emf, idMacchina);

        } catch (DatiAggiornamentoNotFoundException ex) {
            throw ex;
        } catch (ProcessException ex) {
            throw ex;
        } catch (ComunicationException ex) {
            throw ex;
        } catch (MachineCredentialsNotFoundException ex) {
            throw ex;
        } catch (ParseException ex) {
            throw ex;
        } catch (Exception ex) {
            throw ex;
        }

    }

    public static void uploadAggiornamentiDaServerPerTutteLeMacchine(String serverPersistenceUnit, String propFileStr)
            throws InitializeException,
            ProcessException,
            ComunicationException,
            MachineCredentialsNotFoundException,
            ParseException,
            AddressException,
            NoSuchProviderException,
            MessagingException,
            DatiAggiornamentoNotFoundException {

        log.info("############# CREAZIONE PERSISTENCE UNIT : ");
        EntityManagerFactory emf = Persistence.createEntityManagerFactory(serverPersistenceUnit);
        log.info("############# FINE CREAZIONE PERSISTENCE UNIT.");

        try {

            log.info("######## CARICAMENTO PROPRIETA DAL FILE syncorigami.properties");
            SyncOrigamiConstants.loadServerProperties(propFileStr);
            log.info("######## FINE CARICAMENTO PROPRIETA DAL FILE syncorigami.properties");

        } catch (InitializeException ex) {
            log.error(ex);
            throw new InitializeException("ERRORE NEL CARICARE LE PROPRIETA' DEL SERVER");
        }

        try {

            ServerProcess.uploadAllUpdates(emf);

        } catch (ProcessException ex) {
            throw ex;
        } catch (ComunicationException ex) {
            throw ex;
        } catch (MachineCredentialsNotFoundException ex) {
            throw ex;
        } catch (ParseException ex) {
            throw ex;
        }
    }
}
