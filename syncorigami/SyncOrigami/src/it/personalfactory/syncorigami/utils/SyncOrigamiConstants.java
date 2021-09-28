/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.utils;

import it.personalfactory.syncorigami.exceptions.InitializeException;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Properties;
import org.apache.log4j.Logger;

/**
 *
 * @author marilisa
 */
public class SyncOrigamiConstants {

  private static Logger log = Logger.getLogger(SyncOrigamiConstants.class);
  //COSTANTI DEL FILE DI PROPERTIES
  private static final String SERVER_PFX = "server.";
  private static final String MACCHINA_PFX = "macchina.";
  private static final String OUT_FILE_PFX_PROP = "out.file.pfx";
  private static final String IN_FILE_PFX_PROP = "in.file.pfx";
  private static final String BKP_FILE_PFX_PROP = "bkp.file.pfx";
  private static final String FIELD_DELIMITER_PROP = "field.delimiter";
  private static final String DATA_DEFAULT_PROP = "data.default";
  private static final String ABILITATO_PROP = "abilitato";
  private static final String XSD_MACCHINA_FILE_PROP = "xsd.macchina.file";
  private static final String XSD_SERVER_FILE_PROP = "xsd.server.file";
  private static final String FTP_SERVER_NAME_PROP = "ftp.server.name";
  private static final String FTP_SERVER_PORT_PROP = "ftp.server.port";
  private static final String FTP_SERVER_MIRROR_LIST_PROP = "ftp.server.mirror.list";
  private static final String FTP_FILE_SEPARATOR_PROP = "ftp.file.separator";
  private static final String JAXB_INDEX_FILE_NAME_PROP = "jaxb.index.file.name";
  private static final String XML_SCHEMA_DEST_FILE_NAME_PROP = "xml.schema.dest.file.name";
  private static final String XML_DATA_OUT_GENERATE_DIR_PROP = "xml.data.out.generate.dir";
  private static final String XML_DATA_OUT_COMPRESS_DIR_PROP = "xml.data.out.compress.dir";
  private static final String XML_DATA_IN_COMPRESS_DIR_PROP = "xml.data.in.compress.dir";
  private static final String XML_DATA_IN_UNCOMPRESS_DIR_PROP = "xml.data.in.uncompress.dir";
  private static final String JAXB_INPUT_PACKAGE_NAME_PROP = "jaxb.package.name";
  private static final String JAXB_OUTPUT_PACKAGE_NAME_PROP = "jaxb.output.package.name";
  private static final String XML_DATA_IN_DOWNLOADED_DIR_PROP = "xml.data.in.downloaded.dir";
  private static final String XML_DATA_OUT_TRANSFERED_DIR_PROP = "xml.data.out.transfered.dir";
  private static final String FTP_SERVER_OUT_DIR_PROP = "ftp.server.out.dir";
  private static final String FTP_SERVER_OUT_BKP_DIR_PROP = "ftp.server.out.bkp.dir";
  private static final String FTP_SERVER_IN_DIR_PROP = "ftp.server.in.dir";
  private static final String FTP_SERVER_IN_DIR_OLD_PROP = "ftp.server.in.dir.old";
  private static final String FTP_SERVER_IN_BKP_DIR_PROP = "ftp.server.in.bkp.dir";
  private static final String FTP_SERVER_IN_BKP_DIR_OLD_PROP = "ftp.server.in.bkp.dir.old";
  private static final String SERVER_FTP_SERVER_USER_PROP = "server.ftp.server.user";
  private static final String SERVER_FTP_SERVER_PASSWORD_PROP = "server.ftp.server.password";
  private static final String SO_WINDOWS_PFX = "windows.";
  
    
  
//  private static String MAIL_SENDER_USER_PROP="mail.sender.user";
//  private static String MAIL_SENDER_PASSWORD_PROP="mail.sender.password";
//  private static String MAIL_HOST_PROP="mail.host";
//  private static String MAIL_ADDRESS_SENDER_PROP="mail.address.sender";
//  private static String MAIL_ADDRESS_RECEIVER_PROP="mail.address.receiver";
//  private static String MAIL_OBJECT_PROP="mail.object";
//  private static String MAIL_PATH_FILE_PROP="mail.path.file";
   
  
  //VARIABILI INTERNE CHE CONTENGONO I DATI PRESENTI NEL FILE DI PROPERTIES PER IL SERVER
  public static String OUT_FILE_PFX;
  public static String IN_FILE_PFX;
  public static String BKP_FILE_PFX;
  public static String FIELD_DELIMITER;
  public static Date DATA_DEFAULT;
  public static boolean ABILITATO;
  public static String XSD_MACCHINA_FILE_NAME;
  public static String XSD_SERVER_FILE_NAME;
  public static String FTP_SERVER_NAME;
  public static String FTP_SERVER_PORT;
  public static String[] FTP_SERVER_MIRROR_LIST;
  public static String FTP_FILE_SEPARATOR;
  public static String JAXB_INDEX_FILE_NAME;
  public static String SERVER_XML_SCHEMA_DEST_FILE_NAME;
  public static String SERVER_XML_DATA_OUT_GENERATE_DIR;
  public static String SERVER_XML_DATA_OUT_COMPRESS_DIR;
  public static String SERVER_XML_DATA_IN_COMPRESS_DIR;
  public static String SERVER_XML_DATA_IN_UNCOMPRESS_DIR;
  //public static String SERVER_PERSISTENCE_UNIT;
  public static String SERVER_JAXB_INPUT_PACKAGE_NAME;
  public static String SERVER_JAXB_OUTPUT_PACKAGE_NAME;
  public static String SERVER_XML_DATA_IN_DOWNLOADED_DIR;
  public static String SERVER_XML_DATA_OUT_TRANSFERED_DIR;
  public static String SERVER_FTP_SERVER_OUT_DIR;
  public static String SERVER_FTP_SERVER_IN_DIR;
  public static String SERVER_FTP_SERVER_IN_DIR_OLD;
  public static String SERVER_FTP_SERVER_IN_BKP_DIR;
  public static String SERVER_FTP_SERVER_IN_BKP_DIR_OLD;
  public static String SERVER_FTP_SERVER_USER;
  public static String SERVER_FTP_SERVER_PASSWORD;
  
