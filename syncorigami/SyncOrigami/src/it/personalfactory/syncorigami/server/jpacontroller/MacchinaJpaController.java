/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package it.personalfactory.syncorigami.server.jpacontroller;

import it.personalfactory.syncorigami.server.entity.*;
import java.io.Serializable;
import javax.persistence.Query;
import javax.persistence.EntityNotFoundException;
import java.util.ArrayList;
import java.util.Collection;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.IllegalOrphanException;
import it.personalfactory.syncorigami.server.jpacontroller.exceptions.NonexistentEntityException;
import java.util.List;
import javax.persistence.*;
import javax.transaction.UserTransaction;
import org.apache.log4j.Logger;

/**
 *
 * @author Marilisa Tassone
 */
public class MacchinaJpaController implements Serializable {

    Logger log = Logger.getLogger(MacchinaJpaController.class);
    
    public MacchinaJpaController(UserTransaction utx, EntityManagerFactory emf) {
        this.utx = utx;
        this.emf = emf;
    }
    private UserTransaction utx = null;
    private EntityManagerFactory emf = null;

    public EntityManager getEntityManager() {
        return emf.createEntityManager();
    }

    public void create(Macchina macchina) {
        if (macchina.getBollaCollection() == null) {
            macchina.setBollaCollection(new ArrayList<Bolla>());
        }
        if (macchina.getProcessoCollection() == null) {
            macchina.setProcessoCollection(new ArrayList<Processo>());
        }
        if (macchina.getValoreParSingMacCollection() == null) {
            macchina.setValoreParSingMacCollection(new ArrayList<ValoreParSingMac>());
        }
        if (macchina.getAggiornamentoCollection() == null) {
            macchina.setAggiornamentoCollection(new ArrayList<Aggiornamento>());
        }
        if (macchina.getAnagrafeMacchinaCollection() == null) {
            macchina.setAnagrafeMacchinaCollection(new ArrayList<AnagrafeMacchina>());
        }
        if (macchina.getValoreParCompCollection() == null) {
            macchina.setValoreParCompCollection(new ArrayList<ValoreParComp>());
        }
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Collection<Bolla> attachedBollaCollection = new ArrayList<Bolla>();
            for (Bolla bollaCollectionBollaToAttach : macchina.getBollaCollection()) {
                bollaCollectionBollaToAttach = em.getReference(bollaCollectionBollaToAttach.getClass(), bollaCollectionBollaToAttach.getIdBolla());
                attachedBollaCollection.add(bollaCollectionBollaToAttach);
            }
            macchina.setBollaCollection(attachedBollaCollection);
            Collection<Processo> attachedProcessoCollection = new ArrayList<Processo>();
            for (Processo processoCollectionProcessoToAttach : macchina.getProcessoCollection()) {
                processoCollectionProcessoToAttach = em.getReference(processoCollectionProcessoToAttach.getClass(), processoCollectionProcessoToAttach.getProcessoPK());
                attachedProcessoCollection.add(processoCollectionProcessoToAttach);
            }
            macchina.setProcessoCollection(attachedProcessoCollection);
            Collection<ValoreParSingMac> attachedValoreParSingMacCollection = new ArrayList<ValoreParSingMac>();
            for (ValoreParSingMac valoreParSingMacCollectionValoreParSingMacToAttach : macchina.getValoreParSingMacCollection()) {
                valoreParSingMacCollectionValoreParSingMacToAttach = em.getReference(valoreParSingMacCollectionValoreParSingMacToAttach.getClass(), valoreParSingMacCollectionValoreParSingMacToAttach.getIdValParSm());
                attachedValoreParSingMacCollection.add(valoreParSingMacCollectionValoreParSingMacToAttach);
            }
            macchina.setValoreParSingMacCollection(attachedValoreParSingMacCollection);
            Collection<Aggiornamento> attachedAggiornamentoCollection = new ArrayList<Aggiornamento>();
            for (Aggiornamento aggiornamentoCollectionAggiornamentoToAttach : macchina.getAggiornamentoCollection()) {
                aggiornamentoCollectionAggiornamentoToAttach = em.getReference(aggiornamentoCollectionAggiornamentoToAttach.getClass(), aggiornamentoCollectionAggiornamentoToAttach.getId());
                attachedAggiornamentoCollection.add(aggiornamentoCollectionAggiornamentoToAttach);
            }
            macchina.setAggiornamentoCollection(attachedAggiornamentoCollection);
            Collection<AnagrafeMacchina> attachedAnagrafeMacchinaCollection = new ArrayList<AnagrafeMacchina>();
            for (AnagrafeMacchina anagrafeMacchinaCollectionAnagrafeMacchinaToAttach : macchina.getAnagrafeMacchinaCollection()) {
                anagrafeMacchinaCollectionAnagrafeMacchinaToAttach = em.getReference(anagrafeMacchinaCollectionAnagrafeMacchinaToAttach.getClass(), anagrafeMacchinaCollectionAnagrafeMacchinaToAttach.getIdAnMac());
                attachedAnagrafeMacchinaCollection.add(anagrafeMacchinaCollectionAnagrafeMacchinaToAttach);
            }
            macchina.setAnagrafeMacchinaCollection(attachedAnagrafeMacchinaCollection);
            Collection<ValoreParComp> attachedValoreParCompCollection = new ArrayList<ValoreParComp>();
            for (ValoreParComp valoreParCompCollectionValoreParCompToAttach : macchina.getValoreParCompCollection()) {
                valoreParCompCollectionValoreParCompToAttach = em.getReference(valoreParCompCollectionValoreParCompToAttach.getClass(), valoreParCompCollectionValoreParCompToAttach.getIdValComp());
                attachedValoreParCompCollection.add(valoreParCompCollectionValoreParCompToAttach);
            }
            macchina.setValoreParCompCollection(attachedValoreParCompCollection);
            em.persist(macchina);
            for (Bolla bollaCollectionBolla : macchina.getBollaCollection()) {
                Macchina oldIdMacchinaOfBollaCollectionBolla = bollaCollectionBolla.getIdMacchina();
                bollaCollectionBolla.setIdMacchina(macchina);
                bollaCollectionBolla = em.merge(bollaCollectionBolla);
                if (oldIdMacchinaOfBollaCollectionBolla != null) {
                    oldIdMacchinaOfBollaCollectionBolla.getBollaCollection().remove(bollaCollectionBolla);
                    oldIdMacchinaOfBollaCollectionBolla = em.merge(oldIdMacchinaOfBollaCollectionBolla);
                }
            }
            for (Processo processoCollectionProcesso : macchina.getProcessoCollection()) {
                Macchina oldIdMacchinaOfProcessoCollectionProcesso = processoCollectionProcesso.getIdMacchina();
                processoCollectionProcesso.setIdMacchina(macchina);
                processoCollectionProcesso = em.merge(processoCollectionProcesso);
                if (oldIdMacchinaOfProcessoCollectionProcesso != null) {
                    oldIdMacchinaOfProcessoCollectionProcesso.getProcessoCollection().remove(processoCollectionProcesso);
                    oldIdMacchinaOfProcessoCollectionProcesso = em.merge(oldIdMacchinaOfProcessoCollectionProcesso);
                }
            }
            for (ValoreParSingMac valoreParSingMacCollectionValoreParSingMac : macchina.getValoreParSingMacCollection()) {
                Macchina oldIdMacchinaOfValoreParSingMacCollectionValoreParSingMac = valoreParSingMacCollectionValoreParSingMac.getIdMacchina();
                valoreParSingMacCollectionValoreParSingMac.setIdMacchina(macchina);
                valoreParSingMacCollectionValoreParSingMac = em.merge(valoreParSingMacCollectionValoreParSingMac);
                if (oldIdMacchinaOfValoreParSingMacCollectionValoreParSingMac != null) {
                    oldIdMacchinaOfValoreParSingMacCollectionValoreParSingMac.getValoreParSingMacCollection().remove(valoreParSingMacCollectionValoreParSingMac);
                    oldIdMacchinaOfValoreParSingMacCollectionValoreParSingMac = em.merge(oldIdMacchinaOfValoreParSingMacCollectionValoreParSingMac);
                }
            }
            for (Aggiornamento aggiornamentoCollectionAggiornamento : macchina.getAggiornamentoCollection()) {
                Macchina oldIdMacchinaOfAggiornamentoCollectionAggiornamento = aggiornamentoCollectionAggiornamento.getIdMacchina();
                aggiornamentoCollectionAggiornamento.setIdMacchina(macchina);
                aggiornamentoCollectionAggiornamento = em.merge(aggiornamentoCollectionAggiornamento);
                if (oldIdMacchinaOfAggiornamentoCollectionAggiornamento != null) {
                    oldIdMacchinaOfAggiornamentoCollectionAggiornamento.getAggiornamentoCollection().remove(aggiornamentoCollectionAggiornamento);
                    oldIdMacchinaOfAggiornamentoCollectionAggiornamento = em.merge(oldIdMacchinaOfAggiornamentoCollectionAggiornamento);
                }
            }
            for (AnagrafeMacchina anagrafeMacchinaCollectionAnagrafeMacchina : macchina.getAnagrafeMacchinaCollection()) {
                Macchina oldIdMacchinaOfAnagrafeMacchinaCollectionAnagrafeMacchina = anagrafeMacchinaCollectionAnagrafeMacchina.getIdMacchina();
                anagrafeMacchinaCollectionAnagrafeMacchina.setIdMacchina(macchina);
                anagrafeMacchinaCollectionAnagrafeMacchina = em.merge(anagrafeMacchinaCollectionAnagrafeMacchina);
                if (oldIdMacchinaOfAnagrafeMacchinaCollectionAnagrafeMacchina != null) {
                    oldIdMacchinaOfAnagrafeMacchinaCollectionAnagrafeMacchina.getAnagrafeMacchinaCollection().remove(anagrafeMacchinaCollectionAnagrafeMacchina);
                    oldIdMacchinaOfAnagrafeMacchinaCollectionAnagrafeMacchina = em.merge(oldIdMacchinaOfAnagrafeMacchinaCollectionAnagrafeMacchina);
                }
            }
            for (ValoreParComp valoreParCompCollectionValoreParComp : macchina.getValoreParCompCollection()) {
                Macchina oldIdMacchinaOfValoreParCompCollectionValoreParComp = valoreParCompCollectionValoreParComp.getIdMacchina();
                valoreParCompCollectionValoreParComp.setIdMacchina(macchina);
                valoreParCompCollectionValoreParComp = em.merge(valoreParCompCollectionValoreParComp);
                if (oldIdMacchinaOfValoreParCompCollectionValoreParComp != null) {
                    oldIdMacchinaOfValoreParCompCollectionValoreParComp.getValoreParCompCollection().remove(valoreParCompCollectionValoreParComp);
                    oldIdMacchinaOfValoreParCompCollectionValoreParComp = em.merge(oldIdMacchinaOfValoreParCompCollectionValoreParComp);
                }
            }
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void edit(Macchina macchina) throws IllegalOrphanException, NonexistentEntityException, Exception {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Macchina persistentMacchina = em.find(Macchina.class, macchina.getIdMacchina());
            Collection<Bolla> bollaCollectionOld = persistentMacchina.getBollaCollection();
            Collection<Bolla> bollaCollectionNew = macchina.getBollaCollection();
            Collection<Processo> processoCollectionOld = persistentMacchina.getProcessoCollection();
            Collection<Processo> processoCollectionNew = macchina.getProcessoCollection();
            Collection<ValoreParSingMac> valoreParSingMacCollectionOld = persistentMacchina.getValoreParSingMacCollection();
            Collection<ValoreParSingMac> valoreParSingMacCollectionNew = macchina.getValoreParSingMacCollection();
            Collection<Aggiornamento> aggiornamentoCollectionOld = persistentMacchina.getAggiornamentoCollection();
            Collection<Aggiornamento> aggiornamentoCollectionNew = macchina.getAggiornamentoCollection();
            Collection<AnagrafeMacchina> anagrafeMacchinaCollectionOld = persistentMacchina.getAnagrafeMacchinaCollection();
            Collection<AnagrafeMacchina> anagrafeMacchinaCollectionNew = macchina.getAnagrafeMacchinaCollection();
            Collection<ValoreParComp> valoreParCompCollectionOld = persistentMacchina.getValoreParCompCollection();
            Collection<ValoreParComp> valoreParCompCollectionNew = macchina.getValoreParCompCollection();
            List<String> illegalOrphanMessages = null;
            for (Bolla bollaCollectionOldBolla : bollaCollectionOld) {
                if (!bollaCollectionNew.contains(bollaCollectionOldBolla)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Bolla " + bollaCollectionOldBolla + " since its idMacchina field is not nullable.");
                }
            }
            for (Processo processoCollectionOldProcesso : processoCollectionOld) {
                if (!processoCollectionNew.contains(processoCollectionOldProcesso)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Processo " + processoCollectionOldProcesso + " since its idMacchina field is not nullable.");
                }
            }
            for (ValoreParSingMac valoreParSingMacCollectionOldValoreParSingMac : valoreParSingMacCollectionOld) {
                if (!valoreParSingMacCollectionNew.contains(valoreParSingMacCollectionOldValoreParSingMac)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain ValoreParSingMac " + valoreParSingMacCollectionOldValoreParSingMac + " since its idMacchina field is not nullable.");
                }
            }
            for (Aggiornamento aggiornamentoCollectionOldAggiornamento : aggiornamentoCollectionOld) {
                if (!aggiornamentoCollectionNew.contains(aggiornamentoCollectionOldAggiornamento)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain Aggiornamento " + aggiornamentoCollectionOldAggiornamento + " since its idMacchina field is not nullable.");
                }
            }
            for (AnagrafeMacchina anagrafeMacchinaCollectionOldAnagrafeMacchina : anagrafeMacchinaCollectionOld) {
                if (!anagrafeMacchinaCollectionNew.contains(anagrafeMacchinaCollectionOldAnagrafeMacchina)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain AnagrafeMacchina " + anagrafeMacchinaCollectionOldAnagrafeMacchina + " since its idMacchina field is not nullable.");
                }
            }
            for (ValoreParComp valoreParCompCollectionOldValoreParComp : valoreParCompCollectionOld) {
                if (!valoreParCompCollectionNew.contains(valoreParCompCollectionOldValoreParComp)) {
                    if (illegalOrphanMessages == null) {
                        illegalOrphanMessages = new ArrayList<String>();
                    }
                    illegalOrphanMessages.add("You must retain ValoreParComp " + valoreParCompCollectionOldValoreParComp + " since its idMacchina field is not nullable.");
                }
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            Collection<Bolla> attachedBollaCollectionNew = new ArrayList<Bolla>();
            for (Bolla bollaCollectionNewBollaToAttach : bollaCollectionNew) {
                bollaCollectionNewBollaToAttach = em.getReference(bollaCollectionNewBollaToAttach.getClass(), bollaCollectionNewBollaToAttach.getIdBolla());
                attachedBollaCollectionNew.add(bollaCollectionNewBollaToAttach);
            }
            bollaCollectionNew = attachedBollaCollectionNew;
            macchina.setBollaCollection(bollaCollectionNew);
            Collection<Processo> attachedProcessoCollectionNew = new ArrayList<Processo>();
            for (Processo processoCollectionNewProcessoToAttach : processoCollectionNew) {
                processoCollectionNewProcessoToAttach = em.getReference(processoCollectionNewProcessoToAttach.getClass(), processoCollectionNewProcessoToAttach.getProcessoPK());
                attachedProcessoCollectionNew.add(processoCollectionNewProcessoToAttach);
            }
            processoCollectionNew = attachedProcessoCollectionNew;
            macchina.setProcessoCollection(processoCollectionNew);
            Collection<ValoreParSingMac> attachedValoreParSingMacCollectionNew = new ArrayList<ValoreParSingMac>();
            for (ValoreParSingMac valoreParSingMacCollectionNewValoreParSingMacToAttach : valoreParSingMacCollectionNew) {
                valoreParSingMacCollectionNewValoreParSingMacToAttach = em.getReference(valoreParSingMacCollectionNewValoreParSingMacToAttach.getClass(), valoreParSingMacCollectionNewValoreParSingMacToAttach.getIdValParSm());
                attachedValoreParSingMacCollectionNew.add(valoreParSingMacCollectionNewValoreParSingMacToAttach);
            }
            valoreParSingMacCollectionNew = attachedValoreParSingMacCollectionNew;
            macchina.setValoreParSingMacCollection(valoreParSingMacCollectionNew);
            Collection<Aggiornamento> attachedAggiornamentoCollectionNew = new ArrayList<Aggiornamento>();
            for (Aggiornamento aggiornamentoCollectionNewAggiornamentoToAttach : aggiornamentoCollectionNew) {
                aggiornamentoCollectionNewAggiornamentoToAttach = em.getReference(aggiornamentoCollectionNewAggiornamentoToAttach.getClass(), aggiornamentoCollectionNewAggiornamentoToAttach.getId());
                attachedAggiornamentoCollectionNew.add(aggiornamentoCollectionNewAggiornamentoToAttach);
            }
            aggiornamentoCollectionNew = attachedAggiornamentoCollectionNew;
            macchina.setAggiornamentoCollection(aggiornamentoCollectionNew);
            Collection<AnagrafeMacchina> attachedAnagrafeMacchinaCollectionNew = new ArrayList<AnagrafeMacchina>();
            for (AnagrafeMacchina anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach : anagrafeMacchinaCollectionNew) {
                anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach = em.getReference(anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach.getClass(), anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach.getIdAnMac());
                attachedAnagrafeMacchinaCollectionNew.add(anagrafeMacchinaCollectionNewAnagrafeMacchinaToAttach);
            }
            anagrafeMacchinaCollectionNew = attachedAnagrafeMacchinaCollectionNew;
            macchina.setAnagrafeMacchinaCollection(anagrafeMacchinaCollectionNew);
            Collection<ValoreParComp> attachedValoreParCompCollectionNew = new ArrayList<ValoreParComp>();
            for (ValoreParComp valoreParCompCollectionNewValoreParCompToAttach : valoreParCompCollectionNew) {
                valoreParCompCollectionNewValoreParCompToAttach = em.getReference(valoreParCompCollectionNewValoreParCompToAttach.getClass(), valoreParCompCollectionNewValoreParCompToAttach.getIdValComp());
                attachedValoreParCompCollectionNew.add(valoreParCompCollectionNewValoreParCompToAttach);
            }
            valoreParCompCollectionNew = attachedValoreParCompCollectionNew;
            macchina.setValoreParCompCollection(valoreParCompCollectionNew);
            macchina = em.merge(macchina);
            for (Bolla bollaCollectionNewBolla : bollaCollectionNew) {
                if (!bollaCollectionOld.contains(bollaCollectionNewBolla)) {
                    Macchina oldIdMacchinaOfBollaCollectionNewBolla = bollaCollectionNewBolla.getIdMacchina();
                    bollaCollectionNewBolla.setIdMacchina(macchina);
                    bollaCollectionNewBolla = em.merge(bollaCollectionNewBolla);
                    if (oldIdMacchinaOfBollaCollectionNewBolla != null && !oldIdMacchinaOfBollaCollectionNewBolla.equals(macchina)) {
                        oldIdMacchinaOfBollaCollectionNewBolla.getBollaCollection().remove(bollaCollectionNewBolla);
                        oldIdMacchinaOfBollaCollectionNewBolla = em.merge(oldIdMacchinaOfBollaCollectionNewBolla);
                    }
                }
            }
            for (Processo processoCollectionNewProcesso : processoCollectionNew) {
                if (!processoCollectionOld.contains(processoCollectionNewProcesso)) {
                    Macchina oldIdMacchinaOfProcessoCollectionNewProcesso = processoCollectionNewProcesso.getIdMacchina();
                    processoCollectionNewProcesso.setIdMacchina(macchina);
                    processoCollectionNewProcesso = em.merge(processoCollectionNewProcesso);
                    if (oldIdMacchinaOfProcessoCollectionNewProcesso != null && !oldIdMacchinaOfProcessoCollectionNewProcesso.equals(macchina)) {
                        oldIdMacchinaOfProcessoCollectionNewProcesso.getProcessoCollection().remove(processoCollectionNewProcesso);
                        oldIdMacchinaOfProcessoCollectionNewProcesso = em.merge(oldIdMacchinaOfProcessoCollectionNewProcesso);
                    }
                }
            }
            for (ValoreParSingMac valoreParSingMacCollectionNewValoreParSingMac : valoreParSingMacCollectionNew) {
                if (!valoreParSingMacCollectionOld.contains(valoreParSingMacCollectionNewValoreParSingMac)) {
                    Macchina oldIdMacchinaOfValoreParSingMacCollectionNewValoreParSingMac = valoreParSingMacCollectionNewValoreParSingMac.getIdMacchina();
                    valoreParSingMacCollectionNewValoreParSingMac.setIdMacchina(macchina);
                    valoreParSingMacCollectionNewValoreParSingMac = em.merge(valoreParSingMacCollectionNewValoreParSingMac);
                    if (oldIdMacchinaOfValoreParSingMacCollectionNewValoreParSingMac != null && !oldIdMacchinaOfValoreParSingMacCollectionNewValoreParSingMac.equals(macchina)) {
                        oldIdMacchinaOfValoreParSingMacCollectionNewValoreParSingMac.getValoreParSingMacCollection().remove(valoreParSingMacCollectionNewValoreParSingMac);
                        oldIdMacchinaOfValoreParSingMacCollectionNewValoreParSingMac = em.merge(oldIdMacchinaOfValoreParSingMacCollectionNewValoreParSingMac);
                    }
                }
            }
            for (Aggiornamento aggiornamentoCollectionNewAggiornamento : aggiornamentoCollectionNew) {
                if (!aggiornamentoCollectionOld.contains(aggiornamentoCollectionNewAggiornamento)) {
                    Macchina oldIdMacchinaOfAggiornamentoCollectionNewAggiornamento = aggiornamentoCollectionNewAggiornamento.getIdMacchina();
                    aggiornamentoCollectionNewAggiornamento.setIdMacchina(macchina);
                    aggiornamentoCollectionNewAggiornamento = em.merge(aggiornamentoCollectionNewAggiornamento);
                    if (oldIdMacchinaOfAggiornamentoCollectionNewAggiornamento != null && !oldIdMacchinaOfAggiornamentoCollectionNewAggiornamento.equals(macchina)) {
                        oldIdMacchinaOfAggiornamentoCollectionNewAggiornamento.getAggiornamentoCollection().remove(aggiornamentoCollectionNewAggiornamento);
                        oldIdMacchinaOfAggiornamentoCollectionNewAggiornamento = em.merge(oldIdMacchinaOfAggiornamentoCollectionNewAggiornamento);
                    }
                }
            }
            for (AnagrafeMacchina anagrafeMacchinaCollectionNewAnagrafeMacchina : anagrafeMacchinaCollectionNew) {
                if (!anagrafeMacchinaCollectionOld.contains(anagrafeMacchinaCollectionNewAnagrafeMacchina)) {
                    Macchina oldIdMacchinaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina = anagrafeMacchinaCollectionNewAnagrafeMacchina.getIdMacchina();
                    anagrafeMacchinaCollectionNewAnagrafeMacchina.setIdMacchina(macchina);
                    anagrafeMacchinaCollectionNewAnagrafeMacchina = em.merge(anagrafeMacchinaCollectionNewAnagrafeMacchina);
                    if (oldIdMacchinaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina != null && !oldIdMacchinaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina.equals(macchina)) {
                        oldIdMacchinaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina.getAnagrafeMacchinaCollection().remove(anagrafeMacchinaCollectionNewAnagrafeMacchina);
                        oldIdMacchinaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina = em.merge(oldIdMacchinaOfAnagrafeMacchinaCollectionNewAnagrafeMacchina);
                    }
                }
            }
            for (ValoreParComp valoreParCompCollectionNewValoreParComp : valoreParCompCollectionNew) {
                if (!valoreParCompCollectionOld.contains(valoreParCompCollectionNewValoreParComp)) {
                    Macchina oldIdMacchinaOfValoreParCompCollectionNewValoreParComp = valoreParCompCollectionNewValoreParComp.getIdMacchina();
                    valoreParCompCollectionNewValoreParComp.setIdMacchina(macchina);
                    valoreParCompCollectionNewValoreParComp = em.merge(valoreParCompCollectionNewValoreParComp);
                    if (oldIdMacchinaOfValoreParCompCollectionNewValoreParComp != null && !oldIdMacchinaOfValoreParCompCollectionNewValoreParComp.equals(macchina)) {
                        oldIdMacchinaOfValoreParCompCollectionNewValoreParComp.getValoreParCompCollection().remove(valoreParCompCollectionNewValoreParComp);
                        oldIdMacchinaOfValoreParCompCollectionNewValoreParComp = em.merge(oldIdMacchinaOfValoreParCompCollectionNewValoreParComp);
                    }
                }
            }
            em.getTransaction().commit();
        } catch (Exception ex) {
            String msg = ex.getLocalizedMessage();
            if (msg == null || msg.length() == 0) {
                Integer id = macchina.getIdMacchina();
                if (findMacchina(id) == null) {
                    throw new NonexistentEntityException("The macchina with id " + id + " no longer exists.");
                }
            }
            throw ex;
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public void destroy(Integer id) throws IllegalOrphanException, NonexistentEntityException {
        EntityManager em = null;
        try {
            em = getEntityManager();
            em.getTransaction().begin();
            Macchina macchina;
            try {
                macchina = em.getReference(Macchina.class, id);
                macchina.getIdMacchina();
            } catch (EntityNotFoundException enfe) {
                throw new NonexistentEntityException("The macchina with id " + id + " no longer exists.", enfe);
            }
            List<String> illegalOrphanMessages = null;
            Collection<Bolla> bollaCollectionOrphanCheck = macchina.getBollaCollection();
            for (Bolla bollaCollectionOrphanCheckBolla : bollaCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Macchina (" + macchina + ") cannot be destroyed since the Bolla " + bollaCollectionOrphanCheckBolla + " in its bollaCollection field has a non-nullable idMacchina field.");
            }
            Collection<Processo> processoCollectionOrphanCheck = macchina.getProcessoCollection();
            for (Processo processoCollectionOrphanCheckProcesso : processoCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Macchina (" + macchina + ") cannot be destroyed since the Processo " + processoCollectionOrphanCheckProcesso + " in its processoCollection field has a non-nullable idMacchina field.");
            }
            Collection<ValoreParSingMac> valoreParSingMacCollectionOrphanCheck = macchina.getValoreParSingMacCollection();
            for (ValoreParSingMac valoreParSingMacCollectionOrphanCheckValoreParSingMac : valoreParSingMacCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Macchina (" + macchina + ") cannot be destroyed since the ValoreParSingMac " + valoreParSingMacCollectionOrphanCheckValoreParSingMac + " in its valoreParSingMacCollection field has a non-nullable idMacchina field.");
            }
            Collection<Aggiornamento> aggiornamentoCollectionOrphanCheck = macchina.getAggiornamentoCollection();
            for (Aggiornamento aggiornamentoCollectionOrphanCheckAggiornamento : aggiornamentoCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Macchina (" + macchina + ") cannot be destroyed since the Aggiornamento " + aggiornamentoCollectionOrphanCheckAggiornamento + " in its aggiornamentoCollection field has a non-nullable idMacchina field.");
            }
            Collection<AnagrafeMacchina> anagrafeMacchinaCollectionOrphanCheck = macchina.getAnagrafeMacchinaCollection();
            for (AnagrafeMacchina anagrafeMacchinaCollectionOrphanCheckAnagrafeMacchina : anagrafeMacchinaCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Macchina (" + macchina + ") cannot be destroyed since the AnagrafeMacchina " + anagrafeMacchinaCollectionOrphanCheckAnagrafeMacchina + " in its anagrafeMacchinaCollection field has a non-nullable idMacchina field.");
            }
            Collection<ValoreParComp> valoreParCompCollectionOrphanCheck = macchina.getValoreParCompCollection();
            for (ValoreParComp valoreParCompCollectionOrphanCheckValoreParComp : valoreParCompCollectionOrphanCheck) {
                if (illegalOrphanMessages == null) {
                    illegalOrphanMessages = new ArrayList<String>();
                }
                illegalOrphanMessages.add("This Macchina (" + macchina + ") cannot be destroyed since the ValoreParComp " + valoreParCompCollectionOrphanCheckValoreParComp + " in its valoreParCompCollection field has a non-nullable idMacchina field.");
            }
            if (illegalOrphanMessages != null) {
                throw new IllegalOrphanException(illegalOrphanMessages);
            }
            em.remove(macchina);
            em.getTransaction().commit();
        } finally {
            if (em != null) {
                em.close();
            }
        }
    }

    public List<Macchina> findMacchinaEntities() {
        return findMacchinaEntities(true, -1, -1);
    }

    public List<Macchina> findMacchinaEntities(int maxResults, int firstResult) {
        return findMacchinaEntities(false, maxResults, firstResult);
    }

    private List<Macchina> findMacchinaEntities(boolean all, int maxResults, int firstResult) {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select object(o) from Macchina as o");
            if (!all) {
                q.setMaxResults(maxResults);
                q.setFirstResult(firstResult);
            }
            return q.getResultList();
        } finally {
            em.close();
        }
    }

    public Macchina findMacchina(Integer id) {
        EntityManager em = getEntityManager();
        try {
            return em.find(Macchina.class, id);
        } finally {
            em.close();
        }
    }

    public int getMacchinaCount() {
        EntityManager em = getEntityManager();
        try {
            Query q = em.createQuery("select count(o) from Macchina as o");
            return ((Long) q.getSingleResult()).intValue();
        } finally {
            em.close();
        }
    }
      //  //Non in uso
//   public Collection<Macchina> findMacchinaNew(Date dt_ult_agg, Integer id_macchina){
//         
//     EntityManager em = getEntityManager();
//     
//       Query q = em.createNamedQuery("Macchina.findDatiNuovi");
//       q.setParameter ("idMacchina",id_macchina);
//       q.setParameter ("dtAbilitato",dt_ult_agg);
//       Collection<Macchina> macchinaColl = null;
//     
//     try {
//        macchinaColl = (Collection<Macchina>) q.getResultList();
//       } catch (NoResultException nre) {
//         log.info("##### Nessun Risultato in findMacchinaNew" );
//       } catch (Exception e){
//         log.error("##### eccezione inattesa su findMacchinaNew: " + e.toString());
//     }
//     
//     return  macchinaColl;
//        
//  }    

//   //Parametri : data di ultimo aggiornamento, id_macchina da aggiornamre
//   //Restituisce una macchina con i dati aggiornati alla data di ultimo aggiornamento
//   public Macchina findUniqueMacchinaNew(Date dt_ult_agg, Integer id_macchina){
//         
//     EntityManager em = getEntityManager();
//     
//     Query q = em.createNamedQuery("Macchina.findDatiNuovi");
//     q.setParameter ("idMacchina",id_macchina);
//     q.setParameter ("dtAbilitato",dt_ult_agg);
//     Macchina macchina = null;
//     
//     try {
//        macchina = (Macchina) q.getSingleResult();
//       }   catch (NonUniqueResultException nre) {
//          log.error("##### Macchina duplicata in findUniqueMacchinaNew" );
//       } catch (Exception e){
//         log.error("##### eccezione inattesa su findUniqueMacchinaNew: " + e.toString());
//     }
//     
//     return  macchina;
//        
//  }    
  /**
   * Metodo che restituiscel'ultima versione di un dato tipo di aggiornamento di una data macchina 
   * @param Intero che indica l'id della macchina da aggiornare
   * @param Stringa che indica il tipo aggiornamento(IN/OUT) 
   * @return Un oggetto Integer ovvero l'ultima versione dell'aggiornamento
   */
  public Integer findLastUpdateVersion(Integer idMacchina, String tipo) {

    EntityManager em = getEntityManager();
//a.idMacchina = m.idMacchina AND
    Query q = em.createQuery("SELECT MAX(a.versione) FROM Aggiornamento a, Macchina m "
            + "WHERE  a.idMacchina = :idMacchina "
            + "AND a.tipo= :tipo");
   
    Macchina macchina =findMacchina(idMacchina);
    q.setParameter("idMacchina", macchina);
    q.setParameter("tipo", tipo);
    Integer versione = null;
    try {

      versione= (Integer) q.getSingleResult();

    } catch (NoResultException nre) {
      log.error("##### Nessun Risultato in findLastUpdateVersion");
      throw nre;
    } catch (NonUniqueResultException nure) {
      log.error("##### Data ultimo aggiornamento duplicata in findLastUpdateVersion");
      throw nure;
    } catch (Exception e) {
      log.error("##### Eccezione inattesa su findLastUpdateVersion: " + e.toString());
    }

    return versione;

  }


  
  public Collection<Macchina> findMacchinaAll() {
    
    EntityManager em = getEntityManager();
    Query q = em.createNamedQuery("Macchina.findAll");

    try {
     
      q.getResultList();
      
    } catch (NoResultException ex) {
      log.error("##### Nessuna Macchina trovata nella tabella macchina");
      throw ex;
    }

    return q.getResultList();
  }
  
/**
   * Restituisce le macchine abilitate
   * @param abilitato
   * @return 
   */
public Collection<Macchina> findMacchineAbilitate(Boolean abilitato) {
    
    EntityManager em = getEntityManager();
    Query q = em.createNamedQuery("Macchina.findByAbilitato");
   
    q.setParameter("abilitato", abilitato);

    try {
     
      q.getResultList();
      
    } catch (NoResultException ex) {
      log.error("##### Non ci sono macchine abilitate nella tabella macchina");
      throw ex;
    }

    return q.getResultList();
  }


public void merge(Macchina macchina) {
    EntityManager em = null;

    try {
      em = getEntityManager();
      em.getTransaction().begin();

      Integer id = 0;
      id =macchina.getIdMacchina();
      if (findMacchina(id) != null) {
        em.merge(macchina);
      } else {
        em.persist(macchina);
      }
      em.getTransaction().commit();

    } catch (SecurityException ex) {
      log.error(ex.getStackTrace());
    } catch (IllegalStateException ex) {
      log.error(ex.getStackTrace());
    }

  }
  


}

