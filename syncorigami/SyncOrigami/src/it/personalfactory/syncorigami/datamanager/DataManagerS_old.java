/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.datamanager;

import it.personalfactory.syncorigami.exceptions.InvalidUpdateContentException;
import it.personalfactory.syncorigami.exceptions.InvalidUpdateTypeException;
import it.personalfactory.syncorigami.exceptions.InvalidUpdateVersionException;
import it.personalfactory.syncorigami.macchina.entity.AggiornamentoOri;
import it.personalfactory.syncorigami.macchina.entity.CategoriaOri;
import it.personalfactory.syncorigami.macchina.entity.ChimicaOri;
import it.personalfactory.syncorigami.macchina.entity.ColoreBaseOri;
import it.personalfactory.syncorigami.macchina.entity.ColoreOri;
import it.personalfactory.syncorigami.macchina.entity.ComponenteProdottoOri;
import it.personalfactory.syncorigami.macchina.entity.DizionarioOri;
import it.personalfactory.syncorigami.macchina.entity.MacchinaOri;
import it.personalfactory.syncorigami.macchina.entity.MazzettaColorataOri;
import it.personalfactory.syncorigami.macchina.entity.MazzettaOri;
import it.personalfactory.syncorigami.macchina.entity.NumSacchettoOri;
import it.personalfactory.syncorigami.macchina.entity.ParametroCompProdOri;
import it.personalfactory.syncorigami.macchina.entity.ParametroGlobMacOri;
import it.personalfactory.syncorigami.macchina.entity.PresaOri;
import it.personalfactory.syncorigami.macchina.entity.ProdottoOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreParProdOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreParSacchettoOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreParSingMacOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreRipristinoOri;
import it.personalfactory.syncorigami.exceptions.MacchinaNotFoundException;
import it.personalfactory.syncorigami.exceptions.MachineCredentialsNotFoundException;
import it.personalfactory.syncorigami.macchina.entity.AggiornamentoConfigOri;
import it.personalfactory.syncorigami.macchina.entity.AllarmeOri;
import it.personalfactory.syncorigami.macchina.entity.CicloOri;
import it.personalfactory.syncorigami.macchina.entity.CicloProcessoOri;
import it.personalfactory.syncorigami.macchina.entity.ComponenteOri;
import it.personalfactory.syncorigami.macchina.entity.ComponentePesaturaOri;
import it.personalfactory.syncorigami.macchina.entity.FiguraOri;
import it.personalfactory.syncorigami.macchina.entity.FiguraTipoOri;
import it.personalfactory.syncorigami.macchina.entity.MazzettaColSingMacOri;
import it.personalfactory.syncorigami.macchina.entity.MovimentoSingMacOri;
import it.personalfactory.syncorigami.macchina.entity.OrdineSingMacOri;
import it.personalfactory.syncorigami.macchina.entity.ProcessoOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreAllarmeOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreParCompOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreParOrdineOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreParProdMacOri;
import it.personalfactory.syncorigami.macchina.entity.ValoreProdottoOri;
import it.personalfactory.syncorigami.server.entity.*;
import it.personalfactory.syncorigami.server.jpacontroller.AggiornamentoConfigJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.AggiornamentoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.AllarmeJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.AnagrafeProdottoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.CategoriaJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ChimicaJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.CicloJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.CicloProcessoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.CodiceJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ColoreBaseJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ColoreJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ComponenteJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ComponentePesaturaJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ComponenteProdottoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.DizionarioJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.FiguraJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.FiguraTipoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.MacchinaJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.MazzettaColSingMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.MazzettaColorataJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.MazzettaJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.MovimentoSingMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.NumSacchettoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.OrdineElencoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.OrdineSingMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroCompProdJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroGlobMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroOrdineJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroProdJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroProdMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroProdottoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroRipristinoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroSacchettoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ParametroSingMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.PresaJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ProcessoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ProdottoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreAllarmeJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreParCompJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreParOrdineJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreParProdJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreParProdMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreParSacchettoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreParSingMacJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreProdottoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.ValoreRipristinoJpaController;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import it.personalfactory.syncorigami.utils.MachineCredentials;
import it.personalfactory.syncorigami.utils.SyncOrigamiConstants;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Date;
import javax.persistence.EntityManagerFactory;
import javax.persistence.NoResultException;
import javax.persistence.NonUniqueResultException;
import org.apache.log4j.Logger;

/**
 *
 * @author divinotaras
 */
public class DataManagerS {

//  private EntityManagerFactory emf;
    private static Logger log = Logger.getLogger(DataManagerS.class);
//  private final MachineCredentials machineCredentials;

    //#############################################################################
    //######################## METODI PER AGGIORNAMENTO OUT #######################
    //#############################################################################
    public static MachineCredentials getMachineCredentials(Integer idMacchina, EntityManagerFactory emf, String outFilePfx)
            throws MachineCredentialsNotFoundException, ParseException {
        //RECUPERA LE CREDENZIALI DELLA MACCHINA
        MachineCredentials mc = new MachineCredentials();
        MacchinaJpaController mjc = new MacchinaJpaController(null, emf);
        AggiornamentoJpaController ajc = new AggiornamentoJpaController(null, emf);
        ValoreParSingMacJpaController valSmJc = new ValoreParSingMacJpaController(null, emf);

        Macchina m = mjc.findMacchina(idMacchina);
        if (m == null) {
            throw new MachineCredentialsNotFoundException("IMPOSSIBILE RECUPERARE L'OGGETTO Macchina con id: " + idMacchina);
        }

        Integer ultimaVersioneOut = null;
        Date dataUltAgg = null;
        log.info("Esecuzione metodo getMachineCredentials : ");
        try {
            log.info("TROVATO idMacchina :" + idMacchina);
            ultimaVersioneOut = mjc.findLastUpdateVersion(idMacchina, outFilePfx);
            log.info("TROVATA ultimaVersioneOut :" + ultimaVersioneOut);
            dataUltAgg = ajc.recuperaDtUltimoAggiornamento(idMacchina, outFilePfx);

        } catch (NoResultException nre) {
            log.error("##### Nessun Risultato in findLastUpdateVersion");
        } catch (NonUniqueResultException nure) {
            log.error("##### Data ultimo aggiornamento duplicata in findLastUpdateVersion");
            throw nure;
        }

        if (ultimaVersioneOut == null) {
            ultimaVersioneOut = 0;

//            SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy - HH:mm:ss");
//            try {
//                dataUltAgg = sdf.parse("01/01/1970 - 00:00:00");
//                //NON HA TROVATO VERSIONI DI AGGIORNAMENTO...SETTA L'ULIMA VERSIONE A 0
//            } catch (ParseException ex) {
//                log.error(ex);
//            }
            dataUltAgg = SyncOrigamiConstants.DATA_DEFAULT;
        }

        //################## GESTIONE VERSIONE SOFTWARE SYNCORIGAMI ############
        String versioneDb = "2";
        String stringVersioneSftw = "CloudFab2";
        String versioneSftw = "2";
        //Il valore del campo valore_mac della tabella valore_par_sing_mac con id_par_sm=27 indica la versione di origamidb
        Integer idParVersioneDb = 27;
        //Il valore del campo valore_mac della tabella valore_par_sing_mac con id_par_sm=221 indica la versione del programma CloudFab
        Integer idParVersioneSftw = 211;

        //Valore del campo user_origami della tabella macchina 
        //se user_origami=2 vuol dire che ancora non è mai stato inviato un aggiornamento
        //contenente i nuovi dati delle tabelle valore_prodotto, valore_par_prod_mac
        String valorePrimoAgg = m.getUserOrigami();

        ParametroSingMac parVersioneDb = new ParametroSingMac(idParVersioneDb);
        ParametroSingMac parVersioneSftw = new ParametroSingMac(idParVersioneSftw);

        versioneDb = valSmJc.findValoreByMacchinaIdPar(m.getIdMacchina(), parVersioneDb).getValoreMac();
        stringVersioneSftw = valSmJc.findValoreByMacchinaIdPar(m.getIdMacchina(), parVersioneSftw).getValoreMac();

        if (stringVersioneSftw != null && !stringVersioneSftw.isEmpty()) {
            versioneSftw = stringVersioneSftw.substring(8, 9);
        }

        //######################################################################
        // Se il campo valore_mac relativo ai valori dei parametri singola macchina 27 e 211 che
        //indicano la versione rispettivamente del db e del software a bordo macchina
        //sono uguali a 3 allora si puossono includere nell'aggiornamento i dati relativi alle nuove tabelle
        //dei parametri prodotto
        log.info("@versioneSFTW : (user-origami)- SYNC-VERSION: " + m.getUserOrigami());
        log.info("@versioneSFTW : VERSIONE origamiDB : " + versioneDb);
        log.info("@versioneSFTW : VERSIONE CloudFab : " + versioneSftw);

        mc.setIdMacchina(m.getIdMacchina());
        mc.setLastUpdateDate(dataUltAgg);
        mc.setLastUpdateVersion(ultimaVersioneOut);
        mc.setNewRemoteUpdateVersion(ultimaVersioneOut + 1);
        mc.setFtpPassword(m.getFtpPassword());
        mc.setFtpUser(m.getFtpUser());
        mc.setZipPassword(m.getZipPassword());

        //mc.setMachineSoftwareVersion(m.getPassOrigami());
        mc.setSyncSoftwareVersion(m.getUserOrigami());
        mc.setMachineSoftwareVersion(versioneSftw);
        mc.setOrigamiDbVersion(versioneSftw);

        log.info(mc.toString());

        return mc;
    }

//    /**
//     * Metodo che costruisce un oggetto di tipo Aggiornamento contenente una
//     * collection di dati nuovi selezionati lato server da inviare alla macchina
//     *
//     * @return Aggiornamento completo per una macchina
//     * @throws MacchinaNotFoundException
//     */
//    public static Aggiornamento costruisciAggiornamento(MachineCredentials machineCredentials,
//            EntityManagerFactory emf,
//            String outFilePfx) {
//
//        Aggiornamento aggiornamentoOut = new Aggiornamento();
//        aggiornamentoOut.setDaInserire(new ArrayList());
//
//        AggiornamentoJpaController aggiornamentoJc = new AggiornamentoJpaController(null, emf);
//        AggiornamentoConfigJpaController aggiornamentoConfigJc = new AggiornamentoConfigJpaController(null, emf);
//        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
//        ProdottoJpaController prodottoJc = new ProdottoJpaController(null, emf);
//        AnagrafeProdottoJpaController anagrafeProdottoJc = new AnagrafeProdottoJpaController(null, emf);
//        CategoriaJpaController categoriaJc = new CategoriaJpaController(null, emf);
//        ChimicaJpaController chimicaJc = new ChimicaJpaController(null, emf);
//        ColoreJpaController coloreJc = new ColoreJpaController(null, emf);
//        ColoreBaseJpaController coloreBaseJc = new ColoreBaseJpaController(null, emf);
//        ComponenteJpaController componenteJc = new ComponenteJpaController(null, emf);
//        ComponenteProdottoJpaController componenteProdottoJc = new ComponenteProdottoJpaController(null, emf);
//        ParametroCompProdJpaController parametroCompProdJc = new ParametroCompProdJpaController(null, emf);
//        DizionarioJpaController dizionarioJc = new DizionarioJpaController(null, emf);
//        PresaJpaController presaJc = new PresaJpaController(null, emf);
//        MazzettaJpaController mazzettaJc = new MazzettaJpaController(null, emf);
//        MazzettaColorataJpaController mazzettaColorataJc = new MazzettaColorataJpaController(null, emf);
//        NumSacchettoJpaController numSacchettoJc = new NumSacchettoJpaController(null, emf);
//        ParametroGlobMacJpaController parametroGlobMacJc = new ParametroGlobMacJpaController(null, emf);
//        ParametroProdottoJpaController parametroProdottoJc = new ParametroProdottoJpaController(null, emf);
//        ParametroRipristinoJpaController parametroRipristinoJc = new ParametroRipristinoJpaController(null, emf);
//        ParametroSacchettoJpaController parametroSacchettoJc = new ParametroSacchettoJpaController(null, emf);
//        ParametroSingMacJpaController parametroSingMacJc = new ParametroSingMacJpaController(null, emf);
//        ValoreParProdJpaController valoreParProdJc = new ValoreParProdJpaController(null, emf);
//        ValoreParSacchettoJpaController valoreParSacchettoJc = new ValoreParSacchettoJpaController(null, emf);
//        ValoreRipristinoJpaController valoreRipristinoJc = new ValoreRipristinoJpaController(null, emf);
//        ValoreParSingMacJpaController valoreParSingMacJc = new ValoreParSingMacJpaController(null, emf);
//        ValoreParCompJpaController valoreParCompJc = new ValoreParCompJpaController(null, emf);
//
//        //Prendo l'entità macchina con id_macchina che intendo aggiornare
//        Macchina macchina = macchinaJc.findMacchina(machineCredentials.getIdMacchina());
//
//        //Recupero i nuovi dati della tab macchina e li inserisco nella collection DaInserire
//        //solo se il campo dtAbilitato è > della data dell'ultimo aggiornamento
//        Macchina macchinaNew = macchinaJc.findMacchina(macchina.getIdMacchina());
//        if (macchinaNew.getDtAbilitato().compareTo(machineCredentials.getLastUpdateDate()) > 0) {
//            aggiornamentoOut.getDaInserire().add(macchinaNew);
//            log.info("############ DATI ANAGRAFICI MODIFICATI PER MACCHINA (tabella macchina)!!!");
//        } else {
//
////            log.info("machineCredentials.getLastUpdateDate() : " + machineCredentials.getLastUpdateDate());
//            log.info("############ DATI ANAGRAFICI NON MODIFICATI PER MACCHINA (tabella macchina)!!!");
//        }
//
//        //Recupero i nuovi dati della tab aggiornamento_config e li aggiungo alla collection DaInserire    
//        Collection<AggiornamentoConfig> aggiornamentoConfigColl = aggiornamentoConfigJc.findAggiornamentoConfigNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(aggiornamentoConfigColl);
//        
//        log.info("############ NUMERO PARAMETRI AGGIORNAMENTO CONFIG : " + aggiornamentoConfigColl.size());
//        
//
//        //Recupero i nuovi dati della tab colore e li aggiungo alla collection DaInserire    
//        Collection<Colore> coloreColl = coloreJc.findColoreNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(coloreColl);
//        
//        log.info("############ NUMERO COLORI : " + coloreColl.size());
//
//        //Recupero i nuovi dati della tab colore_base e li aggiungo alla collection DaInserire    
//        Collection<ColoreBase> coloreBaseColl = coloreBaseJc.findColoreBaseNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(coloreBaseColl);
//       
//        log.info("############ NUMERO COLORI BASE : " + coloreBaseColl.size());
//        
//
//        //TEST 23-10-2014
//        //###### ASSEGNAZIONE DEI COMPONENTI GRUPPO E RIF GEOGRAFICO ##############################        
//        //Recupero i nuovi dati della tab componente e li aggiungo alla collection DaInserire    
////        Collection<Componente> componenteColl = componenteJc.findComponenteNew(machineCredentials.getLastUpdateDate());
//        Collection<Componente> componenteGruppoColl = componenteJc.findComponenteNewByGruppo(machineCredentials.getLastUpdateDate(), macchina);
//        aggiornamentoOut.getDaInserire().addAll(componenteGruppoColl);
//        
//        Collection<Componente> componenteGeoColl = componenteJc.findComponenteNewByGeo(machineCredentials.getLastUpdateDate(), macchina);
//        int k=0;
//        for (Object obj : componenteGeoColl) {
//            //############ INTERSEZIONE  ###############################   
//            //Inserico solo i componenti dei prodotti che (essendo stati assegnati in base al gruppo)
//            //vengono assegnati anche in base al riferimento geo
//            
//            if (aggiornamentoOut.getDaInserire().contains(obj)) {
//                aggiornamentoOut.getDaInserire().add(obj);
//                k++;
//
//            }
//            
//        }
//        log.info("############ NUMERO COMPONENTI GRUPPO : " +componenteGruppoColl.size());
//        
//        log.info("############ NUMERO COMPONENTI RIF GEO : "+componenteGeoColl.size());
//        
//        log.info("############ NUMERO COMPONENTI INTERSEZIONE GRUPPO E GEO : "+k);        
//        
//        
//        //Recupero i nuovi dati della tab mazzetta e li aggiungo alla collection DaInserire    
//        Collection<Mazzetta> mazzettaColl = mazzettaJc.findMazzettaNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(mazzettaColl);        
//        
//        log.info("############ NUMERO MAZZETTE : "+mazzettaColl.size());
//        
//
//        //Recupero i nuovi dati della tab mazzetta_colorata e li aggiungo alla collection DaInserire    
//        Collection<MazzettaColorata> mazzettaColorataColl = mazzettaColorataJc.findMazzettaColorataNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(mazzettaColorataColl);
//        
//        log.info("############ NUMERO MAZZETTE COLORATE : " + mazzettaColorataColl.size());
//
//        //Recupero i nuovi dati della tab categoria e li aggiungo alla collection DaInserire    
//        Collection<Categoria> categoriaColl = categoriaJc.findCategoriaNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(categoriaColl);
//       
//        log.info("############ NUMERO CATEGORIE : " + categoriaColl.size());
//               
//
//        //Recupero i nuovi dati della tab parametro_comp_prod e li aggiungo alla collection DaInserire    
//        Collection<ParametroCompProd> parametroCompProdColl = parametroCompProdJc.findParametroCompProdNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(parametroCompProdColl);
//        
//        log.info("############ NUMERO PARAMETRI COMP PROD : " + parametroCompProdColl.size());
//
//        //############# ASSEGNAZIONE DEI PRODOTTI GRUPPO E RIF GEOGRAFICO ############################################
//        //Recupero i nuovi dati della tab anagrafe_prodotto e li aggiungo alla collection DaInserire
//        //Tenendo conto dell'assegnazione dei prodotti in base al gruppo ed al riferimento geografico della macchina
//        Collection<AnagrafeProdotto> anagrafeProdottoGruppoColl = anagrafeProdottoJc.findAnagrafeProdottoNewGruppo(machineCredentials.getLastUpdateDate(), macchina);
//        aggiornamentoOut.getDaInserire().addAll(anagrafeProdottoGruppoColl);
//        
//        Collection<AnagrafeProdotto> anagrafeProdottoGeoColl = anagrafeProdottoJc.findAnagrafeProdottoNewGeo(machineCredentials.getLastUpdateDate(), macchina);
//        int z=0;
//        for (Object obj : anagrafeProdottoGeoColl) {
//         
//            //############ INTERSEZIONE DEI PRODOTTI ###############################   
//            //Inserico solo i prodotti che (essendo stati assegnati in base al gruppo)
//            //vengono assegnati anche in base al riferimento geo
//            if (aggiornamentoOut.getDaInserire().contains(obj)) {
//                aggiornamentoOut.getDaInserire().add(obj);
//                z++;
//            }            
//        }
//        //12 ottobre 2015 metodo più giusto
////        for (Object obj : anagrafeProdottoGruppoColl) {
////         
////            //############ INTERSEZIONE DEI PRODOTTI ###############################   
////            //Inserico solo i prodotti che (essendo stati assegnati in base al gruppo)
////            //vengono assegnati anche in base al riferimento geo
////            if (anagrafeProdottoGeoColl.contains(obj)) {
////                aggiornamentoOut.getDaInserire().add(obj);
////                z++;
////            }
////            
////        }
//
//        log.info("############ NUMERO PRODOTTI GRUPPO : " + anagrafeProdottoGruppoColl.size());
//        log.info("############ NUMERO PRODOTTI GEO : " + anagrafeProdottoGeoColl.size());
//        log.info("############ NUMERO PRODOTTI INTERSEZIONE GRUPPO GEO : " + z);
//
//        //Recupero i nuovi dati della tab componente_prodotto e li aggiungo alla collection DaInserire
//        //Tenendo conto dell'assegnazione dei prodotti in base al gruppo ed al riferimento geografico della macchina
//        Collection<ComponenteProdotto> componenteProdottoGruppoColl = componenteProdottoJc.findCompProdottoNewGruppo(machineCredentials.getLastUpdateDate(), macchina);
//        aggiornamentoOut.getDaInserire().addAll(componenteProdottoGruppoColl);
//        Collection<ComponenteProdotto> componenteProdottoGeoColl = componenteProdottoJc.findCompProdottoNewGeo(machineCredentials.getLastUpdateDate(), macchina);
//        int t=0;
//        for (Object obj : componenteProdottoGeoColl) {
//            //Inserisco solo i componenti prodotto che non sono già stati inseriti
////            if(!aggiornamentoOut.getDaInserire().contains(obj)){  
////                aggiornamentoOut.getDaInserire().add(obj);
////            }
//            //############ INTERSEZIONE DEI COMPONENTI PRODOTTI ##################
//            //Inserico solo i componenti che (essendo stati assegnati in base al gruppo)
//            //vengono assegnati anche in base al riferimento geo
//            if (aggiornamentoOut.getDaInserire().contains(obj)) {
//                aggiornamentoOut.getDaInserire().add(obj);
//                t++;
//            }
//        }
//
//        
//        log.info("############ NUMERO COMPONENTI PRODOTTI GRUPPO : " + componenteProdottoGruppoColl.size());
//        log.info("############ NUMERO COMPONENTI PRODOTTI GEO : " + componenteProdottoGeoColl.size());
//        log.info("############ NUMERO COMPONENTI PRODOTTI INTERSEZIONE GRUPPO GEO : " + t);
//
//        //######################################################################
//        //Recupero i nuovi dati della tab presa e li aggiungo alla collection DaInserire    
//        Collection<Presa> presaColl = presaJc.findPresaNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(presaColl);
//        log.info("############ NUMERO PRESE : " + presaColl.size());
//
//        //Recupero i nuovi dati della tab dizionario e li aggiungo alla collection DaInserire    
//        Collection<Dizionario> dizionarioColl = dizionarioJc.findDizionarioNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(dizionarioColl);
//        log.info("############ NUMERO DIZIONARIO : " + dizionarioColl.size());
//
//        //Recupero i nuovi dati della tab chimica, bolla, lotto e li aggiungo alla collection DaInserire    
//        Collection<Chimica> chimicaColl = chimicaJc.findChimicaNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
//        aggiornamentoOut.getDaInserire().addAll(chimicaColl);
//
////        for (Object obj : chimicaColl) {
////            log.info("############ chimColl :" + obj);
////        }
//        log.info("############ NUMERO CHIMICHE : " + chimicaColl.size());
//
//        //Recupero i nuovi dati della tab num_sacchetto e li aggiungo alla collection DaInserire    
//        Collection<NumSacchetto> numSacchettoColl = numSacchettoJc.findNumSacchettoNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(numSacchettoColl);
//        log.info("############ NUMERO SACCHETTO : " + numSacchettoColl.size());
//
//        //Recupero i nuovi dati della tab parametro_glob_mac e li aggiungo alla collection DaInserire    
//        Collection<ParametroGlobMac> parametroGlobMacColl = parametroGlobMacJc.findParametroGlobMacNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(parametroGlobMacColl);
//        log.info("############ NUMERO PARAMETRO GLOBALE MAC : " + parametroGlobMacColl.size());
//
//        //Recupero i nuovi dati della tab parametro_prodotto e li aggiungo alla collection DaInserire    
//        Collection<ParametroProdotto> parametroProdottoColl = parametroProdottoJc.findParametroProdottoNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(parametroProdottoColl);
//        log.info("############ NUMERO PARAMETRO PRODOTTO : " + parametroProdottoColl.size());
//
//        //Recupero i nuovi dati della tab parametro_ripristino e li aggiungo alla collection DaInserire    
//        Collection<ParametroRipristino> parametroRipristinoColl = parametroRipristinoJc.findParametroRipristinoNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(parametroRipristinoColl);
//        log.info("############ NUMERO PARAMETRO RIPRISTINO : " + parametroRipristinoColl.size());
//
//        //Recupero i nuovi dati della tab parametro_sacchetto e li aggiungo alla collection DaInserire    
//        Collection<ParametroSacchetto> parametroSacchettoColl = parametroSacchettoJc.findParametroSacchettoNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(parametroSacchettoColl);
//        log.info("############ NUMERO PARAMETRO SACCHETTO : " + parametroSacchettoColl.size());
//
//        //Recupero i nuovi dati della tab parametro_sing_mac e li aggiungo alla collection DaInserire    
//        Collection<ParametroSingMac> parametroSingMacColl = parametroSingMacJc.findParametroSingMacNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(parametroSingMacColl);
//        log.info("############ NUMERO PARAMETRO SINGOLA MAC : " + parametroSingMacColl.size());
//
//        //Recupero i nuovi dati della tab valore_par_prod e li aggiungo alla collection DaInserire    
//        Collection<ValoreParProd> valoreParProdColl = valoreParProdJc.findValoreParProdNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(valoreParProdColl);
//        log.info("############ NUMERO VALORE PAR PROD : " + valoreParProdColl.size());
//
//        //Recupero i nuovi dati della tab valore_par_sacchetto e li aggiungo alla collection DaInserire    
//        Collection<ValoreParSacchetto> valoreParSacchettoColl = valoreParSacchettoJc.findValoreParSacchettoNew(machineCredentials.getLastUpdateDate());
//        aggiornamentoOut.getDaInserire().addAll(valoreParSacchettoColl);
//        log.info("############ NUMERO VALORE PAR SACCHETTO : " + valoreParSacchettoColl.size());
//
//        //Recupero i nuovi dati della tab valore_ripristino e li aggiungo alla collection DaInserire    
//        Collection<ValoreRipristino> valoreRipristinoColl = valoreRipristinoJc.findValoreRipristinoNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
//        aggiornamentoOut.getDaInserire().addAll(valoreRipristinoColl);
//        log.info("############ NUMERO VALORE RIPRISTINO : " + valoreRipristinoColl.size());
//
//        //Recupero i nuovi dati della tab valore_par_sing_mac e li aggiungo alla collection DaInserire    
//        Collection<ValoreParSingMac> valoreParSingMacColl = valoreParSingMacJc.findValoreParSingMacNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
//        aggiornamentoOut.getDaInserire().addAll(valoreParSingMacColl);
//
//        log.info("############ NUMERO VALORE PAR SING MAC : " + valoreParSingMacColl.size());
//        
//        //Recupero i nuovi dati della tab valore_par_comp e li aggiungo alla collection DaInserire    
////        Collection<ValoreParComp> valoreParCompColl = valoreParCompJc.findValoreParCompNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
////        aggiornamentoOut.getDaInserire().addAll(valoreParCompColl);
////        for (Object valObj : valoreParCompColl) {
////            ValoreParComp valoreParComp = (ValoreParComp) valObj;
////
////            for (Object compObj : componenteGruppoColl) {
////                Componente comp = (Componente) compObj;
////
////                if (valoreParComp.getIdComp().equals(comp.getIdComp())) {
////                    
////                }
////            }
////        }
//
//        //TEST 23-10-2014
//        //###### ASSEGNAZIONE DEI VALORI PAR COMPONENTI GRUPPO E RIF GEOGRAFICO ##############################  
//        Collection<ValoreParComp> valoreParCompGruppoColl = valoreParCompJc.findValParCompNewByGruppo(machineCredentials.getLastUpdateDate(), macchina);
//        aggiornamentoOut.getDaInserire().addAll(valoreParCompGruppoColl);
//        
//       
//
////        int numValParComp = 0;
////        for (Object obj : valoreParCompGruppoColl) {
////            numValParComp++;
////            log.info("############ numero di valori par comp in base al gruppo : " + obj);
////        }
//        
//
//        Collection<ValoreParComp> valoreParCompGeoColl = valoreParCompJc.findValParCompNewByGeo(machineCredentials.getLastUpdateDate(), macchina);
//        int h=0;
//        for (Object obj : valoreParCompGeoColl) {
//
//            //Inserico solo i valori dei par dei componenti dei prodotti che (essendo stati assegnati in base al gruppo)
//            //vengono assegnati anche in base al riferimento geo
//            if (aggiornamentoOut.getDaInserire().contains(obj)) {
//                aggiornamentoOut.getDaInserire().add(obj);
//                h++;
//
//            }
//        }
//        
//        log.info("############ NUMERO VALORE PAR COMP GRUPPO : " + valoreParCompGruppoColl.size());
//        log.info("############ NUMERO VALORE PAR COMP RIF GEO : " + valoreParCompGeoColl.size());
//        log.info("############ NUMERO VALORE PAR COMP INTERSEZIONE GRUPPO RIF GEO : " + h);
//        log.info("############ NUMERO TOT COLLECTION DA INSERIRE : " +aggiornamentoOut.getDaInserire().size());
//
//        log.info("MACCHINA CON ID_MACCHINA : " + machineCredentials.getIdMacchina());
//        log.info("DATA DI COSTRUZIONE DELL'ULTIMO AGGIORNAMENTO : " + machineCredentials.getLastUpdateDate());
//        log.info("ULTIMA VERSIONE AGGIORNAMENTO : " + machineCredentials.getLastUpdateVersion());
//
//        
//        
//         
//        //Setto alcuni campi dell'oggetto aggiornamento
//        //Calcolo la versione dell'aggiornamento corrente
//        aggiornamentoOut.setIdMacchina(macchina);
//        aggiornamentoOut.setTipo(outFilePfx);
//        aggiornamentoOut.setDtAggiornamento(new Date());
//
//        aggiornamentoOut.setVersione(machineCredentials.getLastUpdateVersion() + 1);
//
//        return aggiornamentoOut;
//
//    }
    /*public static boolean datiAssgnatiTest(Macchina macchina,
     EntityManagerFactory emf) {

     AnagrafeProdottoJpaController anagrafeProdottoJc = new AnagrafeProdottoJpaController(null, emf);
     //######################################################################
     //############# ASSEGNAZIONE DEI PRODOTTI GRUPPO E RIF GEOGRAFICO ######
     //######################################################################

     //Inizialmente creo la collection di tutti i prodotti assegnati alla macchina, indipendentemente dalle modifiche e dalle date
     //Creo le colletion dei dati relativi solo ai prodotti assegnati, componenti_prodotto, componenti
     //In un secondo momento vado a verificare le date ed eventualmente li inserisco nell'aggiornamento
     Collection<AnagrafeProdotto> anagrafeProdottoGruppoColl = anagrafeProdottoJc.findAnagrafeProdottoGruppo(macchina);
     Collection<AnagrafeProdotto> anagrafeProdottoGeoColl = anagrafeProdottoJc.findAnagrafeProdottoGeo(macchina);

     Collection<AnagrafeProdotto> prodottiAssegnatiColl = new ArrayList();
     Collection<ComponenteProdotto> compProdAssegnatiColl = new ArrayList();
     Collection<Componente> componentiAssegnatiColl = new ArrayList();

     //############ INTERSEZIONE DEI PRODOTTI ############################### 
     for (Object obj : anagrafeProdottoGruppoColl) {
     AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj;
     //Per ogni prodotto che viene assegnato in base al gruppo
     //verifico se è stato assegnato anche in base al rif geografico
     //e in tal caso lo aggiungo alla collection dei prodotti assegnati       
     if (anagrafeProdottoGeoColl.contains(anagrafeProdotto)) {
     prodottiAssegnatiColl.add(anagrafeProdotto);
     }
     }

     //############ COMPONENTI-PRODOTTI ASSEGNATI ###########################
     for (Object objPa : prodottiAssegnatiColl) {
     AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) objPa;
     compProdAssegnatiColl.addAll(anagrafeProdotto.getIdProdotto().getComponenteProdottoCollection());
     }

     //############ COMPONENTI ASSEGNATI ####################################
     for (Object compProd : compProdAssegnatiColl) {
     ComponenteProdotto componenteProdotto = (ComponenteProdotto) compProd;
     if (!componentiAssegnatiColl.contains(componenteProdotto.getIdComp())) {
     componentiAssegnatiColl.add(componenteProdotto.getIdComp());
     }
     }

     log.info("############ NUMERO PRODOTTI GRUPPO : " + anagrafeProdottoGruppoColl.size());
     log.info("############ NUMERO PRODOTTI GEO : " + anagrafeProdottoGeoColl.size());
     log.info("############ NUMERO PRODOTTI INTERSEZIONE GRUPPO GEO : " + prodottiAssegnatiColl);

     return true;

     }*/
    /**
     * Metodo che gestisce il passaggio di versione alla dalla 2 alla 3
     *
     * @param machineCredentials
     * @param emf
     * @param outFilePfx
     * @return
     * @throws NonexistentEntityException
     * @throws Exception
     */
    public static Aggiornamento costruisciAggiornamento(MachineCredentials machineCredentials,
            EntityManagerFactory emf,
            String outFilePfx) throws NonexistentEntityException, Exception {

        Aggiornamento aggiornamentoOut = new Aggiornamento();
        aggiornamentoOut.setDaInserire(new ArrayList());

        AggiornamentoJpaController aggiornamentoJc = new AggiornamentoJpaController(null, emf);
        AggiornamentoConfigJpaController aggiornamentoConfigJc = new AggiornamentoConfigJpaController(null, emf);
        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
        ProdottoJpaController prodottoJc = new ProdottoJpaController(null, emf);
        AnagrafeProdottoJpaController anagrafeProdottoJc = new AnagrafeProdottoJpaController(null, emf);
        CategoriaJpaController categoriaJc = new CategoriaJpaController(null, emf);
        ChimicaJpaController chimicaJc = new ChimicaJpaController(null, emf);
        ColoreJpaController coloreJc = new ColoreJpaController(null, emf);
        ColoreBaseJpaController coloreBaseJc = new ColoreBaseJpaController(null, emf);
        ComponenteJpaController componenteJc = new ComponenteJpaController(null, emf);
        ComponenteProdottoJpaController componenteProdottoJc = new ComponenteProdottoJpaController(null, emf);
        ParametroCompProdJpaController parametroCompProdJc = new ParametroCompProdJpaController(null, emf);
        DizionarioJpaController dizionarioJc = new DizionarioJpaController(null, emf);
        PresaJpaController presaJc = new PresaJpaController(null, emf);
        MazzettaJpaController mazzettaJc = new MazzettaJpaController(null, emf);
        MazzettaColorataJpaController mazzettaColorataJc = new MazzettaColorataJpaController(null, emf);
        NumSacchettoJpaController numSacchettoJc = new NumSacchettoJpaController(null, emf);
        ParametroGlobMacJpaController parametroGlobMacJc = new ParametroGlobMacJpaController(null, emf);
        ParametroProdottoJpaController parametroProdottoJc = new ParametroProdottoJpaController(null, emf);
        ParametroRipristinoJpaController parametroRipristinoJc = new ParametroRipristinoJpaController(null, emf);
        ParametroSacchettoJpaController parametroSacchettoJc = new ParametroSacchettoJpaController(null, emf);
        ParametroSingMacJpaController parametroSingMacJc = new ParametroSingMacJpaController(null, emf);
        ValoreParProdJpaController valoreParProdJc = new ValoreParProdJpaController(null, emf);
        ValoreParSacchettoJpaController valoreParSacchettoJc = new ValoreParSacchettoJpaController(null, emf);
        ValoreRipristinoJpaController valoreRipristinoJc = new ValoreRipristinoJpaController(null, emf);
        ValoreParSingMacJpaController valoreParSingMacJc = new ValoreParSingMacJpaController(null, emf);
        ValoreParCompJpaController valoreParCompJc = new ValoreParCompJpaController(null, emf);
        ParametroProdJpaController parametroProdJc = new ParametroProdJpaController(null, emf);
        ParametroProdMacJpaController parametroProdMacJc = new ParametroProdMacJpaController(null, emf);
        ValoreProdottoJpaController valoreProdottoJc = new ValoreProdottoJpaController(null, emf);
        ValoreParProdMacJpaController valoreParProdMacJc = new ValoreParProdMacJpaController(null, emf);

        //Prendo l'entità macchina con id_macchina che intendo aggiornare
        Macchina macchina = macchinaJc.findMacchina(machineCredentials.getIdMacchina());

        //Recupero i nuovi dati della tab macchina e li inserisco nella collection DaInserire
        //solo se il campo dtAbilitato è > della data dell'ultimo aggiornamento
        Macchina macchinaNew = macchinaJc.findMacchina(macchina.getIdMacchina());
        if (macchinaNew.getDtAbilitato().compareTo(machineCredentials.getLastUpdateDate()) > 0) {
            aggiornamentoOut.getDaInserire().add(macchinaNew);
            log.info("############ DATI ANAGRAFICI MODIFICATI PER MACCHINA (tabella macchina)!!!");
        } else {

//            log.info("machineCredentials.getLastUpdateDate() : " + machineCredentials.getLastUpdateDate());
            log.info("############ DATI ANAGRAFICI NON MODIFICATI PER MACCHINA (tabella macchina)!!!");
        }

        //Elenco dei prodotti assegnati alla macchina indipendentemente da modifiche fatte sui dati
        Collection<Prodotto> prodottiAssegnatiColl = prodottoJc.findProdottiAssegnati(macchina);
        log.info("############ NUMERO PRODOTTI ASSEGNATI IN TUTTO : " + prodottiAssegnatiColl.size());
        //Elenco dei componenti assegnati alla macchina indipendentemente da modifiche fatte sui dati
        Collection<Componente> componentiAssegnatiColl = componenteJc.findComponentiAssegnati(macchina);
        log.info("############ NUMERO COMPONENTI ASSEGNATI IN TUTTO : " + componentiAssegnatiColl.size());

        //Recupero i nuovi dati della tab aggiornamento_config e li aggiungo alla collection DaInserire    
        Collection<AggiornamentoConfig> aggiornamentoConfigColl = aggiornamentoConfigJc.findAggiornamentoConfigNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(aggiornamentoConfigColl);

        log.info("############ NUMERO PARAMETRI AGGIORNAMENTO CONFIG : " + aggiornamentoConfigColl.size());

        //Recupero i nuovi dati della tab colore e li aggiungo alla collection DaInserire    
        Collection<Colore> coloreColl = coloreJc.findColoreNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(coloreColl);

        log.info("############ NUMERO COLORI : " + coloreColl.size());

        //Recupero i nuovi dati della tab colore_base e li aggiungo alla collection DaInserire    
        Collection<ColoreBase> coloreBaseColl = coloreBaseJc.findColoreBaseNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(coloreBaseColl);

        log.info("############ NUMERO COLORI BASE : " + coloreBaseColl.size());

        //Seleziono i componenti dalla tabella componente verificando le date nelle tabelle componente, componente_prodotto, anagrafe_prodotto
        //e aggiungo all'aggiornamento solo se i componenti sono fra quelli assegnati alla macchina
        Collection<Componente> componenteColl = componenteJc.findComponenteNew(machineCredentials.getLastUpdateDate());
        int k = 0;
        for (Object obj : componenteColl) {
            Componente componente = (Componente) obj;
            if (componentiAssegnatiColl.contains(componente)) {
                aggiornamentoOut.getDaInserire().add(componente);
                k++;
            }
        }
        log.info("############ NUMERO COMPONENTI : " + k);

        //Recupero i nuovi dati della tab mazzetta e li aggiungo alla collection DaInserire    
        Collection<Mazzetta> mazzettaColl = mazzettaJc.findMazzettaNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(mazzettaColl);

        log.info("############ NUMERO MAZZETTE : " + mazzettaColl.size());

        //Recupero i nuovi dati della tab mazzetta_colorata e li aggiungo alla collection DaInserire    
        Collection<MazzettaColorata> mazzettaColorataColl = mazzettaColorataJc.findMazzettaColorataNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(mazzettaColorataColl);

        log.info("############ NUMERO MAZZETTE COLORATE : " + mazzettaColorataColl.size());

        //Recupero i nuovi dati della tab categoria e li aggiungo alla collection DaInserire    
        Collection<Categoria> categoriaColl = categoriaJc.findCategoriaNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(categoriaColl);

        log.info("############ NUMERO CATEGORIE : " + categoriaColl.size());

        //Recupero i nuovi dati della tab parametro_comp_prod e li aggiungo alla collection DaInserire    
        Collection<ParametroCompProd> parametroCompProdColl = parametroCompProdJc.findParametroCompProdNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroCompProdColl);