  public static String SERVER_SYNCORIGAMI_SFTW_VERSION;
  
  
  //VARIABILI INTERNE CHE CONTENGONO I DATI PRESENTI NEL FILE DI PROPERTIES PER LA MACCHINA
  public static String MACCHINA_XML_SCHEMA_DEST_FILE_NAME;
  public static String MACCHINA_XML_DATA_OUT_GENERATE_DIR;
  public static String MACCHINA_XML_DATA_OUT_COMPRESS_DIR;
  public static String MACCHINA_XML_DATA_IN_COMPRESS_DIR;
  public static String MACCHINA_XML_DATA_IN_UNCOMPRESS_DIR;
  //public static String MACCHINA_PERSISTENCE_UNIT;
  public static String MACCHINA_JAXB_INPUT_PACKAGE_NAME;
  public static String MACCHINA_JAXB_OUTPUT_PACKAGE_NAME;
  public static String MACCHINA_XML_DATA_IN_DOWNLOADED_DIR;
  public static String MACCHINA_XML_DATA_OUT_TRANSFERED_DIR;
  public static String MACCHINA_FTP_SERVER_OUT_DIR;
  public static String MACCHINA_FTP_SERVER_OUT_BKP_DIR;
  public static String MACCHINA_FTP_SERVER_IN_DIR;
  public static String MACCHINA_FTP_SERVER_IN_DIR_OLD;
  public static String MACCHINA_FTP_SERVER_IN_BKP_DIR;
  public static InputStream xsdM;
  public static InputStream xsdS;
  
  //VARIABILI UTILI ALL'INVIO DELLE NOTIFICHE PER MAIL
//  public static String MAIL_SENDER_USER;
//  public static String MAIL_SENDER_PASSWORD;
//  public static String MAIL_HOST;
//  public static String MAIL_ADDRESS_SENDER;
//  public static String MAIL_ADDRESS_RECEIVER;
//  public static String MAIL_OBJECT;
//  public static String MAIL_PATH_FILE;
  
  
  

  //############################################################################
  //#################### CARICO LE PROPERTIES DAL FILE #########################
  //############################################################################
  /**
   * Metodo private che carica le proprietà comuni al server ed alle macchine
   * prendendole dal file syncorigami.properties
   *
   * @param propFileStr
   * @throws InitializeException
   */
  private static void loadCommonProperties(String propFileStr) throws InitializeException {
    //legge dal file di properties i valori da inserire
    Properties prop = new Properties();
    try {
      FileInputStream fis = new FileInputStream(propFileStr);
      prop.load(fis);
      //Carichiamo i valori dal file di properties

      FIELD_DELIMITER = prop.getProperty(FIELD_DELIMITER_PROP);
      log.info("FIELD_DELIMITER: " + FIELD_DELIMITER);

      //Formatto la data di default
      DATA_DEFAULT = null;
      SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy - HH:mm:ss");
      DATA_DEFAULT = sdf.parse(prop.getProperty(DATA_DEFAULT_PROP));
      log.info("DATA_DEFAULT: " + DATA_DEFAULT);

      XSD_MACCHINA_FILE_NAME = prop.getProperty(XSD_MACCHINA_FILE_PROP);
      log.info("XSD_MACCHINA_FILE_NAME = " + XSD_MACCHINA_FILE_NAME);

      XSD_SERVER_FILE_NAME = prop.getProperty(XSD_SERVER_FILE_PROP);
      log.info("XSD_SERVER_FILE_NAME = " + XSD_SERVER_FILE_NAME);

      FTP_SERVER_NAME = prop.getProperty(FTP_SERVER_NAME_PROP);
      log.info("FTP_SERVER_NAME = " + FTP_SERVER_NAME);

      FTP_SERVER_PORT = prop.getProperty(FTP_SERVER_PORT_PROP);
      log.info("FTP_SERVER_PORT = " + FTP_SERVER_PORT);

      String ftpServerMirrorListStr = prop.getProperty(FTP_SERVER_MIRROR_LIST_PROP);
      FTP_SERVER_MIRROR_LIST = ftpServerMirrorListStr.split(FIELD_DELIMITER);
      int count = 0;
      for (String s : FTP_SERVER_MIRROR_LIST) {
        log.info("server " + count + " = " + s);
        count++;
      }

      FTP_FILE_SEPARATOR = prop.getProperty(FTP_FILE_SEPARATOR_PROP);
      log.info("FTP_FILE_SEPARATOR = " + FTP_FILE_SEPARATOR);

      SERVER_FTP_SERVER_USER = prop.getProperty(SERVER_FTP_SERVER_USER_PROP);
      log.info("SERVER_FTP_SERVER_USER = " + SERVER_FTP_SERVER_USER);

      SERVER_FTP_SERVER_PASSWORD = prop.getProperty(SERVER_FTP_SERVER_PASSWORD_PROP);
      log.info("SERVER_FTP_SERVER_PASSWORD = " + SERVER_FTP_SERVER_PASSWORD);

      OUT_FILE_PFX = prop.getProperty(OUT_FILE_PFX_PROP);
      log.info("OUT_FILE_PFX = " + OUT_FILE_PFX);

      IN_FILE_PFX = prop.getProperty(IN_FILE_PFX_PROP);
      log.info("IN_FILE_PFX = " + IN_FILE_PFX);

      BKP_FILE_PFX = prop.getProperty(BKP_FILE_PFX_PROP);
      log.info("BKP_FILE_PFX = " + BKP_FILE_PFX);
            

    } catch (IOException ioe) {
      throw new InitializeException("ERRORE NEL CARICARE IL FILE DI PROPERTIES: " + ioe.getMessage());
    } catch (ParseException ex) {
      throw new InitializeException("Errore di definizione della data di default: " + ex.getMessage());
    }

    //####### LOG TEST 
    log.info("@## UpdaterUtils.class.getClassLoader() è " + UpdaterUtils.class.getClassLoader());
    log.info("@## UpdaterUtils.class.getClassLoader().getResourceAsStream è " + UpdaterUtils.class.getClassLoader().getResourceAsStream(XSD_MACCHINA_FILE_NAME));

    xsdM = UpdaterUtils.class.getClassLoader().getResourceAsStream(XSD_MACCHINA_FILE_NAME);
    xsdS = UpdaterUtils.class.getClassLoader().getResourceAsStream(XSD_SERVER_FILE_NAME);

    if (xsdM != null) {
      log.info("FILE " + XSD_MACCHINA_FILE_NAME + " TROVATO");
    } else {
      throw new InitializeException("FILE " + XSD_MACCHINA_FILE_NAME + " NON TROVATO!!!");
    }
    if (xsdS != null) {
      log.info("FILE " + XSD_SERVER_FILE_NAME + " TROVATO");
    } else {
      throw new InitializeException("FILE " + XSD_SERVER_FILE_NAME + " NON TROVATO!!!");
    }
  }