        log.info("############ NUMERO PARAMETRI COMP PROD : " + parametroCompProdColl.size());

        //Seleziono i prodotti con data nuova dalla tabella anagrafe_prodotto 
        //e li aggiungo all'aggiornamento solo se i prodotti sono fra quelli assegnati alla macchina
        Collection<AnagrafeProdotto> anagrafeProdottoColl = anagrafeProdottoJc.findAnagrafeProdottoNew(machineCredentials.getLastUpdateDate());
        int n = 0;
        int comp = 0;

        for (Object obj : anagrafeProdottoColl) {
            AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj;
            if (prodottiAssegnatiColl.contains(anagrafeProdotto.getIdProdotto())) {

                aggiornamentoOut.getDaInserire().add(anagrafeProdotto);

                //Aggiungo all'agg tutti i componenti del prodotto anche se non sono stati modificati
                //Ogni volta che mando un prodotto nuovo (magari perchè è stato assegnato ad una nuova mac) mando sempre tutti i suoi componenti 
                Collection<ComponenteProdotto> componenteProdottoColl = componenteProdottoJc.findComponenteProdottoIdProd(anagrafeProdotto.getIdProdotto());
                for (Object compProd : componenteProdottoColl) {
                    ComponenteProdotto componenteProdotto = (ComponenteProdotto) compProd;
                    aggiornamentoOut.getDaInserire().add(componenteProdotto);
                    comp++;
                }
                n++;
            }
        }
        log.info("############ NUMERO ANAGRAFE PRODOTTO : " + n);
        log.info("############ - NUM COMPONENTI NEI PRODOTTI NUOVI : " + comp);

        //Seleziono i componenti dei prodotti  dalla tabella componente_prodotto 
        //e aggiungo all'aggiornamento solo se i prodotti sono fra quelli assegnati alla macchina
        Collection<ComponenteProdotto> componenteProdottoColl = componenteProdottoJc.findComponenteProdottoNew(machineCredentials.getLastUpdateDate());
        int m = 0;
        for (Object obj : componenteProdottoColl) {
            ComponenteProdotto componenteProdotto = (ComponenteProdotto) obj;
            if (prodottiAssegnatiColl.contains(componenteProdotto.getIdProdotto())) {
                aggiornamentoOut.getDaInserire().add(componenteProdotto);
                m++;
            }
        }
        log.info("############ NUMERO COMPONENTE PRODOTTO : " + m);

        //######################################################################
        //Recupero i nuovi dati della tab presa e li aggiungo alla collection DaInserire    
        Collection<Presa> presaColl = presaJc.findPresaNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(presaColl);
        log.info("############ NUMERO PRESE : " + presaColl.size());

        //Recupero i nuovi dati della tab dizionario e li aggiungo alla collection DaInserire    
        Collection<Dizionario> dizionarioColl = dizionarioJc.findDizionarioNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(dizionarioColl);
        log.info("############ NUMERO DIZIONARIO : " + dizionarioColl.size());

        //Recupero i nuovi dati della tab chimica, bolla, lotto e li aggiungo alla collection DaInserire    
        Collection<Chimica> chimicaColl = chimicaJc.findChimicaNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(chimicaColl);
        log.info("############ NUMERO CHIMICHE : " + chimicaColl.size());

        //Recupero i nuovi dati della tab num_sacchetto e li aggiungo alla collection DaInserire    
        Collection<NumSacchetto> numSacchettoColl = numSacchettoJc.findNumSacchettoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(numSacchettoColl);
        log.info("############ NUMERO SACCHETTO : " + numSacchettoColl.size());

        //Recupero i nuovi dati della tab parametro_glob_mac e li aggiungo alla collection DaInserire    
        Collection<ParametroGlobMac> parametroGlobMacColl = parametroGlobMacJc.findParametroGlobMacNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroGlobMacColl);
        log.info("############ NUMERO PARAMETRO GLOBALE MAC : " + parametroGlobMacColl.size());

        //Recupero i nuovi dati della tab parametro_prodotto e li aggiungo alla collection DaInserire    
        Collection<ParametroProdotto> parametroProdottoColl = parametroProdottoJc.findParametroProdottoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroProdottoColl);
        log.info("############ NUMERO PARAMETRO PRODOTTO : " + parametroProdottoColl.size());

        //Recupero i nuovi dati della tab parametro_ripristino e li aggiungo alla collection DaInserire    
        Collection<ParametroRipristino> parametroRipristinoColl = parametroRipristinoJc.findParametroRipristinoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroRipristinoColl);
        log.info("############ NUMERO PARAMETRO RIPRISTINO : " + parametroRipristinoColl.size());

        //Recupero i nuovi dati della tab parametro_sacchetto e li aggiungo alla collection DaInserire    
        Collection<ParametroSacchetto> parametroSacchettoColl = parametroSacchettoJc.findParametroSacchettoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroSacchettoColl);
        log.info("############ NUMERO PARAMETRO SACCHETTO : " + parametroSacchettoColl.size());

        //Recupero i nuovi dati della tab parametro_sing_mac e li aggiungo alla collection DaInserire    
        Collection<ParametroSingMac> parametroSingMacColl = parametroSingMacJc.findParametroSingMacNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroSingMacColl);
        log.info("############ NUMERO PARAMETRO SINGOLA MAC : " + parametroSingMacColl.size());

        //Recupero i nuovi dati della tab valore_par_prod e li aggiungo alla collection DaInserire    
        Collection<ValoreParProd> valoreParProdColl = valoreParProdJc.findValoreParProdNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(valoreParProdColl);
        log.info("############ NUMERO VALORE PAR PROD : " + valoreParProdColl.size());

        //Recupero i nuovi dati della tab valore_par_sacchetto e li aggiungo alla collection DaInserire    
        Collection<ValoreParSacchetto> valoreParSacchettoColl = valoreParSacchettoJc.findValoreParSacchettoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(valoreParSacchettoColl);
        log.info("############ NUMERO VALORE PAR SACCHETTO : " + valoreParSacchettoColl.size());

        //Recupero i nuovi dati della tab valore_ripristino e li aggiungo alla collection DaInserire    
        Collection<ValoreRipristino> valoreRipristinoColl = valoreRipristinoJc.findValoreRipristinoNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(valoreRipristinoColl);
        log.info("############ NUMERO VALORE RIPRISTINO : " + valoreRipristinoColl.size());

        //Recupero i nuovi dati della tab valore_par_sing_mac e li aggiungo alla collection DaInserire    
        Collection<ValoreParSingMac> valoreParSingMacColl = valoreParSingMacJc.findValoreParSingMacNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(valoreParSingMacColl);