  /**
   * <em>Testato e verificato<em> Metodo che carica le proprietà del server
   * memorizzate nel file di configurazione syncorigami.properties che gli
   * viene passato come argomento
   *
   * @param propFileStr String contenente il file da caricare
   * @throws InitializeException
   */
  public static void loadServerProperties(String propFileStr) throws InitializeException {
    loadCommonProperties(propFileStr);

    //legge dal file di properties i valori da inserire
    Properties prop = new Properties();
    try {
      FileInputStream fis = new FileInputStream(propFileStr);
      prop.load(fis);

      //Carichiamo i valori dal file di properties
      SERVER_XML_SCHEMA_DEST_FILE_NAME = prop.getProperty(SERVER_PFX + XML_SCHEMA_DEST_FILE_NAME_PROP);
      log.info("SERVER_XML_SCHEMA_DEST_FILE_NAME = " + SERVER_XML_SCHEMA_DEST_FILE_NAME);

      SERVER_XML_DATA_OUT_GENERATE_DIR = prop.getProperty(SERVER_PFX + XML_DATA_OUT_GENERATE_DIR_PROP);
      log.info("SERVER_XML_DATA_OUT_GENERATE_DIR = " + SERVER_XML_DATA_OUT_GENERATE_DIR);

      SERVER_XML_DATA_OUT_COMPRESS_DIR = prop.getProperty(SERVER_PFX + XML_DATA_OUT_COMPRESS_DIR_PROP);
      log.info("SERVER_XML_DATA_OUT_COMPRESS_DIR = " + SERVER_XML_DATA_OUT_COMPRESS_DIR);

      SERVER_XML_DATA_IN_COMPRESS_DIR = prop.getProperty(SERVER_PFX + XML_DATA_IN_COMPRESS_DIR_PROP);
      log.info("SERVER_XML_DATA_IN_COMPRESS_DIR = " + SERVER_XML_DATA_IN_COMPRESS_DIR);

      SERVER_XML_DATA_IN_UNCOMPRESS_DIR = prop.getProperty(SERVER_PFX + XML_DATA_IN_UNCOMPRESS_DIR_PROP);
      log.info("SERVER_XML_DATA_IN_UNCOMPRESS_DIR = " + SERVER_XML_DATA_IN_UNCOMPRESS_DIR);

      SERVER_JAXB_INPUT_PACKAGE_NAME = prop.getProperty(SERVER_PFX + JAXB_INPUT_PACKAGE_NAME_PROP);
      log.info("SERVER_JAXB_INPUT_PACKAGE_NAME = " + SERVER_JAXB_INPUT_PACKAGE_NAME);

      SERVER_FTP_SERVER_OUT_DIR = prop.getProperty(SERVER_PFX + FTP_SERVER_OUT_DIR_PROP);
      log.info("SERVER_FTP_SERVER_OUT_DIR = " + SERVER_FTP_SERVER_OUT_DIR);

      SERVER_FTP_SERVER_IN_DIR = prop.getProperty(SERVER_PFX + FTP_SERVER_IN_DIR_PROP);
      log.info("SERVER_FTP_SERVER_IN_DIR = " + SERVER_FTP_SERVER_IN_DIR);

      SERVER_FTP_SERVER_IN_DIR_OLD = prop.getProperty(SERVER_PFX + FTP_SERVER_IN_DIR_OLD_PROP);
      log.info("SERVER_FTP_SERVER_IN_DIR_OLD = " + SERVER_FTP_SERVER_IN_DIR_OLD);

      SERVER_FTP_SERVER_IN_BKP_DIR = prop.getProperty(SERVER_PFX + FTP_SERVER_IN_BKP_DIR_PROP);
      log.info("SERVER_FTP_SERVER_IN_BKP_DIR = " + SERVER_FTP_SERVER_IN_BKP_DIR);

      SERVER_FTP_SERVER_IN_BKP_DIR_OLD = prop.getProperty(SERVER_PFX + FTP_SERVER_IN_BKP_DIR_OLD_PROP);
      log.info("SERVER_FTP_SERVER_IN_BKP_DIR_OLD = " + SERVER_FTP_SERVER_IN_BKP_DIR_OLD);

      SERVER_XML_DATA_IN_DOWNLOADED_DIR = prop.getProperty(SERVER_PFX + XML_DATA_IN_DOWNLOADED_DIR_PROP);
      log.info("SERVER_XML_DATA_IN_DOWNLOADED_DIR = " + SERVER_XML_DATA_IN_DOWNLOADED_DIR);

      SERVER_XML_DATA_OUT_TRANSFERED_DIR = prop.getProperty(SERVER_PFX + XML_DATA_OUT_TRANSFERED_DIR_PROP);
      log.info("SERVER_XML_DATA_OUT_TRANSFERED_DIR = " + SERVER_XML_DATA_OUT_TRANSFERED_DIR);

      SERVER_JAXB_OUTPUT_PACKAGE_NAME = prop.getProperty(SERVER_PFX + JAXB_OUTPUT_PACKAGE_NAME_PROP);
      log.info("SERVER_JAXB_OUTPUT_PACKAGE_NAME = " + SERVER_JAXB_OUTPUT_PACKAGE_NAME);

      ABILITATO = Boolean.parseBoolean(prop.getProperty(ABILITATO_PROP));
      log.info("ABILITATO = " + ABILITATO);
      
           
//      MAIL_SENDER_USER = prop.getProperty(MAIL_SENDER_USER_PROP);
//      log.info("MAIL_SENDER_USER = " + MAIL_SENDER_USER);
//      
//      MAIL_SENDER_PASSWORD = prop.getProperty(MAIL_SENDER_PASSWORD_PROP);
//      log.info("MAIL_SENDER_PASSWORD = " + MAIL_SENDER_PASSWORD);
//      
//      MAIL_HOST = prop.getProperty(MAIL_HOST_PROP);
//      log.info("MAIL_HOST = " + MAIL_HOST);
//      
//      MAIL_ADDRESS_SENDER = prop.getProperty(MAIL_ADDRESS_SENDER_PROP);
//      log.info("MAIL_ADDRESS_SENDER = " + MAIL_ADDRESS_SENDER);
//      
//      MAIL_ADDRESS_RECEIVER = prop.getProperty(MAIL_ADDRESS_RECEIVER_PROP);
//      log.info("MAIL_ADDRESS_RECEIVER = " + MAIL_ADDRESS_RECEIVER);
//      
//      MAIL_OBJECT = prop.getProperty(MAIL_OBJECT_PROP);
//      log.info("MAIL_OBJECT = " + MAIL_OBJECT);
//      
//      MAIL_PATH_FILE = prop.getProperty(MAIL_PATH_FILE_PROP);
//      log.info("MAIL_PATH_FILE = " + MAIL_PATH_FILE);
     
          
      
      
    } catch (IOException ioe) {
      throw new InitializeException("ERRORE NEL CARICARE IL FILE DI PROPERTIES: " + ioe.getMessage());
    }


  }

  /**
   * <em>Testato e verificato<em> Metodo che carica le proprietà della
   * macchina memorizzate nel file di configurazione syncorigami.properties
   * che viene passato come argomento
   *
   * @param propFileStr String contenente il file da caricare
   * @throws InitializeException
   */
  public static void loadMacchinaProperties(String propFileStr) throws InitializeException {
    loadCommonProperties(propFileStr);

    //legge dal file di properties i valori da inserire
    Properties prop = new Properties();
    try {
      FileInputStream fis = new FileInputStream(propFileStr);
      prop.load(fis);
      //Carichiamo i valori dal file di properties

      MACCHINA_XML_SCHEMA_DEST_FILE_NAME = prop.getProperty(MACCHINA_PFX + XML_SCHEMA_DEST_FILE_NAME_PROP);
      log.info("MACCHINA_XML_SCHEMA_DEST_FILE_NAME = " + MACCHINA_XML_SCHEMA_DEST_FILE_NAME);

      MACCHINA_XML_DATA_OUT_GENERATE_DIR = prop.getProperty(MACCHINA_PFX + XML_DATA_OUT_GENERATE_DIR_PROP);
      log.info("MACCHINA_XML_DATA_OUT_GENERATE_DIR = " + MACCHINA_XML_DATA_OUT_GENERATE_DIR);

      MACCHINA_XML_DATA_OUT_COMPRESS_DIR = prop.getProperty(MACCHINA_PFX + XML_DATA_OUT_COMPRESS_DIR_PROP);
      log.info("MACCHINA_XML_DATA_OUT_COMPRESS_DIR = " + MACCHINA_XML_DATA_OUT_COMPRESS_DIR);

      MACCHINA_XML_DATA_IN_COMPRESS_DIR = prop.getProperty(MACCHINA_PFX + XML_DATA_IN_COMPRESS_DIR_PROP);
      log.info("MACCHINA_XML_DATA_IN_COMPRESS_DIR = " + MACCHINA_XML_DATA_IN_COMPRESS_DIR);

      MACCHINA_XML_DATA_IN_UNCOMPRESS_DIR = prop.getProperty(MACCHINA_PFX + XML_DATA_IN_UNCOMPRESS_DIR_PROP);
      log.info("MACCHINA_XML_DATA_IN_UNCOMPRESS_DIR = " + MACCHINA_XML_DATA_IN_UNCOMPRESS_DIR);

      MACCHINA_JAXB_INPUT_PACKAGE_NAME = prop.getProperty(MACCHINA_PFX + JAXB_INPUT_PACKAGE_NAME_PROP);
      log.info("MACCHINA_JAXB_INPUT_PACKAGE_NAME = " + MACCHINA_JAXB_INPUT_PACKAGE_NAME);

      MACCHINA_FTP_SERVER_OUT_DIR = prop.getProperty(MACCHINA_PFX + FTP_SERVER_OUT_DIR_PROP);
      log.info("MACCHINA_FTP_SERVER_OUT_DIR = " + MACCHINA_FTP_SERVER_OUT_DIR);

      MACCHINA_FTP_SERVER_IN_DIR = prop.getProperty(MACCHINA_PFX + FTP_SERVER_IN_DIR_PROP);
      log.info("MACCHINA_FTP_SERVER_IN_DIR = " + MACCHINA_FTP_SERVER_OUT_DIR);

      MACCHINA_FTP_SERVER_IN_DIR_OLD = prop.getProperty(MACCHINA_PFX + FTP_SERVER_IN_DIR_OLD_PROP);
      log.info("MACCHINA_FTP_SERVER_IN_DIR_OLD = " + MACCHINA_FTP_SERVER_OUT_DIR);

      MACCHINA_XML_DATA_IN_DOWNLOADED_DIR = prop.getProperty(MACCHINA_PFX + XML_DATA_IN_DOWNLOADED_DIR_PROP);
      log.info("MACCHINA_XML_DATA_IN_DOWNLOADED_DIR = " + MACCHINA_XML_DATA_IN_DOWNLOADED_DIR);

      MACCHINA_XML_DATA_OUT_TRANSFERED_DIR = prop.getProperty(MACCHINA_PFX + XML_DATA_OUT_TRANSFERED_DIR_PROP);
      log.info("MACCHINA_XML_DATA_OUT_TRANSFERED_DIR = " + MACCHINA_XML_DATA_OUT_TRANSFERED_DIR);

      MACCHINA_JAXB_OUTPUT_PACKAGE_NAME = prop.getProperty(MACCHINA_PFX + JAXB_OUTPUT_PACKAGE_NAME_PROP);
      log.info("MACCHINA_JAXB_OUTPUT_PACKAGE_NAME = " + MACCHINA_JAXB_OUTPUT_PACKAGE_NAME);



    } catch (IOException ioe) {
      throw new InitializeException("ERRORE NEL CARICARE IL FILE DI PROPERTIES: " + ioe.getMessage());
    }

  }
}