//        for (Object obj : valoreParSingMacColl) {
//            log.info("valore-par-sing-mac : " + obj.toString());
//        }
        log.info("############ NUMERO VALORE PAR SING MAC : " + valoreParSingMacColl.size());

        //Seleziono i valori dei parametri dei componenti dalla tabella valore_par_comp 
        //e aggiungo all'aggiornamento solo se i componenti sono fra quelli assegnati alla macchina
        Collection<ValoreParComp> valoreParCompColl = valoreParCompJc.findValoreParCompNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        int v = 0;
        for (Object obj : valoreParCompColl) {
            ValoreParComp valoreParComp = (ValoreParComp) obj;
            if (componentiAssegnatiColl.contains(valoreParComp.getIdComp())) {
                aggiornamentoOut.getDaInserire().add(valoreParComp);
                v++;
            }
        }
        log.info("############ NUMERO VALORE PAR COMP : " + v);

        //######################################################################
        //######## NUOVE TABELLE VALORI PARAMETRI PRODOTTO #####################
        //######################################################################
        //################## GESTIONE DELLA VERSIONE ###########################
        // Parametri per la gestione delle versioni del software
        //Il valore del campo valore_mac della tabella valore_par_sing_mac con id_par_sm=27 indica la versione di origamidb
        Integer idParVersioneDb = 27;
        //Il valore del campo valore_mac della tabella valore_par_sing_mac con id_par_sm=221 indica la versione del programma CloudFab
        Integer idParVersioneSftw = 211;
        //Valore del campo user_origami della tabella macchina 
        //se user_origami=2 vuol dire che ancora non è mai stato inviato un aggiornamento
        //contenente i nuovi dati delle tabelle valore_prodotto, valore_par_prod_mac
        String valorePrimoAgg = macchina.getUserOrigami();

        ParametroSingMac parVersioneDb = new ParametroSingMac(idParVersioneDb);
        ParametroSingMac parVersioneSftw = new ParametroSingMac(idParVersioneSftw);

        String versioneDb = "2";
        String stringVersioneSftw = "CloudFab2";
        String versioneSftw = "2";

        versioneDb = valoreParSingMacJc.findValoreByMacchinaIdPar(macchina.getIdMacchina(), parVersioneDb).getValoreMac();
        stringVersioneSftw = valoreParSingMacJc.findValoreByMacchinaIdPar(macchina.getIdMacchina(), parVersioneSftw).getValoreMac();

        if (stringVersioneSftw != null && !stringVersioneSftw.isEmpty()) {
            versioneSftw = stringVersioneSftw.substring(8, 9);
        }

        //######################################################################
        // Se il campo valore_mac relativo ai valori dei parametri singola macchina 27 e 211 che
        //indicano la versione rispettivamente del db e del software a bordo macchina
        //sono uguali a 3 allora si puossono includere nell'aggiornamento i dati relativi alle nuove tabelle
        //dei parametri prodotto
        log.info("USER-ORIGAMI: " + macchina.getUserOrigami());
        log.info("VERSIONE DB: " + versioneDb);
        log.info("VERSIONE CloudFab: " + versioneSftw);

        //Per le Macchine nuove si verifica il valore del campo pass_origami e si genera direttamente l'aggiornamento completo
        //Per le Macchine che devono passare dal vecchio software al nuovo si verificano 3 valori
        // - versioneDb,
        // - versioneSoftw, 
        // - userOrigami
        if ((versioneDb.equals("3") & versioneSftw.equals("3")) || macchina.getPassOrigami().equals("3")) {

            Date dataUltAgg = null;
            dataUltAgg = machineCredentials.getLastUpdateDate();

            //Se il campo user_origami della macchina non ha ancora valore 3 vuol 
            //dire che è la prima volta che vengono inviati i dati nuovi e quindi si imposta la data al 1970
            //e vengono inviati tutti i parametri
            if (!macchina.getUserOrigami().equals("3")) {
                //Si imposta la data dell'ultimo agg al 1970 e si mandano tutti i valori dei parametri nuovi
                dataUltAgg = SyncOrigamiConstants.DATA_DEFAULT;

                log.info("Data ultimo agg impostata a : " + dataUltAgg);
                //Bisogna aggiornare il campo user_origami nella tab macchina di serverdb e impostarlo =3
                macchina.setUserOrigami("3");
                macchinaJc.merge(macchina);

                log.info("Modificato campo user_origami tab macchina di serverdb");

            }

            //Recupero i nuovi dati della tab parametro_prod e li aggiungo alla collection DaInserire  ???servono???   
            Collection<ParametroProd> parametroProdColl = parametroProdJc.findParametroProdNew(dataUltAgg);
            aggiornamentoOut.getDaInserire().addAll(parametroProdColl);

            //Recupero i nuovi dati della tab parametro_prod_mac e li aggiungo alla collection DaInserire  ???servono???   
            Collection<ParametroProdMac> parametroProdMacColl = parametroProdMacJc.findParametroProdMacNew(dataUltAgg);
            aggiornamentoOut.getDaInserire().addAll(parametroProdMacColl);
//        
            log.info("############ NUMERO PARAMETRI PROD MAC : " + parametroProdMacColl.size());

//        Recupero i nuovi dati della tab valore_prodotto e li aggiungo alla collection DaInserire  
//        solo se si riferiscono ad uno dei prodotti assegnati alla macchina   
            Collection<ValoreProdotto> valoreProdottoColl = valoreProdottoJc.findValoreProdottoNew(dataUltAgg);
            int y = 0;
            for (Object obj : valoreProdottoColl) {
                ValoreProdotto valoreProdotto = (ValoreProdotto) obj;
                if (prodottiAssegnatiColl.contains(valoreProdotto.getIdProdotto())) {
                    aggiornamentoOut.getDaInserire().add(valoreProdotto);
//                log.info("valore-prodotto: " + valoreProdotto.toString());
                    y++;
                }
            }
            log.info("############ NUMERO VALORI PRODOTTO : " + y);
//        
//        Recupero i nuovi dati della tab valore_par_prod_mac e li aggiungo alla collection DaInserire  
//        solo se si riferiscono ad uno dei prodotti assegnati alla macchina   
            Collection<ValoreParProdMac> valoreParProdMacColl = valoreParProdMacJc.findValoreParProdMacNew(dataUltAgg, macchina.getIdMacchina());
            int r = 0;
            for (Object obj : valoreParProdMacColl) {
                ValoreParProdMac ValoreParProdMac = (ValoreParProdMac) obj;
                if (prodottiAssegnatiColl.contains(ValoreParProdMac.getIdProdotto())) {
                    aggiornamentoOut.getDaInserire().add(ValoreParProdMac);
                    r++;
                }
            }
            log.info("############ NUMERO VALORI PAR PROD MAC : " + r);
        }//end dati relativi a nuovi parametri

        //######################################################################
        //####################### FINE PARAMETRI NUOVI #########################
        //######################################################################
        log.info("############ NUMERO TOT COLLECTION DA INSERIRE : " + aggiornamentoOut.getDaInserire().size());

        log.info("MACCHINA CON ID_MACCHINA : " + machineCredentials.getIdMacchina());
        log.info("DATA DI COSTRUZIONE DELL'ULTIMO AGGIORNAMENTO : " + machineCredentials.getLastUpdateDate());
        log.info("ULTIMA VERSIONE AGGIORNAMENTO : " + machineCredentials.getLastUpdateVersion());

        //Setto alcuni campi dell' oggetto aggiornamento
        //Calcolo la versione dell'aggiornamento corrente
        aggiornamentoOut.setIdMacchina(macchina);
        aggiornamentoOut.setTipo(outFilePfx);
        aggiornamentoOut.setDtAggiornamento(new Date());

        aggiornamentoOut.setVersione(machineCredentials.getLastUpdateVersion() + 1);

        return aggiornamentoOut;

    }

    /**
     * Metodo che gestisce l'aggiornamento per le macchine con versione 4 del
     * programma
     *
     * @param machineCredentials
     * @param emf
     * @param outFilePfx
     * @return
     * @throws NonexistentEntityException
     * @throws Exception
     */
    public static Aggiornamento costruisciAggiornamento4(MachineCredentials machineCredentials,
            EntityManagerFactory emf,
            String outFilePfx) throws NonexistentEntityException, Exception {

        Aggiornamento aggiornamentoOut = new Aggiornamento();
        aggiornamentoOut.setDaInserire(new ArrayList());

        AggiornamentoJpaController aggiornamentoJc = new AggiornamentoJpaController(null, emf);
        AggiornamentoConfigJpaController aggiornamentoConfigJc = new AggiornamentoConfigJpaController(null, emf);
        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
        ProdottoJpaController prodottoJc = new ProdottoJpaController(null, emf);
        AnagrafeProdottoJpaController anagrafeProdottoJc = new AnagrafeProdottoJpaController(null, emf);
        CategoriaJpaController categoriaJc = new CategoriaJpaController(null, emf);
        ChimicaJpaController chimicaJc = new ChimicaJpaController(null, emf);
        ColoreJpaController coloreJc = new ColoreJpaController(null, emf);
        ColoreBaseJpaController coloreBaseJc = new ColoreBaseJpaController(null, emf);
        ComponenteJpaController componenteJc = new ComponenteJpaController(null, emf);
        ComponenteProdottoJpaController componenteProdottoJc = new ComponenteProdottoJpaController(null, emf);
        ParametroCompProdJpaController parametroCompProdJc = new ParametroCompProdJpaController(null, emf);
        DizionarioJpaController dizionarioJc = new DizionarioJpaController(null, emf);
        PresaJpaController presaJc = new PresaJpaController(null, emf);
        MazzettaJpaController mazzettaJc = new MazzettaJpaController(null, emf);
        MazzettaColorataJpaController mazzettaColorataJc = new MazzettaColorataJpaController(null, emf);
        NumSacchettoJpaController numSacchettoJc = new NumSacchettoJpaController(null, emf);
        ParametroGlobMacJpaController parametroGlobMacJc = new ParametroGlobMacJpaController(null, emf);
        ParametroProdottoJpaController parametroProdottoJc = new ParametroProdottoJpaController(null, emf);
        ParametroRipristinoJpaController parametroRipristinoJc = new ParametroRipristinoJpaController(null, emf);
        ParametroSacchettoJpaController parametroSacchettoJc = new ParametroSacchettoJpaController(null, emf);
        ParametroSingMacJpaController parametroSingMacJc = new ParametroSingMacJpaController(null, emf);
        ValoreParProdJpaController valoreParProdJc = new ValoreParProdJpaController(null, emf);
        ValoreParSacchettoJpaController valoreParSacchettoJc = new ValoreParSacchettoJpaController(null, emf);
        ValoreRipristinoJpaController valoreRipristinoJc = new ValoreRipristinoJpaController(null, emf);
        ValoreParSingMacJpaController valoreParSingMacJc = new ValoreParSingMacJpaController(null, emf);
        ValoreParCompJpaController valoreParCompJc = new ValoreParCompJpaController(null, emf);
        ParametroProdJpaController parametroProdJc = new ParametroProdJpaController(null, emf);
        ParametroProdMacJpaController parametroProdMacJc = new ParametroProdMacJpaController(null, emf);
        ValoreProdottoJpaController valoreProdottoJc = new ValoreProdottoJpaController(null, emf);
        ValoreParProdMacJpaController valoreParProdMacJc = new ValoreParProdMacJpaController(null, emf);

        //######## Modifiche 24 agosto 2017 NUOVE TABELLE 
        OrdineSingMacJpaController ordineSingMacJc = new OrdineSingMacJpaController(null, emf);
        ValoreParOrdineJpaController valoreParOrdineJc = new ValoreParOrdineJpaController(null, emf);
        AllarmeJpaController allarmeJc = new AllarmeJpaController(null, emf);
        FiguraJpaController figuraJc = new FiguraJpaController(null, emf);
        FiguraTipoJpaController figuraTipoJc = new FiguraTipoJpaController(null, emf);
        MovimentoSingMacJpaController movimentoSingMacJc = new MovimentoSingMacJpaController(null, emf);
        ComponentePesaturaJpaController componentePesaturaJc = new ComponentePesaturaJpaController(null, emf);

        //Prendo l'entità macchina con id_macchina che intendo aggiornare
        Macchina macchina = macchinaJc.findMacchina(machineCredentials.getIdMacchina());

        //Recupero i nuovi dati della tab macchina e li inserisco nella collection DaInserire
        //solo se il campo dtAbilitato è > della data dell'ultimo aggiornamento
        Macchina macchinaNew = macchinaJc.findMacchina(macchina.getIdMacchina());
        if (macchinaNew.getDtAbilitato().compareTo(machineCredentials.getLastUpdateDate()) > 0) {
            aggiornamentoOut.getDaInserire().add(macchinaNew);
            log.info("############ DATI ANAGRAFICI MODIFICATI PER MACCHINA (tabella macchina)!!!");
        } else {
            log.info("############ DATI ANAGRAFICI NON MODIFICATI PER MACCHINA (tabella macchina)!!!");
        }

        //Elenco dei prodotti assegnati alla macchina indipendentemente da modifiche fatte sui dati
        Collection<Prodotto> prodottiAssegnatiColl = prodottoJc.findProdottiAssegnati(macchina);
        log.info("############ NUMERO PRODOTTI ASSEGNATI IN TUTTO : " + prodottiAssegnatiColl.size());

        //Elenco dei componenti assegnati alla macchina indipendentemente da modifiche fatte sui dati
        Collection<Componente> componentiAssegnatiColl = componenteJc.findComponentiAssegnati(macchina);
        log.info("############ NUMERO COMPONENTI ASSEGNATI IN TUTTO : " + componentiAssegnatiColl.size());

        //Recupero i nuovi dati della tab aggiornamento_config e li aggiungo alla collection DaInserire    
        Collection<AggiornamentoConfig> aggiornamentoConfigColl = aggiornamentoConfigJc.findAggiornamentoConfigNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(aggiornamentoConfigColl);
        log.info("############ NUMERO PARAMETRI AGGIORNAMENTO CONFIG : " + aggiornamentoConfigColl.size());

        //Recupero i nuovi dati della tab colore e li aggiungo alla collection DaInserire    
        Collection<Colore> coloreColl = coloreJc.findColoreNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(coloreColl);

        log.info("############ NUMERO COLORI : " + coloreColl.size());

        //Recupero i nuovi dati della tab colore_base e li aggiungo alla collection DaInserire    
        Collection<ColoreBase> coloreBaseColl = coloreBaseJc.findColoreBaseNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(coloreBaseColl);

        log.info("############ NUMERO COLORI BASE : " + coloreBaseColl.size());

        //Seleziono i componenti dalla tabella componente verificando le date nelle tabelle componente, componente_prodotto, anagrafe_prodotto
        //e aggiungo all'aggiornamento solo se i componenti sono fra quelli assegnati alla macchina
        Collection<Componente> componenteColl = componenteJc.findComponenteNew(machineCredentials.getLastUpdateDate());
        int k = 0;
        for (Object obj : componenteColl) {
            Componente componente = (Componente) obj;
            if (componentiAssegnatiColl.contains(componente)) {
                aggiornamentoOut.getDaInserire().add(componente);
                k++;
            }
        }
        log.info("############ NUMERO COMPONENTI : " + k);

        //Recupero i nuovi dati della tab mazzetta e li aggiungo alla collection DaInserire    
        Collection<Mazzetta> mazzettaColl = mazzettaJc.findMazzettaNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(mazzettaColl);
        log.info("############ NUMERO MAZZETTE : " + mazzettaColl.size());

        //Recupero i nuovi dati della tab mazzetta_colorata e li aggiungo alla collection DaInserire    
        Collection<MazzettaColorata> mazzettaColorataColl = mazzettaColorataJc.findMazzettaColorataNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(mazzettaColorataColl);
        log.info("############ NUMERO MAZZETTE COLORATE : " + mazzettaColorataColl.size());

        //Recupero i nuovi dati della tab categoria e li aggiungo alla collection DaInserire    
        Collection<Categoria> categoriaColl = categoriaJc.findCategoriaNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(categoriaColl);
        log.info("############ NUMERO CATEGORIE : " + categoriaColl.size());

        //Recupero i nuovi dati della tab parametro_comp_prod e li aggiungo alla collection DaInserire    
        Collection<ParametroCompProd> parametroCompProdColl = parametroCompProdJc.findParametroCompProdNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroCompProdColl);
        log.info("############ NUMERO PARAMETRI COMP PROD : " + parametroCompProdColl.size());

        //Seleziono i prodotti con data nuova dalla tabella anagrafe_prodotto 
        //e li aggiungo all'aggiornamento solo se i prodotti sono fra quelli assegnati alla macchina
        Collection<AnagrafeProdotto> anagrafeProdottoColl = anagrafeProdottoJc.findAnagrafeProdottoNew(machineCredentials.getLastUpdateDate());
        int n = 0;
        int comp = 0;

        int pesatura = 0;
        for (Object obj : anagrafeProdottoColl) {
            AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj;
            if (prodottiAssegnatiColl.contains(anagrafeProdotto.getIdProdotto())) {
                aggiornamentoOut.getDaInserire().add(anagrafeProdotto);
                //Aggiungo all'agg tutti i componenti del prodotto anche se non sono stati modificati
                //Ogni volta che mando un prodotto nuovo (magari perchè è stato assegnato ad una nuova mac) mando sempre tutti i suoi componenti 
                Collection<ComponenteProdotto> componenteProdottoColl = componenteProdottoJc.findComponenteProdottoIdProd(anagrafeProdotto.getIdProdotto());
                for (Object compProd : componenteProdottoColl) {
                    ComponenteProdotto componenteProdotto = (ComponenteProdotto) compProd;
                    aggiornamentoOut.getDaInserire().add(componenteProdotto);
                    comp++;
                }
                n++;
                //Modifica del 24/agosto/2017
                //Aggiungo all'agg tutti i dati della pesatura del prodotto anche se non sono stati modificati
                //Ogni volta che mando un prodotto nuovo (magari perchè è stato assegnato ad una nuova mac) mando sempre tutti i dati sulla pesatura 
                Collection<ComponentePesatura> componentePesaturaColl = componentePesaturaJc.findComponentePesaturaIdProd(anagrafeProdotto.getIdProdotto());
                for (Object compPes : componentePesaturaColl) {
                    ComponentePesatura componentePesatura = (ComponentePesatura) compPes;
                    aggiornamentoOut.getDaInserire().add(componentePesatura);
                    pesatura++;
                }
                //################################################################

            }
        }
        log.info("############ NUMERO ANAGRAFE PRODOTTO : " + n);
        log.info("############ NUMERO COMPONENTI NEI PRODOTTI NUOVI : " + comp);
        log.info("############ NUMERO DATI PESATURA COMP : " + pesatura);

        //Seleziono i componenti dei prodotti  dalla tabella componente_prodotto 
        //e aggiungo all'aggiornamento solo se i prodotti sono fra quelli assegnati alla macchina
        Collection<ComponenteProdotto> componenteProdottoColl = componenteProdottoJc.findComponenteProdottoNew(machineCredentials.getLastUpdateDate());
        int m = 0;
        for (Object obj : componenteProdottoColl) {
            ComponenteProdotto componenteProdotto = (ComponenteProdotto) obj;
            if (prodottiAssegnatiColl.contains(componenteProdotto.getIdProdotto())) {
                aggiornamentoOut.getDaInserire().add(componenteProdotto);
                m++;
            }
        }
        log.info("############ NUMERO COMPONENTE PRODOTTO : " + m);

        //Modifica del ottobre/2017 ###########################################
        //Seleziono i dati di pesatura dei componenti  dalla tabella componente_pesatura
        //e aggiungo all'aggiornamento solo se i prodotti sono fra quelli assegnati alla macchina
        Collection<ComponentePesatura> componentePesaturaColl = componentePesaturaJc.findComponentePesaturaNew(machineCredentials.getLastUpdateDate());
        int mp = 0;
        for (Object obj : componentePesaturaColl) {
            ComponentePesatura componentePesatura = (ComponentePesatura) obj;
            Prodotto prod=new Prodotto(componentePesatura.getIdProdotto());           
            if (prodottiAssegnatiColl.contains(prod)){
                aggiornamentoOut.getDaInserire().add(componentePesatura);
                mp++;
            }
        }
        log.info("############ NUMERO COMPONENTE PESATURA : " + mp);

        //Recupero i nuovi dati della tab allarme e li aggiungo alla collection DaInserire    
        Collection<Allarme> allarmeColl = allarmeJc.findAllarmeNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(allarmeColl);
        log.info("############ NUMERO ALLARMI : " + allarmeColl.size());

        //Inserire in parametri globali 139
        Integer idParOrigineMov = 139;
        String strParOrigineMov = "";
        strParOrigineMov = parametroGlobMacJc.findParametroGlobMac(idParOrigineMov).getValoreVariabile();

        //Recupero i nuovi dati della tabella movimento_sing_mac e li aggiungo alla collection DaInserire    
        Collection<MovimentoSingMac> movimentoSingMacColl = movimentoSingMacJc.findMovimentoSingMacNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina(), strParOrigineMov);
        aggiornamentoOut.getDaInserire().addAll(movimentoSingMacColl);
        log.info("############ NUMERO MOVIMENTI SING MAC: " + movimentoSingMacColl.size());

        //Recupero i nuovi dati della tabella ordine_sing_mac e li aggiungo alla collection DaInserire    
        Collection<OrdineSingMac> ordineSingMacColl = ordineSingMacJc.findOrdineSingMacNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(ordineSingMacColl);
        log.info("############ NUMERO ORDINE SING MAC : " + ordineSingMacColl.size());

        //Recupero i nuovi dati della tabella valore_par_ordine e li aggiungo alla collection DaInserire    
        Collection<ValoreParOrdine> valoreParOrdineColl = valoreParOrdineJc.findValoreParOrdineNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(valoreParOrdineColl);
        log.info("############ NUMERO VALORE PAR ORDINE : " + valoreParOrdineColl.size());

        //Recupero i nuovi dati della tabella figura_tipo e li aggiungo alla collection DaInserire    
        Collection<FiguraTipo> figuraTipoColl = figuraTipoJc.findFiguraTipoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(figuraTipoColl);
        log.info("############ NUMERO FIGURA TIPO: " + figuraTipoColl.size());

        //Recupero i nuovi dati della tabella figura e li aggiungo alla collection DaInserire    
        Collection<Figura> figuraColl = figuraJc.findFiguraNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(figuraColl);
        log.info("############ NUMERO FIGURA : " + figuraColl.size());

        //Recupero i nuovi dati della tab presa e li aggiungo alla collection DaInserire    
        Collection<Presa> presaColl = presaJc.findPresaNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(presaColl);
        log.info("############ NUMERO PRESE : " + presaColl.size());

        //Recupero i nuovi dati della tab dizionario e li aggiungo alla collection DaInserire    
        Collection<Dizionario> dizionarioColl = dizionarioJc.findDizionarioNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(dizionarioColl);
        log.info("############ NUMERO DIZIONARIO : " + dizionarioColl.size());

        //Recupero i nuovi dati della tab chimica, bolla, lotto e li aggiungo alla collection DaInserire    
        Collection<Chimica> chimicaColl = chimicaJc.findChimicaNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(chimicaColl);
        log.info("############ NUMERO CHIMICHE : " + chimicaColl.size());

        //Recupero i nuovi dati della tab num_sacchetto e li aggiungo alla collection DaInserire    
        Collection<NumSacchetto> numSacchettoColl = numSacchettoJc.findNumSacchettoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(numSacchettoColl);
        log.info("############ NUMERO SACCHETTO : " + numSacchettoColl.size());

        //Recupero i nuovi dati della tab parametro_glob_mac e li aggiungo alla collection DaInserire    
        Collection<ParametroGlobMac> parametroGlobMacColl = parametroGlobMacJc.findParametroGlobMacNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroGlobMacColl);
        log.info("############ NUMERO PARAMETRO GLOBALE MAC : " + parametroGlobMacColl.size());

        //Recupero i nuovi dati della tab parametro_prodotto e li aggiungo alla collection DaInserire    
        Collection<ParametroProdotto> parametroProdottoColl = parametroProdottoJc.findParametroProdottoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroProdottoColl);
        log.info("############ NUMERO PARAMETRO PRODOTTO : " + parametroProdottoColl.size());

        //Recupero i nuovi dati della tab parametro_ripristino e li aggiungo alla collection DaInserire    
        Collection<ParametroRipristino> parametroRipristinoColl = parametroRipristinoJc.findParametroRipristinoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroRipristinoColl);
        log.info("############ NUMERO PARAMETRO RIPRISTINO : " + parametroRipristinoColl.size());

        //Recupero i nuovi dati della tab parametro_sacchetto e li aggiungo alla collection DaInserire    
        Collection<ParametroSacchetto> parametroSacchettoColl = parametroSacchettoJc.findParametroSacchettoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroSacchettoColl);
        log.info("############ NUMERO PARAMETRO SACCHETTO : " + parametroSacchettoColl.size());

        //Recupero i nuovi dati della tab parametro_sing_mac e li aggiungo alla collection DaInserire    
        Collection<ParametroSingMac> parametroSingMacColl = parametroSingMacJc.findParametroSingMacNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroSingMacColl);
        log.info("############ NUMERO PARAMETRO SINGOLA MAC : " + parametroSingMacColl.size());

        //Recupero i nuovi dati della tab valore_par_prod e li aggiungo alla collection DaInserire    
        Collection<ValoreParProd> valoreParProdColl = valoreParProdJc.findValoreParProdNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(valoreParProdColl);
        log.info("############ NUMERO VALORE PAR PROD : " + valoreParProdColl.size());

        //Recupero i nuovi dati della tab valore_par_sacchetto e li aggiungo alla collection DaInserire    
        Collection<ValoreParSacchetto> valoreParSacchettoColl = valoreParSacchettoJc.findValoreParSacchettoNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(valoreParSacchettoColl);
        log.info("############ NUMERO VALORE PAR SACCHETTO : " + valoreParSacchettoColl.size());

        //Recupero i nuovi dati della tab valore_ripristino e li aggiungo alla collection DaInserire    
        Collection<ValoreRipristino> valoreRipristinoColl = valoreRipristinoJc.findValoreRipristinoNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(valoreRipristinoColl);
        log.info("############ NUMERO VALORE RIPRISTINO : " + valoreRipristinoColl.size());

        //Recupero i nuovi dati della tab valore_par_sing_mac e li aggiungo alla collection DaInserire    
        Collection<ValoreParSingMac> valoreParSingMacColl = valoreParSingMacJc.findValoreParSingMacNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(valoreParSingMacColl);
        log.info("############ NUMERO VALORE PAR SING MAC : " + valoreParSingMacColl.size());

        //Seleziono i valori dei parametri dei componenti dalla tabella valore_par_comp 
        //e aggiungo all'aggiornamento solo se i componenti sono fra quelli assegnati alla macchina
        Collection<ValoreParComp> valoreParCompColl = valoreParCompJc.findValoreParCompNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        int v = 0;
        for (Object obj : valoreParCompColl) {
            ValoreParComp valoreParComp = (ValoreParComp) obj;
            if (componentiAssegnatiColl.contains(valoreParComp.getIdComp())) {
                aggiornamentoOut.getDaInserire().add(valoreParComp);
                v++;
            }
        }
        log.info("############ NUMERO VALORE PAR COMP : " + v);

        //######################################################################
        //########  TABELLE VALORI PARAMETRI PRODOTTO (versione CloudFab3 ) ####
        //######################################################################
        //Recupero i nuovi dati della tab parametro_prod e li aggiungo alla collection DaInserire  ???servono???   
        Collection<ParametroProd> parametroProdColl = parametroProdJc.findParametroProdNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroProdColl);

        //Recupero i nuovi dati della tab parametro_prod_mac e li aggiungo alla collection DaInserire  ???servono???   
        Collection<ParametroProdMac> parametroProdMacColl = parametroProdMacJc.findParametroProdMacNew(machineCredentials.getLastUpdateDate());
        aggiornamentoOut.getDaInserire().addAll(parametroProdMacColl);

        log.info("############ NUMERO PARAMETRI PROD MAC : " + parametroProdMacColl.size());

        //Recupero i nuovi dati della tab valore_prodotto e li aggiungo alla collection DaInserire  
        //solo se si riferiscono ad uno dei prodotti assegnati alla macchina   
        Collection<ValoreProdotto> valoreProdottoColl = valoreProdottoJc.findValoreProdottoNew(machineCredentials.getLastUpdateDate());
        int y = 0;
        for (Object obj : valoreProdottoColl) {
            ValoreProdotto valoreProdotto = (ValoreProdotto) obj;
            if (prodottiAssegnatiColl.contains(valoreProdotto.getIdProdotto())) {
                aggiornamentoOut.getDaInserire().add(valoreProdotto);
                y++;
            }
        }
        log.info("############ NUMERO VALORI PRODOTTO : " + y);

        //Recupero i nuovi dati della tab valore_par_prod_mac e li aggiungo alla collection DaInserire  
        //solo se si riferiscono ad uno dei prodotti assegnati alla macchina   
        Collection<ValoreParProdMac> valoreParProdMacColl = valoreParProdMacJc.findValoreParProdMacNew(machineCredentials.getLastUpdateDate(), macchina.getIdMacchina());
        int r = 0;
        for (Object obj : valoreParProdMacColl) {
            ValoreParProdMac ValoreParProdMac = (ValoreParProdMac) obj;
            if (prodottiAssegnatiColl.contains(ValoreParProdMac.getIdProdotto())) {
                aggiornamentoOut.getDaInserire().add(ValoreParProdMac);
                r++;
            }
        }
        log.info("############ NUMERO VALORI PAR PROD MAC : " + r);

        log.info("############ NUMERO TOT COLLECTION DA INSERIRE : " + aggiornamentoOut.getDaInserire().size());

        log.info("MACCHINA CON ID_MACCHINA : " + machineCredentials.getIdMacchina());
        log.info("DATA DI COSTRUZIONE DELL' ULTIMO AGGIORNAMENTO : " + machineCredentials.getLastUpdateDate());
        log.info("ULTIMA VERSIONE AGGIORNAMENTO : " + machineCredentials.getLastUpdateVersion());

        //Setto alcuni campi dell'oggetto aggiornamento
        //Calcolo la versione dell'aggiornamento corrente
        aggiornamentoOut.setIdMacchina(macchina);
        aggiornamentoOut.setTipo(outFilePfx);
        aggiornamentoOut.setDtAggiornamento(new Date());

        aggiornamentoOut.setVersione(machineCredentials.getLastUpdateVersion() + 1);

        return aggiornamentoOut;

    }

    /**
     * Metodo che invia per la prima volta un aggiornamento gestendo il
     * l'avanzamento della versione del software dalla 3 alla 4 Aggiunge
     * all'oggetto aggiornamento i dati relativi alle tabelle: Ordine_sing_mac,
     * valore_par_ordine,allarme,figura,figura_tipo,movimento_sing_mac,componente_pesatura
     *
     * @param machineCredentials
     * @param emf
     * @param aggiornamentoOut
     * @return
     * @throws NonexistentEntityException
     * @throws Exception
     */
    public static Aggiornamento aggiungiDatiPrimoAggiornamento4(MachineCredentials machineCredentials,
            EntityManagerFactory emf,
            Aggiornamento aggiornamentoOut) throws NonexistentEntityException, Exception {

        log.info("############@versioneSFTW INIZIO METODO   aggiungiDatiPrimoAggiornamento4");

        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
        ProdottoJpaController prodottoJc = new ProdottoJpaController(null, emf);
        AnagrafeProdottoJpaController anagrafeProdottoJc = new AnagrafeProdottoJpaController(null, emf);
        ComponenteJpaController componenteJc = new ComponenteJpaController(null, emf);
        ParametroGlobMacJpaController parametroGlobMacJc = new ParametroGlobMacJpaController(null, emf);

        //######## Modifiche 24 agosto 2017 NUOVE TABELLE 
        OrdineSingMacJpaController ordineSingMacJc = new OrdineSingMacJpaController(null, emf);
        ValoreParOrdineJpaController valoreParOrdineJc = new ValoreParOrdineJpaController(null, emf);
        AllarmeJpaController allarmeJc = new AllarmeJpaController(null, emf);
        FiguraJpaController figuraJc = new FiguraJpaController(null, emf);
        FiguraTipoJpaController figuraTipoJc = new FiguraTipoJpaController(null, emf);
        MovimentoSingMacJpaController movimentoSingMacJc = new MovimentoSingMacJpaController(null, emf);
        ComponentePesaturaJpaController componentePesaturaJc = new ComponentePesaturaJpaController(null, emf);

        //Prendo l'entità macchina con id_macchina che intendo aggiornare
        Macchina macchina = macchinaJc.findMacchina(machineCredentials.getIdMacchina());

        //Elenco dei prodotti assegnati alla macchina indipendentemente da modifiche fatte sui dati
        Collection<Prodotto> prodottiAssegnatiColl = prodottoJc.findProdottiAssegnati(macchina);

        //Elenco dei componenti assegnati alla macchina indipendentemente da modifiche fatte sui dati
        Collection<Componente> componentiAssegnatiColl = componenteJc.findComponentiAssegnati(macchina);

        //Si imposta la data dell'ultimo agg al 1970 e si mandano tutti i valori dei parametri nuovi
        Date dataUltAgg = null;
        dataUltAgg = SyncOrigamiConstants.DATA_DEFAULT;

        log.info("Data ultimo agg impostata a : " + dataUltAgg);
        //Bisogna aggiornare il campo user_origami nella tab macchina di serverdb e impostarlo=4
        macchina.setUserOrigami("4");
        macchinaJc.merge(macchina);

        log.info("Modificato campo user_origami tab macchina di serverdb");

        //Seleziono i prodotti con data nuova dalla tabella anagrafe_prodotto 
        //e li aggiungo all'aggiornamento solo se i prodotti sono fra quelli assegnati alla macchina
        Collection<AnagrafeProdotto> anagrafeProdottoColl = anagrafeProdottoJc.findAnagrafeProdottoNew(dataUltAgg);
        int n = 0;
        int comp = 0;

        int pesatura = 0;
        for (Object obj : anagrafeProdottoColl) {
            AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj;
            if (prodottiAssegnatiColl.contains(anagrafeProdotto.getIdProdotto())) {
                aggiornamentoOut.getDaInserire().add(anagrafeProdotto);
                //Modifica del 24/agosto/2017
                //Aggiungo all'agg tutti i dati della pesatura del prodotto anche se non sono stati modificati
                //Ogni volta che mando un prodotto nuovo (magari perchè è stato assegnato ad una nuova mac) mando sempre tutti i dati sulla pasatura 
                Collection<ComponentePesatura> componentePesaturaColl = componentePesaturaJc.findComponentePesaturaIdProd(anagrafeProdotto.getIdProdotto());
                for (Object compPes : componentePesaturaColl) {
                    ComponentePesatura componentePesatura = (ComponentePesatura) compPes;
                    aggiornamentoOut.getDaInserire().add(componentePesatura);
                    pesatura++;
                }
                //################################################################
                n++;
            }
        }
        log.info("############ NUMERO ANAGRAFE PRODOTTO : " + n);
        log.info("############ NUMERO DATI PESATURA COMP (se modificato anagrafe_prodotto): " + pesatura);

        //Seleziono i dati di pesatura dei componenti  dalla tabella componente_pesatura
        //e aggiungo all'aggiornamento solo se i prodotti sono fra quelli assegnati alla macchina
        Collection<ComponentePesatura> componentePesaturaColl = componentePesaturaJc.findComponentePesaturaNew(dataUltAgg);
        int mp = 0;
        for (Object obj : componentePesaturaColl) {
            ComponentePesatura componentePesatura = (ComponentePesatura) obj;
            Prodotto prod=new Prodotto(componentePesatura.getIdProdotto());
            if (prodottiAssegnatiColl.contains(prod)) {
                aggiornamentoOut.getDaInserire().add(componentePesatura);
                mp++;
            }
        }
        log.info("############ NUMERO ALTRI COMPONENTE PESATURA : " + mp);

        //Recupero i nuovi dati della tab allarme e li aggiungo alla collection DaInserire    
        Collection<Allarme> allarmeColl = allarmeJc.findAllarmeNew(dataUltAgg);
        aggiornamentoOut.getDaInserire().addAll(allarmeColl);
        log.info("############ NUMERO ALLARMI : " + allarmeColl.size());

        //Inserire in parametri globali 139
        Integer idParOrigineMov = 139;
        String strParOrigineMov = "";
        strParOrigineMov = parametroGlobMacJc.findParametroGlobMac(idParOrigineMov).getValoreVariabile();

        //Recupero i nuovi dati della tabella movimento_sing_mac e li aggiungo alla collection DaInserire    
        Collection<MovimentoSingMac> movimentoSingMacColl = movimentoSingMacJc.findMovimentoSingMacNew(dataUltAgg, macchina.getIdMacchina(), strParOrigineMov);
        aggiornamentoOut.getDaInserire().addAll(movimentoSingMacColl);
        log.info("############ NUMERO MOVIMENTI SING MAC: " + movimentoSingMacColl.size());

        //Recupero i nuovi dati della tabella ordine_sing_mac e li aggiungo alla collection DaInserire    
        Collection<OrdineSingMac> ordineSingMacColl = ordineSingMacJc.findOrdineSingMacNew(dataUltAgg, macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(ordineSingMacColl);
        log.info("############ NUMERO ORDINE SING MAC : " + ordineSingMacColl.size());

        //Recupero i nuovi dati della tabella valore_par_ordine e li aggiungo alla collection DaInserire    
        Collection<ValoreParOrdine> valoreParOrdineColl = valoreParOrdineJc.findValoreParOrdineNew(dataUltAgg, macchina.getIdMacchina());
        aggiornamentoOut.getDaInserire().addAll(valoreParOrdineColl);
        log.info("############ NUMERO VALORE PAR ORDINE : " + valoreParOrdineColl.size());

        //Recupero i nuovi dati della tabella figura_tipo e li aggiungo alla collection DaInserire    
        Collection<FiguraTipo> figuraTipoColl = figuraTipoJc.findFiguraTipoNew(dataUltAgg);
        aggiornamentoOut.getDaInserire().addAll(figuraTipoColl);
        log.info("############ NUMERO FIGURA TIPO: " + figuraTipoColl.size());

        //Recupero i nuovi dati della tabella figura e li aggiungo alla collection DaInserire    
        Collection<Figura> figuraColl = figuraJc.findFiguraNew(dataUltAgg);
        aggiornamentoOut.getDaInserire().addAll(figuraColl);
        log.info("############ NUMERO FIGURA : " + figuraColl.size());

        log.info("############ NUMERO TOT COLLECTION DA INSERIRE : " + aggiornamentoOut.getDaInserire().size());

        log.info("MACCHINA CON ID_MACCHINA : " + machineCredentials.getIdMacchina());
        log.info("DATA ULTIMO AGGIORNAMENTO SOLO PER DATI NUOVI AGG 4: " + dataUltAgg);
        log.info("ULTIMA VERSIONE AGGIORNAMENTO : " + machineCredentials.getLastUpdateVersion());

        return aggiornamentoOut;

    }

    /**
     * Metodo testato e funzionante per Kerneos , modificato il nome in questa
     * versione di sviluppo
     *
     * @param machineCredentials
     * @param emf
     * @param outFilePfx
     * @return
     * @throws NonexistentEntityException
     * @throws Exception
     *
     * public static Aggiornamento
     * costruisciAggiornamentoKerneos(MachineCredentials machineCredentials,
     * EntityManagerFactory emf, String outFilePfx) throws
     * NonexistentEntityException, Exception {
     *
     * Aggiornamento aggiornamentoOut = new Aggiornamento();
     * aggiornamentoOut.setDaInserire(new ArrayList());
     *
     * AggiornamentoJpaController aggiornamentoJc = new
     * AggiornamentoJpaController(null, emf); AggiornamentoConfigJpaController
     * aggiornamentoConfigJc = new AggiornamentoConfigJpaController(null, emf);
     * MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
     * ProdottoJpaController prodottoJc = new ProdottoJpaController(null, emf);
     * AnagrafeProdottoJpaController anagrafeProdottoJc = new
     * AnagrafeProdottoJpaController(null, emf); CategoriaJpaController
     * categoriaJc = new CategoriaJpaController(null, emf); ChimicaJpaController
     * chimicaJc = new ChimicaJpaController(null, emf); ColoreJpaController
     * coloreJc = new ColoreJpaController(null, emf); ColoreBaseJpaController
     * coloreBaseJc = new ColoreBaseJpaController(null, emf);
     * ComponenteJpaController componenteJc = new ComponenteJpaController(null,
     * emf); ComponenteProdottoJpaController componenteProdottoJc = new
     * ComponenteProdottoJpaController(null, emf);
     * ParametroCompProdJpaController parametroCompProdJc = new
     * ParametroCompProdJpaController(null, emf); DizionarioJpaController
     * dizionarioJc = new DizionarioJpaController(null, emf); PresaJpaController
     * presaJc = new PresaJpaController(null, emf); MazzettaJpaController
     * mazzettaJc = new MazzettaJpaController(null, emf);
     * MazzettaColorataJpaController mazzettaColorataJc = new
     * MazzettaColorataJpaController(null, emf); NumSacchettoJpaController
     * numSacchettoJc = new NumSacchettoJpaController(null, emf);
     * ParametroGlobMacJpaController parametroGlobMacJc = new
     * ParametroGlobMacJpaController(null, emf); ParametroProdottoJpaController
     * parametroProdottoJc = new ParametroProdottoJpaController(null, emf);
     * ParametroRipristinoJpaController parametroRipristinoJc = new
     * ParametroRipristinoJpaController(null, emf);
     * ParametroSacchettoJpaController parametroSacchettoJc = new
     * ParametroSacchettoJpaController(null, emf); ParametroSingMacJpaController
     * parametroSingMacJc = new ParametroSingMacJpaController(null, emf);
     * ValoreParProdJpaController valoreParProdJc = new
     * ValoreParProdJpaController(null, emf); ValoreParSacchettoJpaController
     * valoreParSacchettoJc = new ValoreParSacchettoJpaController(null, emf);
     * ValoreRipristinoJpaController valoreRipristinoJc = new
     * ValoreRipristinoJpaController(null, emf); ValoreParSingMacJpaController
     * valoreParSingMacJc = new ValoreParSingMacJpaController(null, emf);
     * ValoreParCompJpaController valoreParCompJc = new
     * ValoreParCompJpaController(null, emf); ParametroProdJpaController
     * parametroProdJc = new ParametroProdJpaController(null, emf);
     * ParametroProdMacJpaController parametroProdMacJc = new
     * ParametroProdMacJpaController(null, emf); ValoreProdottoJpaController
     * valoreProdottoJc = new ValoreProdottoJpaController(null, emf);
     * ValoreParProdMacJpaController valoreParProdMacJc = new
     * ValoreParProdMacJpaController(null, emf);
     *
     * //######## Modifiche 24 agosto 2017 NUOVE TABELLE
     * OrdineSingMacJpaController ordineSingMacJc = new
     * OrdineSingMacJpaController(null, emf); ValoreParOrdineJpaController
     * valoreParOrdineJc = new ValoreParOrdineJpaController(null, emf);
     *
     * AllarmeJpaController allarmeJc = new AllarmeJpaController(null, emf);
     *
     * FiguraJpaController figuraJc = new FiguraJpaController(null, emf);
     *
     * FiguraTipoJpaController figuraTipoJc = new FiguraTipoJpaController(null,
     * emf);
     *
     * MovimentoSingMacJpaController movimentoSingMacJc = new
     * MovimentoSingMacJpaController(null, emf);
     *
     * ComponentePesaturaJpaController componentePesaturaJc = new
     * ComponentePesaturaJpaController(null, emf);
     *
     * //Prendo l'entità macchina con id_macchina che intendo aggiornare
     * Macchina macchina =
     * macchinaJc.findMacchina(machineCredentials.getIdMacchina());
     *
     * //Recupero i nuovi dati della tab macchina e li inserisco nella
     * collection DaInserire //solo se il campo dtAbilitato è > della data
     * dell'ultimo aggiornamento Macchina macchinaNew =
     * macchinaJc.findMacchina(macchina.getIdMacchina()); if
     * (macchinaNew.getDtAbilitato().compareTo(machineCredentials.getLastUpdateDate())
     * > 0) { aggiornamentoOut.getDaInserire().add(macchinaNew);
     * log.info("############ DATI ANAGRAFICI MODIFICATI PER MACCHINA (tabella
     * macchina)!!!"); } else {
     *
     * log.info("############ DATI ANAGRAFICI NON MODIFICATI PER MACCHINA
     * (tabella macchina)!!!"); }
     *
     * //Elenco dei prodotti assegnati alla macchina indipendentemente da
     * modifiche fatte sui dati Collection<Prodotto> prodottiAssegnatiColl =
     * prodottoJc.findProdottiAssegnati(macchina); log.info("############ NUMERO
     * PRODOTTI ASSEGNATI IN TUTTO : " + prodottiAssegnatiColl.size());
     *
     * //Elenco dei componenti assegnati alla macchina indipendentemente da
     * modifiche fatte sui dati Collection<Componente> componentiAssegnatiColl =
     * componenteJc.findComponentiAssegnati(macchina); log.info("############
     * NUMERO COMPONENTI ASSEGNATI IN TUTTO : " +
     * componentiAssegnatiColl.size());
     *
     * //Recupero i nuovi dati della tab aggiornamento_config e li aggiungo
     * alla collection DaInserire Collection<AggiornamentoConfig>
     * aggiornamentoConfigColl =
     * aggiornamentoConfigJc.findAggiornamentoConfigNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(aggiornamentoConfigColl);
     * log.info("############ NUMERO PARAMETRI AGGIORNAMENTO CONFIG : " +
     * aggiornamentoConfigColl.size());
     *
     * //Recupero i nuovi dati della tab colore e li aggiungo alla collection
     * DaInserire Collection<Colore> coloreColl =
     * coloreJc.findColoreNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(coloreColl);
     *
     * log.info("############ NUMERO COLORI : " + coloreColl.size());
     *
     * //Recupero i nuovi dati della tab colore_base e li aggiungo alla
     * collection DaInserire Collection<ColoreBase> coloreBaseColl =
     * coloreBaseJc.findColoreBaseNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(coloreBaseColl);
     *
     * log.info("############ NUMERO COLORI BASE : " + coloreBaseColl.size());
     *
     * //Seleziono i componenti dalla tabella componente verificando le date
     * nelle tabelle componente, componente_prodotto, anagrafe_prodotto //e
     * aggiungo all'aggiornamento solo se i componenti sono fra quelli assegnati
     * alla macchina Collection<Componente> componenteColl =
     * componenteJc.findComponenteNew(machineCredentials.getLastUpdateDate());
     * int k = 0; for (Object obj : componenteColl) { Componente componente =
     * (Componente) obj; if (componentiAssegnatiColl.contains(componente)) {
     * aggiornamentoOut.getDaInserire().add(componente); k++; } }
     *
     * log.info("############ NUMERO COMPONENTI : " + k);
     *
     * //Recupero i nuovi dati della tab mazzetta e li aggiungo alla collection
     * DaInserire Collection<Mazzetta> mazzettaColl =
     * mazzettaJc.findMazzettaNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(mazzettaColl);
     *
     * log.info("############ NUMERO MAZZETTE : " + mazzettaColl.size());
     *
     * //Recupero i nuovi dati della tab mazzetta_colorata e li aggiungo alla
     * collection DaInserire Collection<MazzettaColorata> mazzettaColorataColl =
     * mazzettaColorataJc.findMazzettaColorataNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(mazzettaColorataColl);
     *
     * log.info("############ NUMERO MAZZETTE COLORATE : " +
     * mazzettaColorataColl.size());
     *
     * //Recupero i nuovi dati della tab categoria e li aggiungo alla
     * collection DaInserire Collection<Categoria> categoriaColl =
     * categoriaJc.findCategoriaNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(categoriaColl);
     *
     * log.info("############ NUMERO CATEGORIE : " + categoriaColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_comp_prod e li aggiungo alla
     * collection DaInserire Collection<ParametroCompProd> parametroCompProdColl
     * =
     * parametroCompProdJc.findParametroCompProdNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroCompProdColl);
     *
     * log.info("############ NUMERO PARAMETRI COMP PROD : " +
     * parametroCompProdColl.size());
     *
     * //Seleziono i prodotti con data nuova dalla tabella anagrafe_prodotto
     * //e li aggiungo all'aggiornamento solo se i prodotti sono fra quelli
     * assegnati alla macchina Collection<AnagrafeProdotto> anagrafeProdottoColl
     * =
     * anagrafeProdottoJc.findAnagrafeProdottoNew(machineCredentials.getLastUpdateDate());
     * int n = 0; int comp = 0;
     *
     * int pesatura = 0; for (Object obj : anagrafeProdottoColl) {
     * AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj; if
     * (prodottiAssegnatiColl.contains(anagrafeProdotto.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(anagrafeProdotto); //Aggiungo
     * all'agg tutti i componenti del prodotto anche se non sono stati
     * modificati //Ogni volta che mando un prodotto nuovo (magari perchè è
     * stato assegnato ad una nuova mac) mando sempre tutti i suoi componenti
     * Collection<ComponenteProdotto> componenteProdottoColl =
     * componenteProdottoJc.findComponenteProdottoIdProd(anagrafeProdotto.getIdProdotto());
     * for (Object compProd : componenteProdottoColl) { ComponenteProdotto
     * componenteProdotto = (ComponenteProdotto) compProd;
     * aggiornamentoOut.getDaInserire().add(componenteProdotto); comp++; } n++;
     * //Modifica del 24/agosto/2017 //Aggiungo all'agg tutti i dati della
     * pesatura del prodotto anche se non sono stati modificati //Ogni volta che
     * mando un prodotto nuovo (magari perchè è stato assegnato ad una nuova
     * mac) mando sempre tutti i dati sulla pasatura
     * Collection<ComponentePesatura> componentePesaturaColl =
     * componentePesaturaJc.findComponentePesaturaIdProd(anagrafeProdotto.getIdProdotto());
     * for (Object compPes : componentePesaturaColl) { ComponentePesatura
     * componentePesatura = (ComponentePesatura) compPes;
     * aggiornamentoOut.getDaInserire().add(componentePesatura); pesatura++; }
     * //################################################################
     *
     * }
     * }
     * log.info("############ NUMERO ANAGRAFE PRODOTTO : " + n);
     * log.info("############ NUMERO COMPONENTI NEI PRODOTTI NUOVI : " + comp);
     * log.info("############ NUMERO DATI PESATURA COMP : " + pesatura);
     *
     * //Seleziono i componenti dei prodotti dalla tabella componente_prodotto
     * //e aggiungo all'aggiornamento solo se i prodotti sono fra quelli
     * assegnati alla macchina Collection<ComponenteProdotto>
     * componenteProdottoColl =
     * componenteProdottoJc.findComponenteProdottoNew(machineCredentials.getLastUpdateDate());
     * int m = 0; for (Object obj : componenteProdottoColl) { ComponenteProdotto
     * componenteProdotto = (ComponenteProdotto) obj; if
     * (prodottiAssegnatiColl.contains(componenteProdotto.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(componenteProdotto); m++; } }
     * log.info("############ NUMERO COMPONENTE PRODOTTO : " + m);
     *
     * //Modifica del ottobre/2017 ###########################################
     * //Seleziono i dati di pesatura dei componenti dalla tabella
     * componente_pesatura //e aggiungo all'aggiornamento solo se i prodotti
     * sono fra quelli assegnati alla macchina Collection<ComponentePesatura>
     * componentePesaturaColl =
     * componentePesaturaJc.findComponentePesaturaNew(machineCredentials.getLastUpdateDate());
     * int mp = 0; for (Object obj : componentePesaturaColl) {
     * ComponentePesatura componentePesatura = (ComponentePesatura) obj; if
     * (prodottiAssegnatiColl.contains(componentePesatura.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(componentePesatura); mp++; } }
     * log.info("############ NUMERO COMPONENTE PESATURA : " + mp);
     *
     * //Recupero i nuovi dati della tab allarme e li aggiungo alla collection
     * DaInserire Collection<Allarme> allarmeColl =
     * allarmeJc.findAllarmeNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(allarmeColl);
     * log.info("############ NUMERO ALLARMI : " + allarmeColl.size());
     *
     * //Inserire in parametri globali 139 Integer idParOrigineMov = 139;
     * String strParOrigineMov = ""; strParOrigineMov =
     * parametroGlobMacJc.findParametroGlobMac(idParOrigineMov).getValoreVariabile();
     *
     * //Recupero i nuovi dati della tabella movimento_sing_mac e li aggiungo
     * alla collection DaInserire Collection<MovimentoSingMac>
     * movimentoSingMacColl =
     * movimentoSingMacJc.findMovimentoSingMacNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina(), strParOrigineMov);
     * aggiornamentoOut.getDaInserire().addAll(movimentoSingMacColl);
     * log.info("############ NUMERO MOVIMENTI SING MAC: " +
     * movimentoSingMacColl.size());
     *
     * //Recupero i nuovi dati della tabella ordine_sing_mac e li aggiungo alla
     * collection DaInserire Collection<OrdineSingMac> ordineSingMacColl =
     * ordineSingMacJc.findOrdineSingMacNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(ordineSingMacColl);
     * log.info("############ NUMERO ORDINE SING MAC : " +
     * ordineSingMacColl.size());
     *
     * //Recupero i nuovi dati della tabella valore_par_ordine e li aggiungo
     * alla collection DaInserire Collection<ValoreParOrdine>
     * valoreParOrdineColl =
     * valoreParOrdineJc.findValoreParOrdineNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(valoreParOrdineColl);
     * log.info("############ NUMERO VALORE PAR ORDINE : " +
     * valoreParOrdineColl.size());
     *
     * //Recupero i nuovi dati della tabella figura_tipo e li aggiungo alla
     * collection DaInserire Collection<FiguraTipo> figuraTipoColl =
     * figuraTipoJc.findFiguraTipoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(figuraTipoColl);
     * log.info("############ NUMERO FIGURA TIPO: " + figuraTipoColl.size());
     *
     * //Recupero i nuovi dati della tabella figura e li aggiungo alla
     * collection DaInserire Collection<Figura> figuraColl =
     * figuraJc.findFiguraNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(figuraColl);
     * log.info("############ NUMERO FIGURA : " + figuraColl.size());
     *
     * //Recupero i nuovi dati della tab presa e li aggiungo alla collection
     * DaInserire Collection<Presa> presaColl =
     * presaJc.findPresaNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(presaColl);
     * log.info("############ NUMERO PRESE : " + presaColl.size());
     *
     * //Recupero i nuovi dati della tab dizionario e li aggiungo alla
     * collection DaInserire Collection<Dizionario> dizionarioColl =
     * dizionarioJc.findDizionarioNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(dizionarioColl);
     * log.info("############ NUMERO DIZIONARIO : " + dizionarioColl.size());
     *
     * //Recupero i nuovi dati della tab chimica, bolla, lotto e li aggiungo
     * alla collection DaInserire Collection<Chimica> chimicaColl =
     * chimicaJc.findChimicaNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(chimicaColl);
     * log.info("############ NUMERO CHIMICHE : " + chimicaColl.size());
     *
     * //Recupero i nuovi dati della tab num_sacchetto e li aggiungo alla
     * collection DaInserire Collection<NumSacchetto> numSacchettoColl =
     * numSacchettoJc.findNumSacchettoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(numSacchettoColl);
     * log.info("############ NUMERO SACCHETTO : " + numSacchettoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_glob_mac e li aggiungo alla
     * collection DaInserire Collection<ParametroGlobMac> parametroGlobMacColl =
     * parametroGlobMacJc.findParametroGlobMacNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroGlobMacColl);
     * log.info("############ NUMERO PARAMETRO GLOBALE MAC : " +
     * parametroGlobMacColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_prodotto e li aggiungo alla
     * collection DaInserire Collection<ParametroProdotto> parametroProdottoColl
     * =
     * parametroProdottoJc.findParametroProdottoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroProdottoColl);
     * log.info("############ NUMERO PARAMETRO PRODOTTO : " +
     * parametroProdottoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_ripristino e li aggiungo
     * alla collection DaInserire Collection<ParametroRipristino>
     * parametroRipristinoColl =
     * parametroRipristinoJc.findParametroRipristinoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroRipristinoColl);
     * log.info("############ NUMERO PARAMETRO RIPRISTINO : " +
     * parametroRipristinoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_sacchetto e li aggiungo alla
     * collection DaInserire Collection<ParametroSacchetto>
     * parametroSacchettoColl =
     * parametroSacchettoJc.findParametroSacchettoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroSacchettoColl);
     * log.info("############ NUMERO PARAMETRO SACCHETTO : " +
     * parametroSacchettoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_sing_mac e li aggiungo alla
     * collection DaInserire Collection<ParametroSingMac> parametroSingMacColl =
     * parametroSingMacJc.findParametroSingMacNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroSingMacColl);
     * log.info("############ NUMERO PARAMETRO SINGOLA MAC : " +
     * parametroSingMacColl.size());
     *
     * //Recupero i nuovi dati della tab valore_par_prod e li aggiungo alla
     * collection DaInserire Collection<ValoreParProd> valoreParProdColl =
     * valoreParProdJc.findValoreParProdNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(valoreParProdColl);
     * log.info("############ NUMERO VALORE PAR PROD : " +
     * valoreParProdColl.size());
     *
     * //Recupero i nuovi dati della tab valore_par_sacchetto e li aggiungo
     * alla collection DaInserire Collection<ValoreParSacchetto>
     * valoreParSacchettoColl =
     * valoreParSacchettoJc.findValoreParSacchettoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(valoreParSacchettoColl);
     * log.info("############ NUMERO VALORE PAR SACCHETTO : " +
     * valoreParSacchettoColl.size());
     *
     * //Recupero i nuovi dati della tab valore_ripristino e li aggiungo alla
     * collection DaInserire Collection<ValoreRipristino> valoreRipristinoColl =
     * valoreRipristinoJc.findValoreRipristinoNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(valoreRipristinoColl);
     * log.info("############ NUMERO VALORE RIPRISTINO : " +
     * valoreRipristinoColl.size());
     *
     * //Recupero i nuovi dati della tab valore_par_sing_mac e li aggiungo alla
     * collection DaInserire Collection<ValoreParSingMac> valoreParSingMacColl =
     * valoreParSingMacJc.findValoreParSingMacNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(valoreParSingMacColl);
     * log.info("############ NUMERO VALORE PAR SING MAC : " +
     * valoreParSingMacColl.size());
     *
     * //Seleziono i valori dei parametri dei componenti dalla tabella
     * valore_par_comp //e aggiungo all'aggiornamento solo se i componenti sono
     * fra quelli assegnati alla macchina Collection<ValoreParComp>
     * valoreParCompColl =
     * valoreParCompJc.findValoreParCompNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina()); int v = 0; for (Object obj :
     * valoreParCompColl) { ValoreParComp valoreParComp = (ValoreParComp) obj;
     * if (componentiAssegnatiColl.contains(valoreParComp.getIdComp())) {
     * aggiornamentoOut.getDaInserire().add(valoreParComp); v++; } }
     * log.info("############ NUMERO VALORE PAR COMP : " + v);
     *
     * //######################################################################
     * //######## NUOVE TABELLE VALORI PARAMETRI PRODOTTO #####################
     * //######################################################################
     * //################## GESTIONE DELLA VERSIONE ###########################
     * // Parametri per la gestione delle versioni del software //Il valore del
     * campo valore_mac della tabella valore_par_sing_mac con id_par_sm=27
     * indica la versione di origamidb Integer idParVersioneDb = 27; //Il valore
     * del campo valore_mac della tabella valore_par_sing_mac con id_par_sm=221
     * indica la versione del programma CloudFab Integer idParVersioneSftw =
     * 211; //Valore del campo user_origami della tabella macchina //se
     * user_origami=2 vuol dire che ancora non è mai stato inviato un
     * aggiornamento //contenente i nuovi dati delle tabelle valore_prodotto,
     * valore_par_prod_mac String valorePrimoAgg = macchina.getUserOrigami();
     *
     * ParametroSingMac parVersioneDb = new ParametroSingMac(idParVersioneDb);
     * ParametroSingMac parVersioneSftw = new
     * ParametroSingMac(idParVersioneSftw);
     *
     * String versioneDb = "2"; String stringVersioneSftw = "CloudFab2"; String
     * versioneSftw = "2";
     *
     * versioneDb =
     * valoreParSingMacJc.findValoreByMacchinaIdPar(macchina.getIdMacchina(),
     * parVersioneDb).getValoreMac(); stringVersioneSftw =
     * valoreParSingMacJc.findValoreByMacchinaIdPar(macchina.getIdMacchina(),
     * parVersioneSftw).getValoreMac();
     *
     * if (stringVersioneSftw != null && !stringVersioneSftw.isEmpty()) {
     * versioneSftw = stringVersioneSftw.substring(8, 9); }
     *
     * //######################################################################
     * // Se il campo valore_mac relativo ai valori dei parametri singola
     * macchina 27 e 211 che //indicano la versione rispettivamente del db e del
     * software a bordo macchina //sono uguali a 3 allora si possono includere
     * nell'aggiornamento i dati relativi alle nuove tabelle //dei parametri
     * prodotto log.info("USER-ORIGAMI: " + macchina.getUserOrigami());
     * log.info("VERSIONE DB: " + versioneDb); log.info("VERSIONE CloudFab: " +
     * versioneSftw);
     *
     * //Per le Macchine nuove si verifica il valore del campo pass_origami e
     * si genera direttamente l'aggiornamento completo //Per le Macchine che
     * devono passare dal vecchio software al nuovo si verificano 3 valori // -
     * versioneDb, // - versioneSoftw, // - userOrigami if
     * (versioneDb.equals("3") & versioneSftw.equals("3") ||
     * macchina.getPassOrigami().equals("3")) {
     *
     * Date dataUltAgg = null; dataUltAgg =
     * machineCredentials.getLastUpdateDate();
     *
     * //Se il campo user_origami della macchina non ha ancora valore 3 vuol
     * //dire che è la prima volta che vengono inviati i dati nuovi e quindi si
     * imposta la data al 1970 //e vengono inviati tutti i parametri if
     * (!macchina.getUserOrigami().equals("3")) { //Si imposta la data
     * dell'ultimo agg al 1970 e si mandano tutti i valori dei parametri nuovi
     * dataUltAgg = SyncOrigamiConstants.DATA_DEFAULT;
     *
     * log.info("Data ultimo agg impostata a : " + dataUltAgg); //Bisogna
     * aggiornare il campo user_origami nella tab macchina di serverdb e
     * impostarlo =3 macchina.setUserOrigami("3"); macchinaJc.merge(macchina);
     *
     * log.info("Modificato campo user_origami tab macchina di serverdb");
     *
     * }
     *
     * //Recupero i nuovi dati della tab parametro_prod e li aggiungo alla
     * collection DaInserire ???servono??? Collection<ParametroProd>
     * parametroProdColl = parametroProdJc.findParametroProdNew(dataUltAgg);
     * aggiornamentoOut.getDaInserire().addAll(parametroProdColl);
     *
     * //Recupero i nuovi dati della tab parametro_prod_mac e li aggiungo alla
     * collection DaInserire ???servono??? Collection<ParametroProdMac>
     * parametroProdMacColl =
     * parametroProdMacJc.findParametroProdMacNew(dataUltAgg);
     * aggiornamentoOut.getDaInserire().addAll(parametroProdMacColl);
     *
     * log.info("############ NUMERO PARAMETRI PROD MAC : " +
     * parametroProdMacColl.size());
     *
     * //Recupero i nuovi dati della tab valore_prodotto e li aggiungo alla
     * collection DaInserire //solo se si riferiscono ad uno dei prodotti
     * assegnati alla macchina Collection<ValoreProdotto> valoreProdottoColl =
     * valoreProdottoJc.findValoreProdottoNew(dataUltAgg); int y = 0; for
     * (Object obj : valoreProdottoColl) { ValoreProdotto valoreProdotto =
     * (ValoreProdotto) obj; if
     * (prodottiAssegnatiColl.contains(valoreProdotto.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(valoreProdotto); y++; } }
     * log.info("############ NUMERO VALORI PRODOTTO : " + y);
     *
     * //Recupero i nuovi dati della tab valore_par_prod_mac e li aggiungo alla
     * collection DaInserire //solo se si riferiscono ad uno dei prodotti
     * assegnati alla macchina Collection<ValoreParProdMac> valoreParProdMacColl
     * = valoreParProdMacJc.findValoreParProdMacNew(dataUltAgg,
     * macchina.getIdMacchina()); int r = 0; for (Object obj :
     * valoreParProdMacColl) { ValoreParProdMac ValoreParProdMac =
     * (ValoreParProdMac) obj; if
     * (prodottiAssegnatiColl.contains(ValoreParProdMac.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(ValoreParProdMac); r++; } }
     * log.info("############ NUMERO VALORI PAR PROD MAC : " + r);
     *
     * }//end dati relativi a nuovi parametri
     *
     * //######################################################################
     * //####################### FINE PARAMETRI NUOVI #########################
     * //######################################################################
     * log.info("############ NUMERO TOT COLLECTION DA INSERIRE : " +
     * aggiornamentoOut.getDaInserire().size());
     *
     * log.info("MACCHINA CON ID_MACCHINA : " +
     * machineCredentials.getIdMacchina()); log.info("DATA DI COSTRUZIONE DELL'
     * ULTIMO AGGIORNAMENTO : " + machineCredentials.getLastUpdateDate());
     * log.info("ULTIMA VERSIONE AGGIORNAMENTO : " +
     * machineCredentials.getLastUpdateVersion());
     *
     * //Setto alcuni campi dell'oggetto aggiornamento //Calcolo la versione
     * dell'aggiornamento corrente aggiornamentoOut.setIdMacchina(macchina);
     * aggiornamentoOut.setTipo(outFilePfx);
     * aggiornamentoOut.setDtAggiornamento(new Date());
     *
     * aggiornamentoOut.setVersione(machineCredentials.getLastUpdateVersion() +
     * 1);
     *
     * return aggiornamentoOut;
     *
     * }
     */
    /**
     * Metodo che salva l'oggetto Aggiornamento nella tabella aggiornamento di
     * serverdb
     *
     * @param aggiornamento public static Aggiornamento
     * costruisciAggiornamentoKerneos(MachineCredentials machineCredentials,
     * EntityManagerFactory emf, String outFilePfx) throws
     * NonexistentEntityException, Exception {
     *
     * Aggiornamento aggiornamentoOut = new Aggiornamento();
     * aggiornamentoOut.setDaInserire(new ArrayList());
     *
     * AggiornamentoJpaController aggiornamentoJc = new
     * AggiornamentoJpaController(null, emf); AggiornamentoConfigJpaController
     * aggiornamentoConfigJc = new AggiornamentoConfigJpaController(null, emf);
     * MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
     * ProdottoJpaController prodottoJc = new ProdottoJpaController(null, emf);
     * AnagrafeProdottoJpaController anagrafeProdottoJc = new
     * AnagrafeProdottoJpaController(null, emf); CategoriaJpaController
     * categoriaJc = new CategoriaJpaController(null, emf); ChimicaJpaController
     * chimicaJc = new ChimicaJpaController(null, emf); ColoreJpaController
     * coloreJc = new ColoreJpaController(null, emf); ColoreBaseJpaController
     * coloreBaseJc = new ColoreBaseJpaController(null, emf);
     * ComponenteJpaController componenteJc = new ComponenteJpaController(null,
     * emf); ComponenteProdottoJpaController componenteProdottoJc = new
     * ComponenteProdottoJpaController(null, emf);
     * ParametroCompProdJpaController parametroCompProdJc = new
     * ParametroCompProdJpaController(null, emf); DizionarioJpaController
     * dizionarioJc = new DizionarioJpaController(null, emf); PresaJpaController
     * presaJc = new PresaJpaController(null, emf); MazzettaJpaController
     * mazzettaJc = new MazzettaJpaController(null, emf);
     * MazzettaColorataJpaController mazzettaColorataJc = new
     * MazzettaColorataJpaController(null, emf); NumSacchettoJpaController
     * numSacchettoJc = new NumSacchettoJpaController(null, emf);
     * ParametroGlobMacJpaController parametroGlobMacJc = new
     * ParametroGlobMacJpaController(null, emf); ParametroProdottoJpaController
     * parametroProdottoJc = new ParametroProdottoJpaController(null, emf);
     * ParametroRipristinoJpaController parametroRipristinoJc = new
     * ParametroRipristinoJpaController(null, emf);
     * ParametroSacchettoJpaController parametroSacchettoJc = new
     * ParametroSacchettoJpaController(null, emf); ParametroSingMacJpaController
     * parametroSingMacJc = new ParametroSingMacJpaController(null, emf);
     * ValoreParProdJpaController valoreParProdJc = new
     * ValoreParProdJpaController(null, emf); ValoreParSacchettoJpaController
     * valoreParSacchettoJc = new ValoreParSacchettoJpaController(null, emf);
     * ValoreRipristinoJpaController valoreRipristinoJc = new
     * ValoreRipristinoJpaController(null, emf); ValoreParSingMacJpaController
     * valoreParSingMacJc = new ValoreParSingMacJpaController(null, emf);
     * ValoreParCompJpaController valoreParCompJc = new
     * ValoreParCompJpaController(null, emf); ParametroProdJpaController
     * parametroProdJc = new ParametroProdJpaController(null, emf);
     * ParametroProdMacJpaController parametroProdMacJc = new
     * ParametroProdMacJpaController(null, emf); ValoreProdottoJpaController
     * valoreProdottoJc = new ValoreProdottoJpaController(null, emf);
     * ValoreParProdMacJpaController valoreParProdMacJc = new
     * ValoreParProdMacJpaController(null, emf);
     *
     * //######## Modifiche 24 agosto 2017 NUOVE TABELLE
     * OrdineSingMacJpaController ordineSingMacJc = new
     * OrdineSingMacJpaController(null, emf); ValoreParOrdineJpaController
     * valoreParOrdineJc = new ValoreParOrdineJpaController(null, emf);
     *
     * AllarmeJpaController allarmeJc = new AllarmeJpaController(null, emf);
     *
     * FiguraJpaController figuraJc = new FiguraJpaController(null, emf);
     *
     * FiguraTipoJpaController figuraTipoJc = new FiguraTipoJpaController(null,
     * emf);
     *
     * MovimentoSingMacJpaController movimentoSingMacJc = new
     * MovimentoSingMacJpaController(null, emf);
     *
     * ComponentePesaturaJpaController componentePesaturaJc = new
     * ComponentePesaturaJpaController(null, emf);
     *
     * //Prendo l'entità macchina con id_macchina che intendo aggiornare
     * Macchina macchina =
     * macchinaJc.findMacchina(machineCredentials.getIdMacchina());
     *
     * //Recupero i nuovi dati della tab macchina e li inserisco nella
     * collection DaInserire //solo se il campo dtAbilitato è > della data
     * dell'ultimo aggiornamento Macchina macchinaNew =
     * macchinaJc.findMacchina(macchina.getIdMacchina()); if
     * (macchinaNew.getDtAbilitato().compareTo(machineCredentials.getLastUpdateDate())
     * > 0) { aggiornamentoOut.getDaInserire().add(macchinaNew);
     * log.info("############ DATI ANAGRAFICI MODIFICATI PER MACCHINA (tabella
     * macchina)!!!"); } else {
     *
     * log.info("############ DATI ANAGRAFICI NON MODIFICATI PER MACCHINA
     * (tabella macchina)!!!"); }
     *
     * //Elenco dei prodotti assegnati alla macchina indipendentemente da
     * modifiche fatte sui dati Collection<Prodotto> prodottiAssegnatiColl =
     * prodottoJc.findProdottiAssegnati(macchina); log.info("############ NUMERO
     * PRODOTTI ASSEGNATI IN TUTTO : " + prodottiAssegnatiColl.size());
     *
     * //Elenco dei componenti assegnati alla macchina indipendentemente da
     * modifiche fatte sui dati Collection<Componente> componentiAssegnatiColl =
     * componenteJc.findComponentiAssegnati(macchina); log.info("############
     * NUMERO COMPONENTI ASSEGNATI IN TUTTO : " +
     * componentiAssegnatiColl.size());
     *
     * //Recupero i nuovi dati della tab aggiornamento_config e li aggiungo
     * alla collection DaInserire Collection<AggiornamentoConfig>
     * aggiornamentoConfigColl =
     * aggiornamentoConfigJc.findAggiornamentoConfigNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(aggiornamentoConfigColl);
     * log.info("############ NUMERO PARAMETRI AGGIORNAMENTO CONFIG : " +
     * aggiornamentoConfigColl.size());
     *
     * //Recupero i nuovi dati della tab colore e li aggiungo alla collection
     * DaInserire Collection<Colore> coloreColl =
     * coloreJc.findColoreNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(coloreColl);
     *
     * log.info("############ NUMERO COLORI : " + coloreColl.size());
     *
     * //Recupero i nuovi dati della tab colore_base e li aggiungo alla
     * collection DaInserire Collection<ColoreBase> coloreBaseColl =
     * coloreBaseJc.findColoreBaseNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(coloreBaseColl);
     *
     * log.info("############ NUMERO COLORI BASE : " + coloreBaseColl.size());
     *
     * //Seleziono i componenti dalla tabella componente verificando le date
     * nelle tabelle componente, componente_prodotto, anagrafe_prodotto //e
     * aggiungo all'aggiornamento solo se i componenti sono fra quelli assegnati
     * alla macchina Collection<Componente> componenteColl =
     * componenteJc.findComponenteNew(machineCredentials.getLastUpdateDate());
     * int k = 0; for (Object obj : componenteColl) { Componente componente =
     * (Componente) obj; if (componentiAssegnatiColl.contains(componente)) {
     * aggiornamentoOut.getDaInserire().add(componente); k++; } }
     *
     * log.info("############ NUMERO COMPONENTI : " + k);
     *
     * //Recupero i nuovi dati della tab mazzetta e li aggiungo alla collection
     * DaInserire Collection<Mazzetta> mazzettaColl =
     * mazzettaJc.findMazzettaNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(mazzettaColl);
     *
     * log.info("############ NUMERO MAZZETTE : " + mazzettaColl.size());
     *
     * //Recupero i nuovi dati della tab mazzetta_colorata e li aggiungo alla
     * collection DaInserire Collection<MazzettaColorata> mazzettaColorataColl =
     * mazzettaColorataJc.findMazzettaColorataNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(mazzettaColorataColl);
     *
     * log.info("############ NUMERO MAZZETTE COLORATE : " +
     * mazzettaColorataColl.size());
     *
     * //Recupero i nuovi dati della tab categoria e li aggiungo alla
     * collection DaInserire Collection<Categoria> categoriaColl =
     * categoriaJc.findCategoriaNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(categoriaColl);
     *
     * log.info("############ NUMERO CATEGORIE : " + categoriaColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_comp_prod e li aggiungo alla
     * collection DaInserire Collection<ParametroCompProd> parametroCompProdColl
     * =
     * parametroCompProdJc.findParametroCompProdNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroCompProdColl);
     *
     * log.info("############ NUMERO PARAMETRI COMP PROD : " +
     * parametroCompProdColl.size());
     *
     * //Seleziono i prodotti con data nuova dalla tabella anagrafe_prodotto
     * //e li aggiungo all'aggiornamento solo se i prodotti sono fra quelli
     * assegnati alla macchina Collection<AnagrafeProdotto> anagrafeProdottoColl
     * =
     * anagrafeProdottoJc.findAnagrafeProdottoNew(machineCredentials.getLastUpdateDate());
     * int n = 0; int comp = 0;
     *
     * int pesatura = 0; for (Object obj : anagrafeProdottoColl) {
     * AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj; if
     * (prodottiAssegnatiColl.contains(anagrafeProdotto.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(anagrafeProdotto); //Aggiungo
     * all'agg tutti i componenti del prodotto anche se non sono stati
     * modificati //Ogni volta che mando un prodotto nuovo (magari perchè è
     * stato assegnato ad una nuova mac) mando sempre tutti i suoi componenti
     * Collection<ComponenteProdotto> componenteProdottoColl =
     * componenteProdottoJc.findComponenteProdottoIdProd(anagrafeProdotto.getIdProdotto());
     * for (Object compProd : componenteProdottoColl) { ComponenteProdotto
     * componenteProdotto = (ComponenteProdotto) compProd;
     * aggiornamentoOut.getDaInserire().add(componenteProdotto); comp++; } n++;
     * //Modifica del 24/agosto/2017 //Aggiungo all'agg tutti i dati della
     * pesatura del prodotto anche se non sono stati modificati //Ogni volta che
     * mando un prodotto nuovo (magari perchè è stato assegnato ad una nuova
     * mac) mando sempre tutti i dati sulla pasatura
     * Collection<ComponentePesatura> componentePesaturaColl =
     * componentePesaturaJc.findComponentePesaturaIdProd(anagrafeProdotto.getIdProdotto());
     * for (Object compPes : componentePesaturaColl) { ComponentePesatura
     * componentePesatura = (ComponentePesatura) compPes;
     * aggiornamentoOut.getDaInserire().add(componentePesatura); pesatura++; }
     * //################################################################
     *
     * }
     * }
     * log.info("############ NUMERO ANAGRAFE PRODOTTO : " + n);
     * log.info("############ NUMERO COMPONENTI NEI PRODOTTI NUOVI : " + comp);
     * log.info("############ NUMERO DATI PESATURA COMP : " + pesatura);
     *
     * //Seleziono i componenti dei prodotti dalla tabella componente_prodotto
     * //e aggiungo all'aggiornamento solo se i prodotti sono fra quelli
     * assegnati alla macchina Collection<ComponenteProdotto>
     * componenteProdottoColl =
     * componenteProdottoJc.findComponenteProdottoNew(machineCredentials.getLastUpdateDate());
     * int m = 0; for (Object obj : componenteProdottoColl) { ComponenteProdotto
     * componenteProdotto = (ComponenteProdotto) obj; if
     * (prodottiAssegnatiColl.contains(componenteProdotto.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(componenteProdotto); m++; } }
     * log.info("############ NUMERO COMPONENTE PRODOTTO : " + m);
     *
     * //Modifica del ottobre/2017 ###########################################
     * //Seleziono i dati di pesatura dei componenti dalla tabella
     * componente_pesatura //e aggiungo all'aggiornamento solo se i prodotti
     * sono fra quelli assegnati alla macchina Collection<ComponentePesatura>
     * componentePesaturaColl =
     * componentePesaturaJc.findComponentePesaturaNew(machineCredentials.getLastUpdateDate());
     * int mp = 0; for (Object obj : componentePesaturaColl) {
     * ComponentePesatura componentePesatura = (ComponentePesatura) obj; if
     * (prodottiAssegnatiColl.contains(componentePesatura.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(componentePesatura); mp++; } }
     * log.info("############ NUMERO COMPONENTE PESATURA : " + mp);
     *
     * //Recupero i nuovi dati della tab allarme e li aggiungo alla collection
     * DaInserire Collection<Allarme> allarmeColl =
     * allarmeJc.findAllarmeNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(allarmeColl);
     * log.info("############ NUMERO ALLARMI : " + allarmeColl.size());
     *
     * //Inserire in parametri globali 139 Integer idParOrigineMov = 139;
     * String strParOrigineMov = ""; strParOrigineMov =
     * parametroGlobMacJc.findParametroGlobMac(idParOrigineMov).getValoreVariabile();
     *
     * //Recupero i nuovi dati della tabella movimento_sing_mac e li aggiungo
     * alla collection DaInserire Collection<MovimentoSingMac>
     * movimentoSingMacColl =
     * movimentoSingMacJc.findMovimentoSingMacNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina(), strParOrigineMov);
     * aggiornamentoOut.getDaInserire().addAll(movimentoSingMacColl);
     * log.info("############ NUMERO MOVIMENTI SING MAC: " +
     * movimentoSingMacColl.size());
     *
     * //Recupero i nuovi dati della tabella ordine_sing_mac e li aggiungo alla
     * collection DaInserire Collection<OrdineSingMac> ordineSingMacColl =
     * ordineSingMacJc.findOrdineSingMacNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(ordineSingMacColl);
     * log.info("############ NUMERO ORDINE SING MAC : " +
     * ordineSingMacColl.size());
     *
     * //Recupero i nuovi dati della tabella valore_par_ordine e li aggiungo
     * alla collection DaInserire Collection<ValoreParOrdine>
     * valoreParOrdineColl =
     * valoreParOrdineJc.findValoreParOrdineNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(valoreParOrdineColl);
     * log.info("############ NUMERO VALORE PAR ORDINE : " +
     * valoreParOrdineColl.size());
     *
     * //Recupero i nuovi dati della tabella figura_tipo e li aggiungo alla
     * collection DaInserire Collection<FiguraTipo> figuraTipoColl =
     * figuraTipoJc.findFiguraTipoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(figuraTipoColl);
     * log.info("############ NUMERO FIGURA TIPO: " + figuraTipoColl.size());
     *
     * //Recupero i nuovi dati della tabella figura e li aggiungo alla
     * collection DaInserire Collection<Figura> figuraColl =
     * figuraJc.findFiguraNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(figuraColl);
     * log.info("############ NUMERO FIGURA : " + figuraColl.size());
     *
     * //Recupero i nuovi dati della tab presa e li aggiungo alla collection
     * DaInserire Collection<Presa> presaColl =
     * presaJc.findPresaNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(presaColl);
     * log.info("############ NUMERO PRESE : " + presaColl.size());
     *
     * //Recupero i nuovi dati della tab dizionario e li aggiungo alla
     * collection DaInserire Collection<Dizionario> dizionarioColl =
     * dizionarioJc.findDizionarioNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(dizionarioColl);
     * log.info("############ NUMERO DIZIONARIO : " + dizionarioColl.size());
     *
     * //Recupero i nuovi dati della tab chimica, bolla, lotto e li aggiungo
     * alla collection DaInserire Collection<Chimica> chimicaColl =
     * chimicaJc.findChimicaNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(chimicaColl);
     * log.info("############ NUMERO CHIMICHE : " + chimicaColl.size());
     *
     * //Recupero i nuovi dati della tab num_sacchetto e li aggiungo alla
     * collection DaInserire Collection<NumSacchetto> numSacchettoColl =
     * numSacchettoJc.findNumSacchettoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(numSacchettoColl);
     * log.info("############ NUMERO SACCHETTO : " + numSacchettoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_glob_mac e li aggiungo alla
     * collection DaInserire Collection<ParametroGlobMac> parametroGlobMacColl =
     * parametroGlobMacJc.findParametroGlobMacNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroGlobMacColl);
     * log.info("############ NUMERO PARAMETRO GLOBALE MAC : " +
     * parametroGlobMacColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_prodotto e li aggiungo alla
     * collection DaInserire Collection<ParametroProdotto> parametroProdottoColl
     * =
     * parametroProdottoJc.findParametroProdottoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroProdottoColl);
     * log.info("############ NUMERO PARAMETRO PRODOTTO : " +
     * parametroProdottoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_ripristino e li aggiungo
     * alla collection DaInserire Collection<ParametroRipristino>
     * parametroRipristinoColl =
     * parametroRipristinoJc.findParametroRipristinoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroRipristinoColl);
     * log.info("############ NUMERO PARAMETRO RIPRISTINO : " +
     * parametroRipristinoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_sacchetto e li aggiungo alla
     * collection DaInserire Collection<ParametroSacchetto>
     * parametroSacchettoColl =
     * parametroSacchettoJc.findParametroSacchettoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroSacchettoColl);
     * log.info("############ NUMERO PARAMETRO SACCHETTO : " +
     * parametroSacchettoColl.size());
     *
     * //Recupero i nuovi dati della tab parametro_sing_mac e li aggiungo alla
     * collection DaInserire Collection<ParametroSingMac> parametroSingMacColl =
     * parametroSingMacJc.findParametroSingMacNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(parametroSingMacColl);
     * log.info("############ NUMERO PARAMETRO SINGOLA MAC : " +
     * parametroSingMacColl.size());
     *
     * //Recupero i nuovi dati della tab valore_par_prod e li aggiungo alla
     * collection DaInserire Collection<ValoreParProd> valoreParProdColl =
     * valoreParProdJc.findValoreParProdNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(valoreParProdColl);
     * log.info("############ NUMERO VALORE PAR PROD : " +
     * valoreParProdColl.size());
     *
     * //Recupero i nuovi dati della tab valore_par_sacchetto e li aggiungo
     * alla collection DaInserire Collection<ValoreParSacchetto>
     * valoreParSacchettoColl =
     * valoreParSacchettoJc.findValoreParSacchettoNew(machineCredentials.getLastUpdateDate());
     * aggiornamentoOut.getDaInserire().addAll(valoreParSacchettoColl);
     * log.info("############ NUMERO VALORE PAR SACCHETTO : " +
     * valoreParSacchettoColl.size());
     *
     * //Recupero i nuovi dati della tab valore_ripristino e li aggiungo alla
     * collection DaInserire Collection<ValoreRipristino> valoreRipristinoColl =
     * valoreRipristinoJc.findValoreRipristinoNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(valoreRipristinoColl);
     * log.info("############ NUMERO VALORE RIPRISTINO : " +
     * valoreRipristinoColl.size());
     *
     * //Recupero i nuovi dati della tab valore_par_sing_mac e li aggiungo alla
     * collection DaInserire Collection<ValoreParSingMac> valoreParSingMacColl =
     * valoreParSingMacJc.findValoreParSingMacNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina());
     * aggiornamentoOut.getDaInserire().addAll(valoreParSingMacColl);
     * log.info("############ NUMERO VALORE PAR SING MAC : " +
     * valoreParSingMacColl.size());
     *
     * //Seleziono i valori dei parametri dei componenti dalla tabella
     * valore_par_comp //e aggiungo all'aggiornamento solo se i componenti sono
     * fra quelli assegnati alla macchina Collection<ValoreParComp>
     * valoreParCompColl =
     * valoreParCompJc.findValoreParCompNew(machineCredentials.getLastUpdateDate(),
     * macchina.getIdMacchina()); int v = 0; for (Object obj :
     * valoreParCompColl) { ValoreParComp valoreParComp = (ValoreParComp) obj;
     * if (componentiAssegnatiColl.contains(valoreParComp.getIdComp())) {
     * aggiornamentoOut.getDaInserire().add(valoreParComp); v++; } }
     * log.info("############ NUMERO VALORE PAR COMP : " + v);
     *
     * //######################################################################
     * //######## NUOVE TABELLE VALORI PARAMETRI PRODOTTO #####################
     * //######################################################################
     * //################## GESTIONE DELLA VERSIONE ###########################
     * // Parametri per la gestione delle versioni del software //Il valore del
     * campo valore_mac della tabella valore_par_sing_mac con id_par_sm=27
     * indica la versione di origamidb Integer idParVersioneDb = 27; //Il valore
     * del campo valore_mac della tabella valore_par_sing_mac con id_par_sm=221
     * indica la versione del programma CloudFab Integer idParVersioneSftw =
     * 211; //Valore del campo user_origami della tabella macchina //se
     * user_origami=2 vuol dire che ancora non è mai stato inviato un
     * aggiornamento //contenente i nuovi dati delle tabelle valore_prodotto,
     * valore_par_prod_mac String valorePrimoAgg = macchina.getUserOrigami();
     *
     * ParametroSingMac parVersioneDb = new ParametroSingMac(idParVersioneDb);
     * ParametroSingMac parVersioneSftw = new
     * ParametroSingMac(idParVersioneSftw);
     *
     * String versioneDb = "2"; String stringVersioneSftw = "CloudFab2"; String
     * versioneSftw = "2";
     *
     * versioneDb =
     * valoreParSingMacJc.findValoreByMacchinaIdPar(macchina.getIdMacchina(),
     * parVersioneDb).getValoreMac(); stringVersioneSftw =
     * valoreParSingMacJc.findValoreByMacchinaIdPar(macchina.getIdMacchina(),
     * parVersioneSftw).getValoreMac();
     *
     * if (stringVersioneSftw != null && !stringVersioneSftw.isEmpty()) {
     * versioneSftw = stringVersioneSftw.substring(8, 9); }
     *
     * //######################################################################
     * // Se il campo valore_mac relativo ai valori dei parametri singola
     * macchina 27 e 211 che //indicano la versione rispettivamente del db e del
     * software a bordo macchina //sono uguali a 3 allora si possono includere
     * nell'aggiornamento i dati relativi alle nuove tabelle //dei parametri
     * prodotto log.info("USER-ORIGAMI: " + macchina.getUserOrigami());
     * log.info("VERSIONE DB: " + versioneDb); log.info("VERSIONE CloudFab: " +
     * versioneSftw);
     *
     * //Per le Macchine nuove si verifica il valore del campo pass_origami e
     * si genera direttamente l'aggiornamento completo //Per le Macchine che
     * devono passare dal vecchio software al nuovo si verificano 3 valori // -
     * versioneDb, // - versioneSoftw, // - userOrigami if
     * (versioneDb.equals("3") & versioneSftw.equals("3") ||
     * macchina.getPassOrigami().equals("3")) {
     *
     * Date dataUltAgg = null; dataUltAgg =
     * machineCredentials.getLastUpdateDate();
     *
     * //Se il campo user_origami della macchina non ha ancora valore 3 vuol
     * //dire che è la prima volta che vengono inviati i dati nuovi e quindi si
     * imposta la data al 1970 //e vengono inviati tutti i parametri if
     * (!macchina.getUserOrigami().equals("3")) { //Si imposta la data
     * dell'ultimo agg al 1970 e si mandano tutti i valori dei parametri nuovi
     * dataUltAgg = SyncOrigamiConstants.DATA_DEFAULT;
     *
     * log.info("Data ultimo agg impostata a : " + dataUltAgg); //Bisogna
     * aggiornare il campo user_origami nella tab macchina di serverdb e
     * impostarlo =3 macchina.setUserOrigami("3"); macchinaJc.merge(macchina);
     *
     * log.info("Modificato campo user_origami tab macchina di serverdb");
     *
     * }
     *
     * //Recupero i nuovi dati della tab parametro_prod e li aggiungo alla
     * collection DaInserire ???servono??? Collection<ParametroProd>
     * parametroProdColl = parametroProdJc.findParametroProdNew(dataUltAgg);
     * aggiornamentoOut.getDaInserire().addAll(parametroProdColl);
     *
     * //Recupero i nuovi dati della tab parametro_prod_mac e li aggiungo alla
     * collection DaInserire ???servono??? Collection<ParametroProdMac>
     * parametroProdMacColl =
     * parametroProdMacJc.findParametroProdMacNew(dataUltAgg);
     * aggiornamentoOut.getDaInserire().addAll(parametroProdMacColl);
     *
     * log.info("############ NUMERO PARAMETRI PROD MAC : " +
     * parametroProdMacColl.size());
     *
     * //Recupero i nuovi dati della tab valore_prodotto e li aggiungo alla
     * collection DaInserire //solo se si riferiscono ad uno dei prodotti
     * assegnati alla macchina Collection<ValoreProdotto> valoreProdottoColl =
     * valoreProdottoJc.findValoreProdottoNew(dataUltAgg); int y = 0; for
     * (Object obj : valoreProdottoColl) { ValoreProdotto valoreProdotto =
     * (ValoreProdotto) obj; if
     * (prodottiAssegnatiColl.contains(valoreProdotto.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(valoreProdotto); y++; } }
     * log.info("############ NUMERO VALORI PRODOTTO : " + y);
     *
     * //Recupero i nuovi dati della tab valore_par_prod_mac e li aggiungo alla
     * collection DaInserire //solo se si riferiscono ad uno dei prodotti
     * assegnati alla macchina Collection<ValoreParProdMac> valoreParProdMacColl
     * = valoreParProdMacJc.findValoreParProdMacNew(dataUltAgg,
     * macchina.getIdMacchina()); int r = 0; for (Object obj :
     * valoreParProdMacColl) { ValoreParProdMac ValoreParProdMac =
     * (ValoreParProdMac) obj; if
     * (prodottiAssegnatiColl.contains(ValoreParProdMac.getIdProdotto())) {
     * aggiornamentoOut.getDaInserire().add(ValoreParProdMac); r++; } }
     * log.info("############ NUMERO VALORI PAR PROD MAC : " + r);
     *
     * }//end dati relativi a nuovi parametri
     *
     * //######################################################################
     * //####################### FINE PARAMETRI NUOVI #########################
     * //######################################################################
     * log.info("############ NUMERO TOT COLLECTION DA INSERIRE : " +
     * aggiornamentoOut.getDaInserire().size());
     *
     * log.info("MACCHINA CON ID_MACCHINA : " +
     * machineCredentials.getIdMacchina()); log.info("DATA DI COSTRUZIONE DELL'
     * ULTIMO AGGIORNAMENTO : " + machineCredentials.getLastUpdateDate());
     * log.info("ULTIMA VERSIONE AGGIORNAMENTO : " +
     * machineCredentials.getLastUpdateVersion());
     *
     * //Setto alcuni campi dell'oggetto aggiornamento //Calcolo la versione
     * dell'aggiornamento corrente aggiornamentoOut.setIdMacchina(macchina);
     * aggiornamentoOut.setTipo(outFilePfx);
     * aggiornamentoOut.setDtAggiornamento(new Date());
     *
     * aggiornamentoOut.setVersione(machineCredentials.getLastUpdateVersion() +
     * 1);
     *
     * return aggiornamentoOut;
     *
     * }
     */
    /**
     * Metodo che salva l'oggetto Aggiornamento nella tabella aggiornamento di
     * serverdb
     *
     * @param aggiornamento
     */
    public static void salvaAggiornamentoOut(
            Aggiornamento aggiornamento,
            EntityManagerFactory emf,
            MachineCredentials mc) {

        AggiornamentoJpaController aggiornamentoJc = new AggiornamentoJpaController(null, emf);
        aggiornamento.setNomeFile(mc.getCurrentUpdateFileNameCompletePath());
        aggiornamentoJc.create(aggiornamento);

//        log.info("NUOVO AGGIORNAMENTO IN USCITA :" + aggiornamento.toString());
    }

//    /**
//     * Adatta l'aggiornamento al formato di uscita
//     *
//     * @param aggiornamento
//     * @return aggiornamentoOri
//     *
//     */
//    public static AggiornamentoOri adattaAggiornamentoOut(Aggiornamento aggiornamento, String InFilePfx, EntityManagerFactory emf) {
//
//        AggiornamentoOri aggiornamentoOriOut = new AggiornamentoOri();
//
//        //Il tipo dell'AggiornamentoOri deve essere IN quando arriva sulla macchina, 
//        //la versione coincide con quella dell'Aggiornamento
//        aggiornamentoOriOut.setTipo(InFilePfx);
//        aggiornamentoOriOut.setVersione(aggiornamento.getVersione());
//
//        AnagrafeProdottoJpaController anagrafeProdottoJc = new AnagrafeProdottoJpaController(null, emf);
//
//        //NOTA BENE: 
//        //nelle seguenti trasformazioni il campo dtAbilitato degli oggetti di tipo Ori non viene mai 
//        //copiato sulla macchina ma nelle tabelle di origamidb che hanno un flusso dati server-to-macchina contiene sempre 
//        //la data propria della macchina in formato timestamp gestita automaticamente in locale ad ogni insert o update
//        Collection c = new ArrayList();
//        aggiornamentoOriOut.setDaInserire(c);
//
//        //codice di trasformazione 
//        for (Object obj : aggiornamento.getDaInserire()) {
//
//            //Trasformazione di Macchina in MacchinaOri
//            if (obj instanceof Macchina) {
//
//                Macchina macchina = (Macchina) obj;
//                MacchinaOri macchinaOri = new MacchinaOri();
//
//                macchinaOri.setIdMacchina(macchina.getIdMacchina());
//                macchinaOri.setCodStab(macchina.getCodStab());
//                macchinaOri.setDescriStab(macchina.getDescriStab());
//                macchinaOri.setPassOrigami(macchina.getPassOrigami());
//                macchinaOri.setPassServer(macchina.getPassServer());
//                macchinaOri.setRagso1(macchina.getRagso1());
//                macchinaOri.setUserOrigami(macchina.getUserOrigami());
//                macchinaOri.setUserServer(macchina.getUserServer());
//                macchinaOri.setFtpPassword(macchina.getFtpPassword());
//                macchinaOri.setFtpUser(macchina.getFtpUser());
//                macchinaOri.setZipPassword(macchina.getZipPassword());
//                macchinaOri.setAbilitato(macchina.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(macchinaOri);
//            }
//
//            //Trasformazione di AggiornamentoConfig in AggiornamentoConfigOri
//            if (obj instanceof AggiornamentoConfig) {
//
//                AggiornamentoConfig aggiornamentoConfig = (AggiornamentoConfig) obj;
//                AggiornamentoConfigOri aggiornamentoConfigOri = new AggiornamentoConfigOri();
//
//                aggiornamentoConfigOri.setId(aggiornamentoConfig.getId());
//                aggiornamentoConfigOri.setParametro(aggiornamentoConfig.getParametro());
//                aggiornamentoConfigOri.setTipo(aggiornamentoConfig.getTipo());
//                aggiornamentoConfigOri.setDescrizione(aggiornamentoConfig.getDescrizione());
//                aggiornamentoConfigOri.setValore(aggiornamentoConfig.getValore());
//                aggiornamentoConfigOri.setAbilitato(aggiornamentoConfig.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(aggiornamentoConfigOri);
//            }
//
//            //Trasformazione di Chimica in ChimicaOri
//            if (obj instanceof Chimica) {
//                Chimica chimica = (Chimica) obj;
//                ChimicaOri chimicaOri = new ChimicaOri();
//
//                chimicaOri.setIdChimica(chimica.getIdChimica());
//                chimicaOri.setCodChimica(chimica.getCodChimica());
//                chimicaOri.setCodLotto(chimica.getCodLotto().getCodLotto());
//                chimicaOri.setDescriFormula(chimica.getDescriFormula());
//                chimicaOri.setNumBolla(chimica.getCodLotto().getIdBolla().getNumBolla());
//                chimicaOri.setDtBolla(chimica.getCodLotto().getIdBolla().getDtBolla());
//
//                chimicaOri.setStatoCh(Boolean.FALSE);
//                aggiornamentoOriOut.getDaInserire().add(chimicaOri);
//            }
//
//            //Trasformazione di Componente in ComponenteOri
//            if (obj instanceof Componente) {
//                Componente componente = (Componente) obj;
//                ComponenteOri componenteOri = new ComponenteOri();
//
//                componenteOri.setIdComp(componente.getIdComp());
//                componenteOri.setCodComponente(componente.getCodComponente());
//                componenteOri.setDescriComponente(componente.getDescriComponente());
//                componenteOri.setAbilitato(componente.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(componenteOri);
//            }
//
//            //Trasformazione di Colore in ColoreOri
//            if (obj instanceof Colore) {
//                Colore colore = (Colore) obj;
//                ColoreOri coloreOri = new ColoreOri();
//                coloreOri.setCodColore(colore.getCodColore());
//                coloreOri.setIdColore(colore.getIdColore());
//                coloreOri.setNomeColore(colore.getNomeColore());
//                coloreOri.setAbilitato(colore.getAbilitato());
//
//                //Modifica TEMPORANEA 12 APRILE 2013
//                //Il campo dtAbilitato non bisogna settarlo
//                coloreOri.setDtAbilitato(colore.getDtAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(coloreOri);
//            }
//
//            //Trasformazione di ColoreBase in ColoreBaseOri
//            if (obj instanceof ColoreBase) {
//                ColoreBase coloreBase = (ColoreBase) obj;
//                ColoreBaseOri coloreBaseOri = new ColoreBaseOri();
//                coloreBaseOri.setCodColoreBase(coloreBase.getCodColoreBase());
//                coloreBaseOri.setIdColoreBase(coloreBase.getIdColoreBase());
//                coloreBaseOri.setNomeColoreBase(coloreBase.getNomeColoreBase());
//                coloreBaseOri.setCostoColoreBase(coloreBase.getCostoColoreBase());
//                coloreBaseOri.setTollPerc(coloreBase.getTollPerc());
//                coloreBaseOri.setAbilitato(coloreBase.getAbilitato());
//                aggiornamentoOriOut.getDaInserire().add(coloreBaseOri);
//            }
//
//            //Trasformazione di Mazzetta in Mazzetta
//            if (obj instanceof Mazzetta) {
//                Mazzetta mazzetta = (Mazzetta) obj;
//                MazzettaOri mazzettaOri = new MazzettaOri();
//                mazzettaOri.setCodMazzetta(mazzetta.getCodMazzetta());
//                mazzettaOri.setIdMazzetta(mazzetta.getIdMazzetta());
//                mazzettaOri.setNomeMazzetta(mazzetta.getNomeMazzetta());
//                mazzettaOri.setAbilitato(mazzetta.getAbilitato());
//
//                //Modifica TEMPORANEA 12 APRILE 2013
//                //Il campo abilitato non bisogna settarlo
//                mazzettaOri.setDtAbilitato(mazzetta.getDtAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(mazzettaOri);
//            }
//
//            //Trasformazione di MazzettaColorata in MazzettaColorataOri
//            if (obj instanceof MazzettaColorata) {
//                MazzettaColorata mazzettaColorata = (MazzettaColorata) obj;
//                MazzettaColorataOri mazzettaColorataOri = new MazzettaColorataOri();
//
//                //Prendo l'oggetto Colore da MazzettaColorata e la trasformo in ColoreOri 
//                //per poterlo settare dentro MazzettaColorataOri
//                Colore colore = new Colore();
//                colore = mazzettaColorata.getIdColore();
//
//                ColoreOri coloreOri = new ColoreOri();
//                coloreOri.setIdColore(colore.getIdColore());
//                coloreOri.setCodColore(colore.getCodColore());
//                coloreOri.setNomeColore(colore.getNomeColore());
//                coloreOri.setAbilitato(colore.getAbilitato());
//                //Prendo l'oggetto ColoreBase da MazzettaColorata e lo trasformo in ColoreBaseOri 
//                //per poterlo settare dentro MazzettaColorataOri
//                ColoreBase coloreBase = new ColoreBase();
//                coloreBase = mazzettaColorata.getIdColoreBase();
//
//                ColoreBaseOri coloreBaseOri = new ColoreBaseOri();
//                coloreBaseOri.setIdColoreBase(coloreBase.getIdColoreBase());
//                coloreBaseOri.setCodColoreBase(coloreBase.getCodColoreBase());
//                coloreBaseOri.setNomeColoreBase(coloreBase.getNomeColoreBase());
//                coloreBaseOri.setCostoColoreBase(coloreBase.getCostoColoreBase());
//                coloreBaseOri.setAbilitato(coloreBase.getAbilitato());
//                //Prendo l'oggetto Mazzetta da MazzettaColorata e la trasformo in MazzettaOri 
//                //per poterlo settare dentro MazzettaColorataOri
//                Mazzetta mazzetta = new Mazzetta();
//                mazzetta = mazzettaColorata.getIdMazzetta();
//                MazzettaOri mazzettaOri = new MazzettaOri();
//                mazzettaOri.setIdMazzetta(mazzetta.getIdMazzetta());
//                mazzettaOri.setCodMazzetta(mazzetta.getCodMazzetta());
//                mazzettaOri.setNomeMazzetta(mazzetta.getNomeMazzetta());
//                mazzettaOri.setAbilitato(mazzetta.getAbilitato());
//
//                mazzettaColorataOri.setIdMazCol(mazzettaColorata.getIdMazCol());
//                mazzettaColorataOri.setIdColore(coloreOri);
//                mazzettaColorataOri.setIdColoreBase(coloreBaseOri);
//                mazzettaColorataOri.setIdMazzetta(mazzettaOri);
//                mazzettaColorataOri.setQuantita(mazzettaColorata.getQuantita());
//                mazzettaColorataOri.setAbilitato(mazzettaColorata.getAbilitato());
//
//                //Modifica TEMPORANEA 12 APRILE 2013
//                //Il campo dtAbilitato non bisogna settarlo
//                mazzettaColorataOri.setDtAbilitato(mazzettaColorata.getDtAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(mazzettaColorataOri);
//            }
//
//            //Trasformazione di Categoria in CategoriaOri
//            if (obj instanceof Categoria) {
//                Categoria categoria = (Categoria) obj;
//                CategoriaOri categoriaOri = new CategoriaOri();
//                categoriaOri.setIdCat(categoria.getIdCat());
//                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());
//                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
//                categoriaOri.setAbilitato(categoria.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(categoriaOri);
//            }
//
//            //Trasformazione di ParametroCompProd in ParametroCompProdOri
//            if (obj instanceof ParametroCompProd) {
//                ParametroCompProd parametroCompProd = (ParametroCompProd) obj;
//                ParametroCompProdOri parametroCompProdOri = new ParametroCompProdOri();
//
//                parametroCompProdOri.setIdParComp(parametroCompProd.getIdParComp());
//                parametroCompProdOri.setNomeVariabile(parametroCompProd.getNomeVariabile());
//                parametroCompProdOri.setDescriVariabile(parametroCompProd.getDescriVariabile());
//                parametroCompProdOri.setValoreBase(parametroCompProd.getValoreBase());
//                parametroCompProdOri.setAbilitato(parametroCompProd.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(parametroCompProdOri);
//            }
//
//            //Trasformazione di Prodotto,AnagrafeProdotto in ProdottoOri
//            //Aggiungere if (obj instanceof Prodotto)
//            if (obj instanceof AnagrafeProdotto) {
//                AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj;
//                ProdottoOri prodottoOri = new ProdottoOri();
//
//                prodottoOri.setIdProdotto(anagrafeProdotto.getIdProdotto().getIdProdotto());
//                prodottoOri.setCodProdotto(anagrafeProdotto.getIdProdotto().getCodProdotto());
//                prodottoOri.setNomeProdotto(anagrafeProdotto.getIdProdotto().getNomeProdotto());
//
//                prodottoOri.setColorato(anagrafeProdotto.getColorato());
//                prodottoOri.setIdCodice(anagrafeProdotto.getIdCodice().getIdCodice());
//                prodottoOri.setDescriFamiglia(anagrafeProdotto.getIdCodice().getDescrizione());
//                prodottoOri.setTipoFamiglia(anagrafeProdotto.getIdCodice().getTipoCodice());
//                prodottoOri.setFascia(anagrafeProdotto.getFascia());
//                prodottoOri.setFattoreDiv(anagrafeProdotto.getFattoreDiv());
//                prodottoOri.setLimColore(anagrafeProdotto.getLimColore());
//                prodottoOri.setAbilitato(anagrafeProdotto.getAbilitato());
//
//                //Prendo l'oggetto Categoria da anagrafeProdotto e la trasformo in CategoriaOri 
//                //per poterlo settare dentro ProdottoOri
//                Categoria categoria = anagrafeProdotto.getIdCat();
//                CategoriaOri categoriaOri = new CategoriaOri();
//                categoriaOri.setIdCat(categoria.getIdCat());
//                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());
//                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
//
//                prodottoOri.setIdCat(categoriaOri);
//
//                //Prendo l'oggetto Mazzetta da anagrafeProdotto e la trasformo in MazzettaOri 
//                //per poterlo settare dentro ProdottoOri     
//                Mazzetta mazzetta = anagrafeProdotto.getIdMazzetta();
//                MazzettaOri mazzettaOri = new MazzettaOri();
//
//                mazzettaOri.setIdMazzetta(mazzetta.getIdMazzetta());
//                mazzettaOri.setCodMazzetta(mazzetta.getCodMazzetta());
//                mazzettaOri.setNomeMazzetta(mazzetta.getNomeMazzetta());
//
//                prodottoOri.setIdMazzetta(mazzettaOri);
//
//                aggiornamentoOriOut.getDaInserire().add(prodottoOri);
//            }
//
//            //Trasformazione di ComponenteProdotto in ComponenteProdottoOri
//            if (obj instanceof ComponenteProdotto) {
//                ComponenteProdotto componenteProdotto = (ComponenteProdotto) obj;
//
//                //Prendo l'oggetto Componente da componenteProdotto e la trasformo in ComponenteOri 
//                //per poterlo settare dentro ComponenteProdottoOri  
//                //TODO: componente
//                Componente componente = componenteProdotto.getIdComp();
//                ComponenteOri componenteOri = new ComponenteOri();
//
//                componenteOri.setIdComp(componente.getIdComp());
//                componenteOri.setCodComponente(componente.getCodComponente());
//                componenteOri.setDescriComponente(componente.getDescriComponente());
//                componenteOri.setAbilitato(componente.getAbilitato());
//
//                //Prendo l'oggetto Prodotto da componenteProdotto e la trasformo in ProdottoOri 
//                //per poterlo settare dentro ComponenteProdottoOri  
//                Prodotto prodotto = componenteProdotto.getIdProdotto();
//                ProdottoOri prodottoOri = new ProdottoOri();
//                prodottoOri.setIdProdotto(prodotto.getIdProdotto());
//
//                ComponenteProdottoOri componenteProdottoOri = new ComponenteProdottoOri();
//                componenteProdottoOri.setIdCompProd(componenteProdotto.getIdCompProd());
//                componenteProdottoOri.setIdComp(componenteOri);
//                componenteProdottoOri.setIdProdotto(prodottoOri);
//                componenteProdottoOri.setQuantita(componenteProdotto.getQuantita());
//                componenteProdottoOri.setAbilitato(componenteProdotto.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(componenteProdottoOri);
//            }
//
//            //Trasformazione di Presa in PresaOri
//            if (obj instanceof Presa) {
//                Presa presa = (Presa) obj;
//                PresaOri presaOri = new PresaOri();
//                presaOri.setIdPresa(presa.getIdPresa());
//                presaOri.setPresa(presa.getPresa());
//                presaOri.setAbilitato(presa.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(presaOri);
//            }
//
//            //Trasformazione di Dizionario in DizionarioOri
//            if (obj instanceof Dizionario) {
//                Dizionario dizionario = (Dizionario) obj;
//
//                DizionarioOri dizionarioOri = new DizionarioOri();
//                dizionarioOri.setIdDizTipo(dizionario.getIdDizTipo().getIdDizTipo());
//                dizionarioOri.setIdDizionario(dizionario.getIdDizionario());
//                dizionarioOri.setIdLingua(dizionario.getIdLingua().getIdLingua());
//                dizionarioOri.setIdVocabolo(dizionario.getIdVocabolo());
//                dizionarioOri.setNomeDizionarioTipo(dizionario.getIdDizTipo().getDizionarioTipo());
//                dizionarioOri.setNomeLingua(dizionario.getIdLingua().getLingua());
//                dizionarioOri.setVocabolo(dizionario.getVocabolo());
//                dizionarioOri.setAbilitato(dizionario.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(dizionarioOri);
//            }
//
//            //Trasformazione di NumSacchetto in NumSacchettoOri
//            if (obj instanceof NumSacchetto) {
//                NumSacchetto numSacchetto = (NumSacchetto) obj;
//                NumSacchettoOri numSacchettoOri = new NumSacchettoOri();
//
//                //Prendo l'oggetto Categoria da numSacchetto e la trasformo in CategoriaOri 
//                //per poterlo settare dentro NumSacchettoOri  
//                Categoria categoria = numSacchetto.getIdCat();
//                CategoriaOri categoriaOri = new CategoriaOri();
//                categoriaOri.setIdCat(categoria.getIdCat());
//                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
//                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());
//
//                numSacchettoOri.setIdNumSac(numSacchetto.getIdNumSac());
//                numSacchettoOri.setNumSacchetti(numSacchetto.getNumSacchetti());
//                numSacchettoOri.setIdCat(categoriaOri);
//                numSacchettoOri.setAbilitato(numSacchetto.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(numSacchettoOri);
//            }
//
//            //Trasformazione di ParametroGlobMac in ParametroGlobMacOri
//            if (obj instanceof ParametroGlobMac) {
//                ParametroGlobMac parametroGlobMac = (ParametroGlobMac) obj;
//                ParametroGlobMacOri parametroGlobMacOri = new ParametroGlobMacOri();
//
//                parametroGlobMacOri.setDescriVariabile(parametroGlobMac.getDescriVariabile());
//                parametroGlobMacOri.setIdParGm(parametroGlobMac.getIdParGm());
//                parametroGlobMacOri.setNomeVariabile(parametroGlobMac.getNomeVariabile());
//                parametroGlobMacOri.setValoreVariabile(parametroGlobMac.getValoreVariabile());
//                parametroGlobMacOri.setAbilitato(parametroGlobMac.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(parametroGlobMacOri);
//            }
//
//            //Trasformazione di ValoreParProd in ValoreParProdOri
//            if (obj instanceof ValoreParProd) {
//                ValoreParProd valoreParProd = (ValoreParProd) obj;
//
//                //Prendo l'oggetto Categoria da valoreParProd e la trasformo in CategoriaOri 
//                //per poterlo settare dentro valoreParProdOri  
//                Categoria categoria = valoreParProd.getIdCat();
//                CategoriaOri categoriaOri = new CategoriaOri();
//                categoriaOri.setIdCat(categoria.getIdCat());
//                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
//                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());
//
//                ValoreParProdOri valoreParProdOri = new ValoreParProdOri();
//                valoreParProdOri.setIdParProd(valoreParProd.getIdParProd().getIdParProd());
//                valoreParProdOri.setIdValParPr(valoreParProd.getIdValParPr());
//                valoreParProdOri.setValoreVariabile(valoreParProd.getValoreVariabile());
//                valoreParProdOri.setIdCat(categoriaOri);
//                valoreParProdOri.setAbilitato(valoreParProd.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(valoreParProdOri);
//            }
//
//            if (obj instanceof ValoreParSacchetto) {
//                ValoreParSacchetto valoreParSacchetto = (ValoreParSacchetto) obj;
//                ValoreParSacchettoOri valoreParSacchettoOri = new ValoreParSacchettoOri();
//
//                //Prendo l'oggetto Categoria da valoreParSacchetto e la trasformo in CategoriaOri 
//                //per poterlo settare dentro valoreParSacchettoOri  
//                Categoria categoria = valoreParSacchetto.getIdCat();
//                CategoriaOri categoriaOri = new CategoriaOri();
//                categoriaOri.setIdCat(categoria.getIdCat());
//                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
//                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());
//
//                //Prendo l'oggetto NumSacchetto da valoreParSacchetto e la trasformo in NumSacchettoOri 
//                //per poterlo settare dentro valoreParSacchettoOri  
//                NumSacchetto numSacchetto = valoreParSacchetto.getIdNumSac();
//                NumSacchettoOri numSacchettoOri = new NumSacchettoOri();
//                numSacchettoOri.setIdNumSac(numSacchetto.getIdNumSac());
//                numSacchettoOri.setIdCat(categoriaOri);
//                numSacchettoOri.setNumSacchetti(numSacchetto.getNumSacchetti());
//
//                valoreParSacchettoOri.setIdValParSac(valoreParSacchetto.getIdValParSac());
//                valoreParSacchettoOri.setIdCat(categoriaOri);
//                valoreParSacchettoOri.setIdParSac(valoreParSacchetto.getIdParSac().getIdParSac());
//                valoreParSacchettoOri.setIdNumSac(numSacchettoOri);
//                valoreParSacchettoOri.setValoreVariabile(valoreParSacchetto.getValoreVariabile());
//                valoreParSacchettoOri.setSacchetto(valoreParSacchetto.getSacchetto());
//                valoreParSacchettoOri.setAbilitato(valoreParSacchetto.getAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(valoreParSacchettoOri);
//            }
//
//            //CASO PARTICOLARE DOPPIO FLUSSO
//            //Trasformazione di ValoreRipristino in ValoreRipristinoOri
//            if (obj instanceof ValoreRipristino) {
//                ValoreRipristino valoreRipristino = (ValoreRipristino) obj;
//
//                ValoreRipristinoOri valoreRipristinoOri = new ValoreRipristinoOri();
//
//                valoreRipristinoOri.setIdValoreRipristino(valoreRipristino.getValoreRipristinoPK().getIdValoreRipristino());
//                valoreRipristinoOri.setIdParRipristino(valoreRipristino.getIdParRipristino().getIdParRipristino());
//                valoreRipristinoOri.setValoreVariabile(valoreRipristino.getValoreVariabile());
//                valoreRipristinoOri.setIdProCorso(valoreRipristino.getIdProCorso());
//                valoreRipristinoOri.setAbilitato(valoreRipristino.getAbilitato());
//                //Il valore del campo dt_abilitato viene modificato sulla macchina
//                valoreRipristinoOri.setDtAbilitato(valoreRipristino.getDtAbilitato());
//                valoreRipristinoOri.setDtRegistrato(valoreRipristino.getDtRegistrato());
//
//                aggiornamentoOriOut.getDaInserire().add(valoreRipristinoOri);
//            }
//
//            //CASO PARTICOLARE DOPPIO FLUSSO    
//            //Trasformazione di ValoreParSingMac in ValoreParSingMacOri
//            if (obj instanceof ValoreParSingMac) {
//
//                ValoreParSingMac valoreParSingMac = (ValoreParSingMac) obj;
//                ValoreParSingMacOri valoreParSingMacOri = new ValoreParSingMacOri();
//
//                valoreParSingMacOri.setIdValParSm(valoreParSingMac.getIdValParSm());
//                valoreParSingMacOri.setIdParSm(valoreParSingMac.getIdParSm().getIdParSm());
//                valoreParSingMacOri.setValoreVariabile(valoreParSingMac.getValoreVariabile());
//                //ATTENZIONE AL VALORE INIZIALE
//                valoreParSingMacOri.setValoreIniziale(valoreParSingMac.getValoreIniziale());
//                valoreParSingMacOri.setDtValoreIniziale(valoreParSingMac.getDtValoreIniziale());
//                valoreParSingMacOri.setAbilitato(valoreParSingMac.getAbilitato());
//                //I due campi seguenti non vengono salvati sulla macchina 
//                //In questo modio si evita di avere campi con valore null
//                valoreParSingMacOri.setDtModificaMac(valoreParSingMac.getDtModificaMac());
//                valoreParSingMacOri.setDtAbilitato(valoreParSingMac.getDtAbilitato());
//
//                aggiornamentoOriOut.getDaInserire().add(valoreParSingMacOri);
//            }
//
//            //CASO PARTICOLARE DOPPIO FLUSSO    
//            //Trasformazione di ValoreParComp in ValoreParCompOri
//            if (obj instanceof ValoreParComp) {
//
//                ValoreParComp valoreParComp = (ValoreParComp) obj;
//                ValoreParCompOri valoreParCompOri = new ValoreParCompOri();
//
//                valoreParCompOri.setIdValComp(valoreParComp.getIdValComp());
//                valoreParCompOri.setIdParComp(valoreParComp.getIdParComp().getIdParComp());
//                valoreParCompOri.setIdComp(valoreParComp.getIdComp().getIdComp());
//                valoreParCompOri.setValoreVariabile(valoreParComp.getValoreVariabile());
//
//                valoreParCompOri.setValoreIniziale(valoreParComp.getValoreIniziale());
//                valoreParCompOri.setDtValoreIniziale(valoreParComp.getDtValoreIniziale());
//                valoreParCompOri.setAbilitato(valoreParComp.getAbilitato());
//                //I due campi seguenti non vengono salvati sulla macchina 
//                //In questo modio si evita di avere campi con valore null
//                valoreParCompOri.setDtAbilitato(valoreParComp.getDtAbilitato());
//                valoreParCompOri.setDtModificaMac(valoreParComp.getDtModificaMac());
//
//                aggiornamentoOriOut.getDaInserire().add(valoreParCompOri);
//            }
//
//        }
//
////        log.info("TRASFORMAZIONE DI Aggiornamento IN AggiornamentoOri EFFETTUATA:" + aggiornamentoOriOut);
//        return aggiornamentoOriOut;
//
//    }
    /**
     * Adatta l'aggiornamento al formato di uscita
     *
     * @param aggiornamento
     * @return aggiornamentoOri
     *
     */
    public static AggiornamentoOri adattaAggiornamentoOut(Aggiornamento aggiornamento, Integer syncSftwVersion, Integer origamiDbVersion, Integer machineSftwVersion, String InFilePfx, EntityManagerFactory emf) {

        AggiornamentoOri aggiornamentoOriOut = new AggiornamentoOri();

        //Il tipo dell'AggiornamentoOri deve essere IN quando arriva sulla macchina, 
        //la versione coincide con quella dell'Aggiornamento
        aggiornamentoOriOut.setTipo(InFilePfx);
        aggiornamentoOriOut.setVersione(aggiornamento.getVersione());

        AnagrafeProdottoJpaController anagrafeProdottoJc = new AnagrafeProdottoJpaController(null, emf);

        //NOTA BENE: 
        //nelle seguenti trasformazioni il campo dtAbilitato degli oggetti di tipo Ori non viene mai 
        //copiato sulla macchina ma nelle tabelle di origamidb che hanno un flusso dati server-to-macchina contiene sempre 
        //la data propria della macchina in formato timestamp gestita automaticamente in locale ad ogni insert o update
        Collection c = new ArrayList();
        aggiornamentoOriOut.setDaInserire(c);

        //codice di trasformazione 
        for (Object obj : aggiornamento.getDaInserire()) {

            //Trasformazione di Macchina in MacchinaOri
            if (obj instanceof Macchina) {

                Macchina macchina = (Macchina) obj;
                MacchinaOri macchinaOri = new MacchinaOri();

                macchinaOri.setIdMacchina(macchina.getIdMacchina());
                macchinaOri.setCodStab(macchina.getCodStab());
                macchinaOri.setDescriStab(macchina.getDescriStab());
                macchinaOri.setPassOrigami(macchina.getPassOrigami());
                macchinaOri.setPassServer(macchina.getPassServer());
                macchinaOri.setRagso1(macchina.getRagso1());
                macchinaOri.setUserOrigami(macchina.getUserOrigami());
                macchinaOri.setUserServer(macchina.getUserServer());
                macchinaOri.setFtpPassword(macchina.getFtpPassword());
                macchinaOri.setFtpUser(macchina.getFtpUser());
                macchinaOri.setZipPassword(macchina.getZipPassword());
                macchinaOri.setAbilitato(macchina.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(macchinaOri);
            }

            //Trasformazione di AggiornamentoConfig in AggiornamentoConfigOri
            if (obj instanceof AggiornamentoConfig) {

                AggiornamentoConfig aggiornamentoConfig = (AggiornamentoConfig) obj;
                AggiornamentoConfigOri aggiornamentoConfigOri = new AggiornamentoConfigOri();

                aggiornamentoConfigOri.setId(aggiornamentoConfig.getId());
                aggiornamentoConfigOri.setParametro(aggiornamentoConfig.getParametro());
                aggiornamentoConfigOri.setTipo(aggiornamentoConfig.getTipo());
                aggiornamentoConfigOri.setDescrizione(aggiornamentoConfig.getDescrizione());
                aggiornamentoConfigOri.setValore(aggiornamentoConfig.getValore());
                aggiornamentoConfigOri.setAbilitato(aggiornamentoConfig.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(aggiornamentoConfigOri);
            }

            //Trasformazione di Chimica in ChimicaOri
            if (obj instanceof Chimica) {
                Chimica chimica = (Chimica) obj;
                ChimicaOri chimicaOri = new ChimicaOri();

                chimicaOri.setIdChimica(chimica.getIdChimica());
                chimicaOri.setCodChimica(chimica.getCodChimica());
                chimicaOri.setCodLotto(chimica.getCodLotto().getCodLotto());
                chimicaOri.setDescriFormula(chimica.getDescriFormula());
                chimicaOri.setNumBolla(chimica.getCodLotto().getIdBolla().getNumBolla());
                chimicaOri.setDtBolla(chimica.getCodLotto().getIdBolla().getDtBolla());

                chimicaOri.setStatoCh(Boolean.FALSE);
                aggiornamentoOriOut.getDaInserire().add(chimicaOri);
            }

            //Trasformazione di Componente in ComponenteOri
            if (obj instanceof Componente) {
                Componente componente = (Componente) obj;
                ComponenteOri componenteOri = new ComponenteOri();

                componenteOri.setIdComp(componente.getIdComp());
                componenteOri.setCodComponente(componente.getCodComponente());
                componenteOri.setDescriComponente(componente.getDescriComponente());
                componenteOri.setAbilitato(componente.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(componenteOri);
            }

            //Trasformazione di Colore in ColoreOri
            if (obj instanceof Colore) {
                Colore colore = (Colore) obj;
                ColoreOri coloreOri = new ColoreOri();
                coloreOri.setCodColore(colore.getCodColore());
                coloreOri.setIdColore(colore.getIdColore());
                coloreOri.setNomeColore(colore.getNomeColore());
                coloreOri.setAbilitato(colore.getAbilitato());

                //Modifica TEMPORANEA 12 APRILE 2013
                //Il campo dtAbilitato non bisogna settarlo
                coloreOri.setDtAbilitato(colore.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(coloreOri);
            }

            //Trasformazione di ColoreBase in ColoreBaseOri
            if (obj instanceof ColoreBase) {
                ColoreBase coloreBase = (ColoreBase) obj;
                ColoreBaseOri coloreBaseOri = new ColoreBaseOri();
                coloreBaseOri.setCodColoreBase(coloreBase.getCodColoreBase());
                coloreBaseOri.setIdColoreBase(coloreBase.getIdColoreBase());
                coloreBaseOri.setNomeColoreBase(coloreBase.getNomeColoreBase());
                coloreBaseOri.setCostoColoreBase(coloreBase.getCostoColoreBase());
                coloreBaseOri.setTollPerc(coloreBase.getTollPerc());
                coloreBaseOri.setAbilitato(coloreBase.getAbilitato());
                aggiornamentoOriOut.getDaInserire().add(coloreBaseOri);
            }

            //Trasformazione di Mazzetta in Mazzetta
            if (obj instanceof Mazzetta) {
                Mazzetta mazzetta = (Mazzetta) obj;
                MazzettaOri mazzettaOri = new MazzettaOri();
                mazzettaOri.setCodMazzetta(mazzetta.getCodMazzetta());
                mazzettaOri.setIdMazzetta(mazzetta.getIdMazzetta());
                mazzettaOri.setNomeMazzetta(mazzetta.getNomeMazzetta());
                mazzettaOri.setAbilitato(mazzetta.getAbilitato());

                //Modifica TEMPORANEA 12 APRILE 2013
                //Il campo abilitato non bisogna settarlo
                mazzettaOri.setDtAbilitato(mazzetta.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(mazzettaOri);
            }

            //Trasformazione di MazzettaColorata in MazzettaColorataOri
            if (obj instanceof MazzettaColorata) {
                MazzettaColorata mazzettaColorata = (MazzettaColorata) obj;
                MazzettaColorataOri mazzettaColorataOri = new MazzettaColorataOri();

                //Prendo l'oggetto Colore da MazzettaColorata e la trasformo in ColoreOri 
                //per poterlo settare dentro MazzettaColorataOri
                Colore colore = new Colore();
                colore = mazzettaColorata.getIdColore();

                ColoreOri coloreOri = new ColoreOri();
                coloreOri.setIdColore(colore.getIdColore());
                coloreOri.setCodColore(colore.getCodColore());
                coloreOri.setNomeColore(colore.getNomeColore());
                coloreOri.setAbilitato(colore.getAbilitato());
                //Prendo l'oggetto ColoreBase da MazzettaColorata e lo trasformo in ColoreBaseOri 
                //per poterlo settare dentro MazzettaColorataOri
                ColoreBase coloreBase = new ColoreBase();
                coloreBase = mazzettaColorata.getIdColoreBase();

                ColoreBaseOri coloreBaseOri = new ColoreBaseOri();
                coloreBaseOri.setIdColoreBase(coloreBase.getIdColoreBase());
                coloreBaseOri.setCodColoreBase(coloreBase.getCodColoreBase());
                coloreBaseOri.setNomeColoreBase(coloreBase.getNomeColoreBase());
                coloreBaseOri.setCostoColoreBase(coloreBase.getCostoColoreBase());
                coloreBaseOri.setAbilitato(coloreBase.getAbilitato());
                //Prendo l'oggetto Mazzetta da MazzettaColorata e la trasformo in MazzettaOri 
                //per poterlo settare dentro MazzettaColorataOri
                Mazzetta mazzetta = new Mazzetta();
                mazzetta = mazzettaColorata.getIdMazzetta();
                MazzettaOri mazzettaOri = new MazzettaOri();
                mazzettaOri.setIdMazzetta(mazzetta.getIdMazzetta());
                mazzettaOri.setCodMazzetta(mazzetta.getCodMazzetta());
                mazzettaOri.setNomeMazzetta(mazzetta.getNomeMazzetta());
                mazzettaOri.setAbilitato(mazzetta.getAbilitato());

                mazzettaColorataOri.setIdMazCol(mazzettaColorata.getIdMazCol());
                mazzettaColorataOri.setIdColore(coloreOri);
                mazzettaColorataOri.setIdColoreBase(coloreBaseOri);
                mazzettaColorataOri.setIdMazzetta(mazzettaOri);
                mazzettaColorataOri.setQuantita(mazzettaColorata.getQuantita());
                mazzettaColorataOri.setAbilitato(mazzettaColorata.getAbilitato());

                //Modifica TEMPORANEA 12 APRILE 2013
                //Il campo dtAbilitato non bisogna settarlo
                mazzettaColorataOri.setDtAbilitato(mazzettaColorata.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(mazzettaColorataOri);
            }

            //Trasformazione di Categoria in CategoriaOri
            if (obj instanceof Categoria) {
                Categoria categoria = (Categoria) obj;
                CategoriaOri categoriaOri = new CategoriaOri();
                categoriaOri.setIdCat(categoria.getIdCat());
                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());
                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
                categoriaOri.setAbilitato(categoria.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(categoriaOri);
            }

            //Trasformazione di ParametroCompProd in ParametroCompProdOri
            if (obj instanceof ParametroCompProd) {
                ParametroCompProd parametroCompProd = (ParametroCompProd) obj;
                ParametroCompProdOri parametroCompProdOri = new ParametroCompProdOri();

                parametroCompProdOri.setIdParComp(parametroCompProd.getIdParComp());
                parametroCompProdOri.setNomeVariabile(parametroCompProd.getNomeVariabile());
                parametroCompProdOri.setDescriVariabile(parametroCompProd.getDescriVariabile());
                parametroCompProdOri.setValoreBase(parametroCompProd.getValoreBase());
                parametroCompProdOri.setAbilitato(parametroCompProd.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(parametroCompProdOri);
            }

            //Trasformazione di Prodotto,AnagrafeProdotto in ProdottoOri
            //Aggiungere if (obj instanceof Prodotto)
            if (obj instanceof AnagrafeProdotto) {
                AnagrafeProdotto anagrafeProdotto = (AnagrafeProdotto) obj;
                ProdottoOri prodottoOri = new ProdottoOri();

                prodottoOri.setIdProdotto(anagrafeProdotto.getIdProdotto().getIdProdotto());
                prodottoOri.setCodProdotto(anagrafeProdotto.getIdProdotto().getCodProdotto());
                prodottoOri.setNomeProdotto(anagrafeProdotto.getIdProdotto().getNomeProdotto());

                if (syncSftwVersion == 4 || (syncSftwVersion == 3 & origamiDbVersion.equals(4) & machineSftwVersion.equals(4))) {
                    //campi nuovi 10 aprile 2018
                    prodottoOri.setTipo(anagrafeProdotto.getIdProdotto().getTipo());
                    prodottoOri.setSerieColore(anagrafeProdotto.getIdProdotto().getSerieColore());
                    prodottoOri.setSerieAdditivo(anagrafeProdotto.getIdProdotto().getSerieAdditivo());
                    prodottoOri.setInfo1(anagrafeProdotto.getIdProdotto().getInfo1());
                    prodottoOri.setInfo2(anagrafeProdotto.getIdProdotto().getInfo2());
                    prodottoOri.setInfo3(anagrafeProdotto.getIdProdotto().getInfo3());
                    prodottoOri.setInfo4(anagrafeProdotto.getIdProdotto().getInfo4());
                    prodottoOri.setInfo5(anagrafeProdotto.getIdProdotto().getInfo5());
                    prodottoOri.setInfo6(anagrafeProdotto.getIdProdotto().getInfo6());
                    prodottoOri.setInfo7(anagrafeProdotto.getIdProdotto().getInfo7());
                    prodottoOri.setInfo8(anagrafeProdotto.getIdProdotto().getInfo8());
                    prodottoOri.setInfo9(anagrafeProdotto.getIdProdotto().getInfo9());
                    prodottoOri.setInfo10(anagrafeProdotto.getIdProdotto().getInfo10());
                }

                prodottoOri.setColorato(anagrafeProdotto.getColorato());
                prodottoOri.setIdCodice(anagrafeProdotto.getIdCodice().getIdCodice());
                prodottoOri.setDescriFamiglia(anagrafeProdotto.getIdCodice().getDescrizione());
                prodottoOri.setTipoFamiglia(anagrafeProdotto.getIdCodice().getTipoCodice());
                prodottoOri.setFascia(anagrafeProdotto.getFascia());
                prodottoOri.setFattoreDiv(anagrafeProdotto.getFattoreDiv());
                prodottoOri.setLimColore(anagrafeProdotto.getLimColore());
                prodottoOri.setAbilitato(anagrafeProdotto.getAbilitato());

                //Prendo l'oggetto Categoria da anagrafeProdotto e la trasformo in CategoriaOri 
                //per poterlo settare dentro ProdottoOri
                Categoria categoria = anagrafeProdotto.getIdCat();
                CategoriaOri categoriaOri = new CategoriaOri();
                categoriaOri.setIdCat(categoria.getIdCat());
                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());
                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());

                prodottoOri.setIdCat(categoriaOri);

                //Prendo l'oggetto Mazzetta da anagrafeProdotto e la trasformo in MazzettaOri 
                //per poterlo settare dentro ProdottoOri     
                Mazzetta mazzetta = anagrafeProdotto.getIdMazzetta();
                MazzettaOri mazzettaOri = new MazzettaOri();

                mazzettaOri.setIdMazzetta(mazzetta.getIdMazzetta());
                mazzettaOri.setCodMazzetta(mazzetta.getCodMazzetta());
                mazzettaOri.setNomeMazzetta(mazzetta.getNomeMazzetta());

                prodottoOri.setIdMazzetta(mazzettaOri);

                aggiornamentoOriOut.getDaInserire().add(prodottoOri);
            }

            //Trasformazione di ComponenteProdotto in ComponenteProdottoOri
            if (obj instanceof ComponenteProdotto) {
                ComponenteProdotto componenteProdotto = (ComponenteProdotto) obj;

                //Prendo l'oggetto Componente da componenteProdotto e la trasformo in ComponenteOri 
                //per poterlo settare dentro ComponenteProdottoOri  
                //TODO: componente
                Componente componente = componenteProdotto.getIdComp();
                ComponenteOri componenteOri = new ComponenteOri();

                componenteOri.setIdComp(componente.getIdComp());
                componenteOri.setCodComponente(componente.getCodComponente());
                componenteOri.setDescriComponente(componente.getDescriComponente());
                componenteOri.setAbilitato(componente.getAbilitato());

                //Prendo l'oggetto Prodotto da componenteProdotto e la trasformo in ProdottoOri 
                //per poterlo settare dentro ComponenteProdottoOri  
                Prodotto prodotto = componenteProdotto.getIdProdotto();
                ProdottoOri prodottoOri = new ProdottoOri();
                prodottoOri.setIdProdotto(prodotto.getIdProdotto());

                ComponenteProdottoOri componenteProdottoOri = new ComponenteProdottoOri();
                componenteProdottoOri.setIdCompProd(componenteProdotto.getIdCompProd());
                componenteProdottoOri.setIdComp(componenteOri);
                componenteProdottoOri.setIdProdotto(prodottoOri);
                componenteProdottoOri.setQuantita(componenteProdotto.getQuantita());
                componenteProdottoOri.setAbilitato(componenteProdotto.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(componenteProdottoOri);

//                 log.info("componenteProdottoOri : "+componenteProdottoOri.toString());
            }

            //Trasformazione di Presa in PresaOri
            if (obj instanceof Presa) {
                Presa presa = (Presa) obj;
                PresaOri presaOri = new PresaOri();
                presaOri.setIdPresa(presa.getIdPresa());
                presaOri.setPresa(presa.getPresa());
                presaOri.setAbilitato(presa.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(presaOri);
            }

            //Trasformazione di Dizionario in DizionarioOri
            if (obj instanceof Dizionario) {
                Dizionario dizionario = (Dizionario) obj;

                DizionarioOri dizionarioOri = new DizionarioOri();
                dizionarioOri.setIdDizTipo(dizionario.getIdDizTipo().getIdDizTipo());
                dizionarioOri.setIdDizionario(dizionario.getIdDizionario());
                dizionarioOri.setIdLingua(dizionario.getIdLingua().getIdLingua());
                dizionarioOri.setIdVocabolo(dizionario.getIdVocabolo());
                dizionarioOri.setNomeDizionarioTipo(dizionario.getIdDizTipo().getDizionarioTipo());
                dizionarioOri.setNomeLingua(dizionario.getIdLingua().getLingua());
                dizionarioOri.setVocabolo(dizionario.getVocabolo());
                dizionarioOri.setAbilitato(dizionario.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(dizionarioOri);
            }

            //Trasformazione di NumSacchetto in NumSacchettoOri
            if (obj instanceof NumSacchetto) {
                NumSacchetto numSacchetto = (NumSacchetto) obj;
                NumSacchettoOri numSacchettoOri = new NumSacchettoOri();

                //Prendo l'oggetto Categoria da numSacchetto e la trasformo in CategoriaOri 
                //per poterlo settare dentro NumSacchettoOri  
                Categoria categoria = numSacchetto.getIdCat();
                CategoriaOri categoriaOri = new CategoriaOri();
                categoriaOri.setIdCat(categoria.getIdCat());
                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());

                numSacchettoOri.setIdNumSac(numSacchetto.getIdNumSac());
                numSacchettoOri.setNumSacchetti(numSacchetto.getNumSacchetti());
                numSacchettoOri.setIdCat(categoriaOri);
                numSacchettoOri.setAbilitato(numSacchetto.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(numSacchettoOri);
            }

            //Trasformazione di ParametroGlobMac in ParametroGlobMacOri
            if (obj instanceof ParametroGlobMac) {
                ParametroGlobMac parametroGlobMac = (ParametroGlobMac) obj;
                ParametroGlobMacOri parametroGlobMacOri = new ParametroGlobMacOri();

                parametroGlobMacOri.setDescriVariabile(parametroGlobMac.getDescriVariabile());
                parametroGlobMacOri.setIdParGm(parametroGlobMac.getIdParGm());
                parametroGlobMacOri.setNomeVariabile(parametroGlobMac.getNomeVariabile());
                parametroGlobMacOri.setValoreVariabile(parametroGlobMac.getValoreVariabile());
                parametroGlobMacOri.setAbilitato(parametroGlobMac.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(parametroGlobMacOri);
            }

            //Trasformazione di ValoreParProd in ValoreParProdOri
            if (obj instanceof ValoreParProd) {
                ValoreParProd valoreParProd = (ValoreParProd) obj;

                //Prendo l'oggetto Categoria da valoreParProd e la trasformo in CategoriaOri 
                //per poterlo settare dentro valoreParProdOri  
                Categoria categoria = valoreParProd.getIdCat();
                CategoriaOri categoriaOri = new CategoriaOri();
                categoriaOri.setIdCat(categoria.getIdCat());
                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());

                ValoreParProdOri valoreParProdOri = new ValoreParProdOri();
                valoreParProdOri.setIdParProd(valoreParProd.getIdParProd().getIdParProd());
                valoreParProdOri.setIdValParPr(valoreParProd.getIdValParPr());
                valoreParProdOri.setValoreVariabile(valoreParProd.getValoreVariabile());
                valoreParProdOri.setIdCat(categoriaOri);
                valoreParProdOri.setAbilitato(valoreParProd.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(valoreParProdOri);
            }

            if (obj instanceof ValoreParSacchetto) {
                ValoreParSacchetto valoreParSacchetto = (ValoreParSacchetto) obj;
                ValoreParSacchettoOri valoreParSacchettoOri = new ValoreParSacchettoOri();

                //Prendo l'oggetto Categoria da valoreParSacchetto e la trasformo in CategoriaOri 
                //per poterlo settare dentro valoreParSacchettoOri  
                Categoria categoria = valoreParSacchetto.getIdCat();
                CategoriaOri categoriaOri = new CategoriaOri();
                categoriaOri.setIdCat(categoria.getIdCat());
                categoriaOri.setDescriCategoria(categoria.getDescriCategoria());
                categoriaOri.setNomeCategoria(categoria.getNomeCategoria());

                //Prendo l'oggetto NumSacchetto da valoreParSacchetto e la trasformo in NumSacchettoOri 
                //per poterlo settare dentro valoreParSacchettoOri  
                NumSacchetto numSacchetto = valoreParSacchetto.getIdNumSac();
                NumSacchettoOri numSacchettoOri = new NumSacchettoOri();
                numSacchettoOri.setIdNumSac(numSacchetto.getIdNumSac());
                numSacchettoOri.setIdCat(categoriaOri);
                numSacchettoOri.setNumSacchetti(numSacchetto.getNumSacchetti());

                valoreParSacchettoOri.setIdValParSac(valoreParSacchetto.getIdValParSac());
                valoreParSacchettoOri.setIdCat(categoriaOri);
                valoreParSacchettoOri.setIdParSac(valoreParSacchetto.getIdParSac().getIdParSac());
                valoreParSacchettoOri.setIdNumSac(numSacchettoOri);

                valoreParSacchettoOri.setValoreVariabile(valoreParSacchetto.getValoreVariabile());

                //##############################################################
                //Modifica 3 aprile 2018 per le macchine con versione del sftw 2,3 bisogna mandare valore del par 43 zero
                //per le macchine con versione 4 si invia il valore registrato su inephos ovvero la stringa per la                
                //curvaBilanciaSacchiAValvolaAperta                
                int idParSacCurvaBilancia = 43;
                if (syncSftwVersion < 4 && valoreParSacchettoOri.getIdParSac() == idParSacCurvaBilancia) {

                    valoreParSacchettoOri.setValoreVariabile("0");

                }
                //##############################################################

                valoreParSacchettoOri.setSacchetto(valoreParSacchetto.getSacchetto());
                valoreParSacchettoOri.setAbilitato(valoreParSacchetto.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(valoreParSacchettoOri);
            }

            //CASO PARTICOLARE DOPPIO FLUSSO
            //Trasformazione di ValoreRipristino in ValoreRipristinoOri
            if (obj instanceof ValoreRipristino) {

                ValoreRipristino valoreRipristino = (ValoreRipristino) obj;

                ValoreRipristinoOri valoreRipristinoOri = new ValoreRipristinoOri();

                valoreRipristinoOri.setIdValoreRipristino(valoreRipristino.getValoreRipristinoPK().getIdValoreRipristino());
                valoreRipristinoOri.setIdParRipristino(valoreRipristino.getIdParRipristino().getIdParRipristino());
                valoreRipristinoOri.setValoreVariabile(valoreRipristino.getValoreVariabile());
                valoreRipristinoOri.setIdProCorso(valoreRipristino.getIdProCorso());
                valoreRipristinoOri.setAbilitato(valoreRipristino.getAbilitato());
                //Il valore del campo dt_abilitato viene modificato sulla macchina
                valoreRipristinoOri.setDtAbilitato(valoreRipristino.getDtAbilitato());
                valoreRipristinoOri.setDtRegistrato(valoreRipristino.getDtRegistrato());

                aggiornamentoOriOut.getDaInserire().add(valoreRipristinoOri);
            }

            //CASO PARTICOLARE DOPPIO FLUSSO    
            //Trasformazione di ValoreParSingMac in ValoreParSingMacOri
            if (obj instanceof ValoreParSingMac) {

                ValoreParSingMac valoreParSingMac = (ValoreParSingMac) obj;
                ValoreParSingMacOri valoreParSingMacOri = new ValoreParSingMacOri();

                valoreParSingMacOri.setIdValParSm(valoreParSingMac.getIdValParSm());
                valoreParSingMacOri.setIdParSm(valoreParSingMac.getIdParSm().getIdParSm());
                valoreParSingMacOri.setValoreVariabile(valoreParSingMac.getValoreVariabile());
                //ATTENZIONE AL VALORE INIZIALE
                valoreParSingMacOri.setValoreIniziale(valoreParSingMac.getValoreIniziale());
                valoreParSingMacOri.setDtValoreIniziale(valoreParSingMac.getDtValoreIniziale());
                valoreParSingMacOri.setAbilitato(valoreParSingMac.getAbilitato());
                //I due campi seguenti non vengono salvati sulla macchina 
                //In questo modio si evita di avere campi con valore null
                valoreParSingMacOri.setDtModificaMac(valoreParSingMac.getDtModificaMac());
                valoreParSingMacOri.setDtAbilitato(valoreParSingMac.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(valoreParSingMacOri);
            }

            //CASO PARTICOLARE DOPPIO FLUSSO    
            //Trasformazione di ValoreParComp in ValoreParCompOri
            if (obj instanceof ValoreParComp) {

                ValoreParComp valoreParComp = (ValoreParComp) obj;
                ValoreParCompOri valoreParCompOri = new ValoreParCompOri();

                valoreParCompOri.setIdValComp(valoreParComp.getIdValComp());
                valoreParCompOri.setIdParComp(valoreParComp.getIdParComp().getIdParComp());
                valoreParCompOri.setIdComp(valoreParComp.getIdComp().getIdComp());
                valoreParCompOri.setValoreVariabile(valoreParComp.getValoreVariabile());

                valoreParCompOri.setValoreIniziale(valoreParComp.getValoreIniziale());
                valoreParCompOri.setDtValoreIniziale(valoreParComp.getDtValoreIniziale());
                valoreParCompOri.setAbilitato(valoreParComp.getAbilitato());
                //I due campi seguenti non vengono salvati sulla macchina 
                //In questo modio si evita di avere campi con valore null
                valoreParCompOri.setDtAbilitato(valoreParComp.getDtAbilitato());
                valoreParCompOri.setDtModificaMac(valoreParComp.getDtModificaMac());

                aggiornamentoOriOut.getDaInserire().add(valoreParCompOri);
            }

//###### 21-10-2015
            //Trasformazione di ValoreProdotto in ValoreProdottoOri
            if (obj instanceof ValoreProdotto) {
                ValoreProdotto valoreProdotto = (ValoreProdotto) obj;

                //Prendo l'oggetto Prodotto da valoreProdotto e la trasformo in ProdottoOri 
                //per poterlo settare dentro valoreProdottoOri  
                Prodotto prodotto = valoreProdotto.getIdProdotto();

                ProdottoOri prodottoOri = new ProdottoOri();

                prodottoOri.setIdProdotto(prodotto.getIdProdotto());
                prodottoOri.setCodProdotto(prodotto.getCodProdotto());
                prodottoOri.setNomeProdotto(prodotto.getNomeProdotto());

                ValoreProdottoOri valoreProdottoOri = new ValoreProdottoOri();

                //Prendo l'oggetto ValoreProdotto e la trasformo in ValoreProdottoOri 
                //per poterlo settare dentro valoreProdottoOri  
                valoreProdottoOri = new ValoreProdottoOri();
                valoreProdottoOri.setIdValPr(valoreProdotto.getIdValPr());
                valoreProdottoOri.setIdParProd(valoreProdotto.getIdParProd().getIdParProd());
                valoreProdottoOri.setValoreVariabile(valoreProdotto.getValoreVariabile());
                valoreProdottoOri.setIdProdotto(prodottoOri);
                valoreProdottoOri.setAbilitato(valoreProdotto.getAbilitato());
                valoreProdottoOri.setDtAbilitato(valoreProdotto.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(valoreProdottoOri);

//                log.info("valoreProdottoOri : "+valoreProdottoOri.toString());
            }

            //Trasformazione di ValoreParProdMac in ValoreParProdMacOri
            if (obj instanceof ValoreParProdMac) {
                ValoreParProdMac valoreParProdMac = (ValoreParProdMac) obj;

                //Prendo l'oggetto Prodotto da valoreProdotto e la trasformo in ProdottoOri 
                //per poterlo settare dentro valoreProdottoOri  
                Prodotto prodotto = valoreParProdMac.getIdProdotto();

                ProdottoOri prodottoOri = new ProdottoOri();

                prodottoOri.setIdProdotto(prodotto.getIdProdotto());
                prodottoOri.setCodProdotto(prodotto.getCodProdotto());
                prodottoOri.setNomeProdotto(prodotto.getNomeProdotto());

                ValoreParProdMacOri valoreParProdMacOri = new ValoreParProdMacOri();

                //Prendo l'oggetto ValoreProdotto e la trasformo in ValoreProdottoOri 
                //per poterlo settare dentro valoreProdottoOri  
                valoreParProdMacOri = new ValoreParProdMacOri();
                valoreParProdMacOri.setIdValPm(valoreParProdMac.getIdValPm());
                valoreParProdMacOri.setIdParPm(valoreParProdMac.getIdParPm().getIdParPm());
                valoreParProdMacOri.setValoreVariabile(valoreParProdMac.getValoreVariabile());
                valoreParProdMacOri.setIdProdotto(prodottoOri);
                valoreParProdMacOri.setAbilitato(valoreParProdMac.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(valoreParProdMacOri);
            }

            //Trasformazione di OrdineSingMac in OrdineSingMacOri
            if (obj instanceof OrdineSingMac) {
                OrdineSingMac ordineSingMac = (OrdineSingMac) obj;

                //Prendo l'oggetto OrdineSingMac da ordineSingMac e la trasformo in OrdineSingMacOri 
                OrdineSingMacOri ordineSingMacOri = new OrdineSingMacOri();

                ordineSingMacOri.setIdOrdineSm(ordineSingMac.getIdOrdineSm());
                ordineSingMacOri.setIdOrdine(ordineSingMac.getIdOrdine().getIdOrdine());
                ordineSingMacOri.setIdProdotto(ordineSingMac.getIdProdotto());
                ordineSingMacOri.setOrdineProduzione(ordineSingMac.getOrdineProduzione());
                ordineSingMacOri.setContatore(ordineSingMac.getContatore());
                ordineSingMacOri.setNumPezzi(ordineSingMac.getNumPezzi());
                ordineSingMacOri.setStato(ordineSingMac.getStato());
                ordineSingMacOri.setAbilitato(ordineSingMac.getAbilitato());
                ordineSingMacOri.setDtProduzione(ordineSingMac.getDtProduzione());
                ordineSingMacOri.setDtProgrammata(ordineSingMac.getDtProgrammata());
                ordineSingMacOri.setDtAbilitato(ordineSingMac.getDtAbilitato());

                ordineSingMacOri.setInfo1(ordineSingMac.getInfo1());
                ordineSingMacOri.setInfo2(ordineSingMac.getInfo2());
                ordineSingMacOri.setInfo3(ordineSingMac.getInfo3());
                ordineSingMacOri.setInfo4(ordineSingMac.getInfo4());
                ordineSingMacOri.setInfo5(ordineSingMac.getInfo5());
                ordineSingMacOri.setInfo6(ordineSingMac.getInfo6());
                ordineSingMacOri.setInfo7(ordineSingMac.getInfo7());
                ordineSingMacOri.setInfo8(ordineSingMac.getInfo8());
                ordineSingMacOri.setInfo9(ordineSingMac.getInfo9());
                ordineSingMacOri.setInfo10(ordineSingMac.getInfo10());

                aggiornamentoOriOut.getDaInserire().add(ordineSingMacOri);
            }

            //Trasformazione di ValoreParOrdine in ValoreParOrdineOri
            if (obj instanceof ValoreParOrdine) {
                ValoreParOrdine valoreParOrdine = (ValoreParOrdine) obj;

                ValoreParOrdineOri valoreParOrdineOri = new ValoreParOrdineOri();

                valoreParOrdineOri.setId(valoreParOrdine.getId());
                valoreParOrdineOri.setIdParOrdine(valoreParOrdine.getIdParOrdine().getIdParOrdine());
                valoreParOrdineOri.setIdOrdineSm(valoreParOrdine.getIdOrdineSm());
                valoreParOrdineOri.setValore(valoreParOrdine.getValore());
                valoreParOrdineOri.setAbilitato(valoreParOrdine.getAbilitato());
                valoreParOrdineOri.setDtAbilitato(valoreParOrdine.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(valoreParOrdineOri);
            }

            //Trasformazione di Allarme in AllarmeOri
            if (obj instanceof Allarme) {
                Allarme allarme = (Allarme) obj;
                AllarmeOri allarmeOri = new AllarmeOri();

                allarmeOri.setIdAllarme(allarme.getIdAllarme());
                allarmeOri.setNome(allarme.getNome());
                allarmeOri.setDescrizione(allarme.getDescrizione());
                allarmeOri.setTabellaRiferimento(allarme.getTabellaRiferimento());

                allarmeOri.setAbilitato(allarme.getAbilitato());
                allarmeOri.setDtAbilitato(allarme.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(allarmeOri);
            }

            //Trasformazione di MovimentoSingMac in MovimentoSingMacOri
            if (obj instanceof MovimentoSingMac) {
                MovimentoSingMac movimentoSingMac = (MovimentoSingMac) obj;
                MovimentoSingMacOri movimentoSingMacOri = new MovimentoSingMacOri();

                movimentoSingMacOri.setIdMovInephos(movimentoSingMac.getIdMovInephos());
                //Setto il valore dell'idMovOri altrimenti  da errore nel download
                //Il campo id_mov_ori della tabella movimento_sing_mac_ori è autoincrement
                //quindi quando si salva l'oggetto gli viene assegnato un valore automatico
                //Attenzione però nell'entità MovimentoSingMacOri il campo id_mov_ori NON DEVE essere impostato come automatico
                //Anche se sul db lo è
                movimentoSingMacOri.setIdMovOri(movimentoSingMac.getIdMovOri());

                movimentoSingMacOri.setIdMateriale(movimentoSingMac.getIdMateriale());
                movimentoSingMacOri.setTipoMateriale(movimentoSingMac.getTipoMateriale());
                movimentoSingMacOri.setQuantita(movimentoSingMac.getQuantita());
                movimentoSingMacOri.setCodIngressoComp(movimentoSingMac.getCodIngressoComp());
                movimentoSingMacOri.setCodOperatore(movimentoSingMac.getCodOperatore());
                movimentoSingMacOri.setOperazione(movimentoSingMac.getOperazione());
                movimentoSingMacOri.setProceduraAdottata(movimentoSingMac.getProceduraAdottata());
                movimentoSingMacOri.setTipoMov(movimentoSingMac.getTipoMov());
                movimentoSingMacOri.setDescriMov(movimentoSingMac.getDescriMov());
                movimentoSingMacOri.setDtMov(movimentoSingMac.getDtMov());
                movimentoSingMacOri.setSilo(movimentoSingMac.getSilo());
                movimentoSingMacOri.setPesoTeorico(movimentoSingMac.getPesoTeorico());
                movimentoSingMacOri.setIdCiclo(movimentoSingMac.getIdCiclo());
                movimentoSingMacOri.setDtInizioProcedura(movimentoSingMac.getDtInizioProcedura());
                movimentoSingMacOri.setDtFineProcedura(movimentoSingMac.getDtFineProcedura());
                movimentoSingMacOri.setAbilitato(movimentoSingMac.getAbilitato());
                movimentoSingMacOri.setInfo1(movimentoSingMac.getInfo1());
                movimentoSingMacOri.setInfo2(movimentoSingMac.getInfo2());
                movimentoSingMacOri.setInfo3(movimentoSingMac.getInfo3());
                movimentoSingMacOri.setInfo4(movimentoSingMac.getInfo4());
                movimentoSingMacOri.setInfo5(movimentoSingMac.getInfo5());
                movimentoSingMacOri.setInfo6(movimentoSingMac.getInfo6());
                movimentoSingMacOri.setInfo7(movimentoSingMac.getInfo7());
                movimentoSingMacOri.setInfo8(movimentoSingMac.getInfo8());
                movimentoSingMacOri.setInfo9(movimentoSingMac.getInfo9());
                movimentoSingMacOri.setInfo10(movimentoSingMac.getInfo10());
                movimentoSingMacOri.setOrigineMov(movimentoSingMac.getOrigineMov());

                aggiornamentoOriOut.getDaInserire().add(movimentoSingMacOri);
            }

            //Trasformazione di ComponentePesatura in ComponentePesatureOri
            if (obj instanceof ComponentePesatura) {
                ComponentePesatura componentePesatura = (ComponentePesatura) obj;
                ComponentePesaturaOri componentePesaturaOri = new ComponentePesaturaOri();

                componentePesaturaOri.setId(componentePesatura.getId());
                componentePesaturaOri.setIdProdotto(componentePesatura.getIdProdotto());
                componentePesaturaOri.setIdComp(componentePesatura.getIdComp());
                componentePesaturaOri.setMetodoPesa(componentePesatura.getMetodoPesa());
                componentePesaturaOri.setStepDosaggio(componentePesatura.getStepDosaggio());
                componentePesaturaOri.setOrdineDosaggio(componentePesatura.getOrdineDosaggio());
                componentePesaturaOri.setQuantita(componentePesatura.getQuantita());
                componentePesaturaOri.setTollDifetto(componentePesatura.getTollDifetto());
                componentePesaturaOri.setTollEccesso(componentePesatura.getTollEccesso());
                componentePesaturaOri.setFluidificazione(componentePesatura.getFluidificazione());
                componentePesaturaOri.setValoreResiduoFluidificazione(componentePesatura.getValoreResiduoFluidificazione());
                componentePesaturaOri.setNote(componentePesatura.getNote());
                componentePesaturaOri.setAbilitato(componentePesatura.getAbilitato());
                componentePesaturaOri.setDtAbilitato(componentePesatura.getDtAbilitato());
                componentePesaturaOri.setInfo1(componentePesatura.getInfo1());
                componentePesaturaOri.setInfo2(componentePesatura.getInfo2());
                componentePesaturaOri.setInfo3(componentePesatura.getInfo3());
                componentePesaturaOri.setInfo4(componentePesatura.getInfo4());
                componentePesaturaOri.setInfo5(componentePesatura.getInfo5());
                componentePesaturaOri.setInfo6(componentePesatura.getInfo6());
                componentePesaturaOri.setInfo7(componentePesatura.getInfo7());
                componentePesaturaOri.setInfo8(componentePesatura.getInfo8());
                componentePesaturaOri.setInfo9(componentePesatura.getInfo9());
                componentePesaturaOri.setInfo10(componentePesatura.getInfo10());
                componentePesaturaOri.setVelocitaMix(componentePesatura.getVelocitaMix());
                componentePesaturaOri.setTempoMix(componentePesatura.getTempoMix());

                aggiornamentoOriOut.getDaInserire().add(componentePesaturaOri);
            }

            //Trasformazione di FiguraTipo in FiguraTipoOri
            if (obj instanceof FiguraTipo) {
                FiguraTipo figuraTipo = (FiguraTipo) obj;

                FiguraTipoOri figuraTipoOri = new FiguraTipoOri();

                figuraTipoOri.setIdFiguraTipo(figuraTipo.getIdFiguraTipo());
                figuraTipoOri.setFigura(figuraTipo.getFigura());
                figuraTipoOri.setAbilitato(figuraTipo.getAbilitato());
                figuraTipoOri.setDtAbilitato(figuraTipo.getDtAbilitato());

                aggiornamentoOriOut.getDaInserire().add(figuraTipoOri);
            }

            //Trasformazione di Figura in FiguraOri
            if (obj instanceof Figura) {
                Figura figura = (Figura) obj;
                FiguraTipo figuraTipo = figura.getIdFiguraTipo();

                FiguraOri figuraOri = new FiguraOri();

                FiguraTipoOri figuraTipoOri = new FiguraTipoOri();
                figuraTipoOri.setIdFiguraTipo(figuraTipo.getIdFiguraTipo());

                figuraTipoOri.setFigura(figuraTipo.getFigura());
                figuraTipoOri.setAbilitato(figuraTipo.getAbilitato());
                figuraTipoOri.setDtAbilitato(figuraTipo.getDtAbilitato());

                figuraOri.setIdFiguraTipo(figuraTipoOri);
                figuraOri.setIdFigura(figura.getIdFigura());
                figuraOri.setNominativo(figura.getNominativo());
                figuraOri.setCodice(figura.getCodice());
                figuraOri.setDtAbilitato(figura.getDtAbilitato());
                figuraOri.setAbilitato(figura.getAbilitato());

                aggiornamentoOriOut.getDaInserire().add(figuraOri);
            }

        }

//        log.info("TRASFORMAZIONE DI Aggiornamento IN AggiornamentoOri EFFETTUATA:" + aggiornamentoOriOut);
        return aggiornamentoOriOut;

    }

    //#############################################################################
    //######################## METODI PER AGGIORNAMENTO IN ########################
    //#############################################################################
    /**
     * Metodo che valida i campi di un AggiornamentoOri proveniente dalla
     * macchina, tipo dell' aggiornamento
     *
     * @param Aggiornamento
     * @return true se l'oggetto è valido, false se non è valido
     * @throws
     * InvalidUpdateTypeException,InvalidUpdateContentException,InvalidUpdateVersionException
     */
//TODO : 0) Controllare che si  tratti di un oggetto di tipo AggiornamentoOri
//       1) Controllare che l'id della macchina sia corretto, 
//          quindi si può leggere dal nome del file prima di scaricarlo.
//       2) Controllare che il tipo dell'aggiornamento sia di tipo OUT per la macchina.
//       3) Controllare che la versione dell'aggiornamento sia successiva all'ultima versione 
//          presente nella tabella aggiornamento. Le versioni lato server e lato macchina coincidono
//          si può anche leggere dal nome del file
//       4) Gestire anche il caso del primo aggiornamento
    public static Boolean validaAggiornamentoIn(
            Object obj,
            String outFilePfx,
            String inFilePfx,
            MachineCredentials mc,
            EntityManagerFactory emf)
            throws
            InvalidUpdateContentException,
            InvalidUpdateVersionException,
            InvalidUpdateTypeException {

        AggiornamentoJpaController aggiornamentoJc = new AggiornamentoJpaController(null, emf);
        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);

        //Controllo che si tratti di un oggetto di tipo AggiornamentoOri
        //Eccezione bloccante
        if (!(obj instanceof AggiornamentoOri)) {
            throw new InvalidUpdateContentException("##### Oggetto diverso da AggiornamentoOri!");
        }
        AggiornamentoOri aggiornamentoOri = (AggiornamentoOri) obj;

        //Controllo che l'oggetto AggiornamentoOri da salvare abbia il tipo corretto
        //Eccezione bloccante
        if (!aggiornamentoOri.getTipo().equals(outFilePfx)) {
            throw new InvalidUpdateTypeException("##### Tipo di aggiornamento errato!");
        }

        //Recupero dal database l'ultima versione di aggiornamento di tipo IN
        Integer lastUpdateVersionIn = null;
        try {

            lastUpdateVersionIn = macchinaJc.findLastUpdateVersion(mc.getIdMacchina(), inFilePfx);

        } catch (NoResultException nre) {
            log.error("##### Nessun Risultato in findLastUpdateVersion IN");
        } catch (NonUniqueResultException nure) {
            log.error("##### Versione duplicata in findLastUpdateVersion IN ");
            throw nure;
        }

        //Se l'ultima versione presente nel db è null vuol dire che non sono presenti 
        //aggiornamenti nella tabella aggiornamento
        //Si sta effettuando il primo aggiornamento, dunque setto l'ultima versione a zero
        if (lastUpdateVersionIn == null) {
            lastUpdateVersionIn = 0;
        }

        //Controllo che l'oggetto AggiornamentoOri da salvare abbia la versione 
        //successiva all'ultima versione salvata nel db
        //Eccezione bloccante
        if (!aggiornamentoOri.getVersione().equals(lastUpdateVersionIn + 1)) {
            throw new InvalidUpdateVersionException("VERSIONE DELL'AGGIORNAMENTO IN ENTRATA :" + aggiornamentoOri.getVersione() + "; VERSIONE DELL'ULTIMO AGG REGISTRATO :" + lastUpdateVersionIn);
        }

        return true;

    }

    /**
     * Questo metodo viene eseguito lato server in fase di download dell'xml
     * proveniente dalla macchina in questo caso trasforma un aggiornamentoOri
     * in un aggiornamento
     *
     * @param aggiornamentoOri
     * @return aggiornamento di tipo IN
     * @throws AggiornamentoNotFoundException
     */
    public static Aggiornamento adattaAggiornamentoIn(AggiornamentoOri aggiornamentoOri,
            EntityManagerFactory emf,
            MachineCredentials mc,
            String inFilePfx) throws InvalidUpdateContentException {

        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
        Macchina mac = macchinaJc.findMacchina(mc.getIdMacchina());

        Aggiornamento aggiornamentoIn = new Aggiornamento();
        aggiornamentoIn.setTipo(inFilePfx);
        aggiornamentoIn.setVersione(aggiornamentoOri.getVersione());
        aggiornamentoIn.setIdMacchina(mac);

        ParametroRipristinoJpaController parametroRipristinoJc = new ParametroRipristinoJpaController(null, emf);
        ValoreRipristinoJpaController valoreRipristinoJc = new ValoreRipristinoJpaController(null, emf);
        ValoreParSingMacJpaController valoreParSingMacJc = new ValoreParSingMacJpaController(null, emf);
        ValoreParCompJpaController valoreParCompJc = new ValoreParCompJpaController(null, emf);
        ParametroGlobMacJpaController parametroGlobMacJc = new ParametroGlobMacJpaController(null, emf);

        OrdineSingMacJpaController ordineSingMacJc = new OrdineSingMacJpaController(null, emf);

        //ValoreAllarmeJpaController valoreAllarmeJc=new ValoreAllarmeJpaController(null, emf);
        AllarmeJpaController allarmeJc = new AllarmeJpaController(null, emf);

        CicloJpaController cicloJc = new CicloJpaController(null, emf);

        CicloProcessoJpaController cicloProcessoJc = new CicloProcessoJpaController(null, emf);

        Collection c = new ArrayList();
        aggiornamentoIn.setDaInserire(c);

        Macchina macchina = new Macchina();

        Integer syncSftwVersion = Integer.valueOf(mc.getSyncSoftwareVersion());//valore campo user_origami
        Integer machineSftwVersion = Integer.valueOf(mc.getMachineSoftwareVersion());
        Integer origamiDbVersion = Integer.valueOf(mc.getOrigamiDbVersion());

        //Eseguo una prima volta il ciclo for 
        //Cerco prima l'oggetto MacchinaOri
        for (Object obj : aggiornamentoOri.getDaInserire()) {

            //Trasformazione di MacchinaOri in Macchina
            //Utile per effettuare controlli sull''identità della macchina
            if (obj instanceof MacchinaOri) {

                MacchinaOri macchinaOri = (MacchinaOri) obj;

                macchina.setCodStab(macchinaOri.getCodStab());
                macchina.setDescriStab(macchinaOri.getDescriStab());
                macchina.setIdMacchina(macchinaOri.getIdMacchina());
                macchina.setPassOrigami(macchinaOri.getPassOrigami());
                macchina.setPassServer(macchinaOri.getPassServer());
                macchina.setRagso1(macchinaOri.getRagso1());
                macchina.setUserOrigami(macchinaOri.getUserOrigami());
                macchina.setUserServer(macchinaOri.getUserServer());

                aggiornamentoIn.getDaInserire().add(macchinaOri);
            }
        }

        //Codice di trasformazione 
        for (Object obj : aggiornamentoOri.getDaInserire()) {

            //Trasformazione di MazzettaColSingMacOri in MazzettaColSingMac
            if (obj instanceof MazzettaColSingMacOri) {
                MazzettaColSingMacOri mazzettaColSingMacOri = (MazzettaColSingMacOri) obj;
                MazzettaColSingMac mazzettaColSingMac = new MazzettaColSingMac();

//        //Prendo l'oggetto ColoreOri da mazzettaColSingMacOri e la trasformo in Colore 
//        //per poterlo settare dentro mazzettaColSingMac
//        ColoreOri coloreOri = new ColoreOri();
//        coloreOri = mazzettaColSingMacOri.getIdColore();
//        Colore colore = new Colore();
//        colore.setIdColore(coloreOri.getIdColore());
//        colore.setCodColore(coloreOri.getCodColore());
//        colore.setNomeColore(coloreOri.getNomeColore());
                //Prendo l'oggetto ColoreBaseOri da mazzettaColSingMacOri e la trasformo in ColoreBase 
                //per poterlo settare dentro mazzettaColSingMac
                ColoreBaseOri coloreBaseOri = new ColoreBaseOri();
                coloreBaseOri = mazzettaColSingMacOri.getIdColoreBase();

                ColoreBase coloreBase = new ColoreBase();
                coloreBase.setIdColoreBase(coloreBaseOri.getIdColoreBase());
                coloreBase.setCodColoreBase(coloreBaseOri.getCodColoreBase());
                coloreBase.setNomeColoreBase(coloreBaseOri.getNomeColoreBase());
                coloreBase.setCostoColoreBase(coloreBaseOri.getCostoColoreBase());

                //Prendo l'oggetto MazzettaOri da mazzettaColSingMacOri e la trasformo in Mazzetta 
                //per poterlo settare dentro mazzettaColSingMacOri
                MazzettaOri mazzettaOri = new MazzettaOri();
                mazzettaOri = mazzettaColSingMacOri.getIdMazzetta();

                Mazzetta mazzetta = new Mazzetta();
                mazzetta.setIdMazzetta(mazzettaOri.getIdMazzetta());
                mazzetta.setCodMazzetta(mazzettaOri.getCodMazzetta());
                mazzetta.setNomeMazzetta(mazzettaOri.getNomeMazzetta());

                MazzettaColSingMacPK mazzettaColSingMacPK = new MazzettaColSingMacPK();
                mazzettaColSingMacPK.setIdMacchina(macchina.getIdMacchina());
                mazzettaColSingMacPK.setIdMazSingMac(mazzettaColSingMacOri.getIdMazSingMac());

                mazzettaColSingMac.setCodColore(mazzettaColSingMacOri.getCodColore());
                mazzettaColSingMac.setIdColoreBase(coloreBase);
                mazzettaColSingMac.setIdMazzetta(mazzetta);
                mazzettaColSingMac.setQuantita(mazzettaColSingMacOri.getQuantita());
                mazzettaColSingMac.setAbilitato(mazzettaColSingMacOri.getAbilitato());

                //La dt_abilitato lato macchina diventa la dt_creazione_mac lato server
                mazzettaColSingMac.setDtCreazioneMac(mazzettaColSingMacOri.getDtAbilitato());
                mazzettaColSingMac.setMazzettaColSingMacPK(mazzettaColSingMacPK);

                aggiornamentoIn.getDaInserire().add(mazzettaColSingMac);

            }

            //Trasformazione di ValoreRipristinoOri in ValoreRipristino
            if (obj instanceof ValoreRipristinoOri) {
                //Creo un nuovo oggetto ValoreRipristino
                ValoreRipristinoOri valoreRipristinoOri = (ValoreRipristinoOri) obj;
                ValoreRipristino valoreRipristino = new ValoreRipristino();
                ValoreRipristinoPK valoreRipristinoPK = new ValoreRipristinoPK();

                valoreRipristinoPK.setIdMacchina(macchina.getIdMacchina());
                valoreRipristinoPK.setIdValoreRipristino(valoreRipristinoOri.getIdValoreRipristino());
                valoreRipristino.setValoreRipristinoPK(valoreRipristinoPK);

                ParametroRipristino parametroRipristino = null;

                parametroRipristino = parametroRipristinoJc.findParametroRipristino(valoreRipristinoOri.getIdParRipristino());

                if (parametroRipristinoJc == null) {
                    throw new InvalidUpdateContentException(" Attenzione l'oggetto ParametroRipristino che si intende aggiornare non è presente nel db!");
                }

                valoreRipristino.setIdParRipristino(parametroRipristino);
                valoreRipristino.setValoreVariabile(valoreRipristinoOri.getValoreVariabile());
                valoreRipristino.setDtRegistrato(valoreRipristinoOri.getDtRegistrato());
                //PROVARE
                //Assegno la data di default al campo dt_abilitato            
                valoreRipristino.setDtAbilitato(SyncOrigamiConstants.DATA_DEFAULT);

                valoreRipristino.setIdProCorso(valoreRipristinoOri.getIdProCorso());
                valoreRipristino.setDtAggMac(new Date());
                valoreRipristino.setAbilitato(valoreRipristinoOri.getAbilitato());

                aggiornamentoIn.getDaInserire().add(valoreRipristino);
            }

            //Trasformazione di ValoreParSingMacOri in ValoreParSingMac
            if (obj instanceof ValoreParSingMacOri) {

                ValoreParSingMacOri valoreParSingMacOri = (ValoreParSingMacOri) obj;
                //ValoreParSingMac valoreParSingMac = new ValoreParSingMac();
                //Anzicchè creare un oggetto ValoreParSingMac nuovo
                //Prendo dal db l'oggetto con l'id uguale a quello del ValoreParSingMacOri 
                //e gli modifico solo i campi valore_variabile dt_modifica_mac
                ValoreParSingMac valoreParSingMac = null;
                valoreParSingMac = valoreParSingMacJc.findValoreParSingMac(valoreParSingMacOri.getIdValParSm());

                if (valoreParSingMac == null) {
                    throw new InvalidUpdateContentException(" Attenzione l'oggetto ValoreParSingMac che si intende aggiornare non è presente nel db!");
                }

                valoreParSingMac.setDtModificaMac(valoreParSingMacOri.getDtModificaMac());
                valoreParSingMac.setValoreMac(valoreParSingMacOri.getValoreVariabile());
                valoreParSingMac.setDtAggMac(new Date());

                aggiornamentoIn.getDaInserire().add(valoreParSingMac);

            }

            //Trasformazione di ValoreParCompOri in ValoreParComp
            if (obj instanceof ValoreParCompOri) {
                log.info("@@TROVATO oggetto di tipo ValoreParCompOri nel file xml");
                ValoreParCompOri valoreParCompOri = (ValoreParCompOri) obj;
                //ValoreParSingMac valoreParSingMac = new ValoreParSingMac();
                //Anzicchè creare un oggetto ValoreParSingMac nuovo
                //Prendo dal db l'oggetto con l'id uguale a quello del ValoreParSingMacOri 
                //e gli modifico solo i campi valore_variabile dt_modifica_mac, valore_iniziale, dt_valore_iniziale
                ValoreParComp valoreParComp = null;
                valoreParComp = valoreParCompJc.findValoreParComp(valoreParCompOri.getIdValComp());

                if (valoreParComp == null) {
                    throw new InvalidUpdateContentException(" Attenzione l'oggetto ValoreParComp che si intende aggiornare non è presente nel db!");
                }

                valoreParComp.setDtModificaMac(valoreParCompOri.getDtModificaMac());
                valoreParComp.setDtValoreIniziale(valoreParCompOri.getDtValoreIniziale());
                valoreParComp.setValoreIniziale(valoreParCompOri.getValoreIniziale());
                valoreParComp.setValoreMac(valoreParCompOri.getValoreVariabile());
                valoreParComp.setDtAggMac(new Date());

                aggiornamentoIn.getDaInserire().add(valoreParComp);

            }

            //Trasformazione di ProcessoOri in Processo
            if (obj instanceof ProcessoOri) {
                ProcessoOri processoOri = (ProcessoOri) obj;
                Processo processo = new Processo();
                ProcessoPK processoPK = new ProcessoPK();
                processoPK.setCodStab(macchina.getCodStab());
                processoPK.setIdProcesso(processoOri.getIdProcesso());

                processo.setCliente(processoOri.getCliente());
                processo.setCodChimica(processoOri.getCodChimica());
                processo.setCodColore(processoOri.getCodColore());
                processo.setCodCompPeso(processoOri.getCodCompPeso());
                processo.setCodProdotto(processoOri.getCodProdotto());

                processo.setCodSacco(processoOri.getCodSacco());
                processo.setDescriStab(macchina.getDescriStab());
                processo.setDtProduzioneMac(processoOri.getDtProduzione());
                //######### NUOVI CAMPI 13-10-2014 #############################
                processo.setCodOperatore(processoOri.getCodOperatore());
                processo.setCodCompIn(processoOri.getCodCompIn());
                processo.setTipoProcesso(processoOri.getTipoProcesso());
                processo.setInfo1(processoOri.getInfo1());
                processo.setInfo2(processoOri.getInfo2());
                processo.setInfo3(processoOri.getInfo3());
                processo.setInfo4(processoOri.getInfo4());
                processo.setInfo5(processoOri.getInfo5());
                //##############################################################

                processo.setInfo6("");
                processo.setInfo7("");
                processo.setInfo8("");
                processo.setInfo9("");
                processo.setInfo10("");

                if (syncSftwVersion == 4 || (syncSftwVersion == 3 & origamiDbVersion.equals(4) & machineSftwVersion.equals(4))) {

                    processo.setInfo6(processoOri.getInfo6());
                    processo.setInfo7(processoOri.getInfo7());
                    processo.setInfo8(processoOri.getInfo8());
                    processo.setInfo9(processoOri.getInfo9());
                    processo.setInfo10(processoOri.getInfo10());
                }

                processo.setIdMacchina(macchina);
                processo.setPesoRealeSacco(processoOri.getPesoRealeSacco());
                processo.setProcessoPK(processoPK);

                aggiornamentoIn.getDaInserire().add(processo);

            }

            //Trasformazione di ValoreAllarmeOri in ValoreAllarme
            if (obj instanceof ValoreAllarmeOri) {

                ValoreAllarmeOri valoreAllarmeOri = (ValoreAllarmeOri) obj;
                //Creo un nuovo oggetto ValoreAllarme
                ValoreAllarme valoreAllarme = new ValoreAllarme();

                Allarme allarme = null;
                allarme = allarmeJc.findAllarme(valoreAllarmeOri.getIdAllarme());

                if (allarmeJc == null) {
                    throw new InvalidUpdateContentException("Attenzione l' oggetto Allarme che si intende aggiornare non è presente nel db!");
                }

                valoreAllarme.setId(valoreAllarmeOri.getId());
                valoreAllarme.setIdAllarme(allarme);
                valoreAllarme.setValore(valoreAllarmeOri.getValore());
                valoreAllarme.setAbilitato(valoreAllarmeOri.getAbilitato());
                valoreAllarme.setIdMacchina(macchina.getIdMacchina());
                valoreAllarme.setIdTabellaRif(valoreAllarmeOri.getIdTabellaRif());
                valoreAllarme.setDtAbilitato(valoreAllarmeOri.getDtAbilitato());
                valoreAllarme.setInfo1(valoreAllarmeOri.getInfo1());
                valoreAllarme.setInfo2(valoreAllarmeOri.getInfo2());
                valoreAllarme.setInfo3(valoreAllarmeOri.getInfo3());
                valoreAllarme.setInfo4(valoreAllarmeOri.getInfo4());
                valoreAllarme.setInfo5(valoreAllarmeOri.getInfo5());

                aggiornamentoIn.getDaInserire().add(valoreAllarme);
            }

            //Trasformazione di MovimentoSingMacOri in MovimentoSingMac
            if (obj instanceof MovimentoSingMacOri) {

                MovimentoSingMacOri movimentoSingMacOri = (MovimentoSingMacOri) obj;

                //Creo un nuovo oggetto MovimentoSingMac
                MovimentoSingMac movimentoSingMac = new MovimentoSingMac();

                movimentoSingMac.setIdMovOri(movimentoSingMacOri.getIdMovOri());
                movimentoSingMac.setIdMateriale(movimentoSingMacOri.getIdMateriale());
                movimentoSingMac.setTipoMateriale(movimentoSingMacOri.getTipoMateriale());
                movimentoSingMac.setQuantita(movimentoSingMacOri.getQuantita());
                movimentoSingMac.setCodIngressoComp(movimentoSingMacOri.getCodIngressoComp());
                movimentoSingMac.setCodOperatore(movimentoSingMacOri.getCodOperatore());
                movimentoSingMac.setOperazione(movimentoSingMacOri.getOperazione());
                movimentoSingMac.setProceduraAdottata(movimentoSingMacOri.getProceduraAdottata());
                movimentoSingMac.setTipoMov(movimentoSingMacOri.getTipoMov());
                movimentoSingMac.setDescriMov(movimentoSingMacOri.getDescriMov());
                movimentoSingMac.setDtMov(movimentoSingMacOri.getDtMov());
                movimentoSingMac.setSilo(movimentoSingMacOri.getSilo());
                movimentoSingMac.setDtAbilitato(new Date());
                movimentoSingMac.setIdMacchina(macchina.getIdMacchina());
                movimentoSingMac.setPesoTeorico(movimentoSingMacOri.getPesoTeorico());
                movimentoSingMac.setIdCiclo(movimentoSingMacOri.getIdCiclo());
                movimentoSingMac.setDtInizioProcedura(movimentoSingMacOri.getDtInizioProcedura());
                movimentoSingMac.setDtFineProcedura(movimentoSingMacOri.getDtFineProcedura());
                movimentoSingMac.setOrigineMov(movimentoSingMacOri.getOrigineMov());
                movimentoSingMac.setAbilitato(movimentoSingMacOri.getAbilitato());
                movimentoSingMac.setInfo1(movimentoSingMacOri.getInfo1());
                movimentoSingMac.setInfo2(movimentoSingMacOri.getInfo2());
                movimentoSingMac.setInfo3(movimentoSingMacOri.getInfo3());
                movimentoSingMac.setInfo4(movimentoSingMacOri.getInfo4());
                movimentoSingMac.setInfo5(movimentoSingMacOri.getInfo5());
                movimentoSingMac.setInfo6(movimentoSingMacOri.getInfo6());
                movimentoSingMac.setInfo7(movimentoSingMacOri.getInfo7());
                movimentoSingMac.setInfo8(movimentoSingMacOri.getInfo8());
                movimentoSingMac.setInfo9(movimentoSingMacOri.getInfo9());
                movimentoSingMac.setInfo10(movimentoSingMacOri.getInfo10());

                aggiornamentoIn.getDaInserire().add(movimentoSingMac);
            }

            //Trasformazione di CicloOri in Ciclo
            if (obj instanceof CicloOri) {

                CicloOri cicloOri = (CicloOri) obj;

                //Creo un nuovo oggetto Ciclo
                Ciclo ciclo = new Ciclo();

                ciclo.setIdMacchina(macchina.getIdMacchina());
                ciclo.setDtAggiornamento(new Date());
                ciclo.setIdCiclo(cicloOri.getIdCiclo());
                ciclo.setTipoCiclo(cicloOri.getTipoCiclo());
                ciclo.setDtInizioCiclo(cicloOri.getDtInizioCiclo());
                ciclo.setDtFineCiclo(cicloOri.getDtFineCiclo());
                ciclo.setIdOrdine(cicloOri.getIdOrdine());
                ciclo.setIdProdotto(cicloOri.getIdProdotto());
                ciclo.setIdCat(cicloOri.getIdCat());
                ciclo.setVelocitaMix(cicloOri.getVelocitaMix());
                ciclo.setTempoMix(cicloOri.getTempoMix());
                ciclo.setNumSacchi(cicloOri.getNumSacchi());
                ciclo.setNumSacchiAggiuntivi(cicloOri.getNumSacchiAggiuntivi());
                ciclo.setVibroAttivo(cicloOri.getVibroAttivo());
                ciclo.setAriaCondScarico(cicloOri.getAriaCondScarico());
                ciclo.setAriaInternoValvola(cicloOri.getAriaInternoValvola());
                ciclo.setAriaPulisciValvola(cicloOri.getAriaPulisciValvola());
                ciclo.setDtAbilitato(cicloOri.getDtAbilitato());
                ciclo.setIdSerieColore(cicloOri.getIdSerieColore());
                ciclo.setIdSerieAdditivo(cicloOri.getIdSerieAdditivo());
                ciclo.setInfo1(cicloOri.getInfo1());
                ciclo.setInfo2(cicloOri.getInfo2());
                ciclo.setInfo3(cicloOri.getInfo3());
                ciclo.setInfo4(cicloOri.getInfo4());
                ciclo.setInfo5(cicloOri.getInfo5());
                ciclo.setInfo6(cicloOri.getInfo6());
                ciclo.setInfo7(cicloOri.getInfo7());
                ciclo.setInfo8(cicloOri.getInfo8());
                ciclo.setInfo9(cicloOri.getInfo9());
                ciclo.setInfo10(cicloOri.getInfo10());

                aggiornamentoIn.getDaInserire().add(ciclo);
            }

            //Trasformazione di CicloProcessoOri in CicloProcesso
            if (obj instanceof CicloProcessoOri) {

                CicloProcessoOri cicloProcessoOri = (CicloProcessoOri) obj;

                //Creo un nuovo oggetto CicloProcesso
                CicloProcesso cicloProcesso = new CicloProcesso();

                cicloProcesso.setId(cicloProcessoOri.getId());
                cicloProcesso.setIdCiclo(cicloProcessoOri.getIdCiclo());
                cicloProcesso.setIdProcesso(cicloProcessoOri.getIdProcesso());
                cicloProcesso.setDtInizioProcesso(cicloProcessoOri.getDtInizioProcesso());
                cicloProcesso.setDtFineProcesso(cicloProcessoOri.getDtFineProcesso());
                cicloProcesso.setDtAbilitato(cicloProcessoOri.getDtAbilitato());
                cicloProcesso.setDtAggiornamento(new Date());
                cicloProcesso.setIdMacchina(macchina.getIdMacchina());
                cicloProcesso.setInfo1(cicloProcessoOri.getInfo1());
                cicloProcesso.setInfo2(cicloProcessoOri.getInfo2());
                cicloProcesso.setInfo3(cicloProcessoOri.getInfo3());
                cicloProcesso.setInfo4(cicloProcessoOri.getInfo4());
                cicloProcesso.setInfo5(cicloProcessoOri.getInfo5());
                cicloProcesso.setInfo6(cicloProcessoOri.getInfo6());
                cicloProcesso.setInfo7(cicloProcessoOri.getInfo7());
                cicloProcesso.setInfo8(cicloProcessoOri.getInfo8());
                cicloProcesso.setInfo9(cicloProcessoOri.getInfo9());
                cicloProcesso.setInfo10(cicloProcessoOri.getInfo10());

                aggiornamentoIn.getDaInserire().add(cicloProcesso);
            }

            //DescriStato=PROCESSED
            Integer idParDescriStatoProcessed = 141;
            String strParDescriStatoProcessed = "";
            strParDescriStatoProcessed = parametroGlobMacJc.findParametroGlobMac(idParDescriStatoProcessed).getValoreVariabile();

            //DescriStato=TO PRODUCE
            Integer idParDescriStatoToProduce = 143;
            String strParDescriStatoToProduce = "";
            strParDescriStatoToProduce = parametroGlobMacJc.findParametroGlobMac(idParDescriStatoToProduce).getValoreVariabile();

            //DescriStato=SKIPPED
            Integer idParDescriStatoSkipped = 142;
            String strParDescriStatoSkipped = "";
            strParDescriStatoSkipped = parametroGlobMacJc.findParametroGlobMac(idParDescriStatoSkipped).getValoreVariabile();

            //Trasformazione di OrdineSingMacOri in OrdineSingMac
            if (obj instanceof OrdineSingMacOri) {

                OrdineSingMacOri ordineSingMacOri = (OrdineSingMacOri) obj;

                //Anzicchè creare un oggetto OrdineSingMac nuovo
                //Prendo dal db l'oggetto con l'id uguale a quello del OrdineSingMacOri 
                //e gli modifico solo i campi stato e dt_produzione
                OrdineSingMac ordineSingMac = null;
                ordineSingMac = ordineSingMacJc.findOrdineSingMac(ordineSingMacOri.getIdOrdineSm());

                if (ordineSingMac == null) {
                    throw new InvalidUpdateContentException("Attenzione l'oggetto ordineSingMac che si intende aggiornare non è presente nel db!");
                }

                ordineSingMac.setStato(ordineSingMacOri.getStato());

                int stato = Integer.parseInt(ordineSingMacOri.getStato());

                switch (stato) {
                    case 0: {

                        ordineSingMac.setDescriStato(strParDescriStatoToProduce);

                        break;
                    }
                    case 1: {

                        ordineSingMac.setDescriStato(strParDescriStatoProcessed);

                        break;
                    }
                    case -1: {

                        ordineSingMac.setDescriStato(strParDescriStatoSkipped);

                        break;
                    }
                    default: {

                        ordineSingMac.setDescriStato("");
                        break;
                    }
                }

                //Settare la descrizione
                ordineSingMac.setDtProduzione(ordineSingMacOri.getDtProduzione());

                aggiornamentoIn.getDaInserire().add(ordineSingMac);
            }

        }

//        for (Object obj : aggiornamentoIn.getDaInserire()) {
//            log.info("Dati Macchina :" + obj.toString());
//        }
        return aggiornamentoIn;
    }

    public static void salvaDatiAggiornamentoIn(Aggiornamento aggiornamento, EntityManagerFactory emf)
            throws NonexistentEntityException,
            Exception {

        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
        ProcessoJpaController processoJc = new ProcessoJpaController(null, emf);
        MazzettaColSingMacJpaController mazzettaColSingMacJc = new MazzettaColSingMacJpaController(null, emf);
        ValoreRipristinoJpaController valoreRipristinoJc = new ValoreRipristinoJpaController(null, emf);
        ValoreParSingMacJpaController valoreParSingMacJc = new ValoreParSingMacJpaController(null, emf);
        ValoreParCompJpaController valoreParCompJc = new ValoreParCompJpaController(null, emf);

        ValoreAllarmeJpaController valoreAllarmeJc = new ValoreAllarmeJpaController(null, emf);
        MovimentoSingMacJpaController movimentoSingMacJc = new MovimentoSingMacJpaController(null, emf);
        CicloJpaController cicloJc = new CicloJpaController(null, emf);
        CicloProcessoJpaController cicloProcessoJc = new CicloProcessoJpaController(null, emf);
        OrdineSingMacJpaController ordineSingMacJc = new OrdineSingMacJpaController(null, emf);

        log.info("################ INIZIO SALVATAGGIO DATI AGGIORNAMENTO ######################");

        //Cancello i valori di ripristino esistenti sul server prima di salvare quelli provenienti dalla macchina
        Collection<ValoreRipristino> valoreRipristinoColl = null;
        valoreRipristinoColl = valoreRipristinoJc.findAllValoreRipristino(aggiornamento.getIdMacchina().getIdMacchina());

        if (valoreRipristinoColl != null) {
            for (Object o : valoreRipristinoColl) {
                ValoreRipristino valoreRip = (ValoreRipristino) o;
                valoreRipristinoJc.destroy(valoreRip.getValoreRipristinoPK());
            }
        }
        int countProcessiAgg = 0;
        int countMazColSingMacAgg = 0;
        int countVaRipristinoAgg = 0;
        int countValoreParSingMacAgg = 0;
        int countValoreParCompAgg = 0;
        int countValoreAllarmeAgg = 0;
        int countMovimentoSingMacAgg = 0;
        int countCicloAgg = 0;
        int countCicloProcessoAgg = 0;
        int countOrdineSingMacAgg = 0;

        for (Object obj : aggiornamento.getDaInserire()) {

            if (obj instanceof MazzettaColSingMac) {
                MazzettaColSingMac mazzettaColSingMac = (MazzettaColSingMac) obj;
                mazzettaColSingMacJc.merge(mazzettaColSingMac);
                countMazColSingMacAgg++;
            }
            if (obj instanceof ValoreRipristino) {
                ValoreRipristino valoreRipristino = (ValoreRipristino) obj;
                valoreRipristinoJc.create(valoreRipristino);
                countVaRipristinoAgg++;
            }
            //TODO : forse è il caso di istanziare un nuovo oggetto  ValoreParSingMacOri 
            //settando solo i campi che si intendono modificare e poi salvarlo      
            if (obj instanceof ValoreParSingMac) {
                ValoreParSingMac valoreParSingMac = (ValoreParSingMac) obj;
                valoreParSingMacJc.edit(valoreParSingMac);
                countValoreParSingMacAgg++;
            }
            if (obj instanceof ValoreParComp) {
                ValoreParComp valoreParComp = (ValoreParComp) obj;
                valoreParCompJc.edit(valoreParComp);
                countValoreParCompAgg++;
            }
            //Faccio un insert in questo caso
            if (obj instanceof ValoreAllarme) {
                ValoreAllarme valoreAllarme = (ValoreAllarme) obj;
                valoreAllarmeJc.create(valoreAllarme);
                countValoreAllarmeAgg++;
            }
            if (obj instanceof MovimentoSingMac) {
                MovimentoSingMac movimentoSingMac = (MovimentoSingMac) obj;
                //Valutare se fare il merge.. ma attenzione perchè la chiave è id_mov_inephos
                movimentoSingMacJc.create(movimentoSingMac);
                //movimentoSingMacJc.create(movimentoSingMac);
                countMovimentoSingMacAgg++;
            }
            if (obj instanceof Ciclo) {
                Ciclo ciclo = (Ciclo) obj;
               // cicloJc.create(ciclo);
                cicloJc.merge(ciclo);
                countCicloAgg++;
            }
            if (obj instanceof Processo) {
                Processo processo = (Processo) obj;
                processoJc.merge(processo);
                countProcessiAgg++;
            }

            if (obj instanceof CicloProcesso) {
                CicloProcesso cicloProcesso = (CicloProcesso) obj;
                cicloProcessoJc.merge(cicloProcesso);
                countCicloProcessoAgg++;
            }

            if (obj instanceof OrdineSingMac) {
                OrdineSingMac ordineSingMac = (OrdineSingMac) obj;
                ordineSingMacJc.edit(ordineSingMac);
                countOrdineSingMacAgg++;
            }

        }

        log.info("Numero di oggetii Processo salvati : " + countProcessiAgg);
        log.info("Numero di oggetti MazzettaColorataSingolaMacchina salvati : " + countMazColSingMacAgg);
        log.info("Numero di oggetti ValoreRipristino salvati : " + countVaRipristinoAgg);
        log.info("Numero di oggetti ValoreParSingMac salvati : " + countValoreParSingMacAgg++);
        log.info("Numero di oggetti ValoreParComp salvati : " + countValoreParCompAgg);

        log.info("Numero di oggetti ValoreAllarme salvati : " + countValoreAllarmeAgg);
        log.info("Numero di oggetti MovimentoSingMac salvati : " + countMovimentoSingMacAgg);
        log.info("Numero di oggetti Ciclo salvati : " + countCicloAgg);
        log.info("Numero di oggetti CicloProcesso salvati : " + countCicloProcessoAgg);
        log.info("Numero di oggetti OrdineSingMacAgg salvati : " + countOrdineSingMacAgg);

        log.info("################# FINE SALVATAGGIO DATI SUL SERVER ####################");

    }

    /**
     * Metodo che salva l'oggetto Aggiornamento nella tabella aggiornamento di
     * serverdb
     *
     * @param aggiornamento
     */
    public static void salvaAggiornamentoIn(
            Aggiornamento aggiornamento,
            EntityManagerFactory emf,
            MachineCredentials mc) {

        AggiornamentoJpaController aggiornamentoJc = new AggiornamentoJpaController(null, emf);

        MacchinaJpaController macchinaJc = new MacchinaJpaController(null, emf);
        Macchina macchina = macchinaJc.findMacchina(mc.getIdMacchina());
        //Setto la data corrente dell'aggiornamento
        aggiornamento.setDtAggiornamento(new Date());
        //aggiornamento.setIdMacchina(macchina);
        log.info("##mc.getCurrentUpdateFileNameCompletePath()" + mc.getCurrentUpdateFileNameCompletePath());
        aggiornamento.setNomeFile(mc.getCurrentUpdateFileNameCompletePath());

        aggiornamentoJc.create(aggiornamento);
        log.info("################# SALVATO AGGIORNAMENTO IN ENTRATA SUL SERVER ####################");

    }

}